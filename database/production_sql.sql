-- ============================================
-- SHARE IJ - CMS Update SQL Queries
-- Run these in phpMyAdmin on your cPanel
-- ============================================

-- 1. Create Pages Table
CREATE TABLE IF NOT EXISTS `pages` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NULL,
    `meta_title` VARCHAR(255) NULL,
    `meta_description` TEXT NULL,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Create Menus Table
CREATE TABLE IF NOT EXISTS `menus` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `url` VARCHAR(255) NULL,
    `route_name` VARCHAR(255) NULL,
    `location` VARCHAR(255) NOT NULL DEFAULT 'header',
    `parent_id` BIGINT UNSIGNED NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `icon` VARCHAR(255) NULL,
    `target` VARCHAR(255) NOT NULL DEFAULT '_self',
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    KEY `menus_parent_id_foreign` (`parent_id`),
    CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Register migrations (so Laravel knows they ran)
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2026_02_10_000001_create_pages_table', 2),
('2026_02_10_000002_create_menus_table', 2);

-- 4. Seed Default Header Menus
INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('Home', NULL, 'home', 'header', NULL, 1, 1, NULL, '_self', NOW(), NOW()),
('About', NULL, 'about', 'header', NULL, 2, 1, NULL, '_self', NOW(), NOW()),
('Editorial Team', NULL, 'editorial-board', 'header', NULL, 3, 1, NULL, '_self', NOW(), NOW()),
('For Authors', '#', NULL, 'header', NULL, 4, 1, NULL, '_self', NOW(), NOW());

-- Get the ID of "For Authors" parent (should be 4 if tables were empty)
SET @forAuthorsId = LAST_INSERT_ID();

INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('Call for Papers', NULL, 'call-for-papers', 'header', @forAuthorsId, 1, 1, 'fas fa-bullhorn', '_self', NOW(), NOW()),
('Author Guidelines', NULL, 'author-guidelines', 'header', @forAuthorsId, 2, 1, 'fas fa-file-alt', '_self', NOW(), NOW()),
('Subject Areas', NULL, 'research-areas', 'header', @forAuthorsId, 3, 1, 'fas fa-microscope', '_self', NOW(), NOW()),
('Submission Workflow', NULL, 'submission-workflow', 'header', @forAuthorsId, 4, 1, 'fas fa-tasks', '_self', NOW(), NOW()),
('Publication Charges', NULL, 'apc', 'header', @forAuthorsId, 5, 1, 'fas fa-coins', '_self', NOW(), NOW()),
('Copyright Form Download', '/downloads/copyright-form.pdf', NULL, 'header', @forAuthorsId, 6, 1, 'fas fa-file-contract', '_self', NOW(), NOW()),
('Paper Format Download', '/downloads/paper-format.docx', NULL, 'header', @forAuthorsId, 7, 1, 'fas fa-file-word', '_self', NOW(), NOW());

INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('Archives', NULL, 'volumes.index', 'header', NULL, 5, 1, NULL, '_self', NOW(), NOW()),
('Contact', NULL, 'contact', 'header', NULL, 6, 1, NULL, '_self', NOW(), NOW());

-- 5. Seed Default Footer Menus
INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('Quick Links', '#', NULL, 'footer', NULL, 1, 1, NULL, '_self', NOW(), NOW());

SET @quickLinksId = LAST_INSERT_ID();

INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('Home', NULL, 'home', 'footer', @quickLinksId, 1, 1, NULL, '_self', NOW(), NOW()),
('About Journal', NULL, 'about', 'footer', @quickLinksId, 2, 1, NULL, '_self', NOW(), NOW()),
('Editorial Team', NULL, 'editorial-board', 'footer', @quickLinksId, 3, 1, NULL, '_self', NOW(), NOW()),
('Archives', NULL, 'volumes.index', 'footer', @quickLinksId, 4, 1, NULL, '_self', NOW(), NOW()),
('Contact', NULL, 'contact', 'footer', @quickLinksId, 5, 1, NULL, '_self', NOW(), NOW());

INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('For Authors', '#', NULL, 'footer', NULL, 2, 1, NULL, '_self', NOW(), NOW());

SET @forAuthorsFooterId = LAST_INSERT_ID();

INSERT INTO `menus` (`title`, `url`, `route_name`, `location`, `parent_id`, `sort_order`, `is_active`, `icon`, `target`, `created_at`, `updated_at`) VALUES
('Call for Papers', NULL, 'call-for-papers', 'footer', @forAuthorsFooterId, 1, 1, NULL, '_self', NOW(), NOW()),
('Author Guidelines', NULL, 'author-guidelines', 'footer', @forAuthorsFooterId, 2, 1, NULL, '_self', NOW(), NOW()),
('Submission Workflow', NULL, 'submission-workflow', 'footer', @forAuthorsFooterId, 3, 1, NULL, '_self', NOW(), NOW()),
('Publication Charges', NULL, 'apc', 'footer', @forAuthorsFooterId, 4, 1, NULL, '_self', NOW(), NOW()),
('Copyright Form', '/downloads/copyright-form.pdf', NULL, 'footer', @forAuthorsFooterId, 5, 1, NULL, '_self', NOW(), NOW()),
('Paper Format', '/downloads/paper-format.docx', NULL, 'footer', @forAuthorsFooterId, 6, 1, NULL, '_self', NOW(), NOW()),
('Submit Paper', NULL, 'register', 'footer', @forAuthorsFooterId, 7, 1, NULL, '_self', NOW(), NOW());
