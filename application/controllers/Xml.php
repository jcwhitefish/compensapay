<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xml extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index(){
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('xml','',true);
		$this->load->view('plantilla',$data);
	}
	public function factura(){

		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['invoiceUpload']['tmp_name']);

			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);

			$version = $xml->documentElement->getAttribute('Version');
			$fecha = $xml->documentElement->getAttribute('Fecha');
			$sello = $xml->documentElement->getAttribute('Sello');
			$formaPago = $xml->documentElement->getAttribute('FormaPago');
			$noCertificado = $xml->documentElement->getAttribute('NoCertificado');
			$certificado = $xml->documentElement->getAttribute('Certificado');
			$subTotal = $xml->documentElement->getAttribute('SubTotal');
			$moneda = $xml->documentElement->getAttribute('Moneda');
			$tipoCambio = $xml->documentElement->getAttribute('TipoCambio');
			$total = $xml->documentElement->getAttribute('Total');
			$tipoDeComprobante = $xml->documentElement->getAttribute('TipoDeComprobante');
			$exportacion = $xml->documentElement->getAttribute('Exportacion');
			$metodoPago = $xml->documentElement->getAttribute('MetodoPago');
			$lugarExpedicion = $xml->documentElement->getAttribute('LugarExpedicion');

			$emisor = $xml->getElementsByTagName('Emisor')->item(0);
			$emisorRfc = $emisor->getAttribute('Rfc');
			$emisorNombre = $emisor->getAttribute('Nombre');
			$emisorRegimenFiscal = $emisor->getAttribute('RegimenFiscal');

			$receptor = $xml->getElementsByTagName('Receptor')->item(0);
			$receptorRfc = $receptor->getAttribute('Rfc');
			$receptorNombre = $receptor->getAttribute('Nombre');
			$usoCFDI = $receptor->getAttribute('UsoCFDI');

			$conceptos = $xml->getElementsByTagName('Concepto');
			foreach ($conceptos as $concepto) {
				$claveProdServ = $concepto->getAttribute('ClaveProdServ');
				$noIdentificacion = $concepto->getAttribute('NoIdentificacion');
				$cantidad = $concepto->getAttribute('Cantidad');
				$claveUnidad = $concepto->getAttribute('ClaveUnidad');
				$descripcion = $concepto->getAttribute('Descripcion');
				$valorUnitario = $concepto->getAttribute('ValorUnitario');
				$importe = $concepto->getAttribute('Importe');
				$objetoImp = $concepto->getAttribute('ObjetoImp');
				
				$impuestos = $concepto->getElementsByTagName('Traslado');
				foreach ($impuestos as $impuesto) {
					$base = $impuesto->getAttribute('Base');
					$impuestoId = $impuesto->getAttribute('Impuesto');
					$tipoFactor = $impuesto->getAttribute('TipoFactor');
					$tasaOCuota = $impuesto->getAttribute('TasaOCuota');
					$importeImpuesto = $impuesto->getAttribute('Importe');
				}
			}

			$impuestosGenerales = $xml->getElementsByTagName('Impuestos')->item(0);
			$totalImpuestosTrasladados = $impuestosGenerales->getAttribute('TotalImpuestosTrasladados');

			echo "Version: " . $version . "<br>";
			echo "Fecha: " . $fecha . "<br>";
			echo "Sello: " . $sello . "<br>";
			echo "Forma de Pago: " . $formaPago . "<br>";
			echo "No. de Certificado: " . $noCertificado . "<br>";
			echo "Certificado: " . $certificado . "<br>";
			echo "SubTotal: " . $subTotal . "<br>";
			echo "Moneda: " . $moneda . "<br>";
			echo "Tipo de Cambio: " . $tipoCambio . "<br>";
			echo "Total: " . $total . "<br>";
			echo "Tipo de Comprobante: " . $tipoDeComprobante . "<br>";
			echo "Exportación: " . $exportacion . "<br>";
			echo "Método de Pago: " . $metodoPago . "<br>";
			echo "Lugar de Expedición: " . $lugarExpedicion . "<br>";

			echo "Emisor RFC: " . $emisorRfc . "<br>";
			echo "Emisor Nombre: " . $emisorNombre . "<br>";
			echo "Emisor Regimen Fiscal: " . $emisorRegimenFiscal . "<br>";

			echo "Receptor RFC: " . $receptorRfc . "<br>";
			echo "Receptor Nombre: " . $receptorNombre . "<br>";
			echo "Uso CFDI: " . $usoCFDI . "<br>";

			$contadorConceptos = 1;
			foreach ($conceptos as $concepto) {
				echo "Concepto #" . $contadorConceptos . "<br>";
				echo "Clave Producto/Servicio: " . $claveProdServ . "<br>";
				echo "No. Identificación: " . $noIdentificacion . "<br>";
				echo "Cantidad: " . $cantidad . "<br>";
				echo "Clave Unidad: " . $claveUnidad . "<br>";
				echo "Descripción: " . $descripcion . "<br>";
				echo "Valor Unitario: " . $valorUnitario . "<br>";
				echo "Importe: " . $importe . "<br>";
				echo "Objeto Imp: " . $objetoImp . "<br>";

				$contadorImpuestos = 1;
				foreach ($impuestos as $impuesto) {
					echo "Impuesto #" . $contadorImpuestos . "<br>";
					echo "Base: " . $base . "<br>";
					echo "Impuesto ID: " . $impuestoId . "<br>";
					echo "Tipo de Factor: " . $tipoFactor . "<br>";
					echo "Tasa o Cuota: " . $tasaOCuota . "<br>";
					echo "Importe de Impuesto: " . $importeImpuesto . "<br>";

					$contadorImpuestos++;
				}

				$contadorConceptos++;
			}

			echo "Total de Impuestos Trasladados: " . $totalImpuestosTrasladados . "<br>";


		} 
	}
	public function notaCredito(){

		if ($_FILES['creditNoteUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['creditNoteUpload']['tmp_name']);
			$xml = simplexml_load_string((string)$xmlContent);

			print_r($xml);
		} 
	}

}