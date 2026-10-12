<?php
$pageTitle = "Explore Jobs | AGC Placement Management System";
$metaDescription = "Browse open campus placement jobs, internships, and career opportunities from top recruiters at AGC Training & Placement Cell.";
$metaKeywords = "Campus Jobs, Placement Drives, Fresher Jobs, Internships, Software Engineer Jobs, AGC Jobs";

include 'includes/config.php';
include 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Filter parameters
$search = "";
$location = "";
$company_id = "";

if (isset($_GET['search'])) {
    $search = clean($conn, $_GET['search']);
}
if (isset($_GET['location'])) {
    $location = clean($conn, $_GET['location']);
}
if (isset($_GET['company'])) {
    $company_id = clean($conn, $_GET['company']);
}

// Fetch locations for filter
$loc_query = mysqli_query($conn, "SELECT DISTINCT location FROM jobs WHERE status = 'Open' AND location != '' ORDER BY location ASC");

// Fetch companies for filter
$comp_query = mysqli_query($conn, "SELECT DISTINCT companies.id, companies.company_name FROM companies INNER JOIN jobs ON companies.id = jobs.company_id WHERE jobs.status = 'Open' ORDER BY companies.company_name ASC");

// Fetch open jobs
$sql = "
    SELECT jobs.*, companies.company_name, companies.logo as company_logo
    FROM jobs
    INNER JOIN companies ON jobs.company_id = companies.id
    WHERE jobs.status = 'Open'
";

if ($search != "") {
    $sql .= " AND (jobs.title LIKE '%$search%' OR companies.company_name LIKE '%$search%') ";
}
if ($location != "") {
    $sql .= " AND jobs.location = '$location' ";
}
if ($company_id != "") {
    $sql .= " AND jobs.company_id = '$company_id' ";
}

