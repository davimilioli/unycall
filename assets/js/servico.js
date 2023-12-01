function excluirServico() {
    const btnExcluir = document.querySelectorAll('[data-id]');
    const modalExclude = document.querySelector('.modal-exclude');

    btnExcluir.forEach((btn) => {
        const btnAttrId = btn.getAttribute('data-id');

        btn.addEventListener('click', () => {

            modalExclude.classList.add('active');
            modalExclude.setAttribute('id', btnAttrId);

            const modalContent = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Tem certeza que deseja excluir?</h2>
                        <button type="button" class="closeModal">X</button>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="exclude" value="${btnAttrId}">
                        <div class="buttons-modal">
                            <button class="btn" type="submit">Sim</a>
                            <button class="btn secondary closeModal" type="button">Não</button>
                        </div>
                    </form>
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
}

excluirServico();