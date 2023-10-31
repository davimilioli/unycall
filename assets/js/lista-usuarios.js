function excluirUsuario() {
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
                        <a href="./actions/excluir_action.php?&exclude=${btnAttrId}" class="btn">Sim</a>
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
}

excluirUsuario();

function busca() {
    const buscarNome = document.querySelector('#buscarNome');
    const resultadoBusca = document.querySelector('.resultado-busca');
    const exibirBusca = resultadoBusca.querySelector('.resultado-busca-content');
    resultadoBusca.style.display = 'none';
    let tempo;

    buscarNome.addEventListener('keyup', (e) => {
        clearTimeout(tempo);
        const buscarValue = e.target.value;

        if (buscarValue.length >= 3) {
            tempo = setTimeout(() => {
                buscarUsuario(buscarValue);
            }, 500);
        }

    });

    buscarNome.addEventListener('keyup', () => {

        if (buscarNome.value == '') {
            exibirBusca.innerHTML = '';
            resultadoBusca.style.display = 'none';
        }
    })

    let usuarioNaoEncontrado = false;

    async function buscarUsuario(nome) {
        try {
            const url = 'busca_usuario.php';

            const formData = new FormData();
            formData.append('buscarNome', nome);

            const response = await fetch(url, {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();

            if (data.resposta === 'Nenhum usuário encontrado') {
                resultadoBusca.style.display = 'block';
                const template = `
                    <li class="resultado-busca-lista">
                        <a href="#">${data.resposta}</a>
                    </li>
                `;

                exibirBusca.innerHTML = template;
            } else {
                resultadoBusca.style.display = 'block';
                exibirBusca.innerHTML = '';

                const idUrl = window.location.search;
                const params = new URLSearchParams(idUrl);
                const idAdm = params.get('id');

                if (Array.isArray(data)) {
                    data.forEach((item) => {
                        const template = `
                            <li class="resultado-busca-lista">
                                <a href="editar_usuario.php?id=${idAdm}&edit=${item.id}">${item.nome}</a>
                            </li>
                        `;

                        exibirBusca.innerHTML += template;
                    });
                }


            }
        } catch (error) {
            resultadoBusca.style.display = 'block';
            const template = `
                <li class="resultado-busca-lista">
                    <a href="#">Erro ao busca usuário</a>
                </li>
            `;

            exibirBusca.innerHTML = template;
            console.log('erro: ' + error);
        }
    }
}

busca();