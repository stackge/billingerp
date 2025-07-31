<?php
// მოდული, ქვე-მოდული და მოქმედება
$module = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['module'] ?? 'dashboard');
$submodule = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['submodule'] ?? '');
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['action'] ?? 'index');
$subaction = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['subaction'] ?? '');

// სპეციალური ლოგიკა განსაკუთრებული routes-ისთვის
if ($module === 'product' && $action === 'types') {
    $controller_file = __DIR__ . '/../modules/product/controllers/product_types.php';
} elseif ($module === 'users' && $action === 'management') {
    $controller_file = __DIR__ . '/../modules/users/controllers/users_management.php';
} else {
    // ფაილის ლოკაცია – controllers-ში
    $controller_file = __DIR__ . '/../modules/' . $module . '/controllers/';
    $controller_file .= $submodule ? $submodule . '/' : '';
    $controller_file .= $action . '.php';
}

// თუ controller არ არსებობს, აჩვენე 404
if (file_exists($controller_file)) {
    require_once $controller_file;
} else {
    echo "404 - ფაილი ვერ მოიძებნა: " . $controller_file;
}
