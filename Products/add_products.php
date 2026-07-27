<?php
include '../includes/db_connection.php';

// Fetch products and suppliers for the dropdowns
$product_result = $conn->query("SELECT id, name FROM products");
$supplier_result = $conn->query("SELECT id, name FROM suppliers");

if (isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $supplier_id = $_POST['supplier_id'];
    $quantity = $_POST['quantity'];
    $price_per_unit = $_POST['price'];
    $total_price = $quantity * $price_per_unit;

    $stmt = $conn->prepare("INSERT INTO purchases (product_id, supplier_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $product_id, $supplier_id, $quantity, $total_price);
    $stmt->execute();

    echo "<script>alert('Purchase recorded successfully!'); window.location.href='manage_purchase.php';</script>";
}
?>

<h2>Record Purchase</h2>
<link rel="stylesheet" href="../assets/cart.css">
<form method="post">
    <label>Product:</label>
    <select name="product_id" required>
        <?php while($row = $product_result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Supplier:</label>
    <select name="supplier_id" required>
        <?php while($row = $supplier_result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label>Quantity:</label>
    <input type="number" name="quantity" min="1" required><br><br>

    <label>Price per Unit:</label>
    <input type="number" name="price" step="0.01" required><br><br>

    <button type="submit" name="submit">Record Purchase</button>
</form>
