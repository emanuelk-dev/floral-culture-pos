<?php
include '../includes/db_connection.php';

$result = $conn->query("SELECT p.id, pr.name AS product_name, s.name AS supplier_name, p.quantity, p.total_price, p.purchase_date
                        FROM purchases p
                        JOIN products pr ON p.product_id = pr.id
                        JOIN suppliers s ON p.supplier_id = s.id");

$monthlyData = $conn->query("
    SELECT DATE_FORMAT(purchase_date, '%Y-%m') AS month, 
           SUM(total_price) AS total
    FROM purchases
    GROUP BY month
    ORDER BY month
");

$months = [];
$totals = [];

while ($row = $monthlyData->fetch_assoc()) {
    $months[] = $row['month'];
    $totals[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Purchases</title>
    <link rel="stylesheet" href="../assets/cart.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

<h2>Manage Purchases</h2>

<a href="../Products/add_products.php" style="display: inline-block; padding: 10px 20px; background-color:rgb(160, 10, 206); color: white; font-family: 'Segoe UI', sans-serif; text-decoration: none; border-radius: 5px;">
    + Record New Purchase
</a>

<h2 style="margin-top: 40px;">Monthly Purchases Overview</h2>
<canvas id="purchaseChart" width="400" height="200"></canvas>

<script>
    const ctx = document.getElementById('purchaseChart').getContext('2d');
    const purchaseChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Total Purchases (Monthly)',
                data: <?php echo json_encode($totals); ?>,
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<table border="1" style="margin-top: 40px;">
    <tr>
        <th>ID</th>
        <th>Supplier</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Purchase Date</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['supplier_name']); ?></td>
            <td><?= htmlspecialchars($row['product_name']); ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['total_price']; ?></td>
            <td><?= $row['purchase_date']; ?></td>
            <td>
                <a href="../Products/edit_products.php?id=<?= $row['id']; ?>" style="padding:10px 20px; background-color: purple; color: white; border:none; border-radius:5px; text-decoration:none;">Edit</a>
                <a href="../Products/delete_purchase.php?id=<?= $row['id']; ?>" style="padding:10px 20px; background-color: red; color: white; border:none; border-radius:5px; text-decoration:none;" onclick="return confirm('Are you sure you want to delete this purchase?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>