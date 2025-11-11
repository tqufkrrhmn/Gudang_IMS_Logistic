<?php
require_once BASE_PATH . '/app/models/Supplier.php';

class SupplierController
{
    public function index()
    {
        $suppliers = Supplier::all();
        require BASE_PATH . '/app/views/suppliers/supplier_list.php';
    }

    public function create()
    {
        $supplier = null;
        $isEdit = false;
        require BASE_PATH . '/app/views/suppliers/supplier_form.php';
    }

    public function store()
    {
        $name = $_POST['name'] ?? '';
        $contact_person = $_POST['contact_person'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Nama pemasok harus diisi.';
        }

        if (!empty($errors)) {
            $supplier = null;
            $isEdit = false;
            require BASE_PATH . '/app/views/suppliers/supplier_form.php';
            return;
        }

        $data = [
            'name' => $name,
            'contact_person' => $contact_person,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
        ];

        Supplier::insert($data);
        header('Location: index.php?route=suppliers/index');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=suppliers/index');
            exit;
        }

        $supplier = Supplier::find($id);
        if (!$supplier) {
            header('Location: index.php?route=suppliers/index');
            exit;
        }

        $isEdit = true;
        require BASE_PATH . '/app/views/suppliers/supplier_form.php';
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=suppliers/index');
            exit;
        }

        $supplier = Supplier::find($id);
        if (!$supplier) {
            header('Location: index.php?route=suppliers/index');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $contact_person = $_POST['contact_person'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Nama pemasok harus diisi.';
        }

        if (!empty($errors)) {
            $isEdit = true;
            require BASE_PATH . '/app/views/suppliers/supplier_form.php';
            return;
        }

        $data = [
            'name' => $name,
            'contact_person' => $contact_person,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
        ];

        Supplier::update($id, $data);
        header('Location: index.php?route=suppliers/index');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?route=suppliers/index');
            exit;
        }

        $supplier = Supplier::find($id);
        if (!$supplier) {
            header('Location: index.php?route=suppliers/index');
            exit;
        }

        Supplier::delete($id);
        header('Location: index.php?route=suppliers/index');
        exit;
    }
}
