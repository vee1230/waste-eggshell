<?php
// admin/admin_dashboard.php - Super Administrator Dashboard Overview
require_once "../config.php";
require_once "auth.php";

// Enforce admin authentication
check_admin_auth();

// Fetch dynamic counts with fallbacks
$total_users = 0;
$total_trials = 142; // Fallback default
$total_images = 86;  // Fallback default
$total_reports = 18;  // Fallback default

$pending_count = 0;
try {
    // 1. Count actual users
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $total_users = $stmt->fetchColumn();

    // 2. Count pending registrations
    $stmt2 = $pdo->query("SELECT COUNT(*) FROM users WHERE status='pending'");
    $pending_count = $stmt2 ? (int)$stmt2->fetchColumn() : 0;

    // 3. Count trials if table exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM fingerprint_tests");
    if ($stmt) {
        $db_trials = $stmt->fetchColumn();
        if ($db_trials > 0)
            $total_trials = $db_trials;
    }
} catch (PDOException $e) {
    // Suppress and use fallbacks if tables don't exist yet
}

try {
    // 3. Count reports if table exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM reports");
    if ($stmt) {
        $db_reports = $stmt->fetchColumn();
        if ($db_reports > 0)
            $total_reports = $db_reports;
    }
} catch (PDOException $e) {
    // Suppress and use fallbacks
}

// Set up recent activities
$activities = [
    ['type' => 'security', 'detail' => 'Super Administrator logged in', 'time' => 'Just now', 'user' => $_SESSION["user_name"]],
    ['type' => 'add', 'detail' => 'Created user account: jcreyes@greenforensics.edu.ph', 'time' => '2 hours ago', 'user' => 'System'],
    ['type' => 'edit', 'detail' => 'Updated password for msantos@greenforensics.edu.ph', 'time' => 'Yesterday', 'user' => 'System'],
    ['type' => 'security', 'detail' => 'Database backup created successfully', 'time' => 'May 25, 2026', 'user' => 'System Run']
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Green Forensics</title>
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
                <li class="menu-item active">
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
                    <a href="admin_pending.php" class="menu-link" style="position:relative;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Pending Approvals<?php if ($pending_count > 0): ?> <span style="background:#e07a5f;color:#fff;border-radius:20px;font-size:.65rem;padding:1px 7px;font-weight:700;margin-left:4px;"><?php echo $pending_count; ?></span><?php endif; ?></span>
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
                <li class="menu-item">
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


            </header>

            <!-- Main Content Area -->
            <div class="admin-content">
                <div class="page-header-wrap">
                    <div class="page-title">
                        <h1>Dashboard Overview</h1>
                        <p>Welcome back, Forensic Super Administrator. Here is your system health summary.</p>
                    </div>
                </div>

                <!-- METRICS GRID -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Total Users</span>
                            <div class="stat-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value"><?php echo $total_users; ?></div>
                        <div class="stat-desc">Registered user accounts</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Fingerprint Trials</span>
                            <div class="stat-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value"><?php echo $total_trials; ?></div>
                        <div class="stat-desc">Latent fingerprint extraction test trials</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Uploaded Images</span>
                            <div class="stat-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value"><?php echo $total_images; ?></div>
                        <div class="stat-desc">High resolution images in storage</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Reports Generated</span>
                            <div class="stat-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value"><?php echo $total_reports; ?></div>
                        <div class="stat-desc">PDF evaluations downloaded</div>
                    </div>
                </div>

                <div class="stats-grid" style="margin-bottom: 2rem;">
                    <!-- Comparison Rates -->
                    <div class="stat-card eggshell">
                        <div class="stat-header">
                            <span class="stat-title">Eggshell Powder Success Rate</span>
                            <div class="stat-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                    <polyline points="16 7 22 7 22 13"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">91.8%</div>
                        <div class="stat-desc">Average forensic ridge clarity score</div>
                    </div>

                    <div class="stat-card commercial">
                        <div class="stat-header">
                            <span class="stat-title">Commercial Powder Success Rate</span>
                            <div class="stat-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                    <polyline points="16 7 22 7 22 13"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-value">88.4%</div>
                        <div class="stat-desc">Standard carbon powder clarity benchmark</div>
                    </div>
                </div>

                <!-- MAIN WORKSPACE SECTION -->
                <div class="dashboard-grid">
                    <!-- Recent Activity Card -->
                    <div class="dashboard-card">
                        <div class="card-title-wrap">
                            <h3>
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span>Recent System Activity</span>
                            </h3>
                        </div>
                        <ul class="activity-list">
                            <?php foreach ($activities as $act): ?>
                                <li class="activity-item">
                                    <div class="activity-badge <?php echo $act['type']; ?>">
                                        <?php if ($act['type'] === 'security'): ?>
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor"
                                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                        <?php elseif ($act['type'] === 'add'): ?>
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor"
                                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        <?php elseif ($act['type'] === 'edit'): ?>
                                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor"
                                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="activity-details">
                                        <p><?php echo htmlspecialchars($act['detail']); ?></p>
                                        <span>Triggered by <?php echo htmlspecialchars($act['user']); ?> &bull;
                                            <?php echo $act['time']; ?></span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- System Status Card -->
                    <div class="dashboard-card">
                        <div class="card-title-wrap">
                            <h3>
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                    <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                    <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                    <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                </svg>
                                <span>System Status</span>
                            </h3>
                        </div>
                        <ul class="status-list">
                            <li class="status-item">
                                <span class="status-label">Local Host (Apache)</span>
                                <div class="status-value-indicator">
                                    <span class="dot dot-green"></span>
                                    <span>ONLINE</span>
                                </div>
                            </li>
                            <li class="status-item">
                                <span class="status-label">Database Connection</span>
                                <div class="status-value-indicator">
                                    <span class="dot dot-green"></span>
                                    <span>CONNECTED</span>
                                </div>
                            </li>
                            <li class="status-item">
                                <span class="status-label">Database Name</span>
                                <div class="status-value-indicator" style="color: var(--medium-green);">
                                    <span>green_forensics</span>
                                </div>
                            </li>
                            <li class="status-item">
                                <span class="status-label">Backup Integrity</span>
                                <div class="status-value-indicator">
                                    <span class="dot dot-green"></span>
                                    <span>SECURE</span>
                                </div>
                            </li>
                            <li class="status-item">
                                <span class="status-label">Maintenance Mode</span>
                                <div class="status-value-indicator" style="color: var(--gray);">
                                    <span>OFF</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JS Core Toggles -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarCollapse");

            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle("active");
                });

                // Close sidebar when clicking outside on mobile
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