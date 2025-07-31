<!-- გადახდების ისტორია -->

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/transactionsmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';


TransactionsModel::setDb($pdo);

$clientId = $_GET['client_id'] ?? null;

$client = TransactionsModel::getClientInfo($clientId);
if (!$client) {
    echo "კლიენტი ვერ მოიძებნა.";
    exit;
}

$transactions = TransactionsModel::getClientTransactions($clientId);

require_once __DIR__ . '/../../views/transactions/history.php';