document.addEventListener("DOMContentLoaded", () => {
  function inicializacao() {
    openModalPessoal();
    validarCep();
    abrirModalLogin();
    avisoGood();
    excluirUsuario();
    console.log("informacoes-conta.js iniciado");
  }

  inicializacao();

  function openModalPessoal() {
    const modalPessoal = document.querySelector(".view-modal-personal");
    const botaoAbrirPessoal = document.querySelector("#openModalPessoal");
    const botaoFecharPessoal = document.querySelector("#closeModalPessoal");

    botaoAbrirPessoal.addEventListener("click", () => {
      modalPessoal.classList.add("active");
    });

    botaoFecharPessoal.addEventListener("click", () => {
      modalPessoal.classList.remove("active");
    });
  }

  function validarCep() {
    let validaCep = false;

    const cep = document.querySelector("#cep");
    const address = document.querySelector("#endereco");
    const city = document.querySelector("#cidade");
    const state = document.querySelector("#estado");
    const neighborhood = document.querySelector("#bairro");
    const inputsAddress = document.querySelectorAll("[data-input-address]");
    const numEndereco = document.querySelector("#numend");
    const complemento = document.querySelector("#complemento");
    function formatCEP(cepValue) {
      const cleanValue = cepValue.replace(/\D/g, "");
      return cleanValue.replace(/(\d{5})(\d{3})/, "$1-$2");
    }

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

    cep.addEventListener("keyup", function (e) {
      const inputValue = e.target.value;

      if (inputValue.length === 9) {
        const cepValue = inputValue.replace(/\D/g, "");
        getAddress(cepValue);
        if (getAddress(cepValue)) {
          inputsAddress.forEach((item) => {
            if (
              item.getAttribute("id") == "numend" ||
              item.getAttribute("id") == "complemento"
            ) {
              item.style.borderColor = "none";
            } else {
              item.style.borderColor = "green";
            }
          });
        }
      }
    });

    numEndereco.addEventListener("keyup", function () {
      if (numEndereco.value.length > 0) {
        setarBorda("#numend", true);
      } else {
        setarBorda("#numend", false);
      }
    });

    complemento.addEventListener("keyup", function () {
      if (numEndereco.value.length > 0) {
        setarBorda("#complemento", true);
      }
    });

    async function getAddress(cep) {
      const url = `https://viacep.com.br/ws/${cep}/json/`;

      const response = await fetch(url);

      const data = await response.json();

      if (data.erro) {
        validaCep = false;

        inputsAddress.forEach(function (input) {
          input.value = "";
        });

        return;
      } else {
        validaCep = true;
      }

      address.value = data.logradouro !== undefined ? data.logradouro : "";
      city.value = data.localidade !== undefined ? data.localidade : "";
      state.value = data.uf !== undefined ? data.uf : "";
      neighborhood.value = data.bairro !== undefined ? data.bairro : "";
    }

    const clearInputs = document.querySelector("#limpar");
    const formGroupContainer = document.querySelectorAll(
      ".formGroup-container"
    );

    if (clearInputs) {
      clearInputs.addEventListener("click", function () {
        formGroupContainer.forEach(function (container) {
          container
            .querySelectorAll("[data-input-address]")
            .forEach(function (input) {
              input.value = "";
            });
        });

        numEndereco.value = "";
        complemento.value = "";
      });
    }
  }

  function abrirModalLogin() {
    const modalLogin = document.querySelector(".view-modal-login");
    const botaoAbrirLogin = document.querySelector("#abrirModalLogin");
    const botaoFecharLogin = document.querySelector("#closeModalLogin");

    botaoAbrirLogin.addEventListener("click", () => {
      modalLogin.classList.add("active");
    });

    botaoFecharLogin.addEventListener("click", () => {
      modalLogin.classList.remove("active");
    });
  }

  function avisoGood() {
    const mensagem = document.querySelector(".message.good");
    if (mensagem) {
      setTimeout(() => {
        mensagem.classList.remove("active");
      }, 4000);
    }
  }

  function excluirUsuario() {
    const btnExcluir = document.querySelectorAll("[data-id]");
    const modalExclude = document.querySelector(".modal-exclude");

    btnExcluir.forEach((btn) => {
      const btnAttrId = btn.getAttribute("data-id");

      btn.addEventListener("click", () => {
        modalExclude.classList.add("active");
        modalExclude.setAttribute("id", btnAttrId);

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

        const closeModal = document.querySelectorAll(".closeModal");
        closeModal.forEach((item) => {
          item.addEventListener("click", () => {
            modalExclude.classList.remove("active");
          });
        });
      });
    });
  }
});
