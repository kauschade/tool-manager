var PopupsConsulta = document.getElementById('popup-fundo-consulta');
var BtnPopupConsulta = document.getElementById('btn-consultar');
var PopupConsulta = document.getElementById('popup-consulta');

BtnPopupConsulta.addEventListener('click', function () {
    if (PopupConsulta.classList.contains('escondido')) {
        PopupsConsulta.classList.remove('escondido');
        PopupConsulta.classList.remove('escondido');
    } else {
        PopupsConsulta.classList.add('escondido');
        PopupConsulta.classList.add('escondido');
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        PopupsConsulta.classList.add('escondido');
        PopupConsulta.classList.add('escondido');
    }
});