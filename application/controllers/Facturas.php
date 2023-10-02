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
	public function subida(){

		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['invoiceUpload']['tmp_name']);
			$xml = new DOMDocument();
        	$xml->loadXML($xmlContent);

			$comprobante = $xml->getElementsByTagName('Comprobante')->item(0);
			$timbreFiscalDigital = $xml->getElementsByTagName('TimbreFiscalDigital')->item(0);
			$emisor = $xml->getElementsByTagName('Emisor')->item(0);
			$receptor = $xml->getElementsByTagName('Receptor')->item(0);

			// $facturaAdd = new Factura(
			// 	"1",
			// 	$comprobante->getAttribute('Fecha'),
			// 	$comprobante->getAttribute('Fecha'),
			// 	$comprobante->getAttribute('Total'),
			// 	$comprobante->getAttribute('Exportacion'),
			// 	$comprobante->getAttribute('SubTotal'),
			// 	$comprobante->getAttribute('TipoDeComprobante'),
			// 	"Cargada",
			// 	$timbreFiscalDigital->getAttribute('UUID'),
			// 	$receptor->getAttribute('Nombre'),
			// 	$receptor->getAttribute('Rfc'),
			// 	$emisor->getAttribute('Nombre'),
			// 	$emisor->getAttribute('Rfc'),
			// 	"UserDemo",
			// 	"6"
			// );

			// echo "<pre>";
			// print_r($facturaAdd);
			// echo "</pre>";

			// Crear un arreglo asociativo con los datos de $facturaAdd
			$facturaData = array(
				"NumOperacion" =>  "839667766",
				"idPersona"=>   "2",
				"FechaEmision" =>  $comprobante->getAttribute('Fecha'),
				"SubTotal" =>  $comprobante->getAttribute('SubTotal'),
				"Impuesto" => $comprobante->getAttribute('Exportacion'),
				"Total" => $comprobante->getAttribute('Total'),
				"ArchivoXML" => "",
				"UID" => $timbreFiscalDigital->getAttribute('UUID'),
				"idTipoDocumento" => $comprobante->getAttribute('TipoDeComprobante'),
				"idUsuario" => "6"
			);

			// Convertir el arreglo a formato JSON
			$facturaJSON = json_encode($facturaData);

			// Llamar a la función AgregarOperacion con el JSON como argumento
			$cargo = $this->Interaccionbd->AgregarOperacion($facturaJSON);

			// Imprimir la respuesta
			print_r($cargo);


		}
		
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

				

}