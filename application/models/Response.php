<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Request.php';
include 'Error.php';
const OK_CODES = [
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
];

class Response extends CI_Model
{
    public function __construct() {
        $method = Request::getStaticMethod();
        $denied = null;
        $type = Request::getContentType();
        $protocol = Request::getProtocol();
        $body = Request::getBody();
        $res = null;
        if (!$method) {
            header('HTTP/1.0 405 Method Not Allowed');
            $res = json_encode([
                'error' => 405,
                'error_description' => 'Método no autorizado',
                'reason' => ''
            ]);
        }
        elseif ($method === 'OPTIONS') {
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, Origin, X-Requested-With');
            header('Content-Type: text/plain');
            die('');
        }
        #TODO: VALIDAR CUANDO EL RESQUEST VIENE COMO multipart/form-data PORQUE
        #ESTO NO LO CONTEMPLA Y DEVUELVE ERROR
        elseif (!$type || $body == null || !is_array($body)) {
            header('HTTP/1.0 400 Bad Request');
            $res = json_encode([
                'error' => 400,
                'error_description' => 'Petición incorrecta',
                'reason' => 'Se esperaba contenido en formato JSON',
            ]);
        }

        if ($res != null) {
            header('Content-type: application/json; charset=utf-8');
            die($res);
        }
    }

    public function sendResponse(array $resp = null, $error = 0) {
        $return = null;
        if ($resp == null && $error == 0) {
            header('HTTP/1.0 501 Not Implemented');
            $return = json_encode([
                'error' => 501,
                'error_description' => 'Método no implementado',
                'reason' => ''
            ]);
//            return;
        }
        elseif ($resp == null && is_numeric($error)) {
            if (array_key_exists($error, ERROR_CODES)) {
                $errdesc = ERROR_CODES[$error];
                header("HTTP/1.0 {$error} {$errdesc}");
            } else {
                header('HTTP/1.0 500 Internal Server Error');
                $errdesc = "Error: {$error}";
                $error = 500;
            }
            $return = json_encode([
                'error' => $error,
                'error_description' => 'Ocurrió un error al procesar la petición',
                'reason' => $errdesc,
            ]);
        }
        elseif ($resp == null && $error != 0 && is_string($error)) {
            header('HTTP/1.0 500 Internal Server Error');
            $return = json_encode([
                'error' => 500,
                'error_description' => 'Error de comunicación',
                'reason' => $error
            ]);
        }
        elseif ($resp != null) {
            if ($error == 0) {
                $code = isset($resp['api_code']) ? $resp['api_code'] : null;
                $link = isset($resp['api_link']) ? $resp['api_link'] : null;
                if ($code != null && array_key_exists($code, OK_CODES)) {
                    $codedesc = OK_CODES[$code];
                    header("HTTP/1.0 {$code} {$codedesc}");
                    if ($code == 202 && $link != null) {
                        header("Content-Location: {$link}");
                        $resp['link'] = $resp['api_link'];
                        unset($resp['api_link']);
                    }
                    unset($resp['api_code']);
                }
            } else {
                $errdesc = ERROR_CODES[$error];
                header("HTTP/1.0 {$error} {$errdesc}");
            }

            $return = json_encode($resp);
        }
        else {
            header('HTTP/1.0 500 Internal Server Error');
            $return = json_encode([
                'error' => 500,
                'error_description' => 'Error interno del servidor',
                'reason' => 'Favor de notificar al administrador'
            ]);
        }
        header('Content-type: application/json; charset=utf-8');
        echo $return;
    }
}
