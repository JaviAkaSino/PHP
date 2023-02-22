const DIR_SERV = "http://localhost/PHP/Tema_5/Miguel/Ejercicio1/servicios_rest_ejer1";



$(document).ready(function () {
    obtener_productos();
})

function volver() {
    $("div#respuesta").html("");
}

function obtener_productos() {

    $.ajax({
        url: DIR_SERV + "/productos",
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {
            if (data.mensaje_error) {

                $("div#respuesta").html(data.mensaje_error)

            } else {

                var html_output = "<table><tr><th>COD</th><th>Nombre corto</th><th>PVP</th><th>Acción [+]</th></tr>"
                $.each(data.productos, function (key, tupla) {

                    html_output += "<tr>";
                    html_output += "<td><button onclick = 'info_producto(\"" + tupla["cod"] + "\")' class='enlace'>" + tupla["cod"] + "</button></td>";
                    html_output += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_output += "<td>" + tupla["PVP"] + "</td>";
                    html_output += "<td><button onclick= 'borrar_producto(\"" + tupla["cod"] + "\")'>Borrar</button> - Editar</td>";
                    html_output += "</tr>";
                });

                html_output += "</table>";

                $("div#productos").html(html_output);
            }

        })
        .fail(function () {

            $("div#respuesta").html(error_ajax_jquery(a, b));

        });

}

function info_producto(cod) {
    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/" + cod),
        type: "GET",
        dataType: "json"
    })
        .done(function (data) {

            var output;

            if (data.mensaje_error) {

                output = data.mensaje_error

            } else if (data.producto){ //SÓLO SI NO ESTÁ BORRADO

                //Nombre de la familia 

                $.ajax({
                    url: encodeURI(DIR_SERV + "/familia/" + data.producto["familia"]),
                    type: "GET",
                    dataType: "json"
                })
                    .done(function (data_fam) {

                        if (data_fam.mensaje_error) {

                            output = data_fam.mensaje_error

                        } else {

                            output = "<h2>Información del producto: " + cod + "</h2>"
                            output += "<p><strong>Nombre: </strong>"
                            if (data.producto["nombre"])
                                output += data.producto["nombre"]
                            output += "</p>"
                            output += "<p><strong>Nombre corto: </strong>" + data.producto["nombre_corto"] + "</p>"
                            output += "<p><strong>Descripción: </strong>" + data.producto["descripcion"] + "</p>"
                            output += "<p><strong>PVP: </strong>" + data.producto["PVP"] + "€</p>"
                            output += "<p><strong>Familia: </strong>" + data_fam.familia.nombre + "</p>"

                            output += "<p><button onclick= 'volver()'>Volver</button></p>"

                        }

                        $("div#respuesta").html(output);

                    })
                    .fail(function () {

                        $("div#respuesta").html(error_ajax_jquery(a, b));

                    });

            } else { //ERROR CONSISTENCIA 

                output = "<p class='centrado error'>El producto "+cod+" ya no se encuentra en la base de datos</p>"
                obtener_productos()
            }

            $("div#respuesta").html(output);

        })
        .fail(function () {

            $("div#respuesta").html(error_ajax_jquery(a, b));

        });
}

function borrar_producto(cod) {
    var output = "<p class='centrado'>Se dispone usted a borrar el producto: " + cod + "</p>"
    output += "<p class='centrado'>¿Está seguro?</p>"
    output += "<p class='centrado'><button onclick= 'volver()'>Volver</button><button onclick= 'confirmar_borrar(\"" + cod + "\")'>Confirmar</button></p>"

    $("div#respuesta").html(output);
}

function confirmar_borrar(cod) {


    $.ajax({
        url: encodeURI(DIR_SERV + "/producto/borrar/" + cod),
        type: "DELETE",
        dataType: "json"
    })
        .done(function (data) {

            var output;

            if (data.mensaje_error) {

                output = data.mensaje_error

            } else {


                output= "<p class='centrado mensaje'>El producto "+cod+" ha sido borrado con éxito</p>"
                obtener_productos()

            }

            $("div#productos").html(output);

        })
        .fail(function () {

            $("div#respuesta").html(error_ajax_jquery(a, b));

        });

}

function error_ajax_jquery(jqXHR, textStatus) {
    var respuesta;
    if (jqXHR.status === 0) {

        respuesta = 'Not connect: Verify Network.';

    } else if (jqXHR.status == 404) {

        respuesta = 'Requested page not found [404]';

    } else if (jqXHR.status == 500) {

        respuesta = 'Internal Server Error [500].';

    } else if (textStatus === 'parsererror') {

        respuesta = 'Requested JSON parse failed.';

    } else if (textStatus === 'timeout') {

        respuesta = 'Time out error.';

    } else if (textStatus === 'abort') {

        respuesta = 'Ajax request aborted.';

    } else {

        respuesta = 'Uncaught Error: ' + jqXHR.responseText;

    }
    return respuesta;
}

