document.addEventListener("DOMContentLoaded", () => {

    function buscaUsuario() {
        const buscarNomeInput = document.querySelector("#buscarNome");

        if (buscarNomeInput) {

            buscarNomeInput.addEventListener('input', () => {
                const termoBusca = buscarNomeInput.value.toLowerCase();

                const listaUsuarios = listaUsuariosBd;

                const tabela = document.querySelector("tbody");
                let usuarioEncontrado = false;
                tabela.innerHTML = "";

                listaUsuarios.forEach(function (usuario) {
                    const nomeUsuario = usuario.nome.toLowerCase();
                    if (nomeUsuario.includes(termoBusca)) {
                        const novaLinha = document.createElement("tr");
                        novaLinha.innerHTML = `
                        <td class="table-id" title="${usuario.id}">${usuario.id}</td>
                        <td title="${usuario.nome}">${usuario.nome}</td>
                        <td title="${usuario.cpf}">${usuario.cpf}</td>
                        <td title="${usuario.email}">${usuario.email}</td>
                        <td title="${usuario.celular}">${usuario.celular}</td>
                        <td title="${usuario.telefone}">${usuario.telefone}</td>
                        <td class="table-permissao" title="${usuario.permissao}" id="${usuario.permissao}">
                            <p>${usuario.permissao}</p>
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
            });
        }
    }

    buscaUsuario();


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