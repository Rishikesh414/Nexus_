
<?php
require_once "../server/config/db.php";


// ==================================================
// HELPER FUNCTION
// ==================================================
function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}


// ==================================================
// IMAGE PATH FUNCTION
// ==================================================
function eventImagePath($image)
{
    if (empty($image)) {
        return '';
    }

    /*
     * Existing images already stored in DB
     * Example:
     * ../frontend/img/conference.jpg
     */
    if (
        strpos($image, '../frontend/') === 0 ||
        strpos($image, './') === 0 ||
        strpos($image, 'http://') === 0 ||
        strpos($image, 'https://') === 0
    ) {
        return $image;
    }

    /*
     * New images uploaded from admin/events.php
     *
     * DB value:
     * filename.jpg
     *
     * Frontend path:
     * ../admin/uploads/events/filename.jpg
     */
    return '../admin/uploads/events/' . $image;
}


// ==================================================
// FETCH UPCOMING EVENTS
// ==================================================
$upcoming_events = [];

$stmt = $conn->prepare("
    SELECT
        id,
        title,
        description,
        guest,
        event_date,
        image,
        badge
    FROM events
    WHERE event_type = 'upcoming'
    ORDER BY id ASC
");

if ($stmt) {

    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $upcoming_events[] = $row;
    }

    $stmt->close();
}


// ==================================================
// FETCH PAST EVENTS
// ==================================================
$gallery = [];

