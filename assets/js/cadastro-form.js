document.addEventListener('DOMContentLoaded', () => {
    async function consultarUsuarioBD() {
        try {
            const response = await fetch('../cliente/busca_usuario.php');
            if (!response.ok) {
                throw new Error('Erro ao pegar dados');
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro:', error);
            return [];
        }
    }

    const sexo = document.querySelector('#sexo');

    function setarBorda(seletor, color) {
        if (color == true) {
            const element = document.querySelector(seletor);
            element.style.borderColor = 'green';
        } else {
            const element = document.querySelector(seletor);
            element.style.borderColor = 'red';
        }
    }

    function validarNome() {

        const nome = document.querySelector('#nome');
        let nomeValido = false;
        let nomeRegex = /^[A-Za-z\s]+$/;

        nome.addEventListener('keyup', () => {
            if (nome.value.length < 15 || /\s\s/.test(nome.value) || nome.value.length > 65) {
                nomeValido = false;
                setarBorda('#nome', false);
            } else {
                nomeValido = true;
                console.log(nomeValido);
                setarBorda('#nome', true);
            }

            return nomeValido;
        })
    }

    validarNome();

    /* VALIDAÇÃO NASCIMENTO */

    function validarDataNascimento() {
        const dataNascimento = document.querySelector('#data-nascimento');
        let validaData = false;

        dataNascimento.addEventListener('input', () => {
            let nascimentoValue = dataNascimento.value;
            nascimentoValue = nascimentoValue.replace(/[^0-9]/g, '');

            if (nascimentoValue.length >= 2 && nascimentoValue.length < 4) {
                nascimentoValue = nascimentoValue.slice(0, 2) + '/' + nascimentoValue.slice(2);
            } else if (nascimentoValue.length >= 4) {
                nascimentoValue = nascimentoValue.slice(0, 2) + '/' + nascimentoValue.slice(2, 4) + '/' + nascimentoValue.slice(4, 8);
            }

            if (nascimentoValue.length === 10) {
                validaData = true;
                setarBorda('#data-nascimento', true);
            } else {
                validaData = false;
                setarBorda('#data-nascimento', false);
            }

            dataNascimento.value = nascimentoValue;


        });

        return validaData;
    }

    validarDataNascimento();

    function validarCpf() {
        const cpf = document.querySelector('#cpf');
        const mensagemAviso = document.querySelector('.message_notice.cpf')
        let validaCpf = false;

        cpf.addEventListener("input", function () {
            let formatarCpf = cpf.value.replace(/\D/g, '');
            let validarFormatacao = '';

            for (let i = 0; i < formatarCpf.length; i++) {
                if (i === 3 || i === 6) {
                    validarFormatacao += '.';
                    setarBorda('#cpf', false);
                } else if (i === 9) {
                    validarFormatacao += '-';
                    setarBorda('#cpf', false);
                } else if (i === 11) {
                    setarBorda('#cpf', true);
                }
                validarFormatacao += formatarCpf[i];
            }

            if (cpf.value === '') {
                cpf.style.borderColor = '#d5dfff';
            }

            cpf.value = validarFormatacao;

            validarCPF(formatarCpf);

            setTimeout(() => {
                cpfExiste();
            }, 500);

            if (cpf.value < 11) {
                cpfEncontrado = false;
                mensagemAviso.style.display = 'none';
            }
        });

        async function cpfExiste() {
            const consultaCpf = await consultarUsuarioBD()
            let cpfEncontrado = false
            const valorCpf = cpf.value.replace(/[.-]/g, '');
            consultaCpf.forEach((item) => {

                if (valorCpf.length == 11 && valorCpf == item.cpf) {
                    cpfEncontrado = true;
                }
            })

            if (cpfEncontrado) {
                mensagemAviso.style.display = 'flex';
            }
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

            setarBorda('#cpf', true);
            return true;
        }
    }

    validarCpf();

    function validarNomeMaterno() {

        const nomeMaterno = document.querySelector('#nomeMaterno');
        let nomeValido = false;

        nomeMaterno.addEventListener('keyup', () => {
            if (nomeMaterno.value.length < 15 || /\s\s/.test(nomeMaterno.value) || nomeMaterno.value.length > 65) {
                nomeValido = false;
                setarBorda('#nomeMaterno', false);
            } else {
                nomeValido = true;
                setarBorda('#nomeMaterno', true);
                console.log('NOME MATERNO: ' + nomeValido);
            }
        })
    }

    validarNomeMaterno();

    function validarEmail() {

        const email = document.querySelector('#email');
        let validaEmail = false;

        email.addEventListener('input', function () {
            const emailValue = email.value;
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            if (emailPattern.test(emailValue)) {
                validaEmail = true;
                setarBorda('#email', true);
                console.log('email: ' + validaEmail);
            } else {
                setarBorda('#email', false);
                validaEmail = false;
            }
        });
    }

    validarEmail();

    function validarCelular() {
        const celular = document.querySelector('#celular');

        celular.addEventListener('input', () => {
            const numero = celular.value.replace(/\D/g, '');
            let celularFormatado = '';

            if (numero.length > 0) {
                telefoneFormatado = `(+${numero.slice(0, 2)})`;

                if (numero.length > 2) {
                    telefoneFormatado += ` ${numero.slice(2, 4)}-`;

                    if (numero.length > 4) {
                        telefoneFormatado += numero.slice(4, 13);
                    }
                }
            }

            if (numero.length == 13) {
                setarBorda('#celular', true);
            } else {
                setarBorda('#celular', false);
            }

            celular.value = telefoneFormatado;
        });

    }

    validarCelular();

    function validarTelefone() {
        const telefone = document.querySelector('#telefone');

        telefone.addEventListener('input', () => {
            const numero = telefone.value.replace(/\D/g, '');
            let telefoneFormatado = '';

            if (numero.length > 0) {
                telefoneFormatado = `(+${numero.slice(0, 2)})`;

                if (numero.length > 2) {
                    telefoneFormatado += ` ${numero.slice(2, 4)}-`;

                    if (numero.length > 4) {
                        telefoneFormatado += numero.slice(4, 12);
                    }
                }
            }

            if (numero.length == 12) {
                setarBorda('#telefone', true);
            } else {
                setarBorda('#telefone', false);
            }

            telefone.value = telefoneFormatado;
        });

    }

    validarTelefone();

    function validarCep() {

        let validaCep = false;

        const cep = document.querySelector('#cep');
        const address = document.querySelector('#endereco');
        const city = document.querySelector('#cidade');
        const state = document.querySelector('#estado');
        const neighborhood = document.querySelector('#bairro');
        const inputsAddress = document.querySelectorAll('[data-input-address]');
        const numEndereco = document.querySelector('#numend');
        const complemento = document.querySelector('#complemento');
        function formatCEP(cepValue) {
            const cleanValue = cepValue.replace(/\D/g, '');
            return cleanValue.replace(/(\d{5})(\d{3})/, '$1-$2');
        }

        cep.addEventListener('keypress', function (e) {
            const onlyNumbers = /[0-9]/;
            const key = String.fromCharCode(e.keyCode);

            if (!onlyNumbers.test(key)) {
                e.preventDefault();
                return;
            }
        });

        cep.addEventListener('input', function (e) {
            const inputValue = e.target.value;
            const formattedCEP = formatCEP(inputValue);
            e.target.value = formattedCEP;

        });

        cep.addEventListener('keyup', function (e) {
            const inputValue = e.target.value;

            if (inputValue.length === 9) {
                const cepValue = inputValue.replace(/\D/g, '');
                getAddress(cepValue);
                if (getAddress(cepValue)) {
                    inputsAddress.forEach((item) => {
                        if (item.getAttribute('id') == 'numend' || item.getAttribute('id') == 'complemento') {
                            item.style.borderColor = 'none';
                        } else {
                            item.style.borderColor = 'green';
                        }
                    })
                }
            }
        });

        numEndereco.addEventListener('keyup', function () {

            if (numEndereco.value.length > 0) {
                setarBorda('#numend', true);
            } else {
                setarBorda('#numend', false);
            }
        });

        complemento.addEventListener('keyup', function () {

            if (numEndereco.value.length > 0) {
                setarBorda('#complemento', true);
            }
        });

        async function getAddress(cep) {
            loading('buscando cep');

            const url = `https://viacep.com.br/ws/${cep}/json/`;

            const response = await fetch(url);

            const data = await response.json();

            if (data.erro) {
                validaCep = false;

                inputsAddress.forEach(function (input) {
                    input.value = '';
                });

                loading();
                return;
            } else {
                validaCep = true;

                loading();
            }

            address.value = data.logradouro !== undefined ? data.logradouro : '';
            city.value = data.localidade !== undefined ? data.localidade : '';
            state.value = data.uf !== undefined ? data.uf : '';
            neighborhood.value = data.bairro !== undefined ? data.bairro : '';

        }

        const clearInputs = document.querySelector('#limpar');
        const formGroupContainer = document.querySelectorAll('.formGroup-container');

        clearInputs.addEventListener('click', function () {
            formGroupContainer.forEach(function (container) {
                container.querySelectorAll('[data-input-address]').forEach(function (input) {
                    input.value = '';
                });
            });

            numEndereco.value = '';
            complemento.value = '';
        });

    }

    validarCep()


    function validarLogin() {

        const login = document.querySelector('#login');
        let validaLogin = false;

        login.addEventListener('keyup', () => {
            if (login.value.length < 6) {
                validaLogin = false;
                setarBorda('#login', false);
            } else {
                setarBorda('#login', true);
                validaLogin = true;
                console.log('Login: ' + validaLogin);
            }
        })
    }

    validarLogin();

    function validarSenha() {

        const senha = document.querySelector('#senha');
        let validaSenha = false

        senha.addEventListener('keyup', () => {

            const senhaValue = senha.value;
            const quantidadeAlfabeticos = contarCaracteresAlfabeticos(senhaValue);

            if (quantidadeAlfabeticos >= 8) {
                validaSenha = true;
                console.log('Senha: ' + validaSenha)
                setarBorda('#senha', true);
            } else {
                setarBorda('#senha', false);
                validaSenha = false;
            }
        })

        const confirmaSenha = document.querySelector('#confirmar-senha');
        confirmaSenha.addEventListener('keyup', () => {
            if (confirmaSenha.value != senha.value) {
                validaConfirma = false;
                setarBorda('#confirmar-senha', false);
            } else {
                validaConfirma = true;
                setarBorda('#confirmar-senha', true);
                console.log('confirmar senha: ' + validaConfirma)
            }
        })

        function contarCaracteresAlfabeticos(senha) {
            const padrao = /[a-zA-Z]/g;
            const caracteresAlfabeticos = senha.match(padrao);
            return caracteresAlfabeticos ? caracteresAlfabeticos.length : 0;
        }
    }

    validarSenha();

    function validarFormulário() {

        const btnCadastrar = document.querySelector('#cadastrar');
        const form = document.querySelector('.form');

        btnCadastrar.addEventListener('click', (e) => {
            e.preventDefault()

            const inputsVazios = form.querySelectorAll('input');
            inputsVazios.forEach((item) => {
                if (item.value == '') {
                    item.style.borderColor = 'red';
                } else {
                    const nome = document.querySelector('#nome');
                    const confirmaSenha = document.querySelector('#confirmar-senha');
                    const senha = document.querySelector('#senha');
                    const login = document.querySelector('#login');
                    const cep = document.querySelector('#cep');
                    const telefone = document.querySelector('#telefone');
                    const celular = document.querySelector('#celular');
                    const email = document.querySelector('#email');
                    const nomeMaterno = document.querySelector('#nomeMaterno');
                    const cpf = document.querySelector('#cpf');
                    const dataNascimento = document.querySelector('#data-nascimento');

                    if (nome.value !== '' && dataNascimento.value !== '' && cpf.value !== '' && nomeMaterno.value !== '' && email.value !== '' && celular.value !== '' && telefone.value !== '' && cep.value !== '' && login.value !== '' && senha.value !== '' && confirmaSenha.value !== '') {
                        loading('validando cadastro')

                        setTimeout(() => {
                            form.submit();
                            loading('validando cadastro')
                        }, 2000)
                    }
                }
            })
        })
    }

    validarFormulário();

    function loading(msg) {
        const loading = document.querySelector('.loading');
        const message = document.querySelector('.loading-message')
        loading.classList.toggle('hide');
        message.innerHTML = msg;
    }

});