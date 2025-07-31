<?php
// auth_check.php - ავტორიზაციის შემოწმების ფაილი
session_start();

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getUserName() {
    return $_SESSION['user_name'] ?? 'ანონიმი';
}

function logout() {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
