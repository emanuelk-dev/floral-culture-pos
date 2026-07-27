<?php
session_start();

if (!isset($_SESSION['pending_order'])) {
    die("No pending payment found.");
}

$order = $_SESSION['pending_order'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirm Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .popup {
            width: 420px;
            margin: 80px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 12px rgba(0,0,0,0.3);
        }

        .title {
            color: green;
            font-size: 26px;
            font-weight: bold;
        }

        .confirm {
            background: green;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .cancel {
            background: red;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="popup">
    <div class="title"><?= htmlspecialchars($order['payment_method']) ?> Payment</div>

    <h3>Confirm Payment</h3>

    <p>Pay <strong>KSh <?= number_format($order['grand_total'], 2) ?></strong></p>
    <p>To <strong>Floral Culture</strong></p>
    <p>Phone: <strong><?= htmlspecialchars($order['customer_phone']) ?></strong></p>
    <p>Email: <strong><?= htmlspecialchars($order['customer_email']) ?></strong></p>

    <form action="../Pages/complete_payment.php" method="POST">
        <button type="submit" class="confirm">Confirm Payment</button>
    </form>

    <br>

    <form action="cancel_payment.php" method="POST">
        <button type="submit" class="cancel">Cancel Payment</button>
    </form>
</div>

</body>
</html>