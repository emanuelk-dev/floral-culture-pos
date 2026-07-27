<?php
include '../includes/db_connection.php';

$result = $conn->query("SELECT * FROM suppliers");
?>

<h2>Supplier Details</h2>
<a href="add_supplier.php" style="display: inline-block; padding: 10px 20px; background-color: purple; color: white; text-decoration: none; border-radius: 8px; font-weight: bold;">
    + Add Supplier
</a>

 <link rel="stylesheet" href="../assets/cart.css">
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['contact'] ?></td>
        
    </tr>
    <?php endwhile; ?>
</table>
