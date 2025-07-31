<?php
require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/client.php';

// შემოწმება GET id-ზე
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php?module=clients&action=list");
    exit;
}

$id = (int)$_GET['id'];

// მომხმარებლის წამოღება
Client::setDb($pdo);
$client = Client::find($id);

if (!$client) {
    echo "კლიენტი ვერ მოიძებნა.";
    exit;
}

// თუ შენახვის ფორმა გამოიგზავნა
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
'first_name'       => trim($_POST['first_name'] ?? ''),
'last_name'        => trim($_POST['last_name'] ?? ''),
'company_name'     => trim($_POST['company'] ?? null),
'email'            => trim($_POST['email'] ?? ''),
'phone'            => trim($_POST['phone'] ?? null),
'status'           => trim($_POST['status'] ?? 'active'),
'client_group'     => trim($_POST['client_group'] ?? 'none'),
'admin_notes'      => trim($_POST['admin_notes'] ?? null),
    ];

    Client::update($id, $data);
    header("Location: dashboard.php?module=clients&action=profile&id=$id");
    exit;
}

// view-ის ჩატვირთვა
require_once __DIR__ . '/../views/clients_edit.php'; 




