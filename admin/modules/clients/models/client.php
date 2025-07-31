<?php

class Client
{
    // ➤ ბაზასთან კავშირის ცვლადი (გლობალური ან Dependency Injection)
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

    // ➤ კლიენტის დამატება
    public static function create($data)
    {
        $sql = "INSERT INTO clients (
            first_name, last_name, company_name, vat_number, email, password,
            address1, address2, city, state, postcode, country, phone,
            payment_method, billing_contact, currency, language, status,
            client_group, admin_notes
        ) VALUES (
            :first_name, :last_name, :company_name, :vat_number, :email, :password,
            :address1, :address2, :city, :state, :postcode, :country, :phone,
            :payment_method, :billing_contact, :currency, :language, :status,
            :client_group, :admin_notes
        )";

        $stmt = self::$db->prepare($sql);

        $stmt->execute([
            ':first_name'       => $data['first_name'],
            ':last_name'        => $data['last_name'],
            ':company_name'     => $data['company_name'] ?? null,
            ':vat_number'       => $data['vat_number'] ?? null,
            ':email'            => $data['email'],
            ':password'         => $data['password'],
            ':address1'         => $data['address1'] ?? null,
            ':address2'         => $data['address2'] ?? null,
            ':city'             => $data['city'] ?? null,
            ':state'            => $data['state'] ?? null,
            ':postcode'         => $data['postcode'] ?? null,
            ':country'          => $data['country'] ?? null,
            ':phone'            => $data['phone'] ?? null,
            ':payment_method'   => $data['payment_method'] ?? null,
            ':billing_contact'  => $data['billing_contact'] ?? null,
            ':currency'         => $data['currency'] ?? 'USD',
            ':language'         => $data['language'] ?? 'default',
            ':status'           => $data['status'] ?? 'active',
            ':client_group'     => $data['client_group'] ?? 'none',
            ':admin_notes'      => $data['admin_notes'] ?? null
        ]);
    }

    // ➤ ყველა კლიენტის წამოღება
    public static function all()
    {
        $stmt = self::$db->query("SELECT * FROM clients ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ➤ ერთი კლიენტის წამოღება ID-ით
    public static function find($id)
    {
        $stmt = self::$db->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ➤ კლიენტის განახლება
    public static function update($id, $data)
    {
        $sql = "UPDATE clients SET
            first_name = :first_name,
            last_name = :last_name,
            company_name = :company_name,
            vat_number = :vat_number,
            email = :email,
            address1 = :address1,
            address2 = :address2,
            city = :city,
            state = :state,
            postcode = :postcode,
            country = :country,
            phone = :phone,
            payment_method = :payment_method,
            billing_contact = :billing_contact,
            currency = :currency,
            language = :language,
            status = :status,
            client_group = :client_group,
            admin_notes = :admin_notes
        WHERE id = :id";
    
        $stmt = self::$db->prepare($sql);
    
        // აუცილებელია ყველა პარამეტრი იყოს განსაზღვრული
        $params = [
            ':first_name'       => $data['first_name'] ?? '',
            ':last_name'        => $data['last_name'] ?? '',
            ':company_name'     => $data['company_name'] ?? null,
            ':vat_number'       => $data['vat_number'] ?? null,
            ':email'            => $data['email'] ?? '',
            ':address1'         => $data['address1'] ?? null,
            ':address2'         => $data['address2'] ?? null,
            ':city'             => $data['city'] ?? null,
            ':state'            => $data['state'] ?? null,
            ':postcode'         => $data['postcode'] ?? null,
            ':country'          => $data['country'] ?? null,
            ':phone'            => $data['phone'] ?? null,
            ':payment_method'   => $data['payment_method'] ?? null,
            ':billing_contact'  => $data['billing_contact'] ?? null,
            ':currency'         => $data['currency'] ?? 'USD',
            ':language'         => $data['language'] ?? 'default',
            ':status'           => $data['status'] ?? 'active',
            ':client_group'     => $data['client_group'] ?? 'none',
            ':admin_notes'      => $data['admin_notes'] ?? null,
            ':id'               => $id
        ];
    
        $stmt->execute($params);
    }
    

    // ➤ კლიენტის წაშლა
    public static function delete($id)
    {
        $stmt = self::$db->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$id]);
    }
}
