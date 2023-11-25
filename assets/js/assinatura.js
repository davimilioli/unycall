document.addEventListener("DOMContentLoaded", () => {

    function inicializacao() {
        activeLayout();
        validarNumeroCartao();
        validarCvv();
        validarValidade();
        validarTitular();
        validarCpf();
        validacaoForm();
        verAssinaturaModal();

        console.log('[+] assinatura.js iniciado');
    }

    inicializacao();

    function activeLayout() {

        const buttonSignature = document.querySelector('#buttonSignature');
        const formSignature = document.querySelector('#formSignature');
        const containerButton = document.querySelector('.signature-screen-hidden');

        if (buttonSignature) {
            buttonSignature.addEventListener('click', () => {
                formSignature.classList.add('active');
                containerButton.classList.add('hidden');
            })
        }
    }

    function validarNumeroCartao() {
        const numeroCartao = document.querySelector('#numCartao');

        if (numeroCartao) {
            numeroCartao.addEventListener('input', () => {
                let inputValue = numeroCartao.value.replace(/\D/g, '');
                inputValue = inputValue.replace(/(\d{4})(?=\d)/g, '$1 ');

                if (inputValue.length > 19) {
                    inputValue = inputValue.slice(0, 19);
                }

                numeroCartao.value = inputValue;
            });
        }
    }

    function validarCvv() {
        const cvv = document.querySelector('#cvv');
        if (cvv) {
            cvv.addEventListener('input', () => {
                let inputValue = cvv.value.replace(/\D/g, '');
                inputValue = inputValue.slice(0, 3);
                cvv.value = inputValue;

            });
        }
    }

    function validarValidade() {
        const validade = document.querySelector('#validade');

        if (validade) {
            validade.addEventListener('input', () => {
                let inputValue = validade.value.replace(/\D/g, '');

                if (inputValue.length > 4) {
                    inputValue = inputValue.slice(0, 4);
                }

                if (inputValue.length >= 2) {
                    inputValue = inputValue.slice(0, 2) + '/' + inputValue.slice(2);
                }

                validade.value = inputValue;
            });

            validade.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    let inputValue = validade.value.replace(/\D/g, '');
                    if (inputValue.length > 0) {
                        inputValue = inputValue.slice(0, -1);
                        if (inputValue.length >= 2) {
                            inputValue = inputValue.slice(0, 2) + '/' + inputValue.slice(2);
                        }
                        validade.value = inputValue;
                    }
                }
            });
        }
    }

    function validarTitular() {
        const titular = document.querySelector('#titular');
        let titularRegex = /^[A-Za-z\s]+$/;

        titular.addEventListener('input', () => {
            if (titular.value.length < 15 || /\s\s/.test(titular.value) || titular.value.length > 65 || !titularRegex.test(titular.value)) {
                titularValido = false
                titular.value = titular.value.replace(/[0-9]/g, '');
            }
        });
    }

    function validarCpf() {
        const cpf = document.querySelector('#cpfTitular');

        if (cpf) {
            cpf.addEventListener("input", () => {
                let formatarCpf = cpf.value.replace(/\D/g, '');
                let validarFormatacao = '';

                for (let i = 0; i < formatarCpf.length; i++) {
                    if (i === 3 || i === 6) {
                        validarFormatacao += '.';
                    } else if (i === 9) {
                        validarFormatacao += '-';
                    }
                    validarFormatacao += formatarCpf[i];
                }

                cpf.value = validarFormatacao;
                validarCPF(formatarCpf);
            });
        }

        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');

            let soma = 0;
            for (let i = 0; i < 9; i++) {
                soma += parseInt(cpf.charAt(i)) * (10 - i);
            }

            let resto = 11 - (soma % 11);
            if (resto === 10 || resto === 11) resto = 0;

            if (resto !== parseInt(cpf.charAt(9))) return false;

            soma = 0;
            for (let i = 0; i < 10; i++) {
                soma += parseInt(cpf.charAt(i)) * (11 - i);
            }

            resto = 11 - (soma % 11);
            if (resto === 10 || resto === 11) resto = 0;

            if (resto !== parseInt(cpf.charAt(10))) return false;

            return true;
        }
    }

    function validacaoForm() {
        const form = document.querySelector('.form');
        const botaoAssinar = document.querySelector('#assinar');

        if (botaoAssinar) {
            botaoAssinar.addEventListener('click', (e) => {
                e.preventDefault();

                const inputs = form.querySelectorAll('input');
                inputs.forEach((input) => {
                    if (input.value == '') {
                        input.style.borderColor = 'red';
                    } else {
                        const numeroCartao = document.querySelector('#numCartao');
                        const cvv = document.querySelector('#cvv');
                        const validade = document.querySelector('#validade');
                        const titular = document.querySelector('#titular');
                        const cpf = document.querySelector('#cpfTitular');

                        if (numeroCartao.value != '' && cvv.value.length != '' && validade.value.length != '' && titular.value.length !== '' && cpf.value.length != '') {
                            console.log('formulário validado');

                            botaoAssinar.style.opacity = '0.5';
                            botaoAssinar.innerHTML = `
                            <div class="loading">
                                <div class="loading-content">
                                    <div class="spinner-one"></div>
                                </div>
                            </div> ` + 'Validando...';

                            setTimeout(() => {
                                form.submit();
                                botaoAssinar.innerHTML = 'Assinar';
                            }, 2000)
                        }
                    }
                })
            })
        }
    }

    function verAssinaturaModal() {
        const openModal = document.querySelector('#view-signature');
        if (openModal) {
            const modal = document.querySelector('.view-signature-modal');
            const closeModal = document.querySelector('#closeModalSignature')
            openModal.addEventListener('click', () => {
                modal.classList.add('active');
            })

            closeModal.addEventListener('click', () => {
                modal.classList.remove('active');
            })
        }
    }

    function excluirAssinatura() {
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
                            <h2>Tem certeza que deseja cancelar?</h2>
                            <button type="button" class="closeModal">X</button>
                        </div>
                        <form id="formExclude" method="POST">
                            <input type="hidden" name="excluirAssinatura" value="${btnAttrId}">
                            <div class="buttons-modal">
                                <button class="btn" type="button" id="excluirAssinatura">Sim</a>
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

                const formExclude = document.querySelector('#formExclude')
                const excluirAssinatura = document.querySelector('#excluirAssinatura');
                excluirAssinatura.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = '/php/cliente/cliente.php';
                    formExclude.submit();
                })
            });
        });
    }

    excluirAssinatura();
});