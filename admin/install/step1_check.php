<?php
$errors = [];
$warnings = [];

// PHP version check
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    $errors[] = "საჭიროა PHP 7.4 ან უფრო ახალი ვერსია. მიმდინარე ვერსია: " . PHP_VERSION;
}

// Required extensions
$requiredExtensions = ['mysqli', 'json', 'mbstring'];
foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $errors[] = "საჭიროა $ext გაფართოება.";
    }
}

// Optional extensions
$optionalExtensions = ['curl', 'openssl', 'zip'];
foreach ($optionalExtensions as $ext) {
    if (!extension_loaded($ext)) {
        $warnings[] = "რეკომენდებულია $ext გაფართოება.";
    }
}

// Directory permissions
$directories = [
    __DIR__ . '/../uploads' => 'uploads',
    __DIR__ . '/../cache' => 'cache',
    __DIR__ . '/../logs' => 'logs'
];

foreach ($directories as $dir => $name) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    if (!is_writable($dir)) {
        $errors[] = "საქაღალდე '$name' უნდა იყოს ჩაწერადი.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ინსტალაცია – ნაბიჯი 1</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        h2 { color: #333; }
        .success { color: green; font-weight: bold; }
        .error { color: red; }
        .warning { color: orange; }
        ul { padding-left: 20px; }
        .continue-btn { background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; margin-top: 15px; }
        .continue-btn:hover { background: #218838; }
        .status-ok { color: green; }
        .status-error { color: red; }
        .status-warning { color: orange; }
    </style>
</head>
<body>
    <h2>სისტემური მოთხოვნები</h2>
    
    <h3>აუცილებელი მოთხოვნები:</h3>
    <ul>
        <li>PHP ვერსია: <span class="<?= version_compare(PHP_VERSION, '7.4.0', '>=') ? 'status-ok' : 'status-error' ?>"><?= PHP_VERSION ?></span></li>
        <?php foreach ($requiredExtensions as $ext): ?>
        <li><?= $ext ?> გაფართოება: <span class="<?= extension_loaded($ext) ? 'status-ok' : 'status-error' ?>"><?= extension_loaded($ext) ? 'დაყენებული' : 'არ არის დაყენებული' ?></span></li>
        <?php endforeach; ?>
    </ul>

    <?php if ($warnings): ?>
    <h3>რეკომენდაციები:</h3>
    <ul>
        <?php foreach ($warnings as $warning): ?>
            <li class="warning"><?= htmlspecialchars($warning) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <?php if ($errors): ?>
        <h3>შეცდომები:</h3>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li class="error"><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
        </ul>
        <p class="error">გთხოვთ გამოასწოროთ ყველა შეცდომა და განაახლოთ გვერდი.</p>
    <?php else: ?>
        <p class="success">✓ ყველაფერი მზად არის ინსტალაციისთვის!</p>
        <a href="step2_dbconfig.php" class="continue-btn">გაგრძელება</a>
    <?php endif; ?>
</body>
</html>
