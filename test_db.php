<?php
require_once 'includes/config.php';

// Test database connection
if ($conn) {
    echo "Database connection successful!";
    
    // Test query
    $result = mysqli_query($conn, "SHOW TABLES");
    if ($result) {
        echo "<br>Tables in database:";
        while ($row = mysqli_fetch_row($result)) {
            echo "<br>" . $row[0];
        }
    } else {
        echo "<br>Error executing query: " . mysqli_error($conn);
    }
} else {
    echo "Database connection failed: " . mysqli_connect_error();
}
?> 