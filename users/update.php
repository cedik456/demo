<?php
session_start();
require '../connection/db.php';

if (!isset($_SESSION['reg_id'])) {
    header("Location: login.php");
    exit();
}

$update_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get reg_id from session
    $reg_id = $_SESSION['reg_id']; // Use reg_id from the session
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $mid_name = $conn->real_escape_string($_POST['mid_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $age = (int) $_POST['age'];
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);

    // Update Users table
    $sql_users = "UPDATE Users 
                  SET first_name = '$first_name', last_name = '$last_name', mid_name = '$mid_name', dob = '$dob', age = $age 
                  WHERE reg_id = $reg_id";

    // Update UserLogins table
    $sql_user_logins = "UPDATE UserLogins 
                        SET username = '$username', email = '$email' 
                        WHERE reg_id = $reg_id";

    // Execute updates
    if ($conn->query($sql_users) === TRUE && $conn->query($sql_user_logins) === TRUE) {
        $update_success = true;
        header("Location: dashboard.php"); // Redirect on success
        exit();
    } else {
        echo "Error: " . $conn->error; // Display error message if update fails
    }
}

// Fetch user details for the form
$stmt = $conn->prepare("SELECT * FROM Users WHERE reg_id = ?");
$stmt->bind_param("i", $_SESSION['reg_id']);
$stmt->execute();
$user_details = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM UserLogins WHERE reg_id = ?");
$stmt->bind_param("i", $_SESSION['reg_id']);
$stmt->execute();
$user_logins = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/update.css">
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" action="update.php">
        <input type="hidden" name="reg_id" value="<?php echo $user_details['reg_id']; ?>">
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($user_details['first_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($user_details['last_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <input type="text" name="mid_name" value="<?php echo htmlspecialchars($user_details['mid_name'], ENT_QUOTES, 'UTF-8'); ?>">
        <input type="date" name="dob" value="<?php echo htmlspecialchars($user_details['dob'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <input type="number" name="age" value="<?php echo htmlspecialchars($user_details['age'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user_logins['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user_logins['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
        <button type="submit">Update</button>
    </form>

    <?php if ($update_success): ?>
        <p>Profile updated successfully!</p>
    <?php endif; ?>
</body>
</html>
