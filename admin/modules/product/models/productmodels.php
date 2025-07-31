<?php

class ProductModel
{
    private static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    /**
     * პროდუქტის ტიპების მიღება (dynamic)
     */
    public static function getProductTypes()
    {
        $stmt = self::$db->query("SELECT name, description, icon FROM product_types WHERE is_active = 1 ORDER BY sort_order, name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteProductById($id)
    {
        if (!$id || !is_numeric($id)) {
            return false;
        }

        $stmt = self::$db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function getProductById($id)
    {
        if (!$id || !is_numeric($id)) {
            return null;
        }

        $stmt = self::$db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getAllProducts()
    {
        $stmt = self::$db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public static function createProduct($data)
    {
        $stmt = self::$db->prepare("INSERT INTO products (name, `group`, type, url, module, hidden) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['group'],
            $data['type'],
            $data['url'],
            $data['module'],
            $data['hidden']
        ]);
    }

    public static function updateProduct($id, $data)
    {
        $stmt = self::$db->prepare("
            UPDATE products 
            SET name = ?, `group` = ?, type = ?, url = ?, module = ?, hidden = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['group'],
            $data['type'],
            $data['url'],
            $data['module'],
            $data['hidden'],
            $id
        ]);
    }


}
