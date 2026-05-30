<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$target_link = "login.php";
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    if (isset($_SESSION["user_email"]) && ($_SESSION["user_email"] === 'admin@greenforensics.com' || $_SESSION["user_email"] === 'admin@greenforensics.edu.ph')) {
        $target_link = "admin/admin_dashboard.php";
    } else {
        $target_link = "dashboard.php";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Forensics - Sustainable Fingerprint Powder (Mobile)</title>
    <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/mobile.css?v=<?= time() ?>">
    <!-- GSAP, ScrollTrigger, and ScrollToPlugin CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollToPlugin.min.js"></script>
    <script>
        if (window.innerWidth > 768) {
            window.location.replace("deskstop.php");
        }
    </script>
</head>

<body>
    <!-- Intro Loader Popup -->
    <div id="introLoader">
        <div class="intro-loader-content">
            <div class="intro-product-wrap" style="height: 250px; width: 250px; margin-bottom: 1.5rem;">
                <!-- Empty space for the single mainProductVisual jar to be positioned and animated smoothly -->
            </div>

            <div class="intro-text">
                <span class="intro-label">GREEN Technology</span>
                <h1>Eco Fingerprint Powder</h1>
                <p>Sustainable Fingerprint Powder Using Chicken Eggshell Waste</p>
            </div>
        </div>
    </div>

    <!-- Floating Particles Background -->
    <div class="particles-container" id="particles"></div>

    <!-- Main Product Visual Container (Fixed & Controlled by GSAP) -->
    <div id="mainProductVisual">
        <!-- Premium Glass Jar Image -->
        <div class="product-jar">
            <div class="jar-shadow"></div>
            <img src="images/eco-powder-jar.png" alt="Eco Fingerprint Powder" class="jar-image">
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="container hero-container-layout">
            <div class="hero-content">
                <div class="hero-label">INNOVATIVE FORENSIC SCIENCE</div>
                <h1 class="hero-title">
                    <span class="title-line">GREEN</span>
                    <span class="title-line">FORENSICS</span>
                </h1>
                <p class="hero-subtitle">Sustainable Fingerprint Powder Using Chicken Eggshell Waste</p>
                <a href="<?php echo $target_link; ?>" class="hero-btn">
                    <span>Access Evaluating System</span>
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Floating forensic elements -->
        <div class="floating-elements">
            <div class="float-element fingerprint-mark"></div>
            <div class="float-element grid-line"></div>
            <div class="float-element eggshell-piece"></div>
        </div>
    </section>

    <!-- Problem Section -->
    <section class="problem-section" id="problem">
        <div class="container">
            <div class="section-header-left">
                <span class="section-label">The Challenge</span>
                <h2 class="section-title">Traditional Methods <span class="highlight">Are Harmful</span></h2>
                <p class="section-description-main">Traditional carbon black and heavy-metal based forensic dusting
                    powders contain carcinogenic, hazardous chemicals that pose acute health risks to forensic
                    practitioners and contaminate active crime scene ecosystems.</p>
            </div>

            <div class="problem-content">
                <!-- Upgraded: Visual Problem Cards Column -->
                <div class="problem-cards-container">
                    <!-- Card 1: Harmful Chemicals -->
                    <div class="problem-card">
                        <div class="card-icon-box">
                            <!-- Warning Triangle SVG -->
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Harmful Chemicals</h3>
                            <p class="card-desc">Conventional powders rely on toxic heavy metals like <strong>lead,
                                    mercury, and carbon black</strong>, introducing volatile organic hazards to active
                                crime scenes.</p>
                        </div>
                    </div>

                    <!-- Card 2: Health Risks -->
                    <div class="problem-card">
                        <div class="card-icon-box">
                            <!-- Heart SVG -->
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Health Risks</h3>
                            <p class="card-desc">Daily inhalation of <strong>ultra-fine synthetic dust
                                    particles</strong> poses chronic respiratory hazards and long-term carcinogen
                                exposure for forensic experts.</p>
                        </div>
                    </div>

                    <!-- Card 3: Environmental Concerns -->
                    <div class="problem-card">
                        <div class="card-icon-box">
                            <!-- Globe SVG -->
                            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10M12 2a15.3 15.3 0 0 0-4 10 15.3 15.3 0 0 0 4 10M2 12h20" />
                            </svg>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Environmental Concerns</h3>
                            <p class="card-desc">Mass production and chemical runoff of <strong>non-biodegradable
                                    petroleum-based dusting agents</strong> accumulate in ecosystems, harming soil and
                                water grids.</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Jar Space with high-tech Pedestal and Warning Badges -->
                <div class="problem-jar-space" aria-hidden="true">
                    <!-- Glowing Forensic Pedestal -->
                    <div class="jar-landing-pedestal">
                        <div class="pedestal-glow"></div>
                        <div class="pedestal-ring pedestal-ring-1"></div>
                        <div class="pedestal-ring pedestal-ring-2"></div>
                        <div class="pedestal-ring pedestal-ring-3"></div>
                        <div class="pedestal-plate"></div>
                        <div class="pedestal-scanner"></div>
                        <div class="pedestal-label">
                            <span class="pulse-dot"></span>
                            <span>SAFETY STORAGE TARGET</span>
                        </div>
                    </div>

                    <!-- Floating Hazard Warning Badges -->
                    <div class="jar-warning-badge badge-unsafe" style="top: 15%; left: 8%;">
                        <span class="warning-pulse-dot"></span>
                        <span>UNSAFE TOXINS</span>
                    </div>
                    <div class="jar-warning-badge badge-costly" style="top: 48%; left: -6%;">
                        <span class="warning-pulse-dot"></span>
                        <span>COSTLY HAZARDS</span>
                    </div>
                    <div class="jar-warning-badge badge-unsustainable" style="bottom: 15%; right: 4%;">
                        <span class="warning-pulse-dot"></span>
                        <span>UNSUSTAINABLE</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solution Section / Our Process -->
    <section class="solution-section" id="solution">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Our Process</span>
                <h2 class="section-title">From Waste to<br>Forensic Innovation</h2>
                <p class="section-subtitle">A sustainable four-step transformation process that converts organic waste
                    into cutting-edge forensic technology.</p>
            </div>

            <div class="process-timeline">
                <!-- Step 1 -->
                <div class="process-step" data-step="1">
                    <span class="step-number">01</span>
                    <div class="step-image-wrap">
                        <img src="images/eggshell-waste.png" alt="Eggshell Waste" class="step-img">
                    </div>
                    <h3 class="step-title">Eggshell Waste</h3>
                    <p class="step-desc">Collection of organic chicken eggshells from the local food industry.</p>
                </div>

                <div class="process-arrow">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </div>

                <!-- Step 2 -->
                <div class="process-step" data-step="2">
                    <span class="step-number">02</span>
                    <div class="step-image-wrap">
                        <img src="images/clean-dry.png" alt="Cleaned & Dried" class="step-img">
                    </div>
                    <h3 class="step-title">Cleaned & Dried</h3>
                    <p class="step-desc">Thorough sanitization, chemical washing, and high-temperature oven drying.</p>
                </div>

                <div class="process-arrow">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </div>

                <!-- Step 3 -->
                <div class="process-step" data-step="3">
                    <span class="step-number">03</span>
                    <div class="step-image-wrap">
                        <img src="images/crushed-powder.png" alt="Fine Powder" class="step-img">
                    </div>
                    <h3 class="step-title">Fine Powder</h3>
                    <p class="step-desc">Mechanical ball-milling pulverization to achieve sub-micron forensic-grade
                        fineness.</p>
                </div>

                <div class="process-arrow">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </div>

                <!-- Step 4 (Landed Target Slot) -->
                <div class="process-step process-final-card" id="processFinalJarTarget" data-step="4">
                    <span class="step-number">04</span>
                    <div class="step-image-wrap">
                        <!-- Empty placeholder target slot for the main dynamic jar (#mainProductVisual) -->
                    </div>
                    <h3 class="step-title">Certified Solution</h3>
                    <p class="step-desc">High-contrast, non-toxic, and biodegradable latent print developing powder
                        ready for field work.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Fingerprint Application Section -->
    <section class="fingerprint-section" id="fingerprint">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Forensic Application</span>
                <h2 class="section-title">Latent Print Development</h2>
            </div>

            <div class="fingerprint-demo">
                <div class="demo-left-column">
                    <div class="demo-surface">
                        <span class="surface-label">Glass Surface</span>

                        <!-- Fingerprint SVG that reveals on scroll -->
                        <svg class="fingerprint-reveal" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <mask id="fingerprintMask">
                                    <rect width="200" height="0" fill="white" id="maskRect" />
                                </mask>
                            </defs>
                            <g mask="url(#fingerprintMask)">
                                <!-- Fingerprint ridges -->
                                <ellipse cx="100" cy="100" rx="70" ry="85" fill="none" stroke="var(--dark-green)"
                                    stroke-width="2.5" opacity="0.9" />
                                <ellipse cx="100" cy="100" rx="60" ry="75" fill="none" stroke="var(--soft-green)"
                                    stroke-width="2.5" opacity="0.9" />
                                <ellipse cx="100" cy="100" rx="50" ry="65" fill="none" stroke="var(--soft-green)"
                                    stroke-width="2.5" opacity="0.9" />
                                <ellipse cx="100" cy="100" rx="40" ry="55" fill="none" stroke="var(--soft-green)"
                                    stroke-width="2.5" opacity="0.9" />
                                <ellipse cx="100" cy="100" rx="30" ry="45" fill="none" stroke="var(--soft-green)"
                                    stroke-width="2.5" opacity="0.9" />
                                <ellipse cx="100" cy="100" rx="20" ry="35" fill="none" stroke="var(--soft-green)"
                                    stroke-width="2.5" opacity="0.9" />
                                <ellipse cx="100" cy="100" rx="10" ry="25" fill="none" stroke="var(--soft-green)"
                                    stroke-width="2.5" opacity="0.9" />
                            </g>
                        </svg>

                        <!-- Powder particles spreading -->
                        <div class="powder-spread">
                            <div class="powder-dot"></div>
                            <div class="powder-dot"></div>
                            <div class="powder-dot"></div>
                            <div class="powder-dot"></div>
                            <div class="powder-dot"></div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h4>Effectiveness</h4>
                        <p>Comparable results to commercial powders on glass, paper, and wood surfaces</p>
                    </div>
                </div>

                <div class="demo-right-column demo-info">
                    <div class="info-card">
                        <h4>Application Method</h4>
                        <p>Eggshell powder is gently brushed onto surfaces containing latent fingerprints</p>
                    </div>
                    <div class="info-card">
                        <h4>Visibility</h4>
                        <p>Fine calcium carbonate particles adhere to oils and residues, revealing ridge patterns</p>
                    </div>

                    <!-- Camera Capture Interface Card -->
                    <div class="camera-capture-card">
                        <div class="camera-card-header">
                            <span class="card-badge">INPUT DEVICE</span>
                            <h3>Latent Print Capture</h3>
                            <p>Capture or upload the developed latent fingerprint for Python evaluation.</p>
                        </div>

                        <div class="camera-view-container">
                            <video id="cameraStream" autoplay playsinline class="camera-video"
                                style="display: none;"></video>
                            <canvas id="photoPreviewCanvas" class="photo-preview-canvas"
                                style="display: none;"></canvas>
                            <div id="cameraPlaceholder" class="camera-placeholder">
                                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    class="placeholder-icon">
                                    <path
                                        d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                    </path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                                <p>Camera Preview / Uploaded Image</p>
                                <span class="placeholder-subtext">No media source active</span>
                            </div>

                            <!-- Glowing scanner line during analysis simulation -->
                            <div id="analysisScannerLine" class="analysis-scanner-line" style="display: none;"></div>
                        </div>

                        <div class="camera-controls">
                            <!-- Toggle Video Stream -->
                            <button type="button" id="btnToggleCamera" class="camera-btn secondary-btn">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                    </path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                                <span>Start Camera</span>
                            </button>

                            <!-- Capture Snapshot (only visible when video is streaming) -->
                            <button type="button" id="btnCapturePhoto" class="camera-btn primary-btn"
                                style="display: none;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>Capture Photo</span>
                            </button>

                            <!-- File Upload (Alternative) -->
                            <button type="button" id="btnUploadTrigger" class="camera-btn outline-btn">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <span>Upload File</span>
                            </button>
                            <input type="file" id="cameraFileInput" accept="image/*" capture="environment"
                                style="display: none;">
                        </div>

                        <!-- Analysis Action Button -->
                        <button type="button" id="btnStartEvaluation" class="evaluate-action-btn" disabled>
                            <span>EVALUATE PRINT CLARITY</span>
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 11 12 14 22 4"></polyline>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                        </button>

                        <!-- Simulation Result Display -->
                        <div id="evaluationResultContainer" class="evaluation-result-card" style="display: none;">
                            <div class="result-status-header">
                                <span class="pulse-dot-green"></span>
                                <h4>PYTHON ANALYSIS RESULT</h4>
                            </div>
                            <div class="result-metrics">
                                <div class="result-metric-item">
                                    <span class="label">Ridge Contrast</span>
                                    <span id="metricRidgeContrast" class="value">--</span>
                                </div>
                                <div class="result-metric-item">
                                    <span class="label">Minutiae Points</span>
                                    <span id="metricMinutiae" class="value">--</span>
                                </div>
                                <div class="result-metric-item">
                                    <span class="label">Clarity Rating</span>
                                    <span id="metricClarityRating" class="value-large">--</span>
                                </div>
                            </div>
                            <p id="evaluationFeedback" class="result-feedback-text"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section" id="benefits">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Impact & Advantages</span>
                <h2 class="section-title">Why It Matters</h2>
            </div>

            <div class="benefits-accordion">
                <div class="benefit-accordion-item">
                    <button class="benefit-accordion-trigger" type="button">
                        <span class="benefit-accordion-title">Eco-Friendly &amp; Biodegradable</span>
                        <svg class="benefit-accordion-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="benefit-accordion-body">
                        <p>Natural calcium carbonate breaks down safely without environmental harm</p>
                    </div>
                </div>

                <div class="benefit-accordion-item">
                    <button class="benefit-accordion-trigger" type="button">
                        <span class="benefit-accordion-title">Cost-Effective Alternative</span>
                        <svg class="benefit-accordion-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="benefit-accordion-body">
                        <p>Utilizes waste material, reducing production costs significantly</p>
                    </div>
                </div>

                <div class="benefit-accordion-item">
                    <button class="benefit-accordion-trigger" type="button">
                        <span class="benefit-accordion-title">Safer for Forensic Users</span>
                        <svg class="benefit-accordion-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="benefit-accordion-body">
                        <p>Non-toxic composition eliminates health risks from heavy metals</p>
                    </div>
                </div>

                <div class="benefit-accordion-item">
                    <button class="benefit-accordion-trigger" type="button">
                        <span class="benefit-accordion-title">Supports Waste Reduction</span>
                        <svg class="benefit-accordion-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="benefit-accordion-body">
                        <p>Transforms food industry waste into valuable forensic resource</p>
                    </div>
                </div>

                <div class="benefit-accordion-item">
                    <button class="benefit-accordion-trigger" type="button">
                        <span class="benefit-accordion-title">Criminology Training Tool</span>
                        <svg class="benefit-accordion-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="benefit-accordion-body">
                        <p>Ideal for educational institutions and student practice</p>
                    </div>
                </div>

                <div class="benefit-accordion-item">
                    <button class="benefit-accordion-trigger" type="button">
                        <span class="benefit-accordion-title">Supports SDG 12 &amp; 13</span>
                        <svg class="benefit-accordion-chevron" viewBox="0 0 24 24" width="18" height="18" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="benefit-accordion-body">
                        <p>Aligns with sustainable consumption and climate action goals</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Implementation Timeline Section -->
    <section class="timeline-section" id="timeline">
        <div class="container-full">
            <div class="section-header">
                <span class="section-label">Roadmap</span>
                <h2 class="section-title">Project Implementation</h2>
            </div>

            <div class="timeline-container">
                <div class="timeline-track">
                    <div class="timeline-item" data-phase="1">
                        <div class="timeline-content">
                            <div class="timeline-card-header">
                                <span class="phase-badge">Phase 01</span>
                                <span class="timeline-duration">Month 1-3</span>
                            </div>
                            <h3>Research &amp; Planning</h3>
                            <p>Team organization, budget mapping, and primary raw material extraction</p>
                        </div>
                    </div>

                    <div class="timeline-item" data-phase="2">
                        <div class="timeline-content">
                            <div class="timeline-card-header">
                                <span class="phase-badge">Phase 02</span>
                                <span class="timeline-duration">Month 4-6</span>
                            </div>
                            <h3>Curriculum Integration</h3>
                            <p>Criminology course module updates and forensic lab manual guides</p>
                        </div>
                    </div>

                    <div class="timeline-item" data-phase="3">
                        <div class="timeline-content">
                            <div class="timeline-card-header">
                                <span class="phase-badge">Phase 03</span>
                                <span class="timeline-duration">Month 7-9</span>
                            </div>
                            <h3>Community Extension</h3>
                            <p>Local police department training, field testing, and forensic workshops</p>
                        </div>
                    </div>

                    <div class="timeline-item" data-phase="4">
                        <div class="timeline-content">
                            <div class="timeline-card-header">
                                <span class="phase-badge">Phase 04</span>
                                <span class="timeline-duration">Month 10+</span>
                            </div>
                            <h3>Monitoring &amp; Sustainability</h3>
                            <p>Quality testing feedback loop, policy recommendations, and expansions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Expected Results Section -->
    <section class="results-section" id="results">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Outcomes</span>
                <h2 class="section-title">Expected Impact</h2>
            </div>

            <div class="results-grid">
                <!-- Result Item 1: Clarity -->
                <div class="result-card clarity-card">
                    <div class="result-header">
                        <div class="metric-num-wrap">
                            <span class="metric-num" data-val="95">0</span><span class="percent-sign">%</span>
                        </div>
                        <span class="metric-unit">Clarity</span>
                    </div>
                    <div class="metric-bar-container">
                        <div class="metric-bar-fill" style="width: 0%"></div>
                    </div>
                    <h3>Forensic Quality</h3>
                    <p>High contrast ridge development on non-porous surfaces compared to carbon powder.</p>
                </div>

                <!-- Result Item 2: Toxicity -->
                <div class="result-card toxicity-card">
                    <div class="result-header">
                        <div class="metric-num-wrap">
                            <span class="metric-num" data-val="0">100</span><span class="percent-sign">%</span>
                        </div>
                        <span class="metric-unit">Toxicity</span>
                    </div>
                    <div class="metric-bar-container toxicity">
                        <div class="metric-bar-fill" style="width: 100%"></div>
                    </div>
                    <h3>Hazard Reduction</h3>
                    <p>Complete elimination of toxic metal inhalation risk for student researchers.</p>
                </div>

                <!-- Result Item 3: Recycled -->
                <div class="result-card recycled-card">
                    <div class="result-header">
                        <div class="metric-num-wrap">
                            <span class="metric-num" data-val="100">0</span><span class="percent-sign">%</span>
                        </div>
                        <span class="metric-unit">Recycled</span>
                    </div>
                    <div class="metric-bar-container">
                        <div class="metric-bar-fill" style="width: 0%"></div>
                    </div>
                    <h3>Circular Economy</h3>
                    <p>Repurposing agricultural waste to reduce local landfill footprint and processing costs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Stakeholders Section -->
    <section class="stakeholders-section" id="stakeholders">
        <div class="container">
            <div class="section-header">
                <span class="section-label">Collaboration</span>
                <h2 class="section-title">Project Stakeholders</h2>
            </div>

            <div class="stakeholders-network">
                <!-- Card 1 -->
                <div class="stakeholder-card" data-role="proponent">
                    <span class="card-number">01</span>
                    <div class="card-content">
                        <h3>LSPU CCJE</h3>
                        <p>Project proponent, lead researchers, and criminology faculty steering commit</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="stakeholder-card" data-role="partner">
                    <span class="card-number">02</span>
                    <div class="card-content">
                        <h3>Local Bakeries</h3>
                        <p>Primary suppliers providing clean chicken eggshell waste materials</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="stakeholder-card" data-role="partner">
                    <span class="card-number">03</span>
                    <div class="card-content">
                        <h3>San Pablo Police</h3>
                        <p>Law enforcement end-users assisting in validation and feedback loops</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="stakeholder-card" data-role="beneficiary">
                    <span class="card-number">04</span>
                    <div class="card-content">
                        <h3>Criminology Students</h3>
                        <p>Active participation, learning, and skill development</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="stakeholder-card" data-role="support">
                    <span class="card-number">05</span>
                    <div class="card-content">
                        <h3>Support Staff</h3>
                        <p>Laboratory maintenance and technical assistance</p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="stakeholder-card" data-role="community">
                    <span class="card-number">06</span>
                    <div class="card-content">
                        <h3>Community & Law Enforcement</h3>
                        <p>External collaboration and real-world application</p>
                    </div>
                </div>

                <!-- Card 7 -->
                <div class="stakeholder-card" data-role="committee">
                    <span class="card-number">07</span>
                    <div class="card-content">
                        <h3>Project Committee</h3>
                        <p>Monitoring, evaluation, and sustainability planning</p>
                    </div>
                </div>
            </div>

            <!-- Stakeholders Footer Decoration -->
            <div class="stakeholders-footer">
                <hr class="footer-divider">
                <div class="footer-meta">
                    <span class="meta-left">SEVEN PILLARS — ONE MISSION</span>
                    <span class="meta-right">01 — 07</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Green Forensics Project | LSPU CCJE San Pablo City Campus</p>
            <p>Sustainable Innovation in Criminal Justice Education</p>
        </div>
    </footer>

    <!-- Biometric Scan Transition Overlay -->
    <div id="scanOverlay" class="scan-overlay">
        <div class="scan-content">
            <div class="scanner-ring">
                <svg class="fingerprint-scan-icon" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="100" cy="100" rx="70" ry="85" fill="none" stroke="var(--dark-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                    <ellipse cx="100" cy="100" rx="60" ry="75" fill="none" stroke="var(--soft-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                    <ellipse cx="100" cy="100" rx="50" ry="65" fill="none" stroke="var(--soft-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                    <ellipse cx="100" cy="100" rx="40" ry="55" fill="none" stroke="var(--soft-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                    <ellipse cx="100" cy="100" rx="30" ry="45" fill="none" stroke="var(--soft-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                    <ellipse cx="100" cy="100" rx="20" ry="35" fill="none" stroke="var(--soft-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                    <ellipse cx="100" cy="100" rx="10" ry="25" fill="none" stroke="var(--soft-green)" stroke-width="3"
                        stroke-linecap="round" class="scan-ridge" />
                </svg>
                <div class="scanner-bar"></div>
            </div>
            <div class="scan-text">Scanning Biometrics...</div>
        </div>
    </div>

    <script src="mobile.js?v=<?= time() ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Accordion click handler (inline failsafe against JS caching)
            const triggers = document.querySelectorAll('.benefit-accordion-trigger');
            triggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    const item = trigger.closest('.benefit-accordion-item');
                    const isOpen = item.classList.contains('is-open');

                    // Close all items first (single-open behavior)
                    document.querySelectorAll('.benefit-accordion-item.is-open').forEach(openItem => {
                        openItem.classList.remove('is-open');
                    });

                    // Open if not already open
                    if (!isOpen) {
                        item.classList.add('is-open');
                    }
                });
            });

            // ==========================================================================
            // EXPECTED RESULTS SCROLL ANIMATIONS (Bulletproof in-view Check & Fallback)
            // ==========================================================================
            if (typeof gsap !== 'undefined') {
                const resultsGrid = document.querySelector(".results-grid");

                const triggerAnimation = () => {
                    document.querySelectorAll(".result-card").forEach((card, idx) => {
                        // Fade & Slide up card
                        gsap.to(card, {
                            opacity: 1,
                            y: 0,
                            duration: 0.7,
                            delay: idx * 0.12,
                            ease: "power2.out"
                        });

                        const fill = card.querySelector(".metric-bar-fill");
                        const numSpan = card.querySelector(".metric-num");
                        if (!numSpan) return;

                        const targetVal = parseInt(numSpan.getAttribute("data-val"));

                        // 1. Animate Progress Bar Width
                        if (fill) {
                            setTimeout(() => {
                                if (card.classList.contains("toxicity-card")) {
                                    fill.style.setProperty('width', '0%', 'important');
                                } else {
                                    fill.style.setProperty('width', targetVal + '%', 'important');
                                }
                            }, 100 + (idx * 120));
                        }

                        // 2. Count Number Animation
                        let startVal = card.classList.contains("toxicity-card") ? 100 : 0;
                        let endVal = targetVal;
                        let obj = { val: startVal };

                        gsap.to(obj, {
                            val: endVal,
                            duration: 1.6,
                            delay: idx * 0.12,
                            ease: "power2.out",
                            onUpdate: () => {
                                numSpan.textContent = Math.round(obj.val);
                            }
                        });
                    });
                };

                // Check if already in viewport (e.g. refreshed page while scrolled down)
                if (resultsGrid) {
                    const rect = resultsGrid.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        // In view on load - animate immediately!
                        triggerAnimation();
                    } else {
                        // Out of view - hide first, then animate on scroll trigger
                        gsap.set(".result-card", { opacity: 0, y: 30 });

                        ScrollTrigger.create({
                            trigger: ".results-grid",
                            start: "top 92%",
                            once: true,
                            onEnter: () => {
                                triggerAnimation();
                            }
                        });
                    }
                }
            }

            const heroBtn = document.querySelector(".hero-btn");
            const scanOverlay = document.getElementById("scanOverlay");

            if (heroBtn && scanOverlay) {
                heroBtn.addEventListener("click", (e) => {
                    e.preventDefault();
                    const targetUrl = heroBtn.getAttribute("href");

                    // Show overlay and start transition animation
                    scanOverlay.classList.add("active");

                    const tl = gsap.timeline({
                        onComplete: () => {
                            window.location.href = targetUrl;
                        }
                    });

                    // Reset ridges state for drawing
                    gsap.set(".scan-ridge", { strokeDasharray: 600, strokeDashoffset: 600 });

                    // 1. Draw fingerprint ridges in a beautiful staggered sequence (takes approx 2.76s to finish all ridges)
                    tl.to(".scan-ridge", {
                        strokeDashoffset: 0,
                        duration: 2.4,
                        stagger: 0.06,
                        ease: "power2.out"
                    });

                    // 2. Scan animation bar sweeping down & up 2 times (duration 1.3s * 2 runs = 2.6s)
                    tl.fromTo(".scanner-bar",
                        { top: "10%", opacity: 0 },
                        { top: "90%", opacity: 1, duration: 1.3, repeat: 1, yoyo: true, ease: "power1.inOut" },
                        "<0.1"
                    );

                    // 3. Fade out overlay
                    tl.to(scanOverlay, {
                        opacity: 0,
                        duration: 0.4,
                        ease: "power2.in"
                    }, "-=0.2");
                });
            }
        });
    </script>
</body>

</html>