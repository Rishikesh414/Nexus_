<?php
session_start();

/* =========================================
   DATABASE CONNECTION
========================================= */
require_once("../server/config/db.php");

/* =========================================
   OPTIONAL ADMIN SESSION CHECK
========================================= */
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: ../index.php");
//     exit();
// }


/* =========================================
   VARIABLES
========================================= */
$message = "";
$message_type = "";


/* =========================================
   ADD GALLERY
========================================= */

if (isset($_POST['add_gallery'])) {

    $title = trim($_POST['title'] ?? '');

    if ($title === "") {

        $message = "Please enter gallery title.";
        $message_type = "error";

    } elseif (
        !isset($_FILES['images']) ||
        empty($_FILES['images']['name'][0])
    ) {

        $message = "Please select at least one image.";
        $message_type = "error";

    } else {

        /* Create gallery group */

        $stmt = $conn->prepare(
            "INSERT INTO gallery_groups (title)
             VALUES (?)"
        );

        if (!$stmt) {

            $message =
                "Database error: " . $conn->error;

            $message_type = "error";

        } else {

            $stmt->bind_param("s", $title);

            if ($stmt->execute()) {

                $gallery_id = $stmt->insert_id;

                $stmt->close();


                /* =========================================
                   UPLOAD DIRECTORY
                ========================================= */

                $upload_dir = "../uploads/gallery/";

                if (!is_dir($upload_dir)) {

                    mkdir(
                        $upload_dir,
                        0777,
                        true
                    );
                }


                /* =========================================
                   ALLOWED FILE TYPES
                ========================================= */

                $allowed = [
                    "jpg",
                    "jpeg",
                    "png",
                    "webp"
                ];

                $uploaded_count = 0;


                /* =========================================
                   UPLOAD IMAGES
                ========================================= */

                foreach (
                    $_FILES['images']['name']
                    as $key => $name
                ) {

                    if (
                        $_FILES['images']['error'][$key] != 0
                    ) {
                        continue;
                    }


                    $tmp_name =
                        $_FILES['images']['tmp_name'][$key];


                    $extension = strtolower(
                        pathinfo(
                            $name,
                            PATHINFO_EXTENSION
                        )
                    );


                    if (
                        !in_array(
                            $extension,
                            $allowed
                        )
                    ) {
                        continue;
                    }


                    /* Unique filename */

                    $new_name =
                        time() .
                        "_" .
                        uniqid() .
                        "." .
                        $extension;


                    $destination =
                        $upload_dir .
                        $new_name;


                    if (
                        move_uploaded_file(
                            $tmp_name,
                            $destination
                        )
                    ) {

                        /*
                         * Path stored in database
                         */

                        $db_path =
                            "uploads/gallery/" .
                            $new_name;


                        $image_stmt = $conn->prepare(
                            "INSERT INTO gallery_images
                            (gallery_id, image_path)
                            VALUES (?, ?)"
                        );


                        if ($image_stmt) {

                            $image_stmt->bind_param(
                                "is",
                                $gallery_id,
                                $db_path
                            );


                            if (
                                $image_stmt->execute()
                            ) {

                                $uploaded_count++;
                            }


                            $image_stmt->close();
                        }
                    }
                }


                /* =========================================
                   SUCCESS / FAILURE
                ========================================= */

                if ($uploaded_count > 0) {

                    $message =
                        "Gallery added successfully! " .
                        $uploaded_count .
                        " image(s) uploaded.";

                    $message_type = "success";

                } else {

                    /*
                     * Remove empty gallery
                     */

                    $delete_stmt = $conn->prepare(
                        "DELETE FROM gallery_groups
                         WHERE id = ?"
                    );


                    if ($delete_stmt) {

                        $delete_stmt->bind_param(
                            "i",
                            $gallery_id
                        );

                        $delete_stmt->execute();

                        $delete_stmt->close();
                    }


                    $message =
                        "No valid images were uploaded.";

                    $message_type = "error";
                }

            } else {

                $message =
                    "Failed to create gallery: " .
                    $stmt->error;

                $message_type = "error";

                $stmt->close();
            }
        }
    }
}


