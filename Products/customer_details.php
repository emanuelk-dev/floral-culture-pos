<?php
include '../includes/db_connection.php';

$result = $conn->query("SELECT * FROM customers");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
    <link rel="stylesheet" href="../assets/cart.css">

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

<h2>Customer Details</h2>

<a href="../customer/add_customer.php" style="display: inline-block; padding: 10px 20px; background-color: rgb(160, 10, 206); color: white; font-family: 'Segoe UI', sans-serif; text-decoration: none; border-radius: 5px; margin-bottom: 20px;">
    + Add New Customer
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Registered At</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= $row['registration_date'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>