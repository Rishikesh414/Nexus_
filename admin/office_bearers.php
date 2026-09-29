<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require_once "../server/config/db.php";

$message = "";
$message_type = "";


/* =====================================================
   ADD OFFICE BEARER
===================================================== */

if (isset($_POST['add_bearer'])) {

    $name = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $academic_year = trim($_POST['academic_year'] ?? '');

    $photo_path = NULL;

    if ($name === "" || $position === "") {

        $message = "Name and Position are required.";
        $message_type = "error";

    } else {

        /* =========================
           PHOTO UPLOAD
        ========================== */

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {

            $upload_dir = "../uploads/office_bearers/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = $_FILES['photo']['name'];
            $tmp_name = $_FILES['photo']['tmp_name'];

            $extension = strtolower(
                pathinfo($file_name, PATHINFO_EXTENSION)
            );

            $allowed_extensions = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];

            if (!in_array($extension, $allowed_extensions)) {

                $message = "Only JPG, JPEG, PNG and WEBP images are allowed.";
                $message_type = "error";

            } else {

                $new_file_name =
                    time() . "_" .
                    uniqid() . "." .
                    $extension;

                $destination =
                    $upload_dir . $new_file_name;

                if (move_uploaded_file($tmp_name, $destination)) {

                    $photo_path =
                        "uploads/office_bearers/" .
                        $new_file_name;

                } else {

                    $message = "Photo upload failed.";
                    $message_type = "error";
                }
            }
        }


        /* =========================
           INSERT DATA
        ========================== */

        if ($message_type !== "error") {

            $stmt = $conn->prepare(
                "INSERT INTO office_bearers
                (name, position, department, academic_year, photo)
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssss",
                $name,
                $position,
                $department,
                $academic_year,
                $photo_path
            );

            if ($stmt->execute()) {

                $message = "Office bearer added successfully.";
                $message_type = "success";

            } else {

                $message = "Failed to add office bearer.";
                $message_type = "error";
            }

            $stmt->close();
        }
    }
}


/* =====================================================
   DELETE OFFICE BEARER
===================================================== */

