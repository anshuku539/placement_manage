<?php
include 'includes/company-header.php';
include 'includes/company-sidebar.php';

// Handle Delete Job
if (isset($_GET['delete'])) {
    $job_id = (int)$_GET['delete'];
    
    // Verify job belongs to this company
    $check = mysqli_query($conn, "SELECT id FROM jobs WHERE id='$job_id' AND company_id='" . $_SESSION['company_id'] . "'");
    
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM jobs WHERE id='$job_id'");
        $_SESSION['success'] = "Job deleted successfully.";
    } else {
        $_SESSION['error'] = "Unauthorized action.";
    }
    
    redirect("jobs.php");
}

// Handle Status Toggle (Open/Closed)
if (isset($_GET['toggle_status'])) {
    $job_id = (int)$_GET['toggle_status'];
    
    // Verify job belongs to this company
    $check = mysqli_query($conn, "SELECT id, status FROM jobs WHERE id='$job_id' AND company_id='" . $_SESSION['company_id'] . "'");
    
    if (mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        $new_status = ($row['status'] == 'Open') ? 'Closed' : 'Open';
        
        mysqli_query($conn, "UPDATE jobs SET status='$new_status' WHERE id='$job_id'");
        $_SESSION['success'] = "Job status updated to $new_status.";
    }
    
    redirect("jobs.php");
}
?>

<div class="main-content">
    <?php include 'includes/company-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Posted Jobs</h3>
            <a href="post-job.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Post New Job
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Package</th>
                                <th>Vacancies</th>
                                <th>Status</th>
                                <th>Last Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "
                                SELECT *
                                FROM jobs
                                WHERE company_id='" . $_SESSION['company_id'] . "'
                                ORDER BY created_at DESC
                            ");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                                        <td><?php echo htmlspecialchars($row['package']); ?></td>
                                        <td><?php echo $row['vacancies']; ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'Open') { ?>
                                                <span class="badge bg-success">Open</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger">Closed</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date("d M Y", strtotime($row['last_date'])); ?></td>
                                        <td>
                                            <a href="?toggle_status=<?php echo $row['id']; ?>" class="btn btn-sm btn-<?php echo ($row['status'] == 'Open') ? 'warning' : 'success'; ?> me-1" title="Toggle Status">
                                                <i class="bi bi-<?php echo ($row['status'] == 'Open') ? 'lock' : 'unlock'; ?>"></i>
                                            </a>
                                            <!-- Simple Delete -->
                                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this job? This will also remove all related applications.');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No jobs posted yet.
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/company-footer.php'; ?>
