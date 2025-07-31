<?php
/**
 * Migration: Add settings table
 * Version: 1.0.2
 * Created: 2025-07-31 09:35:00
 */

try {
    // განახლების SQL
    $upSql = "CREATE TABLE IF NOT EXISTS system_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($upSql) {
        $pdo->exec($upSql);
        
        // დაყენება default settings
        $defaultSettings = [
            ['app_name', 'BillingERP', 'აპლიკაციის სახელი'],
            ['app_version', '1.0.2', 'აპლიკაციის ვერსია'],
            ['maintenance_mode', '0', 'მოვლის რეჟიმი'],
            ['max_file_size', '10485760', 'ფაილის მაქსიმალური ზომა (bytes)']
        ];
        
        $stmt = $pdo->prepare("INSERT IGNORE INTO system_settings (setting_key, setting_value, description) VALUES (?, ?, ?)");
        foreach ($defaultSettings as $setting) {
            $stmt->execute($setting);
        }
        
        echo "✅ Add settings table - წარმატებით შესრულდა\n";
    }
    
} catch (Exception $e) {
    // Rollback SQL (არასავალდებულო)
    $downSql = "DROP TABLE IF EXISTS system_settings";
    
    if ($downSql) {
        try {
            $pdo->exec($downSql);
            echo "⚠️ Rollback SQL შესრულდა\n";
        } catch (Exception $rollbackError) {
            echo "❌ Rollback შეცდომა: " . $rollbackError->getMessage() . "\n";
        }
    }
    
    throw new Exception("Add settings table - შეცდომა: " . $e->getMessage());
}
?>
