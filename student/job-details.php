<?php
include 'includes/student-header.php';

if (!isset($_GET['id'])) {
    header("Location: jobs.php");
    exit();
}

$job_id = (int)$_GET['id'];

$sql = mysqli_query($conn, "
    SELECT jobs.*, companies.company_name
    FROM jobs
    INNER JOIN companies
    ON jobs.company_id = companies.id
    WHERE jobs.id='$job_id'
");

if (mysqli_num_rows($sql) == 0) {
    header("Location: jobs.php");
    exit();
}

$job = mysqli_fetch_assoc($sql);

$check = mysqli_query($conn, "
    SELECT id
    FROM applications
    WHERE student_id='" . $_SESSION['student_id'] . "'
    AND job_id='$job_id'
");

$applied = mysqli_num_rows($check) > 0;

include 'includes/student-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/student-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h3 class="mb-0">
                    <?php echo htmlspecialchars($job['title']); ?>
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Company</strong>
                        <p><?php echo htmlspecialchars($job['company_name']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Location</strong>
                        <p><?php echo htmlspecialchars($job['location']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Package</strong>
                        <p><?php echo htmlspecialchars($job['package']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Vacancies</strong>
                        <p><?php echo $job['vacancies']; ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Application Deadline</strong>
                        <p><?php echo date("d M Y", strtotime($job['last_date'])); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Status</strong>
                        <p>
                            <?php
                            if ($job['status'] == "Open") {
                                echo "<span class='badge bg-success'>Open</span>";
                            } else {
                                echo "<span class='badge bg-danger'>Closed</span>";
                            }
                            ?>
                        </p>
                    </div>

                    <div class="col-12 mb-4">
                        <strong>Eligibility</strong>
                        <p><?php echo nl2br(htmlspecialchars($job['eligibility'])); ?></p>
                    </div>

                    <div class="col-12 mb-4">
                        <strong>Job Description</strong>
                        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="jobs.php" class="btn btn-secondary">
                        Back
                    </a>

                    <?php if ($applied) { ?>
                        <button class="btn btn-success" disabled>
                            Already Applied
                        </button>
                    <?php } else { ?>
                        <a href="apply-job.php?id=<?php echo $job['id']; ?>" class="btn btn-primary">
                            Apply Now
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/student-footer.php'; ?>