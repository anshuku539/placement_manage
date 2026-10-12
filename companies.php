<?php
$pageTitle = "Partner Companies | AGC Placement Management System";
$metaDescription = "Explore approved recruiting partners and top companies participating in campus placement drives at AGC Training & Placement Cell.";
$metaKeywords = "AGC Recruiters, Partner Companies, Placement Drives, Hiring Partners, Campus Placements";

include 'includes/config.php';
include 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Search query
$search = "";
if (isset($_GET['search'])) {
    $search = clean($conn, $_GET['search']);
}

// Get approved companies
$sql = "SELECT * FROM companies WHERE status = 'Approved'";
if ($search != "") {
    $sql .= " AND company_name LIKE '%$search%'";
}
$sql .= " ORDER BY company_name ASC";
$result = mysqli_query($conn, $sql);
?>

<main>
    <!-- Page Banner -->
    <section class="page-banner">
        <div class="container">
            <div class="text-center">
                <h1>Partner Companies</h1>
                <p>
                    Explore top recruiting companies and industry partners that actively participate in our campus placement drives.
                </p>
            </div>
        </div>
    </section>

    <!-- Companies Section -->
    <section class="companies-section">
        <div class="container">
            <!-- Search Box -->
            <div class="filter-card">
                <form method="GET" action="companies.php" class="row g-2 align-items-center">
                    <div class="col-md-9 col-sm-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search company by name..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Search
                        </button>
                        <?php if ($search != "") { ?>
                            <a href="companies.php" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        <?php } ?>
                    </div>
                </form>
            </div>

            <!-- Companies Grid -->
            <div class="row g-4">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($company = mysqli_fetch_assoc($result)) {
                        // Check company logo
                        $logo = "assets/images/default-company.svg";
                        if (!empty($company['logo'])) {
                            if (file_exists("assets/uploads/companies/" . $company['logo'])) {
                                $logo = "assets/uploads/companies/" . $company['logo'];
                            } elseif (file_exists("uploads/" . $company['logo'])) {
                                $logo = "uploads/" . $company['logo'];
                            }
                        }

                        // Count active jobs
                        $job_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs WHERE company_id = '" . $company['id'] . "' AND status = 'Open'");
                        $job_data = mysqli_fetch_assoc($job_query);
                        $total_jobs = $job_data['total'];
                ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="company-card">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="company-logo-wrap">
                                        <img src="<?php echo $logo; ?>" alt="<?php echo htmlspecialchars($company['company_name']); ?> Logo" loading="lazy">
                                    </div>
                                    <?php if ($total_jobs > 0) { ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            <i class="bi bi-briefcase me-1"></i> <?php echo $total_jobs; ?> Active Jobs
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge bg-light text-muted border">
                                            0 Active Jobs
                                        </span>
                                    <?php } ?>
                                </div>

                                <h5><?php echo htmlspecialchars($company['company_name']); ?></h5>

                                <ul class="company-info-list flex-grow-1">
                                    <?php if (!empty($company['hr_name'])) { ?>
                                        <li>
                                            <i class="bi bi-person"></i>
                                            <span><strong>HR:</strong> <?php echo htmlspecialchars($company['hr_name']); ?></span>
                                        </li>
                                    <?php } ?>

                                    <?php if (!empty($company['website'])) { ?>
                                        <li>
                                            <i class="bi bi-globe"></i>
                                            <a href="<?php echo htmlspecialchars($company['website']); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                                <?php echo htmlspecialchars($company['website']); ?>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (!empty($company['address'])) { ?>
                                        <li>
                                            <i class="bi bi-geo-alt"></i>
                                            <span><?php echo htmlspecialchars($company['address']); ?></span>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <div class="mt-auto pt-3 border-top">
                                    <?php if ($total_jobs > 0) { ?>
                                        <a href="jobs.php?company=<?php echo $company['id']; ?>" class="btn btn-outline-primary btn-sm w-100">
                                            View Active Jobs (<?php echo $total_jobs; ?>)
                                        </a>
                                    <?php } else { ?>
                                        <span class="text-muted small d-block text-center py-1">
                                            No active openings currently
                                        </span>
                                    <?php } ?>
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
                            <i class="bi bi-buildings fs-1 d-block mb-3 text-primary"></i>
                            <h5 class="alert-heading mb-2">No companies available.</h5>
                            <p class="text-muted mb-0">
                                <?php echo $search != "" ? "No companies matched your search criteria. Try searching with a different keyword." : "There are currently no approved partner companies listed."; ?>
                            </p>
                            <?php if ($search != "") { ?>
                                <div class="mt-3">
                                    <a href="companies.php" class="btn btn-primary btn-sm">
                                        View All Companies
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
