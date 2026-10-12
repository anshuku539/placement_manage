<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$pageTitle = "Home | AGC Placement Management System";
$metaDescription = "Welcome to the AGC Training & Placement Cell. Connect with top recruiters, explore job opportunities, and start your career journey.";
$metaKeywords = "AGC Placement, Campus Recruitment, Student Jobs, Top Recruiters, Placement Drive";

// Fetch CMS Data
$hero_query = mysqli_query($conn, "SELECT * FROM cms_hero LIMIT 1");
$hero = ($hero_query && mysqli_num_rows($hero_query) > 0) ? mysqli_fetch_assoc($hero_query) : null;

$recruiters_res = mysqli_query($conn, "SELECT * FROM cms_recruiters ORDER BY sort_order ASC, id ASC");
$recruiters = [];
if ($recruiters_res && mysqli_num_rows($recruiters_res) > 0) {
    while ($row = mysqli_fetch_assoc($recruiters_res)) {
        $recruiters[] = $row;
    }
}

$stats_res = mysqli_query($conn, "SELECT * FROM cms_statistics ORDER BY sort_order ASC, id ASC");
$statistics = [];
if ($stats_res && mysqli_num_rows($stats_res) > 0) {
    while ($row = mysqli_fetch_assoc($stats_res)) {
        $statistics[] = $row;
    }
}

$why_res = mysqli_query($conn, "SELECT * FROM cms_why_choose_us WHERE status=1 ORDER BY sort_order ASC, id ASC");
$why_list = [];
if ($why_res && mysqli_num_rows($why_res) > 0) {
    while ($row = mysqli_fetch_assoc($why_res)) {
        $why_list[] = $row;
    }
}

$drives_res = mysqli_query($conn, "SELECT * FROM cms_drives WHERE status=1 ORDER BY sort_order ASC, id ASC");
$drives = [];
if ($drives_res && mysqli_num_rows($drives_res) > 0) {
    while ($row = mysqli_fetch_assoc($drives_res)) {
        $drives[] = $row;
    }
}