if (isset($_POST['delete_bearer'])) {

    $id = (int)($_POST['bearer_id'] ?? 0);

    if ($id > 0) {

        /* Get photo before deleting */

        $stmt = $conn->prepare(
            "SELECT photo FROM office_bearers WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $bearer = $result->fetch_assoc();

        $stmt->close();


        /* Delete database record */

        $stmt = $conn->prepare(
            "DELETE FROM office_bearers WHERE id = ?"
        );

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {

            /* Delete photo */

            if (!empty($bearer['photo'])) {

                $photo_file = "../" . $bearer['photo'];

                if (file_exists($photo_file)) {
                    unlink($photo_file);
                }
            }

            $message = "Office bearer deleted successfully.";
            $message_type = "success";

        } else {

            $message = "Failed to delete office bearer.";
            $message_type = "error";
        }

        $stmt->close();
    }
}


/* =====================================================
   FETCH OFFICE BEARERS
===================================================== */

$result = $conn->query(
    "SELECT *
     FROM office_bearers
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Office Bearers - NEXUS</title>

    <!-- Font Awesome -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>

/* =====================================================
   RESET
===================================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;
}


/* =====================================================
   BODY
===================================================== */

body {

    background: #eee7f7;

    color: #35113f;
}


/* =====================================================
   SIDEBAR
===================================================== */

.sidebar {

    position: fixed;

    left: 0;
    top: 0;

    width: 250px;
    height: 100vh;

    background:
        linear-gradient(
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

    box-shadow:
        5px 0 25px
        rgba(72, 7, 91, 0.25);

    z-index: 1000;
}


/* LOGO */

.logo {

    text-align: center;

    padding:
        10px 0 30px;
}

.logo h1 {

    font-size: 30px;

    letter-spacing: 3px;

    font-weight: 800;

    color: white;
}

.logo p {

    font-size: 11px;

    margin-top: 5px;

    color: #e8c9f3;

    letter-spacing: 1.5px;
}


/* NAV */

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

    background:
        rgba(255,255,255,0.14);

    color: white;

    transform:
        translateX(3px);
}


/* ACTIVE */

.nav a.active {

    background: white;

    color: #5b0875;

    box-shadow:
        0 6px 18px
        rgba(0,0,0,0.15);
}


/* LOGOUT */

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

    background:
        rgba(255,255,255,0.10);

    color: white;

    font-size: 14px;

    transition: 0.3s;
}

.logout a:hover {

    background: white;

    color: #68088b;
}


/* =====================================================
   MAIN
===================================================== */

.main {

    margin-left: 250px;

    min-height: 100vh;

    padding: 30px;
}


/* =====================================================
   PAGE HEADER
===================================================== */

.page-header {

    background:
        linear-gradient(
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

    box-shadow:
        0 10px 30px
        rgba(75, 7, 95, 0.25);

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


/* =====================================================
   ADMIN PROFILE
===================================================== */

.admin-profile {

    display: flex;

    align-items: center;

    gap: 12px;

    background:
        rgba(255,255,255,0.13);

    padding:
        9px 15px;

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
}

.admin-profile span {

    font-size: 13px;

    font-weight: 600;
}


/* =====================================================
   MESSAGE
===================================================== */

.message {

    padding: 14px 18px;

    border-radius: 12px;

    margin-bottom: 20px;

    font-size: 13px;

    font-weight: 500;
}

.message.success {

    background: #e8f7ed;

    color: #166534;

    border:
        1px solid #b7e4c7;
}

.message.error {

    background: #fdecec;

    color: #b42318;

    border:
        1px solid #f5c2c0;
}


/* =====================================================
   ADD FORM CARD
===================================================== */

.form-card {

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #f3e5f5
        );

    border:
        1px solid #d8c4e5;

    border-radius: 18px;

    padding: 25px;

    margin-bottom: 30px;

    box-shadow:
        0 6px 20px
        rgba(72, 7, 91, 0.08);
}

.form-title {

    display: flex;

    align-items: center;

    gap: 10px;

    color: #4b075f;

    margin-bottom: 20px;
}

.form-title i {

    color: #68088b;
}

.form-title h3 {

    font-size: 19px;
}


/* FORM GRID */

.form-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 18px;
}

.form-group {

    display: flex;

    flex-direction: column;

    gap: 7px;
}

.form-group.full {

    grid-column:
        1 / -1;
}

.form-group label {

    font-size: 13px;

    font-weight: 600;

    color: #4b075f;
}

.form-group input {

    width: 100%;

    padding: 12px 14px;

    border:
        1px solid #d5c1df;

    border-radius: 10px;

    background: white;

    color: #35113f;

    outline: none;

    font-size: 13px;

    transition: 0.3s;
}

.form-group input:focus {

    border-color: #68088b;

    box-shadow:
        0 0 0 3px
        rgba(104,8,139,0.10);
}


/* FILE */

.form-group input[type="file"] {

    padding: 10px;

    background: #faf7fc;
}


/* ADD BUTTON */

.add-btn {

    margin-top: 20px;

    border: none;

    background:
        linear-gradient(
            135deg,
            #68088b,
            #8e24aa
        );

    color: white;

    padding:
        12px 22px;

    border-radius: 10px;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.3s;

    box-shadow:
        0 5px 15px
        rgba(104,8,139,0.20);
}

.add-btn:hover {

    background:
        linear-gradient(
            135deg,
            #4b075f,
            #68088b
        );

    transform:
        translateY(-2px);
}


/* =====================================================
   LIST HEADER
===================================================== */

.list-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 18px;
}

.list-header h3 {

    color: #4b075f;

    font-size: 19px;
}

.list-header span {

    background:
        #e4cbed;

    color:
        #68088b;

    padding:
        6px 12px;

    border-radius:
        20px;

    font-size:
        12px;

    font-weight:
        600;
}


/* =====================================================
   BEARER GRID
===================================================== */

.bearer-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 20px;
}


/* CARD */

.bearer-card {

    background: white;

    border:
        1px solid #d8c4e5;

    border-radius: 18px;

    overflow: hidden;

    box-shadow:
        0 6px 18px
        rgba(72,7,91,0.08);

    transition: 0.3s;

    position: relative;
}

.bearer-card:hover {

    transform:
        translateY(-5px);

    box-shadow:
        0 12px 28px
        rgba(72,7,91,0.16);
}


/* PHOTO */

.bearer-photo {

    width: 100%;

    height: 220px;

    background:
        linear-gradient(
            135deg,
            #eee0f4,
            #e4c8ed
        );

    display: flex;

    align-items: center;

    justify-content: center;

    overflow: hidden;
}

