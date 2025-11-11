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
            LEFT JOIN users u ON r.created_by = u.id
            ORDER BY r.receipt_date DESC
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
            LEFT JOIN users u ON r.created_by = u.id
            WHERE r.id = :id LIMIT 1
        ');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $header, array $lineItems, int $createdBy = 1)
    {
        $pdo = self::pdo();
        
        // Insert header
        $stmt = $pdo->prepare('
            INSERT INTO receipts (supplier_id, receipt_date, notes, created_by)
            VALUES (:supplier_id, :receipt_date, :notes, :created_by)
        ');
        $stmt->execute([
            'supplier_id' => $header['supplier_id'],
            'receipt_date' => $header['receipt_date'] ?? date('Y-m-d'),
            'notes' => $header['notes'] ?? '',
            'created_by' => $createdBy,
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
                INSERT INTO stock_transactions (item_id, type, change, reference_id, user_id, note)
                VALUES (:item_id, :type, :change, :reference_id, :user_id, :note)
            ');
            $transStmt->execute([
                'item_id' => $line['item_id'],
                'type' => 'receiving',
                'change' => $line['quantity'],
                'reference_id' => $receiptId,
                'user_id' => $createdBy,
                'note' => 'Penerimaan dari receipt #' . $receiptId,
            ]);
        }

        return $receiptId;
    }
}
