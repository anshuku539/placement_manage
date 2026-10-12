<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$pages = ['404.php', '403.php', '500.php', 'maintenance.php', 'privacy.php', 'terms.php'];
foreach ($pages as $p) {
    $_SERVER['PHP_SELF'] = '/Placement_manage/' . $p;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    ob_start();
    include $p;
    $out = ob_get_clean();
    $has_err = false;
    foreach (['Notice:', 'Warning:', 'Fatal error:', 'Deprecated:', 'Parse error:'] as $err) {
        if (stripos($out, $err) !== false) {
            echo "ERROR in $p ($err)\n";
            $has_err = true;
        }
    }
    if (!$has_err) {
        echo "$p: " . strlen($out) . " bytes [CLEAN]\n";
    }
}
unlink(__FILE__);
