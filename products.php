<?php
require_once 'config.php';
require_once 'product_helpers.php';
require_once 'components/product_card/product_card.php';
require_once "helper-functions.php";

$current_page = "Produtos";
$categoria = $_GET['categoria'] ?? null;


echo '
<!DOCTYPE html>
<html lang="pt-PT">';

include "components/page_template/head.php";

echo '<body>';

include 'components/header/header.php';

echo renderAddButton();
echo renderHomeProducts();
echo renderFooter();

echo '
<script src="includes/js/main.js"></script>
</body>
</html>';
