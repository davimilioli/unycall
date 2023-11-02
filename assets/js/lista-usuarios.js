document.addEventListener("DOMContentLoaded", () => {
    function excluirUsuario() {
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

    function paginacaoUsuarios() {
        const listaUsuarios = document.querySelectorAll('.list-users-table tbody tr');
        const paginacoes = document.querySelectorAll('.page-link');
        const corpoTabela = document.querySelector('.list-users-table tbody');
        const quantidadeUsuarios = corpoTabela.getAttribute('data-qtd-usuarios');

        function mostrarPagina(numeroPagina) {
            const startIndex = (numeroPagina - 1) * quantidadeUsuarios;
            const endIndex = numeroPagina * quantidadeUsuarios;

            listaUsuarios.forEach(function (usuario, index) {
                if (index >= startIndex && index < endIndex) {
                    usuario.style.display = "table-row";
                } else {
                    usuario.style.display = "none";
                }
            });
        }

        paginacoes.forEach(function (link, index) {
            link.addEventListener("click", function (e) {
                e.preventDefault();

                paginacoes.forEach((outroLink) => {
                    outroLink.classList.remove('active');
                })

                link.classList.add('active');
                mostrarPagina(index + 1);
            });
        });

        mostrarPagina(1);
    }

    paginacaoUsuarios();
});