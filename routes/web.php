<?php
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/' || $requestUri === '/index') {
  include 'index.php';
  exit;
}

// Add other routing cases as needed
if ($requestUri === '/products') {
  include  $_SERVER["DOCUMENT_ROOT"] . '/public/products/products.php';
  exit;
}

// Optional: Add a default case if no match is found
http_response_code(404);
echo "Page not found.";
exit;
