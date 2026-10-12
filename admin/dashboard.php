<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// Get counts
$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students"))['total'];
$company_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM companies"))['total'];
$pending_companies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM companies WHERE status='Pending'"))['total'];
$approved_companies = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM companies WHERE status='Approved'"))['total'];

$job_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM jobs"))['total'];
$open_jobs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM jobs WHERE status='Open'"))['total'];
$closed_jobs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM jobs WHERE status='Closed'"))['total'];

$app_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM applications"))['total'];
$selected_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM selected_students"))['total'];
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <h4 class="mb-4">Dashboard Overview</h4>

        <div class="row g-3 mb-4">
            <!-- Key Metrics -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-primary bg-primary bg-opacity-10"><i class="bi bi-people"></i></div>
                    <h6>Total Students</h6>
                    <h4><?php echo $student_count; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-secondary bg-secondary bg-opacity-10"><i class="bi bi-buildings"></i></div>
                    <h6>Total Companies</h6>
                    <h4><?php echo $company_count; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-warning bg-warning bg-opacity-10"><i class="bi bi-clock-history"></i></div>
                    <h6>Pending Companies</h6>
                    <h4><?php echo $pending_companies; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-success bg-success bg-opacity-10"><i class="bi bi-building-check"></i></div>
                    <h6>Approved Companies</h6>
                    <h4><?php echo $approved_companies; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-info bg-info bg-opacity-10"><i class="bi bi-briefcase"></i></div>
                    <h6>Total Jobs</h6>
                    <h4><?php echo $job_count; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-success bg-success bg-opacity-10"><i class="bi bi-door-open"></i></div>
                    <h6>Open Jobs</h6>
                    <h4><?php echo $open_jobs; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-danger bg-danger bg-opacity-10"><i class="bi bi-door-closed"></i></div>
                    <h6>Closed Jobs</h6>
                    <h4><?php echo $closed_jobs; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-primary bg-primary bg-opacity-10"><i class="bi bi-file-earmark-text"></i></div>
                    <h6>Applications</h6>
                    <h4><?php echo $app_count; ?></h4>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="dashboard-card h-100">
                    <div class="card-icon text-success bg-success bg-opacity-10"><i class="bi bi-person-check"></i></div>
                    <h6>Selected Students</h6>
                    <h4><?php echo $selected_count; ?></h4>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Registrations -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Students</h6>
                        <a href="students.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $recent_students = mysqli_query($conn, "SELECT name, course, created_at FROM students ORDER BY created_at DESC LIMIT 4");
                            if (mysqli_num_rows($recent_students) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_students)) {
                            ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                                            <small class="d-block text-muted"><?php echo htmlspecialchars($row['course']); ?></small>
                                        </div>
                                        <small class="text-secondary"><?php echo date("d M Y", strtotime($row['created_at'])); ?></small>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No students yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Companies -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Companies</h6>
                        <a href="companies.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $recent_comps = mysqli_query($conn, "SELECT company_name, status, created_at FROM companies ORDER BY created_at DESC LIMIT 4");
                            if (mysqli_num_rows($recent_comps) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_comps)) {
                            ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo htmlspecialchars($row['company_name']); ?></strong>
                                            <small class="d-block text-muted">Status: <?php echo htmlspecialchars($row['status']); ?></small>
                                        </div>
                                        <small class="text-secondary"><?php echo date("d M Y", strtotime($row['created_at'])); ?></small>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No companies yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Jobs -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Jobs</h6>
                        <a href="jobs.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $recent_jobs = mysqli_query($conn, "
                                SELECT jobs.title, companies.company_name, jobs.created_at 
                                FROM jobs 
                                INNER JOIN companies ON jobs.company_id = companies.id 
                                ORDER BY jobs.created_at DESC LIMIT 4
                            ");
                            if (mysqli_num_rows($recent_jobs) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_jobs)) {
                            ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                                            <small class="d-block text-muted"><?php echo htmlspecialchars($row['company_name']); ?></small>
                                        </div>
                                        <small class="text-secondary"><?php echo date("d M Y", strtotime($row['created_at'])); ?></small>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No jobs yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Recent Applications</h6>
                        <a href="applications.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $recent_apps = mysqli_query($conn, "
                                SELECT students.name, jobs.title, applications.applied_at 
                                FROM applications 
                                INNER JOIN students ON applications.student_id = students.id 
                                INNER JOIN jobs ON applications.job_id = jobs.id 
                                ORDER BY applications.applied_at DESC LIMIT 4
                            ");
                            if (mysqli_num_rows($recent_apps) > 0) {
                                while ($row = mysqli_fetch_assoc($recent_apps)) {
                            ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                                            <small class="d-block text-muted">Applied for: <?php echo htmlspecialchars($row['title']); ?></small>
                                        </div>
                                        <small class="text-secondary"><?php echo date("d M Y", strtotime($row['applied_at'])); ?></small>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No applications yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>