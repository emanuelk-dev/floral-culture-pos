<?php
session_start();
include 'includes/db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Wrong password, try again.";
    }
} else {
    echo "No account found with that email.";
}

$stmt->close();
$conn->close();
?>
<html>

<head>
    <title>Admin Login - Floral Culture</title>
    <link rel="stylesheet" href="../assets/login_styles.css">
</head>
</html>