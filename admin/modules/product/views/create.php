<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/productmodels.php';
use App\Config;

// Product types-ების მიღება
ProductModel::setDb($pdo);
$productTypes = ProductModel::getProductTypes();
?>

<?php require_once Config::includePath('head.php'); ?>
<?php require_once Config::includePath('navbar.php'); ?>
<?php require_once Config::includePath('pageheader.php'); ?>
<?php require_once Config::includePath('pagebodystart.php'); ?>


<div class="container-xl mt-4">
  <h2 class="mb-4">ახალი პროდუქტის დამატება</h2>
  <form method="POST" action="dashboard.php?module=product&action=save">
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Product Type</label>
          <div class="row">
            <div class="col">
              <select name="type" class="form-select" id="product-type-select" required>
                <option value="">აირჩიეთ ტიპი...</option>
                <?php foreach ($productTypes as $type): ?>
                <option value="<?= htmlspecialchars($type['name']) ?>" data-icon="<?= htmlspecialchars($type['icon']) ?>">
                  <?= htmlspecialchars($type['name']) ?>
                  <?php if ($type['description']): ?>
                  - <?= htmlspecialchars($type['description']) ?>
                  <?php endif; ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-auto">
              <a href="dashboard.php?module=product&action=types" class="btn btn-outline-secondary" title="ტიპების მართვა">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                  <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                </svg>
                მართვა
              </a>
            </div>
          </div>
          <div class="mt-2" id="type-preview" style="display: none;">
            <div class="d-flex align-items-center text-muted">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon me-2" id="type-icon">
              </svg>
              <span id="type-description"></span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Product Group</label>
          <input type="text" name="group" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">დასახელება</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">URL</label>
          <input type="text" name="url" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">მოდული</label>
          <input type="text" name="module" class="form-control">
        </div>
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" name="hidden" value="1" id="hiddenSwitch">
            <label class="form-check-label" for="hiddenSwitch">შექმნა დამალულად</label>
        </div>
      </div>
    </div>
    <div class="form-footer mt-3">
      <button type="submit" class="btn btn-primary">შენახვა</button>
      <a href="dashboard.php?module=product&action=list" class="btn btn-secondary">გაუქმება</a>
    </div>
  </form>
</div>

<script>
// Product type selection preview
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('product-type-select');
    const typePreview = document.getElementById('type-preview');
    const typeIcon = document.getElementById('type-icon');
    const typeDescription = document.getElementById('type-description');
    
    typeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const iconName = selectedOption.getAttribute('data-icon') || 'box';
            const description = selectedOption.text.split(' - ')[1] || '';
            
            // Update icon
            typeIcon.className = `icon me-2 icon-tabler icons-tabler-outline icon-tabler-${iconName}`;
            
            // Update description
            if (description) {
                typeDescription.textContent = description;
                typePreview.style.display = 'block';
            } else {
                typePreview.style.display = 'none';
            }
        } else {
            typePreview.style.display = 'none';
        }
    });
});
</script>

<?php require_once Config::includePath('footer.php'); ?>