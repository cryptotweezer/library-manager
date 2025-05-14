<?php
session_start(); 
// Start the session so we can use things like $_SESSION['recent_books']

require('model/database.php');      // Connects to the database
require('model/category_db.php');   // Functions to get and add categories
require('model/product_db.php');    // Functions to get, add, delete, update books

// Get the selected category from a form or URL
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if ($category_id === null) {
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id === null || $category_id === false) {
        $category_id = null; // If no category is selected, show all
    }
}

// Get the action from the form or URL (like 'add_product', 'delete_product', etc.)
$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === null) {
        $action = 'list_products'; // Default action is to show book list
    }
}

$error_message = ''; 
// This will store form error messages (like missing fields)

switch ($action) {

    case 'list_products':
        // Show all books or just the ones from a selected category
        $categories = get_categories();

        if ($category_id === null) {
            $category_name = 'All Books';
            $products = [];
            foreach ($categories as $cat) {
                $cat_products = get_products_by_category($cat['categoryID']);
                $products = array_merge($products, $cat_products);
            }
        } else {
            $category_name = get_category_name($category_id);
            $products = get_products_by_category($category_id);
        }

        include('view/product_list.php');
        break;

    case 'delete_product':
        // Delete the selected book
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        if ($product_id) {
            delete_product($product_id);
        }

        // Go back to the same category after delete
        if ($category_id) {
            header("Location: .?category_id=$category_id");
        } else {
            header("Location: .");
        }
        break;

    case 'show_add_form':
        // Show the form to add a new book
        $categories = get_categories();
        include('view/product_add.php');
        break;

    case 'add_product':
        // Add a new book (only if all fields are filled correctly)
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        if ($category_id && $code && $name && $price !== false) {
            add_product($category_id, $code, $name, $price);

            // Save the name to the session for reference
            if (!isset($_SESSION['recent_books'])) {
                $_SESSION['recent_books'] = [];
            }
            array_push($_SESSION['recent_books'], $name);

            header("Location: .?category_id=$category_id");
        } else {
            $categories = get_categories();
            $error_message = "Please enter valid values for Code, Name, and Price.";
            include('view/product_add.php');
        }
        break;

    case 'show_modify_form':
        // Show the form to update an existing book
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product = get_product($product_id);
        include('view/product_modify.php');
        break;

    case 'modify_product':
        // Update a book's name and price
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        if ($product_id && $name && $price !== false) {
            update_product($product_id, $name, $price);
            header("Location: .?category_id=$category_id");
        } else {
            $product = get_product($product_id);
            $error_message = "Please enter valid values for Name and Price.";
            include('view/product_modify.php');
        }
        break;

    case 'sort_books':
        // Sort books in ascending or descending order
        $order = filter_input(INPUT_GET, 'order');
        if ($order !== 'ASC' && $order !== 'DESC') {
            $order = 'ASC';
        }

        $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
        $categories = get_categories();

        if ($category_id) {
            $category_name = get_category_name($category_id);
            $products = get_sorted_products_by_category($category_id, $order);
        } else {
            $category_name = 'All Books (Sorted)';
            $products = [];
            foreach ($categories as $cat) {
                $sorted = get_sorted_products_by_category($cat['categoryID'], $order);
                $products = array_merge($products, $sorted);
            }
        }

        include('view/product_list.php');
        break;

    case 'show_add_category_form':
        // Show the form to add a new category
        include('view/category_add.php');
        break;

    case 'add_category':
        // Add the new category to the database
        $category_name = filter_input(INPUT_POST, 'category_name');

        if ($category_name) {
            add_category($category_name);
            header("Location: .");
        } else {
            $error_message = "Please enter a category name.";
            include('view/category_add.php');
        }
        break;

    default:
        // If action is not recognized
        echo "Unknown action: $action";
        break;
}
?>
