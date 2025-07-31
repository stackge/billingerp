<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;


$success = isset($_GET['sent']) && $_GET['sent'] == 1;

// კლიენტების წამოღება
MarketingModel::setDb($pdo);
$clients = MarketingModel::getAllClients();
?>

<?php require_once Config::includePath('head.php'); ?>
<?php require_once Config::includePath('navbar.php'); ?>
<?php require_once Config::includePath('pageheader.php'); ?>
<?php require_once Config::includePath('pagebodystart.php'); ?>


<div class="container-xl mt-4">
    <h2>ელ.ფოსტის გაგზავნა კლიენტებზე</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">შეტყობინება წარმატებით გაიგზავნა!</div>
    <?php endif; ?>

    <form action="dashboard.php?module=marketing&action=broadcast" method="POST">
        <div class="mb-3">
            <label class="form-label">აირჩიე კლიენტები</label><br>
            <?php foreach ($clients as $client): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="clients[]" value="<?= $client['id'] ?>">
                    <label class="form-check-label"> <?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?> </label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">თემა</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">შეტყობინება</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">გაგზავნა</button>
    </form>
</div>

<?php require_once Config::includePath('footer.php'); ?>
