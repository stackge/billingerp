

<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>

<!-- CONTENT START -->




<div class="d-flex justify-content-between align-items-center mb-3">
      <h2>კლიენტის პროფილი: <?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?></h2>
      <a href="dashboard.php?module=clients&action=list" class="btn btn-secondary">← უკან სიისკენ</a>
    </div>


    <div class="row row-cards">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header"><strong>Clients Information</strong></div>
          <div class="card-body">
            <p><strong>First Name:</strong> <?= htmlspecialchars($client['first_name']) ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($client['last_name']) ?></p>
            <p><strong>Company:</strong> <?= htmlspecialchars($client['company_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($client['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($client['phone']) ?></p>
            <p><strong>Address 1:</strong> <?= htmlspecialchars($client['address1']) ?></p>
            <p><strong>Address 2:</strong> <?= htmlspecialchars($client['address2']) ?></p>
            <p><strong>City:</strong> <?= htmlspecialchars($client['city']) ?></p>
            <p><strong>State/Region:</strong> <?= htmlspecialchars($client['state']) ?></p>
            <p><strong>Postcode:</strong> <?= htmlspecialchars($client['postcode']) ?></p>
            <p><strong>Country:</strong> <?= htmlspecialchars($client['country']) ?></p>
          </div>
        </div>
      </div>
<?php


?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header"><strong>Invoices / Billing</strong></div>
          <div class="card-body">
          <p><strong>Paid:</strong> ₾<?= number_format($paid, 2) ?></p>
          <p><strong>Draft:</strong> ₾<?= number_format($draft, 2) ?></p>
          <p><strong>Unpaid / Due:</strong> ₾<?= number_format($unpaid_due, 2) ?></p>
          <p><strong>Cancelled:</strong> ₾<?= number_format($cancelled, 2) ?></p>
          <p><strong>Refunded:</strong> ₾<?= number_format($refunded, 2) ?></p>
          <hr>
          <p><strong>Gross Revenue:</strong> ₾<?= number_format($gross_revenue, 2) ?></p>
          <p><strong>Net Income:</strong> ₾<?= number_format($net_income, 2) ?></p>
          <p><strong>Credit Balance:</strong> ₾<?= number_format($credit_balance, 2) ?></p>

            <div class="mt-3">
              <a href="#" class="btn btn-outline-primary btn-sm">➕ Create Invoice</a>
              <a href="#" class="btn btn-outline-success btn-sm">➕ Add Funds Invoice</a>
              <a href="#" class="btn btn-outline-info btn-sm">🔁 Generate Due Invoices</a>
              <a href="#" class="btn btn-outline-warning btn-sm">💳 Manage Credits</a>
              <a href="/admin/billing/transactions/history.php?client_id=<?= $client['id'] ?>" class="btn btn-outline-warning btn-sm">ტრანზაქციების ისტორია</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row row-cards mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header"><strong>Admin Notes</strong></div>
          <div class="card-body">
            <p><?= nl2br(htmlspecialchars($client['admin_notes'])) ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header"><strong>Products / Services</strong></div>
          <div class="card-body">
          <?php if (count($services) > 0): ?>
    <ul class="list-group list-group-flush">
        <?php foreach ($services as $service): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($service['product_name']) ?></strong>
                - <?= number_format($service['amount'], 2) ?> ₾
                <br>
                <small class="text-muted"> <?= htmlspecialchars($service['description']) ?> </small>
                <br>
                <small class="text-muted"> თარიღი: <?= htmlspecialchars($service['issue_date']) ?> </small>
            </li>
        <?php endforeach ?>
    </ul>
<?php else: ?>
    <p class="text-muted">სერვისები არ მოიძებნა.</p>
<?php endif ?>
          </div>
        </div>
      </div>
    </div>

    

    <?php require_once Config::includePath('footer.php'); ?>