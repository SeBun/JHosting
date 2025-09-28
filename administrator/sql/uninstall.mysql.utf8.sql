-- Uninstall: drop hosting tables (MySQL)
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `#__hosting_ticket_messages`;
DROP TABLE IF EXISTS `#__hosting_tickets`;
DROP TABLE IF EXISTS `#__hosting_transactions`;
DROP TABLE IF EXISTS `#__hosting_services`;
DROP TABLE IF EXISTS `#__hosting_invoices`;
DROP TABLE IF EXISTS `#__hosting_cron_jobs`;
DROP TABLE IF EXISTS `#__hosting_users`;

SET FOREIGN_KEY_CHECKS = 1;
