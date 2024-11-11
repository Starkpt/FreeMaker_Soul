<!-- Message backdrop modal -->
<?php

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

<!-- Login Form Modal -->
<div class="backdrop" id="login_backdrop">
    <form class="form wrapper" id="form_login" action="/utils/actions.php?act=login" method="POST">
        <div class="login_container">
            <div class="log_btn_container">
                <img id="close_login" class="close_msg" src="/assets/imgs/icons/close.png" alt="Close">
            </div>
            <div class="titulo">Login</div>
            <div class="input-box">
                <input type="text" id="name_login" name="nickname" placeholder="Email ou nome de utilizador" required>
                <img src="/assets/imgs/icons/login-avatar.png" alt="User icon">
            </div>
            <div class="input-box">
                <input type="password" id="pwd_login" name="password" placeholder="Password" required>
                <img class="eye" src="/assets/imgs/icons/closed-eye.png" alt="Show password">
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember"> Lembrar-me
                </label>
                <a href="#">Esqueci a Password</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                Ainda não efetuou registo? <a id="registar" href="#">Registar</a>
            </div>
        </div>
    </form>
</div>

<!-- Header -->
<header class="header">
    <div class="wrapper">
        <a class="logo" href="/index">
            <img src="/assets/imgs/logos/logo.png" alt="Logotipo do proprietário" title="Página principal">
        </a>
        <nav class="menu">
            <a href="/index" class="link" title="Página principal">Home</a>
            <a href="/products" class="link" title="Todos os produtos">Produtos</a>
            <li class="categorias link" tabindex="0">
                <a href="#">Categorias</a>
                <ul class="submenu">
                    <?php foreach (['Figuras', 'Decor', 'Gaming', 'Misc', 'Porta-Chaves', 'Utensílios'] as $categoria): ?>
                        <li><a class="link" href="products?categoria=<?= urlencode($categoria) ?>"><?= $categoria ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </nav>
        <nav class="menu2">
            <form class="search-bar">
                <input type="text" placeholder="Pesquisar">
                <button type="submit">
                    <img src="/assets/imgs/icons/search.png" alt="Search icon">
                </button>
            </form>
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
                        $user_img = $user['foto'] ? "imgs/profile_pics/{$user['foto']}" : 'assets/imgs/icons/login-avatar.png';
                        ?>
                        <img class="user_pic" src="<?= $user_img ?>" alt="User icon">
                    <?php endif; ?>
                    <ul class="profile-options">
                        <?php if ($adm): ?>
                            <li><a href="/config/admin-config.php">Configurar</a></li>
                        <?php else: ?>
                            <li><a href="profile.php">Ver perfil</a></li>
                        <?php endif; ?>
                        <li><a href="/utils/actions.php?act=logout">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a id="login" class="login" href="#">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<!-- Signup Form Modal -->
<div class="backdrop" id="signup_backdrop">
    <form class="form wrapper" id="form_signup" action="/utils/actions.php?act=register" method="POST">
        <div class="titulo">Registar</div>
        <div class="input-box">
            <input type="text" name="nickname" placeholder="Nome de utilizador" required>
            <img src="/assets/imgs/icons/login-avatar.png" alt="User icon">
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <img src="/assets/imgs/icons/at.png" alt="Email icon">
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" minlength="8" required>
            <img class="eye" src="/assets/imgs/icons/closed-eye.png" alt="Show password">
        </div>
        <div class="input-box">
            <input type="password" name="re_password" placeholder="Repetir password" required>
            <img class="re_eye" src="/assets/imgs/icons/closed-eye.png" alt="Show password">
        </div>
        <button type="submit" class="btn">Registar</button>
    </form>
</div>

<script>
    const msg = "<?= $msg ?>"; // Global variable for JavaScript use
</script>
<script src="/utils/main.js"></script>