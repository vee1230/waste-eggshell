<?php
// admin/admin_reports.php - Super Administrator Reports Management
require_once "../config.php";
require_once "auth.php";

// Enforce admin authentication
check_admin_auth();

// Mock generated forensic reports list
$reports = [
    [
        'id' => 'RPT-2026-005',
        'title' => 'Green Forensics Monthly Evaluation Report - May 2026',
        'date' => '2026-05-26 11:00:00',
        'status' => 'Available',
        'size' => '1.8 MB'
    ],
    [
        'id' => 'RPT-2026-004',
        'title' => 'Eggshell Powder vs Carbon Black Forensic Clarity Comparative Study',
        'date' => '2026-05-20 14:30:15',
        'status' => 'Available',
        'size' => '3.4 MB'
    ],
    [
        'id' => 'RPT-2026-003',
        'title' => 'Latent Fingerprint Extraction Accuracy Scores on Non-Porous Surfaces',
        'date' => '2026-05-12 09:15:00',
        'status' => 'Available',
        'size' => '2.1 MB'
    ],
    [
        'id' => 'RPT-2026-002',
        'title' => 'Quarter 1 Sustainable Fingerprint Powder Performance Assessment',
        'date' => '2026-04-15 16:45:10',
        'status' => 'Available',
        'size' => '4.2 MB'
    ],
    [
        'id' => 'RPT-2026-001',
        'title' => 'Biometric Quality Score Summary & Ridge Count Validation',
        'date' => '2026-03-22 10:20:00',
        'status' => 'Archived',
        'size' => '2.9 MB'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Management - Green Forensics</title>
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
                <li class="menu-item active">
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
                        <h1>System & Evaluation Reports</h1>
                        <p>Generate, view, and download comprehensive statistical analysis reports for sustainable
                            powder trials.</p>
                    </div>
                    <div>
                        <button class="btn btn-primary"
                            onclick="alert('Running Green Forensics automated report compiler... Success! Report compiled and queued.')">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <span>Compile New Report</span>
                        </button>
                    </div>
                </div>

                <!-- REPORTS LIST TABLE -->
                <div class="dashboard-card">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Report Title</th>
                                    <th>Date Generated</th>
                                    <th>File Size</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Download Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $rpt): ?>
                                    <tr>
                                        <td style="font-family: monospace; font-weight: 700; color: var(--gray);">
                                            <?php echo $rpt['id']; ?></td>
                                        <td style="font-weight: 600; color: var(--dark-green);">
                                            <?php echo htmlspecialchars($rpt['title']); ?></td>
                                        <td><?php echo date('M d, Y h:i A', strtotime($rpt['date'])); ?></td>
                                        <td><?php echo $rpt['size']; ?></td>
                                        <td>
                                            <span
                                                class="badge badge-<?php echo ($rpt['status'] === 'Available') ? 'success' : 'inactive'; ?>">
                                                <?php echo $rpt['status']; ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div class="btn-group" style="justify-content: flex-end;">
                                                <button class="btn btn-secondary btn-sm"
                                                    onclick="alert('Opening Web Preview of report: <?php echo htmlspecialchars($rpt['title'], ENT_QUOTES); ?>')">
                                                    <span>View</span>
                                                </button>
                                                <button class="btn btn-primary btn-sm"
                                                    onclick="alert('Downloading compiled PDF report (<?php echo $rpt['id']; ?>.pdf) to local downloads... Done!')">
                                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none"
                                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                        stroke-linejoin="round" style="margin-right: 2px;">
                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                        <polyline points="7 10 12 15 17 10"></polyline>
                                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                                    </svg>
                                                    <span>PDF</span>
                                                </button>
                                            </div>
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