<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/config/config.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/product_card/product_card.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/utils/helper_functions.php";

include $_SERVER["DOCUMENT_ROOT"] . "/public/products/product_helpers.php";

$title = "Produtos";
$categoria = $_GET['categoria'] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-PT">

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/templates/head.php" ?>

<body>
  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/navbar/navbar.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/login.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/signup.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/add_product.php';

  ?>
  <div class="container container-md p-5 px-2 mb-5">

    <?php
    renderAddButton();
    renderProducts();
    ?>
  </div>

  <?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php';
  ?>
</body>

</html>