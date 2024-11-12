<?php
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/' || $requestUri === '/index') {
  include $_SERVER["DOCUMENT_ROOT"] . '/';
  exit;
}

// Products page
if ($requestUri === '/products') {
  include $_SERVER["DOCUMENT_ROOT"] . '/public/products/products.php';
  exit;
}

// Add product
if ($requestUri === '/add_product') {
  include $_SERVER["DOCUMENT_ROOT"] . '/public/products/add_product.php';
  exit;
}

// Optional: Add a default case if no match is found
http_response_code(404);
echo "Page not found.";
exit;
