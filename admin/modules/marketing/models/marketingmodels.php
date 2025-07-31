<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../../libs/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../../libs/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../../libs/phpmailer/src/Exception.php';

class MarketingModel
{
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    /**
     * SMTP კონფიგურაციის მიღება ბაზიდან
     */
    private static function getSmtpConfig()
    {
        $stmt = self::$db->query("SELECT setting_key, setting_value FROM smtp_settings");
        $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        // Default ღირებულებები თუ ბაზაში არ არის
        return array_merge([
            'smtp_host' => 'localhost',
            'smtp_port' => '587',
            'smtp_secure' => 'tls',
            'smtp_auth' => '1',
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_from_email' => 'noreply@example.com',
            'smtp_from_name' => 'Website',
            'smtp_debug' => '0'
        ], $settings);
    }

    public static function sendBroadcast($clientIds, $subject, $message)
    {
        $stmt = self::$db->prepare(
            "SELECT id, email, first_name, last_name 
             FROM clients 
             WHERE id IN (" . implode(',', array_fill(0, count($clientIds), '?')) . ")"
        );
        $stmt->execute($clientIds);
        $clients = $stmt->fetchAll();

        // SMTP კონფიგურაციის მიღება ბაზიდან
        $smtpConfig = self::getSmtpConfig();

        foreach ($clients as $client) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = $smtpConfig['smtp_host'];
                $mail->SMTPAuth = (bool)$smtpConfig['smtp_auth'];
                $mail->Username = $smtpConfig['smtp_username'];
                $mail->Password = $smtpConfig['smtp_password'];
                $mail->SMTPSecure = $smtpConfig['smtp_secure'];
                $mail->Port = (int)$smtpConfig['smtp_port'];

                $mail->SMTPDebug = (int)$smtpConfig['smtp_debug'];
                $mail->Debugoutput = 'error_log';

                $mail->setFrom($smtpConfig['smtp_from_email'], $smtpConfig['smtp_from_name']);
                $mail->addAddress($client['email'], $client['first_name'] . ' ' . $client['last_name']);
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = nl2br(htmlspecialchars($message));

                if ($mail->send()) {
                    $log = self::$db->prepare(
                        "INSERT INTO email_logs (client_id, subject, message, sent_at) VALUES (?, ?, ?, NOW())"
                    );
                    $log->execute([$client['id'], $subject, $message]);
                } else {
                    error_log("გაგზავნის შეცდომა: " . $mail->ErrorInfo);
                }
            } catch (Exception $e) {
                error_log("PHPMailer გამონაკლისი: " . $mail->ErrorInfo);
            }
        }

        return true;
    }

    public static function getAllClients()
    {
        $stmt = self::$db->query("SELECT id, first_name, last_name, email FROM clients ORDER BY first_name");
        return $stmt->fetchAll();
    }

    public static function getEmailLogs()
    {
        $stmt = self::$db->query("SELECT email_logs.*, clients.first_name, clients.last_name FROM email_logs
                                JOIN clients ON email_logs.client_id = clients.id
                                ORDER BY sent_at DESC");
        return $stmt->fetchAll();
    }
}
