<?php
// This file connects to the database using the file database.php
require_once('database.php');

/*
 * Function: get_categories
 * Description: This function gets all the categories from the database.
 * It is used to display the list of book categories on the left side of the page.
 */
function get_categories() {
    global $db; // This is the database connection

    // This query selects all the categories from the database
    $query = 'SELECT * FROM categories ORDER BY categoryID';

    $statement = $db->prepare($query); // Prepares the query
    $statement->execute();             // Runs the query

    // This turns the results into an array (array is like a list in PHP)
    $categories = $statement->fetchAll();

    $statement->closeCursor(); // Always close the query when finished

    return $categories;
    // NOTE: You can change the order (ASC or DESC) in the SQL query if you want categories sorted differently
}

/*
 * Function: get_category_name
 * Description: This returns just the name of one category.
 * It is used to display the selected category name above the book list.
 */
function get_category_name($category_id) {
    global $db;

    // This query selects the name of the category where the ID matches
    $query = 'SELECT categoryName FROM categories WHERE categoryID = :category_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id); // We send the category_id to the query
    $statement->execute();

    $category = $statement->fetch(); // We only get one result here
    $statement->closeCursor();

    return $category['categoryName']; // This just returns the name like "Philosophical" or "Literature"
    // NOTE: If you want to change how the category name is shown, it will happen wherever this function is called
}
?>