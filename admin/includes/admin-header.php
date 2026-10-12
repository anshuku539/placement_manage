<?php
include '../includes/config.php';
include '../includes/functions.php';
include '../includes/admin-auth.php';

$current_page = basename($_SERVER['PHP_SELF']);
$result = mysqli_query($conn, "
    SELECT *
    FROM admin
    WHERE id='" . $_SESSION['admin_id'] . "'
");

$admin = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
