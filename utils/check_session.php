<?php
include $_SERVER["DOCUMENT_ROOT"] . '/config/config.php';

if ($_SESSION) {
    echo json_encode(['logged_in' => true]);
} else
    echo json_encode(['logged_in' => false]);
