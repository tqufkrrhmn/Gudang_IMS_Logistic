<?php
// scripts/seed_admin.php
// Usage: run with php from project root: php scripts/seed_admin.php

require __DIR__ . '/../config/database.php';

$pdo = require __DIR__ . '/../config/database.php';

$username = 'admin';
$password = 'admin'; // change this after first login
$full_name = 'Administrator';
$email = 'admin@example.com';
$role_id = 1; // admin

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
$stmt->execute(['username' => $username]);
$exists = $stmt->fetch();

if ($exists) {
    echo "User 'admin' already exists (id=" . $exists['id'] . ").\n";
    exit(0);
}

$insert = $pdo->prepare('INSERT INTO users (username, password, full_name, email, role_id) VALUES (:username, :password, :full_name, :email, :role_id)');
$insert->execute([
    'username' => $username,
    'password' => $hash,
    'full_name' => $full_name,
    'email' => $email,
    'role_id' => $role_id,
]);

echo "Admin user created. Username: {$username}, Password: {$password}\n";
echo "Please change the password after first login.\n";
