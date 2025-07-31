<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/smtpmodel.php';

SMTPModel::setDb($pdo);

$message = '';
$messageType = '';

// SMTP settings-ების განახლება
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_settings') {
        $settings = [
            'smtp_host' => trim($_POST['smtp_host'] ?? ''),
            'smtp_port' => trim($_POST['smtp_port'] ?? '587'),
            'smtp_secure' => $_POST['smtp_secure'] ?? 'tls',
            'smtp_auth' => isset($_POST['smtp_auth']) ? '1' : '0',
            'smtp_username' => trim($_POST['smtp_username'] ?? ''),
            'smtp_password' => $_POST['smtp_password'] ?? '',
            'smtp_from_email' => trim($_POST['smtp_from_email'] ?? ''),
            'smtp_from_name' => trim($_POST['smtp_from_name'] ?? ''),
            'smtp_debug' => $_POST['smtp_debug'] ?? '0'
        ];
        
        try {
            SMTPModel::updateMultipleSettings($settings);
            $message = 'SMTP სეტინგები წარმატებით განახლდა!';
            $messageType = 'success';
        } catch (Exception $e) {
            $message = 'შეცდომა: ' . $e->getMessage();
            $messageType = 'danger';
        }
    }
    
    // SMTP კავშირის ტესტი
    elseif ($action === 'test_connection') {
        $testEmail = trim($_POST['test_email'] ?? '');
        
        if (empty($testEmail)) {
            $result = SMTPModel::testSmtpConnection();
        } else {
            $result = SMTPModel::testSmtpConnection($testEmail);
        }
        
        $message = $result['message'];
        $messageType = $result['success'] ? 'success' : 'danger';
    }
}

// მიმდინარე settings-ების მიღება
$settings = SMTPModel::getSmtpConfig();

require_once __DIR__ . '/../views/smtp_settings.php';
?>
