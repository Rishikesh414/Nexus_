<?php

/* =========================================================
   DATABASE CONNECTION
   ========================================================= */

require_once("../server/config/db.php");


/* =========================================================
   FETCH GALLERY FROM DATABASE
   ========================================================= */

$sql = "
    SELECT
        g.id AS gallery_id,
        g.title,
        i.id AS image_id,
        i.image_path
    FROM gallery_groups g
    LEFT JOIN gallery_images i
        ON g.id = i.gallery_id
    ORDER BY g.id ASC, i.id ASC
";

$result = mysqli_query($conn, $sql);

$gallery = [];


if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $gallery_id = $row['gallery_id'];


        if (!isset($gallery[$gallery_id])) {

            $gallery[$gallery_id] = [

                "title" => $row['title'],

                "images" => []

            ];

        }


        if (!empty($row['image_path'])) {

            $gallery[$gallery_id]["images"][] =
                $row['image_path'];

        }

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>NEXUS Gallery</title>


    <!-- =====================================================
         FONT AWESOME
         ===================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    <!-- =====================================================
         SWIPER CSS
         ===================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    >


    <!-- =====================================================
         TAILWIND CSS
         ===================================================== -->

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- =====================================================
         ORIGINAL GALLERY CSS
         ===================================================== -->

    <style>

        /* Floating animation for nodes */

        @keyframes float {

            0%,100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

        }


        .animate-float {

            animation:
                float 4s ease-in-out infinite;

        }


        /* Image hover effect */

        .gallery-card img {

            transition:
                transform 0.5s ease,
                filter 0.5s ease;

        }


        .gallery-card:hover img {

            transform:
                scale(1.1)
                rotate(1deg);

            filter:
                brightness(1.1);

        }

    </style>

</head>


<body
    class="bg-gray-900 relative text-white"
>


<!-- =========================================================
     3D BACKGROUND
     ========================================================= -->

<div
    class="fixed inset-0 z-0 pointer-events-none"
>

    <?php include("includes/3d.php"); ?>

</div>



<!-- =========================================================
     MAIN CONTENT
     ========================================================= -->

<div
    class="relative z-10"
