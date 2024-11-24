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
  <?= print_r($_SESSION) ?>
  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/navbar/navbar.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/login.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/signup.php';
  ?>

  <div class="banner">
    <div class="container-md pt-5">
      <h1><?= SITE_NAME ?></h1>
      <hr class="ruler">
    </div>
  </div>

  <div class="container container-md p-5 px-2">
    <?php renderProducts(5); ?>

    <div class="more-products pt-4">
      <a href="/products" title="Ver mais produtos">
        <!-- <button class="mais">Ver mais produtos</button> -->
        <button class="btn btn-outline-primary">Ver mais produtos</button>
      </a>
    </div>
  </div>

  <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php'; ?>
</body>

</html>