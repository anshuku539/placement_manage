<?php
include 'includes/company-header.php';
include 'includes/company-sidebar.php';

$message = "";
$type = "";

if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (password_verify($current, $company['password'])) {
        if ($new == $confirm) {
            $password = password_hash($new, PASSWORD_DEFAULT);

            mysqli_query($conn, "
                UPDATE companies
                SET password='$password'
                WHERE id='" . $_SESSION['company_id'] . "'
            ");

            $message = "Password changed successfully.";
            $type = "success";
        } else {
            $message = "New password and confirm password do not match.";
            $type = "danger";
        }
    } else {
        $message = "Current password is incorrect.";
        $type = "danger";
    }
}
?>

<div class="main-content">
    <?php include 'includes/company-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Settings</h4>
            </div>

            <div class="card-body">
                <?php if ($message != "") { ?>
                    <div class="alert alert-<?php echo $type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" name="change_password" class="btn btn-primary">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/company-footer.php'; ?>
