-- migrations/full_schema.sql
-- Full schema for Gudang_IMS_Logistic (IMS)
-- Run this file in MySQL (phpMyAdmin or CLI) to create database and tables used by the app.

-- Change the database name below if you prefer a different name.
CREATE DATABASE IF NOT EXISTS `ims_logistics` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ims_logistics`;

SET FOREIGN_KEY_CHECKS = 0;

-- Roles table
CREATE TABLE IF NOT EXISTS roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE,
  description VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(255),
  email VARCHAR(255),
  role_id INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Suppliers table
CREATE TABLE IF NOT EXISTS suppliers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  contact_person VARCHAR(255),
  phone VARCHAR(50),
  email VARCHAR(255),
  address TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Locations / bins
CREATE TABLE IF NOT EXISTS locations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(100) NOT NULL UNIQUE,
  description VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Items table
CREATE TABLE IF NOT EXISTS items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  sku VARCHAR(100),
  quantity INT DEFAULT 0,
  location_id INT DEFAULT NULL,
  supplier_id INT DEFAULT NULL,
  min_stock INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_items_location FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_items_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX idx_items_sku (sku)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Receipts / Goods Received (GRN)
CREATE TABLE IF NOT EXISTS receipts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  receipt_no VARCHAR(100) NOT NULL UNIQUE,
  supplier_id INT NOT NULL,
  received_by INT DEFAULT NULL,
  received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  notes TEXT,
  CONSTRAINT fk_receipts_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_receipts_user FOREIGN KEY (received_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Receipt lines (items in a receipt)
CREATE TABLE IF NOT EXISTS receipt_lines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  receipt_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  unit_price DECIMAL(15,2) DEFAULT NULL,
  CONSTRAINT fk_receipt_lines_receipt FOREIGN KEY (receipt_id) REFERENCES receipts(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_receipt_lines_item FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Shipments / Outbound
CREATE TABLE IF NOT EXISTS shipments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  shipment_no VARCHAR(100) NOT NULL UNIQUE,
  shipped_by INT DEFAULT NULL,
  shipped_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  destination VARCHAR(255),
  notes TEXT,
  CONSTRAINT fk_shipments_user FOREIGN KEY (shipped_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Shipment lines
CREATE TABLE IF NOT EXISTS shipment_lines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  shipment_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 0,
  CONSTRAINT fk_shipment_lines_shipment FOREIGN KEY (shipment_id) REFERENCES shipments(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_shipment_lines_item FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Stock transactions (in/out/adjustment) - ledger of inventory movements
CREATE TABLE IF NOT EXISTS stock_transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT NOT NULL,
  `change` INT NOT NULL,
  `type` ENUM('RECEIPT','SHIPMENT','ADJUSTMENT','MANUAL') NOT NULL,
  reference_id INT DEFAULT NULL,
  note TEXT,
  created_by INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_stock_item FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_stock_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX idx_stock_item (item_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Audit log
CREATE TABLE IF NOT EXISTS audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT DEFAULT NULL,
  action VARCHAR(100) NOT NULL,
  entity VARCHAR(100),
  entity_id INT DEFAULT NULL,
  meta JSON DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed roles
INSERT INTO roles (name, description) VALUES
('admin', 'Administrator - full access'),
('manager', 'Warehouse manager - manage inventory'),
('operator', 'Warehouse operator - perform receipts and shipments')
ON DUPLICATE KEY UPDATE name = VALUES(name);

SET FOREIGN_KEY_CHECKS = 1;

-- Notes:
-- 1) This file creates the database `ims_logistics` and all tables used by the application.
-- 2) The SQL does NOT insert an admin user with password (password hashing should be done using PHP). Use the provided PHP seed script:
--      php scripts\seed_admin.php
--    This script will create an admin account (username: admin, password: admin) if it doesn't exist.
-- 3) After importing this SQL, run the seed script and then open the app at:
--      http://localhost/Gudang_IMS_Logistic/public/index.php

-- End of file
