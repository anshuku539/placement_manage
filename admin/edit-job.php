<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

if (!isset($_GET['id'])) {
    redirect("jobs.php");
}

$id = (int)$_GET['id'];

// Handle Update
if (isset($_POST['update_job'])) {
    $last_date = clean($conn, $_POST['last_date']);
    $package = clean($conn, $_POST['package']);
    $vacancies = (int)$_POST['vacancies'];
    $eligibility = clean($conn, $_POST['eligibility']);
    $description = clean($conn, $_POST['description']);
    $status = clean($conn, $_POST['status']);

    $query = "UPDATE jobs SET 
        last_date='$last_date', package='$package', vacancies='$vacancies', 
        eligibility='$eligibility', description='$description', status='$status'
        WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Job details updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating job: " . mysqli_error($conn);
    }

    redirect("edit-job.php?id=$id");
}

// Fetch job data
$job_query = mysqli_query($conn, "
    SELECT jobs.*, companies.company_name 
    FROM jobs 
    INNER JOIN companies ON jobs.company_id = companies.id 
    WHERE jobs.id='$id'
");
if (mysqli_num_rows($job_query) == 0) {
    redirect("jobs.php");
}
$job = mysqli_fetch_assoc($job_query);
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Edit Job: <?php echo htmlspecialchars($job['title']); ?></h4>
            <a href="jobs.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Jobs</a>
        </div>

        <?php showMessage(); ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Job Details (<?php echo htmlspecialchars($job['company_name']); ?>)</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Package</label>
                                    <input type="text" name="package" class="form-control" value="<?php echo htmlspecialchars($job['package']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Vacancies</label>
                                    <input type="number" name="vacancies" class="form-control" value="<?php echo htmlspecialchars($job['vacancies']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Date to Apply</label>
                                    <input type="date" name="last_date" class="form-control" value="<?php echo htmlspecialchars($job['last_date']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="Open" <?php echo ($job['status'] == 'Open') ? 'selected' : ''; ?>>Open</option>
                                        <option value="Closed" <?php echo ($job['status'] == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Eligibility Criteria</label>
                                    <textarea name="eligibility" class="form-control" rows="3"><?php echo htmlspecialchars($job['eligibility']); ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Job Description</label>
                                    <textarea name="description" class="form-control" rows="5"><?php echo htmlspecialchars($job['description']); ?></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="update_job" class="btn btn-primary w-100">Save Job Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>