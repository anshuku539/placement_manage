<?php
include 'includes/company-header.php';
include 'includes/company-sidebar.php';

$message = "";
$messageType = "";

if (isset($_POST['post_job'])) {
    $title = clean($conn, $_POST['title']);
    $location = clean($conn, $_POST['location']);
    $package = clean($conn, $_POST['package']);
    $vacancies = (int)$_POST['vacancies'];
    $eligibility = clean($conn, $_POST['eligibility']);
    $description = clean($conn, $_POST['description']);
    $last_date = clean($conn, $_POST['last_date']);
    $company_id = $_SESSION['company_id'];

    $insert = mysqli_query($conn, "
        INSERT INTO jobs (
            company_id, 
            title, 
            location, 
            package, 
            vacancies, 
            eligibility, 
            description, 
            last_date, 
            status
        ) VALUES (
            '$company_id', 
            '$title', 
            '$location', 
            '$package', 
            '$vacancies', 
            '$eligibility', 
            '$description', 
            '$last_date', 
            'Open'
        )
    ");

    if ($insert) {
        $_SESSION['success'] = "Job posted successfully.";
        redirect("jobs.php");
    } else {
        $message = "Unable to post job.";
        $messageType = "danger";
    }
}
?>

<div class="main-content">
    <?php include 'includes/company-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Post a New Job</h4>
            </div>

            <div class="card-body">
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Package (e.g., 5 LPA)</label>
                            <input type="text" name="package" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vacancies</label>
                            <input type="number" name="vacancies" class="form-control" min="1" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Date to Apply</label>
                            <input type="date" name="last_date" class="form-control" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Eligibility Criteria</label>
                            <textarea name="eligibility" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label">Job Description</label>
                            <textarea name="description" rows="5" class="form-control" required></textarea>
                        </div>
                    </div>

                    <button type="submit" name="post_job" class="btn btn-primary">
                        Post Job
                    </button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/company-footer.php'; ?>