/* =========================================
   DELETE GALLERY
========================================= */

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);


    /* Get image paths */

    $stmt = $conn->prepare(
        "SELECT image_path
         FROM gallery_images
         WHERE gallery_id = ?"
    );


    if ($stmt) {

        $stmt->bind_param(
            "i",
            $id
        );

        $stmt->execute();

        $result =
            $stmt->get_result();


        while (
            $row =
            $result->fetch_assoc()
        ) {

            $file =
                "../" .
                $row['image_path'];


            if (
                file_exists($file)
            ) {

                unlink($file);
            }
        }


        $stmt->close();
    }


    /* Delete gallery */

    $stmt = $conn->prepare(
        "DELETE FROM gallery_groups
         WHERE id = ?"
    );


    if ($stmt) {

        $stmt->bind_param(
            "i",
            $id
        );

        $stmt->execute();

        $stmt->close();
    }


    header(
        "Location: gallery.php"
    );

    exit();
}


/* =========================================
   GET GALLERIES
========================================= */

$galleries = false;


$query = "

    SELECT

        g.id,
        g.title,
        g.created_at,

        COUNT(i.id)
        AS image_count,

        MIN(i.image_path)
        AS cover_image

    FROM gallery_groups g

    LEFT JOIN gallery_images i

        ON g.id = i.gallery_id

    GROUP BY

        g.id,
        g.title,
        g.created_at

    ORDER BY

        g.id DESC

";


$galleries =
    $conn->query($query);


if (!$galleries) {

    $message =
        "Gallery loading error: " .
        $conn->error;

    $message_type = "error";
}

?>


