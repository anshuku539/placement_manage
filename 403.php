<?php
http_response_code(403);
$pageTitle = "403 - Access Forbidden | AGC Placement Management System";
$metaDescription = "You do not have permission to access this resource.";

include_once 'includes/config.php';
include_once 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="py-5 my-5">
    <div class="container text-center py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-sm p-4 p-md-5">
                    <div class="mb-4">
                        <i class="bi bi-shield-lock text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-danger mb-2">403</h1>
                    <h2 class="h4 fw-semibold text-dark mb-3">Access Forbidden</h2>
                    <p class="text-muted mb-4">
                        You do not have permission to access this directory or file. If you believe this is an error, please log in with appropriate credentials or return to the homepage.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="index.php" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-house-door me-1"></i> Go to Homepage
                        </a>
                        <a href="student-login.php" class="btn btn-outline-primary px-4 py-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Student Login
                        </a>
                        <a href="company-login.php" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-building me-1"></i> Company Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
