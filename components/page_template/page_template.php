<?php
include $_SERVER["DOCUMENT_ROOT"] . "/config.php";
include $_SERVER["DOCUMENT_ROOT"] . "/components/product_card/product_card.php";

$adm = $_SESSION['adm'] ?? null;
$error_msg = $_SESSION['error_msg'] ?? '';
$info_msg = $_SESSION['info_msg'] ?? '';

$current_page = basename($_SERVER['PHP_SELF']);

function renderPage($title = null)
{
  ob_start(); // Start output buffering
?>
  <!DOCTYPE html>
  <html lang="pt-PT">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ? $title . " - " : $title ?><?= $GLOBALS['site_name']; ?></title>

    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
  </head>

  <body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/components/header/header.php'; ?>

    <div class="banner">
      <div class="wrapper">
        <h1><?= $GLOBALS['site_name']; ?></h1>
        <hr class="sep">
      </div>
    </div>

    <div class="product-sample wrapper">
      <?php

      // Query for products
      $sql = 'SELECT p.ID, c.c_descricao, p.nome, p.preco, MIN(f.foto) AS foto
                FROM produtos AS p
                JOIN fotos AS f ON f.ID_produto = p.ID
                JOIN categorias AS c ON c.ID = p.ID_categoria
                GROUP BY p.ID, p.nome, p.preco';

      // Store results
      $result = $GLOBALS["conn"]->query($sql);

      // Display up to 4 products
      $count = 0;

      while ($row = $result->fetch_assoc()) {

        // Render only the first 4 items
        if ($count >= 4) break;

        // Render component
        echo productCard($row);

        $count++; // Increment counter
      }
      ?>
    </div>

    <div class="mais_container wrapper">
      <a href="products.php" title="Ver mais produtos">
        <button class="mais">Ver mais produtos</button>
      </a>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/components/footer/footer.php'; ?>

    <script>
      // Scroll to top button functionality
      const mybutton = document.getElementById("topBtn");
      window.onscroll = function() {
        scrollFunction()
      };

      function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
          mybutton.style.display = "block";
        } else {
          mybutton.style.display = "none";
        }
      }

      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
  </body>

  </html>
<?php

  return ob_get_clean(); // Return the buffered output as a string
}
?>