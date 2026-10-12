<?php
$pageTitle = "Company Login";

include 'includes/config.php';
include 'includes/functions.php';

$message = "";
$messageType = "";

if (isset($_POST['login'])) {
    $email = clean($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM companies WHERE email = '$email'");

    if (mysqli_num_rows($query) == 1) {
        $company = mysqli_fetch_assoc($query);

        if (password_verify($password, $company['password'])) {

            // Check status
            if ($company['status'] == 'Pending') {
                $message = "Your account is waiting for admin approval.";
                $messageType = "warning";
            } elseif ($company['status'] == 'Rejected') {
                $message = "Your company registration has been rejected.";
                $messageType = "danger";
            } elseif ($company['status'] == 'Approved') {
                // Successful login
                $_SESSION['company_id'] = $company['id'];
                $_SESSION['company_name'] = $company['company_name'];

                header("Location: company/dashboard.php");
                exit();
            }
        } else {
            $message = "Invalid password.";
            $messageType = "danger";
        }
    } else {
        $message = "Email not found.";
        $messageType = "danger";
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Company Login -->
<section class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                <div class="card login-card">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold mb-1">Company Login</h3>
                            <p class="text-muted small mb-0">Enter your credentials to access your account</p>
                        </div>

                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-<?php echo $messageType; ?> py-2 px-3 mb-3">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>

                        <?php showMessage(); ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="company@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Enter your password" required>
                                    <button type="button" class="password-toggle-btn position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" aria-label="Toggle password visibility">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary w-100 py-2 mt-2">
                                Login
                            </button>
                        </form>

                        <hr class="my-4">

                        <p class="text-center mb-0 text-muted small">
                            Don't have an account?
                            <a href="company-register.php" class="text-primary fw-semibold">Register Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toggle password -->
<script>
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const toggleIcon = document.getElementById('toggleIcon');

if (togglePassword && passwordInput) {
    togglePassword.addEventListener('click', function () {
        // Toggle input type
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle eye icon
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>