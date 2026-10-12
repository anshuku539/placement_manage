<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// delete student
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    mysqli_query($conn, "DELETE FROM students WHERE id='$id'");
    
    $_SESSION['success'] = "Student deleted successfully.";
    redirect("students.php");
}

// search query
$search_query = "";
if (isset($_GET['search'])) {
    $search = clean($conn, $_GET['search']);
    $search_query = " WHERE name LIKE '%$search%' OR roll_no LIKE '%$search%' ";
}
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manage Students</h4>
                
                <form method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search by Name or Roll No" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    <?php if (isset($_GET['search'])) { ?>
                        <a href="students.php" class="btn btn-sm btn-secondary ms-2">Clear</a>
                    <?php } ?>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Reg. ID</th>
                                <th>Roll No</th>
                                <th>Student Details</th>
                                <th>Academics</th>
                                <th>Profile</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "SELECT * FROM students $search_query ORDER BY created_at DESC");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['registration_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($row['email']); ?></small><br>
                                            <small><?php echo htmlspecialchars($row['phone']); ?></small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['course']); ?> (Sem <?php echo htmlspecialchars($row['semester']); ?>)<br>
                                            CGPA: <?php echo htmlspecialchars($row['cgpa']); ?>
                                        </td>
                                        <td>
                                            <?php if ($row['profile_completed'] == 1) { ?>
                                                <span class="badge bg-success">Completed</span>
                                            <?php } else { ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="view-student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info text-white mb-1">
                                                <i class="bi bi-eye"></i> View/Edit
                                            </a>
                                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this student?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No students found.</td></tr>';
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
