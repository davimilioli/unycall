document.addEventListener('DOMContentLoaded', () => {

    function inicializacao() {
        alternarBtnsPerm();
        console.log('[+] login-form.js iniciado');
    }

    inicializacao();

    function alternarBtnsPerm() {
        const btnType = document.querySelectorAll('.button-type');
        const inputType = document.querySelector('[name=tipoLogin]');

        btnType.forEach((btn) => {
            btn.addEventListener('click', () => {
                console.log(btn.textContent);

                btnType.forEach((otherBtn) => {
                    otherBtn.classList.remove('active');
                });

                if (btn.textContent == 'Administrador') {
                    btn.classList.add('active');
                    inputType.value = 'administrador';
                } else if (btn.textContent == 'Usuario comum') {
                    btn.classList.add('active');
                    inputType.value = 'normal';
                }
            });
        });

        function setState() {
            btnType.forEach((btn) => {
                if (btn.textContent == 'Administrador' && inputType.value == 'administrador') {
                    btn.classList.add('active');
                } else if (btn.textContent == 'Usuario comum' && inputType.value == 'normal') {
                    btn.classList.add('active');
                }
            })
        }

        setState();
    }

});