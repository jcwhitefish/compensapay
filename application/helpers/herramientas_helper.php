<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function registro($miVariable) {
    $archivo = 'registro.txt';

    // Obtener la fecha y hora actual
    $fechaHora = date('Y-m-d H:i:s');

    // El contenido a añadir al archivo
    $contenido = $fechaHora . ' - ' . $miVariable . PHP_EOL;

    // Añadir el contenido al archivo
    file_put_contents($archivo, $contenido, FILE_APPEND);

    // Puedes agregar algún código adicional aquí si lo necesitas

    return true; // Indica que la operación fue exitosa
}