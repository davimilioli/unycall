<aside class="page-cliente-aside">
    <nav class="page-cliente-aside-content">
        <div class="page-cliente-aside-header">
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="/assets/img/icons/dashboard.svg">
                        <a href="/php/cliente/cliente.php?id=<?= $_GET['id'] ?>">Dashboard</a>
                    </span>
                </div>
            </div>
        </div>
        <?php if ($verificarPerm['usuario']['permissao'] == 'administrador') : ?>
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="/assets/img/icons/user.svg">
                        Usuarios
                    </span>
                    <img class="icon-arrow" src="/assets/img/icons/arrow-drop.svg">
                </div>
                <div class="aside-nav">
                    <ul class="aside-list">
                        <li class="aside-list-item">
                            <a href="./lista_usuarios.php?id=<?= $_GET['id'] ?>">Lista de Usuarios</a>
                        </li>
                        <li class="aside-list-item">
                            <a href="./adicionar_usuario.php?id=<?= $_GET['id'] ?>">Adicionar Usuario</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="/assets/img/icons/database.svg">
                        Banco de dados
                    </span>
                    <img class="icon-arrow" src="/assets/img/icons/arrow-drop.svg">
                </div>
                <div class="aside-nav">
                    <ul class="aside-list">
                        <li class="aside-list-item">
                            <a href="./banco/modelo.php?id=<?= $_GET['id'] ?>">Modelo</a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif ?>
        <div class="aside-category">
            <div class="aside-category-title">
                <span class="aside-category-titles">
                    <img src="/assets/img/icons/user.svg">
                    Assinatura
                </span>
                <img class="icon-arrow" src="/assets/img/icons/arrow-drop.svg">
            </div>
            <div class="aside-nav">
                <ul class="aside-list">
                    <li class="aside-list-item">
                        <a href="./assinatura/gerenciar.php?id=66">Gerenciar</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="aside-category">
            <div class="aside-category-title">
                <span class="aside-category-titles">
                    <img src="/assets/img/icons/user.svg">
                    Faturas
                </span>
                <img class="icon-arrow" src="/assets/img/icons/arrow-drop.svg">
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
        </div>
    </nav>
</aside>