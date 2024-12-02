<?php
// Setup and Header
$title = 'Detalhes Produto';
include 'includes/navbar/navbar.php';

// Get product ID
$produto = $_GET['produto'] ?? null;

// Helper Functions
function fetchSingleResult($conn, $sql, $params)
{
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(...$params);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function fetchMultipleResults($conn, $sql, $params)
{
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(...$params);
    $stmt->execute();
    return $stmt->get_result();
}

// Queries
$productDetails = fetchSingleResult(
    $conn,
    'SELECT p.nome, p.descricao, c.c_descricao, p.preco
     FROM produtos AS p
     JOIN categorias AS c ON c.ID = p.ID_categoria
     WHERE p.ID = ?',
    ['i', $produto]
);

$productImages = fetchMultipleResults(
    $conn,
    'SELECT f.foto, p.nome, c.c_descricao
     FROM fotos AS f
     JOIN produtos AS p ON p.ID = f.ID_produto
     JOIN categorias AS c ON c.ID = p.ID_categoria
     WHERE p.ID = ?',
    ['i', $produto]
);

$filamentos = array_column(fetchMultipleResults(
    $conn,
    'SELECT f.tipo
     FROM filamentos AS f
     JOIN produtos_filamentos_cores AS pf ON pf.ID_filamento = f.ID
     WHERE pf.ID_produto = ?',
    ['i', $produto]
)->fetch_all(MYSQLI_ASSOC), 'tipo');

$cores = array_column(fetchMultipleResults(
    $conn,
    'SELECT c.cor
     FROM cores AS c
     JOIN produtos_filamentos_cores AS pc ON pc.ID_cor = c.ID
     WHERE pc.ID_produto = ?',
    ['i', $produto]
)->fetch_all(MYSQLI_ASSOC), 'cor');

// Helper function to build a <select> dropdown
function buildSelect($name, $defaultOption, $sql, $conn)
{
    $html = "<select name=\"$name\" id=\"$name\">";
    $html .= "<option value=\"\">$defaultOption</option>";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $value = htmlspecialchars($row['ID']);
        $label = htmlspecialchars($row['tipo'] ?? $row['cor']); // Use either 'tipo' or 'cor' as the display text
        $html .= "<option value=\"$value\">$label</option>";
    }

    $html .= "</select>";
    return $html;
}

?>

<div class="product_detail_container wrapper">
    <div class="product_container">
        <!-- Slideshow -->
        <div class="slideshow_container">
            <img class="prev_icon" onclick="slide(-1)" src="/assets/imgs/icons/arrow.png" alt="Previous">
            <img class="next_icon" onclick="slide(1)" src="/assets/imgs/icons/arrow.png" alt="Next">
            <div class="slideshow">
                <?php while ($row = $productImages->fetch_assoc()): ?>
                    <a href="/assets/imgs/produtos/<?= htmlspecialchars($row['c_descricao']) ?>/<?= htmlspecialchars($row['foto']) ?>" target="_blank">
                        <img class="img" src="/assets/imgs/produtos/<?= htmlspecialchars($row['c_descricao']) ?>/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>">
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Image Selector -->
        <div class="img_selector">
            <?php $productImages->data_seek(0);
            $img_index = 0; ?>
            <?php while ($row = $productImages->fetch_assoc()): ?>
                <div class="product_imgs">
                    <a href="#">
                        <img class="img" onclick="img_click(<?= $img_index ?>)" src="/assets/imgs/produtos/<?= htmlspecialchars($row['c_descricao']) ?>/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>" title="Ver Imagem">
                    </a>
                </div>
                <?php $img_index++; ?>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Product Details -->
    <div class="product-description">
        <div class="container_description">
            <h2 class="nome"><?= htmlspecialchars($productDetails['nome']) ?></h2>
            <div class="description"><strong>Descrição:</strong> <?= htmlspecialchars($productDetails['descricao']) ?></div><br>
            <div class="categoria"><strong>Categoria:</strong> <?= htmlspecialchars($productDetails['c_descricao']) ?></div><br>
            <div class="filamento"><strong>Feito em:</strong> <?= htmlspecialchars(implode(', ', $filamentos)) ?><br><br></div>
            <div class="cor"><strong>Cor(es):</strong> <?= htmlspecialchars(implode(', ', $cores)) ?><br><br></div>
            <div class="price"><strong>Preço:</strong> <u><?= htmlspecialchars($productDetails['preco']) ?>€</u></div><br><br>

            <!-- Selectors -->
            <div class="seletores">
                <div class="filamento">
                    <?= buildSelect('escolher_filamento', 'Escolha um tipo de filamento', 'SELECT ID, tipo FROM filamentos', $conn) ?>
                </div>
                <div class="cor">
                    <?= buildSelect('escolher_cor', 'Escolha uma cor', 'SELECT ID, cor FROM cores', $conn) ?>
                </div>
            </div><br>
            <hr>

            <!-- Add to Cart -->
            <div class="add_to_cart">
                <div class="quantidade">
                    <label for="quantity"><strong>Quantidade:</strong></label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                </div>
                <div class="add_btn">
                    <button type="submit">Adicionar ao carrinho</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer/footer.php'; ?>
<script src="./product_details_js.php"></script>