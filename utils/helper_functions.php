<?php

function renderProducts($max_items = null)
{
  // Query for products
  $sql = 'SELECT p.ID, c.c_descricao, p.nome, p.preco, MIN(f.foto) AS foto
            FROM produtos AS p
            JOIN fotos AS f ON f.ID_produto = p.ID
            JOIN categorias AS c ON c.ID = p.ID_categoria
            GROUP BY p.ID, p.nome, p.preco';

  // Store results
  $result = $GLOBALS["conn"]->query($sql);

  echo "<div class='product-sample wrapper'>";

  // Initialize counter
  $count = 0;

  // Loop through results with a `while` loop
  while ($row = $result->fetch_assoc()) {
    // If a max number of items is defined, stop when the limit is reached
    if ($max_items && $count >= $max_items) break;

    // Render product card for each row
    echo productCard($row);

    // Increment counter
    $count++;
  }

  echo "</div>";
}


function renderAddButton()
{
  $addBtn = (isset($_SESSION['adm']) && $_SESSION['adm'] === 1) ? 'Adicionar Produto' : 'Sugerir Produto';
  echo '
        <div class="mais_container wrapper" id="add_container">
          <a href="#" id="add" title="' . htmlspecialchars($addBtn) . '">
            <button class="mais">' . htmlspecialchars($addBtn) . '</button>
          </a>
        </div>
  ';
}