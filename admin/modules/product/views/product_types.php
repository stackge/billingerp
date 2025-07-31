<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;
?>

<?php require_once Config::includePath('head.php'); ?>
<?php require_once Config::includePath('navbar.php'); ?>
<?php require_once Config::includePath('pageheader.php'); ?>
<?php require_once Config::includePath('pagebodystart.php'); ?>

<div class="container-xl mt-4">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">პროდუქტის ტიპების მართვა</h2>
                <div class="text-muted mt-1">პროდუქტების კატეგორიების კონფიგურაცია</div>
            </div>
            <div class="col-auto">
                <div class="btn-list">
                    <?php if ($action === 'list'): ?>
                    <a href="dashboard.php?module=product&action=types&subaction=add" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        ახალი ტიპი
                    </a>
                    <?php endif; ?>
                    <a href="dashboard.php?module=product&action=list" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M5 12l14 0"/>
                            <path d="M5 12l6 6"/>
                            <path d="M5 12l6 -6"/>
                        </svg>
                        უკან დაბრუნება
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible">
        <div class="d-flex">
            <div><?= htmlspecialchars($message) ?></div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <!-- Product Types List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">პროდუქტის ტიპები</h3>
            <div class="card-actions">
                <small class="text-muted">გადაათრიე რიგითობის ცვლილებისთვის</small>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($productTypes)): ?>
            <div class="text-center text-muted py-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon mb-3">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="3.27,6.96 12,12.01 20.73,6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                </svg>
                <h3>პროდუქტის ტიპები არ არის</h3>
                <p class="text-muted">დაამატეთ ახალი პროდუქტის ტიპი</p>
            </div>
            <?php else: ?>
            <div id="sortable-types" class="list-group list-group-flush">
                <?php foreach ($productTypes as $type): ?>
                <div class="list-group-item" data-id="<?= $type['id'] ?>">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="handle cursor-move">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-muted">
                                    <line x1="8" y1="6" x2="21" y2="6"/>
                                    <line x1="8" y1="12" x2="21" y2="12"/>
                                    <line x1="8" y1="18" x2="21" y2="18"/>
                                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                                </svg>
                            </span>
                        </div>
                        <div class="col-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-<?= htmlspecialchars($type['icon']) ?>">
                                <!-- Icon will be rendered by Tabler -->
                            </svg>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center">
                                <strong><?= htmlspecialchars($type['name']) ?></strong>
                                <?php if (!$type['is_active']): ?>
                                <span class="badge bg-secondary ms-2">უაქტივო</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($type['description']): ?>
                            <div class="text-muted small"><?= htmlspecialchars($type['description']) ?></div>
                            <?php endif; ?>
                            <small class="text-muted">რიგითობა: <?= $type['sort_order'] ?></small>
                        </div>
                        <div class="col-auto">
                            <div class="btn-list">
                                <a href="dashboard.php?module=product&action=types&subaction=edit&id=<?= $type['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                        <path d="M16 5l3 3"/>
                                    </svg>
                                    რედაქტირება
                                </a>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $type['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('დარწმუნებული ხართ რომ გსურთ ამ ტიპის წაშლა?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path d="M4 7l16 0"/>
                                            <path d="M10 11l0 6"/>
                                            <path d="M14 11l0 6"/>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                        წაშლა
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <form id="sort-form" method="post" style="display: none;">
                <input type="hidden" name="action" value="update_order">
                <div id="sort-orders"></div>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <?php elseif ($action === 'add' || $action === 'edit'): ?>
    <!-- Add/Edit Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?= $action === 'add' ? 'ახალი პროდუქტის ტიპი' : 'პროდუქტის ტიპის რედაქტირება' ?>
            </h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="action" value="<?= $action ?>">
                <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= $editType['id'] ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ტიპის სახელი</label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= htmlspecialchars($editType['name'] ?? '') ?>" 
                                   placeholder="მაგ: Shared Hosting" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">აღწერა</label>
                            <textarea name="description" class="form-control" rows="3" 
                                      placeholder="ტიპის დეტალური აღწერა"><?= htmlspecialchars($editType['description'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">რიგითობა</label>
                            <input type="number" name="sort_order" class="form-control" 
                                   value="<?= $editType['sort_order'] ?? '0' ?>" 
                                   placeholder="0">
                            <small class="form-hint">უფრო პატარა რიცხვი = უფრო ზევით</small>
                        </div>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   <?= ($editType['is_active'] ?? 1) ? 'checked' : '' ?>>
                            <label class="form-check-label">აქტიური</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">აიკონი</label>
                            <select name="icon" class="form-select" id="icon-select">
                                <?php foreach ($availableIcons as $iconName => $iconLabel): ?>
                                <option value="<?= $iconName ?>" 
                                        <?= ($editType['icon'] ?? 'box') === $iconName ? 'selected' : '' ?>>
                                    <?= $iconLabel ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">აიკონის გადახედვა</label>
                            <div class="icon-preview p-4 border rounded text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline" id="preview-icon">
                                    <!-- Icon preview -->
                                </svg>
                                <div class="mt-2 text-muted" id="preview-text">აიკონის გადახედვა</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17,21 17,13 7,13 7,21"/>
                            <polyline points="7,3 7,8 15,8"/>
                        </svg>
                        შენახვა
                    </button>
                    <a href="dashboard.php?module=product&action=types" class="btn btn-secondary">გაუქმება</a>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="../dist/js/tabler.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sortable functionality
    const sortableEl = document.getElementById('sortable-types');
    if (sortableEl) {
        const sortable = Sortable.create(sortableEl, {
            handle: '.handle',
            animation: 150,
            onEnd: function() {
                const items = sortableEl.querySelectorAll('.list-group-item');
                const orders = {};
                
                items.forEach((item, index) => {
                    const id = item.getAttribute('data-id');
                    orders[id] = index + 1;
                });
                
                // Update hidden form
                const sortOrdersDiv = document.getElementById('sort-orders');
                sortOrdersDiv.innerHTML = '';
                
                Object.keys(orders).forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `orders[${id}]`;
                    input.value = orders[id];
                    sortOrdersDiv.appendChild(input);
                });
                
                // Submit form
                document.getElementById('sort-form').submit();
            }
        });
    }
    
    // Icon preview
    const iconSelect = document.getElementById('icon-select');
    const previewIcon = document.getElementById('preview-icon');
    const previewText = document.getElementById('preview-text');
    
    if (iconSelect && previewIcon) {
        function updateIconPreview() {
            const selectedIcon = iconSelect.value;
            const selectedText = iconSelect.options[iconSelect.selectedIndex].text;
            
            // Update icon class
            previewIcon.className = `icon icon-tabler icons-tabler-outline icon-tabler-${selectedIcon}`;
            previewText.textContent = selectedText;
        }
        
        // Initialize preview
        updateIconPreview();
        
        // Update on change
        iconSelect.addEventListener('change', updateIconPreview);
    }
    
    // Form validation
    const form = document.querySelector('form[method="post"]');
    if (form && form.querySelector('input[name="name"]')) {
        form.addEventListener('submit', function(e) {
            const nameInput = form.querySelector('input[name="name"]');
            if (!nameInput.value.trim()) {
                alert('ტიპის სახელი სავალდებულოა');
                e.preventDefault();
                nameInput.focus();
                return false;
            }
        });
    }
});
</script>

<?php require_once Config::includePath('footer.php'); ?>
