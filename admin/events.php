<?php
session_start();

// Admin login protection
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require_once "../server/config/db.php";

// --------------------------------------------------
// IMAGE UPLOAD SETTINGS
// --------------------------------------------------
$upload_dir = __DIR__ . "/uploads/events/";

// Create upload folder if it doesn't exist
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Allowed image types
$allowed_types = [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif'
];

$max_file_size = 5 * 1024 * 1024; // 5 MB

$message = "";
$error = "";


// ==================================================
// ADD EVENT
// ==================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {

    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $guest       = trim($_POST['guest'] ?? '');
    $event_date  = trim($_POST['event_date'] ?? '');
    $badge       = trim($_POST['badge'] ?? '');
    $event_type  = trim($_POST['event_type'] ?? 'upcoming');

    // Validation
    if ($title === '') {
        $error = "Event title is required.";
    } elseif (!in_array($event_type, ['upcoming', 'past'])) {
        $error = "Invalid event type.";
    }

    // Image upload
    $image_name = null;

    if ($error === "" && isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $error = "Image upload failed.";
        } elseif ($_FILES['image']['size'] > $max_file_size) {
            $error = "Image size must be less than 5 MB.";
        } elseif (!in_array($_FILES['image']['type'], $allowed_types)) {
            $error = "Only JPG, PNG, WEBP and GIF images are allowed.";
        } else {

            $extension = strtolower(
                pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
            );

            // Unique file name
            $image_name = time() . '_' . uniqid() . '.' . $extension;

            $target_file = $upload_dir . $image_name;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $error = "Failed to save uploaded image.";
                $image_name = null;
            }
        }
    }

    // Insert into database
    if ($error === "") {

        $sql = "INSERT INTO events
                (title, description, guest, event_date, image, badge, event_type)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param(
                "sssssss",
                $title,
                $description,
                $guest,
                $event_date,
                $image_name,
                $badge,
                $event_type
            );

            if ($stmt->execute()) {
                $message = "Event added successfully.";
            } else {
                $error = "Failed to add event.";

                // Remove uploaded image if DB insert failed
                if ($image_name && file_exists($upload_dir . $image_name)) {
                    unlink($upload_dir . $image_name);
                }
            }

            $stmt->close();

        } else {
            $error = "Database query error.";
        }
    }
}


// ==================================================
// UPDATE / EDIT EVENT
// ==================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_event'])) {

    $id          = intval($_POST['id'] ?? 0);
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $guest       = trim($_POST['guest'] ?? '');
    $event_date  = trim($_POST['event_date'] ?? '');
    $badge       = trim($_POST['badge'] ?? '');
    $event_type  = trim($_POST['event_type'] ?? 'upcoming');

    if ($id <= 0) {
        $error = "Invalid event ID.";
    } elseif ($title === '') {
        $error = "Event title is required.";
    } elseif (!in_array($event_type, ['upcoming', 'past'])) {
        $error = "Invalid event type.";
    }

    // Get current image
    $old_image = null;

    if ($error === "") {

        $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");

        if ($stmt) {

            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $error = "Event not found.";
            } else {
                $row = $result->fetch_assoc();
                $old_image = $row['image'];
            }

            $stmt->close();

        } else {
            $error = "Database query error.";
        }
    }


    // New image
    $new_image = $old_image;

    if (
        $error === "" &&
        isset($_FILES['image']) &&
        $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
    ) {

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $error = "Image upload failed.";
        } elseif ($_FILES['image']['size'] > $max_file_size) {
            $error = "Image size must be less than 5 MB.";
        } elseif (!in_array($_FILES['image']['type'], $allowed_types)) {
            $error = "Only JPG, PNG, WEBP and GIF images are allowed.";
        } else {

            $extension = strtolower(
                pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)
            );

            $new_image = time() . '_' . uniqid() . '.' . $extension;

            $target_file = $upload_dir . $new_image;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $error = "Failed to save uploaded image.";
                $new_image = $old_image;
            }
        }
    }


    // Update database
    if ($error === "") {

        $sql = "UPDATE events
                SET title = ?,
                    description = ?,
                    guest = ?,
                    event_date = ?,
                    image = ?,
                    badge = ?,
                    event_type = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {

            $stmt->bind_param(
                "sssssssi",
                $title,
                $description,
                $guest,
                $event_date,
                $new_image,
                $badge,
                $event_type,
                $id
            );

            if ($stmt->execute()) {

                $message = "Event updated successfully.";

                // Delete old uploaded image only if it belongs
                // to admin/uploads/events/
                if (
                    $new_image !== $old_image &&
                    !empty($old_image) &&
                    strpos($old_image, '/') === false &&
                    file_exists($upload_dir . $old_image)
                ) {
                    unlink($upload_dir . $old_image);
                }

            } else {

                $error = "Failed to update event.";

                // Remove newly uploaded image if DB update failed
                if (
                    $new_image !== $old_image &&
                    file_exists($upload_dir . $new_image)
                ) {
                    unlink($upload_dir . $new_image);
                }
            }

            $stmt->close();

        } else {
            $error = "Database query error.";
        }
    }
}


