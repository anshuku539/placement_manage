<?php
include 'includes/student-header.php';
include 'includes/student-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/student-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">My Applications</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Package</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            $query = mysqli_query($conn, "
                                SELECT
                                    applications.*,
                                    jobs.title,
                                    jobs.package,
                                    companies.company_name
                                FROM applications
                                INNER JOIN jobs
                                    ON applications.job_id = jobs.id
                                INNER JOIN companies
                                    ON jobs.company_id = companies.id
                                WHERE applications.student_id='" . $_SESSION['student_id'] . "'
                                ORDER BY applications.applied_at DESC
                            ");

                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['package']); ?></td>
                                        <td><?php echo date("d M Y", strtotime($row['applied_at'])); ?></td>
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
                                            <a href="job-details.php?id=<?php echo $row['job_id']; ?>" class="btn btn-sm btn-outline-primary">
                                                View Job
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No applications found.
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

<?php include 'includes/student-footer.php'; ?>