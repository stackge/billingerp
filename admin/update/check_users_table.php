<?php
require_once '/var/www/billingerp/admin/includes/db.php';

try {
    // ვამოწმებთ users ცხრილის სტრუქტურას
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "✅ Users ცხრილის მიმდინარე სტრუქტურა:\n";
    foreach ($columns as $column) {
        echo "  - $column\n";
    }
    
    // ვამოწმებთ საჭირო სვეტები
    $requiredColumns = ['role', 'is_active', 'updated_at'];
    $missingColumns = [];
    
    foreach ($requiredColumns as $requiredColumn) {
        if (!in_array($requiredColumn, $columns)) {
            $missingColumns[] = $requiredColumn;
        }
    }
    
    if (!empty($missingColumns)) {
        echo "\n🔧 დაკლებული სვეტების დამატება:\n";
        
        foreach ($missingColumns as $column) {
            switch ($column) {
                case 'role':
                    $sql = "ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user'";
                    $pdo->exec($sql);
                    echo "  ✅ role სვეტი დაემატა\n";
                    break;
                    
                case 'is_active':
                    $sql = "ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1";
                    $pdo->exec($sql);
                    echo "  ✅ is_active სვეტი დაემატა\n";
                    break;
                    
                case 'updated_at':
                    $sql = "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP";
                    $pdo->exec($sql);
                    echo "  ✅ updated_at სვეტი დაემატა\n";
                    break;
            }
        }
        
        // default admin role-ის დაყენება
        $pdo->exec("UPDATE users SET role = 'admin' WHERE id = 1");
        echo "  ✅ Default admin role დაყენდა\n";
        
    } else {
        echo "\n✅ ყველა საჭირო სვეტი არსებობს!\n";
    }
    
    // Users-ების რაოდენობის შემოწმება
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();
    echo "\n📊 სისტემაში არსებული მომხმარებლების რაოდენობა: $userCount\n";
    
} catch (PDOException $e) {
    echo "❌ შეცდომა: " . $e->getMessage() . "\n";
}
?>
