<?php
// edit_students.php

session_start(); // Start the session

// Database connection
require '../connection/db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $school_id = $_POST['school_id'];
    $bday = $_POST['bday'];
    $age = $_POST['age'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];

    $sql = "UPDATE Students 
            SET name='$name', school_id='$school_id', bday='$bday', age='$age', course='$course', year_level='$year_level' 
            WHERE student_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the view page or refresh it
        header("Location: dashboard_students.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