<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Gallery Management - NEXUS
    </title>


    <!-- Tailwind -->

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    <style>

        /* =========================================
           GLOBAL
        ========================================= */

        * {
            box-sizing: border-box;
        }


        body {

            background:

                radial-gradient(
                    circle at 85% 0%,
                    rgba(139, 92, 246, 0.15),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 10% 85%,
                    rgba(59, 130, 246, 0.08),
                    transparent 30%
                ),

                #f7f5ff;

            color: #29213d;

        }


        /* =========================================
           SIDEBAR
        ========================================= */

        aside {

            background:
                rgba(255, 255, 255, 0.94)
                !important;

            border-right:
                1px solid
                rgba(124, 58, 237, 0.12)
                !important;

            box-shadow:
                5px 0 25px
                rgba(88, 28, 135, 0.06);

        }


        /* NEXUS LOGO */

        aside h1 {

            background:

                linear-gradient(
                    90deg,
                    #2563eb,
                    #7c3aed,
                    #a21caf
                );

            -webkit-background-clip: text;

            background-clip: text;

            color: transparent;

        }


        aside p {

            color:
                #8b8296
                !important;

        }


        /* SIDEBAR LINKS */

        aside nav a {

            color:
                #5b526b
                !important;

            transition:
                all 0.25s ease;

        }


        aside nav a:hover {

            background:
                rgba(
                    124,
                    58,
                    237,
                    0.08
                )
                !important;

            color:
                #6d28d9
                !important;

            transform:
                translateX(3px);

        }


        /* ACTIVE LINK */

        aside nav a.bg-purple-600\/30 {

            background:

                linear-gradient(
                    135deg,
                    rgba(
                        124,
                        58,
                        237,
                        0.14
                    ),
                    rgba(
                        168,
                        85,
                        247,
                        0.07
                    )
                )
                !important;

            color:
                #6d28d9
                !important;

            border:
                1px solid
                rgba(
                    124,
                    58,
                    237,
                    0.18
                )
                !important;

        }


        /* LOGOUT */

        aside .absolute a {

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.06
                )
                !important;

            color:
                #dc2626
                !important;

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    0.08
                );

        }


        aside .absolute a:hover {

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.11
                )
                !important;

        }


        /* =========================================
           MAIN
        ========================================= */

        main {

            background:
                transparent;

        }


        /* PAGE TITLE */

        main h2 {

            background:

                linear-gradient(
                    90deg,
                    #2563eb,
                    #7c3aed,
                    #9333ea
                );

            -webkit-background-clip: text;

            background-clip: text;

            color: transparent;

        }


        /* =========================================
           GLASS CARDS
        ========================================= */

        .glass {

            background:
                rgba(
                    255,
                    255,
                    255,
                    0.90
                )
                !important;

            backdrop-filter:
                blur(15px);

            border:
                1px solid
                rgba(
                    124,
                    58,
                    237,
                    0.10
                )
                !important;

            box-shadow:

                0 10px 35px
                rgba(
                    76,
                    29,
                    149,
                    0.07
                );

        }


        .purple-glow {

            box-shadow:

                0 12px 40px
                rgba(
                    124,
                    58,
                    237,
                    0.10
                );

        }


        /* =========================================
           HEADINGS
        ========================================= */

        main h3 {

            color:
                #30263f;

        }


        main p {

            color:
                #71697f;

        }


        label {

            color:
                #4b4358
                !important;

        }


        /* =========================================
           INPUTS
        ========================================= */

        input[type="text"],
        input[type="file"] {

            background:
                #faf9ff
                !important;

            color:
                #30263f
                !important;

            border:
                1px solid
                #e5def5
                !important;

            transition:
                all 0.25s ease;

        }


        input[type="text"]:focus,
        input[type="file"]:focus {

            border-color:
                #8b5cf6
                !important;

            box-shadow:

                0 0 0 3px
                rgba(
                    139,
                    92,
                    246,
                    0.10
                );

            background:
                #ffffff
                !important;

        }


        input::placeholder {

            color:
                #aaa1b5
                !important;

        }


        input[type="file"] {

            color:
                #655d70
                !important;

        }


        /* =========================================
           ADD BUTTON
        ========================================= */

        button[type="submit"] {

            background:

                linear-gradient(
                    135deg,
                    #6366f1,
                    #7c3aed,
                    #9333ea
                )
                !important;

            box-shadow:

                0 8px 20px
                rgba(
                    124,
                    58,
                    237,
                    0.18
                );

            transition:
                all 0.25s ease;

        }


        button[type="submit"]:hover {

            transform:
                translateY(-2px);

            box-shadow:

                0 12px 25px
                rgba(
                    124,
                    58,
                    237,
                    0.25
                );

        }


        /* =========================================
           SUCCESS MESSAGE
        ========================================= */

        .message-success {

            background:
                rgba(
                    34,
                    197,
                    94,
                    0.08
                );

            border:
                1px solid
                rgba(
                    34,
                    197,
                    94,
                    0.18
                );

            color:
                #15803d;

        }


        /* =========================================
           ERROR MESSAGE
        ========================================= */

        .message-error {

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.07
                );

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    0.16
                );

            color:
                #dc2626;

        }


        /* =========================================
           GALLERY CARD
        ========================================= */

        .gallery-card {

            background:
                rgba(
                    255,
                    255,
                    255,
                    0.96
                )
                !important;

            border:
                1px solid
                #ece7f7
                !important;

            box-shadow:

                0 8px 25px
                rgba(
                    76,
                    29,
                    149,
                    0.07
                );

            transition:
                all 0.3s ease;

        }


        .gallery-card:hover {

            transform:
                translateY(-6px);

            box-shadow:

                0 18px 40px
                rgba(
                    76,
                    29,
                    149,
                    0.13
                );

        }


        .gallery-card img {

            transition:
                transform 0.4s ease;

        }


        .gallery-card:hover img {

            transform:
                scale(1.05);

        }


        .gallery-card h4 {

            color:
                #30263f
                !important;

        }


        .gallery-card p {

            color:
                #81788f
                !important;

        }


        /* =========================================
           DELETE BUTTON
        ========================================= */

        .gallery-card a {

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.06
                )
                !important;

            color:
                #dc2626
                !important;

            border:
                1px solid
                rgba(
                    239,
                    68,
                    68,
                    0.08
                );

        }


        .gallery-card a:hover {

            background:
                rgba(
                    239,
                    68,
                    68,
                    0.11
                )
                !important;

        }


        /* =========================================
           NO GALLERY
        ========================================= */

        .no-gallery {

            color:
                #91889e;

        }


        /* =========================================
           SCROLLBAR
        ========================================= */

        ::-webkit-scrollbar {

            width:
                8px;

        }


        ::-webkit-scrollbar-track {

            background:
                #f1eff8;

        }


        ::-webkit-scrollbar-thumb {

            background:

                linear-gradient(
                    #8b5cf6,
                    #6366f1
                );

            border-radius:
                10px;

        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 768px) {

            aside {

                width:
                    220px
                    !important;

            }

            main {

                margin-left:
                    220px
                    !important;

                padding:
                    25px
                    !important;

            }

        }

    </style>

