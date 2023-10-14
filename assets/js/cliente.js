function openAside() {
    const openAside = document.querySelector('.aside-open');
    const aside = document.querySelector('.page-cliente-aside');
    openAside.addEventListener('click', () => {
        aside.classList.toggle('active');
        openAside.classList.toggle('active');
    })
}

function dropdownAside() {

    const asideTitle = document.querySelector('.aside-category-title');
    const asideNav = document.querySelector('.aside-nav');
    const iconArrow = document.querySelector('.icon-arrow');
    asideTitle.addEventListener('click', () => {
        asideNav.classList.toggle('active');
        iconArrow.classList.toggle('active');
    })
}

openAside();
dropdownAside();