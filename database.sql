-- database.sql
-- Green Forensics Evaluating System Database Schema

CREATE DATABASE IF NOT EXISTS `green_forensics` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `green_forensics`;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `username` VARCHAR(80) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role_id` INT(11) NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `profile_pic` VARCHAR(255) DEFAULT NULL,
    `last_login` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default user accounts
-- Emails: admin@greenforensics.com (or admin@greenforensics.edu.ph)
-- Password: admin123 (for admin accounts) or password (for other accounts)
-- Hashing generated using PHP's password_hash() function
INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role_id`, `status`)
VALUES 
(1, 'System Administrator', 'admin@greenforensics.com', 'admin', '$2y$10$vU3vA6Kj24M75WqYFfL2aO/Qk2tQZlS66HWhFmgz4qEw3Q1c6lGxe', 1, 'active'),
(2, 'System Administrator (Edu)', 'admin@greenforensics.edu.ph', 'admin_edu', '$2y$10$Cde1Vjp9ICu1HX.MbUnSXek0NUwgFr6m2VThMuTikxhTYlgn4sc.C', 1, 'active')
ON DUPLICATE KEY UPDATE `id`=`id`;
