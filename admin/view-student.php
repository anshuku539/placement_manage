<?php
include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';

if (!isset($_GET['id'])) {
    redirect("students.php");
}

$id = (int)$_GET['id'];

// Handle Update
if (isset($_POST['update_student'])) {
    $name = clean($conn, $_POST['name']);
    $roll_no = clean($conn, $_POST['roll_no']);
    $email = clean($conn, $_POST['email']);
    $phone = clean($conn, $_POST['phone']);
    $gender = clean($conn, $_POST['gender']);
    $dob = clean($conn, $_POST['dob']);
    $course = clean($conn, $_POST['course']);
    $semester = clean($conn, $_POST['semester']);
    $cgpa = clean($conn, $_POST['cgpa']);
    $skills = clean($conn, $_POST['skills']);
    $profile_completed = isset($_POST['profile_completed']) ? 1 : 0;

    $query = "UPDATE students SET 
        name='$name', roll_no='$roll_no', email='$email', phone='$phone', 
        gender='$gender', dob='$dob', course='$course', semester='$semester', 
        cgpa='$cgpa', skills='$skills', profile_completed='$profile_completed' 
        WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Student details updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating student: " . mysqli_error($conn);
    }
    
    redirect("view-student.php?id=$id");
}

// Fetch student data
$student_query = mysqli_query($conn, "SELECT * FROM students WHERE id='$id'");
if (mysqli_num_rows($student_query) == 0) {
    redirect("students.php");
}
$student = mysqli_fetch_assoc($student_query);
?>

<div class="main-content">
    <?php include 'includes/admin-topbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Student Profile: <?php echo htmlspecialchars($student['name']); ?></h4>
            <a href="students.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        </div>

        <?php showMessage(); ?>

        <div class="row">
            <!-- Edit Form -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Edit Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Roll Number</label>
                                    <input type="text" name="roll_no" class="form-control" value="<?php echo htmlspecialchars($student['roll_no']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($student['phone']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        <option value="Other" <?php echo ($student['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($student['dob']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Course</label>
                                    <input type="text" name="course" class="form-control" value="<?php echo htmlspecialchars($student['course']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Semester</label>
                                    <input type="text" name="semester" class="form-control" value="<?php echo htmlspecialchars($student['semester']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">CGPA</label>
                                    <input type="number" step="0.01" name="cgpa" class="form-control" value="<?php echo htmlspecialchars($student['cgpa']); ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Skills</label>
                                    <textarea name="skills" class="form-control" rows="2"><?php echo htmlspecialchars($student['skills']); ?></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="profile_completed" id="profileComplete" <?php echo ($student['profile_completed'] == 1) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="profileComplete">Profile Completed (Allows student to apply for jobs)</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="update_student" class="btn btn-primary w-100">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Side Info -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Resume</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php
                        $resumeFolder = '../assets/uploads/students/';
                        $resumeFileName = !empty($student['resume']) ? trim($student['resume']) : '';
                        $resumePath = $resumeFolder . $resumeFileName;
                        $resumeUrl = $resumeFolder . rawurlencode($resumeFileName);

                        $resumeExists = !empty($resumeFileName) && (file_exists($resumePath) || file_exists(__DIR__ . '/' . $resumePath));
                        ?>

                        <?php if ($resumeExists) { ?>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <a href="<?php echo htmlspecialchars($resumeUrl); ?>" target="_blank" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i> View Resume
                                </a>
                                <a href="<?php echo htmlspecialchars($resumeUrl); ?>" download class="btn btn-success">
                                    <i class="bi bi-download"></i> Download Resume
                                </a>
                            </div>
                        <?php } elseif (!empty($resumeFileName)) { ?>
                            <p class="text-danger mb-0"><i class="bi bi-exclamation-circle me-1"></i>Resume file not found.</p>
                        <?php } else { ?>
                            <p class="text-muted mb-0">No resume uploaded.</p>
                        <?php } ?>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Applied Jobs</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php
                            $apps = mysqli_query($conn, "
                                SELECT jobs.title, companies.company_name, applications.status 
                                FROM applications 
                                INNER JOIN jobs ON applications.job_id = jobs.id 
                                INNER JOIN companies ON jobs.company_id = companies.id 
                                WHERE applications.student_id='$id'
                                ORDER BY applications.applied_at DESC
                            ");
                            
                            if (mysqli_num_rows($apps) > 0) {
                                while ($app = mysqli_fetch_assoc($apps)) {
                            ?>
                                    <li class="list-group-item">
                                        <strong><?php echo htmlspecialchars($app['title']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($app['company_name']); ?></small><br>
                                        <?php
                                            if ($app['status'] == "Applied") echo '<span class="badge bg-primary">Applied</span>';
                                            elseif ($app['status'] == "Shortlisted") echo '<span class="badge bg-warning text-dark">Shortlisted</span>';
                                            elseif ($app['status'] == "Selected") echo '<span class="badge bg-success">Selected</span>';
                                            else echo '<span class="badge bg-danger">Rejected</span>';
                                        ?>
                                    </li>
                            <?php
                                }
                            } else {
                                echo '<li class="list-group-item text-center text-muted">No applications yet.</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>