.bearer-photo img {

    width: 100%;
    height: 100%;

    object-fit: cover;
}

.no-photo {

    font-size: 55px;

    color: #68088b;
}


/* DETAILS */

.bearer-details {

    padding: 20px;
}

.bearer-details h4 {

    color: #4b075f;

    font-size: 17px;

    margin-bottom: 8px;
}

.position {

    display: inline-block;

    background:
        #eee0f4;

    color:
        #68088b;

    padding:
        6px 10px;

    border-radius:
        20px;

    font-size:
        11px;

    font-weight:
        600;

    margin-bottom:
        12px;
}

.detail {

    display: flex;

    align-items: center;

    gap: 9px;

    color: #765d7d;

    font-size: 12px;

    margin-top: 7px;
}

.detail i {

    color: #68088b;

    width: 15px;

    text-align: center;
}


/* DELETE */

.delete-form {

    padding:
        0 20px 20px;
}

.delete-btn {

    width: 100%;

    border:
        1px solid #efb4b4;

    background:
        #fff3f3;

    color:
        #b42318;

    padding:
        9px;

    border-radius:
        9px;

    font-size:
        12px;

    font-weight:
        600;

    cursor: pointer;

    transition: 0.3s;
}

.delete-btn:hover {

    background:
        #b42318;

    color: white;
}


/* =====================================================
   EMPTY STATE
===================================================== */

.empty {

    background: white;

    border:
        1px solid #d8c4e5;

    border-radius: 18px;

    padding: 50px 20px;

    text-align: center;

    box-shadow:
        0 6px 18px
        rgba(72,7,91,0.06);
}

.empty i {

    font-size: 45px;

    color: #b98acb;

    margin-bottom: 15px;
}

.empty h3 {

    color: #4b075f;

    margin-bottom: 7px;
}

.empty p {

    color: #765d7d;

    font-size: 13px;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1100px) {

    .bearer-grid {

        grid-template-columns:
            repeat(2, 1fr);
    }
}


@media (max-width: 900px) {

    .sidebar {

        width: 220px;
    }

    .main {

        margin-left: 220px;
    }

    .form-grid {

        grid-template-columns: 1fr;
    }

    .form-group.full {

        grid-column:
            auto;
    }
}


