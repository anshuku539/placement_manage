<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Placement_manage";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database Connection Failed.");
}

if (!defined("BASE_URL")) {
    define("BASE_URL", "http://localhost/Placement_manage/");
}
?>
