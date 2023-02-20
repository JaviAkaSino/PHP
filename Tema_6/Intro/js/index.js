const DIR_SERV = "http://localhost/PHP/Tema_5/Intro/servicios_rest_teor";



$(document).ready(function () {
    obtener_productos();
})

function obtener_productos() {

    $.ajax({
        url: "http://localhost/PHP/Tema_5/Tienda/Ejercicio1/servicios_rest/productos",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {

                $("div#respuesta").html(data.mensaje_error)

            } else {

                var html_output = "<table><tr><th>COD</th><th>Nombre corto</th><th>PVP</th></tr>"
                $.each(data.productos, function(key, tupla){

                    html_output += "<tr>";
                    html_output += "<td>"+tupla["cod"]+"</td>";
                    html_output += "<td>"+tupla["nombre_corto"]+"</td>";
                    html_output += "<td>"+tupla["PVP"]+"</td>";
                    html_output += "</tr>";
                });

                html_output += "</table>";

                $("div#productos").html(html_output);
            }

        })
        .fail(function () {



        });

}


function llamada_get() {

    $.ajax({
        url: DIR_SERV + "/saludo",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {

            $("div#respuesta").html(data.mensaje)
        })
        .fail(function () {


        });

}

function llamada_post() {

    $.ajax({
        url: DIR_SERV + "/saludo",
        type: "POST",
        dataType: "json",
        data: { datos1: "Pedro", datos2: "María José" }
    })
        .done(function (data) {

            $("div#respuesta").html(data.mensaje)
        })
        .fail(function () {


        });

}

function llamada_delete() {

    $.ajax({
        url: encodeURI(DIR_SERV + "/borrar_saludo/5"),
        type: "DELETE",
        dataType: "json"
    })
        .done(function (data) {

            $("div#respuesta").html(data.mensaje)
        })
        .fail(function () {


        });

}

function llamada_put_1() {

    $.ajax({
        url: encodeURI(DIR_SERV + "/modificar_saludo/5/Juan Antonio"),
        type: "PUT",
        dataType: "json"
    })
        .done(function (data) {

            $("div#respuesta").html(data.mensaje)
        })
        .fail(function () {


        });

}

function llamada_put_2() {

    $.ajax({
        url: encodeURI(DIR_SERV + "/modificar_saludo/5"),
        type: "PUT",
        dataType: "json",
        data: { saludo_nuevo: "José Manuel" }
    })
        .done(function (data) {

            $("div#respuesta").html(data.mensaje)
        })
        .fail(function () {


        });

}