$sql .= " ORDER BY jobs.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<main>
    <!-- Page Banner -->
    <section class="page-banner">
        <div class="container">
            <div class="text-center">
                <h1>Current Job Openings</h1>
                <p>
                    Browse verified campus placement drives, internships, and job vacancies from our partner recruiters.
                </p>
            </div>
        </div>
    </section>

    <!-- Jobs Section -->
    <section class="jobs-section">
        <div class="container">
            <!-- Filter Box -->
            <div class="filter-card">
                <form method="GET" action="jobs.php" class="row g-3">
                    <!-- Search Input -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Search Jobs</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Job title or company..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Filter by Location</label>
                        <select name="location" class="form-select">
                            <option value="">All Locations</option>
                            <?php
                            if (mysqli_num_rows($loc_query) > 0) {
                                while ($loc = mysqli_fetch_assoc($loc_query)) {
                                    $selected = ($location == $loc['location']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($loc['location']) . '" ' . $selected . '>' . htmlspecialchars($loc['location']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Company Filter -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Filter by Company</label>
                        <select name="company" class="form-select">
                            <option value="">All Companies</option>
                            <?php
                            if (mysqli_num_rows($comp_query) > 0) {
                                while ($comp = mysqli_fetch_assoc($comp_query)) {
                                    $selected = ($company_id == $comp['id']) ? 'selected' : '';
                                    echo '<option value="' . $comp['id'] . '" ' . $selected . '>' . htmlspecialchars($comp['company_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-lg-2 col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Filter
                        </button>
                        <?php if ($search != "" || $location != "" || $company_id != "") { ?>
                            <a href="jobs.php" class="btn btn-outline-secondary" title="Clear Filters">
                                Reset
                            </a>
                        <?php } ?>
                    </div>
                </form>
            </div>

            <!-- Jobs Grid -->
            <div class="row g-4">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($job = mysqli_fetch_assoc($result)) {
                        // Check company logo
                        $logo = "assets/images/default-company.svg";
                        if (!empty($job['company_logo'])) {
                            if (file_exists("assets/uploads/companies/" . $job['company_logo'])) {
                                $logo = "assets/uploads/companies/" . $job['company_logo'];
                            } elseif (file_exists("uploads/" . $job['company_logo'])) {
                                $logo = "uploads/" . $job['company_logo'];
                            }
                        }
                ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="job-card">
                                <div class="job-card-top">
                                    <div>
                                        <h5><?php echo htmlspecialchars($job['title']); ?></h5>
                                        <p class="job-company-name">
                                            <i class="bi bi-buildings me-1"></i>
                                            <?php echo htmlspecialchars($job['company_name']); ?>
                                        </p>
                                    </div>
                                    <div class="job-company-logo">
                                        <img src="<?php echo $logo; ?>" alt="<?php echo htmlspecialchars($job['company_name']); ?>" loading="lazy">
                                    </div>
                                </div>

                                <ul class="job-details-list flex-grow-1">
                                    <li>
                                        <i class="bi bi-geo-alt"></i>
                                        <span><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></span>
                                    </li>
                                    <li>
                                        <i class="bi bi-cash-stack"></i>
                                        <span><strong>Package:</strong> <?php echo htmlspecialchars($job['package']); ?></span>
                                    </li>
                                    <li>
                                        <i class="bi bi-people"></i>
                                        <span><strong>Vacancies:</strong> <?php echo $job['vacancies']; ?> Openings</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-mortarboard"></i>
                                        <span><strong>Eligibility:</strong> <?php echo htmlspecialchars($job['eligibility']); ?></span>
                                    </li>
                                    <li>
                                        <i class="bi bi-calendar-event"></i>
                                        <span><strong>Last Date:</strong> <?php echo date("d M Y", strtotime($job['last_date'])); ?></span>
                                    </li>
                                </ul>

                                <div class="d-flex gap-2 mt-auto pt-3 border-top">
                                    <button type="button" class="btn btn-outline-primary btn-sm w-50" data-bs-toggle="modal" data-bs-target="#jobModal<?php echo $job['id']; ?>">
                                        View Details
                                    </button>

                                    <?php if (isset($_SESSION['student_id'])) { ?>
                                        <a href="student/apply-job.php?id=<?php echo $job['id']; ?>" class="btn btn-primary btn-sm w-50">
                                            Apply Now
                                        </a>
                                    <?php } else { ?>
                                        <a href="student-login.php" class="btn btn-primary btn-sm w-50" title="Login as student to apply">
                                            Student Login to Apply
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Job Details Modal -->
                        <div class="modal fade" id="jobModal<?php echo $job['id']; ?>" tabindex="-1" aria-labelledby="jobModalLabel<?php echo $job['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-bottom">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1" id="jobModalLabel<?php echo $job['id']; ?>">
                                                <?php echo htmlspecialchars($job['title']); ?>
                                            </h5>
                                            <span class="text-muted small">
                                                <i class="bi bi-buildings me-1"></i> <?php echo htmlspecialchars($job['company_name']); ?>
                                                &bull;
                                                <i class="bi bi-geo-alt me-1"></i> <?php echo htmlspecialchars($job['location']); ?>
                                            </span>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-4">
                                        <div class="row g-3 mb-4 text-center">
                                            <div class="col-sm-6 col-md-3">
                                                <div class="p-3 bg-light rounded">
                                                    <small class="text-muted d-block mb-1">Package</small>
                                                    <strong class="text-primary"><?php echo htmlspecialchars($job['package']); ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="p-3 bg-light rounded">
                                                    <small class="text-muted d-block mb-1">Vacancies</small>
                                                    <strong><?php echo $job['vacancies']; ?> Posts</strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="p-3 bg-light rounded">
                                                    <small class="text-muted d-block mb-1">Last Date</small>
                                                    <strong><?php echo date("d M Y", strtotime($job['last_date'])); ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="p-3 bg-light rounded">
                                                    <small class="text-muted d-block mb-1">Status</small>
                                                    <span class="badge bg-success">Open</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-2">
                                                <i class="bi bi-mortarboard text-primary me-2"></i>Eligibility Criteria
                                            </h6>
                                            <p class="text-muted mb-0">
                                                <?php echo nl2br(htmlspecialchars($job['eligibility'])); ?>
                                            </p>
                                        </div>

                                        <?php if (!empty($job['description'])) { ?>
                                            <div class="mb-2">
                                                <h6 class="fw-bold mb-2">
                                                    <i class="bi bi-file-text text-primary me-2"></i>Job Description
                                                </h6>
                                                <p class="text-muted mb-0">
                                                    <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                                                </p>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="modal-footer border-top">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <?php if (isset($_SESSION['student_id'])) { ?>
                                            <a href="student/apply-job.php?id=<?php echo $job['id']; ?>" class="btn btn-primary btn-sm">
                                                Apply Now
                                            </a>
                                        <?php } else { ?>
                                            <a href="student-login.php" class="btn btn-primary btn-sm">
                                                Student Login to Apply
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                ?>
                    <!-- No records -->
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <i class="bi bi-briefcase fs-1 d-block mb-3 text-primary"></i>
                            <h5 class="alert-heading mb-2">No jobs available.</h5>
                            <p class="text-muted mb-0">
                                <?php echo ($search != "" || $location != "" || $company_id != "") ? "No job openings matched your filter criteria. Try clearing some filters." : "There are currently no active job vacancies available. Please check back soon!"; ?>
                            </p>
                            <?php if ($search != "" || $location != "" || $company_id != "") { ?>
                                <div class="mt-3">
                                    <a href="jobs.php" class="btn btn-primary btn-sm">
                                        View All Jobs
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>