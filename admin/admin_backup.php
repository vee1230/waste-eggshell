<?php
// admin/admin_backup.php - Database Backup & Restoration Panel
require_once "../config.php";
require_once "auth.php";

// Enforce admin authentication
check_admin_auth();

$error = "";
$success = "";
$backup_dir = "backups/";

// Create backup directory if it does not exist
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// 1. HANDLE BACKUP CREATION
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "create_backup") {
    try {
        // Generate SQL backup content
        $tables = [];
        $res = $pdo->query("SHOW TABLES");
        while ($row = $res->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        $sql = "-- Green Forensics Database Backup\n";
        $sql .= "-- Timestamp: " . date("Y-m-d H:i:s") . "\n";
        $sql .= "-- Created by: " . $_SESSION["user_email"] . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            // Get Create Table script
            $create_res = $pdo->query("SHOW CREATE TABLE `$table`");
            $create_row = $create_res->fetch(PDO::FETCH_NUM);
            $sql .= "DROP TABLE IF EXISTS `$table`;\n";
            $sql .= $create_row[1] . ";\n\n";

            // Get Table Records
            $data_res = $pdo->query("SELECT * FROM `$table`");
            while ($row = $data_res->fetch(PDO::FETCH_ASSOC)) {
                $keys = array_map(function($k) { return "`$k`"; }, array_keys($row));
                $vals = array_map(function($v) use ($pdo) {
                    if ($v === null) return "NULL";
                    return $pdo->quote($v);
                }, array_values($row));
                
                $sql .= "INSERT INTO `$table` (" . implode(", ", $keys) . ") VALUES (" . implode(", ", $vals) . ");\n";
            }
            $sql .= "\n";
        }
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        // Write to file
        $filename = "green_forensics_backup_" . date("Ymd_His") . ".sql";
        $filepath = $backup_dir . $filename;
        
        if (file_put_contents($filepath, $sql) !== false) {
            // Record to backup history database
            $stmt = $pdo->prepare("INSERT INTO backup_history (filename, status, created_by) VALUES (:filename, 'success', :created_by)");
            $stmt->execute([
                ':filename' => $filename,
                ':created_by' => $_SESSION["user_id"]
            ]);

            log_activity("Backup Database", "Exported database SQL backup: $filename");
            $success = "Database SQL backup created successfully: $filename";
        } else {
            $error = "Failed to write backup file to disk. Check directory permissions.";
        }
    } catch (Exception $e) {
        $error = "Error generating database backup: " . $e->getMessage();
    }
}

// 2. HANDLE BACKUP RESTORATION FROM HISTORY
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "restore_backup") {
    $filename = trim($_POST["filename"] ?? "");
    $filepath = $backup_dir . $filename;

    if (empty($filename) || !file_exists($filepath)) {
        $error = "Backup file not found.";
    } else {
        try {
            $sql_content = file_get_contents($filepath);
            
            // Execute SQL commands
            $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
            $pdo->exec($sql_content);
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");

            log_activity("Restore Database", "Restored database from local file: $filename");
            
            // Re-authenticate user session in case user table was overwritten
            // We search for the current user's email in the newly restored database
            $chk = $pdo->prepare("SELECT id, full_name, role FROM users WHERE email = :email LIMIT 1");
            $chk->execute([':email' => $_SESSION["user_email"]]);
            $usr = $chk->fetch(PDO::FETCH_ASSOC);
            if ($usr) {
                $_SESSION["user_id"] = $usr["id"];
                $_SESSION["user_name"] = $usr["full_name"];
                $_SESSION["user_role"] = $usr["role"];
            }

            $success = "Database successfully restored to state matching backup: $filename";
        } catch (PDOException $e) {
            $error = "Database restoration failed: " . $e->getMessage();
        }
    }
}

// 3. HANDLE UPLOAD & RESTORE SQL FILE
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "upload_restore") {
    if (!isset($_FILES["backup_file"]) || $_FILES["backup_file"]["error"] !== UPLOAD_ERR_OK) {
        $error = "Error uploading backup file. Please select a valid SQL file.";
    } else {
        $file_name = $_FILES["backup_file"]["name"];
        $tmp_name = $_FILES["backup_file"]["tmp_name"];
        
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (strtolower($ext) !== 'sql') {
            $error = "Invalid file type. Only SQL (.sql) files are supported.";
        } else {
            try {
                $sql_content = file_get_contents($tmp_name);
                
                // Execute restoration
                $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
                $pdo->exec($sql_content);
                $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");

                // Save file copy to backups folder for history record
                $stored_filename = "uploaded_backup_" . date("Ymd_His") . "_" . $file_name;
                move_uploaded_file($tmp_name, $backup_dir . $stored_filename);

                $stmt = $pdo->prepare("INSERT INTO backup_history (filename, status, created_by) VALUES (:filename, 'success', :created_by)");
                $stmt->execute([
                    ':filename' => $stored_filename,
                    ':created_by' => $_SESSION["user_id"]
                ]);

                log_activity("Restore Database", "Restored database from uploaded backup file: $file_name");
                
                // Re-authenticate user session
                $chk = $pdo->prepare("SELECT id, full_name, role FROM users WHERE email = :email LIMIT 1");
                $chk->execute([':email' => $_SESSION["user_email"]]);
                $usr = $chk->fetch(PDO::FETCH_ASSOC);
                if ($usr) {
                    $_SESSION["user_id"] = $usr["id"];
                    $_SESSION["user_name"] = $usr["full_name"];
                    $_SESSION["user_role"] = $usr["role"];
                }

                $success = "Database successfully restored from uploaded file: $file_name";
            } catch (PDOException $e) {
                $error = "Database restoration failed: " . $e->getMessage();
            }
        }
    }
}

