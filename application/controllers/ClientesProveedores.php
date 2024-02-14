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
	
	public function invitasocio(){

		$nameCompanie = $this->session->userdata('datosEmpresa')['legal_name'];
		$nameUser = $this->session->userdata('datosUsuario')["name"];
		$lastnameUser = $this->session->userdata('datosUsuario')["last_name"];

		$correo = $this->input->post('correoe');
		$namePartner = $this->input->post("nombre");
		$empresa = $this->input->post("empresa");

		//envia el correo
		$this->load->helper('sendmail_helper');

		$data = [
			'user' => [
				'name' => $nameUser,
				'lastName' => $lastnameUser,
				'companie' => $nameCompanie,
				'partnerName' => $namePartner,
				'empresa' => $empresa
			],
			'text' => 'Te ha invitado a registrarte en la plataforma Solve para conciliar operaciones de facturación entre ambos, registrate en la liga que te enviamos y comienza a conciliar con el y otros socios de negocios',
			'urlDetail' => ['url' => base_url('registro/empresa'), 'name' => 'registro en Solve'],
			'urlSoporte' => ['url' => "https://www.solve.com.mx/#Contacto", 'name' => "https://www.solve.com.mx/#Contacto"],
		];

		send_mail($correo, $data, 4, 'juan.carreno@whitefish.mx', 'Invitar Socio');

		$this->load->view('clientesproveedores/invitosocio', $data);
	}

}