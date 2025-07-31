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
                <h2 class="page-title">
                    <?php
                    switch ($action) {
                        case 'add': echo 'ახალი მომხმარებლის დამატება'; break;
                        case 'edit': echo 'მომხმარებლის რედაქტირება'; break;
                        case 'profile': echo 'მომხმარებლის პროფილი'; break;
                        default: echo 'მომხმარებლების მართვა'; break;
                    }
                    ?>
                </h2>
                <?php if ($action === 'list'): ?>
                <div class="text-muted mt-1">სისტემის მომხმარებლების კონფიგურაცია და მართვა</div>
                <?php endif; ?>
            </div>
            <div class="col-auto">
                <div class="btn-list">
                    <?php if ($action === 'list'): ?>
                    <a href="dashboard.php?module=users&action=management&subaction=add" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M12 5l0 14"/>
                            <path d="M5 12l14 0"/>
                        </svg>
                        ახალი მომხმარებელი
                    </a>
                    <?php else: ?>
                    <a href="dashboard.php?module=users&action=management" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M5 12l14 0"/>
                            <path d="M5 12l6 6"/>
                            <path d="M5 12l6 -6"/>
                        </svg>
                        უკან დაბრუნება
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <?php if ($message): ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible">
        <div class="d-flex">
            <div><?= $message ?></div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
    <?php endif; ?>

    <?php if ($action === 'list'): ?>
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">სულ მომხმარებლები</div>
                        <div class="ms-auto lh-1">
                            <div class="dropdown">
                                <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <circle cx="12" cy="12" r="1"/>
                                        <circle cx="12" cy="5" r="1"/>
                                        <circle cx="12" cy="19" r="1"/>
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="dashboard.php?module=users&action=management">ყველას ნახვა</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h1 mb-3"><?= $userStats['total'] ?></div>
                    <div class="d-flex mb-2">
                        <div>რეგისტრაცია</div>
                        <div class="ms-auto">
                            <span class="text-green d-inline-flex align-items-center lh-1">
                                <?= $userStats['this_month'] ?> <small class="text-muted ms-1">ამ თვეში</small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">აქტიური</div>
                    <div class="h1 mb-3 text-green"><?= $userStats['active'] ?></div>
                    <div class="d-flex mb-2">
                        <div>უაქტივო</div>
                        <div class="ms-auto">
                            <span class="text-red"><?= $userStats['total'] - $userStats['active'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">ადმინისტრატორები</div>
                    <div class="h1 mb-3 text-blue"><?= $userStats['admins'] ?></div>
                    <div class="d-flex mb-2">
                        <div>სხვა როლები</div>
                        <div class="ms-auto">
                            <span class="text-muted"><?= $userStats['total'] - $userStats['admins'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">ონლაინ</div>
                    <div class="h1 mb-3 text-yellow">0</div>
                    <div class="d-flex mb-2">
                        <div>უკანასკნელი აქტივობა</div>
                        <div class="ms-auto">
                            <span class="text-muted">დღეს</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row">
                <input type="hidden" name="module" value="users">
                <input type="hidden" name="action" value="management">
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">ძიება</label>
                        <input type="text" name="search" class="form-control" 
                               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" 
                               placeholder="სახელი, გვარი, ელ.ფოსტა...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">როლი</label>
                        <select name="role" class="form-select">
                            <option value="">ყველა როლი</option>
                            <?php foreach ($availableRoles as $roleKey => $roleLabel): ?>
                            <option value="<?= $roleKey ?>" <?= ($_GET['role'] ?? '') === $roleKey ? 'selected' : '' ?>>
                                <?= $roleLabel ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">სტატუსი</label>
                        <select name="status" class="form-select">
                            <option value="">ყველა სტატუსი</option>
                            <option value="1" <?= ($_GET['status'] ?? '') === '1' ? 'selected' : '' ?>>აქტიური</option>
                            <option value="0" <?= ($_GET['status'] ?? '') === '0' ? 'selected' : '' ?>>უაქტივო</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="btn-list">
                            <button type="submit" class="btn btn-primary w-100">ძიება</button>
                            <a href="dashboard.php?module=users&action=management" class="btn btn-outline-secondary">გასუფთავება</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">მომხმარებლების სია</h3>
            <div class="card-actions">
                <span class="text-muted">სულ: <?= count($users) ?> მომხმარებელი</span>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($users)): ?>
            <div class="text-center text-muted py-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon mb-3">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <h3>მომხმარებლები ვერ მოიძებნა</h3>
                <p class="text-muted">შეცვალეთ ფილტრები ან დაამატეთ ახალი მომხმარებელი</p>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th>მომხმარებელი</th>
                            <th>ელ.ფოსტა</th>
                            <th>როლი</th>
                            <th>სტატუსი</th>
                            <th>რეგისტრაცია</th>
                            <th>მოქმედებები</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar bg-<?= $user['role'] === 'admin' ? 'red' : ($user['is_active'] ? 'green' : 'secondary') ?>-lt">
                                        <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                                    </span>
                                    <div class="ms-2">
                                        <div class="fw-bold"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></div>
                                        <div class="text-muted small">ID: <?= $user['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($user['email']) ?></div>
                                <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                <small class="text-blue">ეს ხარ თუ</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'red' : ($user['role'] === 'manager' ? 'blue' : 'secondary') ?>">
                                    <?= $availableRoles[$user['role']] ?? $user['role'] ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?= $user['is_active'] ? 'success' : 'danger' ?>">
                                    <?= $user['is_active'] ? 'აქტიური' : 'უაქტივო' ?>
                                </span>
                            </td>
                            <td>
                                <div><?= date('Y-m-d', strtotime($user['created_at'])) ?></div>
                                <small class="text-muted"><?= date('H:i', strtotime($user['created_at'])) ?></small>
                            </td>
                            <td>
                                <div class="btn-list">
                                    <a href="dashboard.php?module=users&action=management&subaction=profile&id=<?= $user['id'] ?>" 
                                       class="btn btn-sm btn-outline-info" title="პროფილი">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </a>
                                    <a href="dashboard.php?module=users&action=management&subaction=edit&id=<?= $user['id'] ?>" 
                                       class="btn btn-sm btn-outline-primary" title="რედაქტირება">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                            <path d="M16 5l3 3"/>
                                        </svg>
                                    </a>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-<?= $user['is_active'] ? 'warning' : 'success' ?>" 
                                                title="<?= $user['is_active'] ? 'გამორთვა' : 'ჩართვა' ?>"
                                                onclick="return confirm('დარწმუნებული ხართ?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                                <?php if ($user['is_active']): ?>
                                                <path d="M10 3H6a2 2 0 0 0-2 2v14c0 5.5 7.5 3 7.5 3s7.5 2.5 7.5-3V5a2 2 0 0 0-2-2h-4"/>
                                                <path d="M8 5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2"/>
                                                <?php else: ?>
                                                <path d="M9 11l3 3l8 -8"/>
                                                <?php endif; ?>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="წაშლა"
                                                onclick="return confirm('დარწმუნებული ხართ რომ გსურთ ამ მომხმარებლის წაშლა?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                                <path d="M4 7l16 0"/>
                                                <path d="M10 11l0 6"/>
                                                <path d="M14 11l0 6"/>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php elseif ($action === 'add' || $action === 'edit'): ?>
    <!-- Add/Edit Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?= $action === 'add' ? 'ახალი მომხმარებლის დამატება' : 'მომხმარებლის რედაქტირება' ?>
            </h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="action" value="<?= $action ?>">
                <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">სახელი</label>
                            <input type="text" name="first_name" class="form-control" 
                                   value="<?= htmlspecialchars($editUser['first_name'] ?? '') ?>" 
                                   placeholder="სახელი" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">გვარი</label>
                            <input type="text" name="last_name" class="form-control" 
                                   value="<?= htmlspecialchars($editUser['last_name'] ?? '') ?>" 
                                   placeholder="გვარი" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">ელ.ფოსტა</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= htmlspecialchars($editUser['email'] ?? '') ?>" 
                                   placeholder="user@example.com" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">პაროლი <?= $action === 'edit' ? '(დატოვეთ ცარიელი თუ არ გსურთ ცვლილება)' : '' ?></label>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="••••••••" <?= $action === 'add' ? 'required' : '' ?>>
                            <?php if ($action === 'add'): ?>
                            <small class="form-hint">მინიმუმ 6 სიმბოლო</small>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">როლი</label>
                            <select name="role" class="form-select" required>
                                <?php foreach ($availableRoles as $roleKey => $roleLabel): ?>
                                <option value="<?= $roleKey ?>" 
                                        <?= ($editUser['role'] ?? 'user') === $roleKey ? 'selected' : '' ?>>
                                    <?= $roleLabel ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   <?= ($editUser['is_active'] ?? 1) ? 'checked' : '' ?>>
                            <label class="form-check-label">აქტიური მომხმარებელი</label>
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
                    <a href="dashboard.php?module=users&action=management" class="btn btn-secondary">გაუქმება</a>
                </div>
            </form>
        </div>
    </div>

    <?php elseif ($action === 'profile'): ?>
    <!-- User Profile -->
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Info -->
            <div class="card">
                <div class="card-body text-center">
                    <span class="avatar avatar-xl bg-<?= $profileUser['role'] === 'admin' ? 'red' : ($profileUser['is_active'] ? 'green' : 'secondary') ?>-lt mb-3">
                        <?= strtoupper(substr($profileUser['first_name'], 0, 1) . substr($profileUser['last_name'], 0, 1)) ?>
                    </span>
                    <h3 class="m-0 mb-1"><?= htmlspecialchars($profileUser['first_name'] . ' ' . $profileUser['last_name']) ?></h3>
                    <div class="text-muted"><?= htmlspecialchars($profileUser['email']) ?></div>
                    <div class="mt-3">
                        <span class="badge bg-<?= $profileUser['role'] === 'admin' ? 'red' : ($profileUser['role'] === 'manager' ? 'blue' : 'secondary') ?> me-1">
                            <?= $availableRoles[$profileUser['role']] ?? $profileUser['role'] ?>
                        </span>
                        <span class="badge bg-<?= $profileUser['is_active'] ? 'success' : 'danger' ?>">
                            <?= $profileUser['is_active'] ? 'აქტიური' : 'უაქტივო' ?>
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row text-center">
                        <div class="col">
                            <div class="h4 m-0">ID</div>
                            <div class="text-muted"><?= $profileUser['id'] ?></div>
                        </div>
                        <div class="col">
                            <div class="h4 m-0">რეგისტრაცია</div>
                            <div class="text-muted"><?= date('Y-m-d', strtotime($profileUser['created_at'])) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Profile Details -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">პროფილის დეტალები</h3>
                    <div class="card-actions">
                        <a href="dashboard.php?module=users&action=management&subaction=edit&id=<?= $profileUser['id'] ?>" class="btn btn-primary btn-sm">
                            რედაქტირება
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">სახელი</label>
                                <div class="form-control-plaintext"><?= htmlspecialchars($profileUser['first_name']) ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ელ.ფოსტა</label>
                                <div class="form-control-plaintext"><?= htmlspecialchars($profileUser['email']) ?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">გვარი</label>
                                <div class="form-control-plaintext"><?= htmlspecialchars($profileUser['last_name']) ?></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ბოლო განახლება</label>
                                <div class="form-control-plaintext">
                                    <?= $profileUser['updated_at'] ? date('Y-m-d H:i', strtotime($profileUser['updated_at'])) : 'არასდროს' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Password Change -->
            <?php if ($profileUser['id'] == $_SESSION['user_id']): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">პაროლის შეცვლა</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="action" value="change_password">
                        <input type="hidden" name="id" value="<?= $profileUser['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">მიმდინარე პაროლი</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ახალი პაროლი</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">პაროლის დადასტურება</label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">პაროლის შეცვლა</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="../dist/js/tabler.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('form[method="post"]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const action = form.querySelector('input[name="action"]')?.value;
            
            if (action === 'add' || action === 'edit') {
                const firstName = form.querySelector('input[name="first_name"]')?.value.trim();
                const lastName = form.querySelector('input[name="last_name"]')?.value.trim();
                const email = form.querySelector('input[name="email"]')?.value.trim();
                const password = form.querySelector('input[name="password"]')?.value;
                
                let errors = [];
                
                if (!firstName) errors.push('სახელი სავალდებულოა');
                if (!lastName) errors.push('გვარი სავალდებულოა');
                if (!email || !email.includes('@')) errors.push('ვალიდური ელ.ფოსტა სავალდებულოა');
                
                if (action === 'add' && (!password || password.length < 6)) {
                    errors.push('პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო');
                }
                
                if (action === 'edit' && password && password.length < 6) {
                    errors.push('პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო');
                }
                
                if (errors.length > 0) {
                    alert('შეცდომები:\n' + errors.join('\n'));
                    e.preventDefault();
                    return false;
                }
            }
            
            if (action === 'change_password') {
                const currentPassword = form.querySelector('input[name="current_password"]')?.value;
                const newPassword = form.querySelector('input[name="new_password"]')?.value;
                const confirmPassword = form.querySelector('input[name="confirm_password"]')?.value;
                
                let errors = [];
                
                if (!currentPassword) errors.push('მიმდინარე პაროლი სავალდებულოა');
                if (!newPassword || newPassword.length < 6) errors.push('ახალი პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო');
                if (newPassword !== confirmPassword) errors.push('პაროლები არ ემთხვევა');
                
                if (errors.length > 0) {
                    alert('შეცდომები:\n' + errors.join('\n'));
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
});
</script>

<?php require_once Config::includePath('footer.php'); ?>