// ==================================================
// DELETE EVENT
// ==================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_event'])) {

    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        $error = "Invalid event ID.";
    } else {

        // Get image before deleting
        $image = null;

        $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");

        if ($stmt) {

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows === 0) {

                $error = "Event not found.";

            } else {

                $row = $result->fetch_assoc();
                $image = $row['image'];
            }

            $stmt->close();

        } else {
            $error = "Database query error.";
        }


        // Delete event
        if ($error === "") {

            $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");

            if ($stmt) {

                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {

                    $message = "Event deleted successfully.";

                    // Delete only images uploaded by admin
                    if (
                        !empty($image) &&
                        strpos($image, '/') === false &&
                        file_exists($upload_dir . $image)
                    ) {
                        unlink($upload_dir . $image);
                    }

                } else {
                    $error = "Failed to delete event.";
                }

                $stmt->close();

            } else {
                $error = "Database query error.";
            }
        }
    }
}


// ==================================================
// FETCH EVENTS
// ==================================================
$events = [];

$result = $conn->query("
    SELECT
        id,
        title,
        description,
        guest,
        event_date,
        image,
        badge,
        event_type,
        created_at
    FROM events
    ORDER BY id DESC
");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}


// ==================================================
// ESCAPE HTML FUNCTION
// ==================================================
function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}


