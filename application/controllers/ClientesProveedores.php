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

	public function __construct()
	{
		parent::__construct();

		// Cargar la biblioteca de sesión
		$this->load->library('session');

	}
	public function index(){

		$data = array(
			'clientes' => $this->Clientesproveedores_model->clientes()
		);

		$this->load->view('plantilla', $data);
		$this->load->view('clientesproveedores/clientesprovedores');

		//Se verifica si esta en la pantalla de cliente
		//$isClient = $this->session->userdata('vista');
		//$user = 6;

		//1 si es cliente o  si es proveedor
		//if($isClient == 1){
		//	$data['main'] = $this->load->view('clientesproveedores/cliente', '' , true);
		//	$this->load->view('plantilla', $data);
		//}else{
		//	$data['main'] = $this->load->view('clientesproveedores/proveedor', '' , true);
		//	$this->load->view('plantilla', $data);
		//}
		//$this->load->model('clientesproveedores_model', 'dataUsr');
		//$id = $this->session->userdata('id');
		//$data['usuario'] = $this->dataUsr->get_cp($id);
		//$data['main'] = $this->load->view('clientesproveedores/clientesprovedores', $data , true);
	
		//
		//$this->load->view('plantilla', $data);

	}					

}