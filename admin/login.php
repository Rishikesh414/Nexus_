<?php

session_start();

require_once "../server/config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    // Check empty fields
    if ($username === "" || $password === "") {

        echo "<script>
                alert('Please enter username and password');
                window.location.href='index.php';
              </script>";
        exit();
    }

    // Check admin username
    $sql = "SELECT * FROM admin WHERE username = ? LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Database query error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Admin found
    if ($result && mysqli_num_rows($result) === 1) {

        $admin = mysqli_fetch_assoc($result);

        // Password check
        if ($password === $admin["password"]) {

            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_username"] = $admin["username"];

            header("Location: dashboard.php");
            exit();

        } else {

            echo "<script>
                    alert('Invalid password');
                    window.location.href='index.php';
                  </script>";
            exit();
        }

    } else {

        echo "<script>
                alert('Invalid username');
                window.location.href='index.php';
              </script>";
        exit();
    }
}

?>