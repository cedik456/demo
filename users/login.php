<?php
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

$conn = new mysqli("localhost", "root", "", "school_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM UserLogins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userLogin = $result->fetch_assoc();
        if (password_verify($password, $userLogin['password'])) {
            // Store reg_id in session
            $_SESSION['reg_id'] = $userLogin['reg_id'];
            $_SESSION['username'] = $userLogin['username'];
            $_SESSION['email'] = $userLogin['email'];

            // Debugging output: Check session variables
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";

            // Redirect to dashboard.php
            header("Location: ../students/dashboard_students.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <img src="../assets/dwcl-logo.png" alt="" class="logo">
            <h1>Sign in</h1>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" autocomplete="off" required /><br />
                <!-- <input type="email" name="email" placeholder="Email" required /><br /> -->
                <input type="password" name="password" placeholder="Password" required /><br />
                <button type="submit">Login</button>
            </form>
            <div class="member">
                Not a member? <a href="register.php">Register now</a>
            </div>
        </div>
    </div>
</body>
</html>

