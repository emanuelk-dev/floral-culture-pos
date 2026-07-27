<?php
include 'includes/db_connection.php';

$email = "admin@floralculture.com";
$password = password_hash("admin123", PASSWORD_DEFAULT); // safe hash

$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo "User added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<h2>Login to Floral Culture</h2>
    <link rel="stylesheet" href="../assets/login_styles.css">
</html>
