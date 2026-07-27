<?php

include '../includes/send_receipt_email.php';

$email_sent = sendReceiptEmail(
    'shamrankyeswa@gmail.com',
    'Shamran',
    2500,
    'M-Pesa',
    'TEST-123456'
);

if ($email_sent) {
    echo "<h2>Email Sent Successfully!</h2>";
} else {
    echo "<h2>Email Failed to Send!</h2>";
}