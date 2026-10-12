<?php
$pageTitle = "Privacy Policy | AGC Placement Management System";
$metaDescription = "Read the Privacy Policy of the AGC Placement Management System regarding student and company data protection.";

include_once 'includes/config.php';
include_once 'includes/functions.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<main>
    <!-- Page Banner -->
    <section class="page-banner">
        <div class="container text-center">
            <h1>Privacy Policy</h1>
            <p>How we handle, safeguard, and respect your personal and academic information.</p>
        </div>
    </section>

    <!-- Policy Content -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm p-4 p-md-5">
                        <h4 class="fw-bold text-primary mb-3">1. Information We Collect</h4>
                        <p class="text-muted mb-4">
                            The Placement Management System collects student details (including names, university roll numbers, contact details, academic percentages, and uploaded resumes) and company information (company name, recruiter contact, and hiring requirements) solely for campus placement purposes.
                        </p>

                        <h4 class="fw-bold text-primary mb-3">2. How Information is Used</h4>
                        <p class="text-muted mb-4">
                            Collected data is used exclusively to evaluate job eligibility, facilitate applications between students and verified recruiters, announce recruitment drives, and maintain placement cell records.
                        </p>

                        <h4 class="fw-bold text-primary mb-3">3. Data Sharing & Disclosure</h4>
                        <p class="text-muted mb-4">
                            Student resumes and academic credentials are only shared with approved recruiting companies when the student voluntarily applies for an open job posting. We do not sell, rent, or trade student or employer information to third parties.
                        </p>

                        <h4 class="fw-bold text-primary mb-3">4. Account Security</h4>
                        <p class="text-muted mb-4">
                            All user passwords are encrypted using secure cryptographic hashing (`password_hash`). Users are responsible for keeping their login credentials confidential.
                        </p>

                        <h4 class="fw-bold text-primary mb-3">5. Contact Information</h4>
                        <p class="text-muted mb-0">
                            If you have questions regarding this Privacy Policy, please contact the Placement Cell at <strong>placement@agc.ac.in</strong> or visit our Training & Placement office.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
