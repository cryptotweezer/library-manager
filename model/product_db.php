<?php
// This file connects to the database and handles everything related to books (called "products" in the DB)
require_once('database.php');

/*
 * This function gets all books from a specific category.
 * It returns them as an array (list) of rows.
 */
function get_products_by_category($category_id) {
    global $db;

    // This is the SQL query to select all books with the given category ID
    $query = 'SELECT * FROM products WHERE categoryID = :category_id ORDER BY productID';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id); // We pass the category ID here
    $statement->execute();

    // We use fetchAll() to return multiple rows (all the books in that category)
    $products = $statement->fetchAll();

    $statement->closeCursor();
    return $products;

    // 📝 If you ever want to change how books are sorted (e.g., by price), modify the ORDER BY above
}

/*
 * This function gets one book using its ID.
 * Useful when we want to edit or display the book’s current info.
 */
function get_product($product_id) {
    global $db;

    $query = 'SELECT * FROM products WHERE productID = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id); // Book ID is used here
    $statement->execute();

    // We only expect one row back
    $product = $statement->fetch();
    $statement->closeCursor();

    return $product;
}

/*
 * This function removes a book from the database.
 * Called when we click the "Delete" button next to a book.
 */
function delete_product($product_id) {
    global $db;

    $query = 'DELETE FROM products WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();

    $statement->closeCursor();
}

/*
 * This function is used to add a new book to the system.
 * It is triggered when the Add Book form is submitted.
 */
function add_product($category_id, $code, $name, $price) {
    global $db;

    // This INSERT query adds a book with category, code, name and price
    $query = 'INSERT INTO products (categoryID, productCode, productName, listPrice)
              VALUES (:category_id, :code, :name, :price)';

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();

    // 📝 If you want to change what fields are saved (like adding Author), you can update this function and the form
}

/*
 * This function is used to update the name or price of a book.
 * Triggered by the Modify Book form.
 */
function update_product($product_id, $name, $price) {
    global $db;

    $query = 'UPDATE products SET productName = :name, listPrice = :price
              WHERE productID = :product_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $statement->closeCursor();

    // 📝 If you want to allow changing the code or category too, you'll need to add those fields here and in the form
}

/*
 * This function gets books from a category and sorts them by name.
 * It is used when we click "Sort A-Z" or "Sort Z-A".
 */
function get_sorted_products_by_category($category_id, $order = 'ASC') {
    global $db;

    // This adds the sorting direction to the SQL (ASC = A to Z, DESC = Z to A)
    $query = 'SELECT * FROM products WHERE categoryID = :category_id ORDER BY productName ' . $order;

    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();

    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;

    // 📝 To change sorting by price instead of name, change ORDER BY productName to listPrice
}
?>