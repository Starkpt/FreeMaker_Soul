<?php
include 'config/config.php';
if ($_SESSION) {
    echo json_encode(['logged_in' => true]);
} else
    echo json_encode(['logged_in' => false]);