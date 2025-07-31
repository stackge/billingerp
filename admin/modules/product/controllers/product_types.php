<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/producttypesmodel.php';

ProductTypesModel::setDb($pdo);

$message = '';
$messageType = '';
$action = $_GET['subaction'] ?? 'list';

// POST მოთხოვნების მართვა
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';
    
    switch ($postAction) {
        case 'add':
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'icon' => $_POST['icon'] ?? 'box',
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            if (empty($data['name'])) {
                $message = 'პროდუქტის ტიპის სახელი სავალდებულოა';
                $messageType = 'danger';
            } else {
                try {
                    ProductTypesModel::addType($data);
                    $message = 'პროდუქტის ტიპი წარმატებით დაემატა';
                    $messageType = 'success';
                    $action = 'list';
                } catch (Exception $e) {
                    $message = 'შეცდომა: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            break;
            
        case 'edit':
            $id = (int)($_POST['id'] ?? 0);
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'icon' => $_POST['icon'] ?? 'box',
                'sort_order' => (int)($_POST['sort_order'] ?? 0),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            if (empty($data['name']) || $id <= 0) {
                $message = 'არასწორი მონაცემები';
                $messageType = 'danger';
            } else {
                try {
                    ProductTypesModel::updateType($id, $data);
                    $message = 'პროდუქტის ტიპი წარმატებით განახლდა';
                    $messageType = 'success';
                    $action = 'list';
                } catch (Exception $e) {
                    $message = 'შეცდომა: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            break;
            
        case 'delete':
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                try {
                    ProductTypesModel::deleteType($id);
                    $message = 'პროდუქტის ტიპი წარმატებით წაიშალა';
                    $messageType = 'success';
                } catch (Exception $e) {
                    $message = 'შეცდომა: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            $action = 'list';
            break;
            
        case 'update_order':
            $orders = $_POST['orders'] ?? [];
            try {
                ProductTypesModel::updateSortOrder($orders);
                $message = 'რიგითობა წარმატებით განახლდა';
                $messageType = 'success';
            } catch (Exception $e) {
                $message = 'შეცდომა: ' . $e->getMessage();
                $messageType = 'danger';
            }
            $action = 'list';
            break;
    }
}

// მონაცემების მომზადება view-სთვის
switch ($action) {
    case 'add':
    case 'edit':
        $availableIcons = ProductTypesModel::getAvailableIcons();
        if ($action === 'edit') {
            $editId = (int)($_GET['id'] ?? 0);
            $editType = ProductTypesModel::getTypeById($editId);
            if (!$editType) {
                $message = 'პროდუქტის ტიპი ვერ მოიძებნა';
                $messageType = 'danger';
                $action = 'list';
            }
        }
        break;
        
    case 'list':
    default:
        $productTypes = ProductTypesModel::getAllTypes();
        break;
}

require_once __DIR__ . '/../views/product_types.php';
?>
