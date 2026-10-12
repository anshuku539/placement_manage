<?php
include 'includes/student-header.php';
include 'includes/student-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/student-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3 class="mb-3 mb-md-0">Available Jobs</h3>

            <form method="GET" class="d-flex">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search Job..."
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </form>
        </div>

        <div class="row">
            <?php
            $search = "";

            if (isset($_GET['search'])) {
                $search = clean($conn, $_GET['search']);
            }

            $sql = "
                SELECT
                    jobs.*,
                    companies.company_name
                FROM jobs
                INNER JOIN companies
                ON jobs.company_id = companies.id
                WHERE jobs.status='Open'
            ";

            if ($search != "") {
                $sql .= " AND jobs.title LIKE '%$search%' ";
            }

            $sql .= " ORDER BY jobs.created_at DESC";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($job = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-3">
                                <h5 class="mb-2 text-primary">
                                    <?php echo htmlspecialchars($job['title']); ?>
                                </h5>

                                <p class="mb-1 small">
                                    <strong>Company:</strong>
                                    <?php echo htmlspecialchars($job['company_name']); ?>
                                </p>

                                <p class="mb-1 small">
                                    <strong>Location:</strong>
                                    <?php echo htmlspecialchars($job['location']); ?>
                                </p>

                                <p class="mb-1 small">
                                    <strong>Package:</strong>
                                    <?php echo htmlspecialchars($job['package']); ?>
                                </p>

                                <p class="mb-3 small">
                                    <strong>Last Date:</strong>
                                    <?php echo date("d M Y", strtotime($job['last_date'])); ?>
                                </p>

                                <div class="d-flex gap-2">
                                    <a href="job-details.php?id=<?php echo $job['id']; ?>" class="btn btn-outline-primary btn-sm w-50">
                                        View Details
                                    </a>
                                    <a href="apply-job.php?id=<?php echo $job['id']; ?>" class="btn btn-primary btn-sm w-50">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No jobs available.
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include 'includes/student-footer.php'; ?>