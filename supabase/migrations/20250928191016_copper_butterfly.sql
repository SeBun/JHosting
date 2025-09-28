@@ .. @@
 --
 -- Table structure for hosting users
 --
 CREATE TABLE IF NOT EXISTS "#__hosting_users" (
     "id" SERIAL PRIMARY KEY,
     "joomla_user_id" INTEGER NOT NULL,
     "balance" DECIMAL(10,2) DEFAULT 0.00,
     "currency" VARCHAR(3) DEFAULT 'RUB',
     "user_type" VARCHAR(20) DEFAULT 'individual',
     "status" VARCHAR(20) DEFAULT 'active',
     "company_name" VARCHAR(255) DEFAULT NULL,
     "company_inn" VARCHAR(20) DEFAULT NULL,
     "company_address" TEXT DEFAULT NULL,
+    "phone" VARCHAR(20) DEFAULT NULL,
+    "passport_series" VARCHAR(10) DEFAULT NULL,
+    "passport_number" VARCHAR(20) DEFAULT NULL,
+    "passport_issued_by" TEXT DEFAULT NULL,
+    "passport_issued_date" DATE DEFAULT NULL,
+    "birth_date" DATE DEFAULT NULL,
+    "first_name" VARCHAR(100) DEFAULT NULL,
+    "last_name" VARCHAR(100) DEFAULT NULL,
+    "middle_name" VARCHAR(100) DEFAULT NULL,
+    "first_name_ru" VARCHAR(100) DEFAULT NULL,
+    "last_name_ru" VARCHAR(100) DEFAULT NULL,
+    "middle_name_ru" VARCHAR(100) DEFAULT NULL,
+    "postal_code" VARCHAR(10) DEFAULT NULL,
+    "region" VARCHAR(100) DEFAULT NULL,
+    "address" TEXT DEFAULT NULL,
     "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 );
 
 CREATE UNIQUE INDEX IF NOT EXISTS "idx_hosting_users_joomla_id" ON "#__hosting_users" ("joomla_user_id");
 CREATE INDEX IF NOT EXISTS "idx_hosting_users_status" ON "#__hosting_users" ("status");
+CREATE INDEX IF NOT EXISTS "idx_hosting_users_phone" ON "#__hosting_users" ("phone");
 
 --
 -- Table structure for hosting services
@@ .. @@
     "service_type" VARCHAR(50) NOT NULL,
     "service_name" VARCHAR(255) NOT NULL,
     "domain" VARCHAR(255) DEFAULT NULL,
     "plan" VARCHAR(100) NOT NULL,
     "status" VARCHAR(20) DEFAULT 'pending',
     "monthly_price" DECIMAL(8,2) NOT NULL,
     "setup_fee" DECIMAL(8,2) DEFAULT 0.00,
     "next_due_date" DATE DEFAULT NULL,
+    "expiry_date" DATE DEFAULT NULL,
     "ispmanager_account_id" VARCHAR(100) DEFAULT NULL,
     "server_data" JSONB DEFAULT NULL,
     "auto_suspend" BOOLEAN DEFAULT TRUE,
+    "nameservers" TEXT DEFAULT NULL,
     "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 );
 
 CREATE INDEX IF NOT EXISTS "idx_hosting_services_user_id" ON "#__hosting_services" ("user_id");
 CREATE INDEX IF NOT EXISTS "idx_hosting_services_status" ON "#__hosting_services" ("status");
 CREATE INDEX IF NOT EXISTS "idx_hosting_services_due_date" ON "#__hosting_services" ("next_due_date");
+CREATE INDEX IF NOT EXISTS "idx_hosting_services_expiry_date" ON "#__hosting_services" ("expiry_date");
+CREATE INDEX IF NOT EXISTS "idx_hosting_services_domain" ON "#__hosting_services" ("domain");
 
 --
 -- Table structure for hosting transactions
@@ .. @@
 CREATE INDEX IF NOT EXISTS "idx_hosting_tickets_user_id" ON "#__hosting_tickets" ("user_id");
 CREATE INDEX IF NOT EXISTS "idx_hosting_tickets_status" ON "#__hosting_tickets" ("status");
+CREATE INDEX IF NOT EXISTS "idx_hosting_tickets_priority" ON "#__hosting_tickets" ("priority");
 
 --
 -- Table structure for hosting ticket messages
@@ .. @@
 CREATE INDEX IF NOT EXISTS "idx_hosting_invoices_user_id" ON "#__hosting_invoices" ("user_id");
 CREATE INDEX IF NOT EXISTS "idx_hosting_invoices_status" ON "#__hosting_invoices" ("status");
+CREATE INDEX IF NOT EXISTS "idx_hosting_invoices_due_date" ON "#__hosting_invoices" ("due_date");
 
 --
 -- Table structure for hosting cron jobs
@@ .. @@
 
 CREATE INDEX IF NOT EXISTS "idx_hosting_cron_jobs_status" ON "#__hosting_cron_jobs" ("status");
 CREATE INDEX IF NOT EXISTS "idx_hosting_cron_jobs_next_run" ON "#__hosting_cron_jobs" ("next_run");
+
+--
+-- Table structure for hosting domains
+--
+CREATE TABLE IF NOT EXISTS "#__hosting_domains" (
+    "id" SERIAL PRIMARY KEY,
+    "user_id" INTEGER NOT NULL REFERENCES "#__hosting_users"("id") ON DELETE CASCADE,
+    "domain_name" VARCHAR(255) NOT NULL,
+    "registrar" VARCHAR(100) DEFAULT NULL,
+    "status" VARCHAR(20) DEFAULT 'active',
+    "expiry_date" DATE DEFAULT NULL,
+    "auto_renew" BOOLEAN DEFAULT FALSE,
+    "nameservers" TEXT DEFAULT NULL,
+    "whois_data" JSONB DEFAULT NULL,
+    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
+    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
+);
+
+CREATE UNIQUE INDEX IF NOT EXISTS "idx_hosting_domains_name" ON "#__hosting_domains" ("domain_name");
+CREATE INDEX IF NOT EXISTS "idx_hosting_domains_user_id" ON "#__hosting_domains" ("user_id");
+CREATE INDEX IF NOT EXISTS "idx_hosting_domains_status" ON "#__hosting_domains" ("status");
+CREATE INDEX IF NOT EXISTS "idx_hosting_domains_expiry" ON "#__hosting_domains" ("expiry_date");
+
+--
+-- Table structure for hosting user settings
+--
+CREATE TABLE IF NOT EXISTS "#__hosting_user_settings" (
+    "id" SERIAL PRIMARY KEY,
+    "user_id" INTEGER NOT NULL REFERENCES "#__hosting_users"("id") ON DELETE CASCADE,
+    "setting_key" VARCHAR(100) NOT NULL,
+    "setting_value" TEXT DEFAULT NULL,
+    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
+    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
+);
+
+CREATE UNIQUE INDEX IF NOT EXISTS "idx_hosting_user_settings_unique" ON "#__hosting_user_settings" ("user_id", "setting_key");
+CREATE INDEX IF NOT EXISTS "idx_hosting_user_settings_key" ON "#__hosting_user_settings" ("setting_key");
+
+--
+-- Insert default cron jobs
+--
+INSERT INTO "#__hosting_cron_jobs" ("name", "command", "schedule", "status") VALUES
+('Check Service Expiry', 'php cli/hosting_check_expiry.php', '0 9 * * *', 'active'),
+('Suspend Expired Services', 'php cli/hosting_suspend_expired.php', '0 10 * * *', 'active'),
+('Send Expiry Notifications', 'php cli/hosting_notify_expiry.php', '0 8 * * *', 'active'),
+('Process Pending Payments', 'php cli/hosting_process_payments.php', '*/15 * * * *', 'active');