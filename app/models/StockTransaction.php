<?php
// app/models/StockTransaction.php
class StockTransaction
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

    public static function all($limit = 100)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('
            SELECT st.*, i.name as item_name, u.username as user_name
            FROM stock_transactions st
            LEFT JOIN items i ON st.item_id = i.id
            LEFT JOIN users u ON st.created_by = u.id
            ORDER BY st.created_at DESC
            LIMIT :limit
        ');
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getByItem(int $itemId, $limit = 50)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('
            SELECT st.*, i.name as item_name, u.username as user_name
            FROM stock_transactions st
            LEFT JOIN items i ON st.item_id = i.id
            LEFT JOIN users u ON st.created_by = u.id
            WHERE st.item_id = :item_id
            ORDER BY st.created_at DESC
            LIMIT :limit
        ');
        $stmt->bindValue(':item_id', $itemId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
