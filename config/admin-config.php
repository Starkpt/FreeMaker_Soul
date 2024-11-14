<?php
$title = "Administração";
include $_SERVER["DOCUMENT_ROOT"] . '/includes/header/header.php';
?>
<!--/********************************************************************************************************************************************/
/*                                                                   USERS_LIST                                                                */
/***********************************************************************************************************************************************/-->
<div class="configs_container">
    <div class="listagem wrapper" id="users_list">
        <div class="titulo">
            Listagem de utilizadores<br>
            <hr>
        </div>
        <table class="lista" cellpadding="10">
            <tr>
                <th>Nome</th>
                <th>Morada</th>
                <th>Codigo Postal</th>
                <th>Telefone</th>
                <th>Nif</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>Foto</th>
                <th>Opções</th>
            </tr>
            <?php
            $sql = 'SELECT * FROM utilizadores ORDER BY nome';
            $results = $conn->query($sql);

            while ($row = $results->fetch_assoc()) {
            ?>
                <tr>
                    <td>
                        <?= @$row['nome'] ?>
                    </td>
                    <td>
                        <?= $row['morada'] ?>
                    </td>
                    <td>
                        <?= $row['cod_postal'] ?>
                    </td>
                    <td>
                        <?= $row['telefone'] ?>
                    </td>
                    <td>
                        <?= $row['nif'] ?>
                    </td>
                    <td>
                        <?= $row['nickname'] ?>
                    </td>
                    <td>
                        <?= $row['email'] ?>
                    </td>
                    <td>
                        <?php
                        if (!$row['foto']) {
                        ?>
                            <img class="user_foto" src="assets/imgs/icons/login-avatar2.png" height="60">
                        <?php
                        } else {
                        ?>
                            <a href="imgs/users/profile_pics/<?= $row['foto'] ?>" target="_blank">
                                <img class="user_foto" img src="/assets/imgs/users/profile_pics/<?= $row['foto'] ?>" height="60">
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td class="icon_container">
                        <a href="/actions/actions.php?act=del_user&ID=<?= $row['ID'] ?>" onclick="return confirm('Pretende apagar o cliente <?= @$row['nome'] ?>?')" style="text-decoration: none">
                            <img src="assets/imgs/icons/trash.png" class="icon" alt="Eliminar" title="Eliminar Utilizador">
                        </a>
                        <a href="#" class="edit_user_link">
                            <img src="assets/imgs/icons/pencil.png" class='user_edit icon' data-id="<?= $row['ID'] ?>" alt="Editar" title="Editar Utilizador">
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <!--/********************************************************************************************************************************************/
/*                                                                   USERS_EDIT                                                                 */
/************************************************************************************************************************************************/-->

    <div class="listagem wrapper" id="user_edit_list" style="display: none;">
        <div class="titulo">
            Editar Utilizador<br>
            <hr>
        </div>
        <form action="/actions/actions.php?act=edit_user" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?= $ID ?>">
            <table class="lista" border="0">
                <tr>
                    <th>Nome</th>
                    <th>Morada</th>
                    <th>Codigo Postal</th>
                    <th>Telefone</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" maxlength="50" name="nome" id="input_nome">
                    </td>
                    <td>
                        <textarea name="morada" id="input_morada" placeholder="EX: Rua das batatas, nº666 cave esq Cod-Postal: 666-999"></textarea>
                    </td>
                    <td>
                        <input type="text" name="cod_postal" maxlength="10" id="input_cod_postal" pattern="^\d{4}-\d{3}$" placeholder="0000-000">
                    </td>
                    <td>
                        <input type="text" name="telefone" maxlength="20" id="input_telefone" pattern="^\d{9}$">
                    </td>
                </tr>
                <tr>
                    <th>Nif</th>
                    <th>Nickname</th>
                    <th>Email</th>
                    <th>Foto</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="nif" maxlength="10" id="input_nif" pattern="^\d{9}$">
                    </td>
                    <td>
                        <input type="text" name="nickname" maxlength="30" id="input_nickname" required>
                    </td>
                    <td>
                        <input type="text" name="email" maxlength="30" id="input_email" required>
                    </td>
                    <td>
                        <a href="#">
                            <img class="user_foto" id="user_foto" height="60">

                        </a><br>
                        <input name="foto" id="input_foto" type="file" accept="img/*" style="display: none;">
                        <button class="btn" id="foto_btn">Escolher Ficheiro</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" halign="right" valign="bottom">
                        <input type="submit" value="Alterar">
                        <button type="button" id="cancel_edit">Cancelar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!--/********************************************************************************************************************************************/
/*                                                                   PRODS_LIST                                                                */
/***********************************************************************************************************************************************/-->

    <div class="listagem wrapper" id="prods_list">
        <div class="titulo">
            Listagem de produtos
            <hr>
        </div>
        <table class="lista" cellpadding="10">
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Imagens</th>
                <th>Filamento</th>
                <th>Cor</th>
                <th>Preço</th>
                <th>Opções</th>
            </tr>
            <?php

            $sql = 'SELECT p.ID, p.nome, p.descricao, ct.c_descricao, GROUP_CONCAT(f.foto SEPARATOR " ") AS fotos, fl.tipo, c.cor, p.preco
                    FROM produtos AS p
                    JOIN categorias AS ct ON ct.ID = p.ID_categoria
                    JOIN fotos AS f ON f.ID_produto = p.ID
                    JOIN produtos_filamentos_cores AS pf ON pf.ID_produto = p.ID
                    JOIN filamentos AS fl ON fl.ID = pf.ID_filamento
                    JOIN cores AS c ON c.ID = pf.ID_cor 
                    GROUP BY p.nome
                    ORDER BY p.nome';
            $results = $conn->query($sql);

            while ($row = $results->fetch_assoc()) {
            ?>
                <tr>
                    <td>
                        <?= $row['nome'] ?>
                    </td>
                    <td>
                        <?= $row['descricao'] ?>
                    </td>
                    <td>
                        <?= $row['c_descricao'] ?>
                    </td>
                    <td>
                        <?php
                        $images = explode(' ', $row['fotos']);
                        foreach ($images as $image) {
                        ?>
                            <a href="assets/imgs/produtos/<?= $row['c_descricao'] ?>/<?= $image ?>" target="_blank">
                                <img src="assets/imgs/produtos/<?= $row['c_descricao'] ?>/<?= $image ?>" alt="<?= @$row['nome'] ?>" height="60">
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?= $row['tipo'] ?>
                    </td>
                    <td>
                        <?= $row['cor'] ?>
                    </td>
                    <td>
                        <?= $row['preco'] ?>
                    </td>
                    <td class="icon_container" align="center">
                        <a href="/actions/actions.php?act=del_prod&ID=<?= $row['ID'] ?>" onclick="return confirm('Pretende apagar o produto <?= $row['nome'] ?>?')" style="text-decoration: none">
                            <img src="assets/imgs/icons/trash.png" class="icon" alt="Eliminar" title="Eliminar Produto">
                        </a>
                        <a href="#" class="prod_edit_link">
                            <img src="assets/imgs/icons/pencil.png" class='prod_edit icon' data-id="<?= $row['ID'] ?>" alt="Editar" title="Editar Produto">
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <!--/********************************************************************************************************************************************/
/*                                                                   PRODS_EDIT                                                                 */
/************************************************************************************************************************************************/-->

    <div class="listagem wrapper" id="prod_edit_list" style="display: none;">
        <div class="titulo">
            Editar Produto<br>
            <hr>
        </div>
        <form action="/actions/actions.php?act=edit_prod" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?= $ID ?>">
            <table class="lista" border="0">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Imagens</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="nome" placeholder="Nome do produto">
                    </td>
                    <td>
                        <textarea class="descricao" name="descricao" rows="4" placeholder="Descrição do produto"></textarea>
                    </td>
                    <td>
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
                    </td>
                    <td>
                        <a href="#">
                            <img class="prod_foto" id="prod_foto" height="60">
                        </a><br>
                        <input type="file" id="foto" name="foto[]" accept="image/*" style="display:none;" multiple>
                        <button class="img_btn">Inserir Imagens</button>
                    </td>
                </tr>
                <tr>
                    <th>Filamento</th>
                    <th>Cor</th>
                    <th>Preço</th>
                </tr>
                <tr>
                    <td>
                        <select class="filamento" id="filamento" name="filamento[]">
                            <option value="">Escolha um tipo de filamento</option>
                            <?php
                            $result = $conn->query('SELECT ID, tipo FROM filamentos');
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <option name="filamento" value="<?= $row['ID'] ?>"> <?= $row['tipo'] ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <div class="add_btn_container" id="add_fil" style="display: none;">
                        <div class="add_btn">
                            <img src="assets/imgs/icons/add.png" alt="Botão de adicionar mais filamentos" title="Adicionar mais filamentos">
                        </div>
                    </div>
                    <td>
                        <select class="cor" id="cor" name="cor[]">
                            <option value="">Escolha uma cor</option>
                            <?php
                            $result = $conn->query('SELECT ID, cor FROM cores');
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <option name="cor" value="<?= $row['ID'] ?>"> <?= $row['cor'] ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                    <div class="add_btn_container" id="add_cor" style="display: none;">
                        <div class="add_btn">
                            <img src="assets/imgs/icons/add.png" alt="Botão de adicionar mais cores" title="Adicionar mais cores">
                        </div>
                    </div>
                    <td>
                        <input type="number" name="preco" step="0.1" min="0">
                    </td>
                </tr>
                <tr>
                    <td colspan="8" halign="right" valign="bottom">
                        <input type="submit" value="Alterar">
                        <button type="button" id="prod_cancel_edit">Cancelar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>


    <script>
        $(document).ready(function() {
            // Função para abrir o painel de edição de utilizador quando se clica no botão de editar
            $('.edit_user_link').on('click', function(e) {
                e.preventDefault();

                // Buscar o ID do utilizador para carregá-lo via AJAX
                const userId = $(this).find('.user_edit').data('id');

                $.ajax({
                    url: '/actions/actions.php', // Endpoint para buscar dados do utilizador pelo ID
                    method: 'GET',
                    data: {
                        act: 'get_user',
                        ID: userId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {

                            // Função para descodificar entidades HTML
                            function decodeHTMLEntities(text) {
                                const textArea = document.createElement('textarea');
                                textArea.innerHTML = text;
                                return textArea.value;
                            }
                            // Preencher os campos do formulário com os dados recebidos
                            $('input[name="ID"]').val(data.ID);
                            $('input[name="nome"]').val(decodeHTMLEntities(data.nome));
                            $('textarea[name="morada"]').val(data.morada.replace(/\r\n/g, '\n')); // Garantir quebras de linha uniformes
                            $('input[name="cod_postal"]').val(data.cod_postal);
                            $('input[name="telefone"]').val(data.telefone);
                            $('input[name="nif"]').val(data.nif);
                            $('input[name="nickname"]').val(data.nickname);
                            $('input[name="email"]').val(data.email);

                            // Atualizar a imagem do perfil, se existir
                            if (data.foto) {
                                $('#user_foto').attr('src', 'imgs/users/profile_pics/' + data.foto);
                            } else {
                                $('#user_foto').attr('src', 'imgs/icons/login-avatar2.png'); // ou outro placeholder
                            }

                            // Esconder a listagem de utilizadores e abrir o formulário de edição
                            $('#users_list').hide();
                            $('#user_edit_list').show();
                        } else {
                            alert('Dados não encontrados.');
                        }
                    },
                    error: function() {
                        alert('Erro ao carregar os dados do utilizador.');
                    }
                });
            });

            // Abertura do seletor de arquivo para upload de foto
            $('#foto_btn').on('click', function(e) {
                e.preventDefault();
                $('#input_foto').click();
            });

            // Atualização da imagem de pré-visualização ao escolher nova foto
            $('#input_foto').on('change', function(e) {
                const foto = e.target.files[0];
                if (foto) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#user_foto').attr("src", e.target.result); // Atualiza a imagem existente
                    };
                    reader.readAsDataURL(foto);
                }
            });

            // Botão de cancelar edição, fecha o formulário de edição e mostra a listagem de utilizadores
            $('#cancel_edit').on('click', function() {
                $('#user_edit_list').hide();
                $('#users_list').show();
            });

            //Função para abrir o painel de edição de produto quando se carrega no botao de editar
            $('.prod_edit_link').on('click', function(e) {
                e.preventDefault();

                // Buscar o ID do produto para carregá-lo via AJAX ou apenas para referência
                const prodId = $(this).find('.prod_edit').data('id');
                console.log(prodId);

                $.ajax({
                    url: '/actions/actions.php', // Endpoint para buscar dados do produto pelo ID
                    method: 'GET',
                    data: {
                        act: 'get_prod',
                        ID: prodId
                    },
                    // dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            // Preencher os campos do formulário com os dados recebidos
                            $('input[name="ID"]').val(data.ID);
                            $('input[name="nome"]').val(data.nome);
                            $('textarea[name="descricao"]').val(data.descricao);
                            $('select[name="categoria"]').val(data.categoria);
                            $('input[name="foto"]').val(data.foto);
                            $('select[name="filamento"]').val(data.tipo);
                            $('select[name="cor"]').val(data.cor);
                            $('input[name="preco"]').val(data.preco);
                            // Handle image display if photo exists
                            if (data.foto) {
                                $('img[src*="profile_pics"]').attr('src', 'imgs/users/profile_pics/' + data.foto);
                            }

                            $('#prod_edit_list').show();
                            $('#prods_list').hide();

                        } else {
                            alert('Dados não encontrados.');
                        }
                        $('#input_foto').val('');
                    },
                    error: function() {
                        alert('Erro ao procurar pelos dados do produto.');
                    }
                });
            });

            //Abrir o selecionador de fotos
            $('#foto_btn').on('click', function(e) {
                e.preventDefault();
                $('#input_foto').click();
            });


            $('#input_foto').on('change', function(e) {
                const foto = e.target.files[0];

                // Limpa qualquer imagem anterior
                // $('.user_foto').empty();
                if (foto) {
                    // $('.user_foto').empty();
                    // $('.user_foto').append(foto);

                    let reader = new FileReader();
                    // let img_preview = $('<img class="user_foto" />');

                    reader.onload = function(e) {
                        $('.user_foto img').attr("src", e.target.result); //atualiza a imagem
                        // img_preview.attr("src", e.target.result);
                    }
                    reader.readAsDataURL(foto);

                }
                // $('.user_foto').append(img_preview);


            });

            // Botão de cancelar edição. Fecha o formulário de edição e mostra a listagem de utilizadores
            $('#prod_cancel_edit').on('click', function() {
                $('#prods_edit_list').hide();
                $('#prods_list').show();
            });

        });
    </script>