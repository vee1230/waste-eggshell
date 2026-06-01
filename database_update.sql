-- database_update.sql
-- Green Forensics - Registration System Update
-- Run this script to update the users table for the new multi-step registration flow

USE `green_forensics`;

-- Step 1: Add new columns to users table
ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `first_name`       VARCHAR(80)  DEFAULT NULL AFTER `id`,
    ADD COLUMN IF NOT EXISTS `middle_name`      VARCHAR(80)  DEFAULT NULL AFTER `first_name`,
    ADD COLUMN IF NOT EXISTS `last_name`        VARCHAR(80)  DEFAULT NULL AFTER `middle_name`,
    ADD COLUMN IF NOT EXISTS `contact_number`   VARCHAR(20)  DEFAULT NULL AFTER `email`,
    ADD COLUMN IF NOT EXISTS `id_number`        VARCHAR(50)  DEFAULT NULL AFTER `contact_number`,
    ADD COLUMN IF NOT EXISTS `department`       VARCHAR(150) DEFAULT NULL AFTER `id_number`,
    ADD COLUMN IF NOT EXISTS `affiliation`      VARCHAR(150) DEFAULT NULL AFTER `department`,
    ADD COLUMN IF NOT EXISTS `requested_role`   VARCHAR(50)  DEFAULT NULL AFTER `affiliation`,
    ADD COLUMN IF NOT EXISTS `reason_for_access` TEXT        DEFAULT NULL AFTER `requested_role`;

-- Step 2: Update status ENUM to include pending and rejected
ALTER TABLE `users`
    MODIFY COLUMN `status` ENUM('active','inactive','pending','rejected','suspended') DEFAULT 'pending';

-- Step 3: Update role ENUM to ensure all values present
ALTER TABLE `users`
    MODIFY COLUMN `role` ENUM('super_admin','faculty_researcher','criminology_student','alumni_police_partner') DEFAULT NULL;

-- Step 4: Ensure seeded admin/faculty users remain active
UPDATE `users` SET `status` = 'active' WHERE `email` IN (
    'admin@greenforensics.com',
    'admin@greenforensics.edu.ph',
    'faculty@greenforensics.edu.ph',
    'student@greenforensics.edu.ph'
);

-- Backfill full_name from existing records (keep full_name column for compatibility)
UPDATE `users` SET `full_name` = COALESCE(`full_name`, '') WHERE `full_name` IS NOT NULL;
