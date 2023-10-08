function openAside() {
    const openAside = document.querySelector('.aside-open');
    const aside = document.querySelector('.page-cliente-aside');
    openAside.addEventListener('click', () => {
        aside.classList.toggle('active');
        openAside.classList.toggle('active');
    })
}

openAside();

function openMenuMobile() {
    const openMenu = document.querySelector('.menu-mobile');
    const menu = document.querySelector('.menu');
    openMenu.addEventListener('click', () => {
        menu.classList.toggle('active');
    })
}

openMenuMobile();