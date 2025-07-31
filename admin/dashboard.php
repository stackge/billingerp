<?php
require_once __DIR__ . '/includes/init.php';     // ავტორიზაცია
require_once __DIR__ . '/includes/Config.php';   // კლასები, path-ები

$hasModule = isset($_GET['module']) && isset($_GET['action']);

if ($hasModule) {
    // უბრალოდ ჩატვირთე router და გაწყვიტე script
    require_once __DIR__ . '/includes/router.php';
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/includes/DashboardModel.php';

use App\Config;

// სტატისტიკის ამოღება
DashboardModel::setDb($pdo);
$stats = DashboardModel::getSystemStats();

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
?>
<!-- CONTENT START -->
      <div class="page-wrapper">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none text-white">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">მიმოხილვა</div>
                <h2 class="page-title">STACK - მთავარი მართვის სისტემა</h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <span class="d-none d-sm-inline">
                    <a href="#" class="btn btn-dark btn-2"> ახალი ხედი </a>
                  </span>
                  <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="icon icon-2"
                    >
                      <path d="M12 5l0 14" />
                      <path d="M5 12l14 0" />
                    </svg>
                    ახალი რეპორტის შექმნა
                  </a>
                  <a
                    href="#"
                    class="btn btn-primary btn-6 d-sm-none btn-icon"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-report"
                    aria-label="ახალი რეპორტის შექმნა"
                  >
                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="icon icon-2"
                    >
                      <path d="M12 5l0 14" />
                      <path d="M5 12l14 0" />
                    </svg>
                  </a>
                </div>
                <!-- BEGIN MODAL -->
                <!-- END MODAL -->
              </div>
            </div>
          </div>
        </div>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE BODY -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">კლიენტები</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">
                            სულ
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="dashboard.php?module=clients&action=list">კლიენტების სია</a>
                            <a class="dropdown-item" href="dashboard.php?module=clients&action=add">ახალი კლიენტი</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="h1 mb-3"><?= $stats['clients']['total'] ?></div>
                    <div class="d-flex mb-2">
                      <div>აქტიური კლიენტები</div>
                      <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          <?= $stats['clients']['active'] ?>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-blue" style="width: <?= $stats['clients']['total'] > 0 ? round(($stats['clients']['active'] / $stats['clients']['total']) * 100) : 0 ?>%" role="progressbar">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">შემოსავალი</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">
                            ამ თვეში
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="dashboard.php?module=billing&submodule=invoices&action=list">ინვოისები</a>
                            <a class="dropdown-item" href="dashboard.php?module=billing&submodule=transactions&action=list">ტრანზაქციები</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-0 me-2">₾<?= number_format($stats['billing']['monthly_revenue'], 2) ?></div>
                      <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          <?= $stats['billing']['paid_invoices'] ?> გადახდილი
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
                            <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/>
                            <path d="M3 10l18 0"/>
                            <path d="M7 15l.01 0"/>
                            <path d="M11 15l2 0"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">პროდუქტები</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">
                            სულ
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="dashboard.php?module=product&action=list">პროდუქტების სია</a>
                            <a class="dropdown-item" href="dashboard.php?module=product&action=create">ახალი პროდუქტი</a>
                            <a class="dropdown-item" href="dashboard.php?module=product&action=types">პროდუქტის ტიპები</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2"><?= $stats['products']['total'] ?></div>
                      <div class="me-auto">
                        <span class="text-blue d-inline-flex align-items-center lh-1">
                          <?= $stats['products']['types'] ?> ტიპი
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
                            <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                            <path d="M12 12l8 -4.5"/>
                            <path d="M12 12l0 9"/>
                            <path d="M12 12l-8 -4.5"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">მომხმარებლები</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">
                            სისტემაში
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="dashboard.php?module=users&action=management">მომხმარებლების მართვა</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2"><?= $stats['users']['total'] ?></div>
                      <div class="me-auto">
                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                          <?= $stats['users']['admins'] ?> ადმინი
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37c1 .608 2.296.07 2.572-1.065z"/>
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- სერვერის სტატისტიკა -->
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">სერვერი</div>
                      <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown">
                            რესურსები
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">PHP <?= $stats['server']['php_version'] ?></a>
                            <a class="dropdown-item" href="#">MySQL <?= substr($stats['server']['mysql_version'], 0, 10) ?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2"><?= $stats['server']['memory_usage'] ?>MB</div>
                      <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                          CPU: <?= $stats['server']['cpu_load'] ?>%
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon ms-1 icon-2">
                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                            <rect x="9" y="9" width="6" height="6"/>
                            <path d="M9 1v3"/>
                            <path d="M15 1v3"/>
                            <path d="M9 20v3"/>
                            <path d="M15 20v3"/>
                            <path d="M20 9h3"/>
                            <path d="M20 14h3"/>
                            <path d="M1 9h3"/>
                            <path d="M1 14h3"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                                <path d="M3 7l9 6l9 -6"/>
                              </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium"><?= $stats['billing']['total_invoices'] ?> ინვოისი</div>
                            <div class="text-secondary"><?= $stats['billing']['pending_invoices'] ?> გადაუხდელი</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/>
                                <path d="M3 10l18 0"/>
                                <path d="M7 15l.01 0"/>
                                <path d="M11 15l2 0"/>
                              </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium"><?= $stats['billing']['total_transactions'] ?> ტრანზაქცია</div>
                            <div class="text-secondary">₾<?= number_format($stats['billing']['total_revenue'], 2) ?> სულ</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-info text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/>
                                <path d="M3 7l9 6l9 -6"/>
                              </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium"><?= $stats['marketing']['total_emails'] ?> ელ.ფოსტა</div>
                            <div class="text-secondary"><?= $stats['marketing']['sent_emails'] ?> გაგზავნილი</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-warning text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                <path d="M12 12l8 -4.5"/>
                                <path d="M12 12l0 9"/>
                                <path d="M12 12l-8 -4.5"/>
                              </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium"><?= $stats['products']['active'] ?> აქტიური</div>
                            <div class="text-secondary"><?= $stats['products']['this_month'] ?> ამ თვეში</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="row row-cards">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body">
                        <p class="mb-3">სერვერის რესურსები - <strong><?= $stats['server']['memory_usage'] ?> MB</strong> მეხსიერება / <strong><?= $stats['server']['disk_free'] ?> GB</strong> თავისუფალი</p>
                        <div class="progress progress-separated mb-3">
                          <div class="progress-bar bg-primary" role="progressbar" style="width: <?= round(($stats['server']['memory_usage'] / (int)$stats['server']['memory_limit']) * 100) ?>%" aria-label="Memory"></div>
                          <div class="progress-bar bg-info" role="progressbar" style="width: <?= round($stats['server']['cpu_load'] * 10) ?>%" aria-label="CPU"></div>
                          <div class="progress-bar bg-success" role="progressbar" style="width: <?= round(($stats['server']['disk_total'] - $stats['server']['disk_free']) / $stats['server']['disk_total'] * 100) ?>%" aria-label="Disk"></div>
                        </div>
                        <div class="row">
                          <div class="col-auto d-flex align-items-center pe-2">
                            <span class="legend me-2 bg-primary"></span>
                            <span>მეხსიერება</span>
                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary"><?= $stats['server']['memory_usage'] ?>MB</span>
                          </div>
                          <div class="col-auto d-flex align-items-center px-2">
                            <span class="legend me-2 bg-info"></span>
                            <span>CPU</span>
                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary"><?= $stats['server']['cpu_load'] ?>%</span>
                          </div>
                          <div class="col-auto d-flex align-items-center px-2">
                            <span class="legend me-2 bg-success"></span>
                            <span>დისკი</span>
                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary"><?= round($stats['server']['disk_total'] - $stats['server']['disk_free'], 1) ?>GB</span>
                          </div>
                          <div class="col-auto d-flex align-items-center ps-2">
                            <span class="legend me-2"></span>
                            <span>თავისუფალი</span>
                            <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary"><?= $stats['server']['disk_free'] ?>GB</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card" style="height: 28rem">
                      <div class="card-header">
                        <h3 class="card-title">სისტემის მომხმარებლები</h3>
                        <div class="card-actions">
                          <a href="dashboard.php?module=users&action=management" class="btn btn-primary btn-sm">
                            ყველა მომხმარებელი
                          </a>
                        </div>
                      </div>
                      <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                        <div class="divide-y">
                          <?php 
                          // Get users from database
                          try {
                            $stmt = $pdo->prepare("SELECT id, username, email, first_name, last_name, role, is_active, created_at, last_login FROM users ORDER BY created_at DESC LIMIT 15");
                            $stmt->execute();
                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          } catch (PDOException $e) {
                            $users = [];
                          }
                          
                          if (!empty($users)): 
                            foreach($users as $user): 
                              // Generate initials for avatar
                              $initials = '';
                              if ($user['first_name'] && $user['last_name']) {
                                $initials = strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
                              } elseif ($user['username']) {
                                $initials = strtoupper(substr($user['username'], 0, 2));
                              } else {
                                $initials = strtoupper(substr($user['email'], 0, 2));
                              }
                              
                              // Role translation to Georgian
                              $role_georgian = [
                                'admin' => 'ადმინისტრატორი',
                                'manager' => 'მენეჯერი',
                                'user' => 'მომხმარებელი',
                                'client' => 'კლიენტი'
                              ];
                              $role_text = isset($role_georgian[$user['role']]) ? $role_georgian[$user['role']] : $user['role'];
                              
                              // Status badge (using is_active instead of status)
                              $status_class = $user['is_active'] ? 'bg-success' : 'bg-secondary';
                              $status_text = $user['is_active'] ? 'აქტიური' : 'არააქტიური';
                              
                              // Display name
                              $display_name = trim($user['first_name'] . ' ' . $user['last_name']) ?: $user['username'];
                              
                              // Last activity
                              $last_activity = $user['last_login'] ? 
                                'ბოლო აქტივობა: ' . date('d M Y', strtotime($user['last_login'])) : 
                                'რეგისტრირებული: ' . date('d M Y', strtotime($user['created_at']));
                          ?>
                          <div>
                            <div class="row">
                              <div class="col-auto">
                                <span class="avatar"><?= htmlspecialchars($initials) ?></span>
                              </div>
                              <div class="col">
                                <div class="text-truncate">
                                  <strong><?= htmlspecialchars($display_name) ?></strong>
                                  <span class="badge <?= $status_class ?> badge-sm ms-2"><?= $status_text ?></span>
                                </div>
                                <div class="text-secondary small">
                                  <?= htmlspecialchars($user['email']) ?> · <?= $role_text ?>
                                </div>
                                <div class="text-secondary small">
                                  <?= $last_activity ?>
                                </div>
                              </div>
                              <div class="col-auto align-self-center">
                                <div class="dropdown">
                                  <button class="btn btn-ghost-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    მოქმედებები
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="dashboard.php?module=users&action=view&id=<?= $user['id'] ?>">
                                      ნახვა
                                    </a>
                                    <a class="dropdown-item" href="dashboard.php?module=users&action=edit&id=<?= $user['id'] ?>">
                                      რედაქტირება
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php 
                            endforeach; 
                          else: 
                          ?>
                          <div class="empty">
                            <div class="empty-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="7" r="4"/>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                              </svg>
                            </div>
                            <p class="empty-title">მომხმარებლები არ მოიძებნა</p>
                            <p class="empty-subtitle text-muted">
                              სისტემაში ჯერ არ არის რეგისტრირებული მომხმარებლები.
                            </p>
                          </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header border-0">
                    <div class="card-title">ბოლო აქტივობა</div>
                  </div>
                  <div class="card-table table-responsive">
                    <table class="table table-vcenter">
                      <thead>
                        <tr>
                          <th>ტიპი</th>
                          <th>აღწერა</th>
                          <th>თარიღი</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($stats['recent_activity'] as $activity): ?>
                        <tr>
                          <td class="w-1">
                            <?php
                            $iconColor = 'bg-primary';
                            $icon = '<circle cx="12" cy="12" r="1"/>';
                            
                            switch($activity['type']) {
                              case 'client':
                                $iconColor = 'bg-blue';
                                $icon = '<path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>';
                                break;
                              case 'invoice':
                                $iconColor = 'bg-green';
                                $icon = '<path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/><path d="M3 7l9 6l9 -6"/>';
                                break;
                              case 'transaction':
                                $iconColor = 'bg-warning';
                                $icon = '<path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"/><path d="M3 10l18 0"/><path d="M7 15l.01 0"/><path d="M11 15l2 0"/>';
                                break;
                            }
                            ?>
                            <span class="avatar avatar-sm <?= $iconColor ?> text-white">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <?= $icon ?>
                              </svg>
                            </span>
                          </td>
                          <td class="td-truncate">
                            <div class="text-truncate"><?= htmlspecialchars($activity['title']) ?></div>
                          </td>
                          <td class="text-nowrap text-secondary">
                            <?= date('d M Y', strtotime($activity['created_at'])) ?>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($stats['recent_activity'])): ?>
                        <tr>
                          <td colspan="3" class="text-center text-muted py-4">
                            ჯერ არ არის აქტივობა
                          </td>
                        </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card card-md sticky-top">
                  <div class="card-stamp card-stamp-lg">
                    <div class="card-stamp-icon bg-primary">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/ghost -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path
                          d="M5 11a7 7 0 0 1 14 0v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-7"
                        />
                        <path d="M10 10l.01 0" />
                        <path d="M14 10l.01 0" />
                        <path d="M10 14a3.5 3.5 0 0 0 4 0" />
                      </svg>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-10">
                        <h3 class="h1">STACK Open Source</h3>
                        <div class="markdown text-secondary">
                          უახლესი განახლებები იხილეთ ჩვენს GitHub გვერდზე: 
                          <a href="https://github.com/stackge" target="_blank" rel="noopener">https://github.com/stackge</a>
                        </div>
                        <div class="mt-3">
                          <a href="https://stack.ge" class="btn btn-primary" target="_blank" rel="noopener">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/download -->
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              class="icon icon-1"
                            >
                              <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                              <path d="M7 11l5 5l5 -5" />
                              <path d="M12 4l0 12" />
                            </svg>
                            STACK GITHUB
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">ინვოისები</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                      <div class="text-secondary">
                        მაჩვენე
                        <div class="mx-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="ინვოისების რაოდენობა" />
                        </div>
                        ჩანაწერი
                      </div>
                      <div class="ms-auto text-secondary">
                        ძებნა:
                        <div class="ms-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" aria-label="ინვოისის ძებნა" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="ყველა ინვოისის არჩევა" /></th>
                          <th class="w-1">
                            №
                            <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-up -->
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="24"
                              height="24"
                              viewBox="0 0 24 24"
                              fill="none"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              class="icon icon-sm icon-thick icon-2"
                            >
                              <path d="M6 15l6 -6l6 6" />
                            </svg>
                          </th>
                          <th>ინვოისის სათაური</th>
                          <th>მომხმარებელი</th>
                          <th>საიდ. №</th>
                          <th>შექმნილია</th>
                          <th>სტატუსი</th>
                          <th>თანხა</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                          // ინვოისების მიღება ბაზიდან
                          $stmt = $pdo->prepare("
                            SELECT 
                                i.id AS invoice_id,
                                i.invoice_number,
                                i.status,
                                i.total_amount,
                                i.created_at,
                                c.first_name,
                                c.last_name,
                                c.vat_number,
                                (
                                    SELECT description
                                    FROM invoice_items
                                    WHERE invoice_id = i.id
                                    LIMIT 1
                                ) AS invoice_subject
                            FROM invoices i
                            LEFT JOIN clients c ON i.client_id = c.id
                            ORDER BY i.created_at DESC
                            LIMIT 8
                        ");
                        $stmt->execute();
                        
                        $invoiceCount = 0;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $invoiceCount++;
                            $status = strtolower($row['status']);
                            
                            // სტატუსების ქართული თარგმანი
                            $statusGeorgian = match ($status) {
                                'paid' => 'გადახდილი',
                                'pending' => 'მოლოდინში',
                                'unpaid' => 'გადაუხდელი',
                                'draft' => 'ნაბოზარი',
                                'overdue' => 'ვადაგასული',
                                default => 'უცნობი'
                            };
                            
                            $badge_class = match ($status) {
                                'paid' => 'bg-success',
                                'pending' => 'bg-warning',
                                'unpaid', 'draft' => 'bg-secondary',
                                'overdue' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        
                            echo '<tr>';
                            echo '<td><input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox" /></td>';
                            echo '<td><span class="text-secondary">' . htmlspecialchars($row['invoice_number']) . '</span></td>';
                            echo '<td><a href="invoice.php?id=' . $row['invoice_id'] . '" class="text-reset" tabindex="-1">' . htmlspecialchars($row['invoice_subject'] ?? 'ღირსება მითითებული არ არის') . '</a></td>';
                            echo '<td>' . htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vat_number'] ?? '—') . '</td>';
                            echo '<td>' . date('d M Y', strtotime($row['created_at'])) . '</td>';
                            echo '<td><span class="badge ' . $badge_class . ' me-1"></span> ' . $statusGeorgian . '</td>';
                            echo '<td>' . number_format($row['total_amount'], 2) . ' ₾</td>';
                            echo '<td class="text-end">
                                    <span class="dropdown">
                                      <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">მოქმედებები</button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="' . App\Config::route('billing/invoices/view.php?id=' . $row['invoice_id']) . '">ნახვა</a>
                                        <a class="dropdown-item" href="' . App\Config::route('billing/invoices/edit.php?id=' . $row['invoice_id']) . '">რედაქტირება</a>
                                      </div>
                                    </span>
                                  </td>';
                            echo '</tr>';
                        }
                        
                        // სულ ინვოისების რაოდენობის გამოთვლა
                        $totalStmt = $pdo->prepare("SELECT COUNT(*) as total FROM invoices");
                        $totalStmt->execute();
                        $totalInvoices = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
                        
                        // თუ ინვოისები არ არის, ცარიელი რიგის ჩვენება
                        if ($invoiceCount == 0) {
                            echo '<tr>';
                            echo '<td colspan="9" class="text-center text-muted py-4">';
                            echo 'ინვოისები ვერ მოიძებნა';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>

                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-secondary">ნაჩვენებია <span>1</span>-დან <span><?= min(8, $totalInvoices) ?></span>-მდე, სულ <span><?= $totalInvoices ?></span> ჩანაწერი</p>
                    <?php if ($totalInvoices > 8): ?>
                    <ul class="pagination m-0 ms-auto">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-1"
                          >
                            <path d="M15 6l-6 6l6 6" />
                          </svg>
                          წინა
                        </a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <?php if ($totalInvoices > 8): ?>
                      <li class="page-item"><a class="page-link" href="dashboard.php?page=2">2</a></li>
                      <?php endif; ?>
                      <?php if ($totalInvoices > 16): ?>
                      <li class="page-item"><a class="page-link" href="dashboard.php?page=3">3</a></li>
                      <?php endif; ?>
                      <li class="page-item">
                        <a class="page-link" href="dashboard.php?page=2">
                          შემდეგი
                          <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-right -->
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-1"
                          >
                            <path d="M9 6l6 6l-6 6" />
                          </svg>
                        </a>
                      </li>
                    </ul>
                    <?php else: ?>
                    <div class="ms-auto"></div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END PAGE BODY -->
        <?php include_once Config::includePath('footer.php'); ?>
        </div>
        </div>
    <!-- BEGIN PAGE MODALS -->
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">ახალი რეპორტი</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="დახურვა"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">სახელი</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="თქვენი რეპორტის სახელი" />
            </div>
            <label class="form-label">რეპორტის ტიპი</label>
            <div class="form-selectgroup-boxes row mb-3">
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked />
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">მარტივი</span>
                      <span class="d-block text-secondary">რეპორტისთვის მხოლოდ ძირითადი მონაცემების მიწოდება</span>
                    </span>
                  </span>
                </label>
              </div>
              <div class="col-lg-6">
                <label class="form-selectgroup-item">
                  <input type="radio" name="report-type" value="1" class="form-selectgroup-input" />
                  <span class="form-selectgroup-label d-flex align-items-center p-3">
                    <span class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </span>
                    <span class="form-selectgroup-label-content">
                      <span class="form-selectgroup-title strong mb-1">გაფართოებული</span>
                      <span class="d-block text-secondary">დიაგრამებისა და დამატებითი გაფართოებული ანალიზის ჩართვა რეპორტში</span>
                    </span>
                  </span>
                </label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-8">
                <div class="mb-3">
                  <label class="form-label">Report url</label>
                  <div class="input-group input-group-flat">
                    <span class="input-group-text"> https://tabler.io/reports/ </span>
                    <input type="text" class="form-control ps-0" value="report-01" autocomplete="off" />
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Visibility</label>
                  <select class="form-select">
                    <option value="1" selected>Private</option>
                    <option value="2">Public</option>
                    <option value="3">Hidden</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">Client name</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mb-3">
                  <label class="form-label">რეპორტის პერიოდი</label>
                  <input type="date" class="form-control" />
                </div>
              </div>
              <div class="col-lg-12">
                <div>
                  <label class="form-label">დამატებითი ინფორმაცია</label>
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary btn-3" data-bs-dismiss="modal"> გაუქმება </a>
            <a href="#" class="btn btn-primary btn-5 ms-auto" data-bs-dismiss="modal">
              <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-2"
              >
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
              </svg>
              ახალი რეპორტის შექმნა
            </a>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("chart-revenue-bg"), {
            chart: {
              type: "area",
              fontFamily: "inherit",
              height: 40,
              sparkline: {
                enabled: true,
              },
              animations: {
                enabled: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            fill: {
              opacity: 0.16,
              type: "solid",
            },
            stroke: {
              width: 2,
              lineCap: "round",
              curve: "smooth",
            },
            series: [
              {
                name: "Profits",
                data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67],
              },
            ],
            tooltip: {
              theme: "dark",
            },
            grid: {
              strokeDashArray: 4,
            },
            xaxis: {
              labels: {
                padding: 0,
              },
              tooltip: {
                enabled: false,
              },
              axisBorder: {
                show: false,
              },
              type: "datetime",
            },
            yaxis: {
              labels: {
                padding: 4,
              },
            },
            labels: [
              "2020-06-20",
              "2020-06-21",
              "2020-06-22",
              "2020-06-23",
              "2020-06-24",
              "2020-06-25",
              "2020-06-26",
              "2020-06-27",
              "2020-06-28",
              "2020-06-29",
              "2020-06-30",
              "2020-07-01",
              "2020-07-02",
              "2020-07-03",
              "2020-07-04",
              "2020-07-05",
              "2020-07-06",
              "2020-07-07",
              "2020-07-08",
              "2020-07-09",
              "2020-07-10",
              "2020-07-11",
              "2020-07-12",
              "2020-07-13",
              "2020-07-14",
              "2020-07-15",
              "2020-07-16",
              "2020-07-17",
              "2020-07-18",
              "2020-07-19",
            ],
            colors: [tabler.getColor("primary")],
            legend: {
              show: false,
            },
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("chart-new-clients"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 40,
              sparkline: {
                enabled: true,
              },
              animations: {
                enabled: false,
              },
            },
            fill: {
              opacity: 1,
            },
            stroke: {
              width: [2, 1],
              dashArray: [0, 3],
              lineCap: "round",
              curve: "smooth",
            },
            series: [
              {
                name: "May",
                data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 4, 46, 39, 62, 51, 35, 41, 67],
              },
              {
                name: "April",
                data: [93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46, 62, 37, 44, 53, 41, 65, 39, 37],
              },
            ],
            tooltip: {
              theme: "dark",
            },
            grid: {
              strokeDashArray: 4,
            },
            xaxis: {
              labels: {
                padding: 0,
              },
              tooltip: {
                enabled: false,
              },
              type: "datetime",
            },
            yaxis: {
              labels: {
                padding: 4,
              },
            },
            labels: [
              "2020-06-20",
              "2020-06-21",
              "2020-06-22",
              "2020-06-23",
              "2020-06-24",
              "2020-06-25",
              "2020-06-26",
              "2020-06-27",
              "2020-06-28",
              "2020-06-29",
              "2020-06-30",
              "2020-07-01",
              "2020-07-02",
              "2020-07-03",
              "2020-07-04",
              "2020-07-05",
              "2020-07-06",
              "2020-07-07",
              "2020-07-08",
              "2020-07-09",
              "2020-07-10",
              "2020-07-11",
              "2020-07-12",
              "2020-07-13",
              "2020-07-14",
              "2020-07-15",
              "2020-07-16",
              "2020-07-17",
              "2020-07-18",
              "2020-07-19",
            ],
            colors: [tabler.getColor("primary"), tabler.getColor("gray-600")],
            legend: {
              show: false,
            },
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("chart-active-users"), {
            chart: {
              type: "bar",
              fontFamily: "inherit",
              height: 40,
              sparkline: {
                enabled: true,
              },
              animations: {
                enabled: false,
              },
            },
            plotOptions: {
              bar: {
                columnWidth: "50%",
              },
            },
            dataLabels: {
              enabled: false,
            },
            fill: {
              opacity: 1,
            },
            series: [
              {
                name: "Profits",
                data: [37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46, 39, 62, 51, 35, 41, 67],
              },
            ],
            tooltip: {
              theme: "dark",
            },
            grid: {
              strokeDashArray: 4,
            },
            xaxis: {
              labels: {
                padding: 0,
              },
              tooltip: {
                enabled: false,
              },
              axisBorder: {
                show: false,
              },
              type: "datetime",
            },
            yaxis: {
              labels: {
                padding: 4,
              },
            },
            labels: [
              "2020-06-20",
              "2020-06-21",
              "2020-06-22",
              "2020-06-23",
              "2020-06-24",
              "2020-06-25",
              "2020-06-26",
              "2020-06-27",
              "2020-06-28",
              "2020-06-29",
              "2020-06-30",
              "2020-07-01",
              "2020-07-02",
              "2020-07-03",
              "2020-07-04",
              "2020-07-05",
              "2020-07-06",
              "2020-07-07",
              "2020-07-08",
              "2020-07-09",
              "2020-07-10",
              "2020-07-11",
              "2020-07-12",
              "2020-07-13",
              "2020-07-14",
              "2020-07-15",
              "2020-07-16",
              "2020-07-17",
              "2020-07-18",
              "2020-07-19",
            ],
            colors: [tabler.getColor("primary")],
            legend: {
              show: false,
            },
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("chart-mentions"), {
            chart: {
              type: "bar",
              fontFamily: "inherit",
              height: 240,
              parentHeightOffset: 0,
              toolbar: {
                show: false,
              },
              animations: {
                enabled: false,
              },
              stacked: true,
            },
            plotOptions: {
              bar: {
                columnWidth: "50%",
              },
            },
            dataLabels: {
              enabled: false,
            },
            fill: {
              opacity: 1,
            },
            series: [
              {
                name: "Web",
                data: [1, 0, 0, 0, 0, 1, 1, 0, 0, 0, 2, 12, 5, 8, 22, 6, 8, 6, 4, 1, 8, 24, 29, 51, 40, 47, 23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 6],
              },
              {
                name: "Social",
                data: [2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6, 7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13, 15, 20, 47, 18, 15, 11, 10, 0],
              },
              {
                name: "Other",
                data: [2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3, 6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3, 2, 3, 4, 9, 7, 1, 6],
              },
            ],
            tooltip: {
              theme: "dark",
            },
            grid: {
              padding: {
                top: -20,
                right: 0,
                left: -4,
                bottom: -4,
              },
              strokeDashArray: 4,
              xaxis: {
                lines: {
                  show: true,
                },
              },
            },
            xaxis: {
              labels: {
                padding: 0,
              },
              tooltip: {
                enabled: false,
              },
              axisBorder: {
                show: false,
              },
              type: "datetime",
            },
            yaxis: {
              labels: {
                padding: 4,
              },
            },
            labels: [
              "2020-06-20",
              "2020-06-21",
              "2020-06-22",
              "2020-06-23",
              "2020-06-24",
              "2020-06-25",
              "2020-06-26",
              "2020-06-27",
              "2020-06-28",
              "2020-06-29",
              "2020-06-30",
              "2020-07-01",
              "2020-07-02",
              "2020-07-03",
              "2020-07-04",
              "2020-07-05",
              "2020-07-06",
              "2020-07-07",
              "2020-07-08",
              "2020-07-09",
              "2020-07-10",
              "2020-07-11",
              "2020-07-12",
              "2020-07-13",
              "2020-07-14",
              "2020-07-15",
              "2020-07-16",
              "2020-07-17",
              "2020-07-18",
              "2020-07-19",
              "2020-07-20",
              "2020-07-21",
              "2020-07-22",
              "2020-07-23",
              "2020-07-24",
              "2020-07-25",
              "2020-07-26",
            ],
            colors: [tabler.getColor("primary"), tabler.getColor("primary", 0.8), tabler.getColor("green", 0.8)],
            legend: {
              show: false,
            },
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const map = new jsVectorMap({
          selector: "#map-world",
          map: "world",
          backgroundColor: "transparent",
          regionStyle: {
            initial: {
              fill: tabler.getColor("body-bg"),
              stroke: tabler.getColor("border-color"),
              strokeWidth: 2,
            },
          },
          zoomOnScroll: false,
          zoomButtons: false,
          // -------- Series --------
          visualizeData: {
            scale: [tabler.getColor("bg-surface"), tabler.getColor("primary")],
            values: {
              AF: 16,
              AL: 11,
              DZ: 158,
              AO: 85,
              AG: 1,
              AR: 351,
              AM: 8,
              AU: 1219,
              AT: 366,
              AZ: 52,
              BS: 7,
              BH: 21,
              BD: 105,
              BB: 3,
              BY: 52,
              BE: 461,
              BZ: 1,
              BJ: 6,
              BT: 1,
              BO: 19,
              BA: 16,
              BW: 12,
              BR: 2023,
              BN: 11,
              BG: 44,
              BF: 8,
              BI: 1,
              KH: 11,
              CM: 21,
              CA: 1563,
              CV: 1,
              CF: 2,
              TD: 7,
              CL: 199,
              CN: 5745,
              CO: 283,
              KM: 0,
              CD: 12,
              CG: 11,
              CR: 35,
              CI: 22,
              HR: 59,
              CY: 22,
              CZ: 195,
              DK: 304,
              DJ: 1,
              DM: 0,
              DO: 50,
              EC: 61,
              EG: 216,
              SV: 21,
              GQ: 14,
              ER: 2,
              EE: 19,
              ET: 30,
              FJ: 3,
              FI: 231,
              FR: 2555,
              GA: 12,
              GM: 1,
              GE: 11,
              DE: 3305,
              GH: 18,
              GR: 305,
              GD: 0,
              GT: 40,
              GN: 4,
              GW: 0,
              GY: 2,
              HT: 6,
              HN: 15,
              HK: 226,
              HU: 132,
              IS: 12,
              IN: 1430,
              ID: 695,
              IR: 337,
              IQ: 84,
              IE: 204,
              IL: 201,
              IT: 2036,
              JM: 13,
              JP: 5390,
              JO: 27,
              KZ: 129,
              KE: 32,
              KI: 0,
              KR: 986,
              KW: 117,
              KG: 4,
              LA: 6,
              LV: 23,
              LB: 39,
              LS: 1,
              LR: 0,
              LY: 77,
              LT: 35,
              LU: 52,
              MK: 9,
              MG: 8,
              MW: 5,
              MY: 218,
              MV: 1,
              ML: 9,
              MT: 7,
              MR: 3,
              MU: 9,
              MX: 1004,
              MD: 5,
              MN: 5,
              ME: 3,
              MA: 91,
              MZ: 10,
              MM: 35,
              NA: 11,
              NP: 15,
              NL: 770,
              NZ: 138,
              NI: 6,
              NE: 5,
              NG: 206,
              NO: 413,
              OM: 53,
              PK: 174,
              PA: 27,
              PG: 8,
              PY: 17,
              PE: 153,
              PH: 189,
              PL: 438,
              PT: 223,
              QA: 126,
              RO: 158,
              RU: 1476,
              RW: 5,
              WS: 0,
              ST: 0,
              SA: 434,
              SN: 12,
              RS: 38,
              SC: 0,
              SL: 1,
              SG: 217,
              SK: 86,
              SI: 46,
              SB: 0,
              ZA: 354,
              ES: 1374,
              LK: 48,
              KN: 0,
              LC: 1,
              VC: 0,
              SD: 65,
              SR: 3,
              SZ: 3,
              SE: 444,
              CH: 522,
              SY: 59,
              TW: 426,
              TJ: 5,
              TZ: 22,
              TH: 312,
              TL: 0,
              TG: 3,
              TO: 0,
              TT: 21,
              TN: 43,
              TR: 729,
              TM: 0,
              UG: 17,
              UA: 136,
              AE: 239,
              GB: 2258,
              US: 4624,
              UY: 40,
              UZ: 37,
              VU: 0,
              VE: 285,
              VN: 101,
              YE: 30,
              ZM: 15,
              ZW: 5,
            },
          },
        });
        window.addEventListener("resize", () => {
          map.updateSize();
        });
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-activity"), {
            chart: {
              type: "radialBar",
              fontFamily: "inherit",
              height: 40,
              width: 40,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  margin: 0,
                  size: "75%",
                },
                track: {
                  margin: 0,
                },
                dataLabels: {
                  show: false,
                },
              },
            },
            colors: [tabler.getColor("blue")],
            series: [35],
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("chart-development-activity"), {
            chart: {
              type: "area",
              fontFamily: "inherit",
              height: 192,
              sparkline: {
                enabled: true,
              },
              animations: {
                enabled: false,
              },
            },
            dataLabels: {
              enabled: false,
            },
            fill: {
              opacity: 0.16,
              type: "solid",
            },
            stroke: {
              width: 2,
              lineCap: "round",
              curve: "smooth",
            },
            series: [
              {
                name: "Purchases",
                data: [3, 5, 4, 6, 7, 5, 6, 8, 24, 7, 12, 5, 6, 3, 8, 4, 14, 30, 17, 19, 15, 14, 25, 32, 40, 55, 60, 48, 52, 70],
              },
            ],
            tooltip: {
              theme: "dark",
            },
            grid: {
              strokeDashArray: 4,
            },
            xaxis: {
              labels: {
                padding: 0,
              },
              tooltip: {
                enabled: false,
              },
              axisBorder: {
                show: false,
              },
              type: "datetime",
            },
            yaxis: {
              labels: {
                padding: 4,
              },
            },
            labels: [
              "2020-06-20",
              "2020-06-21",
              "2020-06-22",
              "2020-06-23",
              "2020-06-24",
              "2020-06-25",
              "2020-06-26",
              "2020-06-27",
              "2020-06-28",
              "2020-06-29",
              "2020-06-30",
              "2020-07-01",
              "2020-07-02",
              "2020-07-03",
              "2020-07-04",
              "2020-07-05",
              "2020-07-06",
              "2020-07-07",
              "2020-07-08",
              "2020-07-09",
              "2020-07-10",
              "2020-07-11",
              "2020-07-12",
              "2020-07-13",
              "2020-07-14",
              "2020-07-15",
              "2020-07-16",
              "2020-07-17",
              "2020-07-18",
              "2020-07-19",
            ],
            colors: [tabler.getColor("primary")],
            legend: {
              show: false,
            },
            point: {
              show: false,
            },
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-bounce-rate-1"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 24,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            stroke: {
              width: 2,
              lineCap: "round",
            },
            series: [
              {
                color: tabler.getColor("primary"),
                data: [17, 24, 20, 10, 5, 1, 4, 18, 13],
              },
            ],
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-bounce-rate-2"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 24,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            stroke: {
              width: 2,
              lineCap: "round",
            },
            series: [
              {
                color: tabler.getColor("primary"),
                data: [13, 11, 19, 22, 12, 7, 14, 3, 21],
              },
            ],
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-bounce-rate-3"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 24,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            stroke: {
              width: 2,
              lineCap: "round",
            },
            series: [
              {
                color: tabler.getColor("primary"),
                data: [10, 13, 10, 4, 17, 3, 23, 22, 19],
              },
            ],
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-bounce-rate-4"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 24,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            stroke: {
              width: 2,
              lineCap: "round",
            },
            series: [
              {
                color: tabler.getColor("primary"),
                data: [6, 15, 13, 13, 5, 7, 17, 20, 19],
              },
            ],
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-bounce-rate-5"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 24,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            stroke: {
              width: 2,
              lineCap: "round",
            },
            series: [
              {
                color: tabler.getColor("primary"),
                data: [2, 11, 15, 14, 21, 20, 8, 23, 18, 14],
              },
            ],
          }).render();
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
          new ApexCharts(document.getElementById("sparkline-bounce-rate-6"), {
            chart: {
              type: "line",
              fontFamily: "inherit",
              height: 24,
              animations: {
                enabled: false,
              },
              sparkline: {
                enabled: true,
              },
            },
            tooltip: {
              enabled: false,
            },
            stroke: {
              width: 2,
              lineCap: "round",
            },
            series: [
              {
                color: tabler.getColor("primary"),
                data: [22, 12, 7, 14, 3, 21, 8, 23, 18, 14],
              },
            ],
          }).render();
      });
    </script>
    <!-- END PAGE SCRIPTS -->
  </body>
</html>
