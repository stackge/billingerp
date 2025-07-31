<?php
/**
 * Update Manager - განახლებების მართვის სისტემა
 * ვერსია: 1.0.0
 */

class UpdateManager {
    private $pdo;
    private $currentVersion;
    private $updatePath;
    private $backupPath;
    
    public function __construct($pdo = null)
    {
        if ($pdo === null) {
            // თუ PDO არ არის გადაცემული, ვიყენებთ მიგრაციის db ფაილს
            require_once __DIR__ . '/includes/db_migration.php';
            global $pdo;
        }
        $this->pdo = $pdo;
        $this->initVersionTable();
    }
    
    /**
     * ვერსიების ცხრილის ინიციალიზაცია
     */
    private function initVersionTable() {
        $sql = "CREATE TABLE IF NOT EXISTS version_history (
            id INT AUTO_INCREMENT PRIMARY KEY,
            version VARCHAR(20) NOT NULL,
            description TEXT,
            migration_file VARCHAR(255),
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pending', 'completed', 'failed') DEFAULT 'pending'
        )";
        $this->pdo->exec($sql);
    }
    
    /**
     * მიმდინარე ვერსიის მიღება
     */
    public function getCurrentVersion() {
        try {
            $stmt = $this->pdo->query("SELECT version FROM version_history WHERE status = 'completed' ORDER BY executed_at DESC LIMIT 1");
            $result = $stmt->fetch();
            return $result ? $result['version'] : '1.0.0';
        } catch (Exception $e) {
            return '1.0.0';
        }
    }
    
    /**
     * ხელმისაწვდომი განახლებების სია
     */
    public function getAvailableUpdates() {
        $migrations = glob($this->updatePath . '/migrations/*.php');
        $available = [];
        
        foreach ($migrations as $file) {
            $filename = basename($file);
            if (preg_match('/^(\d+\.\d+\.\d+)_(.+)\.php$/', $filename, $matches)) {
                $version = $matches[1];
                $description = str_replace('_', ' ', $matches[2]);
                
                // შევამოწმოთ უკვე გაშვებულია თუ არა
                $stmt = $this->pdo->prepare("SELECT id FROM version_history WHERE version = ? AND status = 'completed'");
                $stmt->execute([$version]);
                
                if (!$stmt->fetch()) {
                    $available[] = [
                        'version' => $version,
                        'description' => $description,
                        'file' => $file,
                        'filename' => $filename
                    ];
                }
            }
        }
        
        // ვერსიის მიხედვით დალაგება
        usort($available, function($a, $b) {
            return version_compare($a['version'], $b['version']);
        });
        
        return $available;
    }
    
    /**
     * განახლების გაშვება
     */
    public function runUpdate($version) {
        $updates = $this->getAvailableUpdates();
        $updateToRun = null;
        
        foreach ($updates as $update) {
            if ($update['version'] === $version) {
                $updateToRun = $update;
                break;
            }
        }
        
        if (!$updateToRun) {
            throw new Exception("განახლება ვერსია $version ვერ მოიძებნა");
        }
        
        // backup-ის შექმნა
        $this->createBackup($version);
        
        // განახლების ჩანაწერი
        $stmt = $this->pdo->prepare("INSERT INTO version_history (version, description, migration_file, status) VALUES (?, ?, ?, 'pending')");
        $stmt->execute([$version, $updateToRun['description'], $updateToRun['filename']]);
        $updateId = $this->pdo->lastInsertId();
        
        try {
            // მიგრაციის ფაილის ჩატვირთვა და გაშვება
            require_once $updateToRun['file'];
            
            // განახლების სტატუსის შეცვლა
            $stmt = $this->pdo->prepare("UPDATE version_history SET status = 'completed' WHERE id = ?");
            $stmt->execute([$updateId]);
            
            return [
                'success' => true,
                'message' => "განახლება $version წარმატებით დასრულდა",
                'version' => $version
            ];
            
        } catch (Exception $e) {
            // შეცდომის მტკიცების ჩანაწერი
            $stmt = $this->pdo->prepare("UPDATE version_history SET status = 'failed' WHERE id = ?");
            $stmt->execute([$updateId]);
            
            throw new Exception("განახლების შეცდომა: " . $e->getMessage());
        }
    }
    
    /**
     * ყველა ხელმისაწვდომი განახლების გაშვება
     */
    public function runAllUpdates() {
        $updates = $this->getAvailableUpdates();
        $results = [];
        
        foreach ($updates as $update) {
            try {
                $result = $this->runUpdate($update['version']);
                $results[] = $result;
            } catch (Exception $e) {
                $results[] = [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'version' => $update['version']
                ];
                break; // შეწყვიტოს შემდგომი განახლებები შეცდომის შემთხვევაში
            }
        }
        
        return $results;
    }
    
    /**
     * Backup-ის შექმნა
     */
    private function createBackup($version) {
        $backupDir = $this->backupPath . '/backup_' . $version . '_' . date('Y-m-d_H-i-s');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        // ბაზის backup
        $config = include __DIR__ . '/../config.php';
        $dumpFile = $backupDir . '/database_backup.sql';
        
        $command = sprintf(
            'mysqldump -h%s -u%s -p%s %s > %s',
            escapeshellarg($config['host']),
            escapeshellarg($config['user']),
            escapeshellarg($config['pass']),
            escapeshellarg($config['dbname']),
            escapeshellarg($dumpFile)
        );
        
        exec($command, $output, $returnVar);
        
        if ($returnVar !== 0) {
            throw new Exception("ბაზის backup ვერ შეიქმნა");
        }
        
        // კონფიგურაციის ფაილის backup
        copy(__DIR__ . '/../config.php', $backupDir . '/config_backup.php');
        
        return $backupDir;
    }
    
    /**
     * განახლებების ისტორია
     */
    public function getUpdateHistory() {
        $stmt = $this->pdo->query("SELECT * FROM version_history ORDER BY executed_at DESC");
        return $stmt->fetchAll();
    }
    
    /**
     * ახალი მიგრაციის ფაილის შექმნა
     */
    public function createMigration($version, $description, $upSql, $downSql = '') {
        $filename = $version . '_' . str_replace(' ', '_', strtolower($description)) . '.php';
        $filepath = $this->updatePath . '/migrations/' . $filename;
        
        $template = $this->getMigrationTemplate($version, $description, $upSql, $downSql);
        
        if (file_put_contents($filepath, $template)) {
            return [
                'success' => true,
                'message' => "მიგრაციის ფაილი შეიქმნა: $filename",
                'file' => $filepath
            ];
        } else {
            throw new Exception("მიგრაციის ფაილის შექმნა ვერ მოხერხდა");
        }
    }
    
    /**
     * მიგრაციის ფაილის შაბლონი
     */
    private function getMigrationTemplate($version, $description, $upSql, $downSql) {
        return "<?php
/**
 * Migration: $description
 * Version: $version
 * Created: " . date('Y-m-d H:i:s') . "
 */

try {
    // განახლების SQL
    \$upSql = \"$upSql\";
    
    if (\$upSql) {
        \$pdo->exec(\$upSql);
        echo \"✅ $description - წარმატებით შესრულდა\\n\";
    }
    
} catch (Exception \$e) {
    // Rollback SQL (არასავალდებულო)
    \$downSql = \"$downSql\";
    
    if (\$downSql) {
        try {
            \$pdo->exec(\$downSql);
            echo \"⚠️ Rollback SQL შესრულდა\\n\";
        } catch (Exception \$rollbackError) {
            echo \"❌ Rollback შეცდომა: \" . \$rollbackError->getMessage() . \"\\n\";
        }
    }
    
    throw new Exception(\"$description - შეცდომა: \" . \$e->getMessage());
}
?>";
    }
}
?>
