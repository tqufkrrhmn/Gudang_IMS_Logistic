<?php
require_once BASE_PATH . '/app/models/Receipt.php';

class ReceivingController
{
    public function index()
    {
        $receipts = Receipt::all();
        require BASE_PATH . '/app/views/receipts/receipt_list.php';
    }

    public function create()
    {
        $suppliers = \Supplier::all();
        $items = \Item::all();
        $receipt = null;
        $isEdit = false;
        require BASE_PATH . '/app/views/receipts/receipt_form.php';
    }

    public function store()
    {
        $supplier_id = $_POST['supplier_id'] ?? null;
        $receipt_date = $_POST['receipt_date'] ?? date('Y-m-d');
        $notes = $_POST['notes'] ?? '';
        $line_items = $_POST['line_items'] ?? [];

        $errors = [];

        if (empty($supplier_id)) {
            $errors[] = 'Pemasok harus dipilih.';
        }

        if (empty($line_items)) {
            $errors[] = 'Minimal satu item harus ditambahkan.';
        }

        if (!empty($errors)) {
            $suppliers = \Supplier::all();
            $items = \Item::all();
            $receipt = null;
            $isEdit = false;
            require BASE_PATH . '/app/views/receipts/receipt_form.php';
            return;
        }

        $header = [
            'supplier_id' => $supplier_id,
            'receipt_date' => $receipt_date,
            'notes' => $notes,
            'created_by' => $_SESSION['user']['id'] ?? 1,
        ];

        Receipt::create($header, $line_items, $_SESSION['user']['id'] ?? 1);

        header('Location: index.php?route=receiving/index');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=receiving/index');
            exit;
        }

        $receipt = Receipt::find($id);
        if (!$receipt) {
            header('Location: index.php?route=receiving/index');
            exit;
        }

        $suppliers = \Supplier::all();
        $items = \Item::all();
        $isEdit = true;
        require BASE_PATH . '/app/views/receipts/receipt_form.php';
    }
}
