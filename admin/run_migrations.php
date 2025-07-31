<?php
require 'db.php'; // აქ ქვს უკვე $pdo (არა $conn)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$executed = [];
$pdo->query("CREATE TABLE IF NOT EXISTS migration_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) UNIQUE,
    executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$res = $pdo->query("SELECT filename FROM migration_log");
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $executed[] = $row['filename'];
}

foreach (glob("migrations/*.php") as $file) {
    $filename = basename($file);
    if (!in_array($filename, $executed)) {
        include $file;
        $stmt = $pdo->prepare("INSERT INTO migration_log (filename) VALUES (:filename)");
        $stmt->execute(['filename' => $filename]);
        echo "Migration applied: $filename\n";
    }
}

echo "ok";