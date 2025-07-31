<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/marketingmodels.php';

MarketingModel::setDb($pdo);
$emailLogs = MarketingModel::getEmailLogs();

require_once __DIR__ . '/../views/email_logs.php';