<?php
session_start();
require_once '../connection/db.php';

if (!isset($_SESSION['reg_id'])) {
    header("Location: login.php");
    exit();
}

$reg_id = $_SESSION['reg_id']; // Use reg_id from session
$update_success = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape and sanitize input
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $mid_name = $conn->real_escape_string($_POST['mid_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $age = (int) $_POST['age'];
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);

    // Password fetching here ----

    if (isset($_POST['form_type']) && $_POST['form_type'] == 'password_update') {
        // Retrieve the form data
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validation: Check if new password matches confirmation
        if ($new_password !== $confirm_password) {
            echo "New passwords do not match!";
            exit; // Stop further processing
        }

        // Fetch the user's current password from the database
        $stmt = $conn->prepare("SELECT password FROM UserLogins WHERE reg_id = ?");
        $stmt->bind_param("i", $reg_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // Check if user was found and verify the old password
        if (!$user || !password_verify($old_password, $user['password'])) {
            echo "Old password is incorrect!";
            exit; // Stop further processing
        }

        // Hash the new password
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE UserLogins SET password = ? WHERE reg_id = ?");
        $stmt->bind_param("si", $hashed_new_password, $reg_id);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Password updated successfully!";
            header("Location: login.php");
            exit();
        } else {
            echo "Failed to update the password!";
            exit();
        }
    }

    // Update the Users table
    $stmt_users = $conn->prepare("UPDATE Users 
                                  SET first_name = ?, last_name = ?, mid_name = ?, dob = ?, age = ? 
                                  WHERE reg_id = ?");
    $stmt_users->bind_param("ssssii", $first_name, $last_name, $mid_name, $dob, $age, $reg_id);

    // Update username and email in UserLogins
    $stmt_logins = $conn->prepare("UPDATE UserLogins 
                                   SET username = ?, email = ? 
                                   WHERE reg_id = ?");
    $stmt_logins->bind_param("ssi", $username, $email, $reg_id);

    // Execute both update queries
    if ($stmt_users->execute() && $stmt_logins->execute()) {
        $update_success = true;
        header("Location: update.php");
        exit();
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }

    // Close statements
    $stmt_users->close();
    $stmt_logins->close();
}

// Fetch user details from both tables
$stmt = $conn->prepare("SELECT * FROM Users u JOIN UserLogins ul ON u.reg_id = ul.reg_id WHERE u.reg_id = ?");
$stmt->bind_param("i", $reg_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/update.css">
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
                            data-first-name="<?php echo htmlspecialchars($result['first_name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-middle-name="<?php echo htmlspecialchars($result['mid_name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-last-name="<?php echo htmlspecialchars($result['last_name'], ENT_QUOTES, 'UTF-8'); ?>">
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
        <div class="container">
            <form method="POST" action="update.php">
                <h1>Edit Profile</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolor harum a hic maxime recusandae corrupti aliquid.</p>
                <div class="wrapper wrapper-user">
                    <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($result['first_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($result['last_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <input type="text" name="mid_name" value="<?php echo htmlspecialchars($result['mid_name'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="date" name="dob" value="<?php echo htmlspecialchars($result['dob'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <input type="number" name="age" value="<?php echo htmlspecialchars($result['age'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($result['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <button type="submit">Update</button>
               </form>
                    <form method="POST" action="update.php">
                    <div class="wrapper wrapper-password">
                        <h1>Change Password</h1>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. dolorum facilis expedita eaque nesciunt veniam quae. Assumenda, magnam officia! </p>
                        <input type="hidden" name="form_type" value="password_update"> <!-- To identify the form type -->
                        <input type="password" name="old_password" placeholder="Old Password" required>
                        <input type="password" name="new_password" placeholder="New Password" required>
                        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                        <button type="submit">Update</button>
                    </div>
                </form>
                <!-- <div>
                    <h1>Delete Account</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing Lorem ipsum dolor sit amet consectetur adipisicing elit. La. Autem est amet quaerat deserunt suscipit deleniti totam?</p>
                    <button type="submit" class="delete-button">Delete</button>
                </div> -->
        </div>
    </div>

    <script src="../js/formatFullName.js"></script>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/page_transition.js"></script>
</body>
</html>
