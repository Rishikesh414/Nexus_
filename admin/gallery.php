<?php
session_start();

require_once("../server/config/db.php");

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

        $stmt = $conn->prepare(
            "INSERT INTO gallery_groups (title) VALUES (?)"
        );

        if (!$stmt) {

            $message = "Database error: " . $conn->error;
            $message_type = "error";

        } else {

            $stmt->bind_param("s", $title);

            if ($stmt->execute()) {

                $gallery_id = $stmt->insert_id;
                $stmt->close();

                /* Upload folder */

                $upload_dir = "../uploads/gallery/";

                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $allowed = [
                    "jpg",
                    "jpeg",
                    "png",
                    "webp"
                ];

                $uploaded_count = 0;

                /* Upload images */

                foreach ($_FILES['images']['name'] as $key => $name) {

                    if ($_FILES['images']['error'][$key] != 0) {
                        continue;
                    }

                    $tmp_name = $_FILES['images']['tmp_name'][$key];

                    $extension = strtolower(
                        pathinfo($name, PATHINFO_EXTENSION)
                    );

                    if (!in_array($extension, $allowed)) {
                        continue;
                    }

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

                            if ($image_stmt->execute()) {
                                $uploaded_count++;
                            }

                            $image_stmt->close();
                        }
                    }
                }

                if ($uploaded_count > 0) {

                    $message =
                        "Gallery added successfully! " .
                        $uploaded_count .
                        " image(s) uploaded.";

                    $message_type = "success";

                } else {

                    $delete_stmt = $conn->prepare(
                        "DELETE FROM gallery_groups WHERE id = ?"
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

    /* Get images */

    $stmt = $conn->prepare(
        "SELECT image_path
         FROM gallery_images
         WHERE gallery_id = ?"
    );

    if ($stmt) {

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {

            $file = "../" . $row['image_path'];

            if (file_exists($file)) {
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

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: gallery.php");
    exit();
}


/* =========================================
   GET GALLERIES
========================================= */

$query = "
    SELECT
        g.id,
        g.title,
        g.created_at,
        COUNT(i.id) AS image_count,
        MIN(i.image_path) AS cover_image
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

$galleries = $conn->query($query);

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

<title>Gallery Management - NEXUS</title>

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

html {
    scroll-behavior: smooth;
}

body {

    margin: 0;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    background:
        linear-gradient(
            135deg,
            #faf7ff 0%,
            #f3edff 50%,
            #f8f4ff 100%
        );

    color: #3f3650;
}


/* =========================================
   SIDEBAR
========================================= */

.sidebar {

    position: fixed;

    left: 0;
    top: 0;

    width: 250px;
    height: 100vh;

    background: #ffffff;

    border-right:
        1px solid #eadff5;

    padding: 28px 18px;

    display: flex;
    flex-direction: column;

    z-index: 100;

    box-shadow:
        5px 0 25px
        rgba(104, 67, 145, 0.06);
}


/* LOGO */

.logo {

    padding:
        0 12px;

    margin-bottom:
        40px;
}

.logo h1 {

    margin: 0;

    font-size: 32px;

    font-weight: 800;

    background:
        linear-gradient(
            90deg,
            #6d28d9,
            #9333ea
        );

    -webkit-background-clip: text;
    background-clip: text;

    color: transparent;
}

.logo p {

    margin:
        4px 0 0;

    color: #958ba2;

    font-size: 13px;

    letter-spacing: .5px;
}


/* NAV */

.nav {

    display: flex;

    flex-direction: column;

    gap: 7px;
}

.nav a {

    display: flex;

    align-items: center;

    gap: 13px;

    padding:
        13px 15px;

    border-radius:
        12px;

    text-decoration: none;

    color: #62586e;

    font-size: 15px;

    transition:
        all .2s ease;
}

.nav a i {

    width: 20px;

    text-align: center;

    color: #7652a8;
}

.nav a:hover {

    background:
        #f5effc;

    color:
        #6d28d9;

    transform:
        translateX(2px);
}

.nav a.active {

    background:
        linear-gradient(
            135deg,
            #f1e5ff,
            #f8f1ff
        );

    color:
        #6d28d9;

    border:
        1px solid #dfc8fa;

    font-weight: 600;
}

.nav a.active i {

    color:
        #7c3aed;
}


/* LOGOUT */

.logout {

    margin-top:
        auto;
}

.logout a {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 10px;

    padding: 12px;

    border-radius: 11px;

    text-decoration: none;

    color: #dc3f4d;

    background: #fff5f5;

    border:
        1px solid #f8dede;

    font-weight: 600;

    transition: .2s;
}

.logout a:hover {

    background:
        #ffeded;
}


/* =========================================
   MAIN
========================================= */

.main {

    margin-left:
        250px;

    min-height:
        100vh;

    padding:
        35px 45px 50px;
}


/* =========================================
   PAGE HEADER
========================================= */

.page-header {

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #faf6ff
        );

    border:
        1px solid #eadff5;

    border-radius:
        18px;

    padding:
        24px 28px;

    margin-bottom:
        25px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow:
        0 8px 28px
        rgba(104, 67, 145, .07);
}

.page-title {

    display: flex;

    align-items: center;

    gap: 15px;
}

.page-icon {

    width: 52px;
    height: 52px;

    border-radius:
        14px;

    background:
        #f0e4ff;

    color:
        #7c3aed;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;
}

.page-header h2 {

    margin: 0;

    font-size: 30px;

    color:
        #6326a3;
}

.page-header p {

    margin:
        5px 0 0;

    color:
        #81778e;

    font-size:
        14px;
}


/* =========================================
   ADD BUTTON
========================================= */

.header-add-btn {

    text-decoration: none;

    background:
        linear-gradient(
            135deg,
            #8b5cf6,
            #9333ea
        );

    color:
        white;

    padding:
        12px 18px;

    border-radius:
        10px;

    font-weight:
        600;

    box-shadow:
        0 7px 18px
        rgba(124,58,237,.18);
}


/* =========================================
   MESSAGE
========================================= */

.message {

    padding:
        14px 18px;

    border-radius:
        11px;

    margin-bottom:
        22px;

    font-size:
        14px;

    font-weight:
        600;
}

.message.success {

    background:
        #ecfdf3;

    border:
        1px solid #c8efd7;

    color:
        #16803c;
}

.message.error {

    background:
        #fff1f1;

    border:
        1px solid #f4cccc;

    color:
        #d32f2f;
}


/* =========================================
   CARD
========================================= */

.card {

    background:
        rgba(255,255,255,.96);

    border:
        1px solid #eadff5;

    border-radius:
        18px;

    box-shadow:
        0 8px 28px
        rgba(104,67,145,.07);
}


/* =========================================
   ADD GALLERY
========================================= */

.add-card {

    padding:
        27px;

    margin-bottom:
        30px;
}

.card-heading {

    display: flex;

    align-items: center;

    gap: 13px;

    margin-bottom:
        25px;
}

.card-heading-icon {

    width: 46px;
    height: 46px;

    border-radius:
        13px;

    background:
        #f0e5ff;

    color:
        #7c3aed;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size:
        19px;
}

.card-heading h3 {

    margin: 0;

    color:
        #49365d;

    font-size:
        21px;
}

.card-heading p {

    margin:
        4px 0 0;

    color:
        #8b8197;

    font-size:
        13px;
}


/* FORM */

.form-grid {

    display:
        grid;

    grid-template-columns:
        1fr 1fr;

    gap:
        20px;
}

.form-group {

    display:
        flex;

    flex-direction:
        column;
}

.form-group label {

    margin-bottom:
        8px;

    font-size:
        14px;

    font-weight:
        600;

    color:
        #4e4559;
}

.form-group input {

    width:
        100%;

    height:
        48px;

    border:
        1px solid #dfd4eb;

    border-radius:
        10px;

    background:
        #fbfaff;

    padding:
        0 14px;

    font-size:
        14px;

    color:
        #40374c;

    outline:
        none;

    transition:
        .2s;
}

.form-group input:focus {

    border-color:
        #a678dc;

    box-shadow:
        0 0 0 3px
        rgba(139,92,246,.09);

    background:
        white;
}

.file-help {

    margin-top:
        7px;

    color:
        #91869d;

    font-size:
        12px;
}


/* BUTTON */

.add-btn {

    margin-top:
        22px;

    border:
        none;

    background:
        linear-gradient(
            135deg,
            #7c5ce6,
            #9333ea
        );

    color:
        white;

    padding:
        12px 22px;

    border-radius:
        10px;

    font-size:
        14px;

    font-weight:
        600;

    cursor:
        pointer;

    box-shadow:
        0 7px 18px
        rgba(124,58,237,.18);

    transition:
        .2s;
}

.add-btn:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 10px 24px
        rgba(124,58,237,.25);
}


/* =========================================
   COLLECTION SECTION
========================================= */

.collection-card {

    padding:
        27px;
}

.collection-header {

    display:
        flex;

    align-items:
        center;

    gap:
        13px;

    margin-bottom:
        22px;
}

.collection-header h3 {

    margin:
        0;

    color:
        #49365d;

    font-size:
        21px;
}

.collection-header p {

    margin:
        4px 0 0;

    color:
        #8b8197;

    font-size:
        13px;
}


/* =========================================
   GALLERY GRID
========================================= */

.gallery-grid {

    display:
        grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap:
        20px;
}


/* =========================================
   GALLERY CARD
========================================= */

.gallery-item {

    border:
        1px solid #ebe3f3;

    border-radius:
        14px;

    overflow:
        hidden;

    background:
        white;

    transition:
        .25s ease;
}

.gallery-item:hover {

    transform:
        translateY(-4px);

    box-shadow:
        0 12px 28px
        rgba(91,48,126,.11);
}


/* IMAGE */

.gallery-image {

    width:
        100%;

    height:
        180px;

    background:
        #f4effb;

    overflow:
        hidden;
}

.gallery-image img {

    width:
        100%;

    height:
        100%;

    object-fit:
        cover;

    display:
        block;

    transition:
        .3s;
}

.gallery-item:hover
.gallery-image img {

    transform:
        scale(1.04);
}


/* DETAILS */

.gallery-details {

    padding:
        16px;
}

.gallery-title {

    margin:
        0 0 7px;

    color:
        #4b395b;

    font-size:
        17px;

    font-weight:
        700;

    white-space:
        nowrap;

    overflow:
        hidden;

    text-overflow:
        ellipsis;
}

.gallery-meta {

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        10px;
}

.image-count {

    color:
        #8b8197;

    font-size:
        13px;
}

.image-count i {

    color:
        #8b5cf6;

    margin-right:
        5px;
}


/* DELETE */

.delete-btn {

    display:
        inline-flex;

    align-items:
        center;

    gap:
        6px;

    text-decoration:
        none;

    padding:
        7px 10px;

    border-radius:
        8px;

    background:
        #fff2f2;

    color:
        #dc3f4d;

    border:
        1px solid #f4d5d5;

    font-size:
        12px;

    font-weight:
        600;

    transition:
        .2s;
}

.delete-btn:hover {

    background:
        #dc3f4d;

    color:
        white;

    border-color:
        #dc3f4d;
}


/* =========================================
   EMPTY
========================================= */

.empty {

    text-align:
        center;

    padding:
        60px 20px;

    border:
        1px dashed #d9cbe7;

    border-radius:
        14px;

    background:
        #fcfaff;

    color:
        #958aa2;
}

.empty i {

    font-size:
        45px;

    color:
        #c8b2df;

    margin-bottom:
        12px;
}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1100px) {

    .gallery-grid {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }
}


@media (max-width: 850px) {

    .sidebar {

        width:
            220px;
    }

    .main {

        margin-left:
            220px;

        padding:
            25px;
    }

    .form-grid {

        grid-template-columns:
            1fr;
    }

    .page-header {

        align-items:
            flex-start;

        flex-direction:
            column;
    }
}


@media (max-width: 650px) {

    .sidebar {

        position:
            relative;

        width:
            100%;

        height:
            auto;

        min-height:
            auto;
    }

    .logo {

        margin-bottom:
            20px;
    }

    .nav {

        display:
            grid;

        grid-template-columns:
            1fr 1fr;
    }

    .logout {

        margin-top:
            25px;
    }

    .main {

        margin-left:
            0;

        padding:
            18px;
    }

    .gallery-grid {

        grid-template-columns:
            1fr;
    }

    .page-header {

        padding:
            20px;
    }

    .page-header h2 {

        font-size:
            24px;
    }

    .add-card,
    .collection-card {

        padding:
            20px;
    }
}

</style>

</head>


<body>


<!-- =========================================
     SIDEBAR
========================================= -->

<aside class="sidebar">

    <div class="logo">

        <h1>NEXUS</h1>

        <p>ADMIN PANEL</p>

    </div>


    <nav class="nav">

        <a href="dashboard.php">

            <i class="fa-solid fa-house"></i>

            <span>Dashboard</span>

        </a>


        <a href="events.php">

            <i class="fa-solid fa-calendar-days"></i>

            <span>Events</span>

        </a>


        <a href="achievements.php">

            <i class="fa-solid fa-trophy"></i>

            <span>Achievements</span>

        </a>


        <a href="office_bearers.php">

            <i class="fa-solid fa-users"></i>

            <span>Office Bearers</span>

        </a>


        <a
            href="gallery.php"
            class="active"
        >

            <i class="fa-regular fa-image"></i>

            <span>Gallery</span>

        </a>

    </nav>


    <div class="logout">

        <a href="logout.php">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </a>

    </div>

</aside>


<!-- =========================================
     MAIN
========================================= -->

<main class="main">


    <!-- PAGE HEADER -->

    <section class="page-header">

        <div class="page-title">

            <div class="page-icon">

                <i class="fa-regular fa-images"></i>

            </div>

            <div>

                <h2>Gallery Management</h2>

                <p>
                    Upload and manage images for the gallery collection.
                </p>

            </div>

        </div>


        <a
            href="#add-gallery"
            class="header-add-btn"
        >

            <i class="fa-solid fa-plus"></i>

            &nbsp; Add Gallery

        </a>

    </section>


    <!-- MESSAGE -->

    <?php if ($message !== ""): ?>

        <div
            class="message
            <?= $message_type === 'success'
                ? 'success'
                : 'error'
            ?>"
        >

            <i
                class="fa-solid
                <?= $message_type === 'success'
                    ? 'fa-circle-check'
                    : 'fa-circle-exclamation'
                ?>"
            ></i>

            &nbsp;

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>


    <!-- =========================================
         ADD GALLERY
    ========================================= -->

    <section
        id="add-gallery"
        class="card add-card"
    >

        <div class="card-heading">

            <div class="card-heading-icon">

                <i class="fa-solid fa-cloud-arrow-up"></i>

            </div>

            <div>

                <h3>Add New Gallery</h3>

                <p>
                    Upload images to create a new gallery collection.
                </p>

            </div>

        </div>


        <form
            method="POST"
            enctype="multipart/form-data"
        >

            <div class="form-grid">


                <!-- TITLE -->

                <div class="form-group">

                    <label>
                        Gallery Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="Example: 2026 Symposium"
                    >

                </div>


                <!-- IMAGES -->

                <div class="form-group">

                    <label>
                        Select Images
                    </label>

                    <input
                        type="file"
                        name="images[]"
                        multiple
                        required
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <span class="file-help">

                        Supported formats:
                        JPG, JPEG, PNG, WEBP

                    </span>

                </div>

            </div>


            <button
                type="submit"
                name="add_gallery"
                class="add-btn"
            >

                <i class="fa-solid fa-upload"></i>

                &nbsp; Upload Gallery

            </button>

        </form>

    </section>


    <!-- =========================================
         COLLECTIONS
    ========================================= -->

    <section class="card collection-card">

        <div class="collection-header">

            <div class="card-heading-icon">

                <i class="fa-regular fa-images"></i>

            </div>

            <div>

                <h3>Gallery Collections</h3>

                <p>
                    View and manage your uploaded gallery images.
                </p>

            </div>

        </div>


        <?php if (
            $galleries &&
            $galleries->num_rows > 0
        ): ?>


            <div class="gallery-grid">


                <?php while (
                    $gallery =
                    $galleries->fetch_assoc()
                ): ?>


                    <article class="gallery-item">


                        <!-- IMAGE -->

                        <div class="gallery-image">

                            <?php if (
                                !empty(
                                    $gallery['cover_image']
                                )
                            ): ?>

                                <img
                                    src="../<?= htmlspecialchars(
                                        $gallery['cover_image']
                                    ) ?>"
                                    alt="<?= htmlspecialchars(
                                        $gallery['title']
                                    ) ?>"
                                >

                            <?php else: ?>

                                <div
                                    style="
                                        width:100%;
                                        height:100%;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        color:#b8a8c8;
                                    "
                                >

                                    <i
                                        class="fa-regular fa-image"
                                        style="font-size:42px;"
                                    ></i>

                                </div>

                            <?php endif; ?>

                        </div>


                        <!-- DETAILS -->

                        <div class="gallery-details">

                            <h4 class="gallery-title">

                                <?= htmlspecialchars(
                                    $gallery['title']
                                ) ?>

                            </h4>


                            <div class="gallery-meta">

                                <span class="image-count">

                                    <i
                                        class="fa-regular fa-images"
                                    ></i>

                                    <?= (int)
                                        $gallery['image_count']
                                    ?>

                                    image(s)

                                </span>


                                <a
                                    href="gallery.php?delete=<?= (int)$gallery['id'] ?>"
                                    class="delete-btn"
                                    onclick="
                                        return confirm(
                                            'Are you sure you want to delete this gallery?'
                                        );
                                    "
                                >

                                    <i
                                        class="fa-solid fa-trash"
                                    ></i>

                                    Delete

                                </a>

                            </div>

                        </div>

                    </article>


                <?php endwhile; ?>


            </div>


        <?php else: ?>


            <div class="empty">

                <i class="fa-regular fa-images"></i>

                <div>
                    No gallery collections found.
                </div>

            </div>


        <?php endif; ?>

    </section>


</main>


</body>

</html>