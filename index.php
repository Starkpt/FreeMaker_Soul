<?php
include $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/product_card/product_card.php";

require_once 'public/produtos/product_helpers.php';
require_once 'includes/product_card/product_card.php';
require_once "utils/helper-functions.php";

$adm = $_SESSION['adm'] ?? null;
$error_msg = $_SESSION['error_msg'] ?? '';
$info_msg = $_SESSION['info_msg'] ?? '';

$current_page = "Home";

?>

<!DOCTYPE html>
<html lang="pt-PT">

<?php include  $_SERVER["DOCUMENT_ROOT"] . "/templates/head.php" ?>

<body>
  <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/header/header.php'; ?>

  <div class="banner">
    <div class="wrapper">
      <h1><?= $GLOBALS['site_name']; ?></h1>
      <hr class="sep">
    </div>
  </div>

  <?php renderHomeProducts(4); ?>

  <div class="mais_container wrapper">
    <a href="products.php" title="Ver mais produtos">
      <button class="mais">Ver mais produtos</button>
    </a>
  </div>

  <?php include $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php'; ?>

</body>

</html>