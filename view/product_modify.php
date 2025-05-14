<?php include('header.php'); ?> 
<!-- Adds the top part of the page (menu, title, etc.) -->

<h2 class="page-title">Modify Book</h2> 
<!-- Title of the page. Can change the text if I want to rename it -->

<?php if (!empty($error_message)) : ?>
    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<!-- Shows any error message from index.php if name or price is missing -->

<form action="." method="post" class="book-form">

    <input type="hidden" name="action" value="modify_product">
    <!-- This tells index.php that this form is for updating a book -->

    <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
    <!-- This keeps the ID of the book we are updating -->

    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
    <!-- Input field for book name, already filled with the current name -->

    <br><br>

    <label>Price:</label>
    <input type="text" name="price" value="<?php echo htmlspecialchars($product['listPrice']); ?>" required>
    <!-- Input field for price, also filled with current value -->

    <br><br>

    <input type="submit" class="btn-modify" value="Save Changes">
    <!-- Button to update the book. Text can be changed if needed -->

</form>

<br>
<a href=".">View Book List</a>
<!-- Link to go back to the main page that shows all books -->

<?php include('footer.php'); ?> 
<!-- Adds the bottom part of the page -->
