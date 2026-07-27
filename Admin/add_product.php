<?php 
session_start();
include '../includes/db_connection.php';

// Fetch categories
$categories_result = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Image Upload
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "../uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_path = $target_dir . time() . '_' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (name, category_id, price, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sidis", $name, $category_id, $price, $stock, $image_path);

    if ($stmt->execute()) {
        $success = "Product added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Floral Culture</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #fff0f7, #f5e6ff);
            color: #333;
        }

        .page-wrapper {
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(128, 0, 128, 0.18);
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 18px;
            background: linear-gradient(135deg, #8e24aa, #d81b60);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #6a1b9a, #ad1457);
            transform: translateY(-2px);
        }

        h2 {
            text-align: center;
            color: #7b1fa2;
            margin-bottom: 25px;
            font-size: 30px;
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

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d8a7e8;
            border-radius: 10px;
            font-size: 15px;
            box-sizing: border-box;
            margin-bottom: 18px;
            background: white;
        }

        input:focus,
        select:focus {
            border-color: #8e24aa;
            box-shadow: 0 0 6px rgba(142, 36, 170, 0.3);
            outline: none;
        }

        input[type="file"] {
            padding: 10px;
            cursor: pointer;
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
            transition: 0.3s;
        }

        button:hover {
            background: linear-gradient(135deg, #6a1b9a, #ad1457);
            transform: translateY(-2px);
        }

        .success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .error {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .hint {
            font-size: 13px;
            color: #777;
            margin-top: -12px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>

<?php 
if (file_exists('../includes/admin_nav.php')) {
    include '../includes/admin_nav.php'; 
}
?>

<div class="page-wrapper">
    <div class="container">

        <div class="top-actions">
            <a href="products.php" class="back-btn">← Back to Product List</a>
    
        </div>

        <h2>Add New Product</h2>

        <?php if (isset($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="name" placeholder="Enter product name" required>

            <label>Category:</label>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php while($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?= $category['id']; ?>">
                        <?= htmlspecialchars($category['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" placeholder="Enter product price" required>

            <label>Stock Quantity:</label>
            <input type="number" name="stock" placeholder="Enter stock quantity" required>

            <label>Product Image:</label>
            <input type="file" name="image" accept="image/*">
            <div class="hint">Upload a clear product image for the flower item.</div>

            <button type="submit">Add Product</button>
        </form>

    </div>
</div>

</body>
</html>