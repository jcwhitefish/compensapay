<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends MY_Loggedin
{
	public function __construct()
	{
		parent::__construct();

		// Cargar la biblioteca de sesión
		$this->load->library('session');
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
		//Obtenermos los datos de datosEmpresa y los enviamos al front

		$data['main'] = $this->load->view('perfil/empresa', '', true);

		$this->load->view('plantilla', $data);

	}
	public function empresa()
	{
		//Obtenermos los datos de datosEmpresa y los enviamos al front

		$data['main'] = $this->load->view('perfil/empresa', '', true);

		$this->load->view('plantilla', $data);

	}
	public function usuario()
	{
		//Obtenermos los datos de datosEmpresa y los enviamos al front

		$data['main'] = $this->load->view('perfil/usuario', '', true);

		$this->load->view('plantilla', $data);

	}

	public function datosEmpresa()
	{
		//Esta funciona ya no se puede usar tal cual pero aqui es donde se tenian que llamar los datos
		$dato = array();
		$resultado = json_decode($this->Interaccionbd->consultaPersona($this->session->userdata('idPersona') - 1),true);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
}
