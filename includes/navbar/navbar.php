<!-- Navbar -->

<!-- TODO: add menu options on other screen sizes (add responsiveness) -->
<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom" aria-label="Main navigation">

    <div class="container-fluid container-md">
        <a id="navbar-logo" class="navbar-brand" href="/">
            <img
                title="Página principal"
                alt="Freemaker Soul"
                src="/assets/imgs/logos/logo.png"
                loading="lazy">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-lg-0">
                <li class="nav-item">
                    <a href="/" class="nav-link" title="Página principal">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/products" class="nav-link" title="Ver produtos">Produtos</a>
                </li>
                <li class="nav-item dropdown">
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

            <form id="search-bar" class="d-flex m-0 ms-4" role="search">
                <img class="m-2" src="/assets/imgs/icons/search.svg" alt="Ícone de pesquisar">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </form>

        </div>



        <ul class="navbar-nav mb-lg-0">
            <li class="nav-item dropdown">

                <!-- Determine User State -->
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>

                    <!-- User is Logged In -->
                    <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["username"] ?>

                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <!-- Admin View -->
                            <img class="user_pic" src="/assets/imgs/icons/crown.png" alt="Admin Icon">
                            <span>Admin</span>
                        <?php else: ?>
                            <!-- Regular User View -->
                            <?php
                            $stmt = $conn->prepare('SELECT foto FROM utilizadores WHERE nome = ?');
                            $stmt->bind_param('s', $_SESSION['nome']);
                            $stmt->execute();
                            $user = $stmt->get_result()->fetch_assoc();
                            $user_img = ($user && $user['foto']) ? "/assets/imgs/profile_pics/{$user['foto']}" : '/assets/imgs/icons/person.svg';
                            ?>
                            <img src="<?= htmlspecialchars($user_img, ENT_QUOTES, 'UTF-8') ?>" alt="User Icon">
                            <span><?= htmlspecialchars($_SESSION['nome'] ?? "", ENT_QUOTES, 'UTF-8') ?></span>
                        <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <li><a class="dropdown-item" href="/config/admin-config.php">Admin Configurações</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="/user-profile">Perfil</a></li>
                        <?php endif; ?>

                        <li><a class="dropdown-item" href="/user-settings">Configurações</a></li>

                        <li><a class="dropdown-item" href="/actions/actions.php?act=logout">Logout</a></li>
                    </ul>

                <?php else: ?>
                    <!-- No User Logged In -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login-modal">
                        Login
                        <img src="/assets/imgs/icons/person.svg" alt="User Icon">
                    </button>
                <?php endif; ?>

            </li>
        </ul>

    </div>
</nav>