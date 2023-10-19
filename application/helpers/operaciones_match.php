<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('factura_con_factura')) {
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
			"id_company " => $user,
			"id_user " => $user,
			"sender_rfc" =>  $emisor->getAttribute('Rfc'),
			"receiver_rfc" => $receptor->getAttribute('Rfc'),
			"invoice_number" => $comprobante->getAttribute('TipoDeComprobante'),
			"uuid" => $timbreFiscalDigital->getAttribute('UUID'),
			"invoice_date" => $comprobante->getAttribute('Fecha'),
			"transaction_date" => "0000-00-00",
			"status" => "0",
			"subtotal" => $comprobante->getAttribute('SubTotal'),
			"iva" => $traslado->getAttribute('Importe'),
			"total" => $comprobante->getAttribute('Total'),
            "xml_document" => $xml->saveXML(),
			"created_at" => "0000-00-00",
			"updated_at" => "0000-00-00",
		);

        return $factura;
    }
}

if (!function_exists('factura_con_nota_debito')) {
    function procesar_xml_relacional($xml, $user) {
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
			"created_date" => date('Y-m-d H:i:s'),
			"transaction_date" => "0000-00-00",
			"status" => "0",
			"subtotal" => $comprobante->getAttribute('SubTotal'),
			"iva" => $traslado->getAttribute('Importe'),
			"total" => $comprobante->getAttribute('Total'),
            "xml_document" => $xml->saveXML(),
		);

        if (!function_exists('factura_con_nota_debito')) {
            function factura_con_nota_debito($xml, $user) {
                $factura = procesar_xml_relacional($xml, $user);
                return $factura;
            }
        }

        return $factura;
    }
}