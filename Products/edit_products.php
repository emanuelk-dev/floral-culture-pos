<?php
include '../includes/db_connection.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "No purchase ID specified!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    $stmt = $conn->prepare("UPDATE purchases SET quantity=?, total_price=? WHERE id=?");
    $stmt->bind_param("idi", $quantity, $total_price, $id);
    $stmt->execute();

    echo "<script>alert('Purchase updated!'); window.location.href='manage_purchase.php';</script>";
    exit;
}

// Fetch existing purchase data
$result = $conn->query("SELECT * FROM purchases WHERE id = $id");
$purchase = $result->fetch_assoc();
?>

<h2>Edit Purchase</h2>
 <link rel="stylesheet" href="../assets/cart.css">
<form method="POST">
    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="<?php echo $purchase['quantity']; ?>" required><br><br>

    <label>Total Price:</label><br>
    <input type="number" step="0.01" name="total_price" value="<?php echo $purchase['total_price']; ?>" required><br><br>

    <button type="submit" style="padding:10px 20px; background-color: purple; color: white; border:none; border-radius:5px;">Update</button>
</form>
