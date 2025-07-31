<?php
// 📄 ინვოისის PDF გენერაცია - Controller

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Config;

InvoicesModel::setDb($pdo);

// 🧾 ინვოისის ID გადმოსვლა GET-ით
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    exit('არასწორი ID');
}

$id = (int)$_GET['id'];

// 🧾 ინვოისის მონაცემების წამოღება
$invoice = InvoicesModel::getInvoiceById($id);
if (!$invoice) {
    exit('ინვოისი ვერ მოიძებნა.');
}

$client_name = $invoice['first_name'] . ' ' . $invoice['last_name'];

// 📄 PDF კონფიგურაცია
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// 📄 შაბლონის HTML ჩატვირთვა
ob_start();
require_once realpath(Config::basePath() . '/admin/modules/billing/models/invoices/invoice_template.php');
$html = ob_get_clean();

$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// 📄 PDF-ის შენახვა დროებით
$pdfOutput = $dompdf->output();
$pdfPath = '/tmp/invoice_' . $invoice['id'] . '.pdf';
file_put_contents($pdfPath, $pdfOutput);

// გადამისამართება ან ჩამოტვირთვა შეგიძლიათ დაამატოთ აქ
