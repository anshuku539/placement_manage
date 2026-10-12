<?php
http_response_code(503);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Maintenance | AGC Placement Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-sm p-4 p-md-5">
                    <div class="mb-4">
                        <i class="bi bi-tools text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="h3 fw-bold text-dark mb-3">Under Scheduled Maintenance</h2>
                    <p class="text-muted mb-4">
                        The AGC Placement Management System is currently undergoing routine maintenance and upgrades to serve you better. We will be back online shortly.
                    </p>
                    <div class="alert alert-info d-inline-block text-start small mb-4">
                        <i class="bi bi-info-circle me-1"></i> For urgent placement enquiries, please reach out to:
                        <br><strong>Email:</strong> placement@agc.ac.in
                    </div>
                    <div>
                        <button onclick="window.location.reload();" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
