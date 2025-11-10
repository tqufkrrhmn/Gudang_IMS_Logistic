<?php
class ItemController
{
    public function index()
    {
        // optional filter by location (from GET)
        $selectedLocation = isset($_GET['location']) ? trim($_GET['location']) : '';
        $filters = [];
        if ($selectedLocation !== '') {
            $filters['location'] = $selectedLocation;
        }
        // fetch items with optional filters
        $items = Item::all($filters);

        // try to get list of known locations for filter dropdown
        $locations = [];
        if (class_exists('Location')) {
            $locations = Location::all();
        }
        require BASE_PATH . '/app/views/items/item_list.php';
    }

    public function create()
    {
        $item = null; // empty form
        $action = 'store';
        $locations = [];
        if (class_exists('Location')) {
            $locations = Location::all();
        }
        require BASE_PATH . '/app/views/items/item_form.php';
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'] ?? null,
            'sku' => $_POST['sku'] ?? null,
            'quantity' => isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0,
            'location' => $_POST['location'] ?? null,
            'supplier' => $_POST['supplier'] ?? null,
        ];

        Item::insert($data);
        header('Location: index.php?route=items/index');
        exit;
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $item = Item::find($id);
        if (!$item) {
            echo "Item not found";
            return;
        }
        $action = 'update&id=' . $id;
        $locations = [];
        if (class_exists('Location')) {
            $locations = Location::all();
        }
        require BASE_PATH . '/app/views/items/item_form.php';
    }

    public function update()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $data = [
            'name' => $_POST['name'] ?? null,
            'sku' => $_POST['sku'] ?? null,
            'quantity' => isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0,
            'location' => $_POST['location'] ?? null,
            'supplier' => $_POST['supplier'] ?? null,
        ];
        Item::update($id, $data);
        header('Location: index.php?route=items/index');
        exit;
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        Item::delete($id);
        header('Location: index.php?route=items/index');
        exit;
    }
}
