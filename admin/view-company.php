<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

if (!isset($_GET['id'])) {
    redirect("companies.php");
}

$id = (int)$_GET['id'];

// Handle Update
if (isset($_POST['update_company'])) {
    $company_name = clean($conn, $_POST['company_name']);
    $hr_name = clean($conn, $_POST['hr_name']);
    $email = clean($conn, $_POST['email']);
    $phone = clean($conn, $_POST['phone']);
    $website = clean($conn, $_POST['website']);
    $address = clean($conn, $_POST['address']);

    $query = "UPDATE companies SET 
        company_name='$company_name', hr_name='$hr_name', email='$email', 
        phone='$phone', website='$website', address='$address'
        WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Company details updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating company: " . mysqli_error($conn);
    }
    
    redirect("view-company.php?id=$id");
}

// Handle Status Change
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE companies SET status='Approved' WHERE id='$id'");
        $_SESSION['success'] = "Company approved successfully.";
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE companies SET status='Rejected' WHERE id='$id'");
        $_SESSION['success'] = "Company rejected.";
    }
    redirect("view-company.php?id=$id");
}

// Fetch company data
$company_query = mysqli_query($conn, "SELECT * FROM companies WHERE id='$id'");
if (mysqli_num_rows($company_query) == 0) {
    redirect("companies.php");
}
$company = mysqli_fetch_assoc($company_query);
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Company Profile: <?php echo htmlspecialchars($company['company_name']); ?></h4>
            <div>
                <?php if ($company['status'] != 'Approved') { ?>
                    <a href="?id=<?php echo $id; ?>&action=approve" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Approve</a>
                <?php } ?>
                <?php if ($company['status'] != 'Rejected') { ?>
                    <a href="?id=<?php echo $id; ?>&action=reject" class="btn btn-warning btn-sm"><i class="bi bi-x-circle"></i> Reject</a>
                <?php } ?>
                <a href="companies.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
        </div>

        <?php showMessage(); ?>

        <div class="row">
            <!-- Edit Form -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Edit Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-12 text-center mb-3">
                                    <?php if (!empty($company['logo']) && file_exists('../uploads/' . $company['logo'])) { ?>
                                        <img src="../uploads/<?php echo $company['logo']; ?>" alt="Logo" height="80">
                                    <?php } else { ?>
                                        <span class="text-muted">No Logo Uploaded</span>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">HR Name</label>
                                    <input type="text" name="hr_name" class="form-control" value="<?php echo htmlspecialchars($company['hr_name']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($company['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($company['phone']); ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Website</label>
                                    <input type="url" name="website" class="form-control" value="<?php echo htmlspecialchars($company['website']); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control" rows="2"><?php echo htmlspecialchars($company['address']); ?></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="update_company" class="btn btn-primary w-100">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Side Info -->
            <div class="col-lg-5 mb-4">
                <!-- Posted Jobs -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Posted Jobs</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $jobs = mysqli_query($conn, "SELECT id, title, status FROM jobs WHERE company_id='$id' ORDER BY created_at DESC LIMIT 5");
                            if (mysqli_num_rows($jobs) > 0) {
                                while ($job = mysqli_fetch_assoc($jobs)) {
                            ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="edit-job.php?id=<?php echo $job['id']; ?>" class="text-decoration-none text-dark">
                                            <strong><?php echo htmlspecialchars($job['title']); ?></strong>
                                        </a>
                                        <?php if ($job['status'] == 'Open') { ?>
                                            <span class="badge bg-success">Open</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger">Closed</span>
                                        <?php } ?>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No jobs posted yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="jobs.php?search=<?php echo urlencode($company['company_name']); ?>" class="text-decoration-none">View All Jobs</a>
                    </div>
                </div>

                <!-- Received Applications -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Applications</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $apps = mysqli_query($conn, "
                                SELECT students.name, jobs.title, applications.status 
                                FROM applications 
                                INNER JOIN students ON applications.student_id = students.id
                                INNER JOIN jobs ON applications.job_id = jobs.id
                                WHERE jobs.company_id='$id'
                                ORDER BY applications.applied_at DESC LIMIT 5
                            ");
                            
                            if (mysqli_num_rows($apps) > 0) {
                                while ($app = mysqli_fetch_assoc($apps)) {
                            ?>
                                    <li class="list-group-item">
                                        <strong><?php echo htmlspecialchars($app['name']); ?></strong><br>
                                        <small class="text-muted">For: <?php echo htmlspecialchars($app['title']); ?></small>
                                        <span class="badge bg-secondary float-end"><?php echo $app['status']; ?></span>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No applications received.</li>';
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
