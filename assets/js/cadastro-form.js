document.addEventListener('DOMContentLoaded', () => {

    function inicializacao() {
        validarNome();
        validarDataNascimento();
        validarCpf();
        validarNomeMaterno();
        validarEmail();
        validarCelular();
        validarTelefone();
        validarCep()
        validarLogin();
        validarSenha();
        validarFormulário();

        console.log('[+] cadastro-form.js iniciado');
    }

    inicializacao();

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

    async function verificarDadoExiste(termo, valor) {
        const consulta = await consultarUsuarioBD();
        const termoConsulta = termo;
        const valorConsulta = valor.replace(/[-.]/g, '');
        console.log('a');

        let encontrado = false;

        consulta.forEach((item) => {
            if (item[termoConsulta] === valorConsulta) {
                encontrado = true;
            }
        });

        return encontrado;
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

    function validarCpf() {
        const cpf = document.querySelector('#cpf');
        const mensagemAviso = document.querySelector('.message_notice.cpf');
        let validaCpf = false;

        cpf.addEventListener("input", async () => {
            let formatarCpf = cpf.value.replace(/\D/g, '');
            let validarFormatacao = '';

            for (let i = 0; i < formatarCpf.length; i++) {
                if (i === 3 || i === 6) {
                    validarFormatacao += '.';
                } else if (i === 9) {
                    validarFormatacao += '-';
                } else if (i === 11) {
                    setarBorda('#cpf', true);
                }
                validarFormatacao += formatarCpf[i];
            }

            cpf.value = validarFormatacao;
            validarCPF(formatarCpf);

            if (cpf.value === '') {
                cpf.style.borderColor = '#d5dfff';

            } else if (cpf.value.length < 11) {
                mensagemAviso.style.display = 'none';
                cpf.style.borderColor = '#d5dfff';

            } else if (cpf.value.length == 14) {
                const verificarCpfExiste = await verificarDadoExiste('cpf', formatarCpf);
                if (verificarCpfExiste) {
                    mensagemAviso.style.display = 'flex';
                    setarBorda('#cpf', false);
                } else {
                    mensagemAviso.style.display = 'none';
                    setarBorda('#cpf', true);
                }
            }
        });

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

            const url = `https://viacep.com.br/ws/${cep}/json/`;

            const response = await fetch(url);

            const data = await response.json();

            if (data.erro) {
                validaCep = false;

                inputsAddress.forEach(function (input) {
                    input.value = '';
                });

                return;
            } else {
                validaCep = true;
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

    function validarLogin() {

        const login = document.querySelector('#login');
        const mensagemAvisoLogin = document.querySelector('.message_notice.login')
        let validaLogin = false;

        login.addEventListener('input', async () => {
            const valorLogin = login.value;
            if (valorLogin.length < 6) {
                validaLogin = false;
                setarBorda('#login', false);
            } else {
                setarBorda('#login', true);
                validaLogin = true;
                console.log('Login: ' + validaLogin);
            }

            if (valorLogin === '') {
                login.style.borderColor = '#d5dfff';

            } else if (valorLogin.length < 6) {
                mensagemAvisoLogin.style.display = 'none';
                login.style.borderColor = '#d5dfff';

            } else if (valorLogin.length == 6) {
                const verificarLoginExiste = await verificarDadoExiste('login', valorLogin);
                if (verificarLoginExiste) {
                    mensagemAvisoLogin.style.display = 'flex';
                    setarBorda('#login', false);
                } else {
                    mensagemAvisoLogin.style.display = 'none';
                    setarBorda('#login', true);
                }
            }
        })
    }

    function validarSenha() {

        const senha = document.querySelector('#senha');
        const confirmaSenha = document.querySelector('#confirmar-senha');
        const mensagemAvisoSenha = document.querySelector('.message_notice.senha')
        let validaSenha = false

        senha.addEventListener('input', () => {

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

        confirmaSenha.addEventListener('input', () => {
            if (confirmaSenha.value == senha.value) {
                validaConfirma = true;
                setarBorda('#confirmar-senha', true);
                console.log('confirmar senha: ' + validaConfirma);
                mensagemAvisoSenha.style.display = 'none';
            } else {
                validaConfirma = false;
                setarBorda('#confirmar-senha', false);
                mensagemAvisoSenha.style.display = 'flex';

            }
        })

        function contarCaracteresAlfabeticos(senha) {
            const padrao = /[a-zA-Z]/g;
            const caracteresAlfabeticos = senha.match(padrao);
            return caracteresAlfabeticos ? caracteresAlfabeticos.length : 0;
        }
    }

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

                        btnCadastrar.style.opacity = '0.5';
                        btnCadastrar.innerHTML = `
                            <div class="loading">
                                <div class="loading-content">
                                    <div class="spinner-one"></div>
                                </div>
                            </div> ` + 'Validando...';
                        setTimeout(() => {
                            form.submit();
                            btnCadastrar.innerHTML = 'Cadastrar';
                        }, 2000)
                    }
                }
            })
        })
    }

});