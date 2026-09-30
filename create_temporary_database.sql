-- Temporary database for ci4_pagination_DREW2
-- This database is separate from electriccompany and other DREW databases.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `electric_company_drew2_temp`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `electric_company_drew2_temp`;

-- Registration table required by Register::create()
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `state` VARCHAR(50) DEFAULT NULL,
  `zip_code` VARCHAR(10) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `user_type` ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `email_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pagination table supplied in the new activity
CREATE TABLE IF NOT EXISTS `customer_accounts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `account_number` VARCHAR(50) NOT NULL,
  `customer_name` VARCHAR(150) NOT NULL,
  `address` TEXT NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `meter_number` VARCHAR(50) DEFAULT NULL,
  `connection_type` ENUM('residential','commercial','industrial') DEFAULT 'residential',
  `status` ENUM('active','inactive','suspended') DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_account_number` (`account_number`),
  KEY `idx_status` (`status`),
  KEY `idx_connection_type` (`connection_type`),
  KEY `idx_customer_name` (`customer_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `customer_accounts`
  (`id`, `account_number`, `customer_name`, `address`, `phone`, `email`, `meter_number`, `connection_type`, `status`, `created_at`, `updated_at`)
VALUES
  (1, 'EC-2024-0001', 'John Smith', '123 Main Street, Downtown', '555-0101', 'john.smith@email.com', 'MTR-001', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (2, 'EC-2024-0002', 'Sarah Johnson', '456 Oak Avenue, Suburb', '555-0102', 'sarah.j@email.com', 'MTR-002', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (3, 'EC-2024-0003', 'ABC Corporation', '789 Business Blvd, City Center', '555-0103', 'contact@abc.com', 'MTR-003', 'commercial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (4, 'EC-2024-0004', 'Michael Brown', '321 Pine Road, Eastside', '555-0104', 'mbrown@email.com', 'MTR-004', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (5, 'EC-2024-0005', 'Tech Industries Inc', '555 Industrial Park, Zone A', '555-0105', 'info@techindustries.com', 'MTR-005', 'industrial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (6, 'EC-2024-0006', 'Emily Davis', '678 Maple Drive, Westside', '555-0106', 'emily.d@email.com', 'MTR-006', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (7, 'EC-2024-0007', 'Green Mart Store', '890 Commerce Street, Plaza', '555-0107', 'greenmart@email.com', 'MTR-007', 'commercial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (8, 'EC-2024-0008', 'Robert Wilson', '234 Cedar Lane, Northside', '555-0108', 'rwilson@email.com', 'MTR-008', 'residential', 'inactive', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (9, 'EC-2024-0009', 'Manufacturing Co', '432 Factory Road, Industrial Zone', '555-0109', 'info@mfgco.com', 'MTR-009', 'industrial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (10, 'EC-2024-0010', 'Lisa Anderson', '567 Birch Street, Southside', '555-0110', 'landerson@email.com', 'MTR-010', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (11, 'EC-2024-0011', 'David Martinez', '890 Elm Avenue, Central', '555-0111', 'dmartinez@email.com', 'MTR-011', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (12, 'EC-2024-0012', 'Retail Plaza LLC', '123 Shopping Center, Mall District', '555-0112', 'contact@retailplaza.com', 'MTR-012', 'commercial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (13, 'EC-2024-0013', 'Jennifer Taylor', '456 Spruce Road, Hillside', '555-0113', 'jtaylor@email.com', 'MTR-013', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (14, 'EC-2024-0014', 'Heavy Industries Ltd', '789 Manufacturing Ave, Zone B', '555-0114', 'info@heavyind.com', 'MTR-014', 'industrial', 'suspended', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (15, 'EC-2024-0015', 'Thomas White', '321 Willow Lane, Riverside', '555-0115', 'twhite@email.com', 'MTR-015', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (16, 'EC-2024-0016', 'Office Complex Inc', '654 Corporate Drive, Business Park', '555-0116', 'admin@officecomplex.com', 'MTR-016', 'commercial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (17, 'EC-2024-0017', 'Patricia Harris', '987 Ash Street, Lakeside', '555-0117', 'pharris@email.com', 'MTR-017', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (18, 'EC-2024-0018', 'Auto Manufacturing', '246 Assembly Line Rd, Industrial Park', '555-0118', 'contact@automfg.com', 'MTR-018', 'industrial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (19, 'EC-2024-0019', 'Christopher Lee', '135 Poplar Avenue, Garden District', '555-0119', 'clee@email.com', 'MTR-019', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (20, 'EC-2024-0020', 'Shopping Center Co', '468 Retail Blvd, Downtown', '555-0120', 'info@shopcenter.com', 'MTR-020', 'commercial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (21, 'EC-2024-0021', 'Nancy Clark', '579 Hickory Drive, Parkside', '555-0121', 'nclark@email.com', 'MTR-021', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (22, 'EC-2024-0022', 'Steel Works Inc', '802 Foundry Road, Industrial Zone C', '555-0122', 'contact@steelworks.com', 'MTR-022', 'industrial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (23, 'EC-2024-0023', 'Daniel Lewis', '913 Sycamore Lane, Meadow View', '555-0123', 'dlewis@email.com', 'MTR-023', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (24, 'EC-2024-0024', 'Restaurant Group LLC', '246 Dining Street, Food District', '555-0124', 'info@restgroup.com', 'MTR-024', 'commercial', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51'),
  (25, 'EC-2024-0025', 'Karen Walker', '357 Magnolia Road, Sunset Hills', '555-0125', 'kwalker@email.com', 'MTR-025', 'residential', 'active', '2025-10-22 01:01:51', '2025-10-22 01:01:51');

ALTER TABLE `customer_accounts` AUTO_INCREMENT = 26;

COMMIT;
