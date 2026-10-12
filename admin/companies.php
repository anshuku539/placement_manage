<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// company actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];
    
    if ($action == 'approve') {
        mysqli_query($conn, "UPDATE companies SET status='Approved' WHERE id='$id'");
        $_SESSION['success'] = "Company approved successfully.";
    } elseif ($action == 'reject') {
        mysqli_query($conn, "UPDATE companies SET status='Rejected' WHERE id='$id'");
        $_SESSION['success'] = "Company rejected.";
    } elseif ($action == 'delete') {
        mysqli_query($conn, "DELETE FROM companies WHERE id='$id'");
        $_SESSION['success'] = "Company deleted successfully.";
    }
    
    redirect("companies.php");
}

// search query
$search_query = "";
if (isset($_GET['search'])) {
    $search = clean($conn, $_GET['search']);
    $search_query = " WHERE company_name LIKE '%$search%' OR hr_name LIKE '%$search%' OR email LIKE '%$search%' OR company_code LIKE '%$search%' ";
}
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manage Companies</h4>
                
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Companies..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    <?php if (isset($_GET['search'])) { ?>
                        <a href="companies.php" class="btn btn-sm btn-secondary ms-2">Clear</a>
                    <?php } ?>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Code</th>
                                <th>Company Info</th>
                                <th>Contact Details</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "SELECT * FROM companies $search_query ORDER BY created_at DESC");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['company_code']); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['company_name']); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($row['website']); ?></small>
                                        </td>
                                        <td>
                                            HR: <?php echo htmlspecialchars($row['hr_name']); ?><br>
                                            <small><?php echo htmlspecialchars($row['email']); ?></small><br>
                                            <small><?php echo htmlspecialchars($row['phone']); ?></small>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 'Approved') { ?>
                                                <span class="badge bg-success">Approved</span>
                                            <?php } elseif ($row['status'] == 'Rejected') { ?>
                                                <span class="badge bg-danger">Rejected</span>
                                            <?php } else { ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] != 'Approved') { ?>
                                                <a href="?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success mb-1" title="Approve">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                            <?php } ?>
                                            
                                            <?php if ($row['status'] != 'Rejected') { ?>
                                                <a href="?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-1" title="Reject">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                            <?php } ?>

                                            <a href="view-company.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white mb-1" title="View/Edit">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this company?');" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No companies found.</td></tr>';
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
