<?php
include 'includes/company-header.php';

$jobs_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jobs WHERE company_id='" . $_SESSION['company_id'] . "'");
$total_jobs = mysqli_fetch_assoc($jobs_query);

$apps_query = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM applications 
    INNER JOIN jobs ON applications.job_id = jobs.id 
    WHERE jobs.company_id='" . $_SESSION['company_id'] . "'
");
$total_apps = mysqli_fetch_assoc($apps_query);

$selected_query = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM applications 
    INNER JOIN jobs ON applications.job_id = jobs.id 
    WHERE jobs.company_id='" . $_SESSION['company_id'] . "' AND applications.status = 'Selected'
");
$total_selected = mysqli_fetch_assoc($selected_query);

include 'includes/company-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/company-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Company Name -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h6>Company Name</h6>
                    <h4><?php echo $company['company_name']; ?></h4>
                </div>
            </div>

            <!-- Total Jobs -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <h6>Total Jobs</h6>
                    <h4><?php echo $total_jobs['total']; ?></h4>
                </div>
            </div>

            <!-- Total Applications -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h6>Total Applications</h6>
                    <h4><?php echo $total_apps['total']; ?></h4>
                </div>
            </div>

            <!-- Selected Students -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h6>Selected Students</h6>
                    <h4><?php echo $total_selected['total']; ?></h4>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-5 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Quick Actions</h4>

                <div class="d-flex flex-wrap gap-3">
                    <a href="profile.php" class="btn btn-primary">
                        Update Profile
                    </a>
                    <a href="post-job.php" class="btn btn-success">
                        Post a New Job
                    </a>
                    <a href="jobs.php" class="btn btn-warning">
                        Manage Jobs
                    </a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Recent Notifications</h4>

                <?php
                $notification = mysqli_query($conn, "
                    SELECT *
                    FROM notifications
                    WHERE user_type='Company'
                    AND user_id='" . $_SESSION['company_id'] . "'
                    ORDER BY id DESC
                    LIMIT 5
                ");

                if (mysqli_num_rows($notification) > 0) {
                    while ($row = mysqli_fetch_assoc($notification)) {
                ?>
                        <div class="border-bottom py-3">
                            <h6><?php echo $row['title']; ?></h6>
                            <p class="mb-1 text-muted">
                                <?php echo $row['message']; ?>
                            </p>
                            <small class="text-secondary">
                                <?php echo date("d M Y", strtotime($row['created_at'])); ?>
                            </small>
                        </div>
                <?php
                    }
                } else {
                    echo "<p class='text-muted mb-0'>No notifications available.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/company-footer.php'; ?>
