<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/transactionsmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

TransactionsModel::setDb($pdo);

// ID გადმოსვლის შემოწმება
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    exit('არასწორი ID.');
}

// წაშლის მცდელობა
TransactionsModel::deleteTransaction((int)$id);

// გადამისამართება
header('Location: dashboard.php?module=billing&submodule=transactions&action=list&deleted=1');
exit;