// ==================================================
// IMAGE PATH FOR ADMIN
// ==================================================
function adminImagePath($image)
{
    if (empty($image)) {
        return '';
    }

    // Existing frontend image path
    if (strpos($image, '../frontend/') === 0) {
        return $image;
    }

    // Existing ./assets/ path
    if (strpos($image, './') === 0) {
        return $image;
    }

    // Admin uploaded image
    return 'uploads/events/' . $image;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Events | Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >

</head>


<body class="bg-gray-100 min-h-screen">


<!-- ==================================================
     HEADER
================================================== -->

<header class="bg-gray-900 text-white shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-4">

        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-2xl font-bold">
                    Events Management
                </h1>

                <p class="text-gray-400 text-sm">
                    Add, edit and manage events
                </p>

            </div>

            <a
                href="dashboard.php"
                class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Dashboard
            </a>

        </div>

    </div>

</header>


<!-- ==================================================
     MAIN
================================================== -->

<main class="max-w-7xl mx-auto px-6 py-8">


<!-- SUCCESS MESSAGE -->

<?php if ($message !== ""): ?>

    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

        <i class="fas fa-check-circle mr-2"></i>

        <?= e($message) ?>

    </div>

<?php endif; ?>


<!-- ERROR MESSAGE -->

<?php if ($error !== ""): ?>

    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

        <i class="fas fa-exclamation-circle mr-2"></i>

        <?= e($error) ?>

    </div>

<?php endif; ?>


<!-- ==================================================
     ADD EVENT FORM
================================================== -->

<section class="bg-white rounded-xl shadow-md p-6 mb-8">

    <div class="flex items-center mb-6">

        <div class="bg-purple-100 text-purple-600 p-3 rounded-lg mr-3">

            <i class="fas fa-plus text-xl"></i>

        </div>

        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Add New Event
            </h2>

            <p class="text-gray-500 text-sm">
                Create a new event
            </p>

        </div>

    </div>


    <form
        method="POST"
        enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 gap-5"
    >


        <!-- TITLE -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Event Title *
            </label>

            <input
                type="text"
                name="title"
                required
                placeholder="Enter event title"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >

        </div>


        <!-- GUEST -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Guest / Resource Person
            </label>

            <input
                type="text"
                name="guest"
                placeholder="Enter guest name"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >

        </div>


        <!-- DATE -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Event Date / Duration
            </label>

            <input
                type="text"
                name="event_date"
                placeholder="Example: 25 Oct 2025"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >

        </div>


        <!-- BADGE -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Badge
            </label>

            <input
                type="text"
                name="badge"
                placeholder="Example: Workshop"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >

        </div>


        <!-- EVENT TYPE -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Event Type *
            </label>

            <select
                name="event_type"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            >

                <option value="upcoming">
                    Upcoming
                </option>

                <option value="past">
                    Past
                </option>

            </select>

        </div>


        <!-- IMAGE -->

        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Event Image
            </label>

            <input
                type="file"
                name="image"
                accept=".jpg,.jpeg,.png,.webp,.gif"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
            >

            <p class="text-xs text-gray-500 mt-1">
                JPG, PNG, WEBP or GIF. Maximum 5 MB.
            </p>

        </div>


        <!-- DESCRIPTION -->

        <div class="md:col-span-2">

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Description
            </label>

            <textarea
                name="description"
                rows="4"
                placeholder="Enter event description"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:outline-none"
            ></textarea>

        </div>


        <!-- SUBMIT -->

        <div class="md:col-span-2">

            <button
                type="submit"
                name="add_event"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition"
            >

                <i class="fas fa-plus mr-2"></i>

                Add Event

            </button>

        </div>

    </form>

</section>



<!-- ==================================================
     EVENTS LIST
================================================== -->

<section class="bg-white rounded-xl shadow-md overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold text-gray-800">
            All Events
        </h2>

        <p class="text-gray-500 text-sm mt-1">
            <?= count($events) ?> event(s) found
        </p>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-900 text-white">

                <tr>

                    <th class="px-4 py-4 text-left">
                        ID
                    </th>

                    <th class="px-4 py-4 text-left">
                        Image
                    </th>

                    <th class="px-4 py-4 text-left">
                        Event
                    </th>

                    <th class="px-4 py-4 text-left">
                        Guest
                    </th>

                    <th class="px-4 py-4 text-left">
                        Date
                    </th>

                    <th class="px-4 py-4 text-left">
                        Badge
                    </th>

                    <th class="px-4 py-4 text-left">
                        Type
                    </th>

                    <th class="px-4 py-4 text-center">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200">


            <?php if (empty($events)): ?>

                <tr>

                    <td
                        colspan="8"
                        class="px-6 py-10 text-center text-gray-500"
                    >

                        <i class="fas fa-calendar-xmark text-4xl mb-3"></i>

                        <p>
                            No events found.
                        </p>

                    </td>

                </tr>


            <?php else: ?>


                <?php foreach ($events as $event): ?>

                    <tr class="hover:bg-gray-50">


                        <!-- ID -->

                        <td class="px-4 py-4 font-semibold">

                            <?= e($event['id']) ?>

                        </td>


                        <!-- IMAGE -->

                        <td class="px-4 py-4">

                            <?php
                            $img = adminImagePath($event['image']);
                            ?>

                            <?php if ($img !== ""): ?>

                                <img
                                    src="<?= e($img) ?>"
                                    alt="<?= e($event['title']) ?>"
                                    class="w-20 h-14 object-cover rounded-lg border"
                                >

                            <?php else: ?>

                                <div class="w-20 h-14 bg-gray-200 rounded-lg flex items-center justify-center">

                                    <i class="fas fa-image text-gray-400"></i>

                                </div>

                            <?php endif; ?>

                        </td>


                        <!-- EVENT -->

                        <td class="px-4 py-4">

                            <div class="font-semibold text-gray-800">

                                <?= e($event['title']) ?>

                            </div>

                            <?php if (!empty($event['description'])): ?>

                                <div class="text-sm text-gray-500 mt-1 max-w-xs">

                                    <?= e($event['description']) ?>

                                </div>

                            <?php endif; ?>

                        </td>


                        <!-- GUEST -->

                        <td class="px-4 py-4 text-sm text-gray-700">

                            <?= e($event['guest'] ?: '-') ?>

                        </td>


                        <!-- DATE -->

                        <td class="px-4 py-4 text-sm text-gray-700">

                            <?= e($event['event_date'] ?: '-') ?>

                        </td>


                        <!-- BADGE -->

                        <td class="px-4 py-4">

                            <?php if (!empty($event['badge'])): ?>

                                <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    <?= e($event['badge']) ?>

                                </span>

                            <?php else: ?>

                                <span class="text-gray-400">
                                    -
                                </span>

                            <?php endif; ?>

                        </td>


                        <!-- EVENT TYPE -->

                        <td class="px-4 py-4">

                            <?php if ($event['event_type'] === 'upcoming'): ?>

                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Upcoming

                                </span>

                            <?php else: ?>

                                <span class="inline-block bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Past

                                </span>

                            <?php endif; ?>

                        </td>


                        <!-- ACTIONS -->

                        <td class="px-4 py-4">

                            <div class="flex items-center justify-center gap-2">


                                <!-- EDIT BUTTON -->

                                <button
                                    type="button"
                                    onclick="openEditModal(
                                        <?= e($event['id']) ?>,
                                        <?= htmlspecialchars(json_encode($event['title']), ENT_QUOTES, 'UTF-8') ?>,
                                        <?= htmlspecialchars(json_encode($event['description']), ENT_QUOTES, 'UTF-8') ?>,
                                        <?= htmlspecialchars(json_encode($event['guest']), ENT_QUOTES, 'UTF-8') ?>,
                                        <?= htmlspecialchars(json_encode($event['event_date']), ENT_QUOTES, 'UTF-8') ?>,
                                        <?= htmlspecialchars(json_encode($event['badge']), ENT_QUOTES, 'UTF-8') ?>,
                                        <?= htmlspecialchars(json_encode($event['event_type']), ENT_QUOTES, 'UTF-8') ?>,
                                        <?= htmlspecialchars(json_encode($event['image']), ENT_QUOTES, 'UTF-8') ?>
                                    )"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg"
                                    title="Edit"
                                >

                                    <i class="fas fa-edit"></i>

                                </button>


                                <!-- DELETE -->

                                <form
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this event?');"
                                >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= e($event['id']) ?>"
                                    >

                                    <button
                                        type="submit"
                                        name="delete_event"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg"
                                        title="Delete"
                                    >

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>


                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>


            <?php endif; ?>


            </tbody>

        </table>

    </div>

