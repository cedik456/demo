<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['reg_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
require '../connection/db.php';

// Fetch any necessary data for the dashboard (e.g., user details, grades, etc.)
// Example: Fetching the user's details
$stmt = $conn->prepare("SELECT * FROM Users WHERE reg_id = ?");
$stmt->bind_param("i", $_SESSION['reg_id']);
$stmt->execute();
$users = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM UserLogins WHERE email = ?");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$userLogins = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/reset.css">
</head>
<body>

    <div class="hero">
        <nav>
        <div class="logo-wrapper">
                <a href="../students/dashboard_students.php"><img src="../assets/dwcl-logo.png" alt="" class="logo"></a>
            </div>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="../students/dashboard_students.php">Add Students</a></li>
            </ul>
            <img src="../assets/blank-profile-picture-973460_960_720.webp" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../assets/profile.png" alt="">
                        <h3 id="full-name"
                            data-first-name="<?php echo htmlspecialchars($users['first_name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-middle-name="<?php echo htmlspecialchars($users['mid_name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-last-name="<?php echo htmlspecialchars($users['last_name'], ENT_QUOTES, 'UTF-8'); ?>">
                        </h3>
                    </div>
                    <hr>
                    <a href="update.php" class="sub-menu-link">
                        <img src="../assets/profile.png" alt="">
                        <p>Edit profile</p>
                        <span>></span>
                    </a>
                    <a href="settings_privacy.php" class="sub-menu-link">
                        <img src="../assets/setting.png" alt="">
                        <p>Settings & Privacy</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link">
                        <img src="../assets/help.png" alt="">
                        <p>Help & Support</p>
                        <span>></span>
                    </a>
                    <a href="logout.php" class="sub-menu-link">
                        <img src="../assets/logout.png" alt="">
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </div>


    <script src="../js/formatFullName.js"></script>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/page_transition.js"></script>

</body>
</html>
