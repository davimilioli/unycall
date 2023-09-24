const login = document.querySelector('#login');
const senha = document.querySelector('#senha');
const bntEntrar = document.querySelector('#entrar');
const form = document.querySelector('.form');
console.log(form);

bntEntrar.addEventListener('click', (e) => {
    e.preventDefault()

    form.setAttribute('action', '/pages/login/login_action.php');
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



