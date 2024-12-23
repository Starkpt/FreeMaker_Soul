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

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link active"
                                id="product-details-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#product-details"
                                type="button"
                                role="tab"
                                aria-controls="product-details"
                                aria-selected="true">
                                
                                Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link"
                                id="product-characteristics-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#product-characteristics"
                                type="button"
                                role="tab"
                                aria-controls="product-characteristics"
                                aria-selected="false">
                                
                                Charateristics
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content border border-top-0">

                        <div class="tab-pane p-3 active" id="product-details" role="tabpanel" aria-labelledby="product-details-tab" tabindex="0">

                            <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/dnd_zone.php'; ?>

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

                            <!-- Product Description Input -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição do Produto</label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Descrição do produto"></textarea>
                            </div>

                            <!-- Product Price Input -->
                            <div class="mb-3">
                                <label for="price" class="form-label">Preço (€):</label>
                                <input
                                    type="text"
                                    name="price"
                                    id="price"
                                    class="form-control"
                                    placeholder="Insira o preço do produto" />
                            </div>

                        </div>

                        <div class="tab-pane p-3" id="product-characteristics" role="tabpanel" aria-labelledby="product-characteristics-tab" tabindex="0">

                            <!-- File Upload Section -->
                            <div class="mb-3">
                                <label for='files' class="form-label">Ficheiro STL:</label>
                                <div id='stl-files'></div>
                                <input
                                    class='form-control'
                                    type='file'
                                    id='files'
                                    name='files[]'
                                    accept='.stl'
                                    hidden
                                    multiple />


                                <button
                                    id="btn-upload-files"
                                    type="button"
                                    class="btn btn-outline-secondary w-100">
                                    Escolher Ficheiros
                                    <img
                                        src='assets/imgs/icons/plus-24x24.svg'
                                        alt='Adicionar ficheiros'
                                        title='Adicionar ficheiros'>
                                </button>
                            </div>

                            <!-- Category Select Section -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Categoria</label>
                                <select name='category' class="form-control">
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

                            <!-- Filament Select Section -->
                            <div class="mb-3">
                                <label for="filament" class="form-label">Filamento</label>
                                <select name='filament' class="form-control">
                                    <option value=''>Escolha um filamento</option>
                                    <?php
                                    $result = $conn->query('SELECT ID, tipo FROM filamentos');
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option value="<?= $row['ID'] ?>">
                                            <?= $row['tipo'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Color Upload Section -->
                            <div class="mb-3">
                                <label for="color" class="form-label">Cor</label>
                                <select name="color" class="form-control">
                                    <option value=''>Escolha uma cor</option>
                                    <?php
                                    $result = $conn->query('SELECT ID, cor FROM cores');
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <option value="<?= $row['ID'] ?>">
                                            <?= $row['cor'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>

                    </div>



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
    $('#btn-upload-files').click(function() {
        $('#files').click();
    });


    // Clear modal data on close
    $('#add-product-modal').on('hidden.bs.modal', function() {
        // Clear form inputs
        $(this).find('form')[0].reset();

        // Clear file preview containers
        $('#stl-files').empty();

        // Optional: Clear custom data or elements like previews
        const previewZone = document.querySelector('#files-gallery');
        if (previewZone) {
            previewZone.innerHTML = ''; // Clear any previews
        }
    });
</script>

<script>
    function verificarSelecaoFilamento() {
        // Verifica se qualquer <select> de filamento possui uma seleção válida
        const algumFilamentoSelecionado = $('.filamento').filter(function() {
            return $(this).val();
        }).length > 0;

        // Exibe o botão se algum filamento estiver selecionado; caso contrário, oculta
        document.getElementById('add_fil').style.display = algumFilamentoSelecionado ? 'block' : 'none';
    }

    // Aplica o evento de mudança a todos os selects de filamento atuais e futuros
    $(document).on('change', '.filamento', verificarSelecaoFilamento);

    $('#add_fil').on('click', function(e) {
        e.preventDefault();
        verificarSelecaoFilamento();

        // Cria um novo select de filamento
        const newSelectContainer = $('<div class="input-box fil"></div>');
        const newSelect = $('<select class="filamento"></select>');

        // Copia as opções do primeiro select 
        $('#filamento option').each(function() {
            newSelect.append($(this).clone());
        });

        // Adiciona o novo select ao DOM
        newSelectContainer.append(newSelect);
        $('.input-box.fil').last().after(newSelectContainer);

        verificarSelecaoFilamento();

        // Oculta o botão "Adicionar Filamento" logo após criar um novo select
        document.getElementById('add_fil').style.display = 'none';
    });
</script>

<script>
    function verificarSelecaoCor() {
        // Verifica se qualquer <select> de cor possui uma seleção válida
        const algumaCor = $('.cor').filter(function() {
            return $(this).val();
        }).length > 0;

        // Exibe o botão se alguma cor estiver selecionada; caso contrário, oculta
        document.getElementById('add_cor').style.display = algumaCor ? 'block' : 'none';
    }

    // Aplica o evento de mudança a todos os selects de cor atuais e futuros
    $(document).on('change', '.cor', verificarSelecaoCor);

    $('#add_cor').on('click', function(e) {
        e.preventDefault();
        verificarSelecaoCor();

        // Cria um novo select de cor
        const newSelectContainer = $('<div class="input-box cor"></div>');
        const newSelect = $('<select class="cor"></select>');

        // Copia as opções do primeiro select 
        $('#cor option').each(function() {
            newSelect.append($(this).clone());
        });

        // Adiciona o novo select ao DOM
        newSelectContainer.append(newSelect);
        $('.input-box.cor').last().after(newSelectContainer);

        verificarSelecaoCor();

        // Oculta o botão "Adicionar cor" logo após criar um novo select
        document.getElementById('add_cor').style.display = 'none';
    });
</script>

<!-- <script src="./add_product_js.php"></script> -->