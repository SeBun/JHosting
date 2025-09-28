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
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE UNIQUE INDEX IF NOT EXISTS "idx_hosting_users_joomla_id" ON "#__hosting_users" ("joomla_user_id");
CREATE INDEX IF NOT EXISTS "idx_hosting_users_status" ON "#__hosting_users" ("status");

--
-- Table structure for hosting services
--
CREATE TABLE IF NOT EXISTS "#__hosting_services" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL REFERENCES "#__hosting_users"("id") ON DELETE CASCADE,
    "service_type" VARCHAR(50) NOT NULL,
    "service_name" VARCHAR(255) NOT NULL,
    "domain" VARCHAR(255) DEFAULT NULL,
    "plan" VARCHAR(100) NOT NULL,
    "status" VARCHAR(20) DEFAULT 'pending',
    "monthly_price" DECIMAL(8,2) NOT NULL,
    "setup_fee" DECIMAL(8,2) DEFAULT 0.00,
    "next_due_date" DATE DEFAULT NULL,
    "ispmanager_account_id" VARCHAR(100) DEFAULT NULL,
    "server_data" JSONB DEFAULT NULL,
    "auto_suspend" BOOLEAN DEFAULT TRUE,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS "idx_hosting_services_user_id" ON "#__hosting_services" ("user_id");
CREATE INDEX IF NOT EXISTS "idx_hosting_services_status" ON "#__hosting_services" ("status");
CREATE INDEX IF NOT EXISTS "idx_hosting_services_due_date" ON "#__hosting_services" ("next_due_date");

--
-- Table structure for hosting transactions
--
CREATE TABLE IF NOT EXISTS "#__hosting_transactions" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL REFERENCES "#__hosting_users"("id") ON DELETE CASCADE,
    "service_id" INTEGER DEFAULT NULL REFERENCES "#__hosting_services"("id") ON DELETE SET NULL,
    "type" VARCHAR(30) NOT NULL,
    "amount" DECIMAL(10,2) NOT NULL,
    "currency" VARCHAR(3) DEFAULT 'RUB',
    "description" VARCHAR(500) NOT NULL,
    "payment_method" VARCHAR(50) DEFAULT NULL,
    "payment_id" VARCHAR(255) DEFAULT NULL,
    "status" VARCHAR(20) DEFAULT 'pending',
    "gateway_data" JSONB DEFAULT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS "idx_hosting_transactions_user_id" ON "#__hosting_transactions" ("user_id");
CREATE INDEX IF NOT EXISTS "idx_hosting_transactions_service_id" ON "#__hosting_transactions" ("service_id");
CREATE INDEX IF NOT EXISTS "idx_hosting_transactions_status" ON "#__hosting_transactions" ("status");
CREATE INDEX IF NOT EXISTS "idx_hosting_transactions_payment_id" ON "#__hosting_transactions" ("payment_id");

--
-- Table structure for hosting tickets
--
CREATE TABLE IF NOT EXISTS "#__hosting_tickets" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL REFERENCES "#__hosting_users"("id") ON DELETE CASCADE,
    "service_id" INTEGER DEFAULT NULL REFERENCES "#__hosting_services"("id") ON DELETE SET NULL,
    "subject" VARCHAR(255) NOT NULL,
    "priority" VARCHAR(20) DEFAULT 'normal',
    "status" VARCHAR(20) DEFAULT 'open',
    "assigned_to" INTEGER DEFAULT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS "idx_hosting_tickets_user_id" ON "#__hosting_tickets" ("user_id");
CREATE INDEX IF NOT EXISTS "idx_hosting_tickets_status" ON "#__hosting_tickets" ("status");

--
-- Table structure for hosting ticket messages
--
CREATE TABLE IF NOT EXISTS "#__hosting_ticket_messages" (
    "id" SERIAL PRIMARY KEY,
    "ticket_id" INTEGER NOT NULL REFERENCES "#__hosting_tickets"("id") ON DELETE CASCADE,
    "user_id" INTEGER NOT NULL,
    "message" TEXT NOT NULL,
    "is_admin" BOOLEAN DEFAULT FALSE,
    "attachments" JSONB DEFAULT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS "idx_hosting_ticket_messages_ticket_id" ON "#__hosting_ticket_messages" ("ticket_id");

--
-- Table structure for hosting invoices
--
CREATE TABLE IF NOT EXISTS "#__hosting_invoices" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL REFERENCES "#__hosting_users"("id") ON DELETE CASCADE,
    "invoice_number" VARCHAR(50) NOT NULL,
    "amount" DECIMAL(10,2) NOT NULL,
    "currency" VARCHAR(3) DEFAULT 'RUB',
    "status" VARCHAR(20) DEFAULT 'pending',
    "due_date" DATE NOT NULL,
    "items" JSONB NOT NULL,
    "pdf_path" VARCHAR(500) DEFAULT NULL,
    "xml_path" VARCHAR(500) DEFAULT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE UNIQUE INDEX IF NOT EXISTS "idx_hosting_invoices_number" ON "#__hosting_invoices" ("invoice_number");
CREATE INDEX IF NOT EXISTS "idx_hosting_invoices_user_id" ON "#__hosting_invoices" ("user_id");
CREATE INDEX IF NOT EXISTS "idx_hosting_invoices_status" ON "#__hosting_invoices" ("status");

--
-- Table structure for hosting cron jobs
--
CREATE TABLE IF NOT EXISTS "#__hosting_cron_jobs" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(100) NOT NULL,
    "command" VARCHAR(500) NOT NULL,
    "schedule" VARCHAR(100) NOT NULL,
    "status" VARCHAR(20) DEFAULT 'active',
    "last_run" TIMESTAMP DEFAULT NULL,
    "next_run" TIMESTAMP DEFAULT NULL,
    "run_count" INTEGER DEFAULT 0,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS "idx_hosting_cron_jobs_status" ON "#__hosting_cron_jobs" ("status");
CREATE INDEX IF NOT EXISTS "idx_hosting_cron_jobs_next_run" ON "#__hosting_cron_jobs" ("next_run");