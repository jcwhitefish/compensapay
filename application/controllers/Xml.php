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
	public function xmlTemp(){

		if ($_FILES['comprobantexmlUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['comprobantexmlUpload']['tmp_name']);
			$xml = simplexml_load_string((string)$xmlContent);

			$dom = new DOMDocument();
			$dom->loadXML($xmlContent);

			$version = $dom->documentElement->getAttribute('Version');
			$fecha = $dom->documentElement->getAttribute('Fecha');
			$sello = $dom->documentElement->getAttribute('Sello');
			$formaPago = $dom->documentElement->getAttribute('FormaPago');
			$noCertificado = $dom->documentElement->getAttribute('NoCertificado');
			$certificado = $dom->documentElement->getAttribute('Certificado');
			$subTotal = $dom->documentElement->getAttribute('SubTotal');
			$moneda = $dom->documentElement->getAttribute('Moneda');
			$tipoCambio = $dom->documentElement->getAttribute('TipoCambio');
			$total = $dom->documentElement->getAttribute('Total');
			$tipoDeComprobante = $dom->documentElement->getAttribute('TipoDeComprobante');
			$exportacion = $dom->documentElement->getAttribute('Exportacion');
			$metodoPago = $dom->documentElement->getAttribute('MetodoPago');
			$lugarExpedicion = $dom->documentElement->getAttribute('LugarExpedicion');

			$emisor = $dom->getElementsByTagName('Emisor')->item(0);
			$emisorRfc = $emisor->getAttribute('Rfc');
			$emisorNombre = $emisor->getAttribute('Nombre');
			$emisorRegimenFiscal = $emisor->getAttribute('RegimenFiscal');

			$receptor = $dom->getElementsByTagName('Receptor')->item(0);
			$receptorRfc = $receptor->getAttribute('Rfc');
			$receptorNombre = $receptor->getAttribute('Nombre');
			$usoCFDI = $receptor->getAttribute('UsoCFDI');

			$conceptos = $dom->getElementsByTagName('Concepto');
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

			$impuestosGenerales = $dom->getElementsByTagName('Impuestos')->item(0);
			$totalImpuestosTrasladados = $impuestosGenerales->getAttribute('TotalImpuestosTrasladados');

			print_r($emisorNombre);

		} 
	}

}