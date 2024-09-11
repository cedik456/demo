<?php
session_start(); // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "user_registration");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form inputs
    $new_username = $conn->real_escape_string($_POST['new_username']);
    $new_password = $_POST['new_password'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Get the current logged-in username from the session
    $current_username = $_SESSION['username'];

    // Update query
    $sql = "UPDATE users SET username='$new_username', password='$hashed_password' WHERE username='$current_username'";

    if ($conn->query($sql) === TRUE) {
        // Update the session username
        $_SESSION['username'] = $new_username;

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="wrapper">
      <h1>Update Profile</h1>
      <form action="update.php" method="POST">
        <!-- <label for="new_username">New Username:</label> -->
        <input type="text" id="new_username" name="new_username" placeholder="Username" required />
        <!-- <label for="new_password">New Password:</label> -->
        <input type="password" id="new_password" name="new_password" placeholder="Password" required />
        <button type="submit" value="Update">Update</button>
      </form>
    </div>
  </body>
</html>

