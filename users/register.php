<?php
$conn = new mysqli("localhost", "root", "", "school_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $mid_name = $conn->real_escape_string($_POST['mid_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $age = (int) $_POST['age'];
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Generate unique faculty_id (e.g., using random_bytes)
    $faculty_id = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

    // Insert into Users table
    $sql_users = "INSERT INTO Users (faculty_id, first_name, last_name, mid_name, dob, age) 
                  VALUES ('$faculty_id', '$first_name', '$last_name', '$mid_name', '$dob', $age)";
    
    if ($conn->query($sql_users) === TRUE) {
        // Get the last inserted reg_id
        $reg_id = $conn->insert_id;

        // Insert into UserLogins table
        $sql_user_logins = "INSERT INTO UserLogins (reg_id, username, email, password) 
                            VALUES ($reg_id, '$username', '$email', '$password')";
        
        if ($conn->query($sql_user_logins) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration</title>
    <link rel="stylesheet" href="../css/registration.css">
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <img src="../assets/dwcl-logo.png" alt="" class="logo">
            <h1>Sign up</h1>
            <form action="register.php" method="POST">
                <div class="grid">
                    <div>
                        <input type="text" name="faculty_id" id="faculty_id" placeholder="Faculty ID" autocomplete="off" readonly /><br />
                        <input type="text" name="first_name" placeholder="First Name" autocomplete="off" required /><br />
                        <input type="text" name="last_name" placeholder="Last Name" autocomplete="off" required /><br />
                        <input type="text" name="mid_name" placeholder="Middle Name" autocomplete="off" /><br />
                    </div>
                    <div>
                        <input type="date" name="dob" id="dob" placeholder="Date of Birth" autocomplete="off" required /><br />
                        <input type="number" name="age" id="age" placeholder="Age" autocomplete="off" readonly /><br />
                        <input type="text" name="username" placeholder="Username" autocomplete="off" required /><br />
                        <input type="email" name="email" placeholder="Email" autocomplete="off" required /><br />
                        <input type="password" name="password" placeholder="Password" required /><br />
                    </div>
                </div>
                
                <div class="terms">
                    <input type="checkbox" id="checkbox" required>
                    <label for="checkbox">I agree to these <a href="">Terms & Conditions</a></label>
                </div>
                <button type="submit">Register</button>
            </form>
            <div class="member">
                Already a member? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

    <script>
        // Generate a random faculty_id and set it in the hidden input field
        function generateFacultyId() {
            return 'FAC' + Math.random().toString(36).substr(2, 4).toUpperCase();
        }

        // Set the faculty_id when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('faculty_id').value = generateFacultyId();
        });

        // Add an event listener to the date of birth input
        document.getElementById('dob').addEventListener('input', function() {
            const dob = new Date(this.value); // Get the date of birth value
            const age = calculateAge(dob); // Calculate the age
            document.getElementById('age').value = age; // Set the calculated age
        });

        // Function to calculate age based on date of birth
        function calculateAge(dob) {
            const diffMs = Date.now() - dob.getTime(); // Difference in milliseconds
            const ageDt = new Date(diffMs); // Create a new date object with the difference

            return Math.abs(ageDt.getUTCFullYear() - 1970); // Calculate the year difference
        }
    </script>
</body>
</html>
