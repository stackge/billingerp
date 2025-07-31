<?php
require_once __DIR__ . '/../../../includes/init.php'; // ბაზასთან კავშირი
require_once __DIR__ . '/../models/client.php';            // Client მოდელის ჩასმა

Client::setDb($pdo); // აქ ვუკავშირებთ PDO ობიექტს მოდელს

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ყველა მონაცემის შეგროვება ერთი მასივში
    $data = [
        'first_name'       => trim($_POST['first_name'] ?? ''),
        'last_name'        => trim($_POST['last_name'] ?? ''),
        'company_name'     => trim($_POST['company'] ?? null),
        'vat_number'       => trim($_POST['vat_number'] ?? null),
        'email'            => trim($_POST['email'] ?? ''),
        'password'         => password_hash($_POST['password'], PASSWORD_BCRYPT),
        'address1'         => trim($_POST['address1'] ?? null),
        'address2'         => trim($_POST['address2'] ?? null),
        'city'             => trim($_POST['city'] ?? null),
        'state'            => trim($_POST['state'] ?? null),
        'postcode'         => trim($_POST['postcode'] ?? null),
        'country'          => trim($_POST['country'] ?? null),
        'phone'            => trim($_POST['phone'] ?? null),
        'payment_method'   => trim($_POST['payment_method'] ?? null),
        'billing_contact'  => trim($_POST['billing_contact'] ?? null),
        'currency'         => trim($_POST['currency'] ?? 'USD'),
        'language'         => trim($_POST['language'] ?? 'default'),
        'status'           => trim($_POST['status'] ?? 'active'),
        'client_group'     => trim($_POST['client_group'] ?? 'none'),
        'admin_notes'      => trim($_POST['admin_notes'] ?? null),
    ];

    // მონაცემის დამატება მოდელიდან
    Client::create($data);

    header("Location: dashboard.php?module=clients&action=list");
    exit;
}
// view-ის ჩატვირთვა
require_once __DIR__ . '/../views/clients_add.php';