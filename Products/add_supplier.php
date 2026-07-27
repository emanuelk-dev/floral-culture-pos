<?php
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO suppliers (name, contact, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $contact, $email);
    $stmt->execute();

    echo "<script>alert('Supplier added successfully!'); window.location.href='supplier_details.php';</script>";
}
?>

<h2>Add Supplier</h2>
<link rel="stylesheet" href="../assets/cart.css">
<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Contact:</label><br>
    <input type="text" name="contact"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <button type="submit" style="padding: 10px 20px; background-color: purple; color: white; border: none; border-radius: 5px;">
        Add Supplier
    </button>
</form>
