<?php
class TransactionsModel
{
    private static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    public static function getClients()
    {
        $stmt = self::$db->query("SELECT id, first_name, last_name FROM clients ORDER BY first_name ASC");
        return $stmt->fetchAll();
    }

    public static function getInvoices()
    {
        $stmt = self::$db->query("SELECT id, invoice_number FROM invoices ORDER BY invoice_number ASC");
        return $stmt->fetchAll();
    }

    public static function handleTransactionFormSubmission()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $invoice_id = $_POST['invoice_id'] ?? '';
            $client_id = $_POST['client_id'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $method = $_POST['method'] ?? '';
            $status = $_POST['status'] ?? '';
            $notes = $_POST['notes'] ?? '';

            if (!$invoice_id || !$client_id || !$amount || !$method || !$status) {
                $errors[] = "გთხოვ შეავსო ყველა სავალდებულო ველი.";
            }

            if (empty($errors)) {
                $stmt = self::$db->prepare("INSERT INTO transactions (invoice_id, client_id, amount, method, status, notes) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$invoice_id, $client_id, $amount, $method, $status, $notes]);

                header("Location: dashboard.php?module=billing&submodule=transactions&action=list&added=1");
                exit;
            }
        }

        return $errors;
    }

    public static function getTransactionById($id)
    {
        if (!$id || !is_numeric($id)) {
            return null;
        }

        $stmt = self::$db->prepare("
            SELECT t.*, c.first_name, c.last_name, i.invoice_number
            FROM transactions t
            JOIN clients c ON c.id = t.client_id
            JOIN invoices i ON i.id = t.invoice_id
            WHERE t.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function updateTransaction($id, $data)
    {
        $stmt = self::$db->prepare("
            UPDATE transactions
            SET status = ?, method = ?, notes = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['status'],
            trim($data['method']),
            trim($data['notes']),
            $id
        ]);
    }

    public static function getClientInfo($clientId)
    {
        if (!$clientId || !is_numeric($clientId)) {
            return null;
        }

        $stmt = self::$db->prepare("SELECT first_name, last_name FROM clients WHERE id = ?");
        $stmt->execute([$clientId]);
        return $stmt->fetch();
    }

    public static function getClientTransactions($clientId)
    {
        if (!$clientId || !is_numeric($clientId)) {
            return [];
        }

        $stmt = self::$db->prepare("
            SELECT t.*, i.invoice_number
            FROM transactions t
            JOIN invoices i ON i.id = t.invoice_id
            WHERE t.client_id = ?
            ORDER BY t.created_at DESC
        ");
        $stmt->execute([$clientId]);
        return $stmt->fetchAll();
    }
    
    public static function getAllTransactions()
    {
        $stmt = self::$db->query("
            SELECT t.*, c.first_name, c.last_name, i.invoice_number
            FROM transactions t
            JOIN clients c ON t.client_id = c.id
            JOIN invoices i ON t.invoice_id = i.id
            ORDER BY t.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public static function deleteTransaction($id)
    {
        $stmt = self::$db->prepare("DELETE FROM transactions WHERE id = ?");
        return $stmt->execute([$id]);
    }
    

}
