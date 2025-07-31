<?php
$config = include __DIR__ . '/../config.php';
$conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

if ($conn->connect_error) {
    die("ბაზასთან კავშირის შეცდომა: " . $conn->connect_error);
}

$sqlFile = __DIR__ . '/structure.sql';
if (!file_exists($sqlFile)) {
    die("SQL ფაილი ვერ მოიძებნა: structure.sql");
}

$sql = file_get_contents($sqlFile);
$success = true;
$errorMessage = '';

// Execute multi-query
if ($conn->multi_query($sql)) {
    do {
        // Process results
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    
    // Check for errors
    if ($conn->error) {
        $success = false;
        $errorMessage = $conn->error;
    }
} else {
    $success = false;
    $errorMessage = $conn->error;
}

if ($success) {
    // Auto-redirect after 2 seconds
    header("refresh:2;url=step4_admin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ინსტალაცია – ნაბიჯი 3</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; text-align: center; }
        h2 { color: #333; }
        .success { color: #28a745; }
        .error { color: #dc3545; background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 4px; }
        .loading { font-size: 18px; margin: 20px 0; }
        .spinner { display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-top: 3px solid #007cba; border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .btn { background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 15px; }
        .btn:hover { background: #005a87; }
    </style>
</head>
<body>
    <h2>მონაცემთა ბაზის იმპორტი</h2>
    
    <?php if ($success): ?>
        <div class="success">
            <h3>✅ ბაზა წარმატებით შეიქმნა!</h3>
            <div class="loading">
                <div class="spinner"></div>
                მიმდინარეობს გადამისამართება...
            </div>
            <p>თუ ავტომატური გადამისამართება არ მუშაობს:</p>
            <a href="step4_admin.php" class="btn">გაგრძელება</a>
        </div>
    <?php else: ?>
        <div class="error">
            <h3>❌ ბაზის იმპორტის შეცდომა</h3>
            <p><?= htmlspecialchars($errorMessage) ?></p>
            <p>გთხოვთ შეამოწმოთ:</p>
            <ul style="text-align: left;">
                <li>ბაზის ნებართვები</li>
                <li>structure.sql ფაილის არსებობა</li>
                <li>SQL სინტაქსის სისწორე</li>
            </ul>
            <a href="step2_dbconfig.php" class="btn">უკან დაბრუნება</a>
        </div>
    <?php endif; ?>
</body>
</html>
