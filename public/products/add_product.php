<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/product_card/product_card.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/utils/helper_functions.php";

include $_SERVER["DOCUMENT_ROOT"] . "/public/products/product_helpers.php";

$title = "Adicionar produto";
?>

<!DOCTYPE html>
<html lang="pt-PT">

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/templates/head.php" ?>

<body>
    <?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/header/header.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/login.php';
    require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/modals/signup.php';
    ?>

    <?php if ($_SESSION['adm']) { ?>

        <div class="insert_product_container">
            <form class="insert_product" id="insert_product" action="/actions/products/add_product" method="POST" enctype="multipart/form-data">
                <!-- <form class="insert_product" id="insert_product" action="/utils/actions.php?act=insert_product" method="POST" enctype="multipart/form-data"> -->
                <div class="insert_title wrapper">
                    Adicionar Produto<br>
                    <hr>
                </div>
                <div class="input-box" id="input-box">
                    <input type="text" name="nome_prod" placeholder="Nome do produto">
                </div>

                <!-- DESCRIÇÃO INPUT -->
                <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_descricao.php'; ?>

                <!-- IMAGES INPUT -->
                <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_images.php'; ?>

                <div class="preco input-box" id="input-box">
                    <label for="preco">Preço (€):</label>
                    <input name="preco">
                    <!-- <input type="number" name="preco" step="0.1" min="0"> -->
                </div>

                <!-- CATEGORIA INPUT -->
                <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_categorias.php'; ?>

                <!-- FILAMENTO INPUT -->
                <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_filamento.php'; ?>

                <!-- COLOR INPUT -->
                <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_cor.php'; ?>

                <div class="input-box" id="input-box">
                    <label for="ficheiro">Ficheiro STL:</label>
                    <div class="stl_files" id="stl_files"></div>
                    <input class="stl" type="file" id="ficheiro" name="ficheiro[]" accept=".stl" style="display:none;" multiple>
                    <button class="stl_btn">Escolher Ficheiros</button>
                </div>

                <div class="add_btn_container" id="add_btn_container" style="display: none;">
                    <div class="add_btn">
                        <img src="assets/imgs/icons/add.png" alt="Botão de adicionar ficheiro" title="Adicionar mais ficheiros">
                    </div>
                </div>

                <div>
                    <button id="btn" class="btn" type="submit">Inserir Produto</button>
                </div>
            </form>
        </div>

    <?php } else { ?>

        <div class="insert_product_container">
            <form class="insert_product" id="insert_product" action="/utils/actions.php?act=sugest_product" method="POST" enctype="multipart/form-data">
                <div class="insert_title wrapper">
                    Pedido de orçamento
                    <hr>
                </div>
                <div class="input-box" id="input-box">
                    <input type="text" name="nome_prod" placeholder="Nome do produto">
                </div>
                <div class="input-box">
                    <textarea class="descricao" name="descricao" rows="4" placeholder="Descrição do produto"></textarea>
                </div>
                <div class="input-box" id="input-box">
                    <select name="categoria">
                        <option value="">Escolha uma categoria</option>
                        <?php
                        $result = $conn->query('SELECT ID, c_descricao FROM categorias');
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?= $row['ID'] ?>"><?= $row['c_descricao'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="input-box" id="input-box">
                    <label for="ficheiro">Ficheiro STL:</label>
                    <input class="stl" type="file" id="ficheiro" name="ficheiro[]" accept=".stl" style="display:none;">
                    <div class="stl_files" id="stl_files"></div>
                    <button class="stl_btn">Escolher Ficheiros</button>
                </div>
                <div class="add_btn_container" id="add_btn_container" style="display: none;">
                    <div class="add_btn">
                        <img src="assets/imgs/icons/add.png" alt="Botão de adicionar ficheiro" title="Adicionar mais ficheiros">
                    </div>
                </div>
                <div>
                    <button id="btn" class="btn" type="submit">Inserir Produto</button>
                </div>
            </form>
        </div>

    <?php } ?>

    <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/includes/footer/footer.php'; ?>

    <script src="./add_product_js.php"></script>
</body>

</html>