<?php
define('PROJECT_ROOT', $_SERVER["DOCUMENT_ROOT"]);

// Include required files
require_once PROJECT_ROOT . '/config/constants.php';
require_once PROJECT_ROOT . '/config/database.php';
require_once PROJECT_ROOT . '/config/session.php';
require_once PROJECT_ROOT . '/includes/helpers.php';

// ** Debugging Settings **
$debug = true;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Set headers and character encoding
header('Content-Type: text/html; charset=UTF-8');
