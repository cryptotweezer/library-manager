<?php
// Start session to use $_SESSION array_push + for loop)
session_start();

// Load required model files for database, categories, and products
require('model/database.php');
require('model/category_db.php');
require('model/product_db.php');

// Get category_id from POST or GET
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
if ($category_id === null) {
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id === null || $category_id === false) {
        $category_id = null; // null means show all books from all categories
    }
}

// Get the action (what user wants to do)
$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === null) {
        $action = 'list_products'; // Default action
    }
}

// Main controller logic
switch ($action) {

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

    case 'delete_product':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        if ($product_id) {
            delete_product($product_id);
        }
        header("Location: .?category_id=$category_id");
        break;

    case 'show_add_form':
        $categories = get_categories();
        include('view/product_add.php');
        break;

    case 'add_product':
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $code = filter_input(INPUT_POST, 'code');
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        if ($category_id && $code && $name && $price !== false) {
            add_product($category_id, $code, $name, $price);

            // array_push used here 
            if (!isset($_SESSION['recent_books'])) {
                $_SESSION['recent_books'] = []; // Initialize if not set
            }

            array_push($_SESSION['recent_books'], $name); // Add book name to session array

            // for loop used to display last 3 books (rubric)
            echo "<!-- Recently Added Books: -->";
            echo "<div style='display:none;'>"; 

            $recent = $_SESSION['recent_books'];
            $count = count($recent);
            $limit = ($count < 3) ? $count : 3;

            for ($i = $count - $limit; $i < $count; $i++) {
                echo "Recently added: " . htmlspecialchars($recent[$i]) . "<br>";
            }

            echo "</div>";

            header("Location: .?category_id=$category_id");
        } else {
            echo "Invalid product data. Check all fields and try again.";
        }
        break;

    case 'show_modify_form':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product = get_product($product_id);
        include('view/product_modify.php');
        break;

    case 'modify_product':
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

        if ($product_id && $name && $price !== false) {
            update_product($product_id, $name, $price);
        }
        header("Location: .?category_id=$category_id");
        break;

    case 'sort_books':
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

    default:
        echo "Unknown action: $action";
        break;
}
?>
