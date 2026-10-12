<?php
include '../includes/config.php';
include '../includes/functions.php';
include '../includes/student-auth.php';

if (!isset($_GET['id'])) {
    header("Location: jobs.php");
    exit();
}

$job_id = (int)$_GET['id'];
$student_id = $_SESSION['student_id'];

// check if job exists and open
$job = mysqli_query($conn, "
    SELECT id
    FROM jobs
    WHERE id='$job_id'
    AND status='Open'
");

if (mysqli_num_rows($job) == 0) {
    $_SESSION['error'] = "Job not found.";
    header("Location: jobs.php");
    exit();
}

// check if already applied
$check = mysqli_query($conn, "
    SELECT id
    FROM applications
    WHERE job_id='$job_id'
    AND student_id='$student_id'
");

if (mysqli_num_rows($check) > 0) {
    $_SESSION['error'] = "You have already applied for this job.";
    header("Location: jobs.php");
    exit();
}

// submit application
mysqli_query($conn, "
    INSERT INTO applications
    (
        job_id,
        student_id
    )
    VALUES
    (
        '$job_id',
        '$student_id'
    )
");

// send notification
mysqli_query($conn, "
    INSERT INTO notifications
    (
        user_type,
        user_id,
        title,
        message
    )
    VALUES
    (
        'Student',
        '$student_id',
        'Application Submitted',
        'Your job application has been submitted successfully.'
    )
");

$_SESSION['success'] = "You have successfully applied for this job.";
header("Location: jobs.php");
exit();
?>