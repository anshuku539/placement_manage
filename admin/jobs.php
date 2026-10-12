<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM jobs WHERE id='$id'");
    $_SESSION['success'] = "Job deleted successfully.";
    redirect("jobs.php");
}

// Handle Search
$search_query = "";
if (isset($_GET['search'])) {
    $search = clean($conn, $_GET['search']);
    $search_query = " WHERE jobs.title LIKE '%$search%' OR companies.company_name LIKE '%$search%' ";
}
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manage Jobs</h4>

                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Jobs..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    <?php if (isset($_GET['search'])) { ?>
                        <a href="jobs.php" class="btn btn-sm btn-secondary ms-2">Clear</a>
                    <?php } ?>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location & Package</th>
                                <th>Vacancies</th>
                                <th>Last Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "
                                SELECT jobs.*, companies.company_name 
                                FROM jobs 
                                INNER JOIN companies ON jobs.company_id = companies.id 
                                $search_query
                                ORDER BY jobs.created_at DESC
                            ");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                                        <td>
                                            Loc: <?php echo htmlspecialchars($row['location']); ?><br>
                                            Pkg: <?php echo htmlspecialchars($row['package']); ?>
                                        </td>
                                        <td><?php echo $row['vacancies']; ?></td>
                                        <td><?php echo date("d M Y", strtotime($row['last_date'])); ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'Open') { ?>
                                                <span class="badge bg-success">Open</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger">Closed</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="edit-job.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white mb-1" title="Edit Job">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this job?');" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center">No jobs found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>