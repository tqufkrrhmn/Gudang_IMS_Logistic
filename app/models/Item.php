<?php
// Simple Item model using PDO (expects a constant BASE_PATH to be defined)
class Item
{
    protected static function pdo()
    {
        // Expect public/index.php to define BASE_PATH
        $dbFile = BASE_PATH . '/config/database.php';
        if (!file_exists($dbFile)) {
            throw new RuntimeException('Database config not found: ' . $dbFile);
        }
        return require $dbFile;
    }

    public static function all()
    {
        $pdo = self::pdo();
        $stmt = $pdo->query('SELECT * FROM items ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('SELECT * FROM items WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function insert(array $data)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('INSERT INTO items (name, sku, quantity, location, supplier) VALUES (:name, :sku, :quantity, :location, :supplier)');
        $stmt->execute([
            'name' => $data['name'] ?? null,
            'sku' => $data['sku'] ?? null,
            'quantity' => $data['quantity'] ?? 0,
            'location' => $data['location'] ?? null,
            'supplier' => $data['supplier'] ?? null,
        ]);
        return $pdo->lastInsertId();
    }

    public static function update(int $id, array $data)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('UPDATE items SET name = :name, sku = :sku, quantity = :quantity, location = :location, supplier = :supplier WHERE id = :id');
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'] ?? null,
            'sku' => $data['sku'] ?? null,
            'quantity' => $data['quantity'] ?? 0,
            'location' => $data['location'] ?? null,
            'supplier' => $data['supplier'] ?? null,
        ]);
    }

    public static function delete(int $id)
    {
        $pdo = self::pdo();
        $stmt = $pdo->prepare('DELETE FROM items WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
