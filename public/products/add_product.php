<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/product_card/product_card.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/utils/helper_functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/public/products/product_helpers.php";
$title = "Adicionar produto";

// Functions to render dynamic parts of the form
function renderInputBox($name, $placeholder)
{
    echo "<div class='input-box' id='input-box'>
            <input type='text' name='$name' placeholder='$placeholder'>
          </div>";
}

function renderFileUploadSection()
{
    echo "<div class='input-box' id='input-box'>
            <label for='ficheiro'>Ficheiro STL:</label>
            <div class='stl_files' id='stl_files'></div>
            <input class='stl' type='file' id='ficheiro' name='ficheiro[]' accept='.stl' style='display:none;' multiple>
            <button class='stl_btn'>Escolher Ficheiros</button>
          </div>
          <div class='add_btn_container' id='add_btn_container' style='display: none;'>
            <div class='add_btn'>
              <img src='assets/imgs/icons/add.png' alt='Botão de adicionar ficheiro' title='Adicionar mais ficheiros'>
            </div>
          </div>";
}

function renderCategoriaSelect($conn)
{
    echo "<div class='input-box' id='input-box'>
            <select name='categoria'>
              <option value=''>Escolha uma categoria</option>";
    $result = $conn->query('SELECT ID, c_descricao FROM categorias');
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['ID']}'>{$row['c_descricao']}</option>";
    }
    echo "</select></div>";
}

?>

<!DOCTYPE html>
<html lang="pt-PT">

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/templates/head.php'; ?>

<body>
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/navbar/navbar.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/login.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/signup.php';
    ?>
    <?php print_r($_SESSION["adm"]); ?>
    <div class="insert_product_container">
        <form class="insert_product" id="insert_product"
            action="<?= $_SESSION['adm'] ? '/public/products/add_product' : '/actions/actions.php?act=sugest_product' ?>"
            method="POST" enctype="multipart/form-data">
            <div class="insert_title wrapper">
                <?= $_SESSION['adm'] ? 'Adicionar Produto' : 'Pedido de orçamento' ?>
                <hr>
            </div>

            <?php
            renderInputBox("nome_prod", "Nome do produto");

            if ($_SESSION['adm']) {
                include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_descricao.php';
                include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_images.php';
                include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_categorias.php';
                include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_filamento.php';
                include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_cor.php';

                echo "<div class='preco input-box' id='input-box'>
                        <label for='preco'>Preço (€):</label>
                        <input name='preco'>
                      </div>";
            } else {
                echo "<div class='input-box'><textarea class='descricao' name='descricao' rows='4' placeholder='Descrição do produto'></textarea></div>";
                renderCategoriaSelect($conn);
            }

            renderFileUploadSection();
            ?>

            <div>
                <button id="btn" class="btn" type="submit">Inserir Produto</button>
            </div>
        </form>
    </div>

    <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php'; ?>

    <script src="./add_product_js.php"></script>
</body>

</html>