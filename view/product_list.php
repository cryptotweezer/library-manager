<?php include('header.php'); ?> 

<!-- Main heading with a link to show all books -->
<h2 style="color: orange;">
    <a href="." style="text-decoration: none; color: orange;">Book List</a>
</h2>

<!-- Layout: sidebar and main content side-by-side -->
<div class="main-container" style="display: flex; gap: 40px; align-items: flex-start;">

    <!-- Sidebar: shows all categories as links -->
    <div class="sidebar">
        <h3>Categories</h3>
        <ul style="list-style-type: none; padding: 0;">
            <?php foreach ($categories as $category) : ?> <!-- ✅ Uses array and foreach (rubric) -->
                <li style="margin-bottom: 8px;">
                    <a href=".?category_id=<?php echo $category['categoryID']; ?>">
                        <?php echo htmlspecialchars($category['categoryName']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Book list for selected category -->
    <div class="booklist">
        <h3 style="color: orange;"><?php echo $category_name; ?></h3> <!-- Dynamic category name -->

        <table border="1" cellpadding="5">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th> 
            </tr>

            <?php foreach ($products as $product) : ?> <!--Uses array and foreach (rubric) -->
                <tr>
                    <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                    <td><?php echo htmlspecialchars($product['productName']); ?></td>
                    <td><?php echo htmlspecialchars($product['listPrice']); ?></td>
                    <td>
                        <!-- Delete form -->
                        <form action="." method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete_product"> <!--delete functionality-->
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <input type="submit" value="Delete">
                        </form>

                        <!-- Modify form -->
                        <form action="." method="post" style="display:inline;">
                            <input type="hidden" name="action" value="show_modify_form"> <!-- modify functionality-->
                            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                            <input type="submit" value="Modify">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Functional links for additional actions -->
        <div style="margin-top: 20px;">
            <a href=".?action=show_add_form">Add Book</a><br><br> <!-- ✅ add functionality (rubric) -->

            <!-- Sort options (ASC/DESC) -->
            <a href=".?action=sort_books&order=ASC<?php if (isset($category_id) && $category_id) echo "&category_id=$category_id"; ?>">
                Sort Book in Ascending Order
            </a><br><br>
            <a href=".?action=sort_books&order=DESC<?php if (isset($category_id) && $category_id) echo "&category_id=$category_id"; ?>">
                Sort Book in Descending Order
            </a> 
        </div>
    </div>
</div>

<?php include('footer.php'); ?> 
