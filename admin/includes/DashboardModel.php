<?php

class DashboardModel
{
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    /**
     * კლიენტების სტატისტიკა
     */
    public static function getClientStats()
    {
        $stats = [];
        
        try {
            // სულ კლიენტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM clients");
            $stats['total'] = $stmt->fetchColumn();
            
            // აქტიური კლიენტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM clients WHERE status = 'active'");
            $stats['active'] = $stmt->fetchColumn();
            
            // ამ თვის ახალი კლიენტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM clients WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')");
            $stats['this_month'] = $stmt->fetchColumn();
            
            // გუშინდელი ახალი კლიენტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM clients WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY");
            $stats['yesterday'] = $stmt->fetchColumn();
        } catch (Exception $e) {
            // თუ clients ცხრილი არ არსებობს
            $stats = [
                'total' => 0,
                'active' => 0,
                'this_month' => 0,
                'yesterday' => 0
            ];
        }
        
        return $stats;
    }

    /**
     * პროდუქტების სტატისტიკა
     */
    public static function getProductStats()
    {
        $stats = [];
        
        try {
            // სულ პროდუქტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM products");
            $stats['total'] = $stmt->fetchColumn();
            
            // აქტიური პროდუქტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM products WHERE status = 'active'");
            $stats['active'] = $stmt->fetchColumn();
            
            // ამ თვის ახალი პროდუქტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM products WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')");
            $stats['this_month'] = $stmt->fetchColumn();
        } catch (Exception $e) {
            // თუ products ცხრილი არ არსებობს
            $stats['total'] = 0;
            $stats['active'] = 0;
            $stats['this_month'] = 0;
        }
        
        try {
            // პროდუქტის ტიპები
            $stmt = self::$db->query("SELECT COUNT(*) FROM product_types WHERE is_active = 1");
            $stats['types'] = $stmt->fetchColumn();
        } catch (Exception $e) {
            // თუ product_types ცხრილი არ არსებობს
            $stats['types'] = 0;
        }
        
        return $stats;
    }

