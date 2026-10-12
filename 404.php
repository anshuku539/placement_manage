<?php
http_response_code(404);
$pageTitle = "404 - Page Not Found | AGC Placement Management System";
$metaDescription = "The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.";

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
                        <i class="bi bi-compass text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-primary mb-2">404</h1>
                    <h2 class="h4 fw-semibold text-dark mb-3">Page Not Found</h2>
                    <p class="text-muted mb-4">
                        The page you are looking for might have been moved, renamed, or no longer exists. Please verify the URL or navigate back using the options below.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="index.php" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-house-door me-1"></i> Go to Homepage
                        </a>
                        <a href="jobs.php" class="btn btn-outline-primary px-4 py-2">
                            <i class="bi bi-briefcase me-1"></i> Browse Jobs
                        </a>
                        <a href="contact.php" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-envelope me-1"></i> Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
