<!-- გაგზავნის ლოგიკა -->
 <?php

// ინვოისის გაგზავნა ელფოსტაზე PDF-ით

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/invoicesmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../../libs/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../../../libs/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../../../libs/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

InvoicesModel::setDb($pdo);

// use Dompdf\Dompdf;

// use Dompdf\Options;

// $options = new Options();
// $options->set('isRemoteEnabled', true);

// // ️➡️ უთხარი Dompdf-ს სად არის შენი შრიფტი
// $options->setChroot(__DIR__ . '/../../'); // აქედან იმუშავებს relative path-ებით
// $options->set('defaultFont', 'bpg_glaho');

// $dompdf = new Dompdf($options);


InvoicesModel::setDb($pdo);

// 1. აიდი
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    exit("არასწორი ინვოისის ID.");
}

// 2. მოიტანე ინვოისი და ნივთები
$invoice = InvoicesModel::getInvoiceWithItems($id);
if (!$invoice) {
    exit("ინვოისი ვერ მოიძებნა.");
}



// 3. გენერაცია PDF ფაილის
$pdfPath = InvoicesModel::generateInvoicePDF($invoice);

// Email გაგზავნა
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'vps-7146dd3a.vps.ovh.ca'; // შეცვალე
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@selfhosting.ge'; // შეცვალე
    $mail->Password = 'FSZtTIIIlubk'; // შეცვალე
    $mail->SMTPSecure = 'ssl'; // ან ssl
    $mail->Port = 465; // ან 465

    $mail->setFrom('noreply@selfhosting.ge', 'ბილინგ სერვისი');
    $mail->addAddress($invoice['email'], $invoice['first_name'] . ' ' . $invoice['last_name']);

    $mail->CharSet = 'UTF-8'; // ✅ ეს არის მთავარი!
    $mail->Encoding = 'base64'; // ხშირად დაეხმარება UTF-8-ის სწორ გადაცემას

    $mail->isHTML(true);
    $mail->Subject = "ინვოისი #" . $invoice['invoice_number'];
    $mail->Body = "
        გამარჯობა {$invoice['first_name']},<br><br>
        თქვენთვის შემუშავებულია ახალი ინვოისი ჯამური თანხით <strong>{$invoice['total_amount']} ₾</strong>.<br>
        გადახდის ვადა: {$invoice['due_date']}<br><br>
        იხილეთ დეტალურად: ინვოისის სანახავად იხილეთ მიმაგრებული ფაილი<br><br>
        მადლობა თანამშრომლობისთვის.
    ";

    $invoice = InvoicesModel::getInvoiceWithClientById($id);

    $invoice['company_name'] = $invoice['client_company_name'];
    $invoice['vat_number'] = $invoice['client_vat_number'];
    $invoice['address1'] = $invoice['client_address1'];
    $client_name = $invoice['first_name'] . ' ' . $invoice['last_name'];
    // ინვოისის HTML
    $html = InvoicesModel::renderInvoiceHTML($invoice);


$mail->addAttachment($pdfPath, 'Invoice_' . $invoice['invoice_number'] . '.pdf');
$mail->send();

// ✅ წარმატებული გაგზავნის შემდეგ
header("Location: dashboard.php?module=billing&submodule=invoices&action=view&id={$invoice['id']}&sent=1");
exit;
} catch (Exception $e) {
echo "შეცდომა გაგზავნისას: {$mail->ErrorInfo}";
}


?>