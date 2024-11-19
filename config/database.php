<?php
$server = 'localhost';
$user = 'root';
$pw = '';
$db = 'freemaker_soul';

try {
  $conn = new mysqli($server, $user, $pw, $db);
  $conn->set_charset("utf8");
} catch (Exception $e) {
  global $debug;
  if ($debug) {
    die("Database connection failed: " . $e->getMessage());
  } else {
    echo 'Erro ao tentar ligar ao servidor!';
    exit;
  }
}
