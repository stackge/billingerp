<?php
if (!file_exists(__DIR__ . '/install.lock')) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ინსტალაცია დასრულებული</title>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 600px; 
            margin: 50px auto; 
            padding: 20px; 
            text-align: center; 
        }
        h2 { color: #28a745; }
        .success-icon { font-size: 48px; color: #28a745; margin-bottom: 20px; }
        .warning { 
            background: #fff3cd; 
            border: 1px solid #ffeaa7; 
            padding: 15px; 
            border-radius: 4px; 
            margin: 20px 0; 
            color: #856404; 
        }
        .btn { 
            background: #007cba; 
            color: white; 
            padding: 12px 24px; 
            text-decoration: none; 
            border-radius: 4px; 
            display: inline-block; 
            margin: 10px; 
        }
        .btn:hover { background: #005a87; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="success-icon">✅</div>
    <h2>ინსტალაცია წარმატებით დასრულდა!</h2>
    
    <p>თქვენი სისტემა მზად არის გამოსაყენებლად.</p>
    
    <div class="warning">
        <strong>უსაფრთხოების მიზნებისთვის:</strong><br>
        გთხოვთ წაშალოთ <code>/install</code> დირექტორია სისტემიდან.<br>
        <code>rm -rf <?= __DIR__ ?></code>
    </div>
    
    <div>
        <a href="../login.php" class="btn">ავტორიზაცია</a>
        <a href="../dashboard.php" class="btn">ადმინ პანელი</a>
    </div>
    
    <div style="margin-top: 30px;">
        <a href="#" onclick="if(confirm('დარწმუნებული ხართ?')) { fetch('cleanup.php'); alert('install ფოლდერი წაშლილია'); }" class="btn btn-danger">Install ფოლდერის წაშლა</a>
    </div>
</body>
</html>
