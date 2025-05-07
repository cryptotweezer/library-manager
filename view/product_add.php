<?php include('header.php'); ?> <!-- include statement used -->

<h2>Add Book</h2> <!-- Page title -->

<!-- Input validation (HTML required) -->
<!-- Uses array ($categories) and foreach (rubric) -->
<!-- Form sends POST to index.php to trigger 'add_product' action -->
<form action="." method="post">
    <input type="hidden" name="action" value="add_product">

    <label>Category:</label>
    <select name="category_id">
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['categoryID']; ?>">
                <?php echo htmlspecialchars($category['categoryName']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Code:</label>
    <input type="text" name="code" required>
    <br><br>

    <label>Name:</label>
    <input type="text" name="name" required>
    <br><br>

    <label>Price:</label>
    <input type="text" name="price" required>
    <br><br>

    <input type="submit" value="Add Book">
</form>

<!-- Navigation usability (return to main list) -->
<br>
<a href=".">View Book List</a>

<?php include('footer.php'); ?> 
