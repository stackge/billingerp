<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../includes/init.php';
require_once __DIR__ . '/../models/usermodel.php';

UserModel::setDb($pdo);

$message = '';
$messageType = '';
$action = $_GET['subaction'] ?? 'list';

// POST მოთხოვნების მართვა
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postAction = $_POST['action'] ?? '';
    
    switch ($postAction) {
        case 'add':
            $data = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'] ?? 'user',
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            // ვალიდაცია
            $errors = [];
            if (empty($data['first_name'])) $errors[] = 'სახელი სავალდებულოა';
            if (empty($data['last_name'])) $errors[] = 'გვარი სავალდებულოა';
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'ვალიდური ელ.ფოსტა სავალდებულოა';
            }
            if (empty($data['password']) || strlen($data['password']) < 6) {
                $errors[] = 'პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო';
            }
            
            if (!empty($errors)) {
                $message = implode('<br>', $errors);
                $messageType = 'danger';
            } else {
                try {
                    UserModel::createUser($data);
                    $message = 'მომხმარებელი წარმატებით დაემატა';
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
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'] ?? 'user',
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            // ვალიდაცია
            $errors = [];
            if (empty($data['first_name'])) $errors[] = 'სახელი სავალდებულოა';
            if (empty($data['last_name'])) $errors[] = 'გვარი სავალდებულოა';
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'ვალიდური ელ.ფოსტა სავალდებულოა';
            }
            if (!empty($data['password']) && strlen($data['password']) < 6) {
                $errors[] = 'პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო';
            }
            
            if (!empty($errors)) {
                $message = implode('<br>', $errors);
                $messageType = 'danger';
            } else {
                try {
                    UserModel::updateUser($id, $data);
                    $message = 'მომხმარებელი წარმატებით განახლდა';
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
                    UserModel::deleteUser($id);
                    $message = 'მომხმარებელი წარმატებით წაიშალა';
                    $messageType = 'success';
                } catch (Exception $e) {
                    $message = 'შეცდომა: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            $action = 'list';
            break;
            
        case 'toggle_status':
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                try {
                    UserModel::toggleUserStatus($id);
                    $message = 'მომხმარებლის სტატუსი შეიცვალა';
                    $messageType = 'success';
                } catch (Exception $e) {
                    $message = 'შეცდომა: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            $action = 'list';
            break;
            
        case 'change_password':
            $id = (int)($_POST['id'] ?? 0);
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            if (empty($currentPassword)) $errors[] = 'მიმდინარე პაროლი სავალდებულოა';
            if (empty($newPassword) || strlen($newPassword) < 6) {
                $errors[] = 'ახალი პაროლი უნდა იყოს მინიმუმ 6 სიმბოლო';
            }
            if ($newPassword !== $confirmPassword) $errors[] = 'პაროლები არ ემთხვევა';
            
            if (!empty($errors)) {
                $message = implode('<br>', $errors);
                $messageType = 'danger';
            } else {
                try {
                    UserModel::changePassword($id, $currentPassword, $newPassword);
                    $message = 'პაროლი წარმატებით შეიცვალა';
                    $messageType = 'success';
                } catch (Exception $e) {
                    $message = 'შეცდომა: ' . $e->getMessage();
                    $messageType = 'danger';
                }
            }
            break;
    }
}

// მონაცემების მომზადება view-სთვის
switch ($action) {
    case 'add':
    case 'edit':
        $availableRoles = UserModel::getAvailableRoles();
        if ($action === 'edit') {
            $editId = (int)($_GET['id'] ?? 0);
            $editUser = UserModel::getUserById($editId);
            if (!$editUser) {
                $message = 'მომხმარებელი ვერ მოიძებნა';
                $messageType = 'danger';
                $action = 'list';
            }
        }
        break;
        
    case 'profile':
        $profileId = (int)($_GET['id'] ?? $_SESSION['user_id'] ?? 0);
        $profileUser = UserModel::getUserById($profileId);
        if (!$profileUser) {
            $message = 'მომხმარებელი ვერ მოიძებნა';
            $messageType = 'danger';
            $action = 'list';
        }
        break;
        
    case 'list':
    default:
        // Search და Filter პარამეტრები
        $search = $_GET['search'] ?? '';
        $role = $_GET['role'] ?? '';
        $status = $_GET['status'] ?? '';
        
        if ($search || $role || $status !== '') {
            $users = UserModel::searchUsers($search, $role, $status);
        } else {
            $users = UserModel::getAllUsers();
        }
        
        $userStats = UserModel::getUserStats();
        $availableRoles = UserModel::getAvailableRoles();
        break;
}

require_once __DIR__ . '/../views/users_management.php';
?>
