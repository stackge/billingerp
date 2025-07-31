<?php
require_once __DIR__ . '/../../models/transactionsmodel.php';

use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>

<div class="container-xl mt-4">
  <h2>ტრანზაქციების ისტორია - <?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?></h2>

  <?php if (empty($transactions)): ?>
    <div class="alert alert-info">ტრანზაქცია არ მოიძებნა.</div>
  <?php else: ?>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>ინვოისი</th>
          <th>თანხა</th>
          <th>მეთოდი</th>
          <th>სტატუსი</th>
          <th>შენიშვნა</th>
          <th>თარიღი</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($transactions as $t): ?>
          <tr>
            <td>#<?= htmlspecialchars($t['invoice_number']) ?></td>
            <td><?= number_format($t['amount'], 2) ?> ₾</td>
            <td><?= htmlspecialchars($t['method']) ?></td>
            <td>
              <span class="badge bg-<?= $t['status'] === 'success' ? 'success' : ($t['status'] === 'failed' ? 'danger' : 'warning') ?>">
                <?= htmlspecialchars($t['status']) ?>
              </span>
            </td>
            <td><?= nl2br(htmlspecialchars($t['notes'])) ?></td>
            <td><?= $t['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <a href="/admin/clients/view.php?id=<?= $clientId ?>" class="btn btn-light">🔙 უკან კლიენტის პროფილში</a>
</div>

<?php require_once Config::includePath('footer.php'); ?>
