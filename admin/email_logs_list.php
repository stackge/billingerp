<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Config;

// წამოიღე ლოგები კლიენტის ინფორმაციით
$stmt = $pdo->query("SELECT e.*, c.first_name, c.last_name, c.email FROM email_logs e JOIN clients c ON c.id = e.client_id ORDER BY e.sent_at DESC");
$logs = $stmt->fetchAll();

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>

<div class="container-xl mt-4">
    <h2>გაგზავნილი ელ.ფოსტები</h2>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>დრო</th>
                        <th>კლიენტი</th>
                        <th>ელ.ფოსტა</th>
                        <th>თემა</th>
                        <th>შეტყობინება</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $log['sent_at'] ?></td>
                            <td><?= htmlspecialchars($log['first_name'] . ' ' . $log['last_name']) ?></td>
                            <td><?= htmlspecialchars($log['email']) ?></td>
                            <td><?= htmlspecialchars($log['subject']) ?></td>
                            <td><?= nl2br(htmlspecialchars($log['message'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once Config::includePath('footer.php'); ?>
