<?php
// მარტივი პროფილის გვერდი - ყიდრ access-ისთვის
require_once __DIR__ . '/includes/init.php';

// Redirect to full user management profile
$userId = $_SESSION['user_id'] ?? 0;
header("Location: dashboard.php?module=users&action=management&subaction=profile&id=$userId");
exit;
?>
