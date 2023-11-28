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
            const response = await fetch('/unycall/sistema/busca-usuario.php');
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
        const valorConsulta = valor;
        console.log('consultando: ' + valorConsulta)
        let encontrado = false;

        consulta.forEach((item) => {
            if (item[termoConsulta] === valorConsulta) {
                encontrado = true;
            }
        });

        return encontrado;
    }

    function validarNome() {
        const nome = document.querySelector('#nome');
        let nomeValido = false;
        let nomeRegex = /^[A-Za-z\s]+$/;

        nome.addEventListener('input', () => {
            if (nome.value.length < 15 || /\s\s/.test(nome.value) || nome.value.length > 65 || !nomeRegex.test(nome.value)) {
                nomeValido = false
                nome.value = nome.value.replace(/[0-9]/g, '');
            } else {
                nomeValido = true;
            }
        });
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
            } else {
                validaData = false;
            }

            dataNascimento.value = nascimentoValue;
        });

        dataNascimento.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace') {
                let nascimentoValue = dataNascimento.value.replace(/[^0-9]/g, '');
                if (nascimentoValue.length > 0) {
                    nascimentoValue = nascimentoValue.slice(0, -1);
                }
                dataNascimento.value = nascimentoValue;
            }
        });
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

                const verificarCpfExiste = await verificarDadoExiste('cpf', cpf.value);
                if (verificarCpfExiste) {

                    mensagemAviso.style.display = 'flex';
                } else {
                    mensagemAviso.style.display = 'none';
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

            return true;
        }
    }

    function validarNomeMaterno() {
        const nome = document.querySelector('#nome');
        const nomeMaterno = document.querySelector('#nomeMaterno');
        const mensagemAviso = document.querySelector('.message_notice.nomematerno');
        let nomeMaternoValido = false;
        let nomeMaternoRegex = /^[A-Za-z\s]+$/;

        nomeMaterno.addEventListener('input', () => {
            if (nomeMaterno.value.length < 15 || /\s\s/.test(nomeMaterno.value) || nomeMaterno.value.length > 65 || !nomeMaternoRegex.test(nomeMaterno.value)) {
                mensagemAviso.style.display = 'none';
                nomeMaternoValido = false;
                nomeMaterno.value = nomeMaterno.value.replace(/[0-9]/g, '');
            } else {
                nomeMaternoValido = true;
                console.log('NOME MATERNO: ' + nomeMaternoValido);
                if (nomeMaterno.value == nome.value) {
                    mensagemAviso.style.display = 'flex';
                } else {
                    mensagemAviso.style.display = 'none';
                }
            }
        });
    }


    function validarEmail() {

        const email = document.querySelector('#email');
        const mensagemAvisoEmail = document.querySelector('.message_notice.email')
        let validaEmail = false;
        email.addEventListener('input', async () => {
            const emailValue = email.value;
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            if (emailPattern.test(emailValue)) {
                if (emailValue.length > 6) {
                    const verificarEmailExiste = await verificarDadoExiste('email', emailValue);
                    if (verificarEmailExiste) {
                        mensagemAvisoEmail.style.display = 'flex';
                    } else {
                        mensagemAvisoEmail.style.display = 'none';
                    }
                } else {
                    mensagemAvisoEmail.style.display = 'none';
                }
                validaEmail = true;
            } else {
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
                celularFormatado = `(+${numero.slice(0, 2)})`;

                if (numero.length > 2) {
                    celularFormatado += ` ${numero.slice(2, 4)}-`;

                    if (numero.length > 4) {
                        celularFormatado += numero.slice(4, 13);
                    }
                }
            }

            celular.value = celularFormatado;
        });

        celular.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace') {
                let numero = celular.value.replace(/\D/g, '');
                if (numero.length > 0) {
                    numero = numero.slice(0, -1);
                    let celularFormatado = '';

                    if (numero.length > 0) {
                        celularFormatado = `(+${numero.slice(0, 2)})`;

                        if (numero.length > 2) {
                            celularFormatado += ` ${numero.slice(2, 4)}-`;

                            if (numero.length > 4) {
                                celularFormatado += numero.slice(4, 13);
                            }
                        }
                    }

                    celular.value = celularFormatado;
                }
            }
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

            telefone.value = telefoneFormatado;
        });

        telefone.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace') {
                let numero = telefone.value.replace(/\D/g, '');
                if (numero.length > 0) {
                    numero = numero.slice(0, -1);
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

                    telefone.value = telefoneFormatado;
                }
            }
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
            const inputValue = e.target.value.replace(/\D/g, '').slice(0, 8);
            const formattedCEP = formatCEP(inputValue);
            e.target.value = formattedCEP;
        });

        cep.addEventListener('keyup', function (e) {
            const inputValue = e.target.value;

            if (inputValue.length === 9) {
                const cepValue = inputValue.replace(/\D/g, '');
                getAddress(cepValue);
            }
        });

        async function getAddress(cep) {

            const mensagemAviso = document.querySelector('.message_notice.cep');
            const url = `https://viacep.com.br/ws/${cep}/json/`;

            const response = await fetch(url);

            const data = await response.json();
            if (data.erro === true) {
                mensagemAviso.style.display = 'flex';
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

        if (clearInputs) {
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

    }

    function validarLogin() {

        const login = document.querySelector('#login');
        const mensagemAvisoLogin = document.querySelector('.message_notice.login')
        let validaLogin = false;

        login.addEventListener('input', async () => {
            const valorLogin = login.value;
            if (valorLogin.length < 6) {
                validaLogin = false;
            } else {
                validaLogin = true;
                console.log('Login: ' + validaLogin);
            }

            if (valorLogin.length < 6) {
                mensagemAvisoLogin.style.display = 'none';

            } else if (valorLogin.length == 6) {
                const verificarLoginExiste = await verificarDadoExiste('login', valorLogin);
                if (verificarLoginExiste) {
                    mensagemAvisoLogin.style.display = 'flex';
                } else {
                    mensagemAvisoLogin.style.display = 'none';
                }
            }
        })
    }

    function validarSenha() {

        const senha = document.querySelector('#senha');
        const confirmaSenha = document.querySelector('#confirmar-senha');
        const mensagemAvisoSenha = document.querySelector('.message_notice.senha')
        let validaSenha = false;

        if (senha) {
            senha.addEventListener('input', () => {

                const senhaValue = senha.value;
                const quantidadeAlfabeticos = contarCaracteresAlfabeticos(senhaValue);

                if (quantidadeAlfabeticos >= 8) {
                    validaSenha = true;
                    console.log('Senha: ' + validaSenha)
                } else {
                    validaSenha = false;
                }
            })

            confirmaSenha.addEventListener('input', () => {
                if (confirmaSenha.value == senha.value) {
                    validaConfirma = true;
                    console.log('confirmar senha: ' + validaConfirma);
                    mensagemAvisoSenha.style.display = 'none';
                } else {
                    validaConfirma = false;
                    mensagemAvisoSenha.style.display = 'flex';

                }
            })

            function contarCaracteresAlfabeticos(senha) {
                const padrao = /[a-zA-Z]/g;
                const caracteresAlfabeticos = senha.match(padrao);
                return caracteresAlfabeticos ? caracteresAlfabeticos.length : 0;
            }
        }

    }

    function validarFormulário() {

        const btnCadastrar = document.querySelector('#cadastrar');
        const form = document.querySelector('.form');

        if (btnCadastrar) {

            btnCadastrar.addEventListener('click', (e) => {
                e.preventDefault()

                const inputsVazios = form.querySelectorAll('input');
                inputsVazios.forEach((item) => {
                    if (item.value == '') {
                        item.style.borderColor = 'red';
                    } else {
                        const nome = document.querySelector('#nome');
                        const confirmaSenha = document.querySelector('#confirmar-senha');
                        const senha = document.querySelector('#senha') ? document.querySelector('#senha').value !== '' : '';
                        const login = document.querySelector('#login');
                        const cep = document.querySelector('#cep');
                        const telefone = document.querySelector('#telefone');
                        const celular = document.querySelector('#celular');
                        const email = document.querySelector('#email');
                        const nomeMaterno = document.querySelector('#nomeMaterno');
                        const cpf = document.querySelector('#cpf');
                        const dataNascimento = document.querySelector('#data-nascimento');

                        validarDadosExistentes(cpf.value, email.value, login.value)
                            .then((dadosExistentes) => {
                                if (dadosExistentes === true) {

                                    if (nome.value !== '' && dataNascimento.value !== '' && cpf.value !== '' && nomeMaterno.value !== '' && email.value !== '' && celular.value !== '' && telefone.value !== '' && cep.value !== '' && login.value !== '' && senha && confirmaSenha.value !== '') {
                                        form.submit();
                                    } else {
                                        console.log('erro na validação');
                                    }

                                } else {
                                    const mensagemValidacao = document.querySelector('.message.validacao');
                                    mensagemValidacao.style.display = 'flex';
                                }
                            })
                            .catch((error) => {
                                console.error('Erro ao validar dados existentes:', error);
                            });
                    }
                })
            })
        }
    }

    async function validarDadosExistentes(cpf, email, login) {
        const validarCpf = await verificarDadoExiste('cpf', cpf);
        const validarEmail = await verificarDadoExiste('email', email);
        const validarLogin = await verificarDadoExiste('login', login);

        if (validarCpf !== true && validarEmail !== true && validarLogin !== true) {
            return true;
        } else {
            return false;
        }

    }
});