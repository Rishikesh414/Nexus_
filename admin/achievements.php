<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require_once "../server/config/db.php";

/*
|--------------------------------------------------------------------------
| Achievement Category Configuration
|--------------------------------------------------------------------------
*/
$categories = [

    "academic" => [
        "name" => "Academic Achievement",
        "table" => "academic_achievements"
    ],

    "department" => [
        "name" => "Department Activities",
        "table" => "department_activities"
    ],

    "sports" => [
        "name" => "Sports Achievement",
        "table" => "sports_achievements"
    ],

    "internship" => [
        "name" => "Internship / Company Project",
        "table" => "internships_company_projects"
    ],

    "hackathon" => [
        "name" => "Hackathon / Expo / Conferences",
        "table" => "hackathons_expos_conferences"
    ]
];

$message = "";
$error = "";


/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/
if (isset($_GET['delete']) && isset($_GET['category'])) {

    $delete_id = intval($_GET['delete']);
    $category = $_GET['category'];

    if ($delete_id > 0 && isset($categories[$category])) {

        $table = $categories[$category]['table'];

        $stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");

        if ($stmt) {
            $stmt->bind_param("i", $delete_id);

            if ($stmt->execute()) {
                $message = $categories[$category]['name'] . " deleted successfully.";
            } else {
                $error = "Unable to delete record.";
            }

            $stmt->close();
        }
    }
}


