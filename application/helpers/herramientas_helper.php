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
function cifrarAES($mensaje)
{
    $clave = 'R$#9pL@z&*Q!7k#J2';
    $iv = hex2bin('845e409135219b45a30ca1c60a7e0c77');
    $cifrado = openssl_encrypt($mensaje, 'AES-256-CBC', $clave, 0, $iv);
    return base64_encode($cifrado); 
}

function descifrarAES($mensajeCifrado)
{
    $clave = 'R$#9pL@z&*Q!7k#J2';
    $iv = hex2bin('845e409135219b45a30ca1c60a7e0c77');
    $datosDecodificados = base64_decode($mensajeCifrado);
    $mensajeDescifrado = openssl_decrypt($datosDecodificados, 'AES-256-CBC', $clave, 0, $iv);
    return $mensajeDescifrado;
}