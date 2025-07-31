<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class SMTPModel
{
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    /**
     * ყველა SMTP setting-ის მიღება
     */
    public static function getAllSettings()
    {
        $stmt = self::$db->query("SELECT * FROM smtp_settings ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * კონკრეტული setting-ის მიღება
     */
    public static function getSetting($key)
    {
        $stmt = self::$db->prepare("SELECT setting_value FROM smtp_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['setting_value'] : null;
    }

    /**
     * Setting-ის განახლება
     */
    public static function updateSetting($key, $value)
    {
        $stmt = self::$db->prepare("UPDATE smtp_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
        return $stmt->execute([$value, $key]);
    }

    /**
     * ყველა setting-ის განახლება ერთდროულად
     */
    public static function updateMultipleSettings($settings)
    {
        try {
            self::$db->beginTransaction();
            
            $stmt = self::$db->prepare("UPDATE smtp_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
            
            foreach ($settings as $key => $value) {
                $stmt->execute([$value, $key]);
            }
            
            self::$db->commit();
            return true;
        } catch (Exception $e) {
            self::$db->rollback();
            throw $e;
        }
    }

    /**
     * SMTP კონფიგურაციის ასოციაციური მასივის მიღება
     */
    public static function getSmtpConfig()
    {
        $settings = self::getAllSettings();
        $config = [];
        
        foreach ($settings as $setting) {
            $config[$setting['setting_key']] = $setting['setting_value'];
        }
        
        return $config;
    }

    /**
     * SMTP კავშირის ტესტი
     */
    public static function testSmtpConnection($testEmail = null)
    {
        require_once __DIR__ . '/../../../libs/phpmailer/src/PHPMailer.php';
        require_once __DIR__ . '/../../../libs/phpmailer/src/SMTP.php';
        require_once __DIR__ . '/../../../libs/phpmailer/src/Exception.php';

        $config = self::getSmtpConfig();
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $config['smtp_host'] ?? 'localhost';
            $mail->SMTPAuth = (bool)($config['smtp_auth'] ?? false);
            $mail->Username = $config['smtp_username'] ?? '';
            $mail->Password = $config['smtp_password'] ?? '';
            $mail->SMTPSecure = $config['smtp_secure'] ?? 'tls';
            $mail->Port = (int)($config['smtp_port'] ?? 587);
            $mail->SMTPDebug = 0; // No debug output for test

            $mail->setFrom(
                $config['smtp_from_email'] ?? 'test@example.com',
                $config['smtp_from_name'] ?? 'Test'
            );

            if ($testEmail) {
                $mail->addAddress($testEmail);
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Subject = 'SMTP კონფიგურაციის ტესტი';
                $mail->Body = 'ეს არის SMTP კონფიგურაციის ტესტური შეტყობინება. თუ ეს წერილი მიიღეთ, SMTP სეტინგები სწორია.';

                $result = $mail->send();
                return [
                    'success' => true,
                    'message' => 'ტესტური ელ.წერილი წარმატებით გაიგზავნა ' . $testEmail . ' მისამართზე'
                ];
            } else {
                // მხოლოდ კავშირის ტესტი ელ.წერილის გაგზავნის გარეშე
                $mail->smtpConnect();
                $mail->smtpClose();
                
                return [
                    'success' => true,
                    'message' => 'SMTP კავშირი წარმატებით დამყარდა'
                ];
            }

        } catch (\PHPMailer\PHPMailer\Exception $e) {
            return [
                'success' => false,
                'message' => 'SMTP შეცდომა: ' . $e->getMessage()
            ];
        }
    }
}
?>
