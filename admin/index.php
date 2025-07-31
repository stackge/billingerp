<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ავტორიზაციის შემოწმება
if (isset($_SESSION['user_name'])) {
    // თუ ავტორიზებულია, გადაამისამართე dashboard-ზე
    header("Location: /admin/dashboard.php");
    exit;
} else {
    // თუ არაა ავტორიზებული, გადაამისამართე login-ზე
    header("Location: /admin/login.php");
    exit;
}
?>