</head>


<body>


<!-- =========================================
     SIDEBAR
========================================= -->

<aside
    class="
        fixed
        left-0
        top-0
        h-full
        w-64
        p-6
        z-50
    "
>


    <!-- LOGO -->

    <div class="mb-10">

        <h1
            class="
                text-3xl
                font-bold
            "
        >

            NEXUS

        </h1>


        <p
            class="
                text-sm
                mt-1
            "
        >

            ADMIN PANEL

        </p>

    </div>


    <!-- NAVIGATION -->

    <nav class="space-y-3">


        <a
            href="dashboard.php"
            class="
                block
                px-4
                py-3
                rounded-xl
            "
        >

            🏠 Dashboard

        </a>


        <a
            href="events.php"
            class="
                block
                px-4
                py-3
                rounded-xl
            "
        >

            📅 Events

        </a>


        <a
            href="achievements.php"
            class="
                block
                px-4
                py-3
                rounded-xl
            "
        >

            🏆 Achievements

        </a>


        <a
            href="office_bearers.php"
            class="
                block
                px-4
                py-3
                rounded-xl
            "
        >

            👥 Office Bearers

        </a>


        <a
            href="gallery.php"
            class="
                block
                px-4
                py-3
                rounded-xl
                bg-purple-600/30
            "
        >

            🖼️ Gallery

        </a>


    </nav>


    <!-- LOGOUT -->

    <div
        class="
            absolute
            bottom-6
            left-6
            right-6
        "
    >

        <a
            href="logout.php"
            class="
                block
                text-center
                px-4
                py-3
                rounded-xl
            "
        >

            <i
                class="
                    fa-solid
                    fa-right-from-bracket
                "
            ></i>

            Logout

        </a>

    </div>


</aside>


<!-- =========================================
     MAIN CONTENT
========================================= -->

<main
    class="
        ml-64
        p-10
    "