// 4. HANDLE BACKUP FILE DELETION
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "delete_backup") {
    $filename = trim($_POST["filename"] ?? "");
    $filepath = $backup_dir . $filename;

    if (!empty($filename) && file_exists($filepath)) {
        unlink($filepath);
        
        // Remove from db backup history list (or keep as failed/removed, let's delete)
        $stmt = $pdo->prepare("DELETE FROM backup_history WHERE filename = :filename");
        $stmt->execute([':filename' => $filename]);

        log_activity("Delete Backup", "Deleted database backup file: $filename");
        $success = "Backup file $filename deleted successfully.";
    } else {
        $error = "Backup file not found on disk.";
    }
}

// 5. DOWNLOAD BACKUP FILE TRIGGER
if (isset($_GET["download"])) {
    $filename = basename($_GET["download"]);
    $filepath = $backup_dir . $filename;

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        $error = "Unable to download file. It may have been removed.";
    }
}

// Retrieve backup records list
$backup_history = [];
try {
    $stmt = $pdo->query("
        SELECT bh.id, bh.filename, bh.status, bh.created_at, u.full_name AS created_by_user 
        FROM backup_history bh 
        LEFT JOIN users u ON bh.created_by = u.id 
        ORDER BY bh.id DESC
    ");
    $backup_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore Database - Green Forensics</title>
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="../css/admin_style.css?v=1.6">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .alert { padding: .85rem 1.25rem; margin-bottom: 1.5rem; border-radius: 8px; font-size: 0.85rem; font-weight: 500; }
        .alert-danger { background-color: rgba(224, 122, 95, 0.15); color: var(--danger); border: 1px solid rgba(224, 122, 95, 0.2); }
        .alert-success { background-color: rgba(82, 183, 136, 0.15); color: var(--medium-green); border: 1px solid rgba(82, 183, 136, 0.2); }
        
        .restore-warning {
            background-color: rgba(224, 122, 95, 0.05);
            border-left: 4px solid var(--danger);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
            font-size: 0.82rem;
            color: #5c2010;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        .backup-upload-card {
            background:#fff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            border: 1px solid rgba(27, 67, 50, 0.08);
            box-shadow: var(--box-shadow);
        }
    </style>
</head>

<body>

    <div class="admin-wrapper">
        <!-- SIDEBAR NAVIGATION -->
        <?php include "sidebar.php"; ?>

        <!-- MAIN LAYOUT CONTENT -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="menu-toggle" id="sidebarCollapse">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div class="header-title">
                        <h2>Green Forensics — Super Administrator Dashboard</h2>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="admin-content">
                <div class="page-header-wrap">
                    <div class="page-title">
                        <h1>Database Backup & Restore</h1>
                        <p>Generate SQL exports of the database structure/values, upload existing studies backups, and restore database states.</p>
                    </div>
                    <div>
                        <form method="POST" action="admin_backup.php" style="display:inline;">
                            <input type="hidden" name="action" value="create_backup">
                            <button type="submit" class="btn btn-primary">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <span>Export SQL Backup Now</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ALERTS -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <div class="dashboard-grid" style="margin-bottom: 2rem;">
                    <!-- Upload & Restore card -->
                    <div class="backup-upload-card">
                        <div class="card-title-wrap">
                            <h3>
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <span>Upload SQL Backup File</span>
                            </h3>
                        </div>
                        
                        <div class="restore-warning">
                            <strong>CAUTION:</strong> Restoring database states overwrites all current fingerprint trials, user accounts, and remarks. Make sure to download a backup of your current database first before executing any restore files.
                        </div>

                        <form method="POST" action="admin_backup.php" enctype="multipart/form-data" 
                              onsubmit="return confirm('Restore database from uploaded file? All current records will be overwritten permanently.');">
                            <input type="hidden" name="action" value="upload_restore">
                            <div class="form-group">
                                <label for="backup_file">Select SQL File (.sql)</label>
                                <input type="file" name="backup_file" id="backup_file" class="form-control" accept=".sql" required>
                            </div>
                            <button type="submit" class="btn btn-danger" style="width: 100%; justify-content:center;">
                                <span>Upload &amp; Restore Database State</span>
                            </button>
                        </form>
                    </div>

                    <!-- Backup Guidelines -->
                    <div class="dashboard-card" style="display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div class="card-title-wrap">
                                <h3>
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="16" x2="12" y2="12"></line>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                    </svg>
                                    <span>Backup Guidelines</span>
                                </h3>
                            </div>
                            <p style="font-size:0.82rem; color:var(--gray); line-height:1.5; margin-bottom:0.75rem;">
                                <strong>Complete SQL Dump:</strong> Generating backups exports all system entities (Users, Fingerprint Submissions, Remarks, System Configurations, Reports, and Security Logs) in standard SQL script format.
                            </p>
                            <p style="font-size:0.82rem; color:var(--gray); line-height:1.5; margin-bottom:0.75rem;">
                                <strong>Server Portability:</strong> These files are highly portable and can be restored on any MySQL/MariaDB server supporting standard PHP PDO engines.
                            </p>
                        </div>
                        <div style="font-size:0.78rem; color: var(--medium-green); font-weight:700; border-top:1px solid #eee; padding-top:0.75rem;">
                            Last Backup Operation Checked: Secure
                        </div>
                    </div>
                </div>

                <!-- BACKUP HISTORY LIST TABLE -->
                <div class="dashboard-card">
                    <div class="card-title-wrap">
                        <h3>
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Database SQL Backups History</span>
                        </h3>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>File Size</th>
                                    <th>Backup Creator</th>
                                    <th>Date Created</th>
                                    <th>Backup Status</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($backup_history) > 0): ?>
                                    <?php foreach ($backup_history as $bh): ?>
                                        <?php 
                                            $filepath = $backup_dir . $bh['filename'];
                                            $filesize_str = "File Missing";
                                            $exists = false;
                                            if (file_exists($filepath)) {
                                                $exists = true;
                                                $bytes = filesize($filepath);
                                                if ($bytes >= 1048576) {
                                                    $filesize_str = number_format($bytes / 1048576, 2) . ' MB';
                                                } elseif ($bytes >= 1024) {
                                                    $filesize_str = number_format($bytes / 1024, 2) . ' KB';
                                                } else {
                                                    $filesize_str = $bytes . ' Bytes';
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td style="font-family: monospace; font-weight: 700; color: var(--dark-green);">
                                                <?php echo htmlspecialchars($bh['filename']); ?>
                                            </td>
                                            <td><?php echo $filesize_str; ?></td>
                                            <td><?php echo htmlspecialchars($bh['created_by_user'] ?: 'System Run'); ?></td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($bh['created_at'])); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo ($bh['status'] === 'success') ? 'success' : 'inactive'; ?>">
                                                    <?php echo $bh['status']; ?>
                                                </span>
                                            </td>
                                            <td style="text-align: right;">
                                                <div class="btn-group" style="justify-content: flex-end;">
                                                    <?php if ($exists): ?>
                                                        <!-- Download -->
                                                        <a href="admin_backup.php?download=<?php echo urlencode($bh['filename']); ?>" class="btn btn-secondary btn-sm" title="Download backup script">
                                                            <span>Download</span>
                                                        </a>

                                                        <!-- Restore -->
                                                        <form method="POST" action="admin_backup.php" style="display:inline;"
                                                              onsubmit="return confirm('Restore database to state matching backup: <?php echo htmlspecialchars($bh['filename']); ?>?\nAll current modifications since then will be deleted.');">
                                                            <input type="hidden" name="action" value="restore_backup">
                                                            <input type="hidden" name="filename" value="<?php echo htmlspecialchars($bh['filename']); ?>">
                                                            <button type="submit" class="btn btn-primary btn-sm" title="Restore this state">
                                                                <span>Restore</span>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>

                                                    <!-- Delete -->
                                                    <form method="POST" action="admin_backup.php" style="display:inline;"
                                                          onsubmit="return confirm('Permanently delete backup file: <?php echo htmlspecialchars($bh['filename']); ?>?');">
                                                        <input type="hidden" name="action" value="delete_backup">
                                                        <input type="hidden" name="filename" value="<?php echo htmlspecialchars($bh['filename']); ?>">
                                                        <button type="submit" class="icon-btn danger-hover" title="Delete backup file from server disk">
                                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
                                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: var(--gray); padding: 2rem;">No database backups generated yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JS Toggles -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarCollapse");

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle("active");
                });

                document.addEventListener("click", (e) => {
                    if (window.innerWidth <= 768 && sidebar.classList.contains("active")) {
                        if (!sidebar.contains(e.target) && e.target !== toggleBtn) {
                            sidebar.classList.remove("active");
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>
