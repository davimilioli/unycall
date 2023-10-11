function openAside() {
    const openAside = document.querySelector('.aside-open');
    const aside = document.querySelector('.page-cliente-aside');
    openAside.addEventListener('click', () => {
        aside.classList.toggle('active');
        openAside.classList.toggle('active');
    })
}

openAside();