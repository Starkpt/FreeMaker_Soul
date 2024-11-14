<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/config/config.php';

$requestUri = $_SERVER['REQUEST_URI'];


// Function to check if the user is authenticated
function isAuthenticated()
{
  return isset($_SESSION["ID"]);
}


if ($requestUri === '/' || $requestUri === '/index') {
  include $_SERVER["DOCUMENT_ROOT"] . '/';
  exit;
}

// Products page
if ($requestUri === '/products') {
  include $_SERVER["DOCUMENT_ROOT"] . '/public/products/products.php';
  exit;
}

// Product details page
if ($requestUri === '/product_details') {
  include $_SERVER["DOCUMENT_ROOT"] . '/public/products/product_details.php';
  exit;
}

// Add product
if ($requestUri === '/add_product') {
  if (isAuthenticated()) {
    include $_SERVER["DOCUMENT_ROOT"] . '/public/products/add_product.php';
  } else {
    // If not authenticated, redirect to the login page
    include $_SERVER["DOCUMENT_ROOT"] . '/index.php';
    header('Location: /');
    exit;
  }
}

// Optional: Add a default case if no match is found
http_response_code(404);
echo "Page not found.";
exit;
