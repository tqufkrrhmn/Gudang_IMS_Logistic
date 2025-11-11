<?php
// app/models/Receipt.php
class Receipt
{
    protected static function pdo()
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }
        $dbFile = BASE_PATH . '/config/database.php';
        if (!file_exists($dbFile)) {
            throw new RuntimeException('Database config not found: ' . $dbFile);
        }
        $pdo = require $dbFile;
        if (!($pdo instanceof PDO)) {
            throw new RuntimeException('Database config did not return a PDO instance.');
        }
        return $pdo;
    }

    public static function all()
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('
            SELECT r.*, s.name as supplier_name, u.username as created_by_name
            FROM receipts r
            LEFT JOIN suppliers s ON r.supplier_id = s.id
            LEFT JOIN users u ON r.received_by = u.id
            ORDER BY r.received_at DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('
            SELECT r.*, s.name as supplier_name, u.username as created_by_name
            FROM receipts r
            LEFT JOIN suppliers s ON r.supplier_id = s.id
            LEFT JOIN users u ON r.received_by = u.id
            WHERE r.id = :id LIMIT 1
        ');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $header, array $lineItems, int $createdBy = 1)
    {
        $pdo = self::pdo();
        
        // Generate receipt number
        $receiptNo = 'RCP-' . date('YmdHis');
        
        // Insert header
        $stmt = $pdo->prepare('
            INSERT INTO receipts (receipt_no, supplier_id, received_by, notes)
            VALUES (:receipt_no, :supplier_id, :received_by, :notes)
        ');
        $stmt->execute([
            'receipt_no' => $receiptNo,
            'supplier_id' => $header['supplier_id'],
            'received_by' => $createdBy,
            'notes' => $header['notes'] ?? '',
        ]);
        
        $receiptId = $pdo->lastInsertId();

        // Insert line items
        foreach ($lineItems as $line) {
            $lineStmt = $pdo->prepare('
                INSERT INTO receipt_lines (receipt_id, item_id, quantity, unit_price)
                VALUES (:receipt_id, :item_id, :quantity, :unit_price)
            ');
            $lineStmt->execute([
                'receipt_id' => $receiptId,
                'item_id' => $line['item_id'],
                'quantity' => $line['quantity'],
                'unit_price' => $line['unit_price'] ?? 0,
            ]);

            // Update item quantity
            $updateStmt = $pdo->prepare('
                UPDATE items SET quantity = quantity + :qty WHERE id = :id
            ');
            $updateStmt->execute([
                'qty' => $line['quantity'],
                'id' => $line['item_id'],
            ]);

            // Log stock transaction
            $transStmt = $pdo->prepare('
                INSERT INTO stock_transactions (item_id, type, change, reference_id, created_by, note)
                VALUES (:item_id, :type, :change, :reference_id, :created_by, :note)
            ');
            $transStmt->execute([
                'item_id' => $line['item_id'],
                'type' => 'RECEIPT',
                'change' => $line['quantity'],
                'reference_id' => $receiptId,
                'created_by' => $createdBy,
                'note' => 'Penerimaan dari receipt #' . $receiptNo,
            ]);
        }

        return $receiptId;
    }
}