>


    <!-- PAGE HEADER -->

    <div class="mb-10">


        <h2
            class="
                text-4xl
                font-bold
            "
        >

            Gallery Management

        </h2>


        <p
            class="
                mt-2
            "
        >

            Add and manage department gallery collections.

        </p>


    </div>


    <!-- =========================================
         MESSAGE
    ========================================= -->

    <?php if ($message !== ""): ?>

        <div
            class="
                mb-8
                px-5
                py-4
                rounded-xl

                <?php

                if (
                    $message_type === "success"
                ) {

                    echo "message-success";

                } else {

                    echo "message-error";

                }

                ?>
            "
        >

            <?php

            echo htmlspecialchars(
                $message
            );

            ?>

        </div>

    <?php endif; ?>


    <!-- =========================================
         ADD NEW GALLERY
    ========================================= -->

    <div
        class="
            glass
            purple-glow
            rounded-2xl
            p-8
            mb-12
        "
    >


        <!-- TITLE -->

        <div
            class="
                flex
                items-center
                gap-3
                mb-7
            "
        >

            <div
                class="
                    w-12
                    h-12
                    rounded-xl
                    bg-purple-100
                    flex
                    items-center
                    justify-center
                    text-purple-600
                    text-xl
                "
            >

                🖼️

            </div>


            <div>

                <h3
                    class="
                        text-2xl
                        font-semibold
                    "
                >

                    Add New Gallery

                </h3>


                <p
                    class="
                        text-sm
                    "
                >

                    Create a gallery collection
                    and upload images.

                </p>

            </div>

        </div>


        <!-- FORM -->

        <form
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >


            <!-- GALLERY TITLE -->

            <div>

                <label
                    class="
                        block
                        mb-2
                        font-medium
                    "
                >

                    Gallery Title

                </label>


                <input
                    type="text"
                    name="title"
                    required
                    placeholder="Example: 2026 Symposium"
                    class="
                        w-full
                        px-4
                        py-3
                        rounded-xl
                        outline-none
                    "
                >

            </div>


            <!-- IMAGES -->

            <div>

                <label
                    class="
                        block
                        mb-2
                        font-medium
                    "
                >

                    Select Images

                </label>


                <input
                    type="file"
                    name="images[]"
                    multiple
                    required
                    accept=".jpg,.jpeg,.png,.webp"
                    class="
                        w-full
                        px-4
                        py-3
                        rounded-xl
                        outline-none
                    "
                >


                <p
                    class="
                        text-xs
                        mt-2
                    "
                >

                    Supported formats:
                    JPG, JPEG, PNG, WEBP

                </p>

            </div>


            <!-- BUTTON -->

            <button
                type="submit"
                name="add_gallery"
                class="
                    px-7
                    py-3
                    rounded-xl
                    text-white
                    font-semibold
                "
            >

                <i
                    class="
                        fa-solid
                        fa-plus
                        mr-2
                    "
                ></i>

                Add Gallery

            </button>


        </form>

    </div>


    <!-- =========================================
         GALLERY COLLECTIONS
    ========================================= -->

    <div>


        <h3
            class="
                text-2xl
                font-semibold
                mb-6
            "
        >

            Gallery Collections

        </h3>


        <?php if (
            $galleries &&
            $galleries->num_rows > 0
        ): ?>


            <div
                class="
                    grid
                    grid-cols-1
                    md:grid-cols-2
                    xl:grid-cols-3
                    gap-6
                "
            >


                <?php

                while (
                    $gallery =
                    $galleries->fetch_assoc()
                ):

                ?>


                    <!-- GALLERY CARD -->

                    <div
                        class="
                            gallery-card
                            rounded-2xl
                            overflow-hidden
                        "
                    >


                        <!-- IMAGE -->

                        <div
                            class="
                                h-56
                                bg-purple-50
                                overflow-hidden
                            "
                        >


                            <?php if (
                                !empty(
                                    $gallery[
                                        'cover_image'
                                    ]
                                )
                            ): ?>


                                <img
                                    src="../<?php

                                    echo htmlspecialchars(
                                        $gallery[
                                            'cover_image'
                                        ]
                                    );

                                    ?>"
                                    alt="<?php

                                    echo htmlspecialchars(
                                        $gallery[
                                            'title'
                                        ]
                                    );

                                    ?>"
                                    class="
                                        w-full
                                        h-full
                                        object-cover
                                    "
                                >


                            <?php else: ?>


                                <div
                                    class="
                                        w-full
                                        h-full
                                        flex
                                        items-center
                                        justify-center
                                        no-gallery
                                    "
                                >

                                    <div
                                        class="
                                            text-center
                                        "
                                    >

                                        <i
                                            class="
                                                fa-regular
                                                fa-image
                                                text-4xl
                                                mb-2
                                            "
                                        ></i>


                                        <p>

                                            No image

                                        </p>

                                    </div>

                                </div>


                            <?php endif; ?>


                        </div>


                        <!-- DETAILS -->

                        <div
                            class="
                                p-5
                            "
                        >


                            <h4
                                class="
                                    text-lg
                                    font-semibold
                                    mb-2
                                "
                            >

                                <?php

                                echo htmlspecialchars(
                                    $gallery[
                                        'title'
                                    ]
                                );

                                ?>

                            </h4>


                            <p
                                class="
                                    text-sm
                                    mb-5
                                "
                            >

                                <?php

                                echo (int)
                                    $gallery[
                                        'image_count'
                                    ];

                                ?>

                                image(s)

                            </p>


                            <!-- DELETE -->

                            <a
                                href="gallery.php?delete=<?php

                                echo (int)
                                    $gallery['id'];

                                ?>"
                                onclick="
                                    return confirm(
                                        'Are you sure you want to delete this gallery?'
                                    );
                                "
                                class="
                                    inline-flex
                                    items-center
                                    gap-2
                                    px-4
                                    py-2
                                    rounded-lg
                                "
                            >

                                <i
                                    class="
                                        fa-solid
                                        fa-trash
                                    "
                                ></i>

                                Delete

                            </a>


                        </div>


                    </div>


                <?php endwhile; ?>


            </div>


        <?php else: ?>


            <!-- NO GALLERIES -->

            <div
                class="
                    glass
                    rounded-2xl
                    p-12
                    text-center
                "
            >

                <i
                    class="
                        fa-regular
                        fa-images
                        text-5xl
                        text-purple-200
                        mb-5
                    "
                ></i>


                <p
                    class="
                        text-gray-500
                    "
                >

                    No gallery collections found.

                </p>


            </div>


        <?php endif; ?>


    </div>


</main>


</body>

</html>