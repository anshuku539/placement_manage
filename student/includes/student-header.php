<?php
include '../includes/config.php';
include '../includes/functions.php';
include '../includes/student-auth.php';

$current_page = basename($_SERVER['PHP_SELF']);
$result = mysqli_query($conn, "
    SELECT *
    FROM students
    WHERE id='" . $_SESSION['student_id'] . "'
");

$student = mysqli_fetch_assoc($result);

$photo = "../assets/images/default-user.png";

if (!empty($student['profile_photo'])) {
    $photo = "../assets/uploads/students/" . $student['profile_photo'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>