</section>

</main>



<!-- ==================================================
     EDIT MODAL
================================================== -->

<div
    id="editModal"
    class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4"
>


    <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">


        <!-- MODAL HEADER -->

        <div class="flex items-center justify-between px-6 py-4 border-b">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    Edit Event
                </h2>

                <p class="text-sm text-gray-500">
                    Update event details
                </p>

            </div>


            <button
                type="button"
                onclick="closeEditModal()"
                class="text-gray-500 hover:text-red-500 text-2xl"
            >

                &times;

            </button>

        </div>



        <!-- EDIT FORM -->

        <form
            method="POST"
            enctype="multipart/form-data"
            class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5"
        >

            <input
                type="hidden"
                name="id"
                id="edit_id"
            >


            <!-- TITLE -->

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Event Title *
                </label>

                <input
                    type="text"
                    name="title"
                    id="edit_title"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >

            </div>


            <!-- GUEST -->

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Guest / Resource Person
                </label>

                <input
                    type="text"
                    name="guest"
                    id="edit_guest"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >

            </div>


            <!-- DATE -->

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Event Date / Duration
                </label>

                <input
                    type="text"
                    name="event_date"
                    id="edit_event_date"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >

            </div>


            <!-- BADGE -->

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Badge
                </label>

                <input
                    type="text"
                    name="badge"
                    id="edit_badge"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >

            </div>


            <!-- EVENT TYPE -->

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Event Type *
                </label>

                <select
                    name="event_type"
                    id="edit_event_type"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >

                    <option value="upcoming">
                        Upcoming
                    </option>

                    <option value="past">
                        Past
                    </option>

                </select>

            </div>


            <!-- NEW IMAGE -->

            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Change Image
                </label>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp,.gif"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                >

                <p class="text-xs text-gray-500 mt-1">
                    Leave empty to keep current image.
                </p>

            </div>


            <!-- DESCRIPTION -->

            <div class="md:col-span-2">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    id="edit_description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                ></textarea>

            </div>


            <!-- CURRENT IMAGE -->

            <div
                id="currentImageContainer"
                class="md:col-span-2 hidden"
            >

                <p class="text-sm font-semibold text-gray-700 mb-2">
                    Current Image
                </p>

                <img
                    id="currentImage"
                    src=""
                    alt="Current Event Image"
                    class="w-32 h-24 object-cover rounded-lg border"
                >

            </div>


            <!-- BUTTONS -->

            <div class="md:col-span-2 flex justify-end gap-3 pt-3 border-t">

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-lg font-semibold"
                >

                    Cancel

                </button>


                <button
                    type="submit"
                    name="update_event"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold"
                >

                    <i class="fas fa-save mr-2"></i>

                    Update Event

                </button>

            </div>

        </form>

    </div>

