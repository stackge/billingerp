<?php
require_once __DIR__ . '/../../models/transactionsmodel.php';

use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>

<div class="container-xl mt-4">
    <h2>ტრანზაქციის დამატება</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">ინვოისი</label>
            <select name="invoice_id" class="form-select" required>
                <option value="">აირჩიე</option>
                <?php foreach ($invoices as $inv): ?>
                    <option value="<?= $inv['id'] ?>"><?= htmlspecialchars($inv['invoice_number']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">კლიენტი</label>
            <select name="client_id" class="form-select" required>
                <option value="">აირჩიე</option>
                <?php foreach ($clients as $cl): ?>
                    <option value="<?= $cl['id'] ?>"><?= htmlspecialchars($cl['first_name'] . ' ' . $cl['last_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">თანხა</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">მეთოდი</label>
            <input type="text" name="method" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">სტატუსი</label>
            <select name="status" class="form-select" required>
                <option value="success">წარმატებული</option>
                <option value="failed">წარუმატებელი</option>
                <option value="pending">მოლოდინში</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">შენიშვნა</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">შენახვა</button>
        <a href="list.php" class="btn btn-secondary">გაუქმება</a>
    </form>
</div>

<?php require_once Config::includePath('footer.php'); ?>