-- migrations/patch_add_location_supplier.sql
-- Quick patch to add legacy columns `location` and `supplier` to `items` table
-- Run this after importing full_schema.sql if your application expects these columns.

USE `ims_logistics`;

ALTER TABLE items
  ADD COLUMN IF NOT EXISTS `location` VARCHAR(100) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `supplier` VARCHAR(255) DEFAULT NULL;

-- End of patch
