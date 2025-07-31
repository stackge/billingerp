<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/UpdateManager.php';

// ავტორიზაციის შემოწმება
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$updateManager = new UpdateManager($pdo);
$message = '';
$messageType = '';

// განახლების გაშვება
if ($_POST['action'] ?? '' === 'run_update') {
    $version = $_POST['version'] ?? '';
    try {
        $result = $updateManager->runUpdate($version);
        $message = $result['message'];
        $messageType = 'success';
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = 'danger';
    }
}

// ყველა განახლების გაშვება
if ($_POST['action'] ?? '' === 'run_all_updates') {
    try {
        $results = $updateManager->runAllUpdates();
        $messages = [];
        foreach ($results as $result) {
            $messages[] = $result['message'];
        }
        $message = implode('<br>', $messages);
        $messageType = 'success';
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = 'danger';
    }
}

// ახალი მიგრაციის შექმნა
if ($_POST['action'] ?? '' === 'create_migration') {
    $version = $_POST['new_version'] ?? '';
    $description = $_POST['description'] ?? '';
    $upSql = $_POST['up_sql'] ?? '';
    $downSql = $_POST['down_sql'] ?? '';
    
    // ვალიდაცია
    if (empty($version) || empty($description) || empty($upSql)) {
        $message = "გთხოვთ შეავსოთ ყველა სავალდებულო ველი.";
        $messageType = 'danger';
    } elseif (!preg_match('/^\d+\.\d+\.\d+$/', $version)) {
        $message = "ვერსია უნდა იყოს X.Y.Z ფორმატში (მაგ: 1.0.3)";
        $messageType = 'danger';
    } else {
        try {
            // შევამოწმოთ არ არსებობს თუ არა უკვე ასეთი ვერსია
            $existingUpdates = $updateManager->getAvailableUpdates();
            foreach ($existingUpdates as $update) {
                if ($update['version'] === $version) {
                    throw new Exception("ვერსია $version უკვე არსებობს");
                }
            }
            
            // შევამოწმოთ ვერსიების ისტორიაში
            $history = $updateManager->getUpdateHistory();
            foreach ($history as $record) {
                if ($record['version'] === $version) {
                    throw new Exception("ვერსია $version უკვე გამოყენებულია");
                }
            }
            
            $result = $updateManager->createMigration($version, $description, $upSql, $downSql);
            $message = $result['message'];
            $messageType = 'success';
        } catch (Exception $e) {
            $message = "შეცდომა: " . $e->getMessage();
            $messageType = 'danger';
        }
    }
}

