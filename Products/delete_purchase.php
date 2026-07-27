<?php
include '../includes/db_connection.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM purchases WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: manage_purchase.php");
exit;
