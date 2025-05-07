<?php
// include usage (rubric)
require_once('database.php');

/*
 * Uses array (returns list of books)
 * Returns all products from a given category.
 * Used to display books when a specific category is selected.
 */
function get_products_by_category($category_id) {
    global $db;
    $query = 'SELECT * FROM products WHERE categoryID = :category_id ORDER BY productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $products = $statement->fetchAll(); // array returned
    $statement->closeCursor();
    return $products;
}

/*
 * Returns a single product by its ID.
 * Used when modifying a book to pre-fill its current data.
 */
function get_product($product_id) {
    global $db;
    $query = 'SELECT * FROM products WHERE productID = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $product = $statement->fetch(); // single record (array)
    $statement->closeCursor();
    return $product;
}

/*
 * Deletes a product by ID.
 * Called when the user clicks "Delete" on a book.
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
 * Adds a new product to the database.
 * This is called from the "Add Book" form.
 */
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
}

/*
 * Updates a product's name and price.
 * Used when editing a book from the "Modify" form.
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
}

/*
 * Returns products from a specific category, sorted by product name.
 * Called when user clicks "Sort Ascending" or "Sort Descending".
 */
function get_sorted_products_by_category($category_id, $order = 'ASC') {
    global $db;
    $query = 'SELECT * FROM products WHERE categoryID = :category_id ORDER BY productName ' . $order;
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $products = $statement->fetchAll(); //array returned
    $statement->closeCursor();
    return $products;
}
?>