<?php
// ⚙️ ინვოისის განახლება

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

InvoicesModel::setDb($pdo);

// 📨 მონაცემების მიღება
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    exit('არასწორი ID.');
}

$id = (int)$_POST['id'];
$data = $_POST;

// ინვოისის განახლება
InvoicesModel::updateInvoice($id, $data);

// ↪️ გადამისამართება
header("Location: dashboard.php?module=billing&submodule=invoices&action=view&id=$id");
exit;

