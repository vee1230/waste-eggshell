<?php
// admin/admin_records.php - Super Administrator Records Management
require_once "../config.php";
require_once "auth.php";

// Enforce admin authentication
check_admin_auth();

// Mock forensic trial records for Green Forensics Evaluating System
$records = [
    [
        'id' => 1001,
        'image' => 'egg_powder_glass_01.jpg',
        'surface' => 'Glass',
        'powder' => 'Eggshell Powder',
        'accuracy' => 94,
        'quality' => 'Excellent',
        'date' => '2026-05-26 10:15:32'
    ],
    [
        'id' => 1002,
        'image' => 'comm_powder_glass_01.jpg',
        'surface' => 'Glass',
        'powder' => 'Commercial Carbon',
        'accuracy' => 88,
        'quality' => 'Very Good',
        'date' => '2026-05-26 09:40:11'
    ],
    [
        'id' => 1003,
        'image' => 'egg_powder_steel_02.jpg',
        'surface' => 'Stainless Steel',
        'powder' => 'Eggshell Powder',
        'accuracy' => 91,
        'quality' => 'Excellent',
        'date' => '2026-05-25 15:22:45'
    ],
    [
        'id' => 1004,
        'image' => 'egg_powder_wood_01.jpg',
        'surface' => 'Varnished Wood',
        'powder' => 'Eggshell Powder',
        'accuracy' => 85,
        'quality' => 'Good',
        'date' => '2026-05-25 11:05:19'
    ],
    [
        'id' => 1005,
        'image' => 'comm_powder_wood_01.jpg',
        'surface' => 'Varnished Wood',
        'powder' => 'Commercial Carbon',
        'accuracy' => 78,
        'quality' => 'Fair',
        'date' => '2026-05-24 16:30:00'
    ],
    [
        'id' => 1006,
        'image' => 'egg_powder_plastic_01.jpg',
        'surface' => 'Acrylic Plastic',
        'powder' => 'Eggshell Powder',
        'accuracy' => 93,
        'quality' => 'Excellent',
        'date' => '2026-05-24 14:18:22'
    ],
    [
        'id' => 1007,
        'image' => 'comm_powder_plastic_01.jpg',
        'surface' => 'Acrylic Plastic',
        'powder' => 'Commercial Carbon',
        'accuracy' => 86,
        'quality' => 'Very Good',
        'date' => '2026-05-24 13:55:04'
    ],
    [
        'id' => 1008,
        'image' => 'egg_powder_paper_01.jpg',
        'surface' => 'Cardboard Paper',
        'powder' => 'Eggshell Powder',
        'accuracy' => 82,
        'quality' => 'Good',
        'date' => '2026-05-23 10:44:12'
    ]
];

// Handle search and filtering
$search_surface = isset($_GET["surface"]) ? trim($_GET["surface"]) : "";
$filter_powder = isset($_GET["powder"]) ? trim($_GET["powder"]) : "";

$filtered_records = [];
foreach ($records as $rec) {
    $matches_surface = empty($search_surface) || (stripos($rec['surface'], $search_surface) !== false);
    $matches_powder = empty($filter_powder) || ($rec['powder'] === $filter_powder);

    if ($matches_surface && $matches_powder) {
        $filtered_records[] = $rec;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records Management - Green Forensics</title>
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
                <li class="menu-item active">
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
                        <h1>Forensic Trial Records</h1>
                        <p>Detailed evaluation database of latent fingerprint powder clarity, accuracy scores, and image
                            metadata.</p>
                    </div>
                </div>

                <!-- SEARCH AND FILTERS -->
                <div class="dashboard-card" style="margin-bottom: 1.5rem; padding: 1.25rem;">
                    <form method="GET" action="admin_records.php" class="search-filter-bar">
                        <div class="bar-left">
                            <input type="text" name="surface" class="form-control-inline"
                                placeholder="Filter by Surface (e.g. Glass)"
                                value="<?php echo htmlspecialchars($search_surface); ?>" style="min-width: 250px;">
                            <select name="powder" class="form-control-inline">
                                <option value="">All Powder Types</option>
                                <option value="Eggshell Powder" <?php echo $filter_powder === 'Eggshell Powder' ? 'selected' : ''; ?>>Eggshell Powder</option>
                                <option value="Commercial Carbon" <?php echo $filter_powder === 'Commercial Carbon' ? 'selected' : ''; ?>>Commercial Carbon</option>
                            </select>
                            <button type="submit" class="btn btn-secondary">Filter Records</button>
                            <?php if (!empty($search_surface) || !empty($filter_powder)): ?>
                                <a href="admin_records.php" class="btn btn-secondary btn-sm" style="border: none;">Clear
                                    Filters</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- RECORDS TABLE -->
                <div class="dashboard-card">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Trial ID</th>
                                    <th>Fingerprint Image</th>
                                    <th>Surface Type</th>
                                    <th>Powder Used</th>
                                    <th>Accuracy Score</th>
                                    <th>Quality Rating</th>
                                    <th>Date Evaluated</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($filtered_records) > 0): ?>
                                    <?php foreach ($filtered_records as $rec): ?>
                                        <tr>
                                            <td style="font-weight: 700; color: var(--gray);">#<?php echo $rec['id']; ?></td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <!-- Mock Thumbnail Image Container -->
                                                    <div
                                                        style="width: 32px; height: 32px; border-radius: 4px; background: #e9ecef; border: 1px solid var(--light-gray); display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: 700; color: var(--medium-green); overflow: hidden;">
                                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                                        </svg>
                                                    </div>
                                                    <span
                                                        style="font-family: monospace; font-size: 0.75rem; color: var(--dark-green);"><?php echo $rec['image']; ?></span>
                                                </div>
                                            </td>
                                            <td style="font-weight: 600;"><?php echo htmlspecialchars($rec['surface']); ?></td>
                                            <td>
                                                <span
                                                    style="color: <?php echo ($rec['powder'] === 'Eggshell Powder') ? 'var(--medium-green)' : 'var(--gray)'; ?>; font-weight: 600;">
                                                    <?php echo $rec['powder']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div style="display:flex; align-items:center; gap:0.5rem;">
                                                    <div
                                                        style="width: 50px; background-color: var(--light-gray); height: 6px; border-radius: 3px; overflow:hidden;">
                                                        <div
                                                            style="width: <?php echo $rec['accuracy']; ?>%; height: 100%; background-color: <?php echo ($rec['accuracy'] >= 90) ? 'var(--medium-green)' : (($rec['accuracy'] >= 80) ? 'var(--accent-green)' : 'var(--warning)'); ?>;">
                                                        </div>
                                                    </div>
                                                    <span
                                                        style="font-weight: 700; color: var(--dark-green);"><?php echo $rec['accuracy']; ?>%</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-<?php echo ($rec['quality'] === 'Excellent' || $rec['quality'] === 'Very Good') ? 'success' : 'warning'; ?>">
                                                    <?php echo $rec['quality']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($rec['date'])); ?></td>
                                            <td style="text-align: right;">
                                                <button class="btn btn-secondary btn-sm"
                                                    onclick="alert('Viewing original fingerprint record #<?php echo $rec['id']; ?>... [Awaiting Latent Image Viewer API]')">
                                                    <span>View Details</span>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; color: var(--gray); padding: 2rem;">No
                                            trial records match filter options.</td>
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