<?php include('header.php'); ?> <!-- Adds the top part of the HTML (head, nav, etc.) -->

<!-- Page title with a link that reloads all books -->
<h2 class="page-title">
    <a href="." class="page-title-link">Book List</a> <!-- 📝 You can change the title text here -->
</h2>

<!-- This section puts categories on the left and book list on the right -->
<div class="main-container">

    <!-- Left: list of categories -->
    <div class="sidebar">
        <h3>Categories</h3>
        <ul class="category-list">
            <?php foreach ($categories as $category) : ?>
                <li class="category-item"> <!-- 📝 If you want to adjust spacing between items, see style.css `.category-item` -->
                    <a href=".?category_id=<?php echo $category['categoryID']; ?>">
                        <?php echo htmlspecialchars($category['categoryName']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Right: list of books -->
    <div class="booklist">
        <!-- Shows selected category -->
        <h3 class="category-title"><?php echo $category_name; ?></h3>

        <!-- Error messages -->
        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Table displaying books -->
        <table class="book-table">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <!-- Loop through books -->
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                    <td><?php echo htmlspecialchars($product['productName']); ?></td>
                    <td><?php echo htmlspecialchars($product['listPrice']); ?></td>
                    <td>
                        <!-- Delete button -->
                        <form action="." method="post" class="inline-form">
                            <input type="hidden" name="action" value="delete_product">
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>"> <!-- ✅ Keeps current category -->
                            <input type="submit" class="btn-delete" value="Delete"> <!-- 📝 You can rename this button -->
                        </form>

                        <!-- Modify button -->
                        <form action="." method="post" class="inline-form">
                            <input type="hidden" name="action" value="show_modify_form">
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <input type="submit" class="btn-modify" value="Modify">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Extra action links -->
        <div class="action-links">
            <a class="btn-action" href=".?action=show_add_form">Add Book</a><br><br> <!-- 📝 Change text here to rename -->
            <a class="btn-action" href=".?action=sort_books&order=ASC<?php if (isset($category_id) && $category_id) echo "&category_id=$category_id"; ?>">
                Sort Book in Ascending Order
            </a><br><br>
            <a class="btn-action" href=".?action=sort_books&order=DESC<?php if (isset($category_id) && $category_id) echo "&category_id=$category_id"; ?>">
                Sort Book in Descending Order
            </a>
        </div>
    </div>
</div>

<?php include('footer.php'); ?> <!-- Adds footer -->
