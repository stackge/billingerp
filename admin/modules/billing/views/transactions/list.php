<?php
require_once __DIR__ . '/../../models/transactionsmodel.php';

use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMessage) ?>
    </div>
<?php endif; ?>

<div class="container-xl mt-4">
    <h2>ტრანზაქციები</h2>
    <a href="dashboard.php?module=billing&submodule=transactions&action=create" class="btn btn-primary mb-3">➕ დამატება</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ინვოისი</th>
                <th>კლიენტი</th>
                <th>თანხა</th>
                <th>მეთოდი</th>
                <th>სტატუსი</th>
                <th>თარიღი</th>
                <th>ქმედებები</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $tx): ?>
            <tr>
                <td><?= htmlspecialchars($tx['invoice_number']) ?></td>
                <td><?= htmlspecialchars($tx['first_name'] . ' ' . $tx['last_name']) ?></td>
                <td><?= number_format($tx['amount'], 2) ?> ₾</td>
                <td><?= htmlspecialchars($tx['method']) ?></td>
                <td><?= htmlspecialchars($tx['status']) ?></td>
                <td><?= $tx['created_at'] ?></td>
                <td>
                    <a href="dashboard.php?module=billing&submodule=transactions&action=edit&id=<?= $tx['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                    <a href="dashboard.php?module=billing&submodule=transactions&action=delete&id=<?= $tx['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('დარწმუნებული ხარ?')">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once Config::includePath('footer.php'); ?>
