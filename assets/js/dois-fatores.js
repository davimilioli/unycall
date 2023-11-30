function DataNascimento(seletor) {
    const dataNascimento = document.querySelector(seletor);
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

    return dataNascimento.value
}

function formatarCEP(seletor) {
    const cep = document.querySelector(seletor);
    cep.setAttribute('maxlength', '9');
    cep.addEventListener("keypress", function (e) {
        const onlyNumbers = /[0-9]/;
        const key = String.fromCharCode(e.keyCode);

        if (!onlyNumbers.test(key)) {
            e.preventDefault();
            return;
        }
    });

    cep.addEventListener("input", function (e) {
        const inputValue = e.target.value;
        const formattedCEP = formatCEP(inputValue);
        e.target.value = formattedCEP;
    });

    function formatCEP(cepValue) {
        const cleanValue = cepValue.replace(/\D/g, "");
        return cleanValue.replace(/(\d{5})(\d{3})/, "$1-$2");
    }
}

function nomeMaterno(seletor) {
    const nomeMaterno = document.querySelector(seletor);
    let nomeMaternoRegex = /^[A-Za-z\s]+$/;

    nomeMaterno.addEventListener('input', () => {
        if (!nomeMaternoRegex.test(nomeMaterno.value)) {
            nomeMaterno.value = nomeMaterno.value.replace(/[0-9]/g, '');
        }
    });
}

const resposta = document.querySelector('input[name="resposta"]');

resposta.addEventListener('input', () => {
    const slug = document.querySelector('input[name="slug"]');
    if (slug.value == 'qual-a-data-do-seu-nascimento') {
        DataNascimento('input[name="resposta"]');
    } else if (slug.value == 'qual-o-cep-do-seu-endereco') {
        formatarCEP('input[name="resposta"]');
    } else {
        nomeMaterno('input[name="resposta"]');
    }
})


