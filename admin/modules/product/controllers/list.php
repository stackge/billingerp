<?php
// controllers/list.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

ProductModel::setDb($pdo);
$products = ProductModel::getAllProducts();

require_once __DIR__ . '/../views/list.php';

