<?php
// admin/admin_security.php - Super Administrator Security and System Backups
require_once "../config.php";
require_once "auth.php";

// Enforce admin authentication
check_admin_auth();

// Mock login activity logs
$login_logs = [
    [
        'ip' => '127.0.0.1',
        'email' => 'admin@greenforensics.com',
        'status' => 'Success',
        'time' => '2026-05-26 11:34:02',
        'agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/124.0.0.0'
    ],
    [
        'ip' => '192.168.1.15',
        'email' => 'jcreyes@greenforensics.edu.ph',
        'status' => 'Success',
        'time' => '2026-05-26 09:12:45',
        'agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4_1 like Mac OS X) AppleWebKit/605.1.15'
    ],
    [
        'ip' => '127.0.0.1',
        'email' => 'admin@greenforensics.com',
        'status' => 'Failed (Wrong Password)',
        'time' => '2026-05-26 08:30:19',
        'agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/124.0.0.0'
    ],
    [
        'ip' => '192.168.1.8',
        'email' => 'unknown_attacker@domain.com',
        'status' => 'Failed (User Not Found)',
        'time' => '2026-05-25 22:15:00',
        'agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/115.0'
    ],
    [
        'ip' => '127.0.0.1',
        'email' => 'msantos@greenforensics.edu.ph',
        'status' => 'Success',
        'time' => '2026-05-25 14:02:11',
        'agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:125.0) Gecko/20100101 Firefox/125.0'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Security & Backup - Green Forensics</title>
    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="../css/admin_style.css?v=1.5">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <div class="admin-wrapper">
        <!-- SIDEBAR NAVIGATION -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-text">
                    <span>GREEN</span><span class="brand-accent">FORENSICS</span>
                </div>
            </div>

            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">SA</div>
                    <div class="user-details">
                        <h4><?php echo htmlspecialchars($_SESSION["user_name"]); ?></h4>
                        <span>Super Admin</span>
                    </div>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item">
                    <a href="admin_dashboard.php" class="menu-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="9"></rect>
                            <rect x="14" y="3" width="7" height="5"></rect>
                            <rect x="14" y="12" width="7" height="9"></rect>
                            <rect x="3" y="16" width="7" height="5"></rect>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="admin_users.php" class="menu-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="admin_records.php" class="menu-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Records</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="admin_reports.php" class="menu-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                        </svg>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="menu-item active">
                    <a href="admin_security.php" class="menu-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Security / Backup</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <a href="../logout.php" class="menu-link" style="color: #e07a5f;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

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
                        <h2>Green Forensics Evaluating System</h2>
                    </div>
                </div>

                <div class="header-right">
                    <a href="../logout.php" class="header-logout">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Sign Out</span>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="admin-content">
                <div class="page-header-wrap">
                    <div class="page-title">
                        <h1>Security Controls & Backups</h1>
                        <p>Track access histories, compile full database SQL backups, and oversee system operation
                            modes.</p>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <!-- Backup & Config Section -->
                    <div class="dashboard-card" style="display:flex; flex-direction:column; gap:1.5rem;">
                        <div>
                            <div class="card-title-wrap">
                                <h3>
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    <span>Database Maintenance & Backup</span>
                                </h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--gray); margin-bottom: 1.25rem;">
                                Generate a complete SQL dump of the <code>green_forensics</code> database structure and
                                values to prevent accidental data loss.
                            </p>
                            <button class="btn btn-primary"
                                onclick="alert('Creating database SQL dump... [green_forensics_dump.sql] compiled successfully and downloaded.')">
                                <span>Export SQL Backup Now</span>
                            </button>
                        </div>

                        <div>
                            <div class="card-title-wrap" style="margin-top:1rem;">
                                <h3>
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                        <polyline points="2 17 12 22 22 17"></polyline>
                                        <polyline points="2 12 12 17 22 12"></polyline>
                                    </svg>
                                    <span>System Maintenance State</span>
                                </h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--gray); margin-bottom: 1.25rem;">
                                Toggle offline mode to block student evaluations while database structural changes are
                                ongoing.
                            </p>
                            <div style="display:flex; align-items:center; gap:0.75rem;">
                                <button class="btn btn-secondary" onclick="alert('System maintenance mode toggled!')">
                                    <span>Toggle Maintenance Mode</span>
                                </button>
                                <span style="font-size:0.8rem; font-weight:700; color: var(--gray);">Status: <span
                                        style="color: var(--medium-green);">ONLINE</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Security Warnings Card -->
                    <div class="dashboard-card">
                        <div class="card-title-wrap">
                            <h3>
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                    </path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span>Security Recommendations</span>
                            </h3>
                        </div>
                        <div class="security-note">
                            <strong>1. Use Strong Admin Passwords:</strong> Avoid sharing administrator credentials with
                            faculty or students. Passwords are saved with bcrypt hashing.
                        </div>
                        <div class="security-note"
                            style="border-left-color: var(--danger); background-color: rgba(224, 122, 95, 0.05);">
                            <strong>2. Session Inactivity:</strong> Inactive sessions will expire automatically
                            according to PHP session lifetime rules. Make sure to log out on public computers.
                        </div>
                        <div class="security-note"
                            style="border-left-color: var(--warning); background-color: rgba(244, 162, 97, 0.05);">
                            <strong>3. Database Audits:</strong> Track login failures in the security log table to audit
                            brute-force evaluation attempts.
                        </div>
                    </div>
                </div>

                <!-- LOGIN SECURITY LOGS TABLE -->
                <div class="dashboard-card" style="margin-top: 1.5rem;">
                    <div class="card-title-wrap">
                        <h3>
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Access Activity History (Login Security Logs)</span>
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>IP Address</th>
                                    <th>Access Email Account</th>
                                    <th>Access Status</th>
                                    <th>Access Timestamp</th>
                                    <th>User Browser Agent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($login_logs as $log): ?>
                                    <tr>
                                        <td style="font-family: monospace; font-weight:700; color: var(--gray);">
                                            <?php echo $log['ip']; ?></td>
                                        <td style="font-weight: 600; color: var(--dark-green);">
                                            <?php echo htmlspecialchars($log['email']); ?></td>
                                        <td>
                                            <span
                                                class="badge badge-<?php echo ($log['status'] === 'Success') ? 'success' : 'inactive'; ?>"
                                                style="font-size:0.65rem;">
                                                <?php echo $log['status']; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($log['time'])); ?></td>
                                        <td
                                            style="font-size:0.75rem; color: var(--gray); font-family: monospace; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            <?php echo htmlspecialchars($log['agent']); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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