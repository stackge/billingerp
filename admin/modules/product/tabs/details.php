<div class="container-xl mt-4">
  <h2 class="mb-4">პროდუქტის რედაქტირება: <?= htmlspecialchars($product['name']) ?></h2>

  <div class="tab-content pt-3">
    <div class="tab-pane active" id="details">
      <form method="POST" action="dashboard.php?module=product&action=update">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Product Type</label>
              <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($product['type']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Product Group</label>
              <input type="text" name="group" class="form-control" value="<?= htmlspecialchars($product['group']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Product Name</label>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Product Tagline</label>
              <input type="text" name="tagline" class="form-control" value="<?= htmlspecialchars($product['tagline'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">URL</label>
              <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($product['url']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Short Description</label>
              <textarea name="short_description" class="form-control"><?= htmlspecialchars($product['short_description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Product Color</label>
              <input type="color" name="color" class="form-control form-control-color" value="<?= htmlspecialchars($product['color'] ?? '#ffffff') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Welcome Email</label>
              <input type="text" name="welcome_email" class="form-control" value="<?= htmlspecialchars($product['welcome_email'] ?? '') ?>">
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="require_domain" value="1" id="requireDomain" <?= !empty($product['require_domain']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="requireDomain">Check to show domain registration options</label>
            </div>
            <div class="mb-3">
              <label class="form-label">Stock Quantity</label>
              <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($product['stock_quantity'] ?? 0) ?>">
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="apply_tax" value="1" id="applyTax" <?= !empty($product['apply_tax']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="applyTax">Check to charge tax for this product</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" <?= !empty($product['featured']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="featured">Display this product more prominently</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="hidden" value="1" id="hiddenSwitch" <?= !empty($product['hidden']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="hiddenSwitch">Check to hide from order form</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="retired" value="1" id="retired" <?= !empty($product['retired']) ? 'checked' : '' ?>>
              <label class="form-check-label" for="retired">Check to hide from dropdown menus</label>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">შენახვა</button>
          <a href="dashboard.php?module=product&action=list" class="btn btn-secondary">უკან</a>
        </div>
      </form>
    </div>