$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault();
        event.stopPropagation();

        const form = this;
        const email = $('#email').val();
        const password = $('#password').val();
        const loginAlert = $('#loginAlert');

        loginAlert.hide().text('');

        if (!form.checkValidity()) {
            $(form).addClass('was-validated');
        } else {
            $(form).removeClass('was-validated');

            if (email === 'teste@teste.com' && password === '123456') {
                window.location.href = 'formularios_existentes.php';
            } else {
                loginAlert.text('Email ou senha inválidos. Tente novamente.').show();
            }
        }
    });
});