var urlPrincipal = $("#urlPrincipal").val();
var urlServidor = $("#urlServidor").val();

function convertirAUrlAmigable(cadena) {
    // Convertir a minúsculas
    cadena = cadena.toLowerCase();

    // Reemplazar caracteres acentuados por sus equivalentes sin tilde
    const mapaCaracteres = {
        'á': 'a', 'é': 'e', 'í': 'i', 'ó': 'o', 'ú': 'u',
        'Á': 'a', 'É': 'e', 'Í': 'i', 'Ó': 'o', 'Ú': 'u',
        'ñ': 'n', 'Ñ': 'n'
    };

    cadena = cadena.split('').map(caracter => mapaCaracteres[caracter] || caracter).join('');

    // Reemplazar espacios por guiones
    cadena = cadena.replace(/\s+/g, '-');

    return cadena;
}

//===========================================
//OVERLAY LOGIN
//===========================================
// document.querySelector('.iniciar-sesion').addEventListener('click', function () {
// });

// document.addEventListener('click', function (event) {

// });

$(".iniciar-sesion").click(function (e) {

    document.getElementById('overlayLogin').style.display = 'flex';

    document.getElementById('overlayLogin').addEventListener('click', function (event) {
        if (event.target === this) {
            document.getElementById('overlayLogin').style.display = 'none';
        }
    });

})

//===========================================
//LOGIN VISUALIZAR CONTRA
//===========================================
document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.querySelector('.toggle-password');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Alternar entre texto y contraseña
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Alternar entre icono de ojito abierto y cerrado
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
});







