<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends MY_Loggedin
{
	public function __construct()
	{
		parent::__construct();

		// Cargar la biblioteca de sesión
		$this->load->library('session');
		//Cargamos modelo de postal
		$this->load->model('postal_model');
		//Cargamos modelo de state
		$this->load->model('state_model');	
		//Cargamos modelo de banco
		$this->load->model('bank_model');
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
		
		$idPostal  = $this->session->userdata('datosEmpresa')['id_postal_code'];
		$data['postal'] = $this->postalCodebyId($idPostal);
		$idState  = $this->session->userdata('datosEmpresa')['id_country'];
		$data['state'] = $this->stateCodebyId($idState);
		
		//De clabe lo convertimos a string y solo obtenemos las primeras 3 letras para el banco 
		$clabe  = $this->session->userdata('datosEmpresa')['account_clabe'];
		// convertimos a string
		$clabe = strval($clabe);
		$data['bank'] = $this->bankCode(substr($clabe, 0, 3));
		

		
		$data['main'] = $this->load->view('perfil/empresa', $data, true);
		$this->load->view('plantilla', $data);


	}
	public function usuario()
	{
		//Obtenermos los datos de datosEmpresa y los enviamos al front
		$this->load->model('user_model', 'dataUsr');
		$id = $this->session->userdata('id');
		$usr['usuario'] = $this->dataUsr->get_userById($id);
		$data['usuario'] = $this->dataUsr->get_userById($id);
		$data['main'] = $this->load->view('perfil/usuario', $usr, true);

		$this->load->view('plantilla', $data);

	}
	public function postalCodebyId($idPostal)
	{
		// traemos el codigo postal
		$postal = $this->postal_model->get_postal(array('zip_id' => $idPostal));
		// enviamos el codigo postal al front
		return $postal['zip_code'];

	}
	public function stateCodebyId($idState)
	{
		// traemos el codigo State
		$state = $this->state_model->get_state($idState);
		// enviamos el codigo State al front
		return $state[0] -> stt_name;

	}
	public function bankCode($clabe)
	{
		// traemos el codigo State
		$bank = $this->bank_model->get_bank($clabe);
		// enviamos el codigo State al front
		return $bank[0] -> bnk_alias;
	}
}
