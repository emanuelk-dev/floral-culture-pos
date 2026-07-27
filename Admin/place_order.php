<?php
session_start();
include '../includes/db_connection.php';

// Simulated customer ID from session (replace with your actual logic)
$customer_id = $_SESSION['customer_id'] ?? 1;
$payment_method = $_POST['payment_method'] ?? 'Cash';

// Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Cart is empty!";
    exit;
}

// 1. Insert order record
$stmt = $conn->prepare("INSERT INTO order_list (customer_id, payment_method, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("is", $customer_id, $payment_method);
$stmt->execute();

$order_id = $stmt->insert_id;

// 2. Loop through cart items
foreach ($_SESSION['cart'] as $product_id) {
    $quantity = 1; // Default quantity if not stored

    // Get price from DB
    $price_query = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $price_query->bind_param("i", $product_id);
    $price_query->execute();
    $result = $price_query->get_result();
    $row = $result->fetch_assoc();

    if (!$row) continue; // Skip if product not found

    $price = $row['price'];
    $total_price = $price * $quantity;

    // Insert into sales
    $sales_stmt = $conn->prepare("INSERT INTO sales (customer_id, product_id, quantity, total_price, sale_date)
                                  VALUES (?, ?, ?, ?, NOW())");
    $sales_stmt->bind_param("iiid", $customer_id, $product_id, $quantity, $total_price);
    $sales_stmt->execute();
}

// 3. Clear cart
unset($_SESSION['cart']);

// 4. Redirect or display success
echo "<script>alert('Order placed successfully!'); window.location.href='sales_report.php';</script>";
?>
