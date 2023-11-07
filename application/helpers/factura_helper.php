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
			"id_company " => $user,
			"id_user " => $user,
			"sender_rfc" =>  $emisor->getAttribute('Rfc'),
			"receiver_rfc" => $receptor->getAttribute('Rfc'),
			"invoice_number" => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
			"uuid" => $timbreFiscalDigital->getAttribute('UUID'),
			"invoice_date" => $comprobante->getAttribute('Fecha'),
			"transaction_date" => date('Y-m-d',strtotime(date('Y-m-d')."+ 45 days")),
			"status" => "0",
			"subtotal" => $comprobante->getAttribute('SubTotal'),
			"iva" => $traslado->getAttribute('Importe'),
			"total" => $comprobante->getAttribute('Total'),
            "xml_document" => $xml->saveXML(),
			"created_at" => date('Y-m-d'),
			"updated_at" => "0000-00-00",
		);

        return $factura;
    }
}

if (!function_exists('procesar_factura_relacional')) {
    function procesar_factura_relacional($xml) {
        $comprobante = $xml->getElementsByTagName('Comprobante')->item(0);
		$emisor = $xml->getElementsByTagName('Emisor')->item(0);
		$receptor = $xml->getElementsByTagName('Receptor')->item(0);
		$impuestosGlobales = $xml->getElementsByTagName('Impuestos')->item(0);
		$timbreFiscalDigital = $xml->getElementsByTagName('TimbreFiscalDigital')->item(0);

        $factura = array(
			"fecha" => $comprobante->getAttribute('Fecha'),
			"uuid" => $timbreFiscalDigital->getAttribute('UUID'),
			"impuestos" => $impuestosGlobales->getAttribute('TotalImpuestosTrasladados'),
			"subtotal" => $comprobante->getAttribute('SubTotal'),
			"total" => $comprobante->getAttribute('Total'),
		);

        return $factura;
    }
}

if (!function_exists('procesar_nota_relacional')) {
    function procesar_nota_relacional($xml, $id_invoice) {

		$comprobante = $xml->getElementsByTagName('Comprobante')->item(0);
		$cfdiRelacionados = $xml->getElementsByTagName('CfdiRelacionados')->item(0);
		//$tipoRelacion = $cfdiRelacionados->getAttribute('TipoRelacion'); importante pasa saber si es nota
		$uuidRelacionado = $cfdiRelacionados->getElementsByTagName('CfdiRelacionado')->item(0)->getAttribute('UUID');
		$impuestosGlobales = $xml->getElementsByTagName('Impuestos')->item(0);

        $nota = array(
			"id_invoice" => $id_invoice,
			"note_number" => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
			"total" => $comprobante->getAttribute('Total'),
			"xml_document" => $xml->saveXML(),
			"created_at" => $comprobante->getAttribute('Fecha'),
			"uuid" => 	$uuidRelacionado = $cfdiRelacionados->getElementsByTagName('CfdiRelacionado')->item(0)->getAttribute('UUID'),			
		);

        return $nota;
    }
}

