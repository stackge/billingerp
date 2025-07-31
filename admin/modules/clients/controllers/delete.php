<?php
require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/client.php';

Client::setDb($pdo); // ვუთითებთ PDO ობიექტს

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // გადავცემთ ID-ს მოდელს წასაშლელად
    Client::delete($id);
}

header("Location: dashboard.php?module=clients&action=list");
exit;
