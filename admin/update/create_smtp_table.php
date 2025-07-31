<?php
require_once '/var/www/billingerp/admin/includes/db.php';

// SMTP settings ცხრილის შექმნა
$sql = "CREATE TABLE IF NOT EXISTS smtp_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

try {
    $pdo->exec($sql);
    echo "✅ SMTP settings ცხრილი შეიქმნა წარმატებით\n";
    
    // Default settings-ების ჩასმა
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
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO smtp_settings (setting_key, setting_value, description) VALUES (?, ?, ?)");
    foreach ($defaultSettings as $setting) {
        $stmt->execute($setting);
    }
    
    echo "✅ Default SMTP settings დაემატა\n";
    
} catch (PDOException $e) {
    echo "❌ შეცდომა: " . $e->getMessage() . "\n";
}
?>
