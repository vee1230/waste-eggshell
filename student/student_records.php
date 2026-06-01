<?php
// student/student_records.php — View My Records & Reports
require_once '../config.php';
require_once 'auth.php';
check_student_auth();

$active_page  = 'student_records';
$student_name = $_SESSION['user_name'] ?? 'Student';
$student_id   = $_SESSION['user_id']  ?? 0;

// Filters
$filter_status  = $_GET['status']  ?? '';
$filter_powder  = $_GET['powder']  ?? '';
$filter_surface = $_GET['surface'] ?? '';

// Build query
$where = ['student_id = ?'];
$params = [$student_id];
if ($filter_status)  { $where[] = 'status = ?';       $params[] = $filter_status; }
if ($filter_powder)  { $where[] = 'powder_type = ?';  $params[] = $filter_powder; }
if ($filter_surface) { $where[] = 'surface_type = ?'; $params[] = $filter_surface; }

$records = [];
try {
    $sql = "SELECT * FROM fingerprint_tests WHERE " . implode(' AND ', $where) . " ORDER BY submitted_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="My Records &amp; Reports — Green Forensics">
    <title>Records &amp; Reports — Green Forensics</title>
    <link rel="stylesheet" href="../css/student_style.css?v=1.0">
    <style>
        .filter-bar { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.5rem; align-items:flex-end; }
        .filter-item { display:flex; flex-direction:column; gap:.3rem; }
        .filter-item label { font-size:.72rem; font-weight:700; color:var(--dark-green); text-transform:uppercase; letter-spacing:.4px; }
        .filter-item select { padding:.5rem .9rem; border:1px solid var(--light-gray); border-radius:8px; font-size:.85rem; color:var(--dark); background:var(--white); outline:none; transition:var(--transition); }
        .filter-item select:focus { border-color:var(--medium-green); box-shadow:0 0 0 3px rgba(45,106,79,.1); }
        @media print {
            .student-sidebar, .student-header, .filter-bar, .btn, .no-print { display:none !important; }
            .student-main { margin-left:0 !important; }
            .student-content { padding:0; }
        }
    </style>
</head>
<body>
<div class="student-wrapper">
    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:999;"
         onclick="this.style.display='none';document.getElementById('sidebar').classList.remove('active')"></div>

    <?php require_once '_sidebar.php'; ?>

    <main class="student-main">
        <header class="student-header">
            <div class="header-left">
                <button class="menu-toggle" id="sidebarCollapse" aria-label="Toggle sidebar">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="header-title"><h2>My Records &amp; Reports</h2></div>
            </div>
            <div class="header-right"><div class="header-role-chip">Criminology Student</div></div>
        </header>

        <div class="student-content">
            <div class="page-header-wrap">
                <div class="page-title">
                    <h1>View Records / Reports</h1>
                    <p>All your fingerprint trial submissions — filter and review anytime.</p>
                </div>
                <div style="display:flex;gap:.5rem;" class="no-print">
                    <button onclick="window.print()" class="btn btn-secondary">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                            <rect x="6" y="14" width="12" height="8"/>
                        </svg>
                        Print / Export
                    </button>
                    <a href="submit_trial.php" class="btn btn-primary">+ New Submission</a>
                </div>
            </div>

            <!-- Filters -->
            <form method="GET" class="filter-bar no-print">
                <div class="filter-item">
                    <label>Status</label>
                    <select name="status" id="filter-status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending"  <?= $filter_status==='pending'  ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $filter_status==='approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= $filter_status==='rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Powder Type</label>
                    <select name="powder" id="filter-powder" onchange="this.form.submit()">
                        <option value="">All Powders</option>
                        <option value="eggshell"   <?= $filter_powder==='eggshell'   ? 'selected' : '' ?>>Eggshell</option>
                        <option value="commercial" <?= $filter_powder==='commercial' ? 'selected' : '' ?>>Commercial</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Surface</label>
                    <select name="surface" id="filter-surface" onchange="this.form.submit()">
                        <option value="">All Surfaces</option>
                        <?php foreach (['glass','plastic','metal','paper','wood','ceramic','fabric'] as $s): ?>
                        <option value="<?= $s ?>" <?= $filter_surface===$s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if ($filter_status || $filter_powder || $filter_surface): ?>
                    <div class="filter-item" style="justify-content:flex-end;">
                        <label>&nbsp;</label>
                        <a href="student_records.php" class="btn btn-secondary btn-sm">Clear Filters</a>
                    </div>
                <?php endif; ?>
            </form>

            <!-- Records Table -->
            <div class="dashboard-card">
                <div class="card-title-wrap">
                    <h3>
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        All Submissions
                    </h3>
                    <span style="font-size:.82rem;color:var(--gray);"><?= count($records) ?> record<?= count($records) !== 1 ? 's' : '' ?></span>
                </div>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Powder Type</th>
                                <th>Surface Type</th>
                                <th>Accuracy Score</th>
                                <th>Score Bar</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Date Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center;color:#6c757d;padding:2.5rem;">
                                    No records found.
                                    <?php if (!$filter_status && !$filter_powder && !$filter_surface): ?>
                                        <a href="submit_trial.php" style="color:var(--medium-green);font-weight:600;">Submit your first trial →</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($records as $i => $r): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td style="text-transform:capitalize;"><?= htmlspecialchars($r['powder_type']) ?></td>
                                <td style="text-transform:capitalize;"><?= htmlspecialchars($r['surface_type']) ?></td>
                                <td><strong><?= number_format($r['accuracy_score'], 1) ?>%</strong></td>
                                <td style="min-width:120px;">
                                    <div class="score-bar">
                                        <div class="score-bar-track">
                                            <div class="score-bar-fill" style="width:<?= min(100,$r['accuracy_score']) ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                                <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:.8rem;color:var(--gray);">
                                    <?= htmlspecialchars($r['notes'] ?: '—') ?>
                                </td>
                                <td><?= date('M d, Y', strtotime($r['submitted_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
<?php require_once '_sidebar_js.php'; ?>
</body>
</html>