/*
|--------------------------------------------------------------------------
| ADD ACHIEVEMENT
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_achievement'])) {

    $category = $_POST['achievement_field'] ?? '';

    if (!isset($categories[$category])) {

        $error = "Please select a valid achievement field.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Academic Achievement
        |--------------------------------------------------------------------------
        */
        if ($category === "academic") {

            $date_duration   = trim($_POST['academic_date_duration'] ?? '');
            $student         = trim($_POST['academic_student'] ?? '');
            $year_department = trim($_POST['academic_year_department'] ?? '');
            $activity_event  = trim($_POST['academic_activity_event'] ?? '');
            $achievement_role = trim($_POST['academic_achievement_role'] ?? '');
            $organization    = trim($_POST['academic_organization_venue'] ?? '');
            $academic_year   = trim($_POST['academic_academic_year'] ?? '');

            if (
                $date_duration === '' ||
                $student === '' ||
                $year_department === '' ||
                $activity_event === '' ||
                $achievement_role === '' ||
                $organization === '' ||
                $academic_year === ''
            ) {

                $error = "Please fill all Academic Achievement fields.";

            } else {

                $stmt = $conn->prepare("
                    INSERT INTO academic_achievements
                    (
                        date_duration,
                        student,
                        year_department,
                        activity_event,
                        achievement_role,
                        organization_venue,
                        academic_year
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");

                if ($stmt) {

                    $stmt->bind_param(
                        "sssssss",
                        $date_duration,
                        $student,
                        $year_department,
                        $activity_event,
                        $achievement_role,
                        $organization,
                        $academic_year
                    );

                    if ($stmt->execute()) {
                        $message = "Academic Achievement added successfully.";
                    } else {
                        $error = "Failed to add Academic Achievement.";
                    }

                    $stmt->close();
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Department Activities
        |--------------------------------------------------------------------------
        */
        elseif ($category === "department") {

            $date_duration   = trim($_POST['department_date_duration'] ?? '');
            $activity_event  = trim($_POST['department_activity_event'] ?? '');
            $department_joint = trim($_POST['department_joint'] ?? '');
            $guest_resource  = trim($_POST['guest_resource'] ?? '');
            $academic_year   = trim($_POST['department_academic_year'] ?? '');

            if (
                $date_duration === '' ||
                $activity_event === '' ||
                $department_joint === '' ||
                $guest_resource === '' ||
                $academic_year === ''
            ) {

                $error = "Please fill all Department Activity fields.";

            } else {

                $stmt = $conn->prepare("
                    INSERT INTO department_activities
                    (
                        date_duration,
                        activity_event,
                        department_joint,
                        guest_resource,
                        academic_year
                    )
                    VALUES (?, ?, ?, ?, ?)
                ");

                if ($stmt) {

                    $stmt->bind_param(
                        "sssss",
                        $date_duration,
                        $activity_event,
                        $department_joint,
                        $guest_resource,
                        $academic_year
                    );

                    if ($stmt->execute()) {
                        $message = "Department Activity added successfully.";
                    } else {
                        $error = "Failed to add Department Activity.";
                    }

                    $stmt->close();
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sports Achievement
        |--------------------------------------------------------------------------
        */
        elseif ($category === "sports") {

            $date_duration       = trim($_POST['sports_date_duration'] ?? '');
            $sport_event         = trim($_POST['sport_event'] ?? '');
            $students            = trim($_POST['sports_students'] ?? '');
            $achievement_position = trim($_POST['achievement_position'] ?? '');
            $academic_year       = trim($_POST['sports_academic_year'] ?? '');

            if (
                $date_duration === '' ||
                $sport_event === '' ||
                $students === '' ||
                $achievement_position === '' ||
                $academic_year === ''
            ) {

                $error = "Please fill all Sports Achievement fields.";

            } else {

                $stmt = $conn->prepare("
                    INSERT INTO sports_achievements
                    (
                        date_duration,
                        sport_event,
                        students,
                        achievement_position,
                        academic_year
                    )
                    VALUES (?, ?, ?, ?, ?)
                ");

                if ($stmt) {

                    $stmt->bind_param(
                        "sssss",
                        $date_duration,
                        $sport_event,
                        $students,
                        $achievement_position,
                        $academic_year
                    );

                    if ($stmt->execute()) {
                        $message = "Sports Achievement added successfully.";
                    } else {
                        $error = "Failed to add Sports Achievement.";
                    }

                    $stmt->close();
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Internship / Company Project
        |--------------------------------------------------------------------------
        */
        elseif ($category === "internship") {

            $company_organization = trim($_POST['company_organization'] ?? '');
            $project_role         = trim($_POST['project_role'] ?? '');
            $students             = trim($_POST['internship_students'] ?? '');
            $staff_mentor        = trim($_POST['staff_mentor'] ?? '');
            $duration_notes      = trim($_POST['duration_notes'] ?? '');
            $academic_year       = trim($_POST['internship_academic_year'] ?? '');

            if (
                $company_organization === '' ||
                $project_role === '' ||
                $students === '' ||
                $staff_mentor === '' ||
                $duration_notes === '' ||
                $academic_year === ''
            ) {

                $error = "Please fill all Internship / Company Project fields.";

            } else {

                $stmt = $conn->prepare("
                    INSERT INTO internships_company_projects
                    (
                        company_organization,
                        project_role,
                        students,
                        staff_mentor,
                        duration_notes,
                        academic_year
                    )
                    VALUES (?, ?, ?, ?, ?, ?)
                ");

                if ($stmt) {

                    $stmt->bind_param(
                        "ssssss",
                        $company_organization,
                        $project_role,
                        $students,
                        $staff_mentor,
                        $duration_notes,
                        $academic_year
                    );

                    if ($stmt->execute()) {
                        $message = "Internship / Company Project added successfully.";
                    } else {
                        $error = "Failed to add Internship / Company Project.";
                    }

                    $stmt->close();
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Hackathon / Expo / Conferences
        |--------------------------------------------------------------------------
        */
        elseif ($category === "hackathon") {

            $date_duration      = trim($_POST['hackathon_date_duration'] ?? '');
            $event              = trim($_POST['hackathon_event'] ?? '');
            $students           = trim($_POST['hackathon_students'] ?? '');
            $venue_organization = trim($_POST['venue_organization'] ?? '');
            $academic_year      = trim($_POST['hackathon_academic_year'] ?? '');

            if (
                $date_duration === '' ||
                $event === '' ||
                $students === '' ||
                $venue_organization === '' ||
                $academic_year === ''
            ) {

                $error = "Please fill all Hackathon / Expo / Conference fields.";

            } else {

                $stmt = $conn->prepare("
                    INSERT INTO hackathons_expos_conferences
                    (
                        date_duration,
                        event,
                        students,
                        venue_organization,
                        academic_year
                    )
                    VALUES (?, ?, ?, ?, ?)
                ");

                if ($stmt) {

                    $stmt->bind_param(
                        "sssss",
                        $date_duration,
                        $event,
                        $students,
                        $venue_organization,
                        $academic_year
                    );

                    if ($stmt->execute()) {
                        $message = "Hackathon / Expo / Conference added successfully.";
                    } else {
                        $error = "Failed to add Hackathon / Expo / Conference.";
                    }

                    $stmt->close();
                }
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| FETCH DATA
|--------------------------------------------------------------------------
*/

$academic_result = $conn->query("
    SELECT *
    FROM academic_achievements
    ORDER BY id DESC
");

$department_result = $conn->query("
    SELECT *
    FROM department_activities
    ORDER BY id DESC
");

$sports_result = $conn->query("
    SELECT *
    FROM sports_achievements
    ORDER BY id DESC
");

$internship_result = $conn->query("
    SELECT *
    FROM internships_company_projects
    ORDER BY id DESC
");

$hackathon_result = $conn->query("
    SELECT *
    FROM hackathons_expos_conferences
    ORDER BY id DESC
");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NEXUS - Achievements</title>

    <link rel="stylesheet" href="css/admin.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f5ff;
            color: #29213d;
        }

        .main-content {
            margin-left: 250px;
            padding: 35px;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 800;
            color: #4c1d95;
        }

        .page-header p {
            margin-top: 7px;
            color: #777;
        }


        /* ALERTS */

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .success {
            background: #e9f9ef;
            color: #18733c;
            border: 1px solid #bce7ca;
        }

        .danger {
            background: #fff0f0;
            color: #b42318;
            border: 1px solid #f3c0c0;
        }


        /* FORM CARD */

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 35px;
            border: 1px solid #e5d9f5;
            box-shadow: 0 8px 25px rgba(79, 38, 120, 0.08);
        }

        .form-card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #581c87;
            font-size: 21px;
        }


        /* CATEGORY SELECT */

        .category-select {
            margin-bottom: 25px;
        }

        .category-select label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #4c1d95;
        }

        .category-select select {
            width: 100%;
            max-width: 600px;
            padding: 13px 15px;
            border: 1px solid #d8c9ed;
            border-radius: 9px;
            background: white;
            font-size: 15px;
            color: #333;
            cursor: pointer;
            outline: none;
        }

        .category-select select:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
        }


        /* CATEGORY FORMS */

        .category-fields {
            display: none;
        }

        .category-fields.active {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 7px;
            color: #44345c;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d9cee7;
            border-radius: 8px;
            background: #fff;
            color: #222;
            font-size: 14px;
            font-family: Arial, sans-serif;
            outline: none;
            cursor: text;
            user-select: text;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.10);
        }

        .form-group textarea {
            min-height: 90px;
            resize: vertical;
        }

        .add-btn {
            margin-top: 22px;
            border: none;
            padding: 12px 24px;
            border-radius: 9px;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .add-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(99, 102, 241, 0.25);
        }


        /* DATA SECTION */

        .data-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e5d9f5;
            box-shadow: 0 8px 25px rgba(79, 38, 120, 0.07);
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 10px;
        }

        .section-title h2 {
            margin: 0;
            color: #581c87;
            font-size: 20px;
        }

        .count-badge {
            background: #f0e9ff;
            color: #6d28d9;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }


        /* TABLE */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th {
            background: #f4effc;
            color: #4c1d95;
            font-size: 13px;
            font-weight: 700;
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #dfd2ee;
            white-space: nowrap;
        }

        td {
            padding: 13px 12px;
            font-size: 13px;
            color: #444;
            border-bottom: 1px solid #eee8f5;
            vertical-align: top;
        }

        tr:hover td {
            background: #fcfaff;
        }

        .delete-btn {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 7px;
            background: #fee2e2;
            color: #b91c1c;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
        }

        .delete-btn:hover {
            background: #fecaca;
        }

        .empty {
            padding: 25px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }


        /* =========================
           SIDEBAR ALIGNMENT FIX
           ========================= */

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 18px;
            background: #ffffff;
            border-right: 1px solid #e5d9f5;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .sidebar-logo {
            margin-bottom: 30px;
        }

        .sidebar-logo h2 {
            margin: 0;
            color: #4c1d95;
            font-size: 24px;
            font-weight: 800;
        }

        .sidebar-logo span {
            display: block;
            margin-top: 2px;
            color: #777;
            font-size: 13px;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 14px;
            box-sizing: border-box;
            border-radius: 8px;
            text-decoration: none;
            color: #4c1d95;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
        }

        .sidebar-nav a:hover {
            background: #f4effc;
            color: #6d28d9;
        }

        .sidebar-nav a.active {
            background: #ede9fe;
            color: #6d28d9;
            font-weight: 700;
        }

        /* MOBILE */

        @media (max-width: 900px) {

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }
        }

    </style>

</head>

<body>


<?php
/*
|--------------------------------------------------------------------------
| SIDEBAR
|--------------------------------------------------------------------------
*/
?>

<aside class="sidebar">

    <div class="sidebar-logo">
        <h2>NEXUS</h2>
        <span>ADMIN PANEL</span>
    </div>

    <nav class="sidebar-nav">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="events.php">
            Events
        </a>

        <a href="achievements.php" class="active">
            Achievements
        </a>

        <a href="gallery.php">
            Gallery
        </a>

        <a href="logout.php">
            Logout
        </a>

    </nav>

</aside>


<main class="main-content">

    <div class="page-header">

        <h1>Achievements</h1>

        <p>
            Add and manage achievements by category.
        </p>

    </div>


    <?php if ($message): ?>

        <div class="alert success">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div class="alert danger">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <!-- =========================================================
         ADD ACHIEVEMENT
    ========================================================== -->

    <div class="form-card">

        <h2>Add Achievement</h2>

        <form method="POST">

            <div class="category-select">

                <label for="achievement_field">
                    Achievement Field
                </label>

                <select
                    name="achievement_field"
                    id="achievement_field"
                    required
                >

                    <option value="">
                        -- Select Achievement Field --
                    </option>

                    <option value="academic">
                        Academic Achievement
                    </option>

                    <option value="department">
                        Department Activities
                    </option>

                    <option value="sports">
                        Sports Achievement
                    </option>

                    <option value="internship">
                        Internship / Company Project
                    </option>

                    <option value="hackathon">
                        Hackathon / Expo / Conferences
                    </option>

                </select>

            </div>


            <!-- =================================================
                 ACADEMIC
            ================================================== -->

            <div
                class="category-fields"
                id="academic-fields"
            >

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Date / Duration
                        </label>

                        <input
                            type="text"
                            name="academic_date_duration"
                            placeholder="Example: 10/01/2026"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Student
                        </label>

                        <input
                            type="text"
                            name="academic_student"
                            placeholder="Student name"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Year / Department
                        </label>

                        <input
                            type="text"
                            name="academic_year_department"
                            placeholder="Example: III IT"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Academic Year
                        </label>

                        <input
                            type="text"
                            name="academic_academic_year"
                            placeholder="Example: 2024-2025"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Activity / Event
                        </label>

                        <input
                            type="text"
                            name="academic_activity_event"
                            placeholder="Activity or event name"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Achievement / Role
                        </label>

                        <input
                            type="text"
                            name="academic_achievement_role"
                            placeholder="Achievement or role"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Organization / Venue
                        </label>

                        <input
                            type="text"
                            name="academic_organization_venue"
                            placeholder="Organization or venue"
                        >

                    </div>

                </div>

            </div>


            <!-- =================================================
                 DEPARTMENT
            ================================================== -->

            <div
                class="category-fields"
                id="department-fields"
            >

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Date / Duration
                        </label>

                        <input
                            type="text"
                            name="department_date_duration"
                            placeholder="Example: 25/10/2025"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Academic Year
                        </label>

                        <input
                            type="text"
                            name="department_academic_year"
                            placeholder="Example: 2024-2025"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Activity / Event
                        </label>

                        <input
                            type="text"
                            name="department_activity_event"
                            placeholder="Example: Webinar: Text Web Social Media Analytics"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Department / Joint
                        </label>

                        <input
                            type="text"
                            name="department_joint"
                            placeholder="Example: IT"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Guest / Resource
                        </label>

                        <input
                            type="text"
                            name="guest_resource"
                            placeholder="Guest name / resource person"
                        >

                    </div>

                </div>

            </div>


            <!-- =================================================
                 SPORTS
            ================================================== -->

            <div
                class="category-fields"
                id="sports-fields"
            >

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Date / Duration
                        </label>

                        <input
                            type="text"
                            name="sports_date_duration"
                            placeholder="Example: 07/10/2025–08/10/2025"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Academic Year
                        </label>

                        <input
                            type="text"
                            name="sports_academic_year"
                            placeholder="Example: 2024-2025"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Sport / Event
                        </label>

                        <input
                            type="text"
                            name="sport_event"
                            placeholder="Example: Volleyball (Women)"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Student(s)
                        </label>

                        <input
                            type="text"
                            name="sports_students"
                            placeholder="Student name(s)"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Achievement / Position
                        </label>

                        <input
                            type="text"
                            name="achievement_position"
                            placeholder="Example: IV Position"
                        >

                    </div>

                </div>

            </div>


            <!-- =================================================
                 INTERNSHIP
            ================================================== -->

            <div
                class="category-fields"
                id="internship-fields"
            >

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Company / Organization
                        </label>

                        <input
                            type="text"
                            name="company_organization"
                            placeholder="Company / organization"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Project / Role
                        </label>

                        <input
                            type="text"
                            name="project_role"
                            placeholder="Project or role"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Student(s)
                        </label>

                        <input
                            type="text"
                            name="internship_students"
                            placeholder="Student name(s)"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Staff Mentor
                        </label>

                        <input
                            type="text"
                            name="staff_mentor"
                            placeholder="Staff mentor"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Duration / Notes
                        </label>

                        <input
                            type="text"
                            name="duration_notes"
                            placeholder="Example: 23-06-2025 to 07-07-2025"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Academic Year
                        </label>

                        <input
                            type="text"
                            name="internship_academic_year"
                            placeholder="Example: 2024-2025"
                        >

                    </div>

                </div>

            </div>


            <!-- =================================================
                 HACKATHON
            ================================================== -->

            <div
                class="category-fields"
                id="hackathon-fields"
            >

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Date / Duration
                        </label>

                        <input
                            type="text"
                            name="hackathon_date_duration"
                            placeholder="Example: 20/02/2025–21/02/2025"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Academic Year
                        </label>

                        <input
                            type="text"
                            name="hackathon_academic_year"
                            placeholder="Example: 2024-2025"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Event
                        </label>

                        <input
                            type="text"
                            name="hackathon_event"
                            placeholder="Example: Hack Fest 2025"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Student(s)
                        </label>

                        <input
                            type="text"
                            name="hackathon_students"
                            placeholder="Student name(s)"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Venue / Organization
                        </label>

                        <input
                            type="text"
                            name="venue_organization"
                            placeholder="Venue / organization"
                        >

                    </div>

                </div>

            </div>


            <button
                type="submit"
                name="add_achievement"
                class="add-btn"
            >
                + Add Achievement
            </button>

        </form>

    </div>



    <!-- =========================================================
         ACADEMIC ACHIEVEMENTS
    ========================================================== -->

    <div class="data-section">

        <div class="section-title">

            <h2>Academic Achievements</h2>

            <span class="count-badge">
                <?php echo $academic_result ? $academic_result->num_rows : 0; ?>
                Records
            </span>

        </div>

        <div class="table-wrapper">

            <?php if ($academic_result && $academic_result->num_rows > 0): ?>

                <table>

                    <thead>

                        <tr>
                            <th>S.No</th>
                            <th>Date / Duration</th>
                            <th>Student</th>
                            <th>Year / Department</th>
                            <th>Activity / Event</th>
                            <th>Achievement / Role</th>
                            <th>Organization / Venue</th>
                            <th>Academic Year</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $i = 1;
                    while ($row = $academic_result->fetch_assoc()):
                    ?>

                        <tr>

                            <td><?php echo $i++; ?></td>

                            <td>
                                <?php echo htmlspecialchars($row['date_duration']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['student']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['year_department']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['activity_event']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['achievement_role']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['organization_venue']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['academic_year']); ?>
                            </td>

                            <td>
                                <a
                                    class="delete-btn"
                                    href="?delete=<?php echo $row['id']; ?>&category=academic"
                                    onclick="return confirm('Delete this Academic Achievement?');"
                                >
                                    Delete
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <div class="empty">
                    No academic achievements available.
                </div>

            <?php endif; ?>

        </div>

    </div>



    <!-- =========================================================
         DEPARTMENT ACTIVITIES
    ========================================================== -->

    <div class="data-section">

        <div class="section-title">

            <h2>Department Activities</h2>

            <span class="count-badge">
                <?php echo $department_result ? $department_result->num_rows : 0; ?>
                Records
            </span>

        </div>

        <div class="table-wrapper">

            <?php if ($department_result && $department_result->num_rows > 0): ?>

                <table>

                    <thead>

                        <tr>
                            <th>S.No</th>
                            <th>Date / Duration</th>
                            <th>Activity / Event</th>
                            <th>Department / Joint</th>
                            <th>Guest / Resource</th>
                            <th>Academic Year</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $i = 1;
                    while ($row = $department_result->fetch_assoc()):
                    ?>

                        <tr>

                            <td><?php echo $i++; ?></td>

                            <td>
                                <?php echo htmlspecialchars($row['date_duration']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['activity_event']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['department_joint']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['guest_resource']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['academic_year']); ?>
                            </td>

                            <td>
                                <a
                                    class="delete-btn"
                                    href="?delete=<?php echo $row['id']; ?>&category=department"
                                    onclick="return confirm('Delete this Department Activity?');"
                                >
                                    Delete
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <div class="empty">
                    No department activities available.
                </div>

            <?php endif; ?>

        </div>

    </div>



    <!-- =========================================================
         SPORTS ACHIEVEMENTS
    ========================================================== -->

    <div class="data-section">

        <div class="section-title">

            <h2>Sports Achievements</h2>

            <span class="count-badge">
                <?php echo $sports_result ? $sports_result->num_rows : 0; ?>
                Records
            </span>

        </div>

        <div class="table-wrapper">

            <?php if ($sports_result && $sports_result->num_rows > 0): ?>

                <table>

                    <thead>

                        <tr>
                            <th>S.No</th>
                            <th>Date / Duration</th>
                            <th>Sport / Event</th>
                            <th>Student(s)</th>
                            <th>Achievement / Position</th>
                            <th>Academic Year</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $i = 1;
                    while ($row = $sports_result->fetch_assoc()):
                    ?>

                        <tr>

                            <td><?php echo $i++; ?></td>

                            <td>
                                <?php echo htmlspecialchars($row['date_duration']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['sport_event']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['students']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['achievement_position']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['academic_year']); ?>
                            </td>

                            <td>
                                <a
                                    class="delete-btn"
                                    href="?delete=<?php echo $row['id']; ?>&category=sports"
                                    onclick="return confirm('Delete this Sports Achievement?');"
                                >
                                    Delete
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <div class="empty">
                    No sports achievements available.
                </div>

            <?php endif; ?>

        </div>

    </div>



    <!-- =========================================================
         INTERNSHIP / COMPANY PROJECTS
    ========================================================== -->

    <div class="data-section">

        <div class="section-title">

            <h2>Internship / Company Projects</h2>

            <span class="count-badge">
                <?php echo $internship_result ? $internship_result->num_rows : 0; ?>
                Records
            </span>

        </div>

        <div class="table-wrapper">

            <?php if ($internship_result && $internship_result->num_rows > 0): ?>

                <table>

                    <thead>

                        <tr>
                            <th>S.No</th>
                            <th>Company / Organization</th>
                            <th>Project / Role</th>
                            <th>Student(s)</th>
                            <th>Staff Mentor</th>
                            <th>Duration / Notes</th>
                            <th>Academic Year</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $i = 1;
                    while ($row = $internship_result->fetch_assoc()):
                    ?>

                        <tr>

                            <td><?php echo $i++; ?></td>

                            <td>
                                <?php echo htmlspecialchars($row['company_organization']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['project_role']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['students']); ?>
                            </td>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $row['staff_mentor'] ?? ''
                                );
                                ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['duration_notes']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['academic_year']); ?>
                            </td>

                            <td>
                                <a
                                    class="delete-btn"
                                    href="?delete=<?php echo $row['id']; ?>&category=internship"
                                    onclick="return confirm('Delete this Internship / Company Project?');"
                                >
                                    Delete
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <div class="empty">
                    No internship / company projects available.
                </div>

            <?php endif; ?>

        </div>

    </div>



    <!-- =========================================================
         HACKATHON / EXPO / CONFERENCES
    ========================================================== -->

    <div class="data-section">

        <div class="section-title">

            <h2>Hackathon / Expo / Conferences</h2>

            <span class="count-badge">
                <?php echo $hackathon_result ? $hackathon_result->num_rows : 0; ?>
                Records
            </span>

        </div>

        <div class="table-wrapper">

            <?php if ($hackathon_result && $hackathon_result->num_rows > 0): ?>

                <table>

                    <thead>

                        <tr>
                            <th>S.No</th>
                            <th>Date / Duration</th>
                            <th>Event</th>
                            <th>Student(s)</th>
                            <th>Venue / Organization</th>
                            <th>Academic Year</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $i = 1;
                    while ($row = $hackathon_result->fetch_assoc()):
                    ?>

                        <tr>

                            <td><?php echo $i++; ?></td>

                            <td>
                                <?php echo htmlspecialchars($row['date_duration']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['event']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['students']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['venue_organization']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['academic_year']); ?>
                            </td>

                            <td>
                                <a
                                    class="delete-btn"
                                    href="?delete=<?php echo $row['id']; ?>&category=hackathon"
                                    onclick="return confirm('Delete this Hackathon / Expo / Conference?');"
                                >
                                    Delete
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            <?php else: ?>

                <div class="empty">
                    No hackathon / expo / conference records available.
                </div>

            <?php endif; ?>

        </div>

    </div>

</main>


<script>

document.addEventListener("DOMContentLoaded", function () {

    const categorySelect = document.getElementById("achievement_field");

    const categoryFields = document.querySelectorAll(".category-fields");


    function showCategory(category) {

        categoryFields.forEach(function (section) {
            section.classList.remove("active");
        });


        if (!category) {
            return;
        }


        const selectedSection =
            document.getElementById(category + "-fields");


        if (selectedSection) {
            selectedSection.classList.add("active");
        }
    }


    categorySelect.addEventListener("change", function () {

        showCategory(this.value);

    });

});

</script>

</body>
</html>