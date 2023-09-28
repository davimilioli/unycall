<aside class="page-cliente-aside">
    <div class="page-cliente-aside-content">
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
                        <a href="./lista_usuarios.php">Lista de Usuarios</a>
                    </li>
                    <li class="aside-list-item">
                        <a href="./adicionar_usuario.php">Adicionar Usuario</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>

<script>
    const asideTitle = document.querySelector('.aside-category-title');
    const asideNav = document.querySelector('.aside-nav');
    const iconArrow = document.querySelector('.icon-arrow');
    asideTitle.addEventListener('click', () => {
        asideNav.classList.toggle('active');
        iconArrow.classList.toggle('active');
    })
</script>