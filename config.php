<?php
// ** Set headers and character encoding **
header('Content-Type: text/html; charset=UTF-8');
header("title: asdjapfoaisjdao");

// ** Configuration Settings **
$debug = true;
$server = 'localhost';
$user = 'root';
$pw = '';
$db = 'freemaker_soul';
$site_name = "Freemaker Soul";

// ** Define Constants **
define('SALT', '@#$7:d@erR_er€');
define('ROOT_PATH', __DIR__); // Uses current directory for relative paths
define('MAX_PRODUCTS_DISPLAY', 4); // Max items to display on homepage

// ** Debug Settings **
if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ** Database Connection **
try {
    $conn = new mysqli($server, $user, $pw, $db);
    $conn->set_charset("utf8");
} catch (Exception $e) {
    if ($debug) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        echo 'Erro ao tentar ligar ao servidor!';
        exit;
    }
}

// ** Start Session If Not Already Started **
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}