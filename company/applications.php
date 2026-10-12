<?php
include 'includes/company-header.php';
include 'includes/company-sidebar.php';

// update status
if (isset($_POST['update_status'])) {
    $app_id = (int)$_POST['application_id'];
    $new_status = clean($conn, $_POST['status']);
    
    // verify company owns this job
    $check = mysqli_query($conn, "
        SELECT applications.id, applications.student_id, applications.job_id, jobs.title 
        FROM applications 
        INNER JOIN jobs ON applications.job_id = jobs.id 
        WHERE applications.id='$app_id' AND jobs.company_id='" . $_SESSION['company_id'] . "'
    ");
    
    if (mysqli_num_rows($check) > 0) {
        $app = mysqli_fetch_assoc($check);
        
        mysqli_query($conn, "UPDATE applications SET status='$new_status' WHERE id='$app_id'");
        
        // notify student
        $msg = "Your application status for " . $app['title'] . " has been updated to: $new_status";
        mysqli_query($conn, "
            INSERT INTO notifications (user_type, user_id, title, message)
            VALUES ('Student', '{$app['student_id']}', 'Application Status Update', '$msg')
        ");
        
        // add to selected students if selected
        if ($new_status == 'Selected') {
            $check_sel = mysqli_query($conn, "SELECT id FROM selected_students WHERE student_id='{$app['student_id']}' AND job_id='{$app['job_id']}'");
            if (mysqli_num_rows($check_sel) == 0) {
                mysqli_query($conn, "
                    INSERT INTO selected_students (student_id, company_id, job_id, selection_date)
                    VALUES ('{$app['student_id']}', '{$_SESSION['company_id']}', '{$app['job_id']}', CURDATE())
                ");
            }
        }
        
        $_SESSION['success'] = "Application status updated.";
    } else {
        $_SESSION['error'] = "Unauthorized action.";
    }
    
    redirect("applications.php");
}
?>

<div class="main-content">
    <?php include 'includes/company-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Job Applications</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Student Details</th>
                                <th>Academics</th>
                                <th>Job Applied For</th>
                                <th>Resume</th>
                                <th>Current Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            $query = mysqli_query($conn, "
                                SELECT 
                                    applications.*,
                                    students.name AS student_name,
                                    students.email,
                                    students.phone,
                                    students.course,
                                    students.semester,
                                    students.cgpa,
                                    students.resume,
                                    jobs.title AS job_title
                                FROM applications
                                INNER JOIN students ON applications.student_id = students.id
                                INNER JOIN jobs ON applications.job_id = jobs.id
                                WHERE jobs.company_id='" . $_SESSION['company_id'] . "'
                                ORDER BY applications.applied_at DESC
                            ");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['student_name']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($row['email']); ?></small><br>
                                            <small><?php echo htmlspecialchars($row['phone']); ?></small>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['course']); ?> - Sem: <?php echo htmlspecialchars($row['semester']); ?><br>
                                            CGPA: <?php echo htmlspecialchars($row['cgpa']); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($row['job_title']); ?><br>
                                            <small class="text-muted"><?php echo date("d M Y", strtotime($row['applied_at'])); ?></small>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['resume'])) { ?>
                                                <a href="../assets/uploads/students/<?php echo $row['resume']; ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-file-earmark-pdf"></i> View
                                                </a>
                                            <?php } else { ?>
                                                <span class="text-muted">Not Uploaded</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['status'] == "Applied") {
                                                echo '<span class="badge bg-primary">Applied</span>';
                                            } elseif ($row['status'] == "Shortlisted") {
                                                echo '<span class="badge bg-warning text-dark">Shortlisted</span>';
                                            } elseif ($row['status'] == "Selected") {
                                                echo '<span class="badge bg-success">Selected</span>';
                                            } else {
                                                echo '<span class="badge bg-danger">Rejected</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <form method="POST" class="d-flex align-items-center">
                                                <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                                                <select name="status" class="form-select form-select-sm me-2" required>
                                                    <option value="">Update Status</option>
                                                    <option value="Applied" <?php if ($row['status'] == 'Applied') echo 'selected'; ?>>Applied</option>
                                                    <option value="Shortlisted" <?php if ($row['status'] == 'Shortlisted') echo 'selected'; ?>>Shortlisted</option>
                                                    <option value="Rejected" <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                                    <option value="Selected" <?php if ($row['status'] == 'Selected') echo 'selected'; ?>>Selected</option>
                                                </select>
                                                <button type="submit" name="update_status" class="btn btn-sm btn-primary">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No applications received yet.
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
