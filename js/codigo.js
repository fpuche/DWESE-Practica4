/*global $: false*/
/*global document: false*/
/*global mensaje: false*/
/*global tipo: false*/
/*global toastr: false*/
/*global window: false*/
var main = function () {
    'use strict';
    var agregarEvento, definirBorrar, confirmar, tostada;
    confirmar = function (evento, mensaje, destino) {
        evento.preventDefault();
        var cm = document.getElementById("contenidomodal");
        cm.innerHTML = "¿Borrar " + mensaje + "?";
        $("#btsi").on("click", function () {
            $("#dialogomodal").modal('hide');
            window.location = destino;
        });
        $("#btno").on("click", function (e) {
            $("#dialogomodal").modal('hide');
        });
        $('#dialogomodal').modal('show');
    };
    agregarEvento = function (elemento) {
        var mensaje = elemento.getAttribute("data-nombre");
        elemento.addEventListener("click", function (e) { confirmar(e, mensaje, this.href); }, false);
    };
    definirBorrar = function (clase) {
        var elementos, i;
        elementos = document.getElementsByClassName(clase);
        for (i = 0; i < elementos.length; i = i + 1) {
            agregarEvento(elementos[i]);
        }
    };
    tostada = function (mensaje, tipo) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        if (mensaje !== '') {
            if (tipo === '2') {
                toastr.warning(mensaje);
            } else {
                toastr.success(mensaje);
            }
        }
    };
    definirBorrar("borrar");
    try {
        tostada(mensaje, tipo);
    } catch (ignore) {}
};
document.addEventListener("DOMContentLoaded", main, false);