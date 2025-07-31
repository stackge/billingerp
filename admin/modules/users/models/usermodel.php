<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class UserModel
{
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    /**
     * ყველა მომხმარებლის მიღება
     */
    public static function getAllUsers()
    {
        $stmt = self::$db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * კონკრეტული მომხმარებლის მიღება ID-ით
     */
    public static function getUserById($id)
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * მომხმარებლის მიღება ელ.ფოსტით
     */
    public static function getUserByEmail($email)
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ახალი მომხმარებლის დამატება
     */
    public static function createUser($data)
    {
        // ვამოწმებთ არსებობს თუ არა ასეთი ელ.ფოსტა
        if (self::getUserByEmail($data['email'])) {
            throw new Exception("მომხმარებელი ამ ელ.ფოსტით უკვე არსებობს");
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = self::$db->prepare("
            INSERT INTO users (first_name, last_name, email, password, role, is_active) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['first_name'],
            $data['last_name'], 
            $data['email'],
            $hashedPassword,
            $data['role'] ?? 'user',
            $data['is_active'] ?? 1
        ]);
    }

    /**
     * მომხმარებლის განახლება
     */
    public static function updateUser($id, $data)
    {
        // ვამოწმებთ ელ.ფოსტის უნიკალურობას (თუ შეიცვალა)
        $currentUser = self::getUserById($id);
        if (!$currentUser) {
            throw new Exception("მომხმარებელი ვერ მოიძებნა");
        }

        if ($currentUser['email'] !== $data['email']) {
            $existingUser = self::getUserByEmail($data['email']);
            if ($existingUser && $existingUser['id'] != $id) {
                throw new Exception("მომხმარებელი ამ ელ.ფოსტით უკვე არსებობს");
            }
        }

        $updateFields = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'role' => $data['role'] ?? 'user',
            'is_active' => $data['is_active'] ?? 1
        ];

        // თუ ახალი პაროლი არის მითითებული
        if (!empty($data['password'])) {
            $updateFields['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, role = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
            $params = array_values($updateFields);
            $params[] = $id;
        } else {
            unset($updateFields['password']);
            $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
            $params = array_values($updateFields);
            $params[] = $id;
        }

        $stmt = self::$db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * მომხმარებლის წაშლა
     */
    public static function deleteUser($id)
    {
        // ვამოწმებთ არ არის თუ არა ეს უკანასკნელი ადმინი
        $admins = self::getAdminUsers();
        $userToDelete = self::getUserById($id);
        
        if ($userToDelete['role'] === 'admin' && count($admins) <= 1) {
            throw new Exception("ვერ შეიძლება უკანასკნელი ადმინისტრატორის წაშლა");
        }

        $stmt = self::$db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * მომხმარებლის სტატუსის ცვლილება
     */
    public static function toggleUserStatus($id)
    {
        $user = self::getUserById($id);
        if (!$user) {
            throw new Exception("მომხმარებელი ვერ მოიძებნა");
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        
        // ვამოწმებთ ადმინების რაოდენობას
        if ($user['role'] === 'admin' && $user['is_active'] && $newStatus === 0) {
            $activeAdmins = self::getActiveAdminUsers();
            if (count($activeAdmins) <= 1) {
                throw new Exception("ვერ შეიძლება უკანასკნელი აქტიური ადმინისტრატორის გამორთვა");
            }
        }

        $stmt = self::$db->prepare("UPDATE users SET is_active = ? WHERE id = ?");
        return $stmt->execute([$newStatus, $id]);
    }

    /**
     * პაროლის შეცვლა
     */
    public static function changePassword($id, $currentPassword, $newPassword)
    {
        $user = self::getUserById($id);
        if (!$user) {
            throw new Exception("მომხმარებელი ვერ მოიძებნა");
        }

        if (!password_verify($currentPassword, $user['password'])) {
            throw new Exception("მიმდინარე პაროლი არასწორია");
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = self::$db->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }

    /**
     * ადმინისტრატორების მიღება
     */
    public static function getAdminUsers()
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE role = 'admin'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * აქტიური ადმინისტრატორების მიღება
     */
    public static function getActiveAdminUsers()
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE role = 'admin' AND is_active = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * მომხმარებლების სტატისტიკა
     */
    public static function getUserStats()
    {
        $stats = [];
        
        // სულ მომხმარებლები
        $stmt = self::$db->query("SELECT COUNT(*) FROM users");
        $stats['total'] = $stmt->fetchColumn();
        
        // აქტიური მომხმარებლები
        $stmt = self::$db->query("SELECT COUNT(*) FROM users WHERE is_active = 1");
        $stats['active'] = $stmt->fetchColumn();
        
        // ადმინისტრატორები
        $stmt = self::$db->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
        $stats['admins'] = $stmt->fetchColumn();
        
        // ამ თვის ახალი მომხმარებლები
        $stmt = self::$db->query("SELECT COUNT(*) FROM users WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')");
        $stats['this_month'] = $stmt->fetchColumn();
        
        return $stats;
    }

    /**
     * ხელმისაწვდომი როლები
     */
    public static function getAvailableRoles()
    {
        return [
            'admin' => 'ადმინისტრატორი',
            'manager' => 'მენეჯერი', 
            'user' => 'მომხმარებელი',
            'guest' => 'სტუმარი'
        ];
    }

    /**
     * მომხმარებლის search და filter
     */
    public static function searchUsers($search = '', $role = '', $status = '')
    {
        $sql = "SELECT * FROM users WHERE 1=1";
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($role)) {
            $sql .= " AND role = ?";
            $params[] = $role;
        }

        if ($status !== '') {
            $sql .= " AND is_active = ?";
            $params[] = (int)$status;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
