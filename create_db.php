<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Create database connection without selecting database
    $conn = mysqli_connect('localhost', 'root', '');
    
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS techtrouble";
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating database: " . mysqli_error($conn));
    }
    echo "Database created or already exists<br>";

    // Select the database
    if (!mysqli_select_db($conn, "techtrouble")) {
        throw new Exception("Error selecting database: " . mysqli_error($conn));
    }
    echo "Database selected successfully<br>";

    // Create users table first (since other tables reference it)
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin', 'support') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating users table: " . mysqli_error($conn));
    }
    echo "Users table created or already exists<br>";

    // Create categories table
    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating categories table: " . mysqli_error($conn));
    }
    echo "Categories table created or already exists<br>";

    // Create issues table
    $sql = "CREATE TABLE IF NOT EXISTS issues (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        category_id INT(11) NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        status ENUM('open', 'in_progress', 'resolved', 'closed') NOT NULL DEFAULT 'open',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating issues table: " . mysqli_error($conn));
    }
    echo "Issues table created or already exists<br>";

    // Create solutions table
    $sql = "CREATE TABLE IF NOT EXISTS solutions (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        issue_id INT(11) NOT NULL,
        user_id INT(11) NOT NULL,
        solution TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating solutions table: " . mysqli_error($conn));
    }
    echo "Solutions table created or already exists<br>";

    // Create comments table
    $sql = "CREATE TABLE IF NOT EXISTS comments (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        issue_id INT(11) NOT NULL,
        user_id INT(11) NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating comments table: " . mysqli_error($conn));
    }
    echo "Comments table created or already exists<br>";

    // Insert default categories
    $categories = [
        ['Hardware Issues', 'Problems related to computer hardware components'],
        ['Software Issues', 'Problems related to software applications and operating systems'],
        ['Network Issues', 'Problems related to network connectivity and configuration'],
        ['Security Issues', 'Problems related to system security and access control']
    ];

    foreach ($categories as $category) {
        $name = mysqli_real_escape_string($conn, $category[0]);
        $description = mysqli_real_escape_string($conn, $category[1]);
        $sql = "INSERT IGNORE INTO categories (name, description) VALUES ('$name', '$description')";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Error inserting category: " . mysqli_error($conn));
        }
    }
    echo "Default categories inserted or already exist<br>";

    // Create admin user if not exists
    $admin_username = 'admin';
    $admin_email = 'admin@example.com';
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);

    $sql = "INSERT IGNORE INTO users (username, email, password, role) 
            VALUES ('$admin_username', '$admin_email', '$admin_password', 'admin')";
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error creating admin user: " . mysqli_error($conn));
    }
    echo "Admin user created or already exists<br>";

    mysqli_close($conn);
    echo "<br>Setup completed successfully. You can now <a href='index.php'>go to the homepage</a>.";

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 