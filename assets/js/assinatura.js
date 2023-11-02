document.addEventListener("DOMContentLoaded", () => {
    function activeLayout() {

        const buttonSignature = document.querySelector('#buttonSignature');
        const formSignature = document.querySelector('#formSignature');
        const containerButton = document.querySelector('.signature-screen-hidden');

        if (buttonSignature) {
            buttonSignature.addEventListener('click', () => {
                formSignature.classList.add('active');
                containerButton.classList.add('hidden');
            })
        }
    }

    activeLayout();

});