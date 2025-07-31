<?php

class InvoicesModel
{
    protected static $db;

    public static function setDb($pdo)
    {
        self::$db = $pdo;
    }

        // ყველა ინვოისის წამოღება
        public static function getAllInvoicesWithClientNames()
        {
            $stmt = self::$db->query("
                SELECT i.*, CONCAT(c.first_name, ' ', c.last_name) AS client_name
                FROM invoices i
                JOIN clients c ON i.client_id = c.id
                ORDER BY i.id DESC
            ");
            return $stmt->fetchAll();
        } 

    // ყველა ინვოისის წამოღება
    public static function getAllInvoices()
    {
        $stmt = self::$db->query("SELECT i.*, c.first_name, c.last_name FROM invoices i JOIN clients c ON i.client_id = c.id ORDER BY i.id DESC");
        return $stmt->fetchAll();
    }

    // ერთი ინვოისის წამოღება დეტალურად
    public static function getInvoiceById($id)
    {
        $stmt = self::$db->prepare("SELECT * FROM invoices WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ინვოისის დამატება
    public static function createInvoice($data)
    {
        $stmt = self::$db->prepare("INSERT INTO invoices (invoice_number, client_id, description, payment_method, status, total_amount, is_recurring, issue_date, due_date, payment_date, recurring) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $data['invoice_number'],
            $data['client_id'],
            $data['description'],
            $data['payment_method'],
            $data['status'],
            $data['total_amount'],
            $data['is_recurring'],
            $data['issue_date'],
            $data['due_date'],
            $data['payment_date'],
            $data['recurring']
        ]);

        return self::$db->lastInsertId();
    }

    // ინვოისის განახლება
    public static function updateInvoice($id, $data)
    {
        $stmt = self::$db->prepare("UPDATE invoices SET 
            client_id = ?, invoice_number = ?, description = ?, status = ?, 
            total_amount = ?, payment_method = ?, issue_date = ?, due_date = ?, recurring = ?
            WHERE id = ?");
            
        return $stmt->execute([
            $data['client_id'],
            $data['invoice_number'],
            $data['description'],
            $data['status'],
            $data['total_amount'],
            $data['payment_method'],
            $data['issue_date'],
            $data['due_date'],
            isset($data['recurring']) ? 1 : 0,
            $id
        ]);
    }

    // ინვოისის წაშლა
    public static function deleteInvoice($id)
    {
        $stmt = self::$db->prepare("DELETE FROM invoices WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ინვოისთან დაკავშირებული ნივთების წამოღება
    public static function getInvoiceItems2($invoice_id)
    {
        $stmt = self::$db->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
        $stmt->execute([$invoice_id]);
        return $stmt->fetchAll();
    }

    // ინვოისის ნივთების დამატება
    public static function addInvoiceItem($invoice_id, $item)
    {
        $stmt = self::$db->prepare("INSERT INTO invoice_items (invoice_id, product_id, description, amount) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $invoice_id,
            $item['product_id'],
            $item['description'],
            $item['amount']
        ]);
    }

    // ინვოისის ნივთების წაშლა
    public static function deleteInvoiceItems($invoice_id)
    {
        $stmt = self::$db->prepare("DELETE FROM invoice_items WHERE invoice_id = ?");
        return $stmt->execute([$invoice_id]);
    }

    public static function getInvoiceWithClient($id)
    {
        $stmt = self::$db->prepare("
            SELECT i.*, c.first_name, c.last_name, c.email
            FROM invoices i
            JOIN clients c ON c.id = i.client_id
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getInvoiceItems($invoiceId)
    {
        $stmt = self::$db->prepare("
            SELECT ii.*, p.name
            FROM invoice_items ii
            JOIN products p ON p.id = ii.product_id
            WHERE ii.invoice_id = ?
        ");
        $stmt->execute([$invoiceId]);
        return $stmt->fetchAll();
    }

    public static function generateNextInvoiceNumber(): string
    {
        $currentYear = date('Y');
        $prefix = 'INV-' . $currentYear . '-';
    
        $stmt = self::$db->prepare("SELECT invoice_number FROM invoices WHERE invoice_number LIKE ? ORDER BY invoice_number DESC LIMIT 1");
        $stmt->execute([$prefix . '%']);
        $lastInvoice = $stmt->fetchColumn();
    
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice, strrpos($lastInvoice, '-') + 1);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }
    
        return $prefix . $newNumber;
    }

    public static function getClientsList(): array
    {
        $stmt = self::$db->query("SELECT id, first_name, last_name FROM clients ORDER BY first_name");
        return $stmt->fetchAll();
    }

    public static function getProductList(): array
    {
        $stmt = self::$db->query("SELECT id, name, price FROM products ORDER BY name");
        return $stmt->fetchAll();
    }

    public static function createInvoiceWithItems($data)
    {
        $stmt = self::$db->prepare("INSERT INTO invoices 
            (client_id, invoice_number, description, total_amount, payment_method, status, issue_date, due_date, recurring)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $data['client_id'],
            $data['invoice_number'],
            $data['description'],
            $data['total_amount'],
            $data['payment_method'],
            $data['status'],
            $data['issue_date'],
            $data['due_date'],
            $data['recurring']
        ]);

        $invoice_id = self::$db->lastInsertId();

        $stmtItem = self::$db->prepare("INSERT INTO invoice_items (invoice_id, product_id, amount, description) VALUES (?, ?, ?, ?)");

        for ($i = 0; $i < count($data['products']); $i++) {
            $stmtItem->execute([
                $invoice_id,
                $data['products'][$i],
                $data['amounts'][$i],
                $data['descriptions'][$i]
            ]);
        }

        return $invoice_id;
    }

    public static function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $prefix = 'INV-' . $year . '-';

        $stmt = self::$db->prepare("SELECT invoice_number FROM invoices WHERE invoice_number LIKE ? ORDER BY invoice_number DESC LIMIT 1");
        $stmt->execute([$prefix . '%']);
        $last = $stmt->fetchColumn();

        $lastNumber = $last ? (int) substr($last, strrpos($last, '-') + 1) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $newNumber;
    }


    public static function isValidStatus(string $status): bool
    {
        $allowed = ['დრაფტი', 'გადაუხდელი', 'გადასახდელი', 'გადახდილი', 'გაუქმებული'];
        return in_array($status, $allowed);
    }


    public static function isDuplicateInvoiceNumber(string $invoice_number): bool
    {
        $stmt = self::$db->prepare("SELECT COUNT(*) FROM invoices WHERE invoice_number = ?");
        $stmt->execute([$invoice_number]);
        return $stmt->fetchColumn() > 0;
    }

    public static function getInvoicesDueTomorrow()
    {
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $stmt = self::$db->prepare("
            SELECT invoices.*, clients.first_name, clients.last_name, clients.email 
            FROM invoices
            JOIN clients ON invoices.client_id = clients.id
            WHERE invoices.due_date = ? AND invoices.status IN ('გადაუხდელი', 'გადასახდელი')
        ");
        $stmt->execute([$tomorrow]);
        return $stmt->fetchAll();
    }

    public static function getInvoiceWithItems($id)
    {
        $stmt = self::$db->prepare("
            SELECT invoices.*, clients.email, clients.first_name, clients.last_name
            FROM invoices
            JOIN clients ON invoices.client_id = clients.id
            WHERE invoices.id = ?
        ");
        $stmt->execute([$id]);
        $invoice = $stmt->fetch();

        if (!$invoice) {
            return null;
        }

        $stmtItems = self::$db->prepare("
            SELECT products.name, ii.description, ii.amount
            FROM invoice_items ii
            JOIN products ON products.id = ii.product_id
            WHERE ii.invoice_id = ?
        ");
        $stmtItems->execute([$id]);
        $invoice['items'] = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return $invoice;
    }


    public static function generateInvoicePDF($invoice)
    {
        $html = self::renderInvoiceHTML($invoice);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfPath = '/tmp/invoice_' . $invoice['id'] . '.pdf';
        file_put_contents($pdfPath, $dompdf->output());

        return $pdfPath;
    }

    public static function renderInvoiceHTML($invoice)
    {
        ob_start();
        include __DIR__ . '/../views/invoices/pdf_template.php'; // თუ გინდა გამოყავი ცალკე template ფაილად
        return ob_get_clean();
    }

    // მოაქვს პდფ ფაილში კლიენტის ბაზიდან დამატებითი მონაცემები
    public static function getInvoiceWithClientById($id)
    {
        $stmt = self::$db->prepare("
            SELECT 
                invoices.*, 
                clients.company_name, 
                clients.vat_number, 
                clients.address1,
                clients.first_name AS client_first_name,
                clients.last_name AS client_last_name
            FROM invoices
            LEFT JOIN clients ON invoices.client_id = clients.id
            WHERE invoices.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    

}
