<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/transactionsmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';


TransactionsModel::setDb($pdo);

// მომხმარებლები და ინვოისები ფორმის select-ებისთვის
$clients = TransactionsModel::getClients();
$invoices = TransactionsModel::getInvoices();

// POST დამუშავება
$errors = TransactionsModel::handleTransactionFormSubmission();


require_once __DIR__ . '/../../views/transactions/create.php';