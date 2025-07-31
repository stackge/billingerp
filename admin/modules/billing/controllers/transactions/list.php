<!-- ტრანზაქციების სია -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../../includes/init.php';
require_once __DIR__ . '/../../models/transactionsmodel.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';


// წაკითხვა GET-პარამეტრებიდან
$successMessage = null;

if (isset($_GET['added']) && $_GET['added'] == 1) {
    $successMessage = "ტრანზაქცია წარმატებით დაემატა.";
} elseif (isset($_GET['updated']) && $_GET['updated'] == 1) {
    $successMessage = "ტრანზაქცია წარმატებით განახლდა.";
} elseif (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $successMessage = "ტრანზაქცია წარმატებით წაიშალა.";
}

TransactionsModel::setDb($pdo);

$transactions = TransactionsModel::getAllTransactions();

require_once __DIR__ . '/../../views/transactions/list.php';