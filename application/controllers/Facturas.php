<?php
defined('BASEPATH') or exit('No direct script access allowed');


//later erase this mothers
require_once APPPATH . 'helpers/factura_helper.php';

/**
 * @property Invoice_model $invData
 */
class Facturas extends MY_Loggedin {

	private $user;

	public function __construct(){
		parent::__construct();
		$this->load->model('Invoice_model');
		$this->load->model('Operation_model');
		$this->load->model('Debitnote_model');
		$this->load->model('company_model');
		// Cambia por el usuario
		$this->user = $this->user = $this->session->userdata('id');
	}

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

		$isClient = $this->session->userdata('vista');

		// If is client
		if ($isClient == 1) {
			$data['main'] = $this->load->view('facturas/cliente', '', true);
			$this->load->view('plantilla', $data);
		} else {
			$data['main'] = $this->load->view('facturas/proveedor', '', true);
			$this->load->view('plantilla', $data);
		}
	}

	public function tablaFacturas(){
		$dato = array();
		$dato['facturas'] = $this->Invoice_model->get_provider_invoices_tabla($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaFacturasCliente(){
		$dato = array();
		$dato['facturas'] = $this->Invoice_model->get_invoices_by_client($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaVistaFacturasCliente(){
		$dato = array();
		$dato['facturas'] = $this->Invoice_model->get_invoices_client($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function facturasDisponibles(){
		$dato = array();
		$dato['facturas'] = $this->Invoice_model->get_available_invoices($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaMovimientos(){
		$dato = array();
		$dato['movements'] = $this->Invoice_model->get_movements($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaOperacionesP(){
		$dato = array();
		$dato['operaciones'] = $this->Operation_model->get_my_operation($this->user, 'P');
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaOperacionesC(){
		$dato = array();
		$dato['operaciones'] = $this->Operation_model->get_my_operation($this->user, 'C');
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function operacionesCalendario(){
		$dato = array();
		$mesSelected = $_POST['mesSelected'];
		$dato['operaciones'] = $this->Operation_model->get_operation_calendar($this->user, $mesSelected);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function cargaFacturasPorCliente(){
		$dato = array();

		$idFacturaSelect = $_POST['id_f_s'];

		$facturaData = $this->Invoice_model->get_invoices_by_id($idFacturaSelect);
		//var_dump($facturaData);
		$company = $this->company_model->get_company_by_rfc($facturaData[0]->receiver_rfc);
		$dato['name_proveedor'] = $company[0]->short_name;
		$dato['facturasClient'] = $this->Invoice_model->get_inv_prov_send_by_rfc($facturaData[0]->receiver_rfc);

		$dato['status'] = "ok";
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaFacturasPorClienteU(){
		$dato = array();

		$rfc_proveedor = $_POST['rfc_proveedor'];
		$dato['facturas'] = $this->Invoice_model->get_inv_prov_send_by_rfc($rfc_proveedor);

		$dato['status'] = "ok";
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaFacturasProveedor(){
		$dato = array();

		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);

			//Obtiene los datos del cliente, receptor de la nota
			$receptor = $xml->getElementsByTagName('Receptor')->item(0);
			$rfc_rec = $receptor->getAttribute('Rfc');
			$this->load->helper('factura_helper');
			$dataReceptor = $this->Invoice_model->company($rfc_rec);
			$dato['name_client'] = $dataReceptor[0]->short_name;
			//obtiene las facturas asignadas al proveedor, emisor de la nota
			$emisor = $xml->getElementsByTagName('Emisor')->item(0);
			$rfc_emi = $emisor->getAttribute('Rfc');
			$dato['facturasProveedor'] = $this->Invoice_model->get_provider_invoices($this->user, $rfc_emi);
		}

		$dato['status'] = "ok";
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaFacturasProveedorU(){
		$dato = array();

		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			
			$receptor = $xml->getElementsByTagName('Receptor')->item(0);
			$this->load->helper('factura_helper');
			$dataEmisor = $this->Invoice_model->company($receptor->getAttribute('Rfc'));
			$dato['name_client'] = $dataEmisor[0]->short_name;
			//YA TIENE FACTURA UNICA
		}

		$dato['status'] = "ok";
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function subidaFactura(){
		$dato = array();

		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$uploadedFile = $_FILES['invoiceUpload'];

			if (pathinfo($uploadedFile['name'], PATHINFO_EXTENSION) === 'zip') {
				$zip = new ZipArchive;
				if ($zip->open($uploadedFile['tmp_name']) === TRUE) {
					$extractedDir = './temporales/xml/';
					$zip->extractTo($extractedDir);
					$zip->close();
		
					$xmlFiles = glob($extractedDir . '*.xml');
					foreach ($xmlFiles as $xmlFile) {
						$xmlContent = file_get_contents($xmlFile);
						$xml = new DOMDocument();
						$xml->loadXML($xmlContent);
						$this->load->helper('factura_helper');
						$factura = procesar_xml($xml, $this->user);
						$xml = $factura["uuid"];
						$dato['error'] = "facturas";
						if (!$this->Invoice_model->uuid_exists($xml)) {
							$id_insertado = $this->Invoice_model->post_my_invoice($factura);
						} else{
							$dato['error'] = "uuids";
						}
						unlink($xmlFile);
					};
					rmdir($extractedDir);
				} else {
					$dato['error'] = "zip";
				}
			} else {
				$xmlContent = file_get_contents($uploadedFile['tmp_name']);
				$xml = new DOMDocument();
				$xml->loadXML($xmlContent);
				$this->load->helper('factura_helper');
				$factura = procesar_xml($xml, $this->user);
				$rfc = $factura["sender_rfc"];
				$xml = $factura["uuid"];
				if (!$this->Invoice_model->uuid_exists($xml)) {
					$dato['error'] = "rfc";
					if ($this->Invoice_model->is_your_rfc($this->user, $rfc)) {
						$dato['error'] = "factura";
						$id_insertado = $this->Invoice_model->post_my_invoice($factura);
					}
				} else{
					$dato['error'] = "uuid";
				}
			}
		}		
		
		$dato['status'] = "ok";
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function subidaFacturaCliente(){
		$dato = array();

		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$uploadedFile = $_FILES['invoiceUpload'];
			$xmlContent = file_get_contents($uploadedFile['tmp_name']);
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$this->load->helper('factura_helper');
			$factura = procesar_xml($xml, $this->user);
			$rfc = $factura["sender_rfc"];
			$xml = $factura["uuid"];
			if (!$this->Invoice_model->uuid_exists($xml)) {
				$dato['error'] = "rfc";
				if ($this->Invoice_model->is_your_rfc($this->user, $rfc)) {
					$dato['error'] = "factura";
					$id_insertado = $this->Invoice_model->post_my_invoice($factura);
				}
			} else{
				$dato['error'] = "uuid";
			}

		}

		$dato['status'] = "ok";
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaOperacionFactura(){
		$dato = array();
		$dato['status'] = "ok";

		$id_factura_c = $_POST['id_f_s'];

		if ($id_factura_c != '0') {
			$id_factura_p = $_POST['grupoRadio'];
			$dato['facturaid'] = $id_factura_p;
			$factura2 = $this->Invoice_model->get_invoices_by_id($id_factura_c);
			$factura1 = $this->Invoice_model->get_invoices_by_id($id_factura_p);

			$uuid1 = $factura1[0]->uuid;
			$uuid2 = $factura2[0]->uuid;

			if($factura2[0]->total > $factura1[0]->total){
				$dato['status'] = "monto";
			}else if ($factura1[0]->sender_rfc == $factura2[0]->receiver_rfc && $factura1[0]->receiver_rfc == $factura2[0]->sender_rfc) {
				$operacion = array(
					"id_invoice" => $id_factura_p,
					"id_invoice_relational" => $id_factura_c,
					"id_uploaded_by" => $this->user,
					"id_client" => $this->user,
					"id_provider" => $factura1[0]->id_user,
					"operation_number" => $this->MakeOperationNumber($this->user.$factura1[0]->id_user),
					"payment_date" =>  strtotime($factura1[0]->invoice_date),
					"entry_money" => $factura2[0]->total,
					"exit_money" => $factura1[0]->total,
					"status" => "1",
					"created_at" => strtotime('now'),
				);

				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);
				//Actualiza factura del proveedor
				$this->Invoice_model->update_status_invoice($id_factura_p, "1");
				//Actualiza factura del cliente
				$this->Invoice_model->update_status_invoice($id_factura_c, "1");
				//Envía notificación de que se a creado la operación
				$this->load->helper('sendmail_helper');
				$this->load->helper('notifications_helper');
				$data = [
					'operationNumber' => $operacion['operation_number'],
					'cliente' => $this->session->userdata('datosEmpresa')["short_name"],
				];
				$notification = notificationBody($data,3);
				$data = [
					'user' => [
						'name' => $this->session->userdata('datosUsuario')["name"],
						'lastName' => $this->session->userdata('datosUsuario')["last_name"],
						'company' => $this->session->userdata('datosUsuario')["short_name"],
					],
					'text' => $notification['body'],
					'urlDetail' => ['url' => base_url('/facturas'), 'name' => 'Operaciones'],
					'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
				];
				send_mail($this->session->userdata('datosUsuario')["email"], $data, 2, 'uriel.magallon@whitefish.mx', $notification['title']);
				$this->nt->insertNotification(
					['id'=>$this->session->userdata('datosUsuario')["id"], 'title' =>$notification['title'], 'body' =>$notification['body'],],'SANDBOX');
			} else{
				$dato['status'] = "error";
			}
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaOperacionFacturaUnica(){
		$dato = array();
		$dato['status'] = "ok";

		if ($_POST['id_factura_cliente'] != '' && $_POST['id_factura_prov'] != '') {
			$id_factura_cliente = $_POST['id_factura_cliente'];
			$id_factura_prov = $_POST['id_factura_prov'];

			$factura2 = $this->Invoice_model->get_invoices_by_id($id_factura_cliente);
			$factura1 = $this->Invoice_model->get_invoices_by_id($id_factura_prov);

			if($factura2[0]->total > $factura1[0]->total){
				$dato['status'] = "monto";
			}else if ($factura1[0]->sender_rfc == $factura2[0]->receiver_rfc && $factura1[0]->receiver_rfc == $factura2[0]->sender_rfc) {
				$operacion = array(
					"id_invoice" => $id_factura_prov,
					"id_invoice_relational" => $id_factura_cliente,
					"id_uploaded_by" =>  $this->user,
					"id_client" => $this->user,
					"id_provider" => $factura1[0]->id_user,
					"operation_number" => $this->MakeOperationNumber($this->user.$factura1[0]->id_user),
					"payment_date" =>  strtotime($factura1[0]->invoice_date),
					"entry_money" => $factura2[0]->total,
					"exit_money" => $factura1[0]->total,
					"status" => "1",
					"created_at" => strtotime('now'),
				);
				//Crea la operacion con los datos anteriores
				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);

				//Actualiza factura del proveedor
				$this->Invoice_model->update_status_invoice($id_factura_prov, "1");
				//Actualiza factura del cliente
				$this->Invoice_model->update_status_invoice($id_factura_cliente, "1");

				$this->load->helper('sendmail_helper');
				$this->load->helper('notifications_helper');
				$data = [
					'operationNumber' => $operacion['operation_number'],
					'cliente' => $this->session->userdata('datosEmpresa')["short_name"],
				];
				$notification = notificationBody($data,3);
				$data = [
					'user' => [
						'name' => $this->session->userdata('datosUsuario')["name"],
						'lastName' => $this->session->userdata('datosUsuario')["last_name"],
						'company' => $this->session->userdata('datosUsuario')["short_name"],
					],
					'text' => $notification['body'],
					'urlDetail' => ['url' => base_url('/facturas'), 'name' => 'Operaciones'],
					'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
				];
				send_mail($this->session->userdata('datosUsuario')["email"], $data, 2, 'uriel.magallon@whitefish.mx', $notification['title']);
				$this->nt->insertNotification(
					['id'=>$this->session->userdata('datosUsuario')["id"], 'title' =>$notification['title'], 'body' =>$notification['body'],],'SANDBOX');
			} else{
				$dato['status'] = "error";
			}
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaOperacionNotaUnica(){
		$dato = array();
		$dato['status'] = "ok";

		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$selectedFacturaId = $_POST['grupoRadio'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$dato['facturaid'] = $selectedFacturaId;
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$this->load->helper('factura_helper');
			$nota = procesar_nota_relacional($xml, $selectedFacturaId);
			$factura1 = $this->Invoice_model->get_invoices_by_id($selectedFacturaId);

			$uuid1 = $factura1[0]->uuid;
			$uuid2 = $nota["uuid"];


			$client =  $this->Invoice_model->company($factura1[0]->receiver_rfc);
			$provider =  $this->Invoice_model->company($factura1[0]->sender_rfc);
			if($nota['total'] > $factura1[0]->total){
				$dato['status'] = "monto";
			}else if ($uuid1 === $uuid2) {
				unset($nota["uuid"]);
				$idDebitNote = $this->Debitnote_model->post_my_debit_note($nota);
				$dato['debitNote'] = $idDebitNote;

				$operacion = array(
					"id_invoice" => $dato['facturaid'],
					"id_debit_note" => $idDebitNote,
					"id_uploaded_by" =>  "$this->user",
					"id_client" => $client[0]->id,
					"id_provider" =>  $provider[0]->id,
					"operation_number" => $this->MakeOperationNumber($this->user.$factura1[0]->id_user),
					"payment_date" =>  strtotime($factura1[0]->invoice_date),
					"entry_money" => $nota["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "0",
					"commentary" => "ok",
					"created_at" => strtotime('now'),
				);
				//Ingresa operación
				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);
				//Actualiza factura
				$this->Invoice_model->update_status_invoice($selectedFacturaId, "1");

				$this->load->helper('sendmail_helper');
				$this->load->helper('notifications_helper');
				$data = [
					'operationNumber' => $operacion['operation_number'],
					'cliente' => $this->session->userdata('datosEmpresa')["short_name"],
				];
				$notification = notificationBody($data,3);
				$data = [
					'user' => [
						'name' => $this->session->userdata('datosUsuario')["name"],
						'lastName' => $this->session->userdata('datosUsuario')["last_name"],
						'company' => $this->session->userdata('datosUsuario')["short_name"],
					],
					'text' => $notification['body'],
					'urlDetail' => ['url' => base_url('/facturas'), 'name' => 'Operaciones'],
					'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
				];
				send_mail($this->session->userdata('datosUsuario')["email"], $data, 2, 'uriel.magallon@whitefish.mx', $notification['title']);
				$this->nt->insertNotification(
					['id'=>$this->session->userdata('datosUsuario')["id"], 'title' =>$notification['title'], 'body' =>$notification['body'],],'SANDBOX');

			} else if ($uuid1 == null) {
				unset($nota["uuid"]);
				$idDebitNote = $this->Debitnote_model->post_my_debit_note($nota);
				$dato['debitNote'] = $idDebitNote;

				$operacion = array(
					"id_debit_note" => $idDebitNote,
					"id_uploaded_by" =>  "$this->user",
					"id_client" => $client[0]->id,
					"id_provider" =>  $provider[0]->id,
					"operation_number" => $this->MakeOperationNumber($this->user.$factura1[0]->id_user),
					"payment_date" =>  strtotime($factura1[0]->invoice_date),
					"entry_money" => $nota["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "0",
					"commentary" => "ok",
					"created_at" => strtotime('now'),
				);

				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);
				$this->load->helper('sendmail_helper');
				$this->load->helper('notifications_helper');
				$data = [
					'operationNumber' => $operacion['operation_number'],
					'cliente' => $this->session->userdata('datosEmpresa')["short_name"],
				];
				$notification = notificationBody($data,3);
				$data = [
					'user' => [
						'name' => $this->session->userdata('datosUsuario')["name"],
						'lastName' => $this->session->userdata('datosUsuario')["last_name"],
						'company' => $this->session->userdata('datosUsuario')["short_name"],
					],
					'text' => $notification['body'],
					'urlDetail' => ['url' => base_url('/facturas'), 'name' => 'Operaciones'],
					'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
				];
				send_mail($this->session->userdata('datosUsuario')["email"], $data, 2, 'uriel.magallon@whitefish.mx', $notification['title']);
				$this->nt->insertNotification(
					['id'=>$this->session->userdata('datosUsuario')["id"], 'title' =>$notification['title'], 'body' =>$notification['body'],],'SANDBOX');

			}else{
				$dato['status'] = "error";
			}
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaOperacionNota(){
		$dato = array();
		$dato['status'] = "ok";

		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$selectedFacturaId = $_POST['grupoRadio'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$dato['facturaid'] = $selectedFacturaId;
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$this->load->helper('factura_helper');
			$nota = procesar_nota_relacional($xml, $selectedFacturaId);
			$factura1 = $this->Invoice_model->get_invoices_by_id($selectedFacturaId);

			$uuid1 = $factura1[0]->uuid;
			$uuid2 = $nota["uuid"];

			$client =  $this->Invoice_model->company($factura1[0]->receiver_rfc);
			$provider =  $this->Invoice_model->company($factura1[0]->sender_rfc);

			if ($uuid1 === $uuid2) {
				unset($nota["uuid"]);
				$idDebitNote = $this->Debitnote_model->post_my_debit_note($nota);
				$dato['debitNote'] = $idDebitNote;

				$operacion = array(
					"id_invoice" => $dato['facturaid'],
					"id_debit_note" => $idDebitNote,
					"id_uploaded_by" =>  "$this->user",
					"id_client" => $client[0]->id,
					"id_provider" =>  $provider[0]->id,
					"operation_number" => $this->MakeOperationNumber($this->user.$factura1[0]->id_user),
					"payment_date" =>  strtotime($factura1[0]->invoice_date),
					"entry_money" => $nota["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "0",
					"commentary" => "ok",
					"created_at" => strtotime('now'),
				);

				//Ingresa operación
				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);
				//Actualiza factura
				$this->Invoice_model->update_status_invoice($selectedFacturaId, "1");
			} else if ($uuid1 == null) {
				unset($nota["uuid"]);
				$idDebitNote = $this->Debitnote_model->post_my_debit_note($nota);
				$dato['debitNote'] = $idDebitNote;

				$operacion = array(
					"id_debit_note" => $idDebitNote,
					"id_uploaded_by" =>  "$this->user",
					"id_client" => $client[0]->id,
					"id_provider" =>  $provider[0]->id,
					"operation_number" =>$this->MakeOperationNumber($this->user.$factura1[0]->id_user),
					"payment_date" =>  strtotime($factura1[0]->invoice_date),
					"entry_money" => $nota["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "0",
					"commentary" => "ok",
					"created_at" => strtotime('now'),
				);

				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);

			}else if($uuid1 != $uuid2){
				$dato['status'] = "uuid";
			}else{
				$dato['status'] = "error";
			}
		}

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function cargaOperacionPorId(){
		$dato = array();

		$selectedoperationId = $_POST['selectedoperationId'];

		$dato['operationsClient'] = $this->Operation_model->get_operation_by_id($selectedoperationId);
		$dato['status'] = "ok";

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));

	}

	public function statusOperacion(){
		$dato = array();

		$selectedoperationId = $_POST['selectedoperationId'];
		$status = $_POST['acceptDecline'];
		$this->Invoice_model->update_status($selectedoperationId, $status);
		if($status == 2){//regresar status 0 a factura cuando se rechaza la OP
			$ope = $this->Operation_model->get_operation_by_id($selectedoperationId);
			$this->Invoice_model->update_status_invoice($ope[0]->id_invoice, '0');
		}

		$dato['status'] = 'ok';

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

	public function crearExcel()
	{
		//$this->Invoice_model->get_provider_invoices($this->user)

		$args = $this->input->post('info');
		$menu = $this->input->post('menu');

		$res = $this->Invoice_model->crearExcel($args, $menu);
		echo json_encode($res);
	}

    private function MakeOperationNumber($operation): string{
        $trash = '010203040506070809';
        return str_pad($operation, 7, substr(str_shuffle($trash), 0, 10), STR_PAD_LEFT);
    }

	public function DocsCFDI(){
		$from = strtotime($this->input->post('from'));
		$to = strtotime($this->input->post('to').' +1 day');
		if ($from & $to){
			$this->load->model('Invoice_model', 'invData');
			$res = json_encode($this->invData->getDocs($from,$to));
			echo $res;
			if($res['code'] != 200){
				return true;
			}
			return false;
		}
		echo json_encode('hola');
		return false;
	}

}
