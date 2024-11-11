<?php
require_once  $_SERVER["DOCUMENT_ROOT"] . '/config/config.php';
require_once  'product_helpers.php';
require_once  $_SERVER["DOCUMENT_ROOT"] . '/includes/product_card/product_card.php';
require_once  $_SERVER["DOCUMENT_ROOT"] . "/utils/helper-functions.php";

$current_page = "Produtos";
$categoria = $_GET['categoria'] ?? null;


echo '
<!DOCTYPE html>
<html lang="pt-PT">';

include  $_SERVER["DOCUMENT_ROOT"] . "/templates/head.php";

echo '<body>';

include  $_SERVER["DOCUMENT_ROOT"] . '/includes/header/header.php';

echo renderAddButton();
echo renderHomeProducts();
echo renderFooter();

echo '
<script src="/utils/main.js"></script>
</body>
</html>';
