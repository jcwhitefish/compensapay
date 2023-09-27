<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/enties/Factura.php';

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
		$user = "1";

		$resultado = $this->Interaccionbd->VerOperaciones($user);
		
		// Verifica que $resultado sea un array antes de procesarlo
		if (is_array($resultado)) {
			// Inicializa un array para almacenar objetos Factura
			$facturas = array();
		
			// Itera sobre el array de resultados
			foreach ($resultado as $jsonFactura) {
				// Decodifica cada cadena JSON y crea una instancia de la clase Factura
				$facturaData = json_decode($jsonFactura);
		
				if ($facturaData !== null) {
					$factura = new Factura(
						$facturaData->FechaEmision,
						$facturaData->FechaUpdate,
						$facturaData->Total,
						$facturaData->Impuestos,
						$facturaData->Subtotal,
						$facturaData->TipoDocumento,
						$facturaData->EstatusClienteProveedor,
						$facturaData->UUID,
						$facturaData->AliasCliente,
						$facturaData->RFCCliente,
						$facturaData->AliasProvedor,
						$facturaData->RFCProveedor
					);
		
					$facturas[] = $factura;
				}
			}
		
			// Ahora tienes un array de objetos Factura
			
			$data['facturas'] = $facturas;
		} 
		
		$data['main'] = $this->load->view('xml', $data , true);
		$this->load->view('plantilla', $data);
		
	}
	public function factura() {
		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['invoiceUpload']['tmp_name']);

			//Create the instance about "Factura"
			$factura = new Factura($xmlContent);

			echo $factura->version;
			echo "<br>";
			echo $factura->date;
			echo "<br>";

			// Items
			foreach ($factura->items as $item) {
				echo $item['description'];
				echo "<br>";
			}

			echo $factura->issuerRfc;
			echo "<br>";
			echo $factura->receiverRfc;
			echo "<br>";

			// Impuestos
			echo $factura->totalTransferredTaxes;
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