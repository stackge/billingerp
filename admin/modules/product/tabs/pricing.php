<?php
$pageTitle = "პროდუქტის რედაქტირება";
$tab = $_GET['tab'] ?? 'details';

include '../../layout/header.php';
?>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <?php if ($tab === 'details') : ?>
          <?php include 'tabs/details.php'; ?>
        <?php elseif ($tab === 'pricing') : ?>
          <h3>Pricing</h3>
          <form>
            <div class="mb-3">
              <label class="form-label">Payment Type</label>
              <div>
                <label class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_type" value="free"> Free
                </label>
                <label class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_type" value="onetime"> One Time
                </label>
                <label class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_type" value="recurring" checked> Recurring
                </label>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Currency</th>
                    <th>Setup Fee</th>
                    <th>Price</th>
                    <th>Enable</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>GEL</td>
                    <td><input type="text" class="form-control" value="0.00"></td>
                    <td><input type="text" class="form-control" value="70.00"></td>
                    <td><input type="checkbox" checked></td>
                  </tr>
                  <tr>
                    <td>USD</td>
                    <td><input type="text" class="form-control" value="0.00"></td>
                    <td><input type="text" class="form-control" value="29.00"></td>
                    <td><input type="checkbox" checked></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php include '../../layout/footer.php'; ?>
