const btnExcluir = document.querySelectorAll('[data-id]');
const modalExclude = document.querySelector('.modal-exclude')

btnExcluir.forEach((btn) => {
    const btnAttr = btn.getAttribute('data-id');
    console.log(btnAttr)
    btn.addEventListener('click', () => {

        modalExclude.classList.add('active');
        modalExclude.setAttribute('id', btnAttr);

        const modalContent = `
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Tem certeza que deseja excluir?</h2>
                    <button type="button" class="closeModal">X</button>
                </div>
                <div class="buttons-modal">
                    <a href="./actions/excluir_action.php?id=${btnAttr}" class="btn">Sim</a>
                    <button class="btn secondary closeModal">Não</button>
                </div>
            </div>
        `;

        modalExclude.innerHTML = modalContent;

        const closeModal = document.querySelectorAll('.closeModal');
        closeModal.forEach((item) => {
            item.addEventListener('click', () => {
                modalExclude.classList.remove('active');
            })
        })

    });
});
