<?php
include 'includes/student-header.php';


$message = "";
$messageType = "";

if (isset($_POST['update_profile'])) {
    $phone = clean($conn, $_POST['phone']);
    $gender = clean($conn, $_POST['gender']);
    $dob = clean($conn, $_POST['dob']);
    $cgpa = clean($conn, $_POST['cgpa']);
    $skills = clean($conn, $_POST['skills']);

    $photo_name = "";
    $resume = "";

    // upload photo
    if (!empty($_FILES['profile_photo']['name'])) {
        $photo_name = time() . "_" . $_FILES['profile_photo']['name'];

        move_uploaded_file(
            $_FILES['profile_photo']['tmp_name'],
            "../assets/uploads/students/" . $photo_name
        );

        mysqli_query($conn, "
            UPDATE students
            SET profile_photo='$photo_name'
            WHERE id='" . $_SESSION['student_id'] . "'
        ");
    }

    // upload resume
    if (!empty($_FILES['resume']['name'])) {
        $extension = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));

        if ($extension == "pdf") {
            $resume = time() . "_" . $_FILES['resume']['name'];

            move_uploaded_file(
                $_FILES['resume']['tmp_name'],
                "../assets/uploads/students/" . $resume
            );

            mysqli_query($conn, "
                UPDATE students
                SET resume='$resume'
                WHERE id='" . $_SESSION['student_id'] . "'
            ");
        }
    }

    $update = mysqli_query($conn, "
        UPDATE students
        SET
        phone='$phone',
        gender='$gender',
        dob='$dob',
        cgpa='$cgpa',
        skills='$skills',
        profile_completed='1'
        WHERE id='" . $_SESSION['student_id'] . "'
    ");

    if ($update) {
        $message = "Profile updated successfully.";
        $messageType = "success";
    } else {
        $message = "Unable to update profile.";
        $messageType = "danger";
    }
}

include 'includes/student-sidebar.php';
?>

<div class="main-content">
    <?php include 'includes/student-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h4 class="mb-0">My Profile</h4>
            </div>

            <div class="card-body">
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php } ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Profile Photo -->
                        <div class="col-lg-3 text-center mb-4">
                            <?php
                            $photo = !empty($student['profile_photo'])
                                ? "../assets/uploads/students/" . $student['profile_photo']
                                : "../assets/images/default-user.png";
                            ?>
                            <img src="<?php echo $photo; ?>" class="profile-image mb-3">
                            <input type="file" name="profile_photo" class="form-control">
                        </div>

                        <!-- Personal Details -->
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Registration ID</label>
                                    <input type="text" class="form-control" value="<?php echo $student['registration_id']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">University Roll Number</label>
                                    <input type="text" class="form-control" value="<?php echo $student['roll_no']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" value="<?php echo $student['name']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?php echo $student['email']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo $student['phone']; ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option <?php if ($student['gender'] == "Male") echo "selected"; ?>>Male</option>
                                        <option <?php if ($student['gender'] == "Female") echo "selected"; ?>>Female</option>
                                        <option <?php if ($student['gender'] == "Other") echo "selected"; ?>>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="<?php echo $student['dob']; ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Course</label>
                                    <input type="text" class="form-control" value="<?php echo $student['course']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Semester</label>
                                    <input type="text" class="form-control" value="<?php echo $student['semester']; ?>" readonly>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CGPA</label>
                                    <input type="text" name="cgpa" class="form-control" value="<?php echo $student['cgpa']; ?>">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Skills</label>
                                    <textarea name="skills" rows="4" class="form-control"><?php echo $student['skills']; ?></textarea>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label">Resume (PDF)</label>
                                    <?php
                                    $resumeFolder = '../assets/uploads/students/';
                                    $resumeFile = !empty($resume) ? trim($resume) : (!empty($student['resume']) ? trim($student['resume']) : '');
                                    $resumePath = $resumeFolder . $resumeFile;
                                    $resumeUrl = $resumeFolder . rawurlencode($resumeFile);

                                    $resumeExists = !empty($resumeFile) && (file_exists($resumePath) || file_exists(__DIR__ . '/' . $resumePath));
                                    ?>
                                    <?php if ($resumeExists) { ?>
                                        <div class="mb-2">
                                            <a href="<?php echo htmlspecialchars($resumeUrl); ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                <i class="bi bi-eye"></i> View Resume
                                            </a>
                                            <a href="<?php echo htmlspecialchars($resumeUrl); ?>" download class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <input type="file" name="resume" class="form-control">
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

<?php include 'includes/student-footer.php'; ?>