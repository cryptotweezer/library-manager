<?php include('header.php'); ?> 
<!-- This adds the top part of the page (HTML head, navigation, etc.) -->

<h2 class="page-title">
    <a href="." class="page-title-link">Book List</a> 
    <!-- This is the main title. Clicking it reloads all books -->
</h2>

<div class="main-container">
    
    <!-- Left side: shows the list of categories -->
    <div class="sidebar">
        <h3>Categories</h3>
        <ul class="category-list">
            <?php foreach ($categories as $category) : ?>
                <li class="category-item">

                    <!-- Button to delete a category -->
                    <form action="." method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        <input type="hidden" name="action" value="delete_category">
                        <input type="hidden" name="category_id" value="<?php echo $category['categoryID']; ?>">
                        <button type="submit" class="btn-delete-category" title="Delete Category">Delete</button>
                    </form>

                    <!-- Link to view books in this category -->
                    <a href=".?category_id=<?php echo $category['categoryID']; ?>">
                        <?php echo htmlspecialchars($category['categoryName']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- This section shows all available categories on the left -->
    </div>

    <!-- Right side: shows the list of books -->
    <div class="booklist">
        <h3 class="category-title"><?php echo $category_name; ?></h3>
        <!-- This shows the current selected category name -->

        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <!-- Shows error messages if there are any -->

        <!-- Table that lists all books -->
        <table class="book-table">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                    <td><?php echo htmlspecialchars($product['productName']); ?></td>
                    <td><?php echo htmlspecialchars($product['listPrice']); ?></td>
                    <td>
                        <!-- Form to delete a book -->
                        <form action="." method="post" class="inline-form">
                            <input type="hidden" name="action" value="delete_product">
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                            <input type="submit" class="btn-delete" value="Delete">
                        </form>

                        <!-- Form to modify a book -->
                        <form action="." method="post" class="inline-form">
                            <input type="hidden" name="action" value="show_modify_form">
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <input type="submit" class="btn-modify" value="Modify">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Buttons to add book, category, or sort -->
        <div class="action-links">
            <a class="btn-action" href=".?action=show_add_form">Add Book</a><br><br>
            <!-- Opens the form to add a new book -->

            <a class="btn-action" href=".?action=show_add_category_form">Add Category</a><br><br>
            <!-- Opens the form to add a new category -->

            <a class="btn-action" href=".?action=sort_books&order=ASC<?php if (isset($category_id) && $category_id) echo "&category_id=$category_id"; ?>">
                Sort Book in Ascending Order
            </a><br><br>

            <a class="btn-action" href=".?action=sort_books&order=DESC<?php if (isset($category_id) && $category_id) echo "&category_id=$category_id"; ?>">
                Sort Book in Descending Order
            </a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?> 
<!-- Adds the footer section to the page -->
