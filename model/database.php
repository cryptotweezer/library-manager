<?php

// This file connects our PHP project to the MySQL database using PDO (PHP Data Objects)

// This is the connection string (called DSN) that says where the database is
// We're connecting to a local database named 'library_manager'
$dsn = 'mysql:host=localhost;dbname=library_manager';

// Login details for the database
$username = 'root';    // Default user in XAMPP
$password = '';        // Leave blank for XAMPP (no password by default)

// Try to connect to the database
try {
    // Create a new database connection and store it in $db
    $db = new PDO($dsn, $username, $password);

    // ✅ NOTE: If you are using a different server or MySQL username/password,
    // you can change the values of $dsn, $username, or $password here.

} catch (PDOException $e) {
    // If connection fails, this block runs
    // We store the error message and show an error page
    $error_message = $e->getMessage();
    include('view/database_error.php'); // Shows a custom error message page
    exit(); // Stop the script because we can't run without a DB
}
?>
