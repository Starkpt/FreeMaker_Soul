
<?php
// product_card.php

/**
 * Render a product card with the provided product data.
 * 
 * @param array $product Product data (ID, name, price, photo, category)
 * @return string HTML for a single product card
 */
function productCard($product)
{
    $productLink = htmlspecialchars("/product_details?produto={$product['ID']}");
    $imagePath = htmlspecialchars("/assets/imgs/produtos/{$product['c_descricao']}/{$product['foto']}");
    $name = htmlspecialchars($product['nome']);
    $price = htmlspecialchars($product['preco']);

    echo "
        <div class='product'>
            <a href='{$productLink}'>
                <img src='{$imagePath}' alt='{$name}' title='Ver detalhes'>
            </a>
            <div class='nome_prod' title='Nome do Produto'>{$name}</div>
            <div class='preco' title='Preço'>{$price}€</div>
        </div>
    ";
}
?>
