<?php include('header.php'); ?> 
<!-- This includes the top part of the page like title, logo, navigation, etc. -->

<h2 class="page-title">Add Book</h2> 
<!-- This is the heading of the page. I can change the text here if I want to rename the page. -->

<?php if (!empty($error_message)) : ?>
    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>
<!-- If there's an error (like missing info), it will show here. I can change the message in index.php. -->

<form action="." method="post" class="book-form">
    <input type="hidden" name="action" value="add_product">
    <!-- This tells index.php that the form action is to add a new book -->

    <label for="category">Category:</label>
    <select name="category_id" id="category" required>
        <option value="">-- Choose a category --</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['categoryID']; ?>">
                <?php echo htmlspecialchars($category['categoryName']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <!-- This dropdown shows all categories from the database.
         If I want to add more categories, I need to update the database (table: categories) -->

    <br><br>

    <label for="code">Code:</label>
    <input type="text" name="code" id="code" required placeholder="e.g. B001">
    <!-- This is the book code. I can change the placeholder to show another example.-->

    <br><br>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required placeholder="Enter book title">
    <!-- Book title. I can add extra validation in PHP or JavaScript if needed. -->

    <br><br>

    <label for="price">Price:</label>
    <input type="text" name="price" id="price" required placeholder="e.g. 19.99">
    <!-- Price must be a number. If I want to allow only 2 decimals, I can improve this in validation. -->

    <br><br>

    <input type="submit" value="Add Book" class="btn-action">
    <!-- If I want to change the button text (e.g. "Submit Book"), I can do it here. -->

</form>

<br>
<a href=".">View Book List</a>
<!-- This link takes me back to the main page that shows all books -->

<?php include('footer.php'); ?> 
<!-- Adds the footer (usually has student info, links, etc.) -->
