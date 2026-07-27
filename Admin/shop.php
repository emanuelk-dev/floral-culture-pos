<?php
session_start();
include '../includes/db_connection.php';

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Get product stock check
    $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product || $product['stock'] <= 0) {
        die("Product is out of stock.");
    }

    if ($quantity > $product['stock']) {
        $quantity = $product['stock'];
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header("Location: shop.php");
    exit();
}

// Fetch products WITH STOCK
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Floral Culture Shop</title>
    <link rel="stylesheet" href="../assets/pos_styles.css">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff0f5;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #4B0082;
        }

        .view-cart-btn {
            display: block;
            width: fit-content;
            margin: 0 auto 20px auto;
            background-color: #4B0082;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product {
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .product img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product h3 {
            color: #4B0082;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        button {
            background-color: #6A0DAD;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #530086;
        }

        .out {
            color: red;
            font-weight: bold;
        }

        .low {
            color: orange;
            font-weight: bold;
        }

        .ok {
            color: green;
        }
    </style>
</head>

<body>
<?php include '../includes/admin_nav.php'; ?>
<h2>Shop Our Flowers</h2>

<a class="view-cart-btn" href="view_cart.php">
    🛒 View Cart (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)
</a>

<div class="products">

<?php while($row = $products->fetch_assoc()): ?>

    <div class="product">

        <?php if (!empty($row['image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($row['image']) ?>">
        <?php else: ?>
            <img src="../assets/placeholder.jpg">
        <?php endif; ?>

        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>Price: <?= $row['price'] ?> KES</p>

        <!-- STOCK STATUS -->
        <?php if ($row['stock'] <= 0): ?>
            <p class="out">🔴 Out of Stock</p>

        <?php elseif ($row['stock'] <= 5): ?>
            <p class="low">🟡 Low Stock: <?= $row['stock'] ?> left</p>

        <?php else: ?>
            <p class="ok">In Stock: <?= $row['stock'] ?></p>
        <?php endif; ?>

        <!-- ADD TO CART -->
        <?php if ($row['stock'] > 0): ?>
            <form method="POST" action="shop.php">

                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">

                <input type="number"
                       name="quantity"
                       value="1"
                       min="1"
                       max="<?= $row['stock'] ?>">

                <button type="submit" name="add_to_cart">
                    Add to Cart
                </button>

            </form>
        <?php else: ?>
            <button disabled style="background: gray;">Out of Stock</button>
        <?php endif; ?>

    </div>

<?php endwhile; ?>

</div>

</body>
</html>