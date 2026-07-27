<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connection.php';

// Fetch all products
$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products - Floral Culture</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
    background-color: #fef8ff;
    margin: 0;
    padding: 20px;
        }
        .container {
            padding: 30px;
        }
        h2 {
            color: #4B0082;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4B0082;
            color: white;
        }
        tr:hover {
            background-color: #f3e6f8;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }
        .add-btn {
            background-color: #6A0DAD;
            color: white;
            margin-bottom: 15px;
        }
        .edit-btn {
            background-color: #f39c12;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <?php include '../includes/admin_nav.php'; ?>
    <div class="container">
        <h2>Manage Products</h2>
       <p> <a href="add_product.php" class="btn add-btn">+ Add New Product</a> </p>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (KES)</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="../uploads/<?= $row['image'] ?>" width="50">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                <a href="../Products/edit_products.php?id=<?= $row['id']; ?>" style="padding:10px 20px; background-color: purple; color: white; border:none; border-radius:5px;">Edit</a>
                <a href="../Products/delete_purchase.php?id=<?= $row['id']; ?>" style="padding:10px 20px; background-color: red; color: white; border:none; border-radius:5px;" onclick="return confirm('Are you sure you want to delete this purchase?');">Delete</a>
            </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
