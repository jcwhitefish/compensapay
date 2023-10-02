<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('procesar_xml')) {
    function procesar_xml($xml) {
        $comprobante = $xml->getElementsByTagName('Comprobante')->item(0);
        $timbreFiscalDigital = $xml->getElementsByTagName('TimbreFiscalDigital')->item(0);
        $emisor = $xml->getElementsByTagName('Emisor')->item(0);
        $conceptos = $xml->getElementsByTagName('Concepto');
        $impuestosConcepto = $conceptos[0]->getElementsByTagName('Impuestos')->item(0);
        $traslados = $impuestosConcepto->getElementsByTagName('Traslados')->item(0);
        $traslado = $traslados->getElementsByTagName('Traslado')->item(0);

        $factura = new Factura(
            $emisor->getAttribute('Rfc'),
            null,
            $comprobante->getAttribute('Fecha'),
            $comprobante->getAttribute('Total'),
            $xml->saveXML(),
            $timbreFiscalDigital->getAttribute('UUID'),
            $comprobante->getAttribute('TipoDeComprobante'),
            $comprobante->getAttribute('SubTotal'),
            $traslado->getAttribute('Importe'),
            date('Y-m-d H:i:s'),
            "1"
        );

        return $factura;
    }
}