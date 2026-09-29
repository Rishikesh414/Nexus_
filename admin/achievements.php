<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require_once "../server/config/db.php";

$message = "";
$error = "";

/*
|--------------------------------------------------------------------------
| DELETE ACHIEVEMENT
|--------------------------------------------------------------------------
*/
if (isset($_GET['delete'])) {

    $delete_id = intval($_GET['delete']);

    if ($delete_id > 0) {

        $stmt = $conn->prepare("DELETE FROM academic_achievements WHERE id = ?");

        if ($stmt) {

            $stmt->bind_param("i", $delete_id);

            if ($stmt->execute()) {
                $message = "Achievement deleted successfully!";
            } else {
                $error = "Failed to delete achievement.";
            }

            $stmt->close();

        } else {
            $error = "Database error: " . $conn->error;
        }
    }
}

/*
|--------------------------------------------------------------------------
| ADD ACHIEVEMENT
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_achievement'])) {

    $date_duration    = trim($_POST['date_duration'] ?? '');
    $student          = trim($_POST['student'] ?? '');
    $year_department  = trim($_POST['year_department'] ?? '');
    $activity_event   = trim($_POST['activity_event'] ?? '');
    $achievement_role = trim($_POST['achievement_role'] ?? '');
    $organization     = trim($_POST['organization_venue'] ?? '');
    $academic_year    = trim($_POST['academic_year'] ?? '');

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
| FETCH ACHIEVEMENTS
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

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f7f1fa;
        color: #333;
    }

    .admin-page {
        min-height: 100vh;
        padding: 30px;
    }

    .page-container {
        max-width: 1350px;
        margin: auto;
    }

    /* =========================
       TOP BAR
    ========================= */

    .topbar {
        background: #ffffff;
        padding: 20px 25px;
        border-radius: 16px;

        display: flex;
        justify-content: space-between;
        align-items: center;

        margin-bottom: 25px;

        border: 1px solid #eadcf0;

        box-shadow: 0 5px 18px rgba(104, 8, 139, 0.07);
    }

    .topbar h1 {
        margin: 0 0 5px;
        color: #7b2c91;
        font-size: 28px;
    }

    .topbar p {
        margin: 0;
        color: #777;
        font-size: 14px;
    }

    .back-btn {
        text-decoration: none;
        color: #ffffff;
        background: #a85bbb;

        padding: 11px 18px;
        border-radius: 9px;

        font-weight: bold;

        transition: 0.2s;
    }

    .back-btn:hover {
        background: #9146a5;
    }

    /* =========================
       MESSAGES
    ========================= */

    .success-message {
        background: #eaf8ef;
        color: #238443;

        padding: 14px 18px;
        border-radius: 10px;

        margin-bottom: 20px;

        font-weight: bold;
        border: 1px solid #c9ecd5;
    }

    .error-message {
        background: #fff0f0;
        color: #c62828;

        padding: 14px 18px;
        border-radius: 10px;

        margin-bottom: 20px;

        font-weight: bold;
        border: 1px solid #ffd0d0;
    }

    /* =========================
       FORM CARD
    ========================= */

    .form-card,
    .list-card {
        background: #ffffff;

        padding: 28px;

        border-radius: 16px;

        border: 1px solid #eadcf0;

        box-shadow: 0 5px 18px rgba(104, 8, 139, 0.07);
    }

    .form-card {
        margin-bottom: 25px;
    }

    .form-card h2,
    .list-card h2 {
        margin: 0 0 22px;
        color: #7b2c91;
        font-size: 21px;
    }

    /* =========================
       FORM
    ========================= */

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
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
        margin-bottom: 7px;

        font-weight: 600;
        color: #444;

        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {

        width: 100%;

        padding: 12px 13px;

        border: 1px solid #ddd1e3;

        border-radius: 8px;

        font-size: 14px;

        outline: none;

        font-family: Arial, sans-serif;

        background: #fff;

        transition: 0.2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {

        border-color: #b66ac5;

        box-shadow: 0 0 0 3px rgba(182, 106, 197, 0.12);
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* =========================
       ADD BUTTON
    ========================= */

    .submit-btn {

        margin-top: 20px;

        padding: 12px 22px;

        border: none;

        border-radius: 8px;

        background: #a85bbb;

        color: white;

        font-size: 14px;

        font-weight: bold;

        cursor: pointer;

        transition: 0.2s;
    }

    .submit-btn:hover {
        background: #9146a5;
        transform: translateY(-1px);
    }

    /* =========================
       TABLE
    ========================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;

        min-width: 1100px;

        overflow: hidden;
    }

    table th {

        background: #f0e1f5;

        color: #6e267f;

        padding: 13px 14px;

        text-align: left;

        font-size: 13px;

        font-weight: 700;

        border-bottom: 2px solid #e2cde8;
    }

    table th:first-child {
        border-radius: 8px 0 0 0;
    }

    table th:last-child {
        border-radius: 0 8px 0 0;
    }

    table td {

        padding: 13px 14px;

        border-bottom: 1px solid #eee6f1;

        color: #444;

        font-size: 13px;

        vertical-align: middle;

        background: #ffffff;
    }

    table tbody tr:hover td {
        background: #fcf8fd;
    }

    /* =========================
       ID BADGE
    ========================= */

    .id-badge {

        display: inline-block;

        background: #f1e4f5;

        color: #7b2c91;

        padding: 5px 9px;

        border-radius: 6px;

        font-weight: bold;

        font-size: 12px;
    }

    /* =========================
       DELETE BUTTON
    ========================= */

    .delete-btn {

        display: inline-block;

        text-decoration: none;

        background: #fff0f0;

        color: #d13c3c;

        border: 1px solid #f1caca;

        padding: 7px 11px;

        border-radius: 7px;

        font-size: 12px;

        font-weight: bold;

        white-space: nowrap;

        transition: 0.2s;
    }

    .delete-btn:hover {

        background: #d13c3c;

        color: #ffffff;

        border-color: #d13c3c;
    }

    /* =========================
       EMPTY
    ========================= */

    .empty-message {

        padding: 30px;

        text-align: center;

        color: #777;

        background: #faf6fc;

        border: 1px dashed #dfcce5;

        border-radius: 10px;
    }

    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 700px) {

        .admin-page {
            padding: 15px;
        }

        .topbar {

            flex-direction: column;

            align-items: flex-start;

            gap: 15px;
        }

        .topbar h1 {
            font-size: 23px;
        }

        .back-btn {
            width: 100%;
            text-align: center;
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


    <!-- SUCCESS -->

    <?php if ($message): ?>

        <div class="success-message">
            <?= htmlspecialchars($message) ?>
        </div>

    <?php endif; ?>


    <!-- ERROR -->

    <?php if ($error): ?>

        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <!-- ADD ACHIEVEMENT -->

    <div class="form-card">

        <h2>➕ Add New Achievement</h2>

        <form method="POST">

            <div class="form-grid">

                <div class="form-group">

                    <label>Date / Duration</label>

                    <input
                        type="text"
                        name="date_duration"
                        placeholder="Example: 15 March 2026"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Student Name</label>

                    <input
                        type="text"
                        name="student"
                        placeholder="Enter student name"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Year / Department</label>

                    <input
                        type="text"
                        name="year_department"
                        placeholder="Example: III Year - CSE"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Academic Year</label>

                    <input
                        type="text"
                        name="academic_year"
                        value="2025-2026"
                        placeholder="Example: 2025-2026"
                        required
                    >

                </div>


                <div class="form-group full">

                    <label>Activity / Event</label>

                    <input
                        type="text"
                        name="activity_event"
                        placeholder="Example: Hackathon, Paper Presentation, Sports Meet"
                        required
                    >

                </div>


                <div class="form-group full">

                    <label>Achievement / Role</label>

                    <input
                        type="text"
                        name="achievement_role"
                        placeholder="Example: First Prize / Winner / Participant"
                        required
                    >

                </div>


                <div class="form-group full">

                    <label>Organization / Venue</label>

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
                name="add_achievement"
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

                            <th>Action</th>

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

                            <td>

                                <a
                                    href="?delete=<?= (int)$row['id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this achievement?');"
                                >
                                    🗑 Delete
                                </a>

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
