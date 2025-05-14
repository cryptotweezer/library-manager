<?php
// This file handles everything related to book categories.
// It gets the list of all categories and returns the name of a specific category.

require_once('database.php'); 
// Connects to the database using the database connection from database.php

function get_categories() {
    global $db;

    // Get all categories from the database, ordered by categoryID
    $query = 'SELECT * FROM categories ORDER BY categoryID';
    $statement = $db->prepare($query);
    $statement->execute();

    $categories = $statement->fetchAll(); // turns results into an array
    $statement->closeCursor();

    return $categories;
    // I can change the SQL query if I want to show categories in a different order
}

function get_category_name($category_id) {
    global $db;

    // Get the name of one category based on the ID
    $query = 'SELECT categoryName FROM categories WHERE categoryID = :category_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();

    $category = $statement->fetch(); // gets one result
    $statement->closeCursor();

    return $category['categoryName']; 
    // This returns the name like "Philosophical", which is used in the product list title
}

function add_category($category_name) {
    global $db;
    $query = 'INSERT INTO categories (categoryName) VALUES (:category_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_name', $category_name);
    $statement->execute();
    $statement->closeCursor();
}

?>