@media (max-width: 700px) {

    .sidebar {

        position: relative;

        width: 100%;
        height: auto;

        padding: 15px;
    }

    .logo {

        padding:
            5px 0 15px;
    }

    .nav {

        flex-direction: row;

        flex-wrap: wrap;
    }

    .nav a {

        flex: 1;

        min-width: 130px;

        justify-content:
            center;
    }

    .logout {

        margin-top: 15px;
    }

    .main {

        margin-left: 0;

        padding: 20px;
    }

    .page-header {

        flex-direction:
            column;

        align-items:
            flex-start;

        gap: 15px;
    }

    .admin-profile {

        width: 100%;
    }

    .bearer-grid {

        grid-template-columns: 1fr;
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

    .form-card {

        padding: 18px;
    }

    .bearer-details {

        padding: 17px;
    }
}

</style>

</head>


<body>


<!-- =====================================================
     SIDEBAR
===================================================== -->

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


        <a href="office_bearers.php"
           class="active">

            <i class="fa-solid fa-users"></i>

            <span>Office Bearers</span>

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



<!-- =====================================================
     MAIN
===================================================== -->

<main class="main">


    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h2>Office Bearers</h2>

            <p>
                Manage NEXUS office bearers and their details.
            </p>

        </div>


        <div class="admin-profile">

            <div class="admin-icon">

                <i class="fa-solid fa-user-shield"></i>

            </div>

            <span>

                <?= htmlspecialchars(
                    $_SESSION['admin_username'] ?? 'Admin'
                ) ?>

            </span>

        </div>

    </div>



    <!-- MESSAGE -->

    <?php if ($message !== ""): ?>

        <div class="message <?= $message_type ?>">

            <i class="fa-solid
                <?= $message_type === 'success'
                    ? 'fa-circle-check'
                    : 'fa-circle-exclamation'
                ?>">
            </i>

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>



    <!-- =================================================
         ADD FORM
    ================================================== -->

    <div class="form-card">

        <div class="form-title">

            <i class="fa-solid fa-user-plus"></i>

            <h3>Add Office Bearer</h3>

        </div>


        <form method="POST"
              enctype="multipart/form-data">


            <div class="form-grid">


                <!-- NAME -->

                <div class="form-group">

                    <label>
                        Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter name"
                        required
                    >

                </div>


                <!-- POSITION -->

                <div class="form-group">

                    <label>
                        Position *
                    </label>

                    <input
                        type="text"
                        name="position"
                        placeholder="Eg: President"
                        required
                    >

                </div>


                <!-- DEPARTMENT -->

                <div class="form-group">

                    <label>
                        Department
                    </label>

                    <input
                        type="text"
                        name="department"
                        placeholder="Eg: Computer Science"
                    >

                </div>


                <!-- YEAR -->

                <div class="form-group">

                    <label>
                        Academic Year
                    </label>

                    <input
                        type="text"
                        name="academic_year"
                        placeholder="Eg: 2025 - 2026"
                    >

                </div>


                <!-- PHOTO -->

                <div class="form-group full">

                    <label>
                        Photo
                    </label>

                    <input
                        type="file"
                        name="photo"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                </div>

            </div>


            <button
                type="submit"
                name="add_bearer"
                class="add-btn">

                <i class="fa-solid fa-plus"></i>

                Add Office Bearer

            </button>

        </form>

    </div>



    <!-- =================================================
         LIST
    ================================================== -->

    <div class="list-header">

        <h3>

            <i class="fa-solid fa-users"></i>

            Office Bearers

        </h3>


        <?php

        $count_result =
            $conn->query(
                "SELECT COUNT(*) AS total
                 FROM office_bearers"
            );

        $count_data =
            $count_result->fetch_assoc();

        ?>

        <span>

            <?= (int)$count_data['total'] ?>

            Members

        </span>

    </div>



    <?php if ($result && $result->num_rows > 0): ?>


        <div class="bearer-grid">


            <?php while ($row = $result->fetch_assoc()): ?>


                <div class="bearer-card">


                    <!-- PHOTO -->

                    <div class="bearer-photo">

                        <?php if (!empty($row['photo'])): ?>

                            <img
                                src="../<?= htmlspecialchars(
                                    $row['photo']
                                ) ?>"
                                alt="<?= htmlspecialchars(
                                    $row['name']
                                ) ?>"
                            >

                        <?php else: ?>

                            <div class="no-photo">

                                <i class="fa-solid fa-user"></i>

                            </div>

                        <?php endif; ?>

                    </div>



                    <!-- DETAILS -->

                    <div class="bearer-details">

                        <h4>

                            <?= htmlspecialchars(
                                $row['name']
                            ) ?>

                        </h4>


                        <span class="position">

                            <?= htmlspecialchars(
                                $row['position']
                            ) ?>

                        </span>


                        <?php if (!empty($row['department'])): ?>

                            <div class="detail">

                                <i class="fa-solid fa-building"></i>

                                <span>

                                    <?= htmlspecialchars(
                                        $row['department']
                                    ) ?>

                                </span>

                            </div>

                        <?php endif; ?>


                        <?php if (!empty($row['academic_year'])): ?>

                            <div class="detail">

                                <i class="fa-solid fa-calendar"></i>

                                <span>

                                    <?= htmlspecialchars(
                                        $row['academic_year']
                                    ) ?>

                                </span>

                            </div>

                        <?php endif; ?>

                    </div>



                    <!-- DELETE -->

                    <form
                        method="POST"
                        class="delete-form"
                        onsubmit="
                            return confirm(
                                'Are you sure you want to delete this office bearer?'
                            );
                        "
                    >

                        <input
                            type="hidden"
                            name="bearer_id"
                            value="<?= (int)$row['id'] ?>"
                        >

                        <button
                            type="submit"
                            name="delete_bearer"
                            class="delete-btn"
                        >

                            <i class="fa-solid fa-trash"></i>

                            Delete

                        </button>

                    </form>


                </div>


            <?php endwhile; ?>


        </div>


    <?php else: ?>


        <div class="empty">

            <i class="fa-solid fa-users"></i>

            <h3>
                No Office Bearers Yet
            </h3>

            <p>
                Add the first office bearer using the form above.
            </p>

        </div>


    <?php endif; ?>


</main>


</body>
</html>