<?php
// app/models/Shipment.php
class Shipment
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
            SELECT s.*, u.username as created_by_name
            FROM shipments s
            LEFT JOIN users u ON s.created_by = u.id
            ORDER BY s.shipment_date DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('
            SELECT s.*, u.username as created_by_name
            FROM shipments s
            LEFT JOIN users u ON s.created_by = u.id
            WHERE s.id = :id LIMIT 1
        ');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function create(array $header, array $lineItems, int $createdBy = 1)
    {
        $pdo = self::pdo();
        
        // Insert header
        $stmt = $pdo->prepare('
            INSERT INTO shipments (destination, shipment_date, notes, created_by)
            VALUES (:destination, :shipment_date, :notes, :created_by)
        ');
        $stmt->execute([
            'destination' => $header['destination'],
            'shipment_date' => $header['shipment_date'] ?? date('Y-m-d'),
            'notes' => $header['notes'] ?? '',
            'created_by' => $createdBy,
        ]);
        
        $shipmentId = $pdo->lastInsertId();

        // Insert line items
        foreach ($lineItems as $line) {
            $lineStmt = $pdo->prepare('
                INSERT INTO shipment_lines (shipment_id, item_id, quantity, unit_price)
                VALUES (:shipment_id, :item_id, :quantity, :unit_price)
            ');
            $lineStmt->execute([
                'shipment_id' => $shipmentId,
                'item_id' => $line['item_id'],
                'quantity' => $line['quantity'],
                'unit_price' => $line['unit_price'] ?? 0,
            ]);

            // Update item quantity (decrease)
            $updateStmt = $pdo->prepare('
                UPDATE items SET quantity = quantity - :qty WHERE id = :id
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
                'type' => 'shipping',
                'change' => -$line['quantity'],
                'reference_id' => $shipmentId,
                'user_id' => $createdBy,
                'note' => 'Pengiriman dari shipment #' . $shipmentId,
            ]);
        }

        return $shipmentId;
    }
}
