<?php include('header.php'); ?> <!-- Add page header (menu, title, etc.) -->

<!-- Title at the top of the page -->
<h2 class="page-title">Modify Book</h2> <!-- 📝 You can change this title -->

<!-- If there's an error message, display it above the form -->
<?php if (!empty($error_message)) : ?>
    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>

<!-- Form to update the book details -->
<form action="." method="post" class="book-form">

    <!-- This hidden field tells index.php that we want to modify a book -->
    <input type="hidden" name="action" value="modify_product">

    <!-- This sends the ID of the book being updated -->
    <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

    <!-- Input to change the book name. It’s pre-filled with the current name -->
    <label>Name:</label> <!-- 📝 You can rename this label if needed -->
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
    <br><br>

    <!-- Input to change the price. Also pre-filled -->
    <label>Price:</label>
    <input type="text" name="price" value="<?php echo htmlspecialchars($product['listPrice']); ?>" required>
    <br><br>

    <!-- Save button -->
    <input type="submit" class="btn-modify" value="Save Changes"> <!-- 📝 Change button text here if needed -->
</form>

<!-- Link to go back to the book list -->
<br>
<a href=".">View Book List</a> <!-- 📝 You can change this link text -->

<?php include('footer.php'); ?> <!-- Add bottom footer info -->