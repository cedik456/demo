<?php
session_start(); // Start the session

if (!isset($_SESSION['reg_id'])) {
    header("Location: login.php");
    exit();
}
require '../connection/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting and sanitizing inputs
    $reg_id = (int) $_POST['reg_id'];  // assuming reg_id is sent via POST
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $mid_name = $conn->real_escape_string($_POST['mid_name']);
    // $dob = $conn->real_escape_string($_POST['dob']); 
    $age = (int) $_POST['age'];
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update Users table
        $stmt_users = $conn->prepare("UPDATE Users 
                                      SET first_name = ?, last_name = ?, mid_name = ?, age = ? 
                                      WHERE reg_id = ?");
        $stmt_users->bind_param("sssii", $first_name, $last_name, $mid_name, $age, $reg_id);
        $stmt_users->execute();

        // Update UserLogins table
        $stmt_logins = $conn->prepare("UPDATE UserLogins 
                                       SET username = ?, email = ?" . ($password ? ", password = ?" : "") . " 
                                       WHERE reg_id = ?");
        
        if ($password) {
            $stmt_logins->bind_param("sssi", $username, $email, $password, $reg_id);
        } else {
            $stmt_logins->bind_param("ssi", $username, $email, $reg_id);
        }
        
        $stmt_logins->execute();

        // Commit transaction if everything is fine
        $conn->commit();

        // Redirect to profile or success page
        header("Location: dashboard.php");
        exit();
    } catch (Exception $e) {
        // Rollback if there's any error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/update.css">
</head>
<body>
     <div class="hero">
        <nav>
        <div class="logo-wrapper">
                <a href="#"><img src="../assets/dwcl-logo.png" alt="" class="logo"></a>
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
                        <h3>
                        </h3>
                    </div>
                    <hr>
                    <a href="#" class="sub-menu-link">
                        <img src="../assets/profile.png" alt="">
                        <p>Edit profile</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link">
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
    <div class="wrapper">
        <h1>Profile Information</h1>
        <p>Update your account's profile information and email address</p>
        <form action="update.php" method="POST">
            <!-- Hidden field to store reg_id (assuming it's available in session or fetched from the database) -->
            <input type="hidden" name="reg_id" value="<?php echo $reg_id; ?>">

            <div class="input-wrapper">
                <label for="first_name">First Name</label>
                <input type="text" placeholder="Cedric" name="first_name" required>
                
                <label for="mid_name">Middle Name</label>
                <input type="text" placeholder="Nano" name="mid_name">
                
                <label for="last_name">Last Name</label>
                <input type="text" placeholder="Nano" name="last_name" required>
                
                <!-- <label for="dob">Date of Birth</label>
                <input type="date" name="dob" required> -->
                
                <label for="email">Email</label>
                <input type="email" placeholder="ced@gmail.com" name="email" required>

                <label for="password">Old Password</label>
                <input type="password" name="password" placeholder="Old Password">

            
            </div>
            <button type="submit">Update</button>
        </form>
     </div>
    
     <div class="delete-wrapper">
        <h1>Delete Account</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat nobis consequuntur ex quaerat sequi. <br> Quia possimus alias maiores, Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <form action="delete.php" method="POST">
            <!-- Assuming a delete.php file will handle account deletion -->
            <button class="delete-button" type="submit">Delete</button>
        </form>
    </div>
</div>

    </div>
  
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/formatFullName.js"></script>
</body>
</html>
