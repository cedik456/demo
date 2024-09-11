<?php
// delete_students.php

// Database connection
$conn = new mysqli("localhost", "root", "", "school_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the student ID from the query string
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $student_id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM Students WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        // Redirect to the student list page with a success message
        header("Location: dashboard_students.php?message=Student deleted successfully");
    } else {
        // Redirect to the student list page with an error message
        header("Location: dashboard_students.php?message=Error deleting student");
    }

    $stmt->close();
} else {
    // Redirect to the student list page with an error message if ID is not valid
    header("Location: dashboard_students.php?message=Invalid student ID");
}

$conn->close();
?>