    /**
     * ბილინგის სტატისტიკა
     */
    public static function getBillingStats()
    {
        $stats = [];
        
        try {
            // სულ ინვოისები
            $stmt = self::$db->query("SELECT COUNT(*) FROM invoices");
            $stats['total_invoices'] = $stmt->fetchColumn();
            
            // გადახდილი ინვოისები
            $stmt = self::$db->query("SELECT COUNT(*) FROM invoices WHERE status = 'paid'");
            $stats['paid_invoices'] = $stmt->fetchColumn();
            
            // გადაუხდელი ინვოისები
            $stmt = self::$db->query("SELECT COUNT(*) FROM invoices WHERE status = 'pending'");
            $stats['pending_invoices'] = $stmt->fetchColumn();
            
            // სულ ტრანზაქციები
            $stmt = self::$db->query("SELECT COUNT(*) FROM transactions");
            $stats['total_transactions'] = $stmt->fetchColumn();
            
            // ამ თვის შემოსავალი
            $stmt = self::$db->query("SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE status = 'completed' AND created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')");
            $stats['monthly_revenue'] = $stmt->fetchColumn();
            
            // სულ შემოსავალი
            $stmt = self::$db->query("SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE status = 'completed'");
            $stats['total_revenue'] = $stmt->fetchColumn();
        } catch (Exception $e) {
            // თუ billing ცხრილები არ არსებობს
            $stats = [
                'total_invoices' => 0,
                'paid_invoices' => 0,
                'pending_invoices' => 0,
                'total_transactions' => 0,
                'monthly_revenue' => 0,
                'total_revenue' => 0
            ];
        }
        
        return $stats;
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
     * მარკეტინგის სტატისტიკა
     */
    public static function getMarketingStats()
    {
        $stats = [];
        
        try {
            // სულ გაგზავნილი ელ.ფოსტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM email_logs");
            $stats['total_emails'] = $stmt->fetchColumn();
            
            // წარმატებით გაგზავნილი
            $stmt = self::$db->query("SELECT COUNT(*) FROM email_logs WHERE status = 'sent'");
            $stats['sent_emails'] = $stmt->fetchColumn();
            
            // ვერ გაგზავნილი
            $stmt = self::$db->query("SELECT COUNT(*) FROM email_logs WHERE status = 'failed'");
            $stats['failed_emails'] = $stmt->fetchColumn();
            
            // ამ თვის ელ.ფოსტები
            $stmt = self::$db->query("SELECT COUNT(*) FROM email_logs WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')");
            $stats['this_month'] = $stmt->fetchColumn();
        } catch (Exception $e) {
            // თუ email_logs ცხრილი არ არსებობს
            $stats = [
                'total_emails' => 0,
                'sent_emails' => 0,
                'failed_emails' => 0,
                'this_month' => 0
            ];
        }
        
        return $stats;
    }

    /**
     * ბოლო აქტივობა
     */
    public static function getRecentActivity()
    {
        $activities = [];
        
        try {
            // ბოლო კლიენტები
            $stmt = self::$db->query("
                SELECT 'client' as type, CONCAT(first_name, ' ', last_name) as title, created_at 
                FROM clients 
                ORDER BY created_at DESC 
                LIMIT 3
            ");
            $activities = array_merge($activities, $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            // clients ცხრილი არ არსებობს
        }
        
        try {
            // ბოლო ინვოისები
            $stmt = self::$db->query("
                SELECT 'invoice' as type, CONCAT('ინვოისი #', id) as title, created_at 
                FROM invoices 
                ORDER BY created_at DESC 
                LIMIT 3
            ");
            $activities = array_merge($activities, $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            // invoices ცხრილი არ არსებობს
        }
        
        try {
            // ბოლო ტრანზაქციები
            $stmt = self::$db->query("
                SELECT 'transaction' as type, CONCAT('ტრანზაქცია ', amount, ' ლარი') as title, created_at 
                FROM transactions 
                ORDER BY created_at DESC 
                LIMIT 3
            ");
            $activities = array_merge($activities, $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            // transactions ცხრილი არ არსებობს
        }
        
        try {
            // ბოლო მომხმარებლები
            $stmt = self::$db->query("
                SELECT 'user' as type, CONCAT(first_name, ' ', last_name, ' - მომხმარებელი') as title, created_at 
                FROM users 
                ORDER BY created_at DESC 
                LIMIT 3
            ");
            $activities = array_merge($activities, $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            // users ცხრილი არ არსებობს
        }
        
        // დალაგება თარიღის მიხედვით
        if (!empty($activities)) {
            usort($activities, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
        }
        
        return array_slice($activities, 0, 10);
    }

    /**
     * სისტემის ზოგადი სტატისტიკა
     */
    public static function getSystemStats()
    {
        return [
            'clients' => self::getClientStats(),
            'products' => self::getProductStats(),
            'billing' => self::getBillingStats(),
            'users' => self::getUserStats(),
            'marketing' => self::getMarketingStats(),
            'server' => self::getServerStats(),
            'recent_activity' => self::getRecentActivity()
        ];
    }

    /**
     * სერვერის სტატისტიკა
     */
    public static function getServerStats()
    {
        $stats = [];
        
        // სერვერის ინფორმაცია
        $stats['php_version'] = PHP_VERSION;
        
        try {
            $stats['mysql_version'] = self::$db->query("SELECT VERSION()")->fetchColumn();
        } catch (Exception $e) {
            $stats['mysql_version'] = 'N/A';
        }
        
        // მეხსიერება
        $stats['memory_usage'] = round(memory_get_usage(true) / 1024 / 1024, 2); // MB
        $stats['memory_limit'] = ini_get('memory_limit');
        
        // დისკის ადგილი
        $stats['disk_free'] = disk_free_space('.') ? round(disk_free_space('.') / 1024 / 1024 / 1024, 2) : 0; // GB
        $stats['disk_total'] = disk_total_space('.') ? round(disk_total_space('.') / 1024 / 1024 / 1024, 2) : 0; // GB
        
        // პროცესორი (load average) - Linux სისტემისთვის
        if (is_readable('/proc/loadavg')) {
            $load = file_get_contents('/proc/loadavg');
            $load_avg = explode(' ', $load);
            $stats['cpu_load'] = round(floatval($load_avg[0]), 2);
        } else {
            $stats['cpu_load'] = 0;
        }
        
        // უფრო ინფორმატიული სტატისტიკა
        $stats['max_execution_time'] = ini_get('max_execution_time');
        $stats['upload_max_filesize'] = ini_get('upload_max_filesize');
        
        return $stats;
    }
}
?>
