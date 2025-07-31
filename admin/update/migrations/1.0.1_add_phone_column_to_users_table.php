<?php
/**
 * Migration: Add phone column to users table
 * Version: 1.0.1
 * Created: 2025-07-31 09:30:00
 */

try {
    // განახლების SQL
    $upSql = "ALTER TABLE users ADD COLUMN phone VARCHAR(20) DEFAULT NULL AFTER email";
    
    if ($upSql) {
        $pdo->exec($upSql);
        echo "✅ Add phone column to users table - წარმატებით შესრულდა\n";
    }
    
} catch (Exception $e) {
    // Rollback SQL (არასავალდებულო)
    $downSql = "ALTER TABLE users DROP COLUMN phone";
    
    if ($downSql) {
        try {
            $pdo->exec($downSql);
            echo "⚠️ Rollback SQL შესრულდა\n";
        } catch (Exception $rollbackError) {
            echo "❌ Rollback შეცდომა: " . $rollbackError->getMessage() . "\n";
        }
    }
    
    throw new Exception("Add phone column to users table - შეცდომა: " . $e->getMessage());
}
?>
