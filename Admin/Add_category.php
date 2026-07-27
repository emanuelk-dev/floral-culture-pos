<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../includes/db_connection.php';

/* =========================
   ADD CATEGORY
========================= */
if (isset($_POST['add_category'])) {

    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {

        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();

        header("Location: add_categories.php");
        exit();
    }
}

/* =========================
   UPDATE CATEGORY
========================= */
if (isset($_POST['update_category'])) {

    $id = intval($_POST['category_id']);
    $new_name = trim($_POST['category_name']);

    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $new_name, $id);
    $stmt->execute();

    header("Location: add_categories.php");
    exit();
}

/* =========================
   DELETE CATEGORY (INLINE FIX)
========================= */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $check = $conn->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0) {
        echo "<script>alert('Cannot delete category with products'); window.location.href='add_categories.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: add_categories.php");
    exit();
}

/* =========================
   FETCH CATEGORIES
========================= */
$categories = $conn->query("SELECT * FROM categories ORDER BY id DESC");

/* =========================
   EDIT MODE
========================= */
$editing = false;
$edit_name = '';
$edit_id = '';

if (isset($_GET['edit'])) {

    $edit_id = intval($_GET['edit']);

    $result = $conn->query("SELECT * FROM categories WHERE id = $edit_id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $edit_name = $row['name'];
        $editing = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>

    <style>
        body { font-family: Arial; background:#fef8ff; padding:20px; }
        .container { max-width:750px; margin:auto; background:white; padding:25px; border-radius:12px; }

        form { display:flex; gap:10px; margin-bottom:20px; }
        input { flex:1; padding:10px; }

        button {
            background:#6a0dad;
            color:white;
            border:none;
            padding:10px;
            cursor:pointer;
        }

        table { width:100%; border-collapse:collapse; }
        th,td { padding:10px; border:1px solid #ddd; }

        th { background:#eee; }

        .btn-edit { background:orange; padding:5px 10px; color:white; text-decoration:none; }
        .btn-delete { background:red; padding:5px 10px; color:white; text-decoration:none; }
    </style>
</head>

<body>

<?php include '../includes/admin_nav.php'; ?>

<div class="container">

<h2>Manage Categories</h2>

<form method="POST" action="add_categories.php">

    <input type="hidden" name="category_id" value="<?= $edit_id ?>">

    <input type="text" name="category_name"
           value="<?= htmlspecialchars($edit_name) ?>"
           placeholder="Category Name" required>

    <?php if ($editing): ?>
        <button type="submit" name="update_category">Update Category</button>
    <?php else: ?>
        <button type="submit" name="add_category">Add Category</button>
    <?php endif; ?>

</form>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Actions</th>
</tr>

<?php while ($cat = $categories->fetch_assoc()): ?>
<tr>
    <td><?= $cat['id'] ?></td>
    <td><?= htmlspecialchars($cat['name']) ?></td>
    <td>
        <a class="btn-edit" href="edit_products.php?edit=<?= $cat['id'] ?>">Edit</a>
        <a class="btn-delete" href="delete_products.php?delete=<?= $cat['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</div>

</body>
</html>