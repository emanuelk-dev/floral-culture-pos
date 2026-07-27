<?php
session_start();
include '../includes/db_connection.php';

$cart_items = $_SESSION['cart'] ?? [];
$total = 0;

if (empty($cart_items)) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart Empty - Floral Culture</title>

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

        .empty-cart-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 8px 25px rgba(128, 0, 128, 0.18);
        }

        .cart-icon {
            font-size: 70px;
            margin-bottom: 10px;
        }

        h2 {
            color: #7b1fa2;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .shop-btn {
            display: inline-block;
            padding: 14px 25px;
            background: linear-gradient(135deg, #8e24aa, #d81b60);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .shop-btn:hover {
            background: linear-gradient(135deg, #6a1b9a, #ad1457);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

<div class="empty-cart-card">

    <div class="cart-icon">🛒</div>

    <h2>Your Cart is Empty</h2>

    <p>
        Looks like you haven't added any flowers yet.
        Browse products and add items to your cart before checkout.
    </p>

    <a href="../Admin/shop.php" class="shop-btn">
        Continue Shopping
    </a>

</div>

</body>
</html>
<?php
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Cart</title>
    <link rel="stylesheet" href="../Assets/view_cart.css">
</head>
<body>

<div class="cart-container">
<a href="../Admin/shop.php" class="back-btn">
    ← Back to POS
</a>
    <h2>Your Cart</h2>

    <table>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($cart_items as $id => $qty): ?>
            <?php
            $id = intval($id);
            $qty = intval($qty);

            $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();

            if (!$product) continue;

            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
            ?>

            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= $qty ?></td>
                <td>KSh <?= number_format($product['price'], 2) ?></td>
                <td>KSh <?= number_format($subtotal, 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="total-box">
        Total: KSh <?= number_format($total, 2) ?>
    </div>

    <form method="POST" action="checkout.php" class="checkout-form">

        <h3>Customer Information</h3>

        <label>Customer Type:</label>
        <select name="customer_type" id="customer_type" required>
            <option value="registered">Registered Customer</option>
            <option value="walkin">Walk-in / New Customer</option>
        </select>

        <div id="registered_customer_box">
            <label>Select Customer:</label>
            <select name="customer_id" id="customer_id">
                <option value="">-- Choose Customer --</option>

                <?php
                $customers = $conn->query("SELECT id, name, email, phone FROM customers ORDER BY name ASC");

                while ($c = $customers->fetch_assoc()):
                ?>
                    <option 
                        value="<?= $c['id'] ?>"
                        data-email="<?= htmlspecialchars($c['email']) ?>"
                        data-phone="<?= htmlspecialchars($c['phone']) ?>"
                    >
                        <?= htmlspecialchars($c['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <label>Customer Phone:</label>
        <input 
            type="text" 
            name="customer_phone" 
            id="customer_phone"
            placeholder="07XXXXXXXX"
            required
        >

        <label>Customer Email:</label>
        <input 
            type="email" 
            name="customer_email" 
            id="customer_email"
            placeholder="customer@email.com"
            required
        >

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="">-- Select Payment Method --</option>
            <option value="M-Pesa">M-Pesa</option>
            <option value="Cash">Cash</option>
            <option value="Card">Card</option>
        </select>

        <button type="submit" name="place_order">Place Order</button>
    </form>

</div>

<script>
    const customerType = document.getElementById('customer_type');
    const registeredBox = document.getElementById('registered_customer_box');
    const customerSelect = document.getElementById('customer_id');
    const phoneInput = document.getElementById('customer_phone');
    const emailInput = document.getElementById('customer_email');

    customerType.addEventListener('change', function () {
        if (this.value === 'walkin') {
            registeredBox.style.display = 'none';
            customerSelect.value = '';
            phoneInput.value = '';
            emailInput.value = '';
        } else {
            registeredBox.style.display = 'block';
        }
    });

    customerSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        phoneInput.value = selectedOption.getAttribute('data-phone') || '';
        emailInput.value = selectedOption.getAttribute('data-email') || '';
    });
</script>

</body>
</html>