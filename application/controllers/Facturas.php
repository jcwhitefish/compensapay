<?php
defined('BASEPATH') or exit('No direct script access allowed');


//later erase this mothers
require_once APPPATH . 'helpers/factura_helper.php';

class Facturas extends MY_Loggedin
{

	private $user;

	public function __construct(){
		parent::__construct();
		$this->load->model('Invoice_model');
		$this->load->model('Operation_model');
		$this->load->model('Debitnote_model');
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
		$dato['facturas'] = $this->Invoice_model->get_provider_invoices($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaFacturasCliente(){
		$dato = array();
		$dato['facturas'] = $this->Invoice_model->get_client_invoices($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaOperaciones(){
		$dato = array();
		$dato['operaciones'] = $this->Operation_model->get_my_operation($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function cargaFacturasPorCliente(){

		$dato = array();

		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$emisor = $xml->getElementsByTagName('Emisor')->item(0);
			$this->load->helper('factura_helper');

			$dato['emisor'] = $emisor->getAttribute('Rfc');
			$dato['facturasClient'] = $this->Invoice_model->get_invoices_by_client($emisor->getAttribute('Rfc'));

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
			$rfc = $factura["receiver_rfc"];
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
		 
		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$selectedFacturaId = $_POST['grupoRadio'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$dato['facturaid'] = $selectedFacturaId;
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$this->load->helper('factura_helper');
			$factura2 = procesar_factura_relacional($xml);
			$factura1 = $this->Invoice_model->get_invoices_by_id($selectedFacturaId);

			$uuid1 = $factura1[0]->uuid;
			$uuid2 = $factura2["uuid"];
			

			if ($uuid1 === $uuid2) {

				$operacion = array(
					"id_invoice" => $selectedFacturaId,
					"id_invoice_relational" => "1",
					"id_uploaded_by" =>  $this->user,
					"id_client" => "1",
					"id_provider" => "1",
					"operation_number" => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
					"payment_date" =>  $factura1[0]->invoice_date,
					"entry_money" => $factura2["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "1",
					"created_at" => date('Y-m-d'),
				);

				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);

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

		if ($_FILES['operationUpload']['error'] == UPLOAD_ERR_OK) {
			$operationUpload = $_FILES['operationUpload'];
			$selectedFacturaId = $_POST['grupoRadio'];
			$xmlContent = file_get_contents($operationUpload['tmp_name']);
			$dato['facturaid'] = $selectedFacturaId;
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$this->load->helper('factura_helper');
			$factura2 = procesar_factura_relacional($xml);
			$factura1 = $this->Invoice_model->get_invoices_by_id($selectedFacturaId);

			$uuid1 = $factura1[0]->uuid;
			$uuid2 = $factura2["uuid"];
			$proveedor_id = $factura1[0]->id_user;

			if ($uuid1 === $uuid2) {
				//Agrega factura subida por cliente
				$factura = procesar_xml($xml, $this->user);
				$id_insertado = $this->Invoice_model->post_my_invoice($factura);

				$operacion = array(
					"id_invoice" => $selectedFacturaId,
					"id_invoice_relational" => $id_insertado,
					"id_uploaded_by" =>  $this->user,
					"id_client" => $this->user,
					"id_provider" => $proveedor_id,
					"operation_number" => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
					"payment_date" =>  $factura1[0]->invoice_date,
					"entry_money" => $factura2["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "1",
					"created_at" => date('Y-m-d'),
				);
				//Crea la operacion con los datos anteriores
				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);

				//Actualiza factura del proveedor
				$this->Invoice_model->update_status_invoice($selectedFacturaId, "1");
				//Actualiza factura del cliente
				$this->Invoice_model->update_status_invoice($id_insertado, "1");
			} else{
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
					"id_debit_note" => $idDebitNote,
					"id_uploaded_by" =>  "$this->user",
					"id_client" => $client[0]->id,
					"id_provider" =>  $provider[0]->id,
					"operation_number" => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
					"payment_date" =>  $factura1[0]->invoice_date,
					"entry_money" => $nota["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "0",
					"commentary" => "ok",
					"created_at" => date('Y-m-d'),
				);

				
				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);

			} else if ($uuid1 == null) {

				unset($nota["uuid"]);
				$idDebitNote = $this->Debitnote_model->post_my_debit_note($nota);
				$dato['debitNote'] = $idDebitNote;

				$operacion = array(
					"id_debit_note" => $idDebitNote,
					"id_uploaded_by" =>  "$this->user",
					"id_client" => $client[0]->id,
					"id_provider" =>  $provider[0]->id,
					"operation_number" => str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
					"payment_date" =>  $factura1[0]->invoice_date,
					"entry_money" => $nota["total"],
					"exit_money" => $factura1[0]->total,
					"status" => "0",
					"commentary" => "ok",
					"created_at" => date('Y-m-d'),
				);

				
				$dato['operacion'] = $this->Operation_model->post_my_invoice($operacion);

			}
			else{
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

		$dato['status'] = 'ok';

		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($dato));
	}

}
