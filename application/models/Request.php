<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request{
    public static function getStaticMethod() {
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
        $method = preg_replace('/[^A-Z]/', '', $method);
        $method = in_array($method, ['POST','GET']) ? $method : false;

        return $method;
    }
    public static function getContentType() {
        $type = filter_input(INPUT_SERVER, 'CONTENT_TYPE', FILTER_SANITIZE_STRING);
        $type = preg_replace('/[^a-z\/\-;=8]/', '', strtolower(trim($type)));
        $allowed = ['application/json;charset=utf-8', 'application/json', 'multipart/form-data'];
        $type = in_array($type, $allowed) ? $type : false;

        return $type;
    }
    public static function getProtocol() {
        $protocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_URL);
        $protocol = preg_replace('/[^HTP\/\.10]/', '', trim($protocol));

        return $protocol;
    }
    public static function getBody() {
        $input = file_get_contents("php://input");
        $input = preg_replace('/[^\x{0021}-\x{005F}\x{0061}-\x{00FC} ]/u', '', $input);
        return json_decode($input, true);
    }
}
