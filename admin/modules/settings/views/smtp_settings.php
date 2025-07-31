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
                <h2 class="page-title">SMTP სეტინგები</h2>
                <div class="text-muted mt-1">ელ.ფოსტის სერვერის კონფიგურაცია</div>
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
            <div><?= htmlspecialchars($message) ?></div>
        </div>
        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- SMTP კონფიგურაცია -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">SMTP სერვერის პარამეტრები</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="action" value="update_settings">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">SMTP სერვერი</label>
                                    <input type="text" name="smtp_host" class="form-control" 
                                           value="<?= htmlspecialchars($settings['smtp_host'] ?? '') ?>" 
                                           placeholder="mail.example.com" required>
                                    <small class="form-hint">მაგ: smtp.gmail.com, mail.yahoo.com</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">პორტი</label>
                                    <input type="number" name="smtp_port" class="form-control" 
                                           value="<?= htmlspecialchars($settings['smtp_port'] ?? '587') ?>" 
                                           placeholder="587" required>
                                    <small class="form-hint">587 (TLS) ან 465 (SSL)</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">დაცვა</label>
                                    <select name="smtp_secure" class="form-select" required>
                                        <option value="tls" <?= ($settings['smtp_secure'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS</option>
                                        <option value="ssl" <?= ($settings['smtp_secure'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" name="smtp_auth" class="form-check-input" 
                                       <?= ($settings['smtp_auth'] ?? '0') === '1' ? 'checked' : '' ?>>
                                <span class="form-check-label">SMTP ავტორიზაცია</span>
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">მომხმარებლის სახელი</label>
                                    <input type="email" name="smtp_username" class="form-control" 
                                           value="<?= htmlspecialchars($settings['smtp_username'] ?? '') ?>" 
                                           placeholder="user@example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">პაროლი</label>
                                    <div class="input-group">
                                        <input type="password" name="smtp_password" id="smtp_password" class="form-control" 
                                               value="<?= htmlspecialchars($settings['smtp_password'] ?? '') ?>" 
                                               placeholder="••••••••">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">გამომგზავნის ელ.ფოსტა</label>
                                    <input type="email" name="smtp_from_email" class="form-control" 
                                           value="<?= htmlspecialchars($settings['smtp_from_email'] ?? '') ?>" 
                                           placeholder="noreply@example.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">გამომგზავნის სახელი</label>
                                    <input type="text" name="smtp_from_name" class="form-control" 
                                           value="<?= htmlspecialchars($settings['smtp_from_name'] ?? '') ?>" 
                                           placeholder="My Website" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Debug რეჟიმი</label>
                            <select name="smtp_debug" class="form-select">
                                <option value="0" <?= ($settings['smtp_debug'] ?? '0') === '0' ? 'selected' : '' ?>>გამორთული</option>
                                <option value="1" <?= ($settings['smtp_debug'] ?? '0') === '1' ? 'selected' : '' ?>>კლიენტის შეტყობინებები</option>
                                <option value="2" <?= ($settings['smtp_debug'] ?? '0') === '2' ? 'selected' : '' ?>>კლიენტი + სერვერი</option>
                            </select>
                            <small class="form-hint">პროდაქშენში გამოიყენეთ 0</small>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SMTP ტესტი -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">კავშირის ტესტი</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="action" value="test_connection">
                        
                        <div class="mb-3">
                            <label class="form-label">ტესტური ელ.ფოსტა (არასავალდებულო)</label>
                            <input type="email" name="test_email" class="form-control" 
                                   placeholder="test@example.com">
                            <small class="form-hint">თუ მითითებული იქნება, ტესტური წერილი გაიგზავნება</small>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22,4 12,14.01 9,11.01"/>
                            </svg>
                            კავშირის ტესტი
                        </button>
                    </form>
                </div>
            </div>

            <!-- მიმდინარე კონფიგურაცია -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">მიმდინარე კონფიგურაცია</h3>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <strong>სერვერი:</strong>
                            <span class="badge bg-secondary"><?= htmlspecialchars($settings['smtp_host'] ?? 'არ არის მითითებული') ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <strong>პორტი:</strong>
                            <span class="badge bg-info"><?= htmlspecialchars($settings['smtp_port'] ?? '587') ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <strong>დაცვა:</strong>
                            <span class="badge bg-warning"><?= strtoupper($settings['smtp_secure'] ?? 'TLS') ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <strong>ავტორიზაცია:</strong>
                            <span class="badge bg-<?= ($settings['smtp_auth'] ?? '0') === '1' ? 'success' : 'danger' ?>">
                                <?= ($settings['smtp_auth'] ?? '0') === '1' ? 'ჩართული' : 'გამორთული' ?>
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <strong>გამომგზავნი:</strong>
                            <span class="text-muted text-truncate" style="max-width: 150px;">
                                <?= htmlspecialchars($settings['smtp_from_email'] ?? 'არ არის მითითებული') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- სასარგებლო ინფორმაცია -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">სასარგებლო ინფორმაცია</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h4>Gmail SMTP:</h4>
                        <ul class="mb-0">
                            <li>სერვერი: smtp.gmail.com</li>
                            <li>პორტი: 587 (TLS)</li>
                            <li>App Password საჭიროა!</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h4>მნიშვნელოვანი!</h4>
                        <ul class="mb-0">
                            <li>პაროლი ნაჩვენებია ღია ტექსტად</li>
                            <li>გთხოვთ დარწმუნდით უსაფრთხოებაში</li>
                            <li>გამოიყენეთ App Password Gmail-ისთვის</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../dist/js/tabler.min.js"></script>
<script>
function togglePassword() {
    const passwordField = document.getElementById('smtp_password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[method="post"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const smtpHost = document.querySelector('input[name="smtp_host"]').value.trim();
            const smtpPort = document.querySelector('input[name="smtp_port"]').value.trim();
            const fromEmail = document.querySelector('input[name="smtp_from_email"]').value.trim();
            
            if (!smtpHost || !smtpPort || !fromEmail) {
                alert('გთხოვთ შეავსოთ ყველა სავალდებულო ველი!');
                e.preventDefault();
                return false;
            }
            
            if (parseInt(smtpPort) < 1 || parseInt(smtpPort) > 65535) {
                alert('პორტი უნდა იყოს 1-65535 დიაპაზონში!');
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>

<?php require_once Config::includePath('footer.php'); ?>
