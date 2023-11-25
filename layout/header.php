<?php require_once('config.php') ?>
<header class="header">
    <div class="logo">
        <a href="/unycall/"><img src="./assets/img/logo.png" alt="Logo UnyCall"></a>
    </div>
    <nav class="menu">
        <ul class="menu-list">
            <!-- <li class="menu-list-item"><a href="#">Sobre</a></li> -->
            <li class="menu-list-item"><a href="<?= CAMINHO_PADRAO ?>/servicos.php">Serviços</a></li>
            <li class="menu-list-item"><a href="<?= CAMINHO_PADRAO ?>/contato.php">Contato</a></li>
        </ul>
        <div class="header-actions">
            <a class="btn secondary" href="<?= CAMINHO_PADRAO ?>/cadastro.php">Cadastrar-se</a>
            <a class="btn" href="<?= CAMINHO_PADRAO ?>/login.php">Login</a>
        </div>
    </nav>
    <nav class="nav-mobile">
        <div class="nav-mobile-header">
            <div class="logo">
                <a href="/unycall/"><img src="./assets/img/logo.png" alt="Logo UnyCall"></a>
            </div>
            <button type="button" id="closeNavMobile">X</button>
        </div>
        <ul class="nav-mobile-links">
            <!-- <li class="menu-list-item"><a href="#">Sobre</a></li> -->
            <li class="nav-mobile-links-item"><a href="<?= CAMINHO_PADRAO ?>/servicos.php">Serviços</a></li>
            <li class="nav-mobile-links-item"><a href="<?= CAMINHO_PADRAO ?>/contato.php">Contato</a></li>
        </ul>
        <div class="nav-mobile-buttons">
            <a class="btn secondary" href="<?= CAMINHO_PADRAO ?>/cadastro.php">Cadastrar-se</a>
            <a class="btn" href="<?= CAMINHO_PADRAO ?>/login.php">Login</a>
        </div>
    </nav>
    <button type="button" class="menu-mobile principal">
        <span></span>
        <span></span>
        <span></span>
    </button>
</header>

<script src="/unycall/assets/js/header.js"></script>