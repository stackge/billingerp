<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $config = include __DIR__ . '/../config.php';
        
        if (!$config) {
            throw new Exception("კონფიგურაციის ფაილი ვერ ჩაიტვირთა");
        }
        
        $conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['dbname']);

        if ($conn->connect_error) {
            throw new Exception("ბაზასთან კავშირის შეცდომა: " . $conn->connect_error);
        }
        
        $conn->set_charset("utf8mb4");
    } catch (Exception $e) {
        $error = $e->getMessage();
        $conn = null;
    }

    if (isset($conn) && $conn) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']); 
        $password = $_POST['password'];
        $email = trim($_POST['email']);
        
        // Validation
        if (strlen($first_name) < 2) {
            $error = "სახელი უნდა იყოს მინიმუმ 2 სიმბოლო";
        } elseif (strlen($last_name) < 2) {
            $error = "გვარი უნდა იყოს მინიმუმ 2 სიმბოლო";
        } elseif (strlen($password) < 6) {
            $error = "პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "გთხოვთ შეიყვანოთ სწორი ელ-ფოსტა";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // არსებული users ცხრილის სტრუქტურა: first_name, last_name, email, password, created_at
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, created_at) VALUES (?, ?, ?, ?, NOW())");
            
            if (!$stmt) {
                throw new Exception("Statement preparation failed: " . $conn->error);
            }
            
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashedPassword);
            
            if ($stmt->execute()) {
                // განაახლოს config.php ფაილი installed სტატუსით
                $currentConfig = include __DIR__ . '/../config.php';
                $currentConfig['app']['installed'] = true;
                
                $configContent = "<?php\nreturn " . var_export($currentConfig, true) . ";\n";
                file_put_contents(__DIR__ . '/../config.php', $configContent);
                
                file_put_contents(__DIR__ . '/install.lock', "installed on " . date('Y-m-d H:i:s'));
                header("Location: finish.php");
                exit;
            } else {
                throw new Exception("მომხმარებლის შექმნის შეცდომა: " . $stmt->error);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>ინსტალაცია – ნაბიჯი 4</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        h2 { color: #333; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; margin-top: 15px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; margin-top: 10px; padding: 10px; background: #ffeaea; border: 1px solid #ffcccc; border-radius: 4px; }
        .info { background: #e7f3ff; border: 1px solid #b3d9ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>ადმინისტრატორის ანგარიშის შექმნა</h2>
    
    <div class="info">
        <strong>ბოლო ნაბიჯი!</strong><br>
        შექმენით ადმინისტრატორის ანგარიში სისტემაში შესასვლელად.
    </div>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <?php if (isset($_GET['debug'])): ?>
        <div style="background: #f0f0f0; padding: 10px; border: 1px solid #ccc; margin: 10px 0;">
            <strong>Debug Info:</strong><br>
            Config file path: <?= __DIR__ . '/../config.php' ?><br>
            Config exists: <?= file_exists(__DIR__ . '/../config.php') ? 'Yes' : 'No' ?><br>
            <?php if (file_exists(__DIR__ . '/../config.php')): ?>
                <?php $testConfig = include __DIR__ . '/../config.php'; ?>
                Host: <?= isset($testConfig['host']) ? $testConfig['host'] : 'NOT SET' ?><br>
                User: <?= isset($testConfig['user']) ? $testConfig['user'] : 'NOT SET' ?><br>
                DBName: <?= isset($testConfig['dbname']) ? $testConfig['dbname'] : 'NOT SET' ?><br>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <label for="first_name">სახელი:</label>
        <input type="text" name="first_name" id="first_name" value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>" required minlength="2">
        
        <label for="last_name">გვარი:</label>
        <input type="text" name="last_name" id="last_name" value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>" required minlength="2">
        
        <label for="email">ელ-ფოსტა:</label>
        <input type="email" name="email" id="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
        
        <label for="password">პაროლი:</label>
        <input type="password" name="password" id="password" required minlength="6">
        
        <button type="submit">ანგარიშის შექმნა და ინსტალაციის დასრულება</button>
    </form>
    
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            
            if (firstName.length < 2) {
                alert('სახელი უნდა იყოს მინიმუმ 2 სიმბოლო');
                e.preventDefault();
                return;
            }
            if (lastName.length < 2) {
                alert('გვარი უნდა იყოს მინიმუმ 2 სიმბოლო');
                e.preventDefault();
                return;
            }
            if (password.length < 6) {
                alert('პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
