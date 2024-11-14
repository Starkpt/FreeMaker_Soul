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
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header/header.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/login.php';
  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/signup.php';

  renderAddButton();
  renderProducts();

  require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php';
  ?>
</body>

</html>