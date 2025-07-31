<?php 

require_once __DIR__ . '/../../models/invoicesmodel.php';


use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>
           
          <!-- CONTENT START -->
          <div class="page-wrapper">
  <div class="container-xl mt-4">
    <h2 class="mb-4">ინვოისის რედაქტირება</h2>

    <form action="dashboard.php?module=billing&submodule=invoices&action=update" method="POST">
      <input type="hidden" name="id" value="<?= $invoice['id'] ?>">

      <div class="mb-3">
        <label class="form-label">კლიენტი</label>
        <select name="client_id" class="form-select" required>
          <?php foreach ($clients as $client): ?>
            <option value="<?= $client['id'] ?>" <?= $invoice['client_id'] == $client['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">ინვოისის ნომერი</label>
        <input type="text" name="invoice_number" class="form-control" value="<?= htmlspecialchars($invoice['invoice_number']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">აღწერა</label>
        <textarea name="description" class="form-control"><?= htmlspecialchars($invoice['description']) ?></textarea>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">გადახდის მეთოდი</label>
          <input type="text" name="payment_method" class="form-control" value="<?= htmlspecialchars($invoice['payment_method']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">სტატუსი</label>
          <select name="status" class="form-select">
            <?php foreach (['დრაფტი', 'გადაუხდელი', 'გადასახდელი', 'გადახდილი', 'გაუქმებული'] as $status): ?>
              <option value="<?= $status ?>" <?= $invoice['status'] == $status ? 'selected' : '' ?>><?= $status ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">თანხა (₾)</label>
        <input type="number" name="total_amount" class="form-control" step="0.01" value="<?= $invoice['total_amount'] ?>" required>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">ინვოისის თარიღი</label>
          <input type="date" name="issue_date" class="form-control" value="<?= $invoice['issue_date'] ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">გადახდის ბოლო ვადა</label>
          <input type="date" name="due_date" class="form-control" value="<?= $invoice['due_date'] ?>" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-check">
          <input class="form-check-input" type="checkbox" name="recurring" value="1" <?= $invoice['recurring'] ? 'checked' : '' ?>>
          <span class="form-check-label">გადახდა განმეორებით (ყოველთვიურად)</span>
        </label>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-primary">შენახვა</button>
        <a href="dashboard.php?module=billing&submodule=invoices&action=view&id=<?= $invoice['id'] ?>" class="btn btn-secondary">უკან</a>
      </div>
    </form>
  </div>
</div>

<?php require_once Config::includePath('footer.php'); ?>