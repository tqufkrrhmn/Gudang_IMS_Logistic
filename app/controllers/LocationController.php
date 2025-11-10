<?php
class LocationController
{
    public function index()
    {
        $locations = Location::all();
        require BASE_PATH . '/app/views/locations/location_list.php';
    }

    public function create()
    {
        $loc = null;
        $action = 'store';
        require BASE_PATH . '/app/views/locations/location_form.php';
    }

    public function store()
    {
        $data = [
            'code' => $_POST['code'] ?? null,
            'description' => $_POST['description'] ?? null,
        ];
        $pdo = Location::getPdo();
        $stmt = $pdo->prepare('INSERT INTO locations (code, description) VALUES (:code, :description)');
        $stmt->execute($data);
        header('Location: index.php?route=locations/index'); exit;
    }

    public function edit()
    {
        $id = isset($_GET['id'])?(int)$_GET['id']:0;
        $pdo = Location::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM locations WHERE id = :id');
        $stmt->execute(['id'=>$id]);
        $loc = $stmt->fetch();
        $action = 'update&id=' . $id;
        require BASE_PATH . '/app/views/locations/location_form.php';
    }

    public function update()
    {
        $id = isset($_GET['id'])?(int)$_GET['id']:0;
        $data = ['code'=>$_POST['code']??null,'description'=>$_POST['description']??null,'id'=>$id];
        $pdo = Location::getPdo();
        $stmt = $pdo->prepare('UPDATE locations SET code=:code, description=:description WHERE id=:id');
        $stmt->execute($data);
        header('Location: index.php?route=locations/index'); exit;
    }

    public function delete()
    {
        $id = isset($_GET['id'])?(int)$_GET['id']:0;
        $pdo = Location::getPdo();
        $stmt = $pdo->prepare('DELETE FROM locations WHERE id=:id');
        $stmt->execute(['id'=>$id]);
        header('Location: index.php?route=locations/index'); exit;
    }
}
