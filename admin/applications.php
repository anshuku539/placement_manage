<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// update status
if (isset($_POST['update_status'])) {
    $app_id = (int)$_POST['app_id'];
    $new_status = clean($conn, $_POST['status']);
    
    // get application details
    $app_query = mysqli_query($conn, "
        SELECT applications.*, jobs.company_id, jobs.package 
        FROM applications 
        INNER JOIN jobs ON applications.job_id = jobs.id 
        WHERE applications.id='$app_id'
    ");
    $app = mysqli_fetch_assoc($app_query);
    
    mysqli_query($conn, "UPDATE applications SET status='$new_status' WHERE id='$app_id'");
    
    // add to selected students if selected
    if ($new_status == 'Selected') {
        // check if already selected
        $check = mysqli_query($conn, "SELECT id FROM selected_students WHERE student_id='".$app['student_id']."' AND job_id='".$app['job_id']."'");
        if (mysqli_num_rows($check) == 0) {
            $date = date("Y-m-d");
            mysqli_query($conn, "
                INSERT INTO selected_students (student_id, company_id, job_id, package, selection_date) 
                VALUES ('".$app['student_id']."', '".$app['company_id']."', '".$app['job_id']."', '".$app['package']."', '$date')
            ");
        }
    } else {
        // remove from selected if status changed
        mysqli_query($conn, "DELETE FROM selected_students WHERE student_id='".$app['student_id']."' AND job_id='".$app['job_id']."'");
    }
    
    $_SESSION['success'] = "Application status updated.";
    redirect("applications.php");
}

// filter applications
$where_clauses = [];
$search = isset($_GET['search']) ? clean($conn, $_GET['search']) : '';
$filter_company = isset($_GET['company']) ? (int)$_GET['company'] : '';
$filter_status = isset($_GET['status']) ? clean($conn, $_GET['status']) : '';

if ($search != '') {
    $where_clauses[] = "(students.name LIKE '%$search%' OR jobs.title LIKE '%$search%')";
}
if ($filter_company != '') {
    $where_clauses[] = "companies.id = '$filter_company'";
}
if ($filter_status != '') {
    $where_clauses[] = "applications.status = '$filter_status'";
}

$where_sql = "";
if (count($where_clauses) > 0) {
    $where_sql = " WHERE " . implode(" AND ", $where_clauses);
}

// Get Companies for filter dropdown
$companies = mysqli_query($conn, "SELECT id, company_name FROM companies ORDER BY company_name");
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Search (Student / Job)</label>
                        <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter by Company</label>
                        <select name="company" class="form-select">
                            <option value="">All Companies</option>
                            <?php while ($comp = mysqli_fetch_assoc($companies)) { ?>
                                <option value="<?php echo $comp['id']; ?>" <?php echo ($filter_company == $comp['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($comp['company_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter by Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="Applied" <?php echo ($filter_status == 'Applied') ? 'selected' : ''; ?>>Applied</option>
                            <option value="Shortlisted" <?php echo ($filter_status == 'Shortlisted') ? 'selected' : ''; ?>>Shortlisted</option>
                            <option value="Selected" <?php echo ($filter_status == 'Selected') ? 'selected' : ''; ?>>Selected</option>
                            <option value="Rejected" <?php echo ($filter_status == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manage Applications</h5>
                <?php if ($search != '' || $filter_company != '' || $filter_status != '') { ?>
                    <a href="applications.php" class="btn btn-sm btn-secondary">Clear Filters</a>
                <?php } ?>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Student Name</th>
                                <th>Company</th>
                                <th>Job Title</th>
                                <th>Applied Date</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "
                                SELECT 
                                    applications.*,
                                    students.name AS student_name,
                                    companies.company_name,
                                    companies.id AS company_id,
                                    jobs.title AS job_title
                                FROM applications
                                INNER JOIN students ON applications.student_id = students.id
                                INNER JOIN jobs ON applications.job_id = jobs.id
                                INNER JOIN companies ON jobs.company_id = companies.id
                                $where_sql
                                ORDER BY applications.applied_at DESC
                            ");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <a href="view-student.php?id=<?php echo $row['student_id']; ?>" class="text-decoration-none">
                                                <strong><?php echo htmlspecialchars($row['student_name']); ?></strong>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="view-company.php?id=<?php echo $row['company_id']; ?>" class="text-decoration-none text-dark">
                                                <?php echo htmlspecialchars($row['company_name']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                                        <td><?php echo date("d M Y h:i A", strtotime($row['applied_at'])); ?></td>
                                        <td>
                                            <form method="POST" class="d-flex align-items-center">
                                                <input type="hidden" name="app_id" value="<?php echo $row['id']; ?>">
                                                <select name="status" class="form-select form-select-sm me-2" style="width: 130px;">
                                                    <option value="Applied" <?php echo ($row['status'] == 'Applied') ? 'selected' : ''; ?>>Applied</option>
                                                    <option value="Shortlisted" <?php echo ($row['status'] == 'Shortlisted') ? 'selected' : ''; ?>>Shortlisted</option>
                                                    <option value="Selected" <?php echo ($row['status'] == 'Selected') ? 'selected' : ''; ?>>Selected</option>
                                                    <option value="Rejected" <?php echo ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                </select>
                                                <button type="submit" name="update_status" class="btn btn-sm btn-success">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No applications found.</td></tr>';
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
