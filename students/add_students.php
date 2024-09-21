<?php
// add_students.php

session_start(); // Start the session

// Database connection
require '../connection/db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $school_id = $_POST['school_id'];
    $bday = $_POST['bday'];
    $age = $_POST['age'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];

    $sql = "INSERT INTO Students (name, school_id, bday, age, course, year_level)
            VALUES ('$name', '$school_id', '$bday', '$age', '$course', '$year_level')";

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

