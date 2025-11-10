<?php
// app/models/Location.php
class Location
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

    public static function all(): array
    {
        $pdo = self::pdo();
        $stmt = $pdo->query('SELECT * FROM locations ORDER BY code ASC');
        return $stmt->fetchAll();
    }

    // expose PDO if controller needs direct queries (kept as helper)
    public static function getPdo(): PDO
    {
        return self::pdo();
    }
}
