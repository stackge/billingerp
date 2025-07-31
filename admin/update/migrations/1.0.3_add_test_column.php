<?php
/**
 * Migration: Add test column
 * Version: 1.0.3
 * Created: 2025-07-31 10:39:56
 */

try {
    // განახლების SQL
    $upSql = "ALTER TABLE users ADD COLUMN test_field VARCHAR(50) DEFAULT NULL";
    
    if ($upSql) {
        $pdo->exec($upSql);
        echo "✅ Add test column - წარმატებით შესრულდა\n";
    }
    
} catch (Exception $e) {
    // Rollback SQL (არასავალდებულო)
    $downSql = "";
    
    if ($downSql) {
        try {
            $pdo->exec($downSql);
            echo "⚠️ Rollback SQL შესრულდა\n";
        } catch (Exception $rollbackError) {
            echo "❌ Rollback შეცდომა: " . $rollbackError->getMessage() . "\n";
        }
    }
    
    throw new Exception("Add test column - შეცდომა: " . $e->getMessage());
}
?>