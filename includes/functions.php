<?php
// Common functions for Placement Management System

// clean input data
function clean($conn, $data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// redirect helper
function redirect($page)
{
    header("Location: " . $page);
    exit();
}

// generate student id
function studentId($conn)
{
    $result = mysqli_query($conn, "SELECT id FROM students ORDER BY id DESC LIMIT 1");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'] + 1;
    } else {
        $id = 1;
    }

    return "STU" . str_pad($id, 5, "0", STR_PAD_LEFT);
}

// generate company code
function companyCode($conn)
{
    $result = mysqli_query($conn, "SELECT id FROM companies ORDER BY id DESC LIMIT 1");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'] + 1;
    } else {
        $id = 1;
    }

    return "COMP" . str_pad($id, 4, "0", STR_PAD_LEFT);
}

// upload image
function uploadImage($file, $folder)
{
    if ($file['error'] == 0) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = array("jpg", "jpeg", "png", "webp");

        if (in_array($ext, $allowed)) {
            $filename = time() . "_" . rand(1000, 9999) . "." . $ext;
            $path = $folder . "/" . $filename;

            if (move_uploaded_file($file['tmp_name'], $path)) {
                return $filename;
            }
        }
    }

    return "";
}

// show session messages
function showMessage()
{
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
}

// get cms image path with fallback
function getCmsImage($filename, $subfolder = '', $default = 'assets/images/hero.png')
{
    $prefix = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../' : '';

    if (empty($filename)) {
        if (empty($default)) return '';
        return (strpos($default, '../') === 0 || empty($prefix)) ? $default : $prefix . $default;
    }

    if (file_exists($prefix . 'assets/uploads/cms/' . $filename)) {
        return $prefix . 'assets/uploads/cms/' . $filename;
    }
    if (!empty($subfolder) && file_exists($prefix . 'assets/images/' . $subfolder . '/' . $filename)) {
        return $prefix . 'assets/images/' . $subfolder . '/' . $filename;
    }
    if (file_exists($prefix . 'assets/images/' . $filename)) {
        return $prefix . 'assets/images/' . $filename;
    }

    if (empty($default)) return '';
    return (strpos($default, '../') === 0 || empty($prefix)) ? $default : $prefix . $default;
}
?>
