function openAside() {
    const openAside = document.querySelector('.aside-open');
    const aside = document.querySelector('.page-cliente-aside');
    openAside.addEventListener('click', () => {
        aside.classList.toggle('active');
        openAside.classList.toggle('active');
    })
}

function dropdownAside() {

    const asideTitles = document.querySelectorAll('.aside-category-title');

    asideTitles.forEach((title) => {
        title.addEventListener('click', () => {
            const asideCategory = title.parentElement;
            const asideNav = asideCategory.querySelector('.aside-nav');
            const iconArrow = asideCategory.querySelector('.icon-arrow');
            asideNav.classList.toggle('active');
            iconArrow.classList.toggle('active');
        });
    });

}

openAside();
dropdownAside();