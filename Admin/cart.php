<?php
session_start();
include '../includes/db_connection.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header("Location: view_cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Floral Culture Shop</title>
    <link rel="stylesheet" href="../assets/cart.css">
</head>
