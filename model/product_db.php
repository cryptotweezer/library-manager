<?php
// This file handles everything related to books in the database.
// It contains functions to get, add, delete, update, and sort books.

require_once('database.php');

// Get all books that belong to a specific category
function get_products_by_category($category_id) {
    global $db;

    $query = 'SELECT * FROM products WHERE categoryID = :category_id ORDER BY productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();

    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
    // I can change the ORDER BY to sort by name or price instead
}

// Get the full details of a single book using its ID
function get_product($product_id) {
    global $db;

    $query = 'SELECT * FROM products WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();

    $product = $statement->fetch();
    $statement->closeCursor();

    return $product;
}

// Delete a book by its ID
function delete_product($product_id) {
    global $db;

    $query = 'DELETE FROM products WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $statement->closeCursor();
}

// Add a new book to the database
function add_product($category_id, $code, $name, $price) {
    global $db;

    $query = 'INSERT INTO products (categoryID, productCode, productName, listPrice)
              VALUES (:category_id, :code, :name, :price)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();

    // If I want to store more fields (like author), I can add them in this query and in the form
}

// Update the name and price of a book
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

    // To update more fields like category or code, I would add them here
}

// Get all books from a category and sort them by name (A-Z or Z-A)
function get_sorted_products_by_category($category_id, $order = 'ASC') {
    global $db;

    $query = 'SELECT * FROM products WHERE categoryID = :category_id ORDER BY productName ' . $order;
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();

    $products = $statement->fetchAll();
    $statement->closeCursor();

    return $products;
    // I can change ORDER BY to sort by price or code instead of name
}
?>
