<?php
session_start();
include '../includes/db_connection.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty.");
}

if (!isset($_POST['customer_id'], $_POST['customer_phone'], $_POST['customer_email'], $_POST['payment_method'])) {
    die("Missing checkout details.");
}

$customer_type = $_POST['customer_type'] ?? 'registered';

if ($customer_type === 'walkin') {
    $customer_id = null;
} else {
    $customer_id = intval($_POST['customer_id']);
}
$customer_phone = trim($_POST['customer_phone']);
$customer_email = trim($_POST['customer_email']);
$payment_method = trim($_POST['payment_method']);

$grand_total = 0;

foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $product_id = intval($product_id);
    $quantity = intval($quantity);

    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        $grand_total += $product['price'] * $quantity;
    }
}

$_SESSION['pending_order'] = [
    'customer_id' => $customer_id,
    'customer_phone' => $customer_phone,
    'customer_email' => $customer_email,
    'payment_method' => $payment_method,
    'grand_total' => $grand_total
];

header("Location: ../Pages/confirm_payment.php");
exit();
?>