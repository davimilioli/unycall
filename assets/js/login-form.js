const login = document.querySelector('#login');
const senha = document.querySelector('#senha');
const bntEntrar = document.querySelector('#entrar');
const form = document.querySelector('.form');
console.log(form);

bntEntrar.addEventListener('click', (e) => {
    e.preventDefault()

    form.setAttribute('action', '/login/login_action.php');
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

        btnType.forEach((otherBtn) => {
            otherBtn.classList.add('secondary');
        });

        if (btn.id == 'usuario-normal') {
            inputType.value = 'normal';
        } else {
            inputType.value = 'administrador';
        }

        btn.classList.remove('secondary');
    });
});