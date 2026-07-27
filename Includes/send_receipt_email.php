<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config.php';

function sendReceiptEmail(
    $customer_email,
    $customer_name,
    $total_amount,
    $payment_method,
    $transaction_code
) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int) $_ENV['MAIL_PORT'];

        // Sender
        $mail->setFrom(
            $_ENV['MAIL_FROM'],
            $_ENV['MAIL_FROM_NAME']
        );

        // Recipient
        $mail->addAddress(
            $customer_email,
            $customer_name
        );

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'Floral Culture Order Confirmation';

        $mail->Body = "
            <h2>🌸 Floral Culture Receipt</h2>

            <p>Hello <strong>{$customer_name}</strong>,</p>

            <p>Thank you for shopping with <strong>Floral Culture</strong>.</p>

            <hr>

            <p><strong>Total Amount:</strong> KSh " . number_format($total_amount, 2) . "</p>

            <p><strong>Payment Method:</strong> {$payment_method}</p>

            <p><strong>Transaction Code:</strong> {$transaction_code}</p>

            <hr>

            <p>Your order has been received successfully.</p>

            <p>We appreciate your support and look forward to serving you again.</p>

            <br>

            <p>Kind Regards,</p>
            <p><strong>Floral Culture Team</strong></p>
        ";

        $mail->AltBody =
            "Floral Culture Receipt\n\n" .
            "Customer: {$customer_name}\n" .
            "Total Amount: KSh " . number_format($total_amount, 2) . "\n" .
            "Payment Method: {$payment_method}\n" .
            "Transaction Code: {$transaction_code}\n\n" .
            "Thank you for shopping with Floral Culture.";

        $mail->send();

        return true;
    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
        return false;
    }
}