$stmt = $conn->prepare("
    SELECT
        id,
        title,
        description,
        guest,
        event_date,
        image,
        badge
    FROM events
    WHERE event_type = 'past'
    ORDER BY id DESC
");

if ($stmt) {

    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $gallery[] = $row;
    }

    $stmt->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Events | NEXUS</title>


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >


    <!-- AOS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/aos@2.3.1/dist/aos.css"
    >


    <!-- Vanilla Tilt -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.2/vanilla-tilt.min.js"></script>


    <style>

        body {
            background: #111827;
            color: white;
        }

        .event-card {
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-8px);
        }

        .event-image {
            transition: transform 0.5s ease;
        }

        .event-card:hover .event-image {
            transform: scale(1.05);
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

    </style>

</head>


<body class="bg-gray-900 text-white">


<!-- ==================================================
     3D BACKGROUND
================================================== -->

<div class="fixed inset-0 -z-10">

    <?php
    $threeDFile = __DIR__ . "/includes/3d.php";

    if (file_exists($threeDFile)) {
        include $threeDFile;
    }
    ?>

</div>


<!-- ==================================================
     NAVBAR
================================================== -->

<?php

$navbarFile = __DIR__ . "/includes/navbar.php";

if (file_exists($navbarFile)) {
    include $navbarFile;
}

?>


<!-- ==================================================
     HERO SECTION
================================================== -->

<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-b from-purple-900/40 via-gray-900/70 to-gray-900"></div>


    <div
        class="relative z-10 text-center px-6"
        data-aos="fade-up"
    >

        

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-wider">

            NEXUS

        </h1>


        <p class="mt-5 text-gray-300 text-lg md:text-xl max-w-2xl mx-auto">

            Connecting minds, fostering innovation,
            and building the future together

        </p>

    </div>

</section>



<!-- ==================================================
     UPCOMING EVENTS
================================================== -->

<section class="py-16 px-6">

    <div class="max-w-7xl mx-auto">


        <!-- SECTION TITLE -->

        <div
            class="text-center mb-12"
            data-aos="fade-up"
        >

            <span class="text-purple-400 font-semibold tracking-widest uppercase">
                What's Next
            </span>

            <h2 class="text-4xl md:text-5xl font-bold mt-3">

                Upcoming Events

            </h2>

            <div class="w-24 h-1 bg-purple-500 mx-auto mt-5 rounded-full"></div>

        </div>


        <?php if (!empty($upcoming_events)): ?>


            <!-- EVENTS GRID -->

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


                <?php foreach ($upcoming_events as $index => $event): ?>

                    <?php
                    $imagePath = eventImagePath($event['image']);
                    ?>


                    <div
                        class="event-card bg-gradient-to-br from-purple-900/80 to-gray-900 border border-purple-700/40 rounded-2xl overflow-hidden shadow-xl"
                        data-aos="fade-up"
                        data-aos-delay="<?= ($index % 3) * 100 ?>"
                        data-tilt
                        data-tilt-max="5"
                    >


                        <!-- IMAGE -->

                        <div class="relative h-56 overflow-hidden bg-gray-800">

                            <?php if (!empty($imagePath)): ?>

                                <img
                                    src="<?= e($imagePath) ?>"
                                    alt="<?= e($event['title']) ?>"
                                    class="event-image w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >

                                <div
                                    class="w-full h-full items-center justify-center text-gray-500 hidden"
                                >

                                    <i class="fas fa-image text-5xl"></i>

                                </div>

                            <?php else: ?>

                                <div
                                    class="w-full h-full flex items-center justify-center text-gray-500"
                                >

                                    <i class="fas fa-calendar-days text-5xl"></i>

                                </div>

                            <?php endif; ?>


                            <!-- BADGE -->

                            <?php if (!empty($event['badge'])): ?>

                                <div class="absolute top-4 left-4">

                                    <span class="bg-purple-600/90 backdrop-blur-sm text-white px-4 py-2 rounded-full text-xs font-semibold shadow-lg">

                                        <?= e($event['badge']) ?>

                                    </span>

                                </div>

                            <?php endif; ?>

                        </div>


                        <!-- CONTENT -->

                        <div class="p-6">


                            <h3 class="text-2xl font-bold mb-3">

                                <?= e($event['title']) ?>

                            </h3>


                            <!-- DESCRIPTION -->

                            <?php if (!empty($event['description'])): ?>

                                <p class="text-gray-300 text-sm leading-relaxed line-clamp-3 mb-5">

                                    <?= e($event['description']) ?>

                                </p>

                            <?php endif; ?>


                            <!-- DATE -->

                            <?php if (!empty($event['event_date'])): ?>

                                <div class="flex items-start gap-3 text-gray-300 mb-3">

                                    <i class="fas fa-calendar-days text-purple-400 mt-1"></i>

                                    <span class="text-sm">

                                        <?= e($event['event_date']) ?>

                                    </span>

                                </div>

                            <?php endif; ?>


                            <!-- GUEST -->

                            <?php if (!empty($event['guest'])): ?>

                                <div class="flex items-start gap-3 text-gray-300 mb-4">

                                    <i class="fas fa-user text-purple-400 mt-1"></i>

                                    <span class="text-sm">

                                        <?= e($event['guest']) ?>

                                    </span>

                                </div>

                            <?php endif; ?>


                            <!-- STATUS -->

                            <div class="pt-4 border-t border-purple-700/30">

                                <span class="inline-flex items-center gap-2 text-green-400 text-sm font-semibold">

                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>

                                    Upcoming

                                </span>

                            </div>


                        </div>

                    </div>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- NO UPCOMING EVENTS -->

            <div
                class="text-center py-16 bg-gray-800/50 rounded-2xl border border-gray-700"
                data-aos="fade-up"
            >

                <i class="fas fa-calendar-xmark text-5xl text-gray-500 mb-5"></i>

                <h3 class="text-2xl font-bold text-gray-300">

                    No Upcoming Events

                </h3>

                <p class="text-gray-500 mt-2">

                    New events will be announced soon.

                </p>

            </div>

        <?php endif; ?>


    </div>

</section>



<!-- ==================================================
     PAST EVENTS / GALLERY
================================================== -->

<section class="py-16 px-6 bg-gray-950/50">

    <div class="max-w-7xl mx-auto">


        <!-- SECTION TITLE -->

        <div
            class="text-center mb-12"
            data-aos="fade-up"
        >

            <span class="text-purple-400 font-semibold tracking-widest uppercase">
                Memories
            </span>

            <h2 class="text-4xl md:text-5xl font-bold mt-3">

                Past Events

            </h2>

            <div class="w-24 h-1 bg-purple-500 mx-auto mt-5 rounded-full"></div>

        </div>


        <?php if (!empty($gallery)): ?>


            <!-- PAST EVENTS GRID -->

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


                <?php foreach ($gallery as $index => $event): ?>

                    <?php
                    $imagePath = eventImagePath($event['image']);
                    ?>


                    <div
                        class="event-card bg-gray-800/80 border border-gray-700 rounded-2xl overflow-hidden shadow-xl"
                        data-aos="fade-up"
                        data-aos-delay="<?= ($index % 3) * 100 ?>"
                        data-tilt
                        data-tilt-max="5"
                    >


                        <!-- IMAGE -->

                        <div class="relative h-56 overflow-hidden bg-gray-900">


                            <?php if (!empty($imagePath)): ?>

                                <img
                                    src="<?= e($imagePath) ?>"
                                    alt="<?= e($event['title']) ?>"
                                    class="event-image w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >

                                <div
                                    class="w-full h-full items-center justify-center text-gray-500 hidden"
                                >

                                    <i class="fas fa-image text-5xl"></i>

                                </div>

                            <?php else: ?>

                                <div
                                    class="w-full h-full flex items-center justify-center text-gray-500"
                                >

                                    <i class="fas fa-images text-5xl"></i>

                                </div>

                            <?php endif; ?>


                            <!-- BADGE -->

                            <?php if (!empty($event['badge'])): ?>

                                <div class="absolute top-4 left-4">

                                    <span class="bg-gray-900/90 backdrop-blur-sm text-purple-300 px-4 py-2 rounded-full text-xs font-semibold border border-purple-500/30">

                                        <?= e($event['badge']) ?>

                                    </span>

                                </div>

                            <?php endif; ?>


                        </div>


                        <!-- CONTENT -->

                        <div class="p-6">


                            <h3 class="text-xl font-bold mb-4">

                                <?= e($event['title']) ?>

                            </h3>


                            <!-- GUEST -->

                            <?php if (!empty($event['guest'])): ?>

                                <div class="flex items-start gap-3 mb-3">

                                    <i class="fas fa-user-tie text-purple-400 mt-1"></i>

                                    <div>

                                        <p class="text-xs text-gray-500 uppercase tracking-wide">

                                            Guest / Resource Person

                                        </p>

                                        <p class="text-gray-300 text-sm mt-1">

                                            <?= e($event['guest']) ?>

                                        </p>

                                    </div>

                                </div>

                            <?php endif; ?>


                            <!-- DATE -->

                            <?php if (!empty($event['event_date'])): ?>

                                <div class="flex items-start gap-3">

                                    <i class="fas fa-calendar-days text-purple-400 mt-1"></i>

                                    <div>

                                        <p class="text-xs text-gray-500 uppercase tracking-wide">

                                            Date / Duration

                                        </p>

                                        <p class="text-gray-300 text-sm mt-1">

                                            <?= e($event['event_date']) ?>

                                        </p>

                                    </div>

                                </div>

                            <?php endif; ?>


                            <!-- PAST STATUS -->

                            <div class="pt-4 mt-4 border-t border-gray-700">

                                <span class="inline-flex items-center gap-2 text-gray-400 text-sm">

                                    <i class="fas fa-circle-check text-green-500"></i>

                                    Completed Event

                                </span>

                            </div>


                        </div>

                    </div>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- NO PAST EVENTS -->

            <div
                class="text-center py-16 bg-gray-800/50 rounded-2xl border border-gray-700"
                data-aos="fade-up"
            >

                <i class="fas fa-images text-5xl text-gray-500 mb-5"></i>

                <h3 class="text-2xl font-bold text-gray-300">

                    No Past Events

                </h3>

                <p class="text-gray-500 mt-2">

                    Event records will appear here.

                </p>

            </div>

        <?php endif; ?>


    </div>

</section>



<!-- ==================================================
     FOOTER
================================================== -->

<footer class="bg-gray-950 border-t border-gray-800 py-8">

    <div class="max-w-7xl mx-auto px-6 text-center">

        <p class="text-gray-500 text-sm">

            &copy; <?= date('Y') ?> NEXUS. All Rights Reserved.

        </p>

    </div>

</footer>



<!-- ==================================================
     AOS SCRIPT
================================================== -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>

AOS.init({
    duration: 800,
    once: true,
    offset: 80
});

</script>



<!-- ==================================================
     VANILLA TILT
================================================== -->

<script>

VanillaTilt.init(
    document.querySelectorAll("[data-tilt]"),
    {
        max: 5,
        speed: 500,
        glare: true,
        "max-glare": 0.15
    }
);

</script>


</body>

</html>

