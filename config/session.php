<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Set session state
$_SESSION["logged_in"] = isset($_SESSION['ID']);
