<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

$admin_name = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - NEXUS</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            background: #eee7f7;
            color: #35113f;
        }

        /* =========================
           SIDEBAR
        ========================== */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;

            background: linear-gradient(
                180deg,
                #3c064d 0%,
                #4b075f 35%,
                #68088b 75%,
                #7b1fa2 100%
            );

            color: white;
            padding: 25px 18px;

            display: flex;
            flex-direction: column;

            box-shadow: 5px 0 25px rgba(72, 7, 91, 0.25);
            z-index: 1000;
        }

        /* Logo */

        .logo {
            text-align: center;
            padding: 10px 0 30px;
        }

        .logo h1 {
            font-size: 30px;
            letter-spacing: 3px;
            font-weight: 800;
            color: #ffffff;
        }

        .logo p {
            font-size: 11px;
            margin-top: 5px;
            color: #e8c9f3;
            letter-spacing: 1.5px;
        }

        /* Navigation */

        .nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav a {
            text-decoration: none;
            color: #f3ddfa;

            padding: 13px 15px;
            border-radius: 12px;

            display: flex;
            align-items: center;
            gap: 13px;

            font-size: 14px;
            font-weight: 500;

            transition: 0.3s;
        }

        .nav a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .nav a:hover {
            background: rgba(255, 255, 255, 0.14);
            color: white;
            transform: translateX(3px);
        }

        .nav a.active {
            background: #ffffff;
            color: #5b0875;

            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        /* Logout */

        .logout {
            margin-top: auto;
        }

        .logout a {
            text-decoration: none;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            padding: 12px;

            border-radius: 10px;

            background: rgba(255,255,255,0.10);
            color: #ffffff;

            font-size: 14px;
            transition: 0.3s;
        }

        .logout a:hover {
            background: #ffffff;
            color: #68088b;
        }

        /* =========================
           MAIN
        ========================== */

        .main {
            margin-left: 250px;
            min-height: 100vh;
            padding: 30px;
        }

        /* =========================
           HEADER
        ========================== */

        .page-header {
            background: linear-gradient(
                135deg,
                #4b075f,
                #68088b,
                #8e24aa
            );

            color: white;

            border-radius: 20px;
            padding: 25px 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            box-shadow: 0 10px 30px rgba(75, 7, 95, 0.25);

            margin-bottom: 25px;
        }

        .page-header h2 {
            font-size: 26px;
            margin-bottom: 6px;
        }

        .page-header p {
            font-size: 13px;
            color: #ead5f1;
        }

        /* Admin Profile */

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;

            background: rgba(255,255,255,0.13);
            padding: 9px 15px;
            border-radius: 30px;
        }

        .admin-icon {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: white;
            color: #68088b;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 17px;
        }

        .admin-profile span {
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
           WELCOME CARD
        ========================== */

        .welcome-card {
            background: linear-gradient(
                135deg,
                #ffffff,
                #f3e5f5
            );

            border: 1px solid #d8c4e5;

            border-radius: 18px;
            padding: 25px;

            margin-bottom: 30px;

            box-shadow: 0 6px 20px rgba(72, 7, 91, 0.08);

            display: flex;
            align-items: center;
            gap: 20px;
        }

        .welcome-icon {
            width: 60px;
            height: 60px;

            border-radius: 16px;

            background: linear-gradient(
                135deg,
                #68088b,
                #8e24aa
            );

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 25px;

            box-shadow: 0 8px 18px rgba(104, 8, 139, 0.25);
        }

        .welcome-card h3 {
            color: #4b075f;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .welcome-card p {
            color: #6d5275;
            font-size: 13px;
        }

        /* =========================
           SECTION TITLE
        ========================== */

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 18px;

            color: #4b075f;
        }

        .section-title i {
            color: #68088b;
        }

        .section-title h3 {
            font-size: 19px;
        }

        /* =========================
           MANAGEMENT GRID
        ========================== */

        .management-grid {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 20px;

            margin-bottom: 30px;
        }

        /* Management Card */

        .management-card {
            position: relative;

            background: #ffffff;

            border: 1px solid #d8c4e5;

            border-radius: 18px;

            padding: 24px;

            display: flex;
            align-items: center;
            gap: 18px;

            text-decoration: none;
            color: inherit;

            overflow: hidden;

            box-shadow: 0 6px 18px rgba(72, 7, 91, 0.08);

            transition: 0.3s;
        }

        .management-card::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;

            width: 5px;
            height: 100%;

            background: linear-gradient(
                180deg,
                #4b075f,
                #9c27b0
            );
        }

        .management-card:hover {
            transform: translateY(-5px);

            box-shadow: 0 12px 28px rgba(72, 7, 91, 0.18);

            border-color: #b98acb;
        }

        /* Icon */

        .management-icon {
            min-width: 58px;
            height: 58px;

            border-radius: 15px;

            background: linear-gradient(
                135deg,
                #eee0f4,
                #e4c8ed
            );

            color: #68088b;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;
        }

        .management-card:hover .management-icon {
            background: linear-gradient(
                135deg,
                #68088b,
                #8e24aa
            );

            color: white;
        }

        /* Text */

        .management-content {
            flex: 1;
        }

        .management-content h4 {
            color: #4b075f;
            font-size: 17px;
            margin-bottom: 5px;
        }

        .management-content p {
            color: #765d7d;
            font-size: 12px;
            line-height: 1.5;
        }

        .arrow {
            color: #68088b;
            font-size: 15px;
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 1000px) {

            .sidebar {
                width: 220px;
            }

            .main {
                margin-left: 220px;
            }

            .management-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 750px) {

            .sidebar {
                position: relative;

                width: 100%;
                height: auto;

                padding: 15px;
            }

            .logo {
                padding: 5px 0 15px;
            }

            .nav {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .nav a {
                flex: 1;
                min-width: 130px;
                justify-content: center;
            }

            .logout {
                margin-top: 15px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .admin-profile {
                width: 100%;
            }
        }

        @media (max-width: 500px) {

            .main {
                padding: 15px;
            }

            .page-header {
                padding: 20px;
                border-radius: 15px;
            }

            .page-header h2 {
                font-size: 22px;
            }

            .welcome-card {
                padding: 20px;
            }

            .management-card {
                padding: 18px;
            }

            .management-icon {
                min-width: 48px;
                height: 48px;
                font-size: 19px;
            }

            .management-content h4 {
                font-size: 15px;
            }
        }

    </style>
</head>

<body>

<!-- =========================
     SIDEBAR
========================== -->

<aside class="sidebar">

    <div class="logo">
        <h1>NEXUS</h1>
        <p>ADMIN PANEL</p>
    </div>

    <nav class="nav">

        <a href="dashboard.php" class="active">
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

        <a href="gallery.php">
            <i class="fa-solid fa-images"></i>
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


<!-- =========================
     MAIN CONTENT
========================== -->

<main class="main">

    <!-- Header -->

    <div class="page-header">

        <div>
            <h2>Admin Dashboard</h2>

            <p>
                Manage your NEXUS website content from one place.
            </p>
        </div>

        <div class="admin-profile">

            <div class="admin-icon">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <span>
                <?= htmlspecialchars($admin_name) ?>
            </span>

        </div>

    </div>


    <!-- Welcome -->

    <div class="welcome-card">

        <div class="welcome-icon">
            <i class="fa-solid fa-hand-sparkles"></i>
        </div>

        <div>

            <h3>
                Welcome, <?= htmlspecialchars($admin_name) ?>!
            </h3>

            <p>
                Use the management sections below to update your
                NEXUS website content.
            </p>

        </div>

    </div>


    <!-- Management -->

    <div class="section-title">

        <i class="fa-solid fa-layer-group"></i>

        <h3>Content Management</h3>

    </div>


    <div class="management-grid">

        <!-- Achievements -->

        <a href="achievements.php" class="management-card">

            <div class="management-icon">
                <i class="fa-solid fa-trophy"></i>
            </div>

            <div class="management-content">

                <h4>Achievements</h4>

                <p>
                    Add and manage student achievements,
                    awards and academic activities.
                </p>

            </div>

            <div class="arrow">
                <i class="fa-solid fa-chevron-right"></i>
            </div>

        </a>


        <!-- Events -->

        <a href="events.php" class="management-card">

            <div class="management-icon">
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div class="management-content">

                <h4>Events</h4>

                <p>
                    Create and manage department events
                    and important activities.
                </p>

            </div>

            <div class="arrow">
                <i class="fa-solid fa-chevron-right"></i>
            </div>

        </a>


        <!-- Gallery -->

        <a href="gallery.php" class="management-card">

            <div class="management-icon">
                <i class="fa-solid fa-images"></i>
            </div>

            <div class="management-content">

                <h4>Gallery</h4>

                <p>
                    Upload and manage event photos
                    and department gallery collections.
                </p>

            </div>

            <div class="arrow">
                <i class="fa-solid fa-chevron-right"></i>
            </div>

        </a>

    </div>

</main>

</body>
</html>