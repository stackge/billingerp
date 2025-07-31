<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// სესიის გაშვება თუ ჯერ არ არის
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ავტორიზაციის შემოწმება
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

// მომხმარებლის მონაცემები
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'] ?? '';

// ბაზასთან კავშირი
require_once __DIR__ . '/db.php';
