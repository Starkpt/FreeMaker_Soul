<?php
$title = 'Detalhes Produto';
include 'includes/header/header.php';

// Get product ID from the query string if available
$produto = $_GET['produto'] ?? null;

// Function to retrieve product details
function getProductDetails($conn, $produto)
{
    $sql = 'SELECT p.nome, p.descricao, c.c_descricao, p.preco
            FROM produtos AS p
            JOIN categorias AS c ON c.ID = p.ID_categoria
            WHERE p.ID = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $produto);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to retrieve product images
function getProductImages($conn, $produto)
{
    $sql = 'SELECT f.foto, p.nome, c.c_descricao
            FROM fotos AS f
            JOIN produtos AS p ON p.ID = f.ID_produto
            JOIN categorias AS c ON c.ID = p.ID_categoria
            WHERE p.ID = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $produto);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to retrieve product materials
function getProductFilaments($conn, $produto)
{
    $sql = 'SELECT f.tipo
            FROM filamentos AS f
            JOIN produtos_filamentos_cores AS pf ON pf.ID_filamento = f.ID
            JOIN produtos AS p ON p.ID = pf.ID_produto
            WHERE p.ID = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $produto);
    $stmt->execute();
    $result = $stmt->get_result();

    $filamentos = [];
    while ($row = $result->fetch_assoc()) {
        $filamentos[] = $row['tipo'];
    }
    return $filamentos;
}

// Function to retrieve product colors
function getProductColors($conn, $produto)
{
    $sql = 'SELECT c.cor
            FROM cores AS c
            JOIN produtos_filamentos_cores AS pc ON pc.ID_cor = c.ID
            JOIN produtos AS p ON p.ID = pc.ID_produto
            WHERE p.ID = ?';

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $produto);
    $stmt->execute();
    $result = $stmt->get_result();

    $cores = [];
    while ($row = $result->fetch_assoc()) {
        $cores[] = $row['cor'];
    }
    return $cores;
}

// Fetch product data
$productDetails = getProductDetails($conn, $produto);
$productImages = getProductImages($conn, $produto);
$filamentos = getProductFilaments($conn, $produto);
$cores = getProductColors($conn, $produto);
?>

<div class="product_detail_container wrapper">
    <div class="product_container">
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

        <div class="img_selector">
            <?php
            $productImages->data_seek(0);
            $img_index = 0;
            while ($row = $productImages->fetch_assoc()):
            ?>
                <div class="product_imgs">
                    <a href="#">
                        <img class="img" onclick="img_click(<?= $img_index ?>)" src="/assets/imgs/produtos/<?= htmlspecialchars($row['c_descricao']) ?>/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>" title="Ver Imagem">
                    </a>
                </div>
            <?php
                $img_index++;
            endwhile;
            ?>
        </div>
    </div>

    <div class="product_description">
        <div class="container_description">
            <h2 class="nome"><?= htmlspecialchars($productDetails['nome']) ?></h2>
            <div class="descricao"><strong>Descrição:</strong> <?= htmlspecialchars($productDetails['descricao']) ?></div><br>
            <div class="categoria"><strong>Categoria:</strong> <?= htmlspecialchars($productDetails['c_descricao']) ?></div><br>
            <div class="filamento"><strong>Feito em:</strong> <?= htmlspecialchars(implode(', ', $filamentos)) ?><br><br></div>
            <div class="cor"><strong>Cor(es):</strong> <?= htmlspecialchars(implode(', ', $cores)) ?><br><br></div>
            <div class="preco"><strong>Preço:</strong> <u><?= htmlspecialchars($productDetails['preco']) ?>€</u></div><br><br>

            <div class="seletores">
                <div class="filamento">
                    <select name="escolher_filamento" id="escolher_filamento">
                        <option value="">Escolha um tipo de filamento</option>
                        <?php
                        $result = $conn->query('SELECT ID, tipo FROM filamentos');
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <option name="filamento" value="<?= htmlspecialchars($row['ID']) ?>"> <?= htmlspecialchars($row['tipo']) ?> </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="cor">
                    <select name="escolher_cor" id="escolher_cor">
                        <option value="">Escolha uma cor</option>
                        <?php
                        $result = $conn->query('SELECT ID, cor FROM cores');
                        while ($row = $result->fetch_assoc()):
                        ?>
                            <option name="cor" value="<?= htmlspecialchars($row['ID']) ?>"> <?= htmlspecialchars($row['cor']) ?> </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div><br>
            <hr>
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


<script>
    $(document).ready(function() {
        //TESTE CAROUSEL
        let slide_index = 0;
        const slides = $('.slideshow_container .img');

        //Função para mostrar apenas a 1ª img do array
        function mostrarSlide(index) {
            slides.hide(); // Esconde todas as imagens
            slides.eq(index).show(); // Mostra apenas a imagem atual
        }

        // Mostrar a 1ª imagem do array
        mostrarSlide(slide_index);

        // Função para mudar de imagem com os botões prev e next
        slide = function(direcao) {
            slide_index += direcao;

            // Voltar à última img
            if (slide_index < 0) {
                slide_index = slides.length - 1;
            }
            // Voltar à primeira img
            else if (slide_index >= slides.length) {
                slide_index = 0;
            }

            // Mostrar a nova imagem
            mostrarSlide(slide_index);
        };

        //Função para mostrar a imagem que for carregada no seletor de baixo
        img_click = function(index) {
            slide_index = index; // Recebe o indice que foi incrementado por cada imagem no loop while
            mostrarSlide(slide_index);
        };

    });
</script>