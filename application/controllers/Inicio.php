<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends MY_Loggedin
{

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
 	  $this->load->model('Inicio_model'); 
 	}

	public function index()
	{
		if ( 
			empty( $this->session->userdata ( 'datosEmpresa' )[ 'kyc_id' ] ) OR 
			empty($this->session->userdata('datosEmpresa')['pt_id']) OR 
			empty($this->session->userdata('datosEmpresa')["propietarioReal"]) OR 
			$this->session->userdata('datosEmpresa')['StpUsuarios'] < 2 OR 
			$this->session->userdata('datosEmpresa')['StpContactos'] == 0 OR 
			empty($this->session->userdata('datosEmpresa')["finclabe"])
			) {

			header("Location: ".base_url('/perfil/empresa')); 
		}
		elseif($this->Inicio_model->pago() == FALSE)
		{
			header("Location: ".base_url('/Configuracion'));
		}
		else{
			$datos = array(
				"dashboard" => $this->Inicio_model->dashboard(),
				"dump" => 0
			);
			//mostramos en pantalla welcome_message.php
			$data['main'] = $this->load->view('inicio', $datos, true);
		}

		$this->load->view('plantilla', $data);
	}
}
