<?php
/**
 * Migration: Add SMTP settings table
 * Version: 1.0.4
 * Created: 2025-07-31 11:00:00
 */

try {
    // SMTP settings ცხრილის შექმნა
    $upSql = "CREATE TABLE smtp_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        description VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($upSql) {
        $pdo->exec($upSql);
        
        // Default SMTP settings-ების ჩასმა
        $defaultSettings = [
            ['smtp_host', 'vps-7146dd3a.vps.ovh.ca', 'SMTP სერვერის მისამართი'],
            ['smtp_port', '465', 'SMTP პორტი'],
            ['smtp_secure', 'ssl', 'SMTP უსაფრთხოება (ssl/tls)'],
            ['smtp_auth', '1', 'SMTP ავტორიზაცია (0/1)'],
            ['smtp_username', 'noreply@selfhosting.ge', 'SMTP მომხმარებლის სახელი'],
            ['smtp_password', 'FSZtTIIIlubk', 'SMTP პაროლი'],
            ['smtp_from_email', 'noreply@selfhosting.ge', 'გამომგზავნის ელ.ფოსტა'],
            ['smtp_from_name', 'SelfHosting.ge', 'გამომგზავნის სახელი'],
            ['smtp_debug', '0', 'Debug რეჟიმი (0-2)']
        ];
        
        $stmt = $pdo->prepare("INSERT INTO smtp_settings (setting_key, setting_value, description) VALUES (?, ?, ?)");
        foreach ($defaultSettings as $setting) {
            $stmt->execute($setting);
        }
        
        echo "✅ Add SMTP settings table - წარმატებით შესრულდა\n";
    }
    
} catch (Exception $e) {
    // Rollback SQL
    $downSql = "DROP TABLE IF EXISTS smtp_settings";
    
    if ($downSql) {
        try {
            $pdo->exec($downSql);
            echo "⚠️ Rollback SQL შესრულდა\n";
        } catch (Exception $rollbackError) {
            echo "❌ Rollback შეცდომა: " . $rollbackError->getMessage() . "\n";
        }
    }
    
    throw new Exception("Add SMTP settings table - შეცდომა: " . $e->getMessage());
}
?>
