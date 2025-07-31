<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProductTypesModel
{
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    /**
     * ყველა აქტიური product type-ის მიღება
     */
    public static function getActiveTypes()
    {
        $stmt = self::$db->query("SELECT * FROM product_types WHERE is_active = 1 ORDER BY sort_order, name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ყველა product type-ის მიღება (ადმინისთვის)
     */
    public static function getAllTypes()
    {
        $stmt = self::$db->query("SELECT * FROM product_types ORDER BY sort_order, name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * კონკრეტული product type-ის მიღება
     */
    public static function getTypeById($id)
    {
        $stmt = self::$db->prepare("SELECT * FROM product_types WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ახალი product type-ის დამატება
     */
    public static function addType($data)
    {
        $stmt = self::$db->prepare("
            INSERT INTO product_types (name, description, icon, sort_order, is_active) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? '',
            $data['icon'] ?? 'box',
            $data['sort_order'] ?? 0,
            $data['is_active'] ?? 1
        ]);
    }

    /**
     * Product type-ის განახლება
     */
    public static function updateType($id, $data)
    {
        $stmt = self::$db->prepare("
            UPDATE product_types 
            SET name = ?, description = ?, icon = ?, sort_order = ?, is_active = ?, updated_at = NOW()
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? '',
            $data['icon'] ?? 'box',
            $data['sort_order'] ?? 0,
            $data['is_active'] ?? 1,
            $id
        ]);
    }

    /**
     * Product type-ის წაშლა
     */
    public static function deleteType($id)
    {
        // ვამოწმებთ არ არის თუ არა გამოყენებული პროდუქტებში
        $stmt = self::$db->prepare("SELECT COUNT(*) FROM products WHERE type = (SELECT name FROM product_types WHERE id = ?)");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            throw new Exception("ამ ტიპის პროდუქტები უკვე არსებობს. წაშლა შეუძლებელია.");
        }
        
        $stmt = self::$db->prepare("DELETE FROM product_types WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Sort order-ის განახლება
     */
    public static function updateSortOrder($orders)
    {
        try {
            self::$db->beginTransaction();
            
            $stmt = self::$db->prepare("UPDATE product_types SET sort_order = ? WHERE id = ?");
            
            foreach ($orders as $id => $order) {
                $stmt->execute([$order, $id]);
            }
            
            self::$db->commit();
            return true;
        } catch (Exception $e) {
            self::$db->rollback();
            throw $e;
        }
    }

    /**
     * ხელმისაწვდომი აიკონების სია
     */
    public static function getAvailableIcons()
    {
        return [
            'server' => 'სერვერი',
            'server-2' => 'VPS/Dedicated',
            'users' => 'მომხმარებლები',
            'world' => 'დომენი',
            'shield-check' => 'უსაფრთხოება',
            'mail' => 'ელ.ფოსტა',
            'cloud' => 'ღრუბელი',
            'database' => 'ბაზა',
            'box' => 'პაკეტი',
            'gift' => 'საჩუქარი',
            'star' => 'პრემიუმი',
            'lightning' => 'სწრაფი',
            'globe' => 'გლობალური',
            'lock' => 'დაცული',
            'dots' => 'სხვა'
        ];
    }
}
?>