$currentVersion = $updateManager->getCurrentVersion();
$availableUpdates = $updateManager->getAvailableUpdates();
$updateHistory = $updateManager->getUpdateHistory();
?>
<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STACK - განახლებების მართვა</title>
    <link href="../dist/css/tabler.min.css" rel="stylesheet" />
    <style>
        .code-block { background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
        .version-badge { font-size: 0.875em; }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-wrapper">
            <div class="container-xl">
                <!-- Header -->
                <div class="page-header d-print-none">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="page-title">STACK - განახლებების მართვა</h2>
                            <div class="text-muted mt-1">
                                მიმდინარე ვერსია: <span class="badge bg-dark"><?= htmlspecialchars($currentVersion) ?></span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="../dashboard.php" class="btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l14 0"/>
                                    <path d="M5 12l6 6"/>
                                    <path d="M5 12l6 -6"/>
                                </svg>
                                უკან დაბრუნება
                            </a>
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

                <div class="row">
                    <!-- ხელმისაწვდომი განახლებები -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">ხელმისაწვდომი განახლებები</h3>
                                <?php if (count($availableUpdates) > 1): ?>
                                <div class="card-actions">
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="action" value="run_all_updates">
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('ყველა განახლების გაშვება?')">
                                            ყველას გაშვება
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <?php if (empty($availableUpdates)): ?>
                                <div class="text-center text-muted py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon mb-3 text-green">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22,4 12,14.01 9,11.01"/>
                                    </svg>
                                    <h3>ყველაფერი განახლებულია!</h3>
                                    <p class="text-muted">ახალი განახლებები ხელმისაწვდომი არ არის.</p>
                                </div>
                                <?php else: ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($availableUpdates as $update): ?>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <strong>ვერსია <?= htmlspecialchars($update['version']) ?></strong>
                                                <div class="text-muted"><?= htmlspecialchars($update['description']) ?></div>
                                                <small class="text-muted">ფაილი: <?= htmlspecialchars($update['filename']) ?></small>
                                            </div>
                                            <div class="col-auto">
                                                <form method="post" style="display: inline;">
                                                    <input type="hidden" name="action" value="run_update">
                                                    <input type="hidden" name="version" value="<?= htmlspecialchars($update['version']) ?>">
                                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('განახლების გაშვება?')">
                                                        გაშვება
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- განახლებების ისტორია -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">განახლებების ისტორია</h3>
                            </div>
                            <div class="card-body">
                                <?php if (empty($updateHistory)): ?>
                                <p class="text-muted">განახლებების ისტორია ცარიელია.</p>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ვერსია</th>
                                                <th>აღწერა</th>
                                                <th>სტატუსი</th>
                                                <th>თარიღი</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($updateHistory as $history): ?>
                                            <tr>
                                                <td><span class="badge bg-secondary version-badge"><?= htmlspecialchars($history['version']) ?></span></td>
                                                <td><?= htmlspecialchars($history['description']) ?></td>
                                                <td>
                                                    <?php
                                                    $statusClass = [
                                                        'completed' => 'success',
                                                        'failed' => 'danger',
                                                        'pending' => 'warning'
                                                    ];
                                                    $statusText = [
                                                        'completed' => 'დასრულებული',
                                                        'failed' => 'ვერ შესრულდა',
                                                        'pending' => 'მუშავდება'
                                                    ];
                                                    ?>
                                                    <span class="badge bg-<?= $statusClass[$history['status']] ?>">
                                                        <?= $statusText[$history['status']] ?>
                                                    </span>
                                                </td>
                                                <td><?= date('Y-m-d H:i', strtotime($history['executed_at'])) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ახალი მიგრაციის შექმნა -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">ახალი მიგრაციის შექმნა</h3>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <input type="hidden" name="action" value="create_migration">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">ვერსია</label>
                                        <?php
                                        // შემოთავაზებული შემდეგი ვერსია
                                        $parts = explode('.', $currentVersion);
                                        $nextMinor = $parts[0] . '.' . $parts[1] . '.' . ((int)$parts[2] + 1);
                                        $nextMajor = $parts[0] . '.' . ((int)$parts[1] + 1) . '.0';
                                        ?>
                                        <input type="text" name="new_version" class="form-control" placeholder="<?= $nextMinor ?>" required>
                                        <small class="form-hint">
                                            ფორმატი: X.Y.Z | შემოთავაზებული: 
                                            <a href="#" onclick="document.querySelector('[name=new_version]').value='<?= $nextMinor ?>'; return false;"><?= $nextMinor ?></a> | 
                                            <a href="#" onclick="document.querySelector('[name=new_version]').value='<?= $nextMajor ?>'; return false;"><?= $nextMajor ?></a>
                                        </small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">აღწერა</label>
                                        <input type="text" name="description" class="form-control" placeholder="მაგ: Add new column to users table" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">SQL (UP)</label>
                                        <textarea name="up_sql" class="form-control" rows="4" placeholder="ALTER TABLE users ADD COLUMN phone VARCHAR(20);" required></textarea>
                                        <small class="form-hint">განახლების SQL</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">SQL (DOWN) - არასავალდებულო</label>
                                        <textarea name="down_sql" class="form-control" rows="4" placeholder="ALTER TABLE users DROP COLUMN phone;"></textarea>
                                        <small class="form-hint">Rollback SQL</small>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">მიგრაციის შექმნა</button>
                                </form>
                            </div>
                        </div>

                        <!-- სასარგებლო ინფორმაცია -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">სასარგებლო ინფორმაცია</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>მიგრაციის ფაილების ლოკაცია:</strong>
                                    <div class="code-block">/admin/update/migrations/</div>
                                </div>
                                
                                <div class="mb-3">
                                    <strong>Backup ფაილები:</strong>
                                    <div class="code-block">/admin/update/backups/</div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <h4>მნიშვნელოვანი!</h4>
                                    <ul class="mb-0">
                                        <li>ყოველი განახლების წინ ავტომატურად იქმნება backup</li>
                                        <li>მიგრაციის ფაილები უნდა იყოს ვერსია_აღწერა.php ფორმატში</li>
                                        <li>ვერსიები ეშვება თანმიმდევრულად</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../dist/js/tabler.min.js"></script>
    <script>
        // მიგრაციის ფორმის validation
        document.addEventListener('DOMContentLoaded', function() {
            const migrationForm = document.querySelector('form[method="post"]');
            const versionInput = document.querySelector('input[name="new_version"]');
            const descriptionInput = document.querySelector('input[name="description"]');
            const upSqlInput = document.querySelector('textarea[name="up_sql"]');
            
            if (migrationForm) {
                migrationForm.addEventListener('submit', function(e) {
                    let errors = [];
                    
                    // ვერსიის ვალიდაცია
                    const version = versionInput.value.trim();
                    if (!version) {
                        errors.push('ვერსია სავალდებულოა');
                    } else if (!/^\d+\.\d+\.\d+$/.test(version)) {
                        errors.push('ვერსია უნდა იყოს X.Y.Z ფორმატში (მაგ: 1.0.3)');
                    }
                    
                    // აღწერის ვალიდაცია
                    if (!descriptionInput.value.trim()) {
                        errors.push('აღწერა სავალდებულოა');
                    }
                    
                    // SQL-ის ვალიდაცია
                    if (!upSqlInput.value.trim()) {
                        errors.push('SQL (UP) სავალდებულოა');
                    }
                    
                    if (errors.length > 0) {
                        alert('შეცდომები:\n' + errors.join('\n'));
                        e.preventDefault();
                        return false;
                    }
                    
                    return confirm('დარწმუნებული ხართ რომ გსურთ მიგრაციის შექმნა?');
                });
            }
            
            // ვერსიის real-time validation
            if (versionInput) {
                versionInput.addEventListener('input', function() {
                    const value = this.value;
                    if (value && !/^\d+\.\d+\.\d+$/.test(value)) {
                        this.style.borderColor = '#dc3545';
                        this.title = 'ვერსია უნდა იყოს X.Y.Z ფორმატში';
                    } else {
                        this.style.borderColor = '';
                        this.title = '';
                    }
                });
            }
        });
    </script>
</body>
</html>
