<?php
// Set the page title
$title = "Produtos";

// Include components
include 'components/header/header.php';
include "components/product_card/product_card.php";

// Define button label based on session 'adm' status
$add_btn = (isset($_SESSION['adm']) && $_SESSION['adm'] === 1) ? 'Adicionar Produto' : 'Sugerir Produto';

// Get category filter if it exists
$categoria = $_GET['categoria'] ?? null;

// Database query to get products
function getProducts($conn, $categoria = null)
{
  $sql = 'SELECT p.ID, c.c_descricao, p.nome, p.descricao, p.preco, MIN(f.foto) AS foto
            FROM produtos AS p
            JOIN fotos AS f ON f.ID_produto = p.ID
            JOIN categorias AS c ON c.ID = p.ID_categoria';

  // Add condition if a category is specified
  if ($categoria) {
    $sql .= ' WHERE c.c_descricao = ?';
  }

  $sql .= ' GROUP BY p.ID, p.nome, p.descricao, p.preco';

  // Prepare and execute query
  $stmt = $conn->prepare($sql);

  if ($categoria) {
    $stmt->bind_param('s', $categoria);
  }

  $stmt->execute();
  return $stmt->get_result();
}

// Fetch products from database
$result = getProducts($conn, $categoria);

?>

<!-- HTML Output -->
<div class="mais_container wrapper" id="add_container">
  <a href="#" id="add" title="<?= htmlspecialchars($add_btn) ?>">
    <button class="mais"><?= htmlspecialchars($add_btn) ?></button>
  </a>
</div>

<div class="product-sample wrapper">
  <?php while ($row = $result->fetch_assoc()): ?>
    <?= productCard($row); ?>
  <?php endwhile; ?>
</div>

<?php include 'components/footer/footer.php'; ?>