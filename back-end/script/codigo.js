/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
window.addEventListener("load", function() {

    var paginaActual = 0;
    cargarPagina(0);
    agregarEventoVerInsertar();

//-----------------------------
    tostada = function(mensaje, tipo) {
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
//-----------------------------
    tostada("Acceso correcto", 1);
    function cargarPagina(pagina) {
        paginaActual = pagina;
        $.ajax({
            url: "ajaxselect.php?pagina=" + pagina, success: function(result) {
                destruirTabla();
                construirTabla(result);
                crearEventos();
            },
            error: function() {
                tostada("error cargar página", '2');
            }
        });
    }
    function agregarEventoVerInsertar() {
        var elemento = document.getElementById("cuadroNuevoPlato");
        elemento.addEventListener("click", function() {
            $("#btsiI").unbind("click");
            $("#btsiI").on("click", function() {
                var nombre = document.getElementById("nombreInsertar").value;
                var descripcion = document.getElementById("descripcionInsertar").value;
                var precio = document.getElementById("precioInsertar").value;
                var datos = {
                    nombre: nombre,
                    descripcion: descripcion,
                    precio: precio
                };
                ajaxInsert(datos);
                $('#myModal').modal('hide');
            });
            $("#btnoI").unbind("click");
            $("#btnoI").on("click", function() {
                $('#myModal').modal('hide');
                tostada("Inserción cancelada", '2');
            });
            $('#myModal').modal('show');
        });
    }
    function ajaxInsert(datos) {
        $.ajax({
            url: "ajaxinsert.php",
            //type: "post",
            data: datos,
            success: function(result) {
                if (result.r === 0) {
                    tostada("No se ha podido insertar", '2');
                } else {
                    tostada("plato insertado", 1);
                    destruirTabla();
                    construirTabla(result);
                    crearEventos();
                    document.getElementById("nombreInsertar").value = "";
                    document.getElementById("descripcionInsertar").value = "";
                    document.getElementById("precioInsertar").value = "";
                }

                subirFotos(result);

            },
            error: function() {
                tostada("No se ha podido insertar. Error ajax", '2');
            }
        });
    }
    function destruirTabla() {
        var divajax = document.getElementById("divajax");
        while (divajax.hasChildNodes()) {
            divajax.removeChild(divajax.firstChild);
        }
    }


    function construirTabla(datos) {
        var tabla = document.createElement("table");
        tabla.setAttribute("id", "admin-table");
        var tr, td, th;

        for (var i = 0; i < datos.platos.length; i++) {
            if (i === 0) {
                tr = document.createElement("tr");
                for (var j = 0 in datos.platos[i]) {
                    th = document.createElement("th");
                    th.textContent = j.toUpperCase();
                    tr.appendChild(th);
                }
                th = document.createElement("th");
                th.setAttribute("colspan", "2");
                th.textContent = "ACCIÓN";
                tr.appendChild(th);
            }
            tabla.appendChild(tr);
            tr = document.createElement("tr");
            for (var j = 0 in datos.platos[i]) {
                td = document.createElement("td");
                td.textContent = datos.platos[i][j];
                tr.appendChild(td);
            }
            td = document.createElement("td");
            td.innerHTML = "<a class='enlace-editar' data-editar='" + datos.platos[i].idplato + "'>Editar</a>";
            tr.appendChild(td);
            td = document.createElement("td");
            td.innerHTML = "<a class='enlace-borrar' data-borrar='" + datos.platos[i].idplato + "'>Borrar</a>";
            tr.appendChild(td);
            tabla.appendChild(tr);
        }
        /* paginacion */
        tr = document.createElement("tr");
        td = document.createElement("th");
        td.setAttribute("colspan", "10");
        /*td.textContent = "" + datos.paginas.inicio + " " + datos.paginas.anterior + " " +
         datos.paginas.primero + " " + datos.paginas.segundo + " " + datos.paginas.actual
         + " " + datos.paginas.cuarto + " " + datos.paginas.quinto + " " + datos.paginas.siguiente
         + " " + datos.paginas.ultimo;*/


        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.inicio + "'>&lt&lt;</a>";
        td.innerHTML += "&nbsp;";
        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.anterior + "'>&lt;</a>";
        td.innerHTML += "&nbsp;";
        if (datos.paginas.primero !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.primero + "'>" +
                    (parseInt(datos.paginas.primero) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.segundo !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.segundo + "'>" +
                    (parseInt(datos.paginas.segundo) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.actual !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.actual + "'>" +
                    (parseInt(datos.paginas.actual) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.cuarto !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.cuarto + "'>" +
                    (parseInt(datos.paginas.cuarto) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.quinto !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.quinto + "'>" +
                    (parseInt(datos.paginas.quinto) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.siguiente + "'>&gt;</a>";
        td.innerHTML += "&nbsp;";
        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.ultimo + "'>&gt;&gt;</a>";
        tr.appendChild(td);
        tabla.appendChild(tr);
        var divajax = document.getElementById("divajax");
        divajax.appendChild(tabla);
    }

    function destruirTablaImages() {
        var divajax = document.getElementById("edit-fotos");
        while (divajax.hasChildNodes()) {
            divajax.removeChild(divajax.firstChild);
        }
    }

    function construirTablaImages(result) {
        var div = document.createElement("div");
        div.setAttribute("id", "admin-fotos");
        var img;
        var a;

        for (var i = 0; i < result.fotos.length; i++) {

            img = document.createElement("img");
            img.setAttribute("src", result.fotos[i].url);
            img.setAttribute("width", "10%");

            a = document.createElement("a");
            a.innerHTML = "<a class='enlace-borrar' data-borrar='" + result.fotos[i].idfoto + "'>Eliminar</a>";
            div.appendChild(img);
            div.appendChild(a);

        }
        var divajax = document.getElementById("edit-fotos");
        divajax.appendChild(div);
    }



//function mostrarFotos(idPlato)
//    {
//        $.ajax({
//            url: "ajaxGetFotos.php?idPlato=" + idPlato,
//            success: function (result) {
//                destruirImagenes();
//                if (result.length !== 0) {
//                    var imagenes = document.getElementById("imagenes");
//                    for (var i = 0; i < result.fotos.length; i++)
//                    {
//                        var imagen = document.createElement("img");
//                        imagen.setAttribute("src", result.fotos[i].url);
//                        imagen.setAttribute("id", result.fotos[i].idPlato);
//                        imagen.setAttribute("width", "20%");
//                        imagen.setAttribute("class", "borrarImagen");
//                        imagenes.appendChild(imagen);
//                        imagen.onclick = function () {
//                            alert("hola");
//                        };
//                    }
//                }
//            },
//            error: function (result) {
//                tostada("No existen fotos. Error ajax", '2');
//            }
//        });
//    }




    function crearEventos() {
        var enlaces = document.getElementsByClassName("enlace");
        for (var i = 0; i < enlaces.length; i++) {
            agregarEvento(enlaces[i]);
        }


        var enlacesEditar = document.getElementsByClassName("enlace-editar");
        for (var i = 0; i < enlacesEditar.length; i++) {
            agregarEventoEditar(enlacesEditar[i]);
        }

        var enlacesBorrar = document.getElementsByClassName("enlace-borrar");
        for (var i = 0; i < enlacesBorrar.length; i++) {
            agregarEventoBorrar(enlacesBorrar[i]);
        }
    }

    function crearEventosBorrarFotos() {
        var enlacesBorrar = document.getElementsByClassName("enlace-borrar");
        for (var i = 0; i < enlacesBorrar.length; i++) {
            agregarEventoBorrarFotos(enlacesBorrar[i]);
        }
    }

    function agregarEventoBorrarFotos(elemento) {
        var mensaje = elemento.getAttribute("data-borrar");
        elemento.addEventListener("click", function() {
            $('#myModal').modal('hide');
            confirmarBorrarFoto(mensaje);
        });
    }

    function confirmarBorrarFoto(mensaje) {
        var cm = document.getElementById("contenidomodal");
        cm.innerHTML = "¿Borrar el plato número " + mensaje + "?";
        $("#btsi").unbind("click");
        $("#btsi").on("click", function() {
            $("#dialogomodal").modal('hide');
            borrarFoto(mensaje);
        });
        $("#btno").unbind("click");
        $("#btno").on("click", function(e) {
            $("#dialogomodal").modal('hide');
            tostada("Borrado cancelado", '2');
        });
        $('#dialogomodal').modal('show');
    }
    
        function borrarFoto (id) {
        $.ajax({
            url: "ajaxdeletefoto.php?idfoto=" + id,
            success: function(result) {
                console.log(result);
                if (result.r === 0) {
                    tostada("No se ha podido borrar", '2');
                } else {
                    tostada("plato " + id + " borrado", 1);
                    exit();
//                    destruirTabla();
//                    construirTabla(result);
//                    crearEventos();
                }
            },
            error: function() {
                tostada("No se ha podido borrar", '2');
            }
        });
    }

    function agregarEvento(elemento) {
        var datahref = elemento.getAttribute("data-href");
        elemento.addEventListener("click", function(e) {
            cargarPagina(datahref);
        });
    }
    function agregarEventoEditar(elemento) {
        var dataEditar = elemento.getAttribute("data-editar");
        elemento.addEventListener("click", function(e) {
            editar(dataEditar);
        });
    }
    function agregarEventoBorrar(elemento) {
        var mensaje = elemento.getAttribute("data-borrar");
        elemento.addEventListener("click", function() {
            confirmarBorrar(mensaje);
        });
    }

    function editar(dataEditar) {
        $.ajax({
            url: "ajaxget.php?idplato=" + dataEditar,
            success: function(result) {
                console.log(result.r);
                if (result.r === 0) {
                    tostada("No existe el plato", '2');
                } else {
                    //tostada("Existe el usuario", 2);
                    var nombre = document.getElementById("nombreInsertar");
                    var descripcion = document.getElementById("descripcionInsertar");
                    var precio = document.getElementById("precioInsertar");
                    platoEdit = result.plato;
                    var idpk = platoEdit.idplato;
//                    idplato.value = platoEdit.idplato;
                    nombre.value = platoEdit.nombre;
                    descripcion.value = platoEdit.descripcion;
                    precio.value = platoEdit.precio;
                    mostrarEditar(idpk, dataEditar);
                }
            },
            error: function() {
                tostada("No existe el plato.Error ajax", '2');
            }

        });
    }

    function mostrarEditar(idpk, dataEditar) {
        $("#btsiI").unbind("click");
        $("#btsiI").on("click", function() {
//            var idplato = document.getElementById("login").value;
            var nombre = document.getElementById("nombreInsertar").value;
            var descripcion = document.getElementById("descripcionInsertar").value;
            var precio = document.getElementById("precioInsertar").value;
            var datos = {
                pagina: paginaActual,
                idpk: idpk,
                nombre: nombre,
                descripcion: descripcion,
                precio: precio
            };
            update(datos, dataEditar);
            $('#myModal').modal('hide');
        });
        $("#btnoI").unbind("click");
        $("#btnoI").on("click", function() {
            $('#myModal').modal('hide');
            tostada("Edición cancelada", '2');
        });
        $('#myModal').modal('show');
        mostrarFotos(idpk);
    }

    function update(datos, dataEditar) {
        $.ajax({
            url: "ajaxupdate.php",
            type: "post",
            data: datos,
            success: function(result) {
                if (result.r === 0) {
                    tostada("No se ha podido actualizar", '2');
                } else {
                    tostada("plato actualizado", '1');
                    destruirTabla();
                    construirTabla(result);
                    crearEventos();
                }
                subirFotosEdit(result, dataEditar);
            },
            error: function() {
                tostada("No se ha podido actualizar. Error ajax", '2');
            }
        });
    }



    function confirmarBorrar(mensaje) {
        var cm = document.getElementById("contenidomodal");
        cm.innerHTML = "¿Borrar el plato número " + mensaje + "?";
        $("#btsi").unbind("click");
        $("#btsi").on("click", function() {
            $("#dialogomodal").modal('hide');
            borrar(mensaje, paginaActual);
        });
        $("#btno").unbind("click");
        $("#btno").on("click", function(e) {
            $("#dialogomodal").modal('hide');
            tostada("Borrado cancelado", '2');
        });
        $('#dialogomodal').modal('show');
    }

    function borrar(id, posicion) {
        $.ajax({
            url: "ajaxdelete.php?idplato=" + id + "&pagina=" + posicion,
            success: function(result) {
                console.log(result);
                if (result.r === 0) {
                    tostada("No se ha podido borrarrrrr", '2');
                } else {
                    tostada("plato " + id + " borrado", 1);
                    destruirTabla();
                    construirTabla(result);
                    crearEventos();
                }
            },
            error: function() {
                tostada("No se ha podido borrar", '2');
            }
        });
    }

    function subirFotosEdit(result, dataEditar) {

        var archivo = document.getElementById("archivo");
        var ajax, archivoactual, archivos, parametros, i, longitud;
        archivos = archivo.files;
        longitud = archivo.files.length;
        parametros = new FormData();
        parametros.append("numerodearchivos", longitud);
        for (i = 0; i < longitud; i++) {
            archivoactual = archivos[i];
            parametros.append('archivo[]', archivoactual, archivoactual.name);
        }
        ajax = new XMLHttpRequest();
        if (ajax.upload) {
            var plato = result.platos[result.platos.length - 1];
            ajax.open("POST", "ajaxinsertimg.php?id=" + dataEditar, true);
//                    ajax.open("POST", "ajaxinsertimg.php?id="+result.platos(result.platos.length-1), true);
            ajax.onreadystatechange = function(texto) {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        tostada("Imagenes subidas", 1);
                    } else {
                        tostada("Error al subir las imagenes", '2');
                    }
                }
            };
            ajax.send(parametros);
        }
    }
    
    function subirFotos(result) {

        var archivo = document.getElementById("archivo");
        var ajax, archivoactual, archivos, parametros, i, longitud;
        archivos = archivo.files;
        longitud = archivo.files.length;
        parametros = new FormData();
        parametros.append("numerodearchivos", longitud);
        for (i = 0; i < longitud; i++) {
            archivoactual = archivos[i];
            parametros.append('archivo[]', archivoactual, archivoactual.name);
        }
        ajax = new XMLHttpRequest();
        if (ajax.upload) {
            var plato = result.platos[result.platos.length - 1];
            ajax.open("POST", "ajaxinsertimg.php?id=" + plato.idplato, true);
//                    ajax.open("POST", "ajaxinsertimg.php?id="+result.platos(result.platos.length-1), true);
            ajax.onreadystatechange = function(texto) {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        tostada("Imagenes subidas", 1);
                    } else {
                        tostada("Error al subir las imagenes", '2');
                    }
                }
            };
            ajax.send(parametros);
        }
    }

    function mostrarFotos(id) {

        $.ajax({
            url: "ajaxbuscaimg.php?id=" + id,
            success: function(result) {
                console.log(result);
                if (result.r === 0) {
                    tostada("El plato no contiene fotos", '2');
                } else {
//                    tostada("plato " + id + " borrado", 1);
                    destruirTablaImages();
                    construirTablaImages(result);
                    crearEventosBorrarFotos();
                }
            },
            error: function() {
                tostada("No se ha podido borrar", '2');
            }
        });
    }
});