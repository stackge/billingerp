<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';

use App\Config;
?>

<?php require_once Config::includePath('head.php'); ?>
<?php require_once Config::includePath('navbar.php'); ?>
<?php require_once Config::includePath('pageheader.php'); ?>
<?php require_once Config::includePath('pagebodystart.php'); ?>

<?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
  <div class="alert alert-success">პროდუქტი წარმატებით დაემატა.</div>
<?php endif; ?>

<div class="container-xl mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>პროდუქტები და სერვისები</h2>
    <div class="btn-list">
      <a href="dashboard.php?module=product&action=types" class="btn btn-outline-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
          <rect x="3" y="3" width="7" height="7"/>
          <rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/>
          <rect x="3" y="14" width="7" height="7"/>
        </svg>
        ტიპების მართვა
      </a>
      <a href="dashboard.php?module=product&action=create" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
          <path d="M12 5l0 14"/>
          <path d="M5 12l14 0"/>
        </svg>
        ახალი პროდუქტი
      </a>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Group</th>
        <th>Type</th>
        <th>Pay Type</th>
        <th>Auto Setup</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product): ?>
        <tr>
        <td><?= htmlspecialchars($product['id'] ?? '') ?></td>
        <td><?= htmlspecialchars($product['name'] ?? '') ?></td>
        <td><?= htmlspecialchars($product['group'] ?? '') ?></td>
        <td><?= htmlspecialchars($product['type'] ?? '') ?></td>
        <td><?= htmlspecialchars($product['pay_type'] ?? '') ?></td>
        <td><?= htmlspecialchars($product['auto_setup'] ?? '') ?></td>
          <td>
            <a href="dashboard.php?module=product&action=edit&id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">რედ.</a>
            <a href="dashboard.php?module=product&action=delete&id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('წაშლა?');">წაშლა</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once Config::includePath('footer.php'); ?>