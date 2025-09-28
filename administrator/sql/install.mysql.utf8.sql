--
-- Table structure for hosting users (MySQL)
--
CREATE TABLE IF NOT EXISTS `#__hosting_users` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `joomla_user_id` INT NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `currency` VARCHAR(3) NOT NULL DEFAULT 'RUB',
  `user_type` VARCHAR(20) NOT NULL DEFAULT 'individual',
  `status` VARCHAR(20) NOT NULL DEFAULT 'active',
  `company_name` VARCHAR(255) DEFAULT NULL,
  `company_inn` VARCHAR(20) DEFAULT NULL,
  `company_address` TEXT,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `idx_hosting_users_joomla_id` ON `#__hosting_users` (`joomla_user_id`);
CREATE INDEX `idx_hosting_users_status` ON `#__hosting_users` (`status`);

--
-- Table structure for hosting services
--
CREATE TABLE IF NOT EXISTS `#__hosting_services` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `service_type` VARCHAR(50) NOT NULL,
  `service_name` VARCHAR(255) NOT NULL,
  `domain` VARCHAR(255) DEFAULT NULL,
  `plan` VARCHAR(100) NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `monthly_price` DECIMAL(8,2) NOT NULL,
  `setup_fee` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  `next_due_date` DATE DEFAULT NULL,
  `ispmanager_account_id` VARCHAR(100) DEFAULT NULL,
  `server_data` JSON DEFAULT NULL,
  `auto_suspend` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `#__hosting_users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_hosting_services_user_id` ON `#__hosting_services` (`user_id`);
CREATE INDEX `idx_hosting_services_status` ON `#__hosting_services` (`status`);
CREATE INDEX `idx_hosting_services_due_date` ON `#__hosting_services` (`next_due_date`);

--
-- Table structure for hosting transactions
--
CREATE TABLE IF NOT EXISTS `#__hosting_transactions` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `service_id` INT DEFAULT NULL,
  `type` VARCHAR(30) NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(3) NOT NULL DEFAULT 'RUB',
  `description` VARCHAR(500) NOT NULL,
  `payment_method` VARCHAR(50) DEFAULT NULL,
  `payment_id` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `gateway_data` JSON DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `#__hosting_users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`service_id`) REFERENCES `#__hosting_services`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_hosting_transactions_user_id` ON `#__hosting_transactions` (`user_id`);
CREATE INDEX `idx_hosting_transactions_service_id` ON `#__hosting_transactions` (`service_id`);
CREATE INDEX `idx_hosting_transactions_status` ON `#__hosting_transactions` (`status`);
CREATE INDEX `idx_hosting_transactions_payment_id` ON `#__hosting_transactions` (`payment_id`);

--
-- Table structure for hosting tickets
--
CREATE TABLE IF NOT EXISTS `#__hosting_tickets` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `service_id` INT DEFAULT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `priority` VARCHAR(20) NOT NULL DEFAULT 'normal',
  `status` VARCHAR(20) NOT NULL DEFAULT 'open',
  `assigned_to` INT DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `#__hosting_users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`service_id`) REFERENCES `#__hosting_services`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_hosting_tickets_user_id` ON `#__hosting_tickets` (`user_id`);
CREATE INDEX `idx_hosting_tickets_status` ON `#__hosting_tickets` (`status`);

--
-- Table structure for hosting ticket messages
--
CREATE TABLE IF NOT EXISTS `#__hosting_ticket_messages` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ticket_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `message` TEXT NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  `attachments` JSON DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`ticket_id`) REFERENCES `#__hosting_tickets`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_hosting_ticket_messages_ticket_id` ON `#__hosting_ticket_messages` (`ticket_id`);

--
-- Table structure for hosting invoices
--
CREATE TABLE IF NOT EXISTS `#__hosting_invoices` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `invoice_number` VARCHAR(50) NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(3) NOT NULL DEFAULT 'RUB',
  `status` VARCHAR(20) NOT NULL DEFAULT 'pending',
  `due_date` DATE NOT NULL,
  `items` JSON NOT NULL,
  `pdf_path` VARCHAR(500) DEFAULT NULL,
  `xml_path` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `#__hosting_users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE UNIQUE INDEX `idx_hosting_invoices_number` ON `#__hosting_invoices` (`invoice_number`);
CREATE INDEX `idx_hosting_invoices_user_id` ON `#__hosting_invoices` (`user_id`);
CREATE INDEX `idx_hosting_invoices_status` ON `#__hosting_invoices` (`status`);

--
-- Table structure for hosting cron jobs
--
CREATE TABLE IF NOT EXISTS `#__hosting_cron_jobs` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `command` VARCHAR(500) NOT NULL,
  `schedule` VARCHAR(100) NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'active',
  `last_run` DATETIME DEFAULT NULL,
  `next_run` DATETIME DEFAULT NULL,
  `run_count` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_hosting_cron_jobs_status` ON `#__hosting_cron_jobs` (`status`);
CREATE INDEX `idx_hosting_cron_jobs_next_run` ON `#__hosting_cron_jobs` (`next_run`);
