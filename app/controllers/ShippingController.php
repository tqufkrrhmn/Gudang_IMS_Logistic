<?php
require_once BASE_PATH . '/app/models/Shipment.php';

class ShippingController
{
    public function index()
    {
        $shipments = Shipment::all();
        require BASE_PATH . '/app/views/shipments/shipment_list.php';
    }

    public function create()
    {
        $items = \Item::all();
        $shipment = null;
        $isEdit = false;
        require BASE_PATH . '/app/views/shipments/shipment_form.php';
    }

    public function store()
    {
        $destination = $_POST['destination'] ?? '';
        $shipment_date = $_POST['shipment_date'] ?? date('Y-m-d');
        $notes = $_POST['notes'] ?? '';
        $line_items = $_POST['line_items'] ?? [];

        $errors = [];

        if (empty($destination)) {
            $errors[] = 'Tujuan pengiriman harus diisi.';
        }

        if (empty($line_items)) {
            $errors[] = 'Minimal satu item harus ditambahkan.';
        }

        if (!empty($errors)) {
            $items = \Item::all();
            $shipment = null;
            $isEdit = false;
            require BASE_PATH . '/app/views/shipments/shipment_form.php';
            return;
        }

        $header = [
            'destination' => $destination,
            'shipment_date' => $shipment_date,
            'notes' => $notes,
            'created_by' => $_SESSION['user']['id'] ?? 1,
        ];

        Shipment::create($header, $line_items, $_SESSION['user']['id'] ?? 1);

        header('Location: index.php?route=shipping/index');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=shipping/index');
            exit;
        }

        $shipment = Shipment::find($id);
        if (!$shipment) {
            header('Location: index.php?route=shipping/index');
            exit;
        }

        $items = \Item::all();
        $isEdit = true;
        require BASE_PATH . '/app/views/shipments/shipment_form.php';
    }
}
