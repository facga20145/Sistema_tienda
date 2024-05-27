document.addEventListener('DOMContentLoaded', function () {
    var formParte1 = document.getElementById('form-parte1');
    var formParte2 = document.getElementById('form-parte2');
    var siguienteBtn = document.getElementById('siguiente');
    var regresarBtn = document.getElementById('regresar');

    siguienteBtn.addEventListener('click', function () {
        formParte1.style.display = 'none';
        siguienteBtn.style.display = 'none';
        formParte2.style.display = 'flex';
    });

    regresarBtn.addEventListener('click', function () {
        formParte1.style.display = 'flex';
        siguienteBtn.style.display = 'inline';
        formParte2.style.display = 'none';
    });
});