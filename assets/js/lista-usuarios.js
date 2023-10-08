const btnExcluir = document.querySelectorAll('[data-id]');
const modalExclude = document.querySelector('.modal-exclude');
const permissao = document.querySelectorAll('[data-permissao]');
const idAdm = document.querySelectorAll('[data-id-adm]');

btnExcluir.forEach((btn) => {
    const btnAttrId = btn.getAttribute('data-id');
    const btnAttrPerm = btn.getAttribute('data-permissao');
    const btnAttrAdm = btn.getAttribute('data-id-adm');

    btn.addEventListener('click', () => {

        modalExclude.classList.add('active');
        modalExclude.setAttribute('id', btnAttrId);

        const modalContent = `
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Tem certeza que deseja excluir?</h2>
                    <button type="button" class="closeModal">X</button>
                </div>
                <div class="buttons-modal">
                    <a href="./actions/excluir_action.php?id=${btnAttrAdm}&exclude=${btnAttrId}" class="btn">Sim</a>
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
