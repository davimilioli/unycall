<?php
$dados = $sistema->procurarIdUsuario($_GET['id']);
?>

<header class="header cliente">
    <button class="aside-open">
        <img src="./assets/img/icons/menu-open.svg">
    </button>
    <div class="logo">
        <a href="../../cliente.php">
            <img src="./assets/img/logo.png" alt="Logo UnyCall">
        </a>
    </div>
    <nav class="menu">
        <ul class="menu-list">
            <li class="menu-list-item"><a href="/php/cliente/cliente.php?id=<?= $_GET['id'] ?>">Inicial</a></li>
            <li class="menu-list-item"><a href="#">Contato</a></li>
        </ul>
    </nav>
    <button type="button" class="menu-mobile">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="menu-profile">
        <button class="menu-profile-button">
            <img src="./assets/img/icons/profile.svg">
        </button>
        <div class="menu-profile-content">
            <div class="menu-profile-header">
                <div class="menu-profile-header-name"><?= $dados['usuario']['nome'] ?></div>
                <div class="menu-profile-header-email"><?= strlen($dados['usuario']['email']) > 30 ? substr($dados['usuario']['email'], 0, 30) . '...' : $dados['usuario']['email'] ?></div>
            </div>
            <div class="menu-profile-body">
                <ul class="menu-profile-body-list">
                    <li class="menu-profile-body-title"><a href="./informacoes-conta.php?id=<?= $_GET['id'] ?>">Informações da conta</a></li>
                    <li class="menu-profile-body-title">Segurança</li>
                    <li class="menu-profile-body-title">Atividades de Conta</li>
                    <li class="menu-profile-body-title">Suporte</li>
                </ul>
            </div>
            <div class="menu-profile-footer">
                <a class="btn" href="sair.php">Sair</a>
            </div>
        </div>
    </div>
</header>

<script>
    const openMenuProfile = document.querySelector('.menu-profile-button');
    const menuProfile = document.querySelector('.menu-profile-content');
    openMenuProfile.addEventListener('click', () => {
        menuProfile.classList.toggle('active')
    })
</script>