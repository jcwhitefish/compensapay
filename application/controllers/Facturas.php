<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/enties/Factura.php';

class Facturas extends MY_Loggedout {

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
		
		$data['main'] = $this->load->view('facturas/facturas_cliente','' , true);
		$this->load->view('plantilla', $data);
		
	}	
    public function facturas_proveedor(){
		
		$data['main'] = $this->load->view('facturas/facturas_proveedor','' , true);
		$this->load->view('plantilla', $data);
		
	}				

}