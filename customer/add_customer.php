<?php
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($name && $email && $phone) {
        $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, registered_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $name, $email, $phone);
        $stmt->execute();

        echo "<script>alert('Customer added successfully!'); window.location.href='customer_details.php';</script>";
        exit;
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #fff0f7, #f5e6ff);
            color: #333;
        }

        .page-container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(128, 0, 128, 0.18);
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
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

        h2 {
            text-align: center;
            color: #7b1fa2;
            margin-bottom: 25px;
        }

        .error {
            background: #ffe6e6;
            color: #b00020;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        form {
            background: #fff7fc;
            padding: 25px;
            border-radius: 15px;
            border: 1px solid #f0c4f7;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #6a1b9a;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d8a7e8;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
            margin-bottom: 18px;
        }

        input:focus {
            border-color: #8e24aa;
            box-shadow: 0 0 6px rgba(142, 36, 170, 0.3);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #8e24aa, #d81b60);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: linear-gradient(135deg, #6a1b9a, #ad1457);
        }
    </style>
</head>

<body>

<div class="page-container">

    <a href="../Products/customer_details.php" class="back-btn">
        ← Back to Customer Details
    </a>

    <h2>Add New Customer</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter customer name" required>

        <label>Email:</label>
        <input type="email" name="email" placeholder="Enter customer email" required>

        <label>Phone:</label>
        <input type="text" name="phone" placeholder="Enter customer phone number" required>

        <button type="submit">
            Save Customer
        </button>
    </form>

</div>

</body>
</html>