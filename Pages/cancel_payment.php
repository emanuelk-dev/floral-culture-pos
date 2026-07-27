<?php
session_start();

unset($_SESSION['pending_order']);

echo "<h2>Payment Cancelled</h2>";
echo "<p>The order was not completed.</p>";
echo "<a href='view_cart.php'>Back to Cart</a>";
?>