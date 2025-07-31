<?php
require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/client.php';

Client::setDb($pdo);
$clients = Client::all(); // მოდელიდან იღებ ყველა კლიენტს

include __DIR__ . '/../views/clients_list.php'; // აჩვენე View
