<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// delete selected record
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // reset application status
    $sel_query = mysqli_query($conn, "SELECT student_id, job_id FROM selected_students WHERE id='$id'");
    if (mysqli_num_rows($sel_query) > 0) {
        $sel = mysqli_fetch_assoc($sel_query);
        mysqli_query($conn, "UPDATE applications SET status='Applied' WHERE student_id='" . $sel['student_id'] . "' AND job_id='" . $sel['job_id'] . "'");
    }

    mysqli_query($conn, "DELETE FROM selected_students WHERE id='$id'");
    $_SESSION['success'] = "Record deleted successfully.";
    redirect("selected_students.php");
}

// update package and date
if (isset($_POST['update_record'])) {
    $id = (int)$_POST['id'];
    $package = clean($conn, $_POST['package']);
    $selection_date = clean($conn, $_POST['selection_date']);

    mysqli_query($conn, "UPDATE selected_students SET package='$package', selection_date='$selection_date' WHERE id='$id'");
    $_SESSION['success'] = "Details updated successfully.";
    redirect("selected_students.php");
}
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Selected Students</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Student Details</th>
                                <th>Company & Job</th>
                                <th>Package & Date</th>
                                <th>Update</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $query = mysqli_query($conn, "
                                SELECT 
                                    selected_students.*,
                                    students.name AS student_name,
                                    students.roll_no,
                                    students.course,
                                    companies.company_name,
                                    jobs.title AS job_title
                                FROM selected_students
                                INNER JOIN students ON selected_students.student_id = students.id
                                INNER JOIN companies ON selected_students.company_id = companies.id
                                INNER JOIN jobs ON selected_students.job_id = jobs.id
                                ORDER BY selected_students.selection_date DESC
                            ");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <a href="view-student.php?id=<?php echo $row['student_id']; ?>" class="text-decoration-none">
                                                <strong><?php echo htmlspecialchars($row['student_name']); ?></strong>
                                            </a><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($row['roll_no']); ?> | <?php echo htmlspecialchars($row['course']); ?></small>
                                        </td>
                                        <td>
                                            <a href="view-company.php?id=<?php echo $row['company_id']; ?>" class="text-decoration-none text-dark">
                                                <strong><?php echo htmlspecialchars($row['company_name']); ?></strong>
                                            </a><br>
                                            <small><?php echo htmlspecialchars($row['job_title']); ?></small>
                                        </td>
                                        <form method="POST">
                                            <td>
                                                <input type="text" name="package" class="form-control form-control-sm mb-1" value="<?php echo htmlspecialchars($row['package']); ?>" placeholder="Package" required>
                                                <input type="date" name="selection_date" class="form-control form-control-sm" value="<?php echo htmlspecialchars($row['selection_date']); ?>" required>
                                            </td>
                                            <td>
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="update_record" class="btn btn-sm btn-success w-100">Save</button>
                                            </td>
                                        </form>
                                        <td>
                                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger w-100" onclick="return confirm('Are you sure you want to remove this record?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No selected students found.</td></tr>';
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