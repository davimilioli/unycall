function openMenuMobile(seletor, element) {
    const openMenu = document.querySelector(seletor)
    if (openMenu) {
        const menu = document.querySelector(element);
        openMenu.addEventListener('click', () => {
            menu.classList.toggle('active');
        })
    }
}

function closeMenuMobile(seletor, element) {
    const closeMenu = document.querySelector(seletor)
    if (closeMenu) {
        const menu = document.querySelector(element);
        closeMenu.addEventListener('click', () => {
            menu.classList.remove('active');
        })
    }
}

openMenuMobile('.menu-mobile', '.menu');
openMenuMobile('.menu-mobile.principal', '.nav-mobile');
closeMenuMobile('#closeNavMobile', '.nav-mobile');