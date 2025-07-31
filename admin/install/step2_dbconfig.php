<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $db   = $_POST['dbname'];

    $conn = @new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        $error = "ბაზასთან კავშირის შეცდომა: " . $conn->connect_error;
    } else {
        // config.php გენერაცია
        $config = "<?php\nreturn [\n" .
            "    // Database configuration (compatible with install wizard)\n" .
            "    'host' => '$host',\n" .
            "    'user' => '$user',\n" .
            "    'pass' => '$pass',\n" .
            "    'dbname' => '$db',\n" .
            "    'port' => 3306,\n" .
            "    'charset' => 'utf8mb4',\n\n" .
            "    // Additional database configuration (nested for better organization)\n" .
            "    'db' => [\n" .
            "        'host' => '$host',\n" .
            "        'user' => '$user',\n" .
            "        'pass' => '$pass',\n" .
            "        'name' => '$db',\n" .
            "        'port' => 3306,\n" .
            "        'charset' => 'utf8mb4'\n" .
            "    ],\n\n" .
            "    // ზოგადი პროექტის პარამეტრები\n" .
            "    'app' => [\n" .
            "        'base_url' => 'http://localhost/',\n" .
            "        'debug' => true,\n" .
            "        'installed' => true,\n" .
            "        'version' => '1.0.0'\n" .
            "    ]\n];";
        file_put_contents(__DIR__ . '/../config.php', $config);
        header("Location: step3_import.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ინსტალაცია – ნაბიჯი 2</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        h2 { color: #333; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; margin-top: 15px; cursor: pointer; }
        button:hover { background: #005a87; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h2>მონაცემთა ბაზის კონფიგურაცია</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    
    <form method="post">
        <label for="host">ჰოსტი:</label>
        <input type="text" name="host" id="host" value="localhost" required>
        
        <label for="user">მომხმარებელი:</label>
        <input type="text" name="user" id="user" value="root" required>
        
        <label for="pass">პაროლი:</label>
        <input type="password" name="pass" id="pass">
        
        <label for="dbname">ბაზის სახელი:</label>
        <input type="text" name="dbname" id="dbname" required>
        
        <button type="submit">შენახვა და გაგრძელება</button>
    </form>
</body>
</html>
