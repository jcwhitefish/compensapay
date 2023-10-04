<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/enties/Factura.php';
require_once APPPATH . 'helpers/factura_helper.php';

class ModeloFiscal extends MY_Loggedin {

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
		$isClient = $this->session->userdata('vista');
		$user = 6;

		if($isClient == 1){
			//Accede a la db 
			$this->db->select('*');
			$this->db->from('operacion');
			$this->db->where('o_idPersona', $user);
			$queryFacturas = $this->db->get();
			$facturas = $queryFacturas->result();
			$data['facturas'] = $facturas;	

			$this->db->select('*');
			$this->db->from('tabla_ejemplo');
			$queryOperacion = $this->db->get();
			$operaciones = $queryOperacion->result();
			$data['operaciones'] = $operaciones;


			$data['main'] = $this->load->view('modelofiscal/modelo_fiscal_cliente', $data , true);
			$this->load->view('plantilla', $data);
		}else{
			$this->db->select('*');
			$this->db->from('operacion');
			$this->db->where('o_idPersona', $user);
			$queryFacturas = $this->db->get();
			$facturas = $queryFacturas->result();
			$data['facturas'] = $facturas;	

			$this->db->select('*');
			$this->db->from('tabla_ejemplo');
			$queryOperacion = $this->db->get();
			$operaciones = $queryOperacion->result();
			$data['operaciones'] = $operaciones;
				
			$data['main'] = $this->load->view('modelofiscal/modelo_fiscal_proveedor', $data , true);
			$this->load->view('plantilla', $data);
		}

	}	
	

}