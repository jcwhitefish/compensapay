<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientesProveedores extends MY_Loggedin {

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

	function __construct()
 	{

 	  parent:: __construct();
 	  $this->load->model('Clientesproveedores_model'); 
 	}
	
	public function index(){

		$dato = array(
			"clipro" => $this->Clientesproveedores_model->clientes(),
			"dump" => 0
		);


		$data['main'] = $this->load->view('clientesproveedores/clientesprovedores', $dato, true);
		$this->load->view('plantilla', $data);
		

	}				

}