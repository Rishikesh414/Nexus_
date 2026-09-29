<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/
require_once "../server/config/db.php";

$message = "";
$error = "";

/*
|--------------------------------------------------------------------------
| Add Achievement
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $date_duration     = trim($_POST['date_duration'] ?? '');
    $student           = trim($_POST['student'] ?? '');
    $year_department   = trim($_POST['year_department'] ?? '');
    $activity_event    = trim($_POST['activity_event'] ?? '');
    $achievement_role  = trim($_POST['achievement_role'] ?? '');
    $organization      = trim($_POST['organization_venue'] ?? '');
    $academic_year     = trim($_POST['academic_year'] ?? '');

    if (
        $date_duration === "" ||
        $student === "" ||
        $year_department === "" ||
        $activity_event === "" ||
        $achievement_role === "" ||
        $organization === "" ||
        $academic_year === ""
    ) {

        $error = "Please fill all the fields.";

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

                $message = "Achievement added successfully!";

            } else {

                $error = "Failed to add achievement: " . $stmt->error;
            }

            $stmt->close();

        } else {

            $error = "Database error: " . $conn->error;
        }
    }
}

/*
|--------------------------------------------------------------------------
| Fetch Existing Achievements
|--------------------------------------------------------------------------
*/
$result = $conn->query("
    SELECT *
    FROM academic_achievements
    ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Achievements - NEXUS Admin</title>

    <link rel="stylesheet" href="css/admin.css">

    <style>

        body {
            background: #f5f1f7;
        }

        .admin-page {
            min-height: 100vh;
            padding: 30px;
        }

        .page-container {
            max-width: 1250px;
            margin: auto;
        }

        /* TOP BAR */

        .topbar {
            background: white;
            padding: 20px 25px;
            border-radius: 18px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 25px;

            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .topbar h1 {
            color: #68088b;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            background: #68088b;

            padding: 11px 18px;
            border-radius: 9px;

            font-weight: bold;
        }

        .back-btn:hover {
            background: #52066e;
        }

        /* MESSAGE */

        .success-message {
            background: #e7f8ec;
            color: #218838;

            padding: 14px 18px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-weight: bold;
        }

        .error-message {
            background: #ffe5e5;
            color: #c62828;

            padding: 14px 18px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-weight: bold;
        }

        /* FORM CARD */

        .form-card {
            background: white;

            padding: 30px;

            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,0.08);

            margin-bottom: 25px;
        }

        .form-card h2 {
            color: #68088b;

            margin-bottom: 25px;
        }

        .form-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;
        }

        .form-group {
            display: flex;

            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            margin-bottom: 8px;

            font-weight: bold;

            color: #333;
        }

        .form-group input,
        .form-group textarea {

            padding: 13px;

            border: 1px solid #ddd;

            border-radius: 9px;

            font-size: 15px;

            outline: none;

            font-family: Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {

            border-color: #68088b;

            box-shadow: 0 0 0 3px rgba(104, 8, 139, 0.08);
        }

        .form-group textarea {

            min-height: 100px;

            resize: vertical;
        }

        .submit-btn {

            margin-top: 20px;

            padding: 13px 25px;

            border: none;

            border-radius: 9px;

            background: #68088b;

            color: white;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;
        }

        .submit-btn:hover {

            background: #52066e;

            transform: translateY(-1px);
        }

        /* LIST CARD */

        .list-card {

            background: white;

            padding: 30px;

            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .list-card h2 {

            color: #68088b;

            margin-bottom: 20px;
        }

        /* TABLE */

        .table-wrapper {

            width: 100%;

            overflow-x: auto;
        }

        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 1000px;
        }

        table th {

            background: #68088b;

            color: white;

            padding: 14px;

            text-align: left;

            font-size: 14px;
        }

        table td {

            padding: 13px 14px;

            border-bottom: 1px solid #eee;

            color: #444;

            font-size: 14px;

            vertical-align: top;
        }

        table tr:hover {

            background: #faf7fb;
        }

        .empty-message {

            padding: 30px;

            text-align: center;

            color: #777;

            background: #faf7fb;

            border-radius: 10px;
        }

        .id-badge {

            background: #f0e4f4;

            color: #68088b;

            padding: 5px 9px;

            border-radius: 6px;

            font-weight: bold;
        }

        /* MOBILE */

        @media (max-width: 700px) {

            .admin-page {

                padding: 15px;
            }

            .topbar {

                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

            .form-grid {

                grid-template-columns: 1fr;
            }

            .form-group.full {

                grid-column: auto;
            }

            .form-card,
            .list-card {

                padding: 20px;
            }

        }

    </style>

</head>

<body>

<div class="admin-page">

    <div class="page-container">

        <!-- TOP BAR -->

        <div class="topbar">

            <div>

                <h1>🏆 Achievements</h1>

                <p>Manage student achievements</p>

            </div>

            <a href="dashboard.php" class="back-btn">
                ← Dashboard
            </a>

        </div>


        <!-- SUCCESS MESSAGE -->

        <?php if ($message): ?>

            <div class="success-message">
                <?= htmlspecialchars($message) ?>
            </div>

        <?php endif; ?>


        <!-- ERROR MESSAGE -->

        <?php if ($error): ?>

            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <!-- ADD ACHIEVEMENT FORM -->

        <div class="form-card">

            <h2>➕ Add New Achievement</h2>

            <form method="POST">

                <div class="form-grid">

                    <!-- DATE -->

                    <div class="form-group">

                        <label>
                            Date / Duration
                        </label>

                        <input
                            type="text"
                            name="date_duration"
                            placeholder="Example: 15 March 2026"
                            required
                        >

                    </div>


                    <!-- STUDENT -->

                    <div class="form-group">

                        <label>
                            Student Name
                        </label>

                        <input
                            type="text"
                            name="student"
                            placeholder="Enter student name"
                            required
                        >

                    </div>


                    <!-- YEAR / DEPARTMENT -->

                    <div class="form-group">

                        <label>
                            Year / Department
                        </label>

                        <input
                            type="text"
                            name="year_department"
                            placeholder="Example: III Year - CSE"
                            required
                        >

                    </div>


                    <!-- ACADEMIC YEAR -->

                    <div class="form-group">

                        <label>
                            Academic Year
                        </label>

                        <input
                            type="text"
                            name="academic_year"
                            value="2025-2026"
                            placeholder="Example: 2025-2026"
                            required
                        >

                    </div>


                    <!-- ACTIVITY / EVENT -->

                    <div class="form-group full">

                        <label>
                            Activity / Event
                        </label>

                        <input
                            type="text"
                            name="activity_event"
                            placeholder="Example: Hackathon, Paper Presentation, Sports Meet"
                            required
                        >

                    </div>


                    <!-- ACHIEVEMENT / ROLE -->

                    <div class="form-group full">

                        <label>
                            Achievement / Role
                        </label>

                        <input
                            type="text"
                            name="achievement_role"
                            placeholder="Example: First Prize / Winner / Participant"
                            required
                        >

                    </div>


                    <!-- ORGANIZATION -->

                    <div class="form-group full">

                        <label>
                            Organization / Venue
                        </label>

                        <input
                            type="text"
                            name="organization_venue"
                            placeholder="Enter organization or venue"
                            required
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="submit-btn"
                >
                    + Add Achievement
                </button>

            </form>

        </div>


        <!-- EXISTING ACHIEVEMENTS -->

        <div class="list-card">

            <h2>📋 Existing Achievements</h2>

            <?php if ($result && $result->num_rows > 0): ?>

                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Date / Duration</th>

                                <th>Student</th>

                                <th>Year / Department</th>

                                <th>Activity / Event</th>

                                <th>Achievement / Role</th>

                                <th>Organization / Venue</th>

                                <th>Academic Year</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php while ($row = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <span class="id-badge">
                                        <?= htmlspecialchars($row['id']) ?>
                                    </span>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['date_duration']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['student']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['year_department']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['activity_event']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['achievement_role']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['organization_venue']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['academic_year']) ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="empty-message">

                    No achievements found.

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

</body>

</html>