>


    <!-- =====================================================
         NAVBAR
         ===================================================== -->

    <?php include("includes/navbar.php"); ?>



    <!-- =====================================================
         HERO SECTION
         ===================================================== -->

    <section
        class="text-center py-16 px-6"
    >


        <div
            class="inline-flex
                   items-center
                   justify-center
                   w-28
                   h-28
                   mb-6
                   mx-auto"
        >

        </div>



        <!-- TITLE -->

        <h1
            class="text-5xl
                   md:text-6xl
                   font-bold
                   mb-4

                   bg-clip-text
                   text-transparent

                   bg-gradient-to-r
                   from-blue-300
                   to-purple-300"
        >

            NEXUS Gallery

        </h1>



        <!-- DESCRIPTION -->

        <p
            class="text-xl
                   md:text-2xl

                   max-w-3xl
                   mx-auto

                   leading-relaxed

                   text-gray-200"
        >

            Explore moments from our workshops,
            hackathons, and events.

        </p>

    </section>



    <!-- =====================================================
         GALLERY SECTION
         ===================================================== -->

    <section
        class="max-w-6xl
               mx-auto
               px-6
               py-12"
    >


        <!-- =================================================
             GALLERY GRID
             ================================================= -->

        <div
            class="grid
                   grid-cols-1
                   sm:grid-cols-2
                   md:grid-cols-3
                   lg:grid-cols-4
                   gap-6"
        >


            <?php

            /*
             * =================================================
             * LOOP THROUGH DATABASE GALLERIES
             * =================================================
             */

            foreach ($gallery as $index => $item):


                /*
                 * Skip empty galleries
                 */

                if (empty($item["images"])) {
                    continue;
                }


                /*
                 * First image used as card image
                 */

                $firstImage =
                    $item["images"][0];


                /*
                 * Escape title
                 */

                $title =
                    htmlspecialchars(
                        $item["title"],
                        ENT_QUOTES,
                        'UTF-8'
                    );

            ?>


                <!-- =================================================
                     GALLERY CARD
                     ================================================= -->

                <div
                    class="gallery-card
                           relative
                           bg-white/5
                           rounded-2xl
                           shadow-lg
                           overflow-hidden
                           transition
                           transform
                           hover:scale-105
                           cursor-pointer"

                    onclick="openModal(<?= $index ?>)"
                >


                    <!-- CARD IMAGE -->

                    <img
                        src="<?= htmlspecialchars($firstImage) ?>"
                        alt="<?= $title ?>"

                        class="w-full
                               h-60
                               object-cover"
                    >


                    <!-- =================================================
                         OVERLAY
                         ================================================= -->

                    <div
                        class="absolute
                               bottom-0
                               left-0
                               right-0

                               bg-gradient-to-t
                               from-black/70
                               to-transparent

                               p-3"
                    >

                        <h3
                            class="text-base
                                   font-semibold
                                   text-white"
                        >

                            <?= $title ?>

                        </h3>

                    </div>


                </div>



                <!-- =================================================
                     MODAL
                     ================================================= -->

                <div
                    id="modal-<?= $index ?>"

                    class="fixed
                           inset-0
                           bg-black/80

                           hidden

                           justify-center
                           items-center

                           z-50"
                >


                    <div
                        class="relative
                               max-w-4xl
                               w-full
                               p-4"
                    >


                        <!-- =================================================
                             CLOSE BUTTON
                             ================================================= -->

                        <button
                            onclick="closeModal(<?= $index ?>)"

                            class="absolute
                                   top-4
                                   right-4

                                   text-white

                                   text-5xl
                                   font-bold

                                   z-50

                                   hover:text-red-500

                                   transition-all
                                   duration-300"
                        >

                            &times;

                        </button>



                        <!-- =================================================
                             SWIPER
                             ================================================= -->

                        <div
                            class="swiper
                                   mySwiper-<?= $index ?>
                                   rounded-2xl
                                   overflow-hidden"
                        >


                            <div
                                class="swiper-wrapper"
                            >


                                <?php

                                foreach (
                                    $item["images"]
                                    as $img
                                ):

                                ?>


                                    <div
                                        class="swiper-slide"
                                    >

                                        <img
                                            src="<?= htmlspecialchars($img) ?>"

                                            class="w-full
                                                   h-[500px]
                                                   object-contain
                                                   bg-black"
                                        >

                                    </div>


                                <?php

                                endforeach;

                                ?>


                            </div>



                            <!-- =================================================
                                 NAVIGATION
                                 ================================================= -->

                            <div
                                class="swiper-button-next"
                            >
                            </div>


                            <div
                                class="swiper-button-prev"
                            >
                            </div>


                            <div
                                class="swiper-pagination"
                            >
                            </div>


                        </div>

                    </div>

                </div>


            <?php

            endforeach;

            ?>


        </div>

    </section>



    <!-- =====================================================
         FOOTER
         ===================================================== -->

    <?php include("includes/footer.php"); ?>


</div>



<!-- =========================================================
     SWIPER JS
     ========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js">
</script>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<script>


/* =========================================================
   OPEN MODAL
   ========================================================= */

function openModal(index) {


    let modal =
        document.getElementById(
            "modal-" + index
        );


    modal.classList.remove(
        "hidden"
    );


    modal.classList.add(
        "flex"
    );


    /*
     * Initialize Swiper only once
     */

    if (!modal.dataset.initiated) {


        new Swiper(
            ".mySwiper-" + index,
            {

                loop: true,


                pagination: {

                    el:
                        ".swiper-pagination",

                    clickable:
                        true

                },


                navigation: {

                    nextEl:
                        ".swiper-button-next",

                    prevEl:
                        ".swiper-button-prev"

                },


                keyboard: {

                    enabled: true,

                    onlyInViewport: true

                }

            }
        );


        modal.dataset.initiated =
            "true";

    }

}



/* =========================================================
   CLOSE MODAL
   ========================================================= */

function closeModal(index) {


    let modal =
        document.getElementById(
            "modal-" + index
        );


    modal.classList.remove(
        "flex"
    );


    modal.classList.add(
        "hidden"
    );

}

</script>


</body>

</html>