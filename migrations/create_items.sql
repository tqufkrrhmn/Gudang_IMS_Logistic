-- migrations/create_items.sql
-- Run this SQL to create the `items` table for the IMS project
CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  sku VARCHAR(100),
  quantity INT DEFAULT 0,
  location VARCHAR(100),
  supplier VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
