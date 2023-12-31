<?php $verificarPermissao = $sistema->verificarPermissao(); ?>
<aside class="page-cliente-aside">
    <nav class="page-cliente-aside-content">
        <div class="page-cliente-aside-header">
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/dashboard.svg">
                        <a href="<?= CAMINHO_PADRAO ?>/sistema/sistema.php">Dashboard</a>
                    </span>
                </div>
            </div>
        </div>
        <?php if ($verificarPermissao  === true) : ?>
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/user.svg">
                        Usuarios
                    </span>
                    <img class="icon-arrow" src="<?= CAMINHO_PADRAO ?>/assets/img/icons/arrow-drop.svg">
                </div>
                <div class="aside-nav">
                    <ul class="aside-list">
                        <li class="aside-list-item">
                            <a href="<?= CAMINHO_PADRAO ?>/sistema/usuarios/lista-usuarios.php">Lista de Usuarios</a>
                        </li>
                        <li class="aside-list-item">
                            <a href="<?= CAMINHO_PADRAO ?>/sistema/usuarios/adicionar-usuario.php">Adicionar Usuario</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/database.svg">
                        Banco de dados
                    </span>
                    <img class="icon-arrow" src="<?= CAMINHO_PADRAO ?>/assets/img/icons/arrow-drop.svg">
                </div>
                <div class="aside-nav">
                    <ul class="aside-list">
                        <li class="aside-list-item">
                            <a href="<?= CAMINHO_PADRAO ?>/sistema/banco/modelo.php">Modelo</a>

                        </li>
                    </ul>
                </div>
            </div>
        <?php endif ?>
        <div class="aside-category">
            <div class="aside-category-title">
                <span class="aside-category-titles">
                    <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/user.svg">
                    Assinatura
                </span>
                <img class="icon-arrow" src="<?= CAMINHO_PADRAO ?>/assets/img/icons/arrow-drop.svg">
            </div>
            <div class="aside-nav">
                <ul class="aside-list">
                    <li class="aside-list-item">
                        <a href="<?= CAMINHO_PADRAO ?>/sistema/assinatura/gerenciar.php">Gerenciar</a>
                    </li>
                    <?php if ($verificarPermissao  === true) : ?>
                        <li class="aside-list-item">
                            <a href="<?= CAMINHO_PADRAO ?>/sistema/assinatura/adicionar-servico.php">Adicionar Serviço</a>
                        </li>
                        <li class="aside-list-item">
                            <a href="<?= CAMINHO_PADRAO ?>/sistema/assinatura/lista-servicos.php">Lista de Serviços</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <!--         <div class="aside-category">
            <div class="aside-category-title">
                <span class="aside-category-titles">
                    <img src="<?= CAMINHO_PADRAO ?>/assets/img/icons/user.svg">
                    Faturas
                </span>
                <img class="icon-arrow" src="<?= CAMINHO_PADRAO ?>/assets/img/icons/arrow-drop.svg">
            </div>
            <div class="aside-nav">
                <ul class="aside-list">
                    <li class="aside-list-item">
                        <a href="#">Forma de Pagamento</a>
                    </li>
                    <li class="aside-list-item">
                        <a href="#">Histórico</a>
                    </li>
                </ul>
            </div>
        </div> -->
    </nav>
</aside>