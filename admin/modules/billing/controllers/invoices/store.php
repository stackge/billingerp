<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';

InvoicesModel::setDb($pdo);

// POST მონაცემების დამუშავება
$data = $_POST;
$data['recurring'] = isset($data['recurring']) ? 1 : 0;

// სტატუსის ვალიდაცია
if (!InvoicesModel::isValidStatus($data['status'])) {
    die('არასწორი სტატუსის მნიშვნელობა');
}

// 🔢 ინვოისის ნომრის გენერაცია
if (empty($data['invoice_number'])) {
    $data['invoice_number'] = InvoicesModel::generateInvoiceNumber();
}


// დუბლიკატის შემოწმება
if (InvoicesModel::isDuplicateInvoiceNumber($data['invoice_number'])) {
    die('ინვოისის ნომერი უკვე გამოიყენება!');
}

// ჩასმა მოდელის მეშვეობით
$invoice_id = InvoicesModel::createInvoiceWithItems($data);

// გადამისამართება
header("Location: dashboard.php?module=billing&submodule=invoices&action=view&id=" . $invoice_id);
exit;
