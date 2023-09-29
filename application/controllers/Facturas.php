<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/enties/Factura.php';

class Facturas extends MY_Loggedin {

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
		echo "hola messi";
	}	
    public function facturas_cliente(){
		$user = "6";

		$resultado = $this->Interaccionbd->VerOperaciones($user);

		//print_r($resultado); iprime para ver que es lo que llega
		
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
						$facturaData->NumOperacion,
						$facturaData->FechaEmision,
						$facturaData->FechaUpdate,
						$facturaData->Total,
						$facturaData->Impuestos,
						$facturaData->Subtotal,
						$facturaData->TipoDocumento,
						$facturaData->Estatus,
						$facturaData->UUID,
						$facturaData->AliasCliente,
						$facturaData->RFCCliente
						// $facturaData->AliasProvedor,
						// $facturaData->RFCProveedor
					);
					$factura->Usuario = 'UserDemo';
					$factura->IdUsuario = $user;
		
					$facturas[] = $factura;
				}
			}
		
			// Ahora tienes un array de objetos Factura
			
			$data['facturas'] = $facturas; 
		} 
		
		$data['main'] = $this->load->view('facturas/facturas_cliente', $data , true);
		$this->load->view('plantilla', $data);
		
	}	
    public function facturas_proveedor(){
		
		$user = "6";

		$resultado = $this->Interaccionbd->VerOperaciones($user);

		//print_r($resultado); iprime para ver que es lo que llega
		
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
						$facturaData->NumOperacion,
						$facturaData->FechaEmision,
						$facturaData->FechaUpdate,
						$facturaData->Total,
						$facturaData->Impuestos,
						$facturaData->Subtotal,
						$facturaData->TipoDocumento,
						$facturaData->Estatus,
						$facturaData->UUID,
						$facturaData->AliasCliente,
						$facturaData->RFCCliente
						// $facturaData->AliasProvedor,
						// $facturaData->RFCProveedor
					);
					$factura->Usuario = 'UserDemo';
					$factura->IdUsuario = $user;
		
					$facturas[] = $factura;
				}
			}
		
			// Ahora tienes un array de objetos Factura
			
			$data['facturas'] = $facturas; 
		} 
		
		$data['main'] = $this->load->view('facturas/facturas_proveedor', $data , true);
		$this->load->view('plantilla', $data);
		
	}	

    public function correcto(){
		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['invoiceUpload']['tmp_name']);

			//Create the instance about "Factura"
			//$factura = new Factura($xmlContent);

			$xml = simplexml_load_string($xmlContent);

			$user = "6";

			$resultado = $this->Interaccionbd->VerOperaciones($user);

			//print_r($resultado); iprime para ver que es lo que llega
			
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
							$facturaData->NumOperacion,
							$facturaData->FechaEmision,
							$facturaData->FechaUpdate,
							$facturaData->Total,
							$facturaData->Impuestos,
							$facturaData->Subtotal,
							$facturaData->TipoDocumento,
							$facturaData->Estatus,
							$facturaData->UUID,
							$facturaData->AliasCliente,
							$facturaData->RFCCliente
							// $facturaData->AliasProvedor,
							// $facturaData->RFCProveedor
						);
						$factura->Usuario = 'UserDemo';
						$factura->IdUsuario = $user;
			
						$facturas[] = $factura;
					}
				}
			
				// Ahora tienes un array de objetos Factura
				
				$data['facturas'] = $facturas; 
			} 
			$data['xml'] = $xml; 

			$data['main'] = $this->load->view('xml', $data , true);
			$this->load->view('plantilla', $data);
			

		}
		
	}
				

}