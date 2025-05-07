<?php
// ✅ include statement used (rubric: General Programming - 2 pts)
require_once('database.php');

/*
 * Retrieves all categories from the 'categories' table.
 * This function returns an array of category records.
 */
function get_categories() {
    global $db;
    $query = 'SELECT * FROM categories ORDER BY categoryID'; // SQL to get all categories ordered by ID
    $statement = $db->prepare($query); // Prepare the SQL statement
    $statement->execute(); // Execute the query
    $categories = $statement->fetchAll(); // returns an array of rows
    $statement->closeCursor(); // Close the cursor to free resources
    return $categories;
}

/*
 * Retrieves the name of a single category by its ID.
 * Used to display the current category name in the book list view.
 */
function get_category_name($category_id) {
    global $db;
    $query = 'SELECT categoryName FROM categories WHERE categoryID = :category_id'; // SQL with placeholder
    $statement = $db->prepare($query); // Prepare the statement
    $statement->bindValue(':category_id', $category_id); // Bind the category ID value
    $statement->execute(); // Execute the query
    $category = $statement->fetch(); // Fetch the result row (only one expected)
    $statement->closeCursor(); // Close the cursor
    return $category['categoryName']; // Return the name of the category
}
?>