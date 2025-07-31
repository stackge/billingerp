<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;
?>

<?php require_once App\Config::includePath('head.php'); ?>
<?php require_once App\Config::includePath('navbar.php'); ?>
<?php require_once App\Config::includePath('pageheader.php'); ?>
<?php require_once App\Config::includePath('pagebodystart.php'); ?>

<div class="container-xl mt-4">
    <h2>ელ.ფოსტის გაგზავნის ისტორია</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>კლიენტი</th>
                <th>თემა</th>
                <th>შეტყობინება</th>
                <th>გაგზავნის დრო</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailLogs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['first_name'] . ' ' . $log['last_name']) ?></td>
                    <td><?= htmlspecialchars($log['subject']) ?></td>
                    <td><?= nl2br(htmlspecialchars($log['message'])) ?></td>
                    <td><?= htmlspecialchars($log['sent_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once App\Config::includePath('footer.php'); ?>
