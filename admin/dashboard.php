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

    <link rel="stylesheet" href="css/admin.css">

    <style>
        .dashboard-wrapper {
            width: 100%;
            min-height: 100vh;
            padding: 30px;
        }

        .topbar {
            max-width: 1200px;
            margin: 0 auto 30px;
            background: white;
            border-radius: 18px;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .topbar h1 {
            color: #68088b;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;
        }

        .logout-btn {
            text-decoration: none;
            background: #68088b;
            color: white;
            padding: 11px 18px;
            border-radius: 9px;
            font-weight: bold;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: auto;
        }

        .welcome-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .welcome-card h2 {
            color: #68088b;
            margin-bottom: 8px;
        }

        .welcome-card p {
            color: #666;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .menu-card {
            background: white;
            padding: 30px 25px;
            border-radius: 18px;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-6px);
        }

        .menu-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: #f2e5f7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .menu-card h3 {
            color: #68088b;
            margin-bottom: 8px;
        }

        .menu-card p {
            color: #777;
            line-height: 1.5;
        }

        @media (max-width: 800px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="dashboard-wrapper">

    <!-- TOP BAR -->
    <div class="topbar">

        <div>
            <h1>NEXUS Admin</h1>
            <p>Administration Panel</p>
        </div>

        <a href="logout.php" class="logout-btn">
            Logout
        </a>

    </div>


    <div class="dashboard-content">

        <!-- WELCOME -->
        <div class="welcome-card">

            <h2>Welcome, <?= htmlspecialchars($admin_name) ?> 👋</h2>

            <p>
                Manage achievements, events and gallery content from this panel.
            </p>

        </div>


        <!-- MENU -->
        <div class="menu-grid">

            <!-- ACHIEVEMENTS -->
            <a href="achievements.php" class="menu-card">

                <div class="menu-icon">
                    🏆
                </div>

                <h3>Achievements</h3>

                <p>
                    Add and manage student achievements
                    that will appear on the frontend.
                </p>

            </a>


            <!-- EVENTS -->
            <a href="events.php" class="menu-card">

                <div class="menu-icon">
                    📅
                </div>

                <h3>Events</h3>

                <p>
                    Add and manage department events
                    and activities.
                </p>

            </a>


            <!-- GALLERY -->
            <a href="gallery.php" class="menu-card">

                <div class="menu-icon">
                    🖼️
                </div>

                <h3>Gallery</h3>

                <p>
                    Upload and manage images
                    displayed in the gallery.
                </p>

            </a>

        </div>

    </div>

</div>

</body>
</html>