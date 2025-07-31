<?php
session_start();

// ჯერ შევამოწმოთ ინსტალაციის სტატუსი
$configFile = __DIR__ . '/config.php';
$installDir = __DIR__ . '/install';

if (!file_exists($configFile)) {
    header('Location: install/');
    exit;
}

$config = include $configFile;
if (!isset($config['app']['installed']) || $config['app']['installed'] !== true) {
    if (is_dir($installDir)) {
        header('Location: install/');
        exit;
    }
}

// თუ უკვე ავტორიზებულია, გადაამისამართოს dashboard-ზე
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/includes/db.php';

$error = '';
$success = '';

// შეცდომების ჩვენება logout-ის შემდეგ
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $success = "წარმატებით გამოხვედით სისტემიდან.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "შეიყვანე ელფოსტა და პაროლი.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // წარმატებული ავტორიზაცია
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'];
                $_SESSION['user_email'] = $user['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "არასწორი ელფოსტა ან პაროლი.";
            }
        } catch (PDOException $e) {
            $error = "სისტემის შეცდომა. გთხოვთ სცადოთ მოგვიანებით.";
            error_log("Login error: " . $e->getMessage());
        }
    }
}
            ?>

<!doctype html>
<!--
* STACK - ბილინგისა და მართვის სისტემა stack.ge
* @version 1.1.1
* @link https://stack.ge
* Copyright 2025 Stack.ge
* შექმნილია Stack.ge გუნდის მიერ
* Licensed under MIT License
-->
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>STACK - ავტორიზაცია სისტემაში</title>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="./dist/css/tabler.min.css?1740918420" rel="stylesheet" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <link href="./dist/css/tabler-flags.min.css?1740918420" rel="stylesheet" />
    <link href="./dist/css/tabler-socials.min.css?1740918420" rel="stylesheet" />
    <link href="./dist/css/tabler-payments.min.css?1740918420" rel="stylesheet" />
    <link href="./dist/css/tabler-vendors.min.css?1740918420" rel="stylesheet" />
    <link href="./dist/css/tabler-marketing.min.css?1740918420" rel="stylesheet" />
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN DEMO STYLES -->
    <link href="./preview/css/demo.min.css?1740918420" rel="stylesheet" />
    <!-- END DEMO STYLES -->
    <!-- BEGIN CUSTOM FONT -->
    <style>
      @import url("https://rsms.me/inter/inter.css");
    </style>
    <!-- END CUSTOM FONT -->
  </head>
  <body class="d-flex flex-column bg-white">
    <!-- BEGIN DEMO THEME SCRIPT -->
    <script src="./preview/js/demo-theme.min.js?1740918420"></script>
    <!-- END DEMO THEME SCRIPT -->
    <div class="row g-0 flex-fill">
      <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
        <div class="container container-tight my-5 px-lg-5">
          <div class="text-center mb-4">
            <!-- BEGIN NAVBAR LOGO -->
            <a href="." class="navbar-brand navbar-brand-autodark">
              <h2 style="color: #066fd1; font-weight: bold; margin: 0;">STACK</h2>
              <small style="color: #6c757d;">stack.ge</small>
            </a>
            <!-- END NAVBAR LOGO -->


          </div>
          <h2 class="h3 text-center mb-3">ავტორიზაცია ანგარიშზე</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
          <form action="" method="POST" autocomplete="off" novalidate>
            <div class="mb-3">
              <label class="form-label">ელ.ფოსტა</label>
              <input name="email" type="email" class="form-control" placeholder="your@email.com" autocomplete="off" required />
            </div>
            <div class="mb-2">
              <label class="form-label">
                პაროლი
                <span class="form-label-description">
                  <a href="./forgot-password.html">პაროლის აღდგენა</a>
                </span>
              </label>
              <div class="input-group input-group-flat">
                <input name="password" type="password" class="form-control" placeholder="Your password" autocomplete="off" required />
                <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/eye -->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="icon icon-1"
                    >
                      <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                      <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                    </svg>
                  </a>
                </span>
              </div>
            </div>
            <div class="mb-2">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" />
                <span class="form-check-label">მოწყობილობის დამახსოვრება</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">შესვლა</button>
            </div>
          </form>
          <div class="text-center text-secondary mt-3">ჯერ არ გაქვთ ანგარიში? <a href="./register.php" tabindex="-1">რეგისტრაცია</a></div>
        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
        <!-- Photo -->
        <div class="bg-cover h-100 min-vh-100" style="background-image: url(./static/photos/finances-us-dollars-and-bitcoins-currency-money-2.jpg)"></div>
      </div>
    </div>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="./dist/js/tabler.min.js?1740918420" defer></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN DEMO SCRIPTS -->
    <script src="./preview/js/demo.min.js?1740918420" defer></script>
    <!-- END DEMO SCRIPTS -->
  </body>
</html>
