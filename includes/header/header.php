<!-- Message backdrop modal -->
<?php


$adm = $_SESSION['adm'] ?? null;
$error_msg = $_SESSION['error_msg'] ?? '';
$info_msg = $_SESSION['info_msg'] ?? '';
$msg = htmlspecialchars($_GET['msg'] ?? '');

if ($msg): ?>
    <div class="backdrop" id="msg_backdrop">
        <div class="msg_container wrapper">
            <img id="close_msg" class="close_msg" src="/assets/imgs/icons/close.png" alt="Close">
            <div class="msg">
                <?php
                switch ($msg) {
                    case 'ja_ha_registo':
                        echo 'Já existe uma conta com este email ou nome de utilizador. <a href="#" id="try_signup">[Tente novamente]</a>';
                        break;
                    case 'registo_error':
                        echo 'Não foi possível realizar o seu registo. <a href="#" id="try_signup">[Tente novamente]</a>';
                        break;
                    case 'registo_success':
                        echo 'Registo efetuado com sucesso! Redirecionando para a página de login.';
                        break;
                    case 'nao_ha_registo':
                        echo 'Ainda não efetuou registo no nosso site. Registe-se <a href="#" id="try_signup">[aqui]</a>.';
                        break;
                    case 'login_error':
                        echo 'Email, nome de utilizador ou palavra passe incorretos. <a href="#" id="try_login">[Tente novamente]</a>';
                        break;
                    case 'login_success':
                        echo 'Login efetuado com sucesso!';
                        break;
                    case 'logout':
                        echo 'Sessão terminada.';
                        break;
                    case 'insert_error':
                    case 'del_user_error':
                    case 'del_prod_error':
                    case 'edit_user_error':
                    case 'edit_prod_error':
                        echo htmlspecialchars($error_msg) . ' <a href="/utils/insert_prod.php">[Tente novamente]</a>';
                        break;
                    case 'insert_success':
                    case 'del_user_success':
                    case 'edit_user_success':
                        echo '<strong>Ação concluída com sucesso!</strong><br>' . htmlspecialchars($info_msg);
                        break;
                }
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Header -->
<header id="navbar-header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary" aria-label="Main navigation">

        <div class="container-fluid">
            <a id="navbar-logo" class="navbar-brand" href="/">
                <img
                    title="Página principal"
                    alt="Freemaker Soul"
                    src="/assets/imgs/logos/logo.png"
                    loading="lazy">
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="/" class="nav-link" title="Página principal">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="/products" class="nav-link" title="Ver produtos">Produtos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <!-- <a class="nav-link dropdown-toggle" href="/categories">Categorias</a> -->
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach (['Figuras', 'Decor', 'Gaming', 'Misc', 'Porta-Chaves', 'Utensílios'] as $categoria): ?>
                                <li>
                                    <a class="dropdown-item" href="products?categoria=<?= urlencode($categoria) ?>">
                                        <?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>

                <form id="search-bar" class="d-flex m-0" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">
                        <img src="/assets/imgs/icons/search.svg" alt="Ícone de pesquisar">
                    </button>
                </form>

            </div>

            <?php if ($_SESSION): ?>
                <div class="profile_container">
                    <?php if ($adm): ?>
                        <img class="avatar" src="/assets/imgs/icons/crown.png" alt="Admin icon">
                    <?php else: ?>
                        <?php
                        $stmt = $conn->prepare('SELECT foto FROM utilizadores WHERE nome = ?');
                        $stmt->bind_param('s', $_SESSION['nome']);
                        $stmt->execute();
                        $user = $stmt->get_result()->fetch_assoc();
                        // TODO : Correct this part. It should show:
                        //  - a crown when admin
                        //  - user photo when regular user logged in
                        //  - "Login" when now user logged in
                        $user_img = ($user && $user['foto']) ? "/imgs/profile_pics/{$user['foto']}" : '/assets/imgs/icons/login-avatar.png';
                        ?>
                        <!-- <img class="user_pic" src="<?= $user_img ?>" alt="User icon"> -->
                        <img class="user_pic" src="/assets/imgs/icons/person.svg" alt="User icon">

                    <?php endif; ?>
                    <ul class="profile-options">
                        <?php if ($adm): ?>
                            <li><a href="/config/admin-config.php">Configurar</a></li>
                        <?php else: ?>
                            <li><a href="profile.php">Ver perfil</a></li>
                        <?php endif; ?>
                        <li><a href="/actions/actions.php?act=logout">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a id="login" class="login" href="#">Login</a>
            <?php endif; ?>

        </div>
    </nav>
</header>

<script>
    const msg = "<?= $msg ?>"; // Global variable for JavaScript use
</script>