<?php

// 📬 გადახდის შეხსენების გაგზავნა

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require '../../libs/phpmailer/src/PHPMailer.php';
require '../../libs/phpmailer/src/SMTP.php';
require '../../libs/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

foreach ($invoices as $invoice) {
    $mail = new PHPMailer(true);

    try {
        // SMTP პარამეტრები
        $mail->isSMTP();
        $mail->Host = 'vps-7146dd3a.vps.ovh.ca';
        $mail->SMTPAuth = true;
        $mail->Username = 'levan@arabuli.info';
        $mail->Password = 'Aqsxcs@1211';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $clientName = $invoice['first_name'] . ' ' . $invoice['last_name'];

        $mail->setFrom('levan@arabuli.info', 'Billing System');
        $mail->addAddress($invoice['email'], $clientName);

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = "გადახდის შეხსენება ინვოისზე #{$invoice['invoice_number']}";
        $mail->Body = "
            გამარჯობა {$clientName},<br><br>
            გთხოვთ გადაიხადოთ ინვოისი #{$invoice['invoice_number']} <strong>{$invoice['total_amount']} ₾</strong><br>
            გადახდის ბოლო ვადაა: <strong>{$invoice['due_date']}</strong><br><br>
            იხილეთ ინვოისი: <a href='https://yourdomain.com/dashboard.php?module=billing&submodule=invoices&action=view&id={$invoice['id']}'>იხილეთ ინვოისი</a>
        ";

        $mail->send();
        echo "✅ შეხსენება გაიგზავნა {$clientName} ({$invoice['email']})<br>";
    } catch (Exception $e) {
        echo "❌ შეცდომა: {$mail->ErrorInfo}<br>";
    }
}
