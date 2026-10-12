<?php

if (!isset($_SESSION['company_id'])) {
    header("Location: ../company-login.php");
    exit();
}

?>