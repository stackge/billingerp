<?php
// ამ ფაილს მხოლოდ მიგრაციების სისტემა იყენებს
// თქვენი არსებული db.php არ შეიცვლება

$configFile = __DIR__ . '/../config.php';

if (!file_exists($configFile)) {
    die('მიგრაციის კონფიგურაცია ვერ მოიძებნა');
}

$config = include $configFile;

// PDO კავშირი მხოლოდ მიგრაციებისთვის
$host = $config['host'] ?? $config['db']['host'] ?? 'localhost';
$db = $config['dbname'] ?? $config['db']['name'] ?? '';
$user = $config['user'] ?? $config['db']['user'] ?? '';
$pass = $config['pass'] ?? $config['db']['pass'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ბაზასთან კავშირის შეცდომა: " . $e->getMessage());
}
?>
