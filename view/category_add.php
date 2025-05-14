<?php include('header.php'); ?>

<h2 class="page-title">Add Category</h2>

<?php if (!empty($error_message)) : ?>
    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>

<form action="." method="post" class="book-form">
    <input type="hidden" name="action" value="add_category">

    <label>Category Name:</label>
    <input type="text" name="category_name" required placeholder="e.g. Science Fiction">
    <br><br>

    <input type="submit" class="btn-action" value="Add Category">
</form>

<br>
<a href=".">View Book List</a>

<?php include('footer.php'); ?>
