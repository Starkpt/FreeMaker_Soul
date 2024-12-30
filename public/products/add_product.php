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
                id="add-product-form"
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
                    <ul class="nav  nav-pills nav-justified" id="myTab" role="tablist">
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
                    <div class="tab-content">

                        <div class="tab-pane p-3 active" id="product-details" role="tabpanel" aria-labelledby="product-details-tab" tabindex="0">

                            <?php require_once $_SERVER["DOCUMENT_ROOT"] . '/public/products/dnd_zone.php'; ?>

                            <!-- Product Name Input -->
                            <div class="mb-3">
                                <label
                                    for="product-name-login-form"
                                    class="form-label fw-semibold">
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
                                <label
                                    for="description"
                                    class="form-label fw-semibold">
                                    Descrição do Produto
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Descrição do produto"></textarea>
                            </div>

                            <!-- Product Price Input -->
                            <div class="mb-3">
                                <label
                                    for="price"
                                    class="form-label fw-semibold">
                                    Preço (€):
                                </label>
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
                                <label
                                    for='files'
                                    class="form-label fw-semibold">
                                    Ficheiro STL:
                                </label>
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
                                <label
                                    for="category"
                                    class="form-label fw-semibold">
                                    Categoria
                                </label>
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
                                <label
                                    for="filament"
                                    class="form-label fw-semibold">
                                    Filamento
                                </label>
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
                                <label
                                    for="color"
                                    class="form-label fw-semibold">
                                    Cor
                                </label>
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
    // Trigger file input when button is clicked
    document.getElementById('btn-upload-files').addEventListener('click', () => {
        document.getElementById('files').click();
    });

    // Clear modal data on close
    document.getElementById('add-product-modal').addEventListener('hidden.bs.modal', () => {
        // Clear form inputs
        const form = document.querySelector('#add-product-modal form');
        if (form) form.reset();

        // Clear file preview containers
        const stlFiles = document.getElementById('stl-files');
        if (stlFiles) stlFiles.innerHTML = '';

        // Optional: Clear custom data or elements like previews
        const previewZone = document.getElementById('files-gallery');
        if (previewZone) previewZone.innerHTML = '';
    });
</script>

<script>
    // Function to verify filament selection
    function verificarSelecaoFilamento() {
        // Check if any filament <select> has a valid selection
        const filamentoSelects = document.querySelectorAll('.filamento');
        const algumFilamentoSelecionado = Array.from(filamentoSelects).some(
            (select) => select.value !== ''
        );

        // Show or hide the "Add Filament" button
        // document.getElementById('add_fil').style.display = algumFilamentoSelecionado ? 'block' : 'none';
    }

    // Event listener for changes in filament <select> elements
    document.addEventListener('change', (event) => {
        if (event.target.classList.contains('filamento')) {
            verificarSelecaoFilamento();
        }
    });

    // Add a new filament <select>
    // document.getElementById('add_fil').addEventListener('click', (event) => {
    //     event.preventDefault();
    //     verificarSelecaoFilamento();

    //     // Create a new select element for filament
    //     const newSelectContainer = document.createElement('div');
    //     newSelectContainer.className = 'input-box fil';
    //     const newSelect = document.createElement('select');
    //     newSelect.className = 'filamento';

    //     // Copy options from the first select
    //     const options = document.querySelectorAll('#filamento option');
    //     options.forEach((option) => {
    //         const clonedOption = option.cloneNode(true);
    //         newSelect.appendChild(clonedOption);
    //     });

    //     // Add the new select to the DOM
    //     newSelectContainer.appendChild(newSelect);
    //     const lastFilContainer = document.querySelector('.input-box.fil:last-of-type');
    //     lastFilContainer.parentNode.insertBefore(newSelectContainer, lastFilContainer.nextSibling);

    //     verificarSelecaoFilamento();

    //     // Hide the "Add Filament" button
    //     document.getElementById('add_fil').style.display = 'none';
    // });
</script>

<script>
    // Function to verify color selection
    function verificarSelecaoCor() {
        // Check if any color <select> has a valid selection
        const corSelects = document.querySelectorAll('.cor');
        const algumaCor = Array.from(corSelects).some((select) => select.value !== '');

        // Show or hide the "Add Color" button
        document.getElementById('add_cor').style.display = algumaCor ? 'block' : 'none';
    }

    // Event listener for changes in color <select> elements
    document.addEventListener('change', (event) => {
        if (event.target.classList.contains('cor')) {
            verificarSelecaoCor();
        }
    });

    // Add a new color <select>
    // document.getElementById('add_cor').addEventListener('click', (event) => {
    //     event.preventDefault();
    //     verificarSelecaoCor();

    //     // Create a new select element for color
    //     const newSelectContainer = document.createElement('div');
    //     newSelectContainer.className = 'input-box cor';
    //     const newSelect = document.createElement('select');
    //     newSelect.className = 'cor';

    //     // Copy options from the first select
    //     const options = document.querySelectorAll('#cor option');
    //     options.forEach((option) => {
    //         const clonedOption = option.cloneNode(true);
    //         newSelect.appendChild(clonedOption);
    //     });

    //     // Add the new select to the DOM
    //     newSelectContainer.appendChild(newSelect);
    //     const lastCorContainer = document.querySelector('.input-box.cor:last-of-type');
    //     lastCorContainer.parentNode.insertBefore(newSelectContainer, lastCorContainer.nextSibling);

    //     verificarSelecaoCor();

    //     // Hide the "Add Color" button
    //     document.getElementById('add_cor').style.display = 'none';
    // });
</script>

<!-- <script src="./add_product_js.php"></script> -->