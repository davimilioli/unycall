function openMenuMobile() {
    const openMenu = document.querySelector('.menu-mobile');
    const menu = document.querySelector('.menu');
    openMenu.addEventListener('click', () => {
        menu.classList.toggle('active');
    })
}

openMenuMobile();