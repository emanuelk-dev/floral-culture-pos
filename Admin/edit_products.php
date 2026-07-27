<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Product ID is required.");
}

/* UPDATE PRODUCT */
if (isset($_POST['update_product'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("
        UPDATE products 
        SET name=?, price=?, stock=?, category_id=? 
        WHERE id=?
    ");

    $stmt->bind_param("sdiii", $name, $price, $stock, $category_id, $id);
    $stmt->execute();

    header("Location: ../Admin/Products.php");
    exit();
}

/* FETCH PRODUCT */
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

/* FETCH CATEGORIES */
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h2>Edit Product</h2>

<form method="POST">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>"><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock" value="<?= $product['stock'] ?>"><br><br>

    <label>Category:</label><br>
    <select name="category_id">
        <?php while ($cat = $categories->fetch_assoc()): ?>
            <option value="<?= $cat['id'] ?>" 
                <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit" name="update_product">Update Product</button>

</form>

</body>
</html>