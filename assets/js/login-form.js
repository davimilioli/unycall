document.addEventListener('DOMContentLoaded', () => {
    const login = document.querySelector('#login');
    const senha = document.querySelector('#senha');
    const bntEntrar = document.querySelector('#entrar');
    const form = document.querySelector('.form');

    bntEntrar.addEventListener('click', (e) => {
        e.preventDefault()

        loading('validando usuario')

        setTimeout(() => {
            form.submit();
            loading('validando usuario')
        }, 2000)
    })

    function loading(msg) {
        const loading = document.querySelector('.loading');
        const message = document.querySelector('.loading-message')
        loading.classList.toggle('hide');
        message.innerHTML = msg;
    }

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
});