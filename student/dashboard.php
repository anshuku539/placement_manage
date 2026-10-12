<?php
include 'includes/student-header.php';

$result = mysqli_query($conn, "SELECT * FROM students WHERE id = '" . $_SESSION['student_id'] . "'");
$student = mysqli_fetch_assoc($result);

$applications = mysqli_query($conn, "SELECT COUNT(*) AS total FROM applications WHERE student_id='" . $_SESSION['student_id'] . "'");
$total_apps = mysqli_fetch_assoc($applications);

include 'includes/student-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/student-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Registration ID -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <h6>Registration ID</h6>
                    <h4><?php echo $student['registration_id']; ?></h4>
                </div>
            </div>

            <!-- Course -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <h6>Course</h6>
                    <h4><?php echo $student['course']; ?></h4>
                </div>
            </div>

            <!-- Semester -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <h6>Semester</h6>
                    <h4><?php echo $student['semester']; ?></h4>
                </div>
            </div>

            <!-- Applications -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card">
                    <div class="card-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h6>Applications</h6>
                    <h4><?php echo $total_apps['total']; ?></h4>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-5 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Quick Actions</h4>

                <div class="d-flex flex-wrap gap-3">
                    <a href="profile.php" class="btn btn-primary">
                        Complete Profile
                    </a>
                    <a href="jobs.php" class="btn btn-success">
                        Browse Jobs
                    </a>
                    <a href="applications.php" class="btn btn-warning">
                        My Applications
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
                    WHERE user_type='Student'
                    AND user_id='" . $_SESSION['student_id'] . "'
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

<?php include 'includes/student-footer.php'; ?>