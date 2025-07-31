<?php
require_once __DIR__ . '/../../models/transactionsmodel.php';

use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>


<div class="container-xl mt-4">
  <h2>ტრანზაქციის რედაქტირება</h2>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">ინვოისი</label>
      <input type="text" class="form-control" value="#<?= $transaction['invoice_number'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">კლიენტი</label>
      <input type="text" class="form-control" value="<?= $transaction['first_name'] . ' ' . $transaction['last_name'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">თანხა</label>
      <input type="text" class="form-control" value="<?= number_format($transaction['amount'], 2) ?> ₾" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">სტატუსი</label>
      <select name="status" class="form-select" required>
        <option value="success" <?= $transaction['status'] === 'success' ? 'selected' : '' ?>>დადასტურებული</option>
        <option value="failed" <?= $transaction['status'] === 'failed' ? 'selected' : '' ?>>ჩავარდა</option>
        <option value="pending" <?= $transaction['status'] === 'pending' ? 'selected' : '' ?>>მოლოდინში</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">გადახდის მეთოდი</label>
      <input type="text" name="method" class="form-control" value="<?= htmlspecialchars($transaction['method']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">შენიშვნა</label>
      <textarea name="notes" class="form-control"><?= htmlspecialchars($transaction['notes']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">შენახვა</button>
    <a href="list.php" class="btn btn-secondary">უკან</a>
  </form>
</div>

<?php require_once Config::includePath('footer.php'); ?>
