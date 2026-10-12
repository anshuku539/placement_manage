<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

// Handle Profile Update
if (isset($_POST['update_profile'])) {
    $name = clean($conn, $_POST['name']);
    $username = clean($conn, $_POST['username']);
    
    // Check if username exists for other admins
    $check = mysqli_query($conn, "SELECT id FROM admin WHERE username='$username' AND id != '".$_SESSION['admin_id']."'");
    
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['error'] = "Username already taken.";
    } else {
        $profile_image = $admin['profile_image'];
        
        // Handle Image Upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            // Ensure the directory exists
            $upload_dir = __DIR__ . '/../assets/uploads/admin/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $uploaded = uploadImage($_FILES['profile_image'], '../assets/uploads/admin');
            if ($uploaded) {
                // Delete old image if exists
                if ($profile_image && file_exists('../assets/uploads/admin/' . $profile_image)) {
                    unlink('../assets/uploads/admin/' . $profile_image);
                }
                $profile_image = $uploaded;
            } else {
                $_SESSION['error'] = "Invalid image format or size.";
            }
        }
        
        if (!isset($_SESSION['error'])) {
            mysqli_query($conn, "
                UPDATE admin 
                SET name='$name', username='$username', profile_image='$profile_image'
                WHERE id='".$_SESSION['admin_id']."'
            ");
            
            $_SESSION['admin_name'] = $name;
            $_SESSION['success'] = "Profile updated successfully.";
            
            // Refresh admin details
            $admin['name'] = $name;
            $admin['username'] = $username;
            $admin['profile_image'] = $profile_image;
        }
    }
    
    redirect("profile.php");
}

// Handle Password Update
if (isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if (password_verify($current, $admin['password'])) {
        if ($new == $confirm) {
            $password = password_hash($new, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE admin SET password='$password' WHERE id='" . $_SESSION['admin_id'] . "'");
            $_SESSION['success'] = "Password changed successfully.";
            $admin['password'] = $password;
        } else {
            $_SESSION['error'] = "New password and confirm password do not match.";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
    }
    redirect("profile.php");
}
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <?php showMessage(); ?>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Admin Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="text-center mb-4">
                                <?php if (!empty($admin['profile_image']) && file_exists('../assets/uploads/admin/' . $admin['profile_image'])) { ?>
                                    <img src="../assets/uploads/admin/<?php echo htmlspecialchars($admin['profile_image']); ?>" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;">
                                <?php } else { ?>
                                    <img src="../assets/images/default-user.png" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;">
                                <?php } ?>
                                <input type="file" name="profile_image" class="form-control form-control-sm mx-auto w-75" accept="image/jpeg, image/png">
                                <small class="text-muted">Max size: 2MB. Leave empty to keep current photo.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                            </div>

                            <button type="submit" name="update_profile" class="btn btn-primary w-100">
                                Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Change Password</h5>
                    </div>
                    <div class="card-body">
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

                            <button type="submit" name="change_password" class="btn btn-danger w-100">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
