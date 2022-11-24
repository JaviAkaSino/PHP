<?php

function pag_error($titulo, $cabecera, $mensaje)
{
    return "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>" . $titulo . "</title>
        </head>
        <body>
            <h1>" . $cabecera . "</h1>
            <p>" . $mensaje . "</p>
        </body>
        </html>";
}
