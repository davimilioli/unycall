<aside class="page-cliente-aside">
    <div class="page-cliente-aside-content">
        <?php if ($verificarPerm['usuario']['permissao'] == 'administrador') : ?>
            <div class="aside-category">
                <div class="aside-category-title">
                    <span class="aside-category-titles">
                        <img src="/assets/img/icons/user.svg">
                        Usuarios
                    </span>
                    <img class="icon-arrow" src="/assets/img/icons/arrow-drop.svg">
                </div>
                <nav class="aside-nav">
                    <ul class="aside-list">
                        <li class="aside-list-item">
                            <a href="./lista_usuarios.php?id=<?= $_GET['id'] ?>">Lista de Usuarios</a>
                        </li>
                        <li class="aside-list-item">
                            <a href="./adicionar_usuario.php?id=<?= $_GET['id'] ?>">Adicionar Usuario</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif ?>
    </div>
</aside>