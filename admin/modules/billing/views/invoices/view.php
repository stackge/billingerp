<!-- კონკრეტული ინვოისის ხილვა -->
<?php require_once __DIR__ . '/../../models/invoicesmodel.php'; ?>

<?php
use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');
?>

           
          <!-- CONTENT START -->
          <?php if ($showAlert): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="invoiceAlert">
    ✅ ინვოისი წარმატებით გაიგზავნა!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <script>
    setTimeout(() => {
      const alertBox = document.getElementById('invoiceAlert');
      if (alertBox) alertBox.remove();
    }, 5000);
  </script>
<?php endif; ?>

          <div class="container-xl mt-4">
        <h2>ინვოისი # <?= $invoice['invoice_number'] ? htmlspecialchars($invoice['invoice_number']) : '' ?></h2>
        <p><strong>კლიენტი:</strong> <?= htmlspecialchars($invoice['first_name'] . ' ' . $invoice['last_name']) ?></p>
        <p><strong>სტატუსი:</strong> <?= htmlspecialchars($invoice['status']) ?></p>
        <p><strong>თარიღი:</strong> <?= $invoice['issue_date'] ?></p>
        <p><strong>ბოლო ვადა:</strong> <?= $invoice['due_date'] ?></p>
        <p><strong>გადასახდელი თანხა:</strong> <?= number_format($invoice['total_amount'], 2) ?> ₾</p>
        <p><strong>გადახდის მეთოდი:</strong> <?= htmlspecialchars($invoice['payment_method']) ?></p>
        <p><strong>აღწერა:</strong> <?= nl2br(htmlspecialchars($invoice['description'])) ?></p>

        <?php if (!empty($productItems)): ?>
            <h4 class="mt-4">პროდუქტები</h4>
            <table class="table">
                <thead>
                <tr>
                    <th>პროდუქტი</th>
                    <th>თანხა</th>
                    <th>აღწერა</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($productItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['amount'], 2) ?> ₾</td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="mt-4">
            <a href="dashboard.php?module=billing&submodule=invoices&action=send&id=<?= $invoice['id'] ?>" class="btn btn-primary">გაგზავნა</a>
            <a href="dashboard.php?module=billing&submodule=invoices&action=edit&id=<?= $invoice['id'] ?>" class="btn btn-secondary">რედაქტირება</a>
            <a href="dashboard.php?module=billing&submodule=invoices&action=delete&id=<?= $invoice['id'] ?>" class="btn btn-danger">წაშლა</a>
            <a href="dashboard.php?module=billing&submodule=invoices&action=list" class="btn btn-light">უკან</a>
        </div>
    </div>
    

    <?php require_once Config::includePath('footer.php'); ?>