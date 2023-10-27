
const sexo = document.querySelector('#sexo');

/* VALIDAÇÃO NOME */
const nome = document.querySelector('#nome');
let nomeValido = false;
let nomeRegex = /^[A-Za-z\s]+$/;

nome.addEventListener('keyup', () => {
    if (nome.value.length < 15 || /\s\s/.test(nome.value) || nome.value.length > 65) {
        nomeValido = false;
    } else {
        nomeValido = true;
        console.log('NOME: ' + nomeValido);
    }
})

/* VALIDAÇÃO NASCIMENTO */
const dataNascimento = document.querySelector('#data-nascimento');
let validaData = false;

function validationDateBirth() {

    function formartDate() {
        let nascimentoValue = dataNascimento.value;
        nascimentoValue = nascimentoValue.replace(/[^0-9]/g, '');

        if (nascimentoValue.length >= 2 && nascimentoValue.length < 4) {
            nascimentoValue = nascimentoValue.slice(0, 2) + '/' + nascimentoValue.slice(2);
        } else if (nascimentoValue.length >= 4) {
            nascimentoValue = nascimentoValue.slice(0, 2) + '/' + nascimentoValue.slice(2, 4) + '/' + nascimentoValue.slice(4, 8);
        }

        dataNascimento.value = nascimentoValue;
    }

    function calculateAge(birthDate) {
        const today = new Date();
        const birthDateArray = birthDate.split('/');
        const birthYear = parseInt(birthDateArray[2], 10);
        const birthMonth = parseInt(birthDateArray[1], 10) - 1; // Subtrai 1 porque os meses em JavaScript começam com 0
        const birthDay = parseInt(birthDateArray[0], 10);
        const age = today.getFullYear() - birthYear;

        if (today.getMonth() < birthMonth || (today.getMonth() === birthMonth && today.getDate() < birthDay)) {
            age--; // Ainda não fez aniversário este ano
        }

        return age;
    }

    dataNascimento.addEventListener('input', formartDate);

    dataNascimento.addEventListener('blur', function () {
        const age = calculateAge(dataNascimento.value);

        if (age < 18) {
            validaData = false;
        } else {
            validaData = true;
            console.log('Data: ' + validaData)
        }
    });
}

validationDateBirth()

/* VALIDAÇÃO CPF */
const cpf = document.querySelector('#cpf');
let validaCpf = false;

cpf.addEventListener("input", function () {
    let formattedCPF = cpf.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    let validFormat = '';

    for (let i = 0; i < formattedCPF.length; i++) {
        if (i === 3 || i === 6) {
            validFormat += '.';
        } else if (i === 9) {
            validFormat += '-';
        }
        validFormat += formattedCPF[i];
    }

    cpf.value = validFormat;

    if (validarCPF(formattedCPF)) {
        validaCpf = true;
        console.log('CPF: ' + validaCpf)
    } else {
        validaCpf = false;
    }
});


function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

    if (cpf.length !== 11) return false;

    // Verificação do CPF
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


/* VALIDAÇÃO EMAIL */
const email = document.querySelector('#email');
let validaEmail = false;

email.addEventListener('input', function () {
    const emailValue = email.value;
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

    if (emailPattern.test(emailValue)) {
        validaEmail = true;
        console.log('email: ' + validaEmail);
    } else {
        validaEmail = false;
    }
});

/* VALIDAÇÃO CELULAR */

/* const celular = document.querySelector('#celular');
let validaCelular = false;

celular.addEventListener('input', function () {
    let celularValue = celular.value.replace(/\D/g, '');
    let formattedCelular = '';

    for (let i = 0; i < celularValue.length; i++) {
        if (i === 0) {
            formattedCelular += '(' + celularValue[i];
        } else if (i === 2) {
            formattedCelular += celularValue[i] + ') ';
        } else if (i === 5) {
            formattedCelular += '-' + celularValue[i];
        } else {
            formattedCelular += celularValue[i];
        }
    }

    celular.value = formattedCelular;

    if (celularValue.length === 14) {
        validaCelular = true;
        console.log('Celular: ' + validaCelular);
    } else {
        validaCelular = false;
    }
}); */


/* VALIDAÇÃO FIXO */
/* const telefone = document.querySelector('#telefone');
let validaTelefone = false;

telefone.addEventListener('input', function () {
    let telefoneValue = telefone.value.replace(/\D/g, ''); 
    let formattedTelefone = '';

    for (let i = 0; i < telefoneValue.length; i++) {
        if (i === 0) {
            formattedTelefone += '(' + telefoneValue[i];
        } else if (i === 2) {
            formattedTelefone += telefoneValue[i] + ') ';
        } else if (i === 5) {
            formattedTelefone += '-' + telefoneValue[i];
        } else {
            formattedTelefone += telefoneValue[i];
        }
    }

    telefone.value = formattedTelefone;

    if (telefoneValue.length === 13) {
        validaTelefone = true;
        console.log('Telefone: ' + validaTelefone)
    } else {
        validaTelefone = false;
    }
}); */

/* VALIDAÇÃO CEP */
let validaCep = false;

const cep = document.querySelector('#cep');
const address = document.querySelector('#endereco');
const city = document.querySelector('#cidade');
const state = document.querySelector('#estado');
const neighborhood = document.querySelector('#bairro');
const inputsAddress = document.querySelectorAll('[data-input-address]');
const numEndereco = document.querySelector('#numend'); // Campo de Número
const complemento = document.querySelector('#complemento'); // Campo de Complemento

