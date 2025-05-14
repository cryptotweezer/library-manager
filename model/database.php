<?php
// This file creates the database connection.
// It connects the project to the 'library_manager' MySQL database using PDO.

$dsn = 'mysql:host=localhost;dbname=library_manager';
// DSN = Data Source Name (tells PHP where the database is)

$username = 'root';    
$password = '';        
// Default XAMPP settings: username is 'root', no password

try {
    $db = new PDO($dsn, $username, $password);
    // This creates the database connection and stores it in $db
    // Other files will use $db to send queries

    // If I move this project to a different server or PC,
    // I may need to change the DB name or login info above

} catch (PDOException $e) {
    // If connection fails, show error message
    $error_message = $e->getMessage();
    include('view/database_error.php');
    exit();
}
?>
