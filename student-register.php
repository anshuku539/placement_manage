<?php
$pageTitle = "Student Registration";

include 'includes/config.php';
include 'includes/functions.php';

$message = "";
$messageType = "";

if (isset($_POST['register'])) {
    $name = clean($conn, $_POST['name']);
    $roll_no = clean($conn, $_POST['roll_no']);
    $email = clean($conn, $_POST['email']);
    $phone = clean($conn, $_POST['phone']);
    $gender = clean($conn, $_POST['gender']);
    $dob = clean($conn, $_POST['dob']);
    $course = clean($conn, $_POST['course']);
    $semester = clean($conn, $_POST['semester']);

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // check passwords match
    if ($password != $confirm_password) {
        $message = "Passwords do not match.";
        $messageType = "danger";
    } else {
        // check if email already registered
        $check_email = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");

        if (mysqli_num_rows($check_email) > 0) {
            $message = "Email already exists.";
            $messageType = "danger";
        } else {
            // check if roll number already registered
            $check_roll = mysqli_query($conn, "SELECT id FROM students WHERE roll_no='$roll_no'");

            if (mysqli_num_rows($check_roll) > 0) {
                $message = "University Roll Number already exists.";
                $messageType = "danger";
            } else {
                $registration_id = studentId($conn);
                $password = password_hash($password, PASSWORD_DEFAULT);

                $insert = mysqli_query($conn, "INSERT INTO students
                (
                    registration_id,
                    roll_no,
                    name,
                    email,
                    phone,
                    gender,
                    dob,
                    course,
                    semester,
                    password
                )
                VALUES
                (
                    '$registration_id',
                    '$roll_no',
                    '$name',
                    '$email',
                    '$phone',
                    '$gender',
                    '$dob',
                    '$course',
                    '$semester',
                    '$password'
                )");

                if ($insert) {
                    $_SESSION['success'] = "Registration completed successfully. Please login.";
                    header("Location: student-login.php");
                    exit();
                } else {
                    $message = "Something went wrong.";
                    $messageType = "danger";
                }
            }
        }
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Student Registration -->
<section class="register-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <div class="card register-card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold mb-1">Student Registration</h3>
                            <p class="text-muted small mb-0">Create your account to apply for campus placements</p>
                        </div>

                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-<?php echo $messageType; ?> py-2 px-3 mb-3">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>

                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">University Roll Number</label>
                                    <input type="text" name="roll_no" class="form-control" placeholder="Enter roll number" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" maxlength="10" class="form-control" placeholder="10-digit mobile number" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Course</label>
                                    <select name="course" class="form-select" required>
                                        <option value="">Select Course</option>
                                        <option>BCA</option>
                                        <option>B.Tech</option>
                                        <option>BBA</option>
                                        <option>B.Com</option>
                                        <option>MCA</option>
                                        <option>MBA</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Semester</label>
                                    <select name="semester" class="form-select" required>
                                        <option value="">Select Semester</option>
                                        <?php
                                        for ($i = 1; $i <= 8; $i++) {
                                            echo "<option>Semester $i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Enter password" required>
                                        <button type="button" class="password-toggle-btn position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" aria-label="Toggle password visibility">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control pe-5" placeholder="Confirm password" required>
                                        <button type="button" class="password-toggle-btn position-absolute top-50 end-0 translate-middle-y me-3" id="toggleConfirmPassword" aria-label="Toggle confirm password visibility">
                                            <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="register" class="btn btn-primary w-100 py-2 mt-2">
                                Register
                            </button>
                        </form>

                        <hr class="my-4">

                        <p class="text-center mb-0 text-muted small">
                            Already have an account?
                            <a href="student-login.php" class="text-primary fw-semibold">Login Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toggle password script -->
<script>
// Toggle password
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const toggleIcon = document.getElementById('toggleIcon');

if (togglePassword && passwordInput) {
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
}

// Toggle confirm password
const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
const confirmPasswordInput = document.getElementById('confirm_password');
const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

if (toggleConfirmPassword && confirmPasswordInput) {
    toggleConfirmPassword.addEventListener('click', function () {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);
        toggleConfirmIcon.classList.toggle('bi-eye');
        toggleConfirmIcon.classList.toggle('bi-eye-slash');
    });
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
