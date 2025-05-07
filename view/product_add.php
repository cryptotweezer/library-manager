<?php include('header.php'); ?> <!-- This brings in the top part of the page (HTML head, navigation, etc.) -->

<h2 class="page-title">Add Book</h2> <!-- Page title shown at the top -->

<!-- This section displays any error messages (like "Code is required") -->
<?php if (!empty($error_message)) : ?>
    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>

<!-- This form sends the data to index.php using POST method -->
<form action="." method="post" class="book-form">
    <input type="hidden" name="action" value="add_product">

    <!-- Category dropdown (dynamically created from $categories array) -->
    <label for="category">Category:</label>
    <select name="category_id" id="category" required>
        <option value="">-- Choose a category --</option> <!-- Default prompt -->
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['categoryID']; ?>">
                <?php echo htmlspecialchars($category['categoryName']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Book Code (required) -->
    <label for="code">Code:</label>
    <input type="text" name="code" id="code" required placeholder="e.g. B001">
    <!-- 📝 You can change the placeholder or validation rule here -->
    <br><br>

    <!-- Book Name (required) -->
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required placeholder="Enter book title">
    <br><br>

    <!-- Book Price (required) -->
    <label for="price">Price:</label>
    <input type="text" name="price" id="price" required placeholder="e.g. 19.99">
    <!-- 📝 You can change the placeholder text or validation later if needed -->
    <br><br>

    <!-- Submit Button to add the book -->
    <input type="submit" value="Add Book" class="btn-action">
    <!-- 📝 If you want to rename this button, this is the place -->
</form>

<!-- Link to return to book list -->
<br>
<a href=".">View Book List</a>

<?php include('footer.php'); ?> <!-- Adds the footer with student info -->