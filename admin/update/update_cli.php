#!/usr/bin/env php
<?php
/**
 * CLI Update Manager
 * გამოყენება: php update_cli.php [command] [options]
 */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/UpdateManager.php';

class UpdateCLI {
    private $updateManager;
    
    public function __construct($pdo) {
        $this->updateManager = new UpdateManager($pdo);
    }
    
    public function run($args) {
        if (count($args) < 2) {
            $this->showHelp();
            return;
        }
        
        $command = $args[1];
        
        switch ($command) {
            case 'status':
                $this->showStatus();
                break;
            case 'list':
                $this->listUpdates();
                break;
            case 'update':
                $version = $args[2] ?? null;
                if ($version) {
                    $this->runUpdate($version);
                } else {
                    $this->runAllUpdates();
                }
                break;
            case 'create':
                $this->createMigration($args);
                break;
            case 'history':
                $this->showHistory();
                break;
            default:
                echo "❌ უცნობი ბრძანება: $command\n";
                $this->showHelp();
        }
    }
    
    private function showStatus() {
        $currentVersion = $this->updateManager->getCurrentVersion();
        $availableUpdates = $this->updateManager->getAvailableUpdates();
        
        echo "📊 სისტემის სტატუსი\n";
        echo "==================\n";
        echo "მიმდინარე ვერსია: $currentVersion\n";
        echo "ხელმისაწვდომი განახლებები: " . count($availableUpdates) . "\n\n";
        
        if (count($availableUpdates) > 0) {
            echo "ხელმისაწვდომი განახლებები:\n";
            foreach ($availableUpdates as $update) {
                echo "  - {$update['version']}: {$update['description']}\n";
            }
        } else {
            echo "✅ ყველაფერი განახლებულია!\n";
        }
    }
    
    private function listUpdates() {
        $availableUpdates = $this->updateManager->getAvailableUpdates();
        
        echo "📋 ხელმისაწვდომი განახლებები\n";
        echo "============================\n";
        
        if (empty($availableUpdates)) {
            echo "ხელმისაწვდომი განახლებები არ არის.\n";
            return;
        }
        
        foreach ($availableUpdates as $update) {
            echo "ვერსია: {$update['version']}\n";
            echo "აღწერა: {$update['description']}\n";
            echo "ფაილი: {$update['filename']}\n";
            echo "---\n";
        }
    }
    
    private function runUpdate($version) {
        echo "🚀 განახლების გაშვება: $version\n";
        
        try {
            $result = $this->updateManager->runUpdate($version);
            echo "✅ " . $result['message'] . "\n";
        } catch (Exception $e) {
            echo "❌ შეცდომა: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    private function runAllUpdates() {
        echo "🚀 ყველა განახლების გაშვება\n";
        
        try {
            $results = $this->updateManager->runAllUpdates();
            
            foreach ($results as $result) {
                if ($result['success']) {
                    echo "✅ " . $result['message'] . "\n";
                } else {
                    echo "❌ " . $result['message'] . "\n";
                    break;
                }
            }
        } catch (Exception $e) {
            echo "❌ შეცდომა: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    private function createMigration($args) {
        if (count($args) < 5) {
            echo "❌ არასაკმარისი პარამეტრები მიგრაციის შესაქმნელად\n";
            echo "გამოყენება: php update_cli.php create <version> <description> <sql>\n";
            return;
        }
        
        $version = $args[2];
        $description = $args[3];
        $sql = $args[4];
        $rollbackSql = $args[5] ?? '';
        
        try {
            $result = $this->updateManager->createMigration($version, $description, $sql, $rollbackSql);
            echo "✅ " . $result['message'] . "\n";
        } catch (Exception $e) {
            echo "❌ შეცდომა: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    private function showHistory() {
        $history = $this->updateManager->getUpdateHistory();
        
        echo "📜 განახლებების ისტორია\n";
        echo "========================\n";
        
        if (empty($history)) {
            echo "განახლებების ისტორია ცარიელია.\n";
            return;
        }
        
        foreach ($history as $record) {
            $status = [
                'completed' => '✅',
                'failed' => '❌',
                'pending' => '⏳'
            ][$record['status']];
            
            echo "{$status} {$record['version']} - {$record['description']}\n";
            echo "   თარიღი: {$record['executed_at']}\n";
            echo "   სტატუსი: {$record['status']}\n";
            echo "---\n";
        }
    }
    
    private function showHelp() {
        echo "🔧 Update Manager CLI\n";
        echo "=====================\n\n";
        echo "ბრძანებები:\n";
        echo "  status              - სისტემის სტატუსი\n";
        echo "  list                - ხელმისაწვდომი განახლებების სია\n";
        echo "  update [version]    - განახლების გაშვება (ყველას ან კონკრეტული ვერსია)\n";
        echo "  create <version> <description> <sql> [rollback_sql] - ახალი მიგრაციის შექმნა\n";
        echo "  history             - განახლებების ისტორია\n\n";
        echo "მაგალითები:\n";
        echo "  php update_cli.php status\n";
        echo "  php update_cli.php update\n";
        echo "  php update_cli.php update 1.0.1\n";
        echo "  php update_cli.php create 1.0.3 'Add new feature' 'ALTER TABLE...'\n";
    }
}

// CLI გაშვება
if (php_sapi_name() === 'cli') {
    try {
        $cli = new UpdateCLI($pdo);
        $cli->run($argv);
    } catch (Exception $e) {
        echo "❌ კრიტიკული შეცდომა: " . $e->getMessage() . "\n";
        exit(1);
    }
} else {
    echo "ეს სკრიპტი მუშაობს მხოლოდ CLI-დან.\n";
    exit(1);
}
?>
