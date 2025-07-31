<?php
require_once '/var/www/billingerp/admin/includes/db.php';

// Product types ცხრილის შექმნა
$sql = "CREATE TABLE IF NOT EXISTS product_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(50),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

try {
    $pdo->exec($sql);
    echo "✅ Product types ცხრილი შეიქმნა წარმატებით\n";
    
    // Default product types-ების ჩასმა
    $defaultTypes = [
        ['Shared Hosting', 'გაზიარებული ჰოსტინგი - იაფი და მარტივი', 'server', 1],
        ['Reseller Hosting', 'რესელერული ჰოსტინგი - ბიზნესისთვის', 'users', 2],
        ['Server/VPS', 'ვირტუალური/დედიკატირებული სერვერი', 'server-2', 3],
        ['Domain Registration', 'დომენის რეგისტრაცია', 'world', 4],
        ['SSL Certificate', 'SSL სერტიფიკატი', 'shield-check', 5],
        ['Email Hosting', 'ელ.ფოსტის ჰოსტინგი', 'mail', 6],
        ['Cloud Storage', 'ღრუბლოვანი საცავი', 'cloud', 7],
        ['Other', 'სხვა სერვისები', 'dots', 8]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO product_types (name, description, icon, sort_order) VALUES (?, ?, ?, ?)");
    foreach ($defaultTypes as $type) {
        $stmt->execute($type);
    }
    
    echo "✅ Default product types დაემატა\n";
    
} catch (PDOException $e) {
    echo "❌ შეცდომა: " . $e->getMessage() . "\n";
}
?>
