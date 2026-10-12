<?php
$pageTitle = "Admin Login";

include '../includes/config.php';
include '../includes/functions.php';

$message = "";
$messageType = "";

if (isset($_POST['login'])) {
    $username = clean($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

    if (mysqli_num_rows($query) == 1) {
        $admin = mysqli_fetch_assoc($query);

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
            $messageType = "danger";
        }
    } else {
        $message = "Username not found.";
        $messageType = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">

<section class="py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4>Admin Panel</h4>
                            <p class="text-muted">Placement Management System</p>
                        </div>

                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-<?php echo $messageType; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>
                        
                        <hr>
                        <div class="text-center">
                            <a href="../index.php" class="text-decoration-none">← Back to Website</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
