<?php include('header.php'); ?> 

<h2>Modify Book</h2> <!-- Page title -->


<form action="." method="post">
    <!-- Hidden field to call modify_product action in index.php -->
    <input type="hidden" name="action" value="modify_product">

    <!-- Hidden field to send product ID -->
    <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

    <!-- Editable input for book name (pre-filled) -->
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['productName']); ?>" required>
    <br><br>

    <!-- Editable input for book price (pre-filled) -->
    <label>Price:</label>
    <input type="text" name="price" value="<?php echo htmlspecialchars($product['listPrice']); ?>" required>
    <br><br>

    <!-- Submit button -->
    <input type="submit" value="Save Changes">
</form>


<br>
<a href=".">View Book List</a>

<?php include('footer.php'); ?> 