</div>



<!-- ==================================================
     JAVASCRIPT
================================================== -->

<script>

function openEditModal(
    id,
    title,
    description,
    guest,
    eventDate,
    badge,
    eventType,
    image
) {

    document.getElementById('edit_id').value = id;

    document.getElementById('edit_title').value = title || '';

    document.getElementById('edit_description').value =
        description || '';

    document.getElementById('edit_guest').value =
        guest || '';

    document.getElementById('edit_event_date').value =
        eventDate || '';

    document.getElementById('edit_badge').value =
        badge || '';

    document.getElementById('edit_event_type').value =
        eventType || 'upcoming';


    // Current image
    const imageContainer =
        document.getElementById('currentImageContainer');

    const currentImage =
        document.getElementById('currentImage');


    if (image) {

        let imagePath = image;


        // Admin uploaded image
        if (
            !image.startsWith('../frontend/') &&
            !image.startsWith('./') &&
            !image.includes('/')
        ) {
            imagePath = 'uploads/events/' + image;
        }


        currentImage.src = imagePath;

        imageContainer.classList.remove('hidden');

    } else {

        currentImage.src = '';

        imageContainer.classList.add('hidden');
    }


    // Show modal
    const modal = document.getElementById('editModal');

    modal.classList.remove('hidden');

    modal.classList.add('flex');

}


function closeEditModal() {

    const modal = document.getElementById('editModal');

    modal.classList.add('hidden');

    modal.classList.remove('flex');

}


// Close when clicking outside modal
document
    .getElementById('editModal')
    .addEventListener('click', function(event) {

        if (event.target === this) {
            closeEditModal();
        }

    });

</script>


</body>

</html>