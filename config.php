<?php
// config.php - Database Configuration & Connection with Auto-Setup

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'green_forensics');

try {
    // 1. First connect to MySQL server without selecting database
    $pdo = new PDO("mysql:host=" . DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Create database if it does not exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // 3. Connect to the specific database
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, DB_PASSWORD === '' ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_WARNING);

    // 4. Create users table if it does not exist
    $createTableSQL = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $pdo->exec($createTableSQL);

    // 5. Seed sample account if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $count = $stmt->fetchColumn();
    if ($count == 0) {
        $sampleName = "Forensic Analyst";
        $sampleEmail = "admin@greenforensics.com";
        // password_hash for 'admin123'
        $samplePassword = password_hash("admin123", PASSWORD_DEFAULT);
        $sampleStatus = "active";

        $insertSQL = "INSERT INTO users (name, email, password, status) VALUES (:name, :email, :password, :status)";
        $insertStmt = $pdo->prepare($insertSQL);
        $insertStmt->execute([
            ':name' => $sampleName,
            ':email' => $sampleEmail,
            ':password' => $samplePassword,
            ':status' => $sampleStatus
        ]);
    }
} catch (PDOException $e) {
    die("DATABASE ERROR: " . $e->getMessage());
}
?>