<?php

// This file establishes the database connection using PDO (PHP Data Objects)

// Data Source Name - tells PDO how to connect
$dsn = 'mysql:host=localhost;dbname=library_manager'; // Connect to MySQL on localhost and use 'library_manager' database

// Credentials for connecting to the database
$username = 'root';       // Default XAMPP username
$password = '';           // Leave empty if using XAMPP (no password by default)

// Try to create the PDO object for DB connection
try {
    $db = new PDO($dsn, $username, $password); // Create the PDO instance to connect to MySQL
} catch (PDOException $e) {
    // If connection fails, capture the error message and show a custom error page
    $error_message = $e->getMessage();
    include('view/database_error.php');
    exit(); // Stop further execution
}
?>
