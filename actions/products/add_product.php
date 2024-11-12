<?php
$nome = htmlentities($_POST['nome_prod']);
$descricao = htmlentities($_POST['descricao']);
$preco = floatval($_POST['preco']); // Ensure price is a float
$categoria = intval($_POST['categoria']); // Ensure category is an integer
$filamentos = array_filter($_POST['filamento']); // Filter out empty values
$cores = array_filter($_POST['cor']); // Filter out empty values
$utilizador = $_SESSION['ID'];

print_r(
  $nome,
  $descricao,
  $preco,
  $categoria,
  $filamentos,
  $cores,
  $utilizador,
);


$tudoOk = true;
$tudoOk_STL = true;

$conn->begin_transaction();

// Insert product
$stmt = $conn->prepare('INSERT INTO produtos (nome, descricao, preco, ID_categoria, ID_utilizador) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('ssdii', $nome, $descricao, $preco, $categoria, $utilizador);
$stmt->execute();

$tudoOk &= $stmt->affected_rows > 0;

if (!$tudoOk) {
  $_SESSION['error_msg'] = 'Faltaram parâmetros na inserção do produto';
  $conn->rollback();
  header('Location: utils/insert_prod.php?msg=insert_error');
  exit;
}

$ID_produto = $conn->insert_id;

// Fetch category name for folder structure
$stmt = $conn->prepare('SELECT c.c_descricao FROM categorias AS c JOIN produtos AS p ON p.ID_categoria = c.ID WHERE p.ID = ?');
$stmt->bind_param('i', $ID_produto);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$categoria_nome = $row['c_descricao'] ?? 'default';

$folder = 'assets/imgs/produtos/' . $categoria_nome . '/';

if (!is_dir($folder)) {
  mkdir($folder, 0777, true);
}

// Upload and insert product images
if (!empty($_FILES['foto']['name'][0])) {
  foreach ($_FILES['foto']['name'] as $key => $imagem) {
    $extension = strtolower(pathinfo($_FILES['foto']['name'][$key], PATHINFO_EXTENSION));
    if (!in_array($extension, ['jpg', 'jpeg', 'bmp', 'png', 'tiff', 'gif'])) {
      $_SESSION['error_msg'] = 'Ficheiro não permitido!!';
      $tudoOk = false;
      break;
    }

    $unique_name = uniqid() . '.' . $extension;
    if (!move_uploaded_file($_FILES['foto']['tmp_name'][$key], $folder . $unique_name)) {
      $_SESSION['error_msg'] = 'Não foi possível adicionar foto';
      $tudoOk = false;
      break;
    }

    $stmt_img = $conn->prepare('INSERT INTO fotos (ID_produto, foto) VALUES (?, ?)');
    $stmt_img->bind_param('is', $ID_produto, $unique_name);
    $stmt_img->execute();
    $tudoOk &= $stmt_img->affected_rows > 0;
  }
}

// Link filaments and colors
if (!empty($filamentos) && !empty($cores) && count($filamentos) === count($cores)) {
  $stmt_fil_cor = $conn->prepare('INSERT INTO produtos_filamentos_cores (ID_produto, ID_filamento, ID_cor) VALUES (?, ?, ?)');

  foreach ($filamentos as $key => $ID_filamento) {
    $ID_cor = $cores[$key];
    $stmt_fil_cor->bind_param('iii', $ID_produto, $ID_filamento, $ID_cor);
    $stmt_fil_cor->execute();
    $tudoOk &= $stmt_fil_cor->affected_rows > 0;
  }
} else {
  $_SESSION['error_msg'] = 'Faltou associar filamento(s) e/ou cor(es)';
  $tudoOk = false;
}

// Upload and insert STL files
$stl_folder = 'ficheiros_stl/';
if (!is_dir($stl_folder)) {
  mkdir($stl_folder, 0777, true);
}

if (!empty($_FILES['ficheiro']['name'][0])) {
  foreach ($_FILES['ficheiro']['name'] as $key => $ficheiro) {
    $extension = strtolower(pathinfo($_FILES['ficheiro']['name'][$key], PATHINFO_EXTENSION));

    if ($extension !== 'stl') {
      $_SESSION['error_msg'] = 'Ficheiro não permitido!!';
      $tudoOk_STL = false;
      break;
    }

    $unique_stl_name = uniqid() . '.' . $extension;
    if (!move_uploaded_file($_FILES['ficheiro']['tmp_name'][$key], $stl_folder . $unique_stl_name)) {
      $_SESSION['error_msg'] = 'Não foi possível adicionar o ficheiro STL';
      $tudoOk_STL = false;
      break;
    }

    $stmt_f = $conn->prepare('INSERT INTO ficheiros_stl (ID_produto, ficheiro) VALUES (?, ?)');
    $stmt_f->bind_param('is', $ID_produto, $unique_stl_name);
    $stmt_f->execute();
    $tudoOk_STL &= $stmt_f->affected_rows > 0;
  }
} else {
  $_SESSION['info_msg'] = 'Nenhum ficheiro STL foi introduzido. Pode ser adicionado posteriormente.';
}

// Finalize transaction
if ($tudoOk && $tudoOk_STL) {
  $conn->commit();
  $_SESSION['success_msg'] = 'Produto inserido com sucesso!';
  header('Location: utils/insert_prod.php?msg=insert_success');
} else {
  $conn->rollback();
  $_SESSION['error_msg'] = 'Não foi possível introduzir o produto';
  header('Location: utils/insert_prod.php?msg=insert_error');
}
exit;