// Variáveis booleanas para cada campo de endereço
let enderecoValid = false;
let bairroValid = false;
let cidadeValid = false;
let estadoValid = false;

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

    // Se o CEP foi alterado, remova o atributo disabled dos campos
    /*     address.disabled = false;
        neighborhood.disabled = false;
        city.disabled = false;
        state.disabled = false; */
});

cep.addEventListener('keyup', function (e) {
    const inputValue = e.target.value;

    if (inputValue.length === 9) {
        const cepValue = inputValue.replace(/\D/g, '');
        getAddress(cepValue);
    }
});

async function getAddress(cep) {
    loading('buscando cep');

    const url = `https://viacep.com.br/ws/${cep}/json/`;

    const response = await fetch(url);

    const data = await response.json();

    const cepInput = document.getElementById('cep'); // Seleciona o elemento com ID 'cep'

    if (data.erro) {
        validaCep = false;

        inputsAddress.forEach(function (input) {
            input.value = '';
        });

        // Remova o atributo disabled dos campos
        /*         address.disabled = false;
                neighborhood.disabled = false;
                city.disabled = false;
                state.disabled = false; */

        /* validateAddressFields(); */
        loading();
        return;
    } else {
        validaCep = true;
        console.log('CEP: ' + validaCep)

        // Chamada para validar os campos de endereço, bairro, cidade e estado
        /* validateAddressFields(); */
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

    /* validateAddressFields(); */
});

// VALIDAÇÃO DE ENDEREÇO

// FUNÇÃO DESABILITADA POIS NÃO ESTAVA DEIXANDO ENVIAR OS DADOS PARA O PHP
function validateAddressFields() {
    const endereco = document.getElementById('endereco');
    const bairro = document.getElementById('bairro');
    const cidade = document.getElementById('cidade');
    const estado = document.getElementById('estado');

    // Validação de cada campo de endereço
    enderecoValid = endereco.value.trim() !== '';
    bairroValid = bairro.value.trim() !== '';
    cidadeValid = cidade.value.trim() !== '';
    estadoValid = estado.value.trim() !== '';

    // Verifique se todos os campos são válidos e desative-os se forem
    if (enderecoValid && bairroValid && cidadeValid && estadoValid) {
        endereco.disabled = true;
        bairro.disabled = true;
        cidade.disabled = true;
        estado.disabled = true;
    }
}

/* VALIDAÇÃO LOGIN */
const login = document.querySelector('#login');
let validaLogin = false;

login.addEventListener('keyup', () => {
    if (login.value.length < 6) {
        validaLogin = false;
    } else {
        validaLogin = true;
        console.log('Login: ' + validaLogin);
    }
})

/* VALIDAÇÃO SENHA */
const senha = document.querySelector('#senha');
let validaSenha = false

senha.addEventListener('keyup', () => {

    const senhaValue = senha.value;
    const quantidadeAlfabeticos = contarCaracteresAlfabeticos(senhaValue);

    if (quantidadeAlfabeticos >= 8) {
        validaSenha = true;
        console.log('Senha: ' + validaSenha)
    } else {
        validaSenha = false;

    }
})

function contarCaracteresAlfabeticos(senha) {
    const padrao = /[a-zA-Z]/g;
    const caracteresAlfabeticos = senha.match(padrao);
    return caracteresAlfabeticos ? caracteresAlfabeticos.length : 0;
}

/* VALIDAÇÃO CONFIRMAÇÃO */
const confirmaSenha = document.querySelector('#confirmar-senha');
confirmaSenha.addEventListener('keyup', () => {
    if (confirmaSenha.value != senha.value) {
        validaConfirma = false;
    } else {
        validaConfirma = true;
        console.log('confirmar senha: ' + validaConfirma)
    }
})

const btnCadastrar = document.querySelector('#cadastrar');
const form = document.querySelector('.form');
console.log(btnCadastrar);

btnCadastrar.addEventListener('click', (e) => {
    e.preventDefault()

    if (nome.value !== '' && dataNascimento.value !== '' && cpf.value !== '' && email.value !== '' && celular.value !== '' && telefone.value !== '' && login.value !== '' && senha.value !== '') {
        form.setAttribute('action', '/php/cadastro/cadastro_action.php');
        loading('validando cadastro')

        setTimeout(() => {
            form.submit();
            loading('validando cadastro')
        }, 2000)
    } else {
        const btnsForm = document.querySelector('.form-actions');
        const existingMsgErro = document.querySelector('.message_error');

        if (!existingMsgErro) {
            const msgErro = document.createElement('div');
            msgErro.classList.add('message_error');
            const erroContent = `
            <p>
              <img src="./assets/img/icons/danger.svg">Preencha os campos
            </p>
          `;
            msgErro.innerHTML = erroContent;
            btnsForm.parentNode.insertBefore(msgErro, btnsForm.nextElementSibling);

            const inputs = form.querySelectorAll('input');
            inputs.forEach((input) => {
                input.addEventListener('click', () => {
                    if (msgErro) {
                        msgErro.innerHTML = ''; // Limpar a mensagem de erro se algum input for clicado
                    }
                });
            });
        }
    }
})

function loading(msg) {
    const loading = document.querySelector('.loading');
    const message = document.querySelector('.loading-message')
    loading.classList.toggle('hide');
    message.innerHTML = msg;
}