$test_res = mysqli_query($conn, "SELECT * FROM cms_testimonials ORDER BY sort_order ASC, id ASC");
$testimonials = [];
if ($test_res && mysqli_num_rows($test_res) > 0) {
    while ($row = mysqli_fetch_assoc($test_res)) {
        $testimonials[] = $row;
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-6">
                    <span class="hero-badge">
                        Welcome to AGC Training & Placement Cell
                    </span>
                    <h1 class="hero-title mt-3">
                        <?php
                        $hero_title = !empty($hero['title']) ? $hero['title'] : 'Build Your Career with Top Companies';
                        $words = explode(' ', trim($hero_title));
                        if (count($words) > 2 && strpos($hero_title, '<') === false) {
                            $last_words = array_splice($words, -2);
                            echo htmlspecialchars(implode(' ', $words)) . ' <span>' . htmlspecialchars(implode(' ', $last_words)) . '</span>';
                        } else {
                            echo htmlspecialchars($hero_title);
                        }
                        ?>
                    </h1>
                    <p class="hero-text mt-3">
                        <?php
                        echo nl2br(htmlspecialchars($hero['subtitle'] ?? 'Connect with leading companies, explore exciting job opportunities, and begin your professional journey through the AGC Placement Management System.'));
                        ?>
                    </p>
                    <div class="hero-btn mt-4">
                        <a href="student-register.php" class="btn btn-primary me-2">
                            Student Registration
                        </a>
                        <a href="jobs.php" class="btn btn-outline-primary">
                            View Jobs
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <?php
                    $hero_img = getCmsImage($hero['image'] ?? '', '', 'assets/images/hero.png');
                    ?>
                    <img src="<?php echo htmlspecialchars($hero_img); ?>" class="img-fluid hero-image" alt="Students celebrating placement success" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Top Recruiters -->
    <section class="recruiters-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Top Recruiters</h2>
                <p class="section-subtitle">
                    Leading companies that recruit talented students from our campus.
                </p>
            </div>
        </div>

        <?php if (!empty($recruiters)) { ?>
            <div class="recruiters-slider">
                <div class="recruiters-track">
                    <?php
                    // Duplicate for smooth infinite CSS animation track
                    for ($loop = 0; $loop < 2; $loop++) {
                        foreach ($recruiters as $rc) {
                            $rc_logo = getCmsImage($rc['logo'], 'recruiters', 'assets/images/default-company.png');
                    ?>
                            <div class="logo-box">
                                <img src="<?php echo htmlspecialchars($rc_logo); ?>" alt="<?php echo htmlspecialchars($rc['company_name']); ?>" loading="lazy" title="<?php echo htmlspecialchars($rc['company_name']); ?>">
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="container text-center py-4">
                <p class="text-muted">No recruiters available.</p>
            </div>
        <?php } ?>
    </section>

    <!-- Placement Statistics -->
    <section class="statistics-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Placement Statistics</h2>
                <p class="section-subtitle">
                    Our placement record reflects the success and dedication of our students and recruiters.
                </p>
            </div>

            <?php if (!empty($statistics)) { ?>
                <div class="row g-4 justify-content-center">
                    <?php
                    $stat_icons = ['bi-people-fill', 'bi-building', 'bi-briefcase-fill', 'bi-award-fill', 'bi-graph-up-arrow', 'bi-mortarboard'];
                    foreach ($statistics as $idx => $st) {
                        $icon = $stat_icons[$idx % count($stat_icons)];
                    ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-card">
                                <div class="stats-icon">
                                    <i class="bi <?php echo $icon; ?>"></i>
                                </div>
                                <h3><?php echo htmlspecialchars($st['number']); ?></h3>
                                <p><?php echo htmlspecialchars($st['title']); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="text-center py-4">
                    <p class="text-muted">No statistics available.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Choose Us</h2>
                <p class="section-subtitle">
                    We help students connect with top recruiters and build successful careers through a simple and transparent placement process.
                </p>
            </div>

            <?php if (!empty($why_list)) { ?>
                <div class="row g-4">
                    <?php foreach ($why_list as $why) {
                        $why_icon = !empty($why['icon']) ? $why['icon'] : 'bi-check-circle';
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="why-card">
                                <div class="why-icon">
                                    <i class="bi <?php echo htmlspecialchars($why_icon); ?>"></i>
                                </div>
                                <h4><?php echo htmlspecialchars($why['title']); ?></h4>
                                <p>
                                    <?php echo htmlspecialchars($why['description']); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="text-center py-4">
                    <p class="text-muted">No information available.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Recent Placement Drives -->
    <section class="drives-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Recent Placement Drives</h2>
                <p class="section-subtitle">
                    Explore the latest placement opportunities from leading companies.
                </p>
            </div>

            <?php if (!empty($drives)) { ?>
                <div class="row g-4">
                    <?php foreach ($drives as $drive) {
                        // Read logo filename from cms_drives.logo and trim whitespace
                        $logo_filename = isset($drive['logo']) ? trim($drive['logo']) : '';
                        $default_logo = 'assets/images/drives/default-company.png';

                        // Build image path and verify file exists using server-safe path checking
                        if (!empty($logo_filename)) {
                            $target_path = 'assets/images/drives/' . $logo_filename;
                            $server_path = __DIR__ . '/' . $target_path;

                            if (file_exists($server_path)) {
                                $drive_logo = $target_path;
                            } elseif (!empty($_SERVER['DOCUMENT_ROOT']) && file_exists(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/' . $target_path)) {
                                $drive_logo = $target_path;
                            } else {
                                $drive_logo = $default_logo;
                            }
                        } else {
                            $drive_logo = $default_logo;
                        }

                        $btn_text = !empty($drive['button_text']) ? $drive['button_text'] : 'Apply Now';
                        $btn_link = !empty($drive['button_link']) ? $drive['button_link'] : 'jobs.php';
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="drive-card">
                                <img src="<?php echo htmlspecialchars($drive_logo); ?>" alt="<?php echo htmlspecialchars($drive['company_name']); ?> Campus Drive" loading="lazy">
                                <h5><?php echo htmlspecialchars($drive['company_name']); ?></h5>
                                <h6><?php echo htmlspecialchars($drive['job_title']); ?></h6>
                                <ul class="list-unstyled">
                                    <?php if (!empty($drive['location'])) { ?>
                                        <li><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($drive['location']); ?></li>
                                    <?php } ?>
                                    <?php if (!empty($drive['package'])) { ?>
                                        <li><i class="bi bi-currency-rupee"></i> <?php echo htmlspecialchars($drive['package']); ?></li>
                                    <?php } ?>
                                    <?php if (!empty($drive['deadline'])) { ?>
                                        <li><i class="bi bi-calendar-event"></i> Last Date : <?php echo htmlspecialchars($drive['deadline']); ?></li>
                                    <?php } ?>
                                </ul>
                                <a href="<?php echo htmlspecialchars($btn_link); ?>" class="btn btn-primary w-100">
                                    <?php echo htmlspecialchars($btn_text); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="text-center py-4">
                    <p class="text-muted">No recent placement drives available.</p>
                </div>
            <?php } ?>

            <div class="text-center mt-5">
                <a href="jobs.php" class="btn btn-outline-primary">
                    View All Jobs
                </a>
            </div>
        </div>
    </section>

    <!-- Student Success Stories -->
    <section class="testimonial-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Student Success Stories</h2>
                <p class="section-subtitle">
                    Hear what our successfully placed students have to say about their placement journey.
                </p>
            </div>

            <?php if (!empty($testimonials)) { ?>
                <div class="row g-4">
                    <?php foreach ($testimonials as $t) {
                        $photo_src = getCmsImage($t['photo'], 'students', 'assets/images/default-user.png');
                        $rating = (int)($t['rating'] ?? 5);
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="testimonial-card">
                                <div class="testimonial-rating">
                                    <?php echo str_repeat('★', max(1, min(5, $rating))); ?>
                                </div>
                                <p class="testimonial-text">
                                    "<?php echo htmlspecialchars($t['message']); ?>"
                                </p>
                                <div class="testimonial-user">
                                    <img src="<?php echo htmlspecialchars($photo_src); ?>" alt="<?php echo htmlspecialchars($t['student_name']); ?> Testimonial" loading="lazy">
                                    <div>
                                        <h5><?php echo htmlspecialchars($t['student_name']); ?></h5>
                                        <span><?php echo htmlspecialchars($t['course']); ?></span>
                                        <p>Placed at <?php echo htmlspecialchars($t['company']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="text-center py-4">
                    <p class="text-muted">No testimonials available.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Call To Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box">
                <h2>Start Your Placement Journey Today</h2>
                <p>
                    Register now to explore exciting career opportunities and connect with leading recruiters through our Placement Management System.
                </p>
                <div class="mt-4">
                    <a href="student-register.php" class="btn btn-light me-2">
                        Student Registration
                    </a>
                    <a href="jobs.php" class="btn btn-outline-light">
                        Explore Jobs
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Website Schema -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "AGC Placement Management System",
        "url": "http://localhost/Placement_manage/",
        "description": "Welcome to the AGC Training & Placement Cell. Connect with top recruiters and explore job opportunities."
    }
</script>

<?php
include 'includes/footer.php';
?>