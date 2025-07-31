<?php
// ვიტვირთავთ კონფიგურაციას ინსტალაციის ვიზარდიდან
$configFile = __DIR__ . '/../config.php';

if (!file_exists($configFile)) {
    die('კონფიგურაციის ფაილი ვერ მოიძებნა. გთხოვთ ჯერ გაიაროთ ინსტალაციის ვიზარდი: <a href="install/">ინსტალაცია</a>');
}

$config = include $configFile;

// შევამოწმოთ არის თუ არა სისტემა ინსტალირებული
if (isset($config['app']['installed']) && $config['app']['installed'] === false) {
    die('სისტემა არ არის ინსტალირებული. გთხოვთ გაიაროთ ინსტალაციის ვიზარდი: <a href="install/">ინსტალაცია</a>');
}

// PDO სისტემა config.php-ის მიხედვით
$host = $config['host'] ?? $config['db']['host'] ?? 'localhost';
$db = $config['dbname'] ?? $config['db']['name'] ?? '';
$user = $config['user'] ?? $config['db']['user'] ?? '';
$pass = $config['pass'] ?? $config['db']['pass'] ?? '';
$charset = $config['charset'] ?? $config['db']['charset'] ?? 'utf8mb4';

if (empty($db)) {
    die('მონაცემთა ბაზის კონფიგურაცია არ არის სწორად დაყენებული.');
}

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Debug-სთვის
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // ასოც. array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // თავდასხმებისგან დაცვა
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("მონაცემთა ბაზის შეცდომა: " . $e->getMessage() . '<br>გთხოვთ შეამოწმოთ კონფიგურაცია.');
}
?>
