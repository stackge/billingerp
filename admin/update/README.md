# განახლებების მართვის სისტემა

## 📁 სტრუქტურა

```
/admin/update/
├── index.php              # ვებ ინტერფეისი
├── UpdateManager.php      # მთავარი კლასი
├── update_cli.php         # CLI ინტერფეისი
├── README.md             # ეს ფაილი
├── migrations/           # მიგრაციის ფაილები
│   ├── 1.0.1_add_phone_column_to_users_table.php
│   └── 1.0.2_add_settings_table.php
├── versions/             # ვერსიების ინფორმაცია
└── backups/              # ავტომატური backup-ები
```

## 🌐 ვებ ინტერფეისი

ვებ ინტერფეისის გამოყენება: `/admin/update/`

### ფუნქციები:
- ✅ ხელმისაწვდომი განახლებების ჩვენება
- ✅ განახლებების გაშვება (ცალ-ცალკე ან ყველა ერთად)
- ✅ განახლებების ისტორია
- ✅ ახალი მიგრაციის შექმნა
- ✅ ავტომატური backup-ების შექმნა

## 💻 CLI ინტერფეისი

### ძირითადი ბრძანებები:

```bash
# სისტემის სტატუსი
php update_cli.php status

# ხელმისაწვდომი განახლებების სია
php update_cli.php list

# ყველა განახლების გაშვება
php update_cli.php update

# კონკრეტული ვერსიის განახლება
php update_cli.php update 1.0.1

# განახლებების ისტორია
php update_cli.php history

# ახალი მიგრაციის შექმნა
php update_cli.php create 1.0.3 "Add new feature" "ALTER TABLE users ADD COLUMN status VARCHAR(20)"
```

## 📝 მიგრაციის ფაილის ფორმატი

მიგრაციის ფაილები უნდა იყოს `migrations/` დირექტორიაში:

**ფაილის სახელი:** `{version}_{description}.php`

**მაგალითი:** `1.0.1_add_phone_column_to_users_table.php`

```php
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
```

## 🗄️ ბაზის ცხრილი

სისტემა ქმნის `version_history` ცხრილს:

```sql
CREATE TABLE version_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(20) NOT NULL,
    description TEXT,
    migration_file VARCHAR(255),
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending'
);
```

## 🔒 უსაფრთხოება

- ✅ ყოველი განახლების წინ ავტომატური database backup
- ✅ კონფიგურაციის ფაილის backup
- ✅ Rollback მხარდაჭერა
- ✅ განახლებების ვერსიების თანმიმდევრულობა
- ✅ ავტორიზაციის შემოწმება

## 📋 ვერსიების ნუმერაცია

სემანტიკური ვერსიონინგი: `MAJOR.MINOR.PATCH`

- **MAJOR**: არათავსებადი ცვლილებები
- **MINOR**: ახალი ფუნქციონალი (უკუთავსებადი)
- **PATCH**: bug fixes

## 🚨 მნიშვნელოვანი!

1. **Backup**: ყოველი განახლების წინ ავტომატურად იქმნება backup
2. **Testing**: მიგრაციები ჯერ test ბაზაზე უნდა გატესტდეს
3. **Rollback**: თუ შეცდომა მოხდა, rollback SQL ავტომატურად შესრულდება
4. **Permissions**: update/ დირექტორია უნდა იყოს writable

## 🔧 გამოყენების მაგალითები

### ახალი column-ის დამატება users ცხრილში:

```bash
php update_cli.php create 1.0.3 "Add phone field" "ALTER TABLE users ADD COLUMN phone VARCHAR(20)" "ALTER TABLE users DROP COLUMN phone"
```

### ახალი ცხრილის შექმნა:

```bash
php update_cli.php create 1.1.0 "Add logs table" "CREATE TABLE logs (id INT AUTO_INCREMENT PRIMARY KEY, message TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)" "DROP TABLE logs"
```

### მონაცემების განახლება:

```bash
php update_cli.php create 1.0.4 "Update user statuses" "UPDATE users SET status = 'active' WHERE status IS NULL"
```

## 📞 მხარდაჭერა

თუ რაიმე პრობლემა მოხდა:

1. შეამოწმეთ PHP error logs
2. გადახედეთ backups/ დირექტორიას
3. გამოიყენეთ rollback SQL მაშინ თუ საჭიროა
4. კონსულტაცია დეველოპერთან

---