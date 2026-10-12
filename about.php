<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';

$pageTitle = "About Us | AGC Placement Management System";
$metaDescription = "Learn about the AGC Training & Placement Cell. We bridge the gap between students and recruiters by organizing campus drives and career guidance.";
$metaKeywords = "About AGC, Placement Cell, Training, Recruiters, Campus Drives, Career Guidance";

// Fetch CMS About Content
$about_query = mysqli_query($conn, "SELECT * FROM cms_about LIMIT 1");
$about = ($about_query && mysqli_num_rows($about_query) > 0) ? mysqli_fetch_assoc($about_query) : null;

$about_heading = !empty($about['heading']) ? $about['heading'] : 'About Our Placement Cell';
$about_desc = !empty($about['description']) ? $about['description'] : 'The Training and Placement Cell acts as a bridge between students and recruiters by organizing campus placement drives, career guidance sessions, aptitude training and interview preparation activities.';
$about_img = getCmsImage($about['image'] ?? '', '', 'assets/images/hero.png');

// Fetch CMS Placement Team
$team_res = mysqli_query($conn, "SELECT * FROM cms_team ORDER BY sort_order ASC, id ASC");
$team_members = [];
if ($team_res && mysqli_num_rows($team_res) > 0) {
    while ($row = mysqli_fetch_assoc($team_res)) {
        $team_members[] = $row;
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<main>

    <!-- About Hero -->
    <section class="page-banner">
        <div class="container">
            <div class="text-center">
                <h1>About Placement Cell</h1>
                <p>
                    Connecting students with the right career opportunities through campus placements and industry partnerships.
                </p>
            </div>
        </div>
    </section>

    <!-- About Placement Cell -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0 text-center text-lg-start">
                    <img src="<?php echo htmlspecialchars($about_img); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($about_heading); ?>" loading="lazy">
                </div>

                <div class="col-lg-7">
                    <div class="ps-lg-4">
                        <h2 class="section-title mb-4">
                            <?php echo htmlspecialchars($about_heading); ?>
                        </h2>
                        <?php 
                        $paragraphs = array_filter(array_map('trim', explode("\n", $about_desc)));
                        if (count($paragraphs) > 1) {
                            foreach ($paragraphs as $para) {
                                echo '<p>' . htmlspecialchars($para) . '</p>';
                            }
                        } else {
                            echo '<p>' . nl2br(htmlspecialchars($about_desc)) . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mission-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Mission & Vision</h2>
                <p class="section-subtitle">
                    Our commitment is to prepare students for successful careers and build strong industry partnerships.
                </p>
            </div>

            <div class="row g-4">
                <!-- Mission -->
                <div class="col-lg-6">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p>
                            To provide students with quality placement opportunities by connecting them with reputed organizations, improving their employability skills, and supporting their overall professional development.
                        </p>
                    </div>
                </div>

                <!-- Vision -->
                <div class="col-lg-6">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <h3>Our Vision</h3>
                        <p>
                            To become a trusted placement platform that bridges the gap between academic learning and industry requirements while helping students build successful careers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Placement Process -->
    <section class="process-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Placement Process</h2>
                <p class="section-subtitle">
                    Follow these simple steps to participate in the campus placement process.
                </p>
            </div>

            <div class="row g-4 text-center justify-content-center">
                <div class="col-lg col-md-4 col-sm-6">
                    <div class="process-card">
                        <div class="process-number">1</div>
                        <div class="process-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h5>Register</h5>
                        <p>Create your placement account.</p>
                    </div>
                </div>

                <div class="col-lg col-md-4 col-sm-6">
                    <div class="process-card">
                        <div class="process-number">2</div>
                        <div class="process-icon">
                            <i class="bi bi-person-vcard"></i>
                        </div>
                        <h5>Complete Profile</h5>
                        <p>Fill your academic and personal details.</p>
                    </div>
                </div>

                <div class="col-lg col-md-4 col-sm-6">
                    <div class="process-card">
                        <div class="process-number">3</div>
                        <div class="process-icon">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <h5>Apply for Jobs</h5>
                        <p>Browse and apply for available jobs.</p>
                    </div>
                </div>

                <div class="col-lg col-md-6 col-sm-6">
                    <div class="process-card">
                        <div class="process-number">4</div>
                        <div class="process-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h5>Interview</h5>
                        <p>Attend company selection rounds.</p>
                    </div>
                </div>

                <div class="col-lg col-md-6 col-sm-6 col-12">
                    <div class="process-card">
                        <div class="process-number">5</div>
                        <div class="process-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <h5>Get Placed</h5>
                        <p>Receive your placement offer.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet Our Placement Team -->
    <section class="team-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Meet Our Placement Team</h2>
                <p class="section-subtitle">
                    Our dedicated placement team works closely with students and recruiters to ensure successful campus placements.
                </p>
            </div>

            <?php if (!empty($team_members)) { ?>
                <div class="row g-4 justify-content-center">
                    <?php foreach ($team_members as $tm) { 
                        $tm_photo = getCmsImage($tm['image'], 'team', 'assets/images/default-user.png');
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="team-card">
                                <img src="<?php echo htmlspecialchars($tm_photo); ?>" alt="<?php echo htmlspecialchars($tm['name']); ?> - <?php echo htmlspecialchars($tm['designation']); ?>" loading="lazy">
                                <h4><?php echo htmlspecialchars($tm['name']); ?></h4>
                                <span><?php echo htmlspecialchars($tm['designation']); ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="text-center py-4">
                    <p class="text-muted">No team members available.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Why Choose Our Placement Cell -->
    <section class="about-features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Why Choose Our Placement Cell</h2>
                <p class="section-subtitle">
                    We are committed to helping students achieve their career goals through quality placement support and industry collaboration.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-buildings"></i>
                        <h5>Industry Connections</h5>
                        <p>
                            Strong relationships with leading companies across multiple industries.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-person-workspace"></i>
                        <h5>Career Guidance</h5>
                        <p>
                            Expert guidance, counseling and placement assistance for every student.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-mortarboard"></i>
                        <h5>Skill Development</h5>
                        <p>
                            Training programs, aptitude sessions and interview preparation support.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-box">
                        <i class="bi bi-shield-check"></i>
                        <h5>Transparent Process</h5>
                        <p>
                            A fair and transparent placement process for all eligible students.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call To Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box">
                <h2>Start Your Placement Journey Today</h2>
                <p>
                    Register yourself to explore placement opportunities, connect with leading recruiters and build a successful career.
                </p>
                <div class="cta-buttons mt-4">
                    <a href="student-register.php" class="btn btn-light">
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

<!-- Organization Schema -->
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "AGC Training & Placement Cell",
        "url": "http://localhost/Placement_manage/",
        "logo": "http://localhost/Placement_manage/assets/images/logo.png",
        "description": "Connecting students with the right career opportunities through campus placements and industry partnerships.",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+91-1234567890",
            "contactType": "Admissions and Placement"
        }
    }
</script>

<?php include 'includes/footer.php'; ?>