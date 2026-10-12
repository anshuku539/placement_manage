<?php
http_response_code(500);
$pageTitle = "500 - Internal Server Error | AGC Placement Management System";
$metaDescription = "Something went wrong on our servers. Please try again shortly.";

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
                        <i class="bi bi-gear-wide-connected text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h1 class="display-4 fw-bold text-dark mb-2">500</h1>
                    <h2 class="h4 fw-semibold text-dark mb-3">Internal Server Error</h2>
                    <p class="text-muted mb-4">
                        Our server encountered an unexpected situation while processing your request. Please refresh the page or try again in a few moments.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="index.php" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-house-door me-1"></i> Go to Homepage
                        </a>
                        <a href="contact.php" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-headset me-1"></i> Report Issue
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
