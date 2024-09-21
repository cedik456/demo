<?php
// db.php

// Create a new MySQLi connection
$conn = new mysqli("localhost", "root", "", "school_db");

// Check for a connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
