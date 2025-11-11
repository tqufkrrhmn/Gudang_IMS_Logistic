<?php
class Role
{
    /**
     * Get all roles
     */
    public static function all()
    {
        $db = require BASE_PATH . '/config/database.php';
        $stmt = $db->query('SELECT * FROM roles ORDER BY id ASC');
        return $stmt->fetchAll();
    }

    /**
     * Find role by ID
     */
    public static function find($id)
    {
        $db = require BASE_PATH . '/config/database.php';
        $stmt = $db->prepare('SELECT * FROM roles WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Find role by name
     */
    public static function findByName($name)
    {
        $db = require BASE_PATH . '/config/database.php';
        $stmt = $db->prepare('SELECT * FROM roles WHERE name = ?');
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    /**
     * Create new role
     */
    public static function create($data)
    {
        $db = require BASE_PATH . '/config/database.php';
        
        $stmt = $db->prepare('INSERT INTO roles (name, description) VALUES (?, ?)');
        $stmt->execute([
            $data['name'],
            $data['description'] ?? null
        ]);

        return $db->lastInsertId();
    }

    /**
     * Update role
     */
    public static function update($id, $data)
    {
        $db = require BASE_PATH . '/config/database.php';
        
        $updates = [];
        $values = [];

        if (isset($data['name'])) {
            $updates[] = 'name = ?';
            $values[] = $data['name'];
        }

        if (isset($data['description'])) {
            $updates[] = 'description = ?';
            $values[] = $data['description'];
        }

        if (empty($updates)) {
            return;
        }

        $values[] = $id;
        $query = 'UPDATE roles SET ' . implode(', ', $updates) . ' WHERE id = ?';
        
        $stmt = $db->prepare($query);
        $stmt->execute($values);
    }

    /**
     * Delete role
     */
    public static function delete($id)
    {
        $db = require BASE_PATH . '/config/database.php';
        
        $stmt = $db->prepare('DELETE FROM roles WHERE id = ?');
        $stmt->execute([$id]);
    }
}
