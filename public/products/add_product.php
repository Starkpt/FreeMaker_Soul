<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/product_card/product_card.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/utils/helper_functions.php";

$title = "Adicionar produto";

?>

<div
    id="add-product-modal"
    class="modal fade"
    tabindex="-1"
    aria-labelledby="add-product-label"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form
                action="<?= $_SESSION['adm'] ? '/public/products/add_product' : '/actions/actions.php?act=sugest_product' ?>"
                method="POST"
                enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="add-product-label">
                        Adicionar produto
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Product Name Input -->
                    <div class="mb-3">
                        <label
                            for="product-name-login-form"
                            class="form-label">
                            Nome do producto
                        </label>
                        <input
                            type="text"
                            id="product-name-login-form"
                            name="product-name"
                            class="form-control"
                            placeholder="Nome do producto"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição do Produto</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            rows="4"
                            placeholder="Descrição do produto"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Preço (€):</label>
                        <input
                            type="text"
                            name="price"
                            id="price"
                            class="form-control"
                            placeholder="Insira o preço do produto" />
                    </div>

                    <!-- Category Upload Section -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoria</label>
                        <select name='category'
                            class="form-control">
                            <option value=''>Escolha uma categoria</option>
                            <?php
                            $result = $conn->query('SELECT ID, c_descricao FROM categorias');
                            while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['ID'] ?>">
                                    <?= $row['c_descricao'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- File Upload Section -->
                    <div class="mb-3">
                        <label for='files' class="form-label">Ficheiro STL:</label>
                        <div id='stl-files'></div>
                        <input class='form-control' type='file' id='files' name='files[]' accept='.stl' style='display:none' multiple>


                        <button
                            type="button"
                            class="btn btn-outline-secondary">Escolher Ficheiros
                            <img
                                src='assets/imgs/icons/plus-24x24.svg'
                                alt='Adicionar ficheiros'
                                title='Adicionar ficheiros'>
                        </button>
                    </div>

                    <!-- Images Upload Section -->
                    <div class="mb-3">
                        <label for='photos' class="form-label">Fotos</label>
                        <div id="product-images-list"></div>
                        <input
                            class="form-control"
                            style="display:none"
                            type="file"
                            id="photos"
                            name="photos[]"
                            accept="image/*"
                            multiple>

                        <button
                            type="button"
                            class="btn btn-outline-secondary">
                            Inserir fotos
                            <img
                                src='assets/imgs/icons/plus-24x24.svg'
                                alt='Adicionar fotos'
                                title='Adicionar fotos'>
                        </button>
                    </div>

                    <div class="mb-3">
                        <select name="category">
                            <option value="">Escolha uma categoria</option>
                            <?php
                            $result = $conn->query('SELECT ID, c_descricao FROM categorias');
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <option value="<?= $row['ID'] ?>">
                                    <?= $row['c_descricao'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>


                    <?php if ($_SESSION['adm']): ?>
                        <!-- Admin Inputs -->
                        <?php include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_filamento.php'; ?>
                        <?php include $_SERVER["DOCUMENT_ROOT"] . '/public/products/form_input_cor.php'; ?>

                    <?php endif; ?>


                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                    <button type="cancel" class="btn btn-outline-danger">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('#photos').on('change', function(e) {
        const foto = e.target.files[0];

        for (let i = 0; i < this.files.length; i++) {
            let reader = new FileReader();
            let img_preview = $(`<img class="preview-${i}" />`);

            reader.onload = function(e) {
                img_preview.attr("src", e.target.result);
            }
            reader.readAsDataURL(this.files[i]);
            $('#product-images-list').append(img_preview);
        }

    });
</script>

<script src="./add_product_js.php"></script>