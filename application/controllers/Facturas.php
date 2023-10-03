<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/enties/Factura.php';
require_once APPPATH . 'helpers/factura_helper.php';

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

		//Se verifica si esta en la pantalla de cliente
		$isClient = false;
		$user = 6;

		if($isClient){
			//Accede a la db 
			$this->db->select('*');
			$this->db->from('operacion');
			$this->db->where('o_idPersona', $user);
			$query = $this->db->get();
			$facturas = $query->result();
			//Pasa arreglo de tabla de operaciones de la db al front
			$data['facturas'] = $facturas;		
			$data['main'] = $this->load->view('facturas/facturas_cliente', $data , true);
			$this->load->view('plantilla', $data);
		}else{
			$this->db->select('*');
			$this->db->from('operacion');
			$this->db->where('o_idPersona', $user);
			$query = $this->db->get();
			$facturas = $query->result();

			$data['facturas'] = $facturas;		
			$data['main'] = $this->load->view('facturas/facturas_proveedor', $data , true);
			$this->load->view('plantilla', $data);
		}

	}	
	
	public function subida(){

		$user = "6";

		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['invoiceUpload']['tmp_name']);
			$xml = new DOMDocument();
			$xml->loadXML($xmlContent);
			$this->load->helper('factura_helper');
			$factura = procesar_xml($xml);
			$factura = array(
				"o_NumOperacion" => $factura->o_NumOperacion,
				"o_idPersona" =>  $user,
				"o_FechaEmision" => $factura->o_FechaEmision,
				"o_Total" => $factura->o_Total,
				"o_ArchivoXML" => $factura->o_ArchivoXML,
				"o_UUID" => $factura->o_UUID,
				"o_idTipoDocumento" => $factura->o_idTipoDocumento,
				"o_SubTotal" => $factura->o_SubTotal,
				"o_Impuesto" => $factura->o_Impuesto,
				"o_FechaUpload" => $factura->o_FechaUpload,
				"o_Activo" => $factura->o_Activo
			);
			$this->db->insert('operacion', $factura);
		}
		
		
		$this->db->select('*');
		$this->db->from('operacion');
		$this->db->where('o_idPersona', '6');
		$query = $this->db->get();
		$facturas = $query->result();

		$data['facturas'] = $facturas;		
		$data['main'] = $this->load->view('facturas/facturas_proveedor', $data , true);
		$this->load->view('plantilla', $data);
		
	}					

}