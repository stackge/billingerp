<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';

use App\Config;
?>

<?php require_once Config::includePath('head.php'); ?>
<?php require_once Config::includePath('navbar.php'); ?>
<?php require_once Config::includePath('pageheader.php'); ?>
<?php require_once Config::includePath('pagebodystart.php'); ?>

<div class="tab-content mt-4">
    <?php
    $allowedTabs = ['details', 'pricing'];
    if (!in_array($tab, $allowedTabs)) {
        $tab = 'details';
    }

    $tabPath = __DIR__ . '/../tabs/' . $tab . '.php';

    if (file_exists($tabPath)) {
        include $tabPath;
    } else {
        echo "<div class='alert alert-danger'>ტაბის ფაილი ვერ მოიძებნა.</div>";
    }
    ?>
</div>
