<?php
$id = $_SESSION['id'];
$dados = $sistema->procurarIdUsuario($id);
?>

<header class="header cliente">
    <button class="aside-open">
        <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/menu-open.svg">
    </button>
    <div class="logo">
        <a href="<?= CAMINHO_PADRAO ?>/sistema/sistema.php">
            <img src=" <?= CAMINHO_PADRAO ?>/assets/img/logo.png" alt="Logo UnyCall">
        </a>
    </div>
    <div class="menu-profile">
        <button class="menu-profile-button">
            <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/profile.svg">
        </button>
        <div class="menu-profile-content">
            <div class="menu-profile-header">
                <div class="menu-profile-header-profile">
                    <div class="menu-profile-header-name"><?= $dados['usuario']['nome'] ?></div>
                    <div class="menu-profile-header-email"><?= strlen($dados['usuario']['email']) > 30 ? substr($dados['usuario']['email'], 0, 30) . '...' : $dados['usuario']['email'] ?></div>
                </div>
                <button type="button" id="closeMenuProfile">X</button>
            </div>
            <div class="menu-profile-body">
                <ul class="menu-profile-body-list">
                    <li class="menu-profile-body-title"><a href="<?= CAMINHO_PADRAO ?>/sistema/informacoes-conta.php">Informações da conta</a></li>
                    <!--                     <li class="menu-profile-body-title">Segurança</li>
                    <li class="menu-profile-body-title">Atividades de Conta</li>
                    <li class="menu-profile-body-title">Suporte</li> -->
                </ul>
            </div>
            <div class="menu-profile-footer">
                <a class="btn" href="<?= CAMINHO_PADRAO ?>/sistema/sair.php">Sair</a>
            </div>
        </div>
    </div>
</header>

<script>
    const openMenuProfile = document.querySelector('.menu-profile-button');
    const menuProfile = document.querySelector('.menu-profile-content');
    const bodyOverflow = document.querySelector('body');

    openMenuProfile.addEventListener('click', () => {
        menuProfile.classList.toggle('active')
        bodyOverflow.classList.toggle('active');
    })

    if (window.innerWidth < 640) {
        const closeProfile = document.querySelector('#closeMenuProfile');
        closeProfile.addEventListener('click', () => {
            menuProfile.classList.remove('active');
            bodyOverflow.classList.remove('active')
        })

    }
</script>