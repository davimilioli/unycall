document.addEventListener("DOMContentLoaded", () => {

    function inicializacao() {
        buscaUsuario();
        excluirUsuario();
        paginacaoUsuarios();
        console.log('[+] lista-usuarios.js iniciado');
    }

    inicializacao();

    function buscaUsuario() {
        const buscarNomeInput = document.querySelector("#buscarNome");

        if (buscarNomeInput) {

            let ativarConsulta = '';
            buscarNomeInput.addEventListener('click', async () => {
                return ativarConsulta = await consultarUsuarioBD()
            })

            buscarNomeInput.addEventListener('input', () => {
                const termoBusca = buscarNomeInput.value.toLowerCase();

                const listaUsuarios = ativarConsulta;

                const tabela = document.querySelector("tbody");
                let usuarioEncontrado = false;
                tabela.innerHTML = "";

                listaUsuarios.forEach(function (usuario) {
                    const nomeUsuario = usuario.nome.toLowerCase();

                    if (termoBusca === '' || nomeUsuario.includes(termoBusca)) {
                        const novaLinha = document.createElement("tr");
                        novaLinha.innerHTML = `
                            <td class="table-id">${usuario.id}</td>
                            <td>${usuario.nome}</td>
                            <td>${usuario.cpf}</td>
                            <td>${usuario.email}</td>
                            <td>${usuario.celular}</td>
                            <td>${usuario.telefone}</td>
                            <td class="table-permissao" id="${usuario.permissao == '' ? 'comum' : usuario.permissao.toLowerCase()}">
                                <p>${usuario.permissao == '' ? 'Não possui' : usuario.permissao}</p>
                            </td>
                            <td class="table-buttons">
                                <a class="btn" title="editar ${usuario.nome}" href="/php/cliente/editar_usuario.php?edit=${usuario.id}">
                                    <img src="/assets/img/icons/edit.svg">
                                </a>
                                <a class="btn secondary" title="excluir ${usuario.nome}" id="excluirUsuario" data-id="${usuario.id}">
                                    <img src="/assets/img/icons/trash.svg">
                                </a>
                                
                            </td>
                        `;
                        tabela.appendChild(novaLinha);
                        usuarioEncontrado = true;
                    }
                });

                const resultadoVazio = document.querySelector('.result-null');
                if (usuarioEncontrado == false) {
                    resultadoVazio.classList.add('active')
                } else {
                    resultadoVazio.classList.remove('active')
                }

            });
        }
    }

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
});