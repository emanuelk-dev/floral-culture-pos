<?php
session_start();
include '../includes/db_connection.php';
include '../includes/send_receipt_email.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty.");
}

if (!isset($_SESSION['pending_order'])) {
    die("No pending order found.");
}

$order = $_SESSION['pending_order'];

$customer_id = $order['customer_id'];
$customer_phone = $order['customer_phone'];
$customer_email = $order['customer_email'];
$payment_method = $order['payment_method'];

$payment_status = "Paid";
$transaction_code = strtoupper(str_replace(" ", "", $payment_method)) . "-" . time();

$conn->begin_transaction();

try {
    $grand_total = 0;

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $product_id = intval($product_id);
        $quantity = intval($quantity);

        $stmt = $conn->prepare("SELECT name, price, stock FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if (!$product) {
            continue;
        }

        if ($quantity > $product['stock']) {
            throw new Exception("Not enough stock for " . $product['name']);
        }

        $total = $product['price'] * $quantity;
        $grand_total += $total;

        $insert = $conn->prepare("
            INSERT INTO sales 
            (customer_id, product_id, quantity, total_price, sale_date, payment_method, payment_status, customer_phone, customer_email, transaction_code)
            VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?)
        ");

        $insert->bind_param(
            "iiidsssss",
            $customer_id,
            $product_id,
            $quantity,
            $total,
            $payment_method,
            $payment_status,
            $customer_phone,
            $customer_email,
            $transaction_code
        );

        $insert->execute();

        $update = $conn->prepare("
            UPDATE products 
            SET stock = stock - ? 
            WHERE id = ?
        ");

        $update->bind_param("ii", $quantity, $product_id);
        $update->execute();
    }

    $conn->commit();

    $email_sent = sendReceiptEmail(
        $customer_email,
        "Customer",
        $grand_total,
        $payment_method,
        $transaction_code
    );

    unset($_SESSION['cart']);
    unset($_SESSION['pending_order']);

} catch (Exception $e) {
    $conn->rollback();
    die("Sale failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful - Floral Culture</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #fff0f7, #f5e6ff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .success-card {
            background: white;
            width: 90%;
            max-width: 650px;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(128, 0, 128, 0.18);
            text-align: center;
        }

        .success-icon {
            font-size: 70px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        h2 {
            color: #7b1fa2;
            margin-bottom: 25px;
        }

        .info-box {
            background: #fff7fc;
            border: 1px solid #f0c4f7;
            border-radius: 15px;
            padding: 20px;
            text-align: left;
            margin-top: 20px;
        }

        .info-box p {
            margin: 12px 0;
            font-size: 16px;
        }

        .info-box strong {
            color: #8e24aa;
        }

        .email-success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 10px;
            margin-top: 15px;
            font-weight: bold;
        }

        .email-fail {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 10px;
            margin-top: 15px;
            font-weight: bold;
        }

        .dashboard-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 25px;
            background: linear-gradient(135deg, #8e24aa, #d81b60);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .dashboard-btn:hover {
            background: linear-gradient(135deg, #6a1b9a, #ad1457);
            transform: translateY(-2px);
        }

        .thank-you {
            margin-top: 15px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>

<div class="success-card">

    <div class="success-icon">✓</div>

    <h2>Payment Successful</h2>

    <div class="info-box">
        <p><strong>Total Amount:</strong> KSh <?= number_format($grand_total, 2) ?></p>

        <p><strong>Payment Method:</strong>
            <?= htmlspecialchars($payment_method) ?>
        </p>

        <p><strong>Payment Status:</strong>
            <?= htmlspecialchars($payment_status) ?>
        </p>

        <p><strong>Transaction Code:</strong>
            <?= htmlspecialchars($transaction_code) ?>
        </p>

        <p><strong>Customer Email:</strong>
            <?= htmlspecialchars($customer_email) ?>
        </p>
    </div>

    <?php if ($email_sent): ?>
        <div class="email-success">
             Receipt sent successfully to customer email.
        </div>
    <?php else: ?>
        <div class="email-fail">
             Receipt failed to send.
        </div>
    <?php endif; ?>

    <p class="thank-you">
        Thank you for choosing Floral Culture 
    </p>

    <a href="../Pages/dashboard.php" class="dashboard-btn">
        Back to Dashboard
    </a>

</div>

</body>
</html>