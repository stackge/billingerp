<?php

require_once __DIR__ . '/../../../includes/init.php';

// ID გადმოწოდებულია URL-იდან
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: clients_list.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch();

if (!$client) {
    echo "კლიენტი ვერ მოიძებნა.";
    exit;
}




// Ჩვენ ვიღებთ კლიენტის ID-ს
$client_id = $_GET['id'];

// ყველა ინვოისი ამ მომხმარებლისთვის
$stmt = $pdo->prepare("SELECT status, total_amount FROM invoices WHERE client_id = ?");
$stmt->execute([$client_id]);
$invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ინიციალიზაცია
$paid = $draft = $unpaid_due = $cancelled = $refunded = 0;

// გამოთვლა
foreach ($invoices as $inv) {
    $amount = (float)$inv['total_amount'];
    switch ($inv['status']) {
        case 'გადახდილი':
            $paid += $amount;
            break;
        case 'დრაფტი':
            $draft += $amount;
            break;
        case 'გადაუხდელი':
        case 'გადასახდელი':
            $unpaid_due += $amount;
            break;
        case 'გაუქმებული':
            $cancelled += $amount;
            break;
        case 'დაბრუნებული':
            $refunded += $amount;
            break;
    }
}

$gross_revenue = $paid + $unpaid_due + $draft;
$net_income = $paid;
$credit_balance = 0.00; // შეგიძლია დაამატო ცალკე ცხრილიდან



$client_id = $_GET['id'];

// სერვისების მიღება
$stmt = $pdo->prepare("
    SELECT p.name AS product_name, ii.amount, ii.description, i.issue_date
    FROM invoice_items ii
    JOIN invoices i ON ii.invoice_id = i.id
    JOIN products p ON ii.product_id = p.id
    WHERE i.client_id = ?
    ORDER BY i.issue_date DESC
");
$stmt->execute([$client_id]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);



require_once __DIR__ . '/../views/client_profile.php';

?>

