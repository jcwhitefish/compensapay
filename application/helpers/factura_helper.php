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
			"invoice_number" => $comprobante->getAttribute('TipoDeComprobante'),
			"uuid" => $timbreFiscalDigital->getAttribute('UUID'),
			"invoice_date" => $comprobante->getAttribute('Fecha'),
			"transaction_date" => "0000-00-00",
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
		// $version = $comprobante->getAttribute('Version');
		// $serie = $comprobante->getAttribute('Serie');
		// $folio = $comprobante->getAttribute('Folio');
		// $fecha = $comprobante->getAttribute('Fecha');
		// $sello = $comprobante->getAttribute('Sello');
		// $subtotal = $comprobante->getAttribute('SubTotal');
		// $moneda = $comprobante->getAttribute('Moneda');
		// $tipoCambio = $comprobante->getAttribute('TipoCambio');
		// $total = $comprobante->getAttribute('Total');
		// $tipoDeComprobante = $comprobante->getAttribute('TipoDeComprobante');
		// $metodoPago = $comprobante->getAttribute('MetodoPago');
		// $formaPago = $comprobante->getAttribute('FormaPago');
		// $lugarExpedicion = $comprobante->getAttribute('LugarExpedicion');
		// $cfdiRelacionados = $comprobante->getAttribute('CfdiRelacionados');

		// // Acceder a datos del Emisor
		$emisor = $xml->getElementsByTagName('Emisor')->item(0);
		// $rfcEmisor = $emisor->getAttribute('Rfc');
		// $nombreEmisor = $emisor->getAttribute('Nombre');
		// $regimenFiscalEmisor = $emisor->getAttribute('RegimenFiscal');

		// // Acceder a datos del Receptor
		$receptor = $xml->getElementsByTagName('Receptor')->item(0);
		// $rfcReceptor = $receptor->getAttribute('Rfc');
		// $nombreReceptor = $receptor->getAttribute('Nombre');
		// $domicilioFiscalReceptor = $receptor->getAttribute('DomicilioFiscalReceptor');
		// $regimenFiscalReceptor = $receptor->getAttribute('RegimenFiscalReceptor');
		// $usoCFDI = $receptor->getAttribute('UsoCFDI');

		// // Acceder a datos de Conceptos (puedes tener múltiples conceptos)
		// $conceptos = $xml->getElementsByTagName('Concepto');cfdi:cfdi:
		// foreach ($conceptos as $concepto) {
		// 	$claveProdServ = $concepto->getAttribute('ClaveProdServ');
		// 	$cantidad = $concepto->getAttribute('Cantidad');
		// 	$claveUnidad = $concepto->getAttribute('ClaveUnidad');
		// 	$unidad = $concepto->getAttribute('Unidad');
		// 	$descripcion = $concepto->getAttribute('Descripcion');
		// 	$valorUnitario = $concepto->getAttribute('ValorUnitario');
		// 	$importe = $concepto->getAttribute('Importe');
		// 	$objetoImp = $concepto->getAttribute('ObjetoImp');
			
		// 	// Acceder a datos de Impuestos dentro de Concepto
		// 	$impuestos = $concepto->getElementsByTagName('Impuestos')->item(0);
		// 	$traslados = $impuestos->getElementsByTagName('Traslados')->item(0);
		// 	$traslado = $traslados->getElementsByTagName('Traslado')->item(0);
		// 	$base = $traslado->getAttribute('Base');
		// 	$importeImpuesto = $traslado->getAttribute('Importe');
		// 	$impuesto = $traslado->getAttribute('Impuesto');
		// 	$tasaOCuota = $traslado->getAttribute('TasaOCuota');
		// 	$tipoFactor = $traslado->getAttribute('TipoFactor');
		// }

		// // Acceder a datos de Impuestos Globales
		$impuestosGlobales = $xml->getElementsByTagName('Impuestos')->item(0);
		// $totalImpuestosTrasladados = $impuestosGlobales->getAttribute('TotalImpuestosTrasladados');
		// $trasladosGlobales = $impuestosGlobales->getElementsByTagName('Traslados')->item(0);
		// $trasladoGlobal = $trasladosGlobales->getElementsByTagName('Traslado')->item(0);
		// $baseGlobal = $trasladoGlobal->getAttribute('Base');
		// $importeImpuestoGlobal = $trasladoGlobal->getAttribute('Importe');
		// $impuestoGlobal = $trasladoGlobal->getAttribute('Impuesto');
		// $tasaOCuotaGlobal = $trasladoGlobal->getAttribute('TasaOCuota');
		// $tipoFactorGlobal = $trasladoGlobal->getAttribute('TipoFactor');

		// // Acceder a datos del Timbre Fiscal Digital
		$timbreFiscalDigital = $xml->getElementsByTagName('TimbreFiscalDigital')->item(0);
		// $versionTimbre = $timbreFiscalDigital->getAttribute('Version');
		// $uuid = $timbreFiscalDigital->getAttribute('UUID');
		// $fechaTimbrado = $timbreFiscalDigital->getAttribute('FechaTimbrado');
		// $rfcProvCertif = $timbreFiscalDigital->getAttribute('RfcProvCertif');
		// $selloCFD = $timbreFiscalDigital->getAttribute('SelloCFD');
		// $noCertificadoSAT = $timbreFiscalDigital->getAttribute('NoCertificadoSAT');
		// $selloSAT = $timbreFiscalDigital->getAttribute('SelloSAT');

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