<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');
?>



<h2 class="mb-4">კლიენტის რედაქტირება</h2>
    <form action="dashboard.php?module=clients&action=edit" method="POST">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($client['first_name']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($client['last_name']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Company</label>
            <input type="text" class="form-control" name="company" value="<?= htmlspecialchars($client['company_name']) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($client['email']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($client['phone']) ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
              <option value="active" <?= $client['status'] === 'active' ? 'selected' : '' ?>>Active</option>
              <option value="inactive" <?= $client['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Client Group</label>
            <input type="text" class="form-control" name="client_group" value="<?= htmlspecialchars($client['client_group']) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Admin Notes</label>
            <textarea class="form-control" name="admin_notes" rows="5"><?= htmlspecialchars($client['admin_notes']) ?></textarea>
          </div>
        </div>
      </div>
      <div class="form-footer">
        <button type="submit" class="btn btn-primary">შენახვა</button>
        <a href="dashboard.php?module=clients&action=profile&id=<?= $client['id'] ?>" class="btn btn-secondary">გაუქმება</a>
      </div>
    </form>


    <?php require_once Config::includePath('footer.php'); ?>