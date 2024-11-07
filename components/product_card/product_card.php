<?php
function productCard($row)
{
    return '
        <div class="product">
            <a href="product_details.php?produto=' . $row['ID'] . '">
                <img src="/assets/imgs/produtos/' . $row['c_descricao'] . '/' . $row['foto'] . '" alt="' . $row['nome'] . '" title="Ver detalhes">
            </a>
            <div class="nome_prod" title="Nome do Produto">' . $row['nome'] . '</div>
            <div class="preco" title="Preço">' . $row['preco'] . '€</div>
        </div>
    ';
}
