<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - Floral Culture</title>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        display: flex;
        background-color: #ffffff;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #4B0082;
        color: white;
        padding: 30px 20px;
        position: fixed;
        overflow-y: auto;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
    }

    .sidebar a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 10px;
        margin: 10px 0;
        border-radius: 6px;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background-color: #6A0DAD;
    }

    .main {
        margin-left: 250px;
        padding: 30px;
        width: 100%;
        background-color: #faf7ff;
    }

    .top-banner {
        display: flex;
        align-items: center;
        gap: 20px;
        background: linear-gradient(135deg, #6A0DAD, #b57edc);
        color: white;
        padding: 25px;
        border-radius: 12px;
    }

    .top-banner img {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
    }

    .top-banner h1 {
        margin: 0;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
        text-align: center;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card h3 {
        color: #4B0082;
        margin-bottom: 10px;
    }

    .card p {
        color: #555;
    }

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>
        <img src="../assets/floral culture2.png" style="width:90px; border-radius:50%;">
        <div>FLORAL CULTURE</div>
    </h2>

    <a href="../Admin/Products.php">Manage Products</a>
    <a href="../Admin/Add_category.php">Manage Categories</a>
    <a href="../Admin/shop.php">POS</a>
    <a href="../Products/sales_report.php">Sales Report</a>
    <a href="../Products/manage_purchase.php">Manage Purchases</a>
    <a href="../Products/supplier_details.php">Suppliers</a>
    <a href="../Products/customer_details.php">Customers</a>
    <a href="logout.php">Logout</a>

</div>

<!-- MAIN -->
<div class="main">

    <!-- HEADER -->
    <div class="top-banner">
       
        <div>
            <h1>Welcome Back, Admin 🌸</h1>
            <p>Your floral system is running smoothly. Manage everything from here.</p>
        </div>
    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>🌷 Products</h3>
            <p>Manage all flower listings</p>
        </div>

        <div class="card">
            <h3>💰 Sales</h3>
            <p>Track completed transactions</p>
        </div>

        <div class="card">
            <h3>📦 Stock</h3>
            <p>Monitor inventory levels</p>
        </div>

        <div class="card">
            <h3>🚚 Suppliers</h3>
            <p>Manage supplier details</p>
        </div>

    </div>

</div>

</body>
</html>