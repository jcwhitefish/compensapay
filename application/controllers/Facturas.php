<?php
defined('BASEPATH') or exit('No direct script access allowed');


//later erase this mothers
require_once APPPATH . 'helpers/factura_helper.php';

class Facturas extends MY_Loggedout
{

	private $user;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Invoice_model');
		// Cambia por el usuario
		$this->user = "1";
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
	public function index()
	{

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

	public function tablaFacturas()
	{
		$dato = array();
		$dato['facturas'] = $this->Invoice_model->get_my_invoices($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function tablaOperaciones()
	{
		$dato = array();
		$dato['operaciones'] = $this->Invoice_model->get_my_invoices($this->user);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function subidaFactura()
	{
		$dato = array();

		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$uploadedFile = $_FILES['invoiceUpload'];

			if (pathinfo($uploadedFile['name'], PATHINFO_EXTENSION) === 'zip') {
				$zip = new ZipArchive;
				if ($zip->open($uploadedFile['tmp_name']) === TRUE) {
					$extractedDir = './xml/';
					$zip->extractTo($extractedDir);
					$zip->close();
		
					$xmlFiles = glob($extractedDir . '*.xml');
					foreach ($xmlFiles as $xmlFile) {
						$xmlContent = file_get_contents($xmlFile);
						$xml = new DOMDocument();
						$xml->loadXML($xmlContent);
						$this->load->helper('factura_helper');
						$factura = procesar_xml($xml, $this->user);
						$id_insertado = $this->Invoice_model->post_my_invoice($factura);
						print_r($id_insertado);
						unlink($xmlFile);
					};
					rmdir($extractedDir);
				} else {
					echo "Error al abrir el archivo ZIP.";
				}
			} else {
				$xmlContent = file_get_contents($uploadedFile['tmp_name']);
				$xml = new DOMDocument();
				$xml->loadXML($xmlContent);
				$this->load->helper('factura_helper');
				$factura = procesar_xml($xml, $this->user);
				$id_insertado = $this->Invoice_model->post_my_invoice($factura);
			}
		}		


		
		$dato['status'] = "ok";
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

	public function carga()
	{

		$factura = array(
			"Aprobacion" => "1",
			"ID_Persona" => "6",
			"ID_Operacion" =>  str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT),
			"Proveedor" => "Frontier",
			"Fecha_Factura" => "2023-05-15",
			"Fecha_Alta" => "2023-10-05",
			"Factura" => "FAC002",
			"Nota_Debito_Factura_Proveedor" => "ND2331",
			"Fecha_Nota_Debito_Fact_Proveedor" => "ND4341",
			"Fecha_Transaccion" => "2023-10-09",
			"Estatus" => "Aprobada",
			"Monto_Ingreso" => "10000.00",
			"Monto_Egreso" => "10000.00",
		);

		$this->db->insert('tabla_ejemplo', $factura);

		redirect("facturas");
	}

	public function actualizacion($id){

		$factura = array(
			"Aprobacion" => "1",
			"Estatus" => "Aprobada",
		);

		$ID_Operacion = $id; // Obtener el ID de operación

		// Construir la consulta de actualización
		$this->db->where('ID', $ID_Operacion);
		$this->db->update('tabla_ejemplo', $factura);

		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
}
