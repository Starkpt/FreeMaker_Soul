<?php


function getProductsByCategory($conn, $categoria = null, $limit = MAX_PRODUCTS_DISPLAY)
{
  $sql = 'SELECT p.ID, c.c_descricao, p.nome, p.descricao, p.preco, MIN(f.foto) AS foto
            FROM produtos AS p
            JOIN fotos AS f ON f.ID_produto = p.ID
            JOIN categorias AS c ON c.ID = p.ID_categoria';

  if ($categoria) {
    $sql .= ' WHERE c.c_descricao = ?';
  }
  $sql .= ' GROUP BY p.ID, p.nome, p.descricao, p.preco';
  if ($limit) {
    $sql .= ' LIMIT ?';
  }

  $stmt = $conn->prepare($sql);

  if ($categoria && $limit) {
    $stmt->bind_param('si', $categoria, $limit);
  } elseif ($categoria) {
    $stmt->bind_param('s', $categoria);
  } elseif ($limit) {
    $stmt->bind_param('i', $limit);
  }

  $stmt->execute();
  return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
