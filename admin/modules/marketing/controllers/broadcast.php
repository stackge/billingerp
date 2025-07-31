<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/marketingmodels.php';


MarketingModel::setDb($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientIds = $_POST['clients'] ?? [];
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($clientIds) && $subject && $message) {
        $success = MarketingModel::sendBroadcast($clientIds, $subject, $message);
        header("Location: dashboard.php?module=marketing&action=broadcast&sent=1");
        exit;
    }
}

// მხოლოდ GET მოთხოვნის დროს ჩაიტვირთოს ფორმა
require_once __DIR__ . '/../views/broadcast.php';