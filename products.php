<?php
$title = "Produtos";
include 'components/header/header.php';
include "components/product_card/product_card.php";

if (@$_SESSION['adm'] === 1) {
  $add_btn = 'Adicionar Produto';
} else {
  $add_btn = 'Sugerir Produto';
}

@$categoria = $_GET['categoria'];

?>

<div class="mais_container wrapper" id="add_container">
  <a href="#" id="add" title="<?= $add_btn ?>">
    <button class="mais"><?= $add_btn ?></button>
  </a>
</div>

<div class="product-sample wrapper">
  <?php
  $sql = 'SELECT p.ID, c.c_descricao, p.nome, p.descricao, p.preco, MIN(f.foto) AS foto
            FROM produtos AS p
            JOIN fotos AS f ON f.ID_produto = p.ID
            JOIN categorias AS c ON c.ID = p.ID_categoria';
  if ($categoria)
    $sql .= ' WHERE c.c_descricao = ?';

  $sql .= ' GROUP BY p.ID, p.nome, p.descricao, p.preco';
  $stmt = $conn->prepare($sql);

  if ($categoria)
    $stmt->bind_param('s', $categoria);


  $stmt->execute();
  $result = $stmt->get_result();



  while ($row = $result->fetch_assoc()) {
    if ($row) {
      echo productCard($row);
    }
  }
  ?>
</div>


<?php include 'components/footer/footer.php'; ?>