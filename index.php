<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/product_card/product_card.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/utils/helper_functions.php";

include $_SERVER["DOCUMENT_ROOT"] . "/public/products/product_helpers.php";

$title = "Home";
?>

<!DOCTYPE html>
<html lang="pt-PT">

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/templates/head.php" ?>

<body>
  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header/header.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/login.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/signup.php';
  ?>

  <div class="banner">
    <div class="wrapper">
      <h1><?= SITE_NAME ?></h1>
      <hr class="sep">
    </div>
  </div>

  <?php renderProducts(4); ?>

  <div class="mais_container wrapper">
    <a href="/products" title="Ver mais produtos">
      <button class="mais">Ver mais produtos</button>
    </a>
  </div>

  <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php'; ?>
</body>

</html>