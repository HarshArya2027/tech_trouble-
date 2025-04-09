<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'techtrouble';

try {
    // Create initial connection without database
    $conn = mysqli_connect($db_host, $db_user, $db_pass);
    
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating database: " . mysqli_error($conn));
    }

    // Select the database
    if (!mysqli_select_db($conn, $db_name)) {
        throw new Exception("Error selecting database: " . mysqli_error($conn));
    }

    // Set charset to utf8mb4
    if (!mysqli_set_charset($conn, "utf8mb4")) {
        throw new Exception("Error setting charset: " . mysqli_error($conn));
    }

} catch (Exception $e) {
    die("Database Error: " . $e->getMessage());
}
?> 