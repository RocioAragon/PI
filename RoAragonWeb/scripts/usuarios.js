//Rocío Aragón Escamilla
//2 DAW
document.addEventListener('DOMContentLoaded', () => {
    var btnInicioSesion = document.getElementById("inicioSesion");
    var user = document.getElementById("user");
    var pass = document.getElementById("pass");
    var formInicioSesion = document.getElementById("formInicioSesion");
    var sesion = document.getElementById("sesion");
    var botonCerrarSesion = document.getElementById("botonCerrarSesion");

    if (sessionStorage.usuario != null) {
        formInicioSesion.style.visibility = "hidden";
        sesion.innerHTML = " Bienvenido, " + sessionStorage.usuario;
        botonCerrarSesion.style.visibility = "visible";
    } else {
        botonCerrarSesion.style.visibility = "hidden";
    }

    btnInicioSesion.addEventListener("click", iniciarSesion);


    function iniciarSesion() {
        if (user.value != "" && pass.value != "") {
            botonCerrarSesion.style.visibility = "visible";
            sessionStorage.usuario = user.value;
            sessionStorage.contrasenia = pass.value;
            formInicioSesion.style.visibility = "hidden";
            sesion.innerHTML = " Bienvenido, " + user.value;
        }
    }

    botonCerrarSesion.addEventListener("click", cerrarSesion);

    function cerrarSesion() {
        sessionStorage.removeItem("usuario");
        formInicioSesion.style.visibility = "visible";
        botonCerrarSesion.style.visibility = "hidden";
        sesion.style.visibility = "hidden";
    }
});