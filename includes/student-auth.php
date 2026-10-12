<?php

if (!isset($_SESSION['student_id'])) {
    header("Location: ../student-login.php");
    exit();
}

?>