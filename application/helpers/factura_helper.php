<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('procesar_xml')) {
    function procesar_xml($xml, $user) {
        $comprobante = $xml->getElementsByTagName('Comprobante')->item(0);
        $timbreFiscalDigital = $xml->getElementsByTagName('TimbreFiscalDigital')->item(0);
        $emisor = $xml->getElementsByTagName('Emisor')->item(0);
        $receptor = $xml->getElementsByTagName('Receptor')->item(0);
        $conceptos = $xml->getElementsByTagName('Concepto');
        $impuestosConcepto = $conceptos[0]->getElementsByTagName('Impuestos')->item(0);
        $traslados = $impuestosConcepto->getElementsByTagName('Traslados')->item(0);
        $traslado = $traslados->getElementsByTagName('Traslado')->item(0);

        $factura = array(
			"id_user " => $user,
			"id_company " => $user,
			"sender_rfc" =>  $emisor->getAttribute('Rfc'),
			"receiver_rfc" => $receptor->getAttribute('Rfc'),
			"invoice_number" => $comprobante->getAttribute('TipoDeComprobante'),
			"uuid" => $timbreFiscalDigital->getAttribute('UUID'),
			"invoice_date" => $comprobante->getAttribute('Fecha'),
			//"created_date" => date('Y-m-d H:i:s'),
			"transaction_date" => "0000-00-00",
			"status" => "0",
			"subtotal" => $comprobante->getAttribute('SubTotal'),
			"iva" => $traslado->getAttribute('Importe'),
			"total" => $comprobante->getAttribute('Total'),
            "xml_document" => $xml->saveXML(),
		);

        return $factura;
    }
}