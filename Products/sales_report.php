<?php
include '../includes/db_connection.php';

$sql = "SELECT 
            s.id, 
            COALESCE(c.name, 'Walk-in Customer') AS customer_name,
            p.name AS product_name, 
            s.quantity, 
            s.total_price, 
            s.payment_method,
            s.payment_status,
            s.customer_phone,
            s.customer_email,
            s.transaction_code,
            s.sale_date
        FROM sales s
        LEFT JOIN customers c ON s.customer_id = c.id
        JOIN products p ON s.product_id = p.id
        ORDER BY s.sale_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <link rel="stylesheet" href="../Assets/cart.css">

    <style>
        .back-btn {
            display: inline-block;
            margin: 15px 0;
            padding: 10px 18px;
            background: linear-gradient(135deg, #8e24aa, #d81b60);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #6a1b9a, #ad1457);
        }
    </style>
</head>
<body>

<a href="../Pages/dashboard.php" class="back-btn">← Back to Dashboard</a>

<h2>Sales Report</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Total (Ksh)</th>
        <th>Payment Method</th>
        <th>Status</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Transaction Code</th>
        <th>Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($row['total_price'], 2) ?></td>
            <td><?= htmlspecialchars($row['payment_method']) ?></td>
            <td><?= htmlspecialchars($row['payment_status']) ?></td>
            <td><?= htmlspecialchars($row['customer_phone']) ?></td>
            <td><?= htmlspecialchars($row['customer_email']) ?></td>
            <td><?= htmlspecialchars($row['transaction_code']) ?></td>
            <td><?= $row['sale_date'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>