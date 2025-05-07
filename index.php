<?php
// ✅ We start the session so we can use session variables (like $_SESSION['recent_books'])
session_start();

// ✅ Load the necessary files that handle the database and logic
require('model/database.php');
require('model/category_db.php');
require('model/product_db.php');

// ✅ Get selected category from POST or GET
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if ($category_id === null) {
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id === null || $category_id === false) {
        $category_id = null; // means no filter, show all categories
    }
}

// ✅ Get action from POST or GET (what the user wants to do)
$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === null) {
        $action = 'list_products'; // default action
    }
}

// This variable will hold any validation error messages
$error_message = '';

switch ($action) {

    // ✅ Show the list of products
    case 'list_products':
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

    // ✅ Delete a product and stay on the same category
    case 'delete_product':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT); // ✅ Ensure category is passed
        if ($product_id) {
            delete_product($product_id);
        }
        if ($category_id) {
            header("Location: .?category_id=$category_id");
        } else {
            header("Location: .");
        }
        break;
    

    // ✅ Show form to add a book
    case 'show_add_form':
        $categories = get_categories();
        include('view/product_add.php');
        break;

    // ✅ Handle adding a book to the DB
    case 'add_product':
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        if ($category_id && $code && $name && $price !== false) {
            add_product($category_id, $code, $name, $price);

            // 👇 This saves the last added books to a session array
            if (!isset($_SESSION['recent_books'])) {
                $_SESSION['recent_books'] = [];
            }
            array_push($_SESSION['recent_books'], $name);

            header("Location: .?category_id=$category_id");
        } else {
            $categories = get_categories();
            $error_message = "⚠️ Please enter valid values for Code, Name, and Price.";
            include('view/product_add.php');
        }
        break;

    // ✅ Show the modify form for a selected product
    case 'show_modify_form':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product = get_product($product_id);
        include('view/product_modify.php');
        break;

    // ✅ Handle updating a book
    case 'modify_product':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        if ($product_id && $name && $price !== false) {
            update_product($product_id, $name, $price);
            header("Location: .?category_id=$category_id");
        } else {
            $product = get_product($product_id);
            $error_message = "⚠️ Please enter valid values for Name and Price.";
            include('view/product_modify.php');
        }
        break;

    // ✅ Sort books by ASC or DESC name
    case 'sort_books':
        $order = filter_input(INPUT_GET, 'order');
        if ($order !== 'ASC' && $order !== 'DESC') {
            $order = 'ASC'; // default
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

    // ✅ If the action is not recognized
    default:
        echo "Unknown action: $action";
        break;
}
?>