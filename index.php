<?php
session_start(); // start the session so we can use session variables like recent books

require('model/database.php');      // connects to the database
require('model/category_db.php');   // functions to work with categories
require('model/product_db.php');    // functions to work with books (products)

// this part checks if a category ID was sent (from form or URL)
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if ($category_id === null) {
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id === null || $category_id === false) {
        $category_id = null; // if nothing is selected, show all categories
    }
}

// here we check what the user wants to do (add, delete, etc.)
$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === null) {
        $action = 'list_products'; // default if nothing is selected
    }
}

$error_message = ''; // we use this to show form error messages if needed

switch ($action) {

    case 'list_products':
        // this shows the book list either for one category or all
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
        // this deletes a book and stays on the same category page
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        if ($product_id) {
            delete_product($product_id);
        }

        // after delete, reload the page for the same category
        if ($category_id) {
            header("Location: .?category_id=$category_id");
        } else {
            header("Location: .");
        }
        break;

    case 'show_add_form':
        // this shows the form to add a new book
        $categories = get_categories();
        include('view/product_add.php');
        break;

    case 'add_product':
        // get form values from the "Add Book" form
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        // only add if all values are valid
        if ($category_id && $code && $name && $price !== false) {
            add_product($category_id, $code, $name, $price);

            // save the last added book in session (just for demo)
            if (!isset($_SESSION['recent_books'])) {
                $_SESSION['recent_books'] = [];
            }
            array_push($_SESSION['recent_books'], $name);

            // go back to the category page
            header("Location: .?category_id=$category_id");
        } else {
            // if form is incomplete or wrong
            $categories = get_categories();
            $error_message = "Please enter valid values for Code, Name, and Price.";
            include('view/product_add.php');
        }
        break;

    case 'show_modify_form':
        // shows the form to update book name and price
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product = get_product($product_id);
        include('view/product_modify.php');
        break;

    case 'modify_product':
        // gets form data and updates book in database
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
        // this part sorts books in ASC or DESC order
        $order = filter_input(INPUT_GET, 'order');
        if ($order !== 'ASC' && $order !== 'DESC') {
            $order = 'ASC'; // default sort
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

    default:
        // just in case the action is not found
        echo "Unknown action: $action";
        break;
}
?>
