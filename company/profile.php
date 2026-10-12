<?php
include 'includes/company-header.php';

$message = "";
$messageType = "";

if (isset($_POST['update_profile'])) {
    $company_name = clean($conn, $_POST['company_name']);
    $hr_name = clean($conn, $_POST['hr_name']);
    $phone = clean($conn, $_POST['phone']);
    $website = clean($conn, $_POST['website']);
    $address = clean($conn, $_POST['address']);

    $logo = "";

    // upload logo
    if (!empty($_FILES['logo']['name'])) {
        $logo = time() . "_" . $_FILES['logo']['name'];

        move_uploaded_file(
            $_FILES['logo']['tmp_name'],
            "../assets/uploads/companies/" . $logo
        );

        mysqli_query($conn, "
            UPDATE companies
            SET logo='$logo'
            WHERE id='" . $_SESSION['company_id'] . "'
        ");
    }

    $update = mysqli_query($conn, "
        UPDATE companies
        SET
        company_name='$company_name',
        hr_name='$hr_name',
        phone='$phone',
        website='$website',
        address='$address'
        WHERE id='" . $_SESSION['company_id'] . "'
    ");

    if ($update) {
        $message = "Profile updated successfully.";
        $messageType = "success";
        
        // Refresh company data
        $result = mysqli_query($conn, "SELECT * FROM companies WHERE id='" . $_SESSION['company_id'] . "'");
        $company = mysqli_fetch_assoc($result);
    } else {
        $message = "Unable to update profile.";
        $messageType = "danger";
    }
}

include 'includes/company-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/company-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">Company Profile</h4>
            </div>

            <div class="card-body">
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Company Logo -->
                        <div class="col-lg-3 text-center mb-4">
                            <?php
                            $logo_img = !empty($company['logo'])
                                ? "../assets/uploads/companies/" . $company['logo']
                                : "../assets/images/default-user.png";
                            ?>
                            <img src="<?php echo $logo_img; ?>" class="profile-image mb-3">
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <!-- Company Details -->
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company Code</label>
                                    <input type="text" class="form-control" value="<?php echo $company['company_code']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?php echo $company['email']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">HR Name</label>
                                    <input type="text" name="hr_name" class="form-control" value="<?php echo htmlspecialchars($company['hr_name']); ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($company['phone']); ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Website</label>
                                    <input type="text" name="website" class="form-control" value="<?php echo htmlspecialchars($company['website']); ?>">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" rows="3" class="form-control"><?php echo htmlspecialchars($company['address']); ?></textarea>
                                </div>
                            </div>

                            <button type="submit" name="update_profile" class="btn btn-primary">
                                Update Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/company-footer.php'; ?>
