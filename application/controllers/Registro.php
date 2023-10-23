<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends MY_Loggedout
{
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model'); // Carga el modelo
		$this->load->model('company_model'); // Carga el modelo
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
		//mostramos en pantalla welcome_message.php
		$this->load->view('welcome_message');
	}
	public function usuario(...$encodedParams)
	{
		// TODO: Aqui solo se deberia acceder por medio de empresa
		$data = array();
		if (!empty($encodedParams)) {

			$decodedParams = array_map('urldecode', $encodedParams);

			$datos = array(
				'bussinesName' => $decodedParams[0],
				'nameComercial' => $decodedParams[1],
				'codigoPostal' => $decodedParams[2],
				'estado' => $decodedParams[3],
				'direccion' => $decodedParams[4],
				'telefono' => $decodedParams[5],
				'type' => $decodedParams[6],
				'rfc' => $decodedParams[7],
				'fiscal' => $decodedParams[8],
				'clabe' => $decodedParams[9],
				'bank' => $decodedParams[10],
				'uniqueString' => $decodedParams[11]
			);
			$datos = json_encode($datos);
			$data['datosEmpresa'] = $datos;
		}

		$data['main'] = $this->load->view('registro/usuario', $data, true);
		$this->load->view('plantilla', $data);
	}
	public function empresa()
	{
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('registro/empresa', '', true);
		$this->load->view('plantilla', $data);
	}
	public function finalizado(...$encodedParams)
	{
		$data = array();
		if (!empty($encodedParams)) {

			$decodedParams = array_map('urldecode', $encodedParams);

			$datos = array(
				'nombre' => $decodedParams[0],
				'correo' => $decodedParams[1],
			);
		}
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('registro/finalizado', $datos, true);
		$this->load->view('plantilla', $data);
	}
	public function usuarioUnico()
	{
		$nombre = $this->uri->segment(3);
		$data = array(
			'nombre' => $nombre,
			'email' => 'johndoe@example.com'
		);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($data));
	}
	public function registraEmpresa()
	{
		$datos = array();
		$this->form_validation->set_rules('bussinesName', 'BussinesName', 'required');
		$this->form_validation->set_rules('nameComercial', 'NameComercial', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('rfc', 'RFC', 'trim|required|regex_match[/^[A-Z0-9]{12,13}$/]');
		$this->form_validation->set_rules('fiscal', 'Fiscal', 'required');
		$this->form_validation->set_rules('clabe', 'CLABE', 'trim|required|regex_match[/^[0-9]{18}$/]');
		$this->form_validation->set_rules('codigoPostal', 'CodigoPostal', 'required');
		$this->form_validation->set_rules('estado', 'Estado', 'required');
		$this->form_validation->set_rules('direccion', 'Direccion', 'required');
		$this->form_validation->set_rules('telefono', 'Telefono', 'required|regex_match[/^[0-9]+$/]');
		$this->form_validation->set_rules('bank', 'Bank', 'required');
		$this->form_validation->set_rules('uniqueString', 'UniqueString', 'required');
		if ($this->form_validation->run() === FALSE) {
			$validation_errors = validation_errors();
			$registro['validation_errors'] = $validation_errors;
		} else {
			$bussinesName = $this->input->post('bussinesName');
			$nameComercial = $this->input->post('nameComercial');
			$type = $this->input->post('type');
			$rfc = $this->input->post('rfc');
			$fiscal = $this->input->post('fiscal');
			$codigoPostal = $this->input->post('codigoPostal');
			$estado = $this->input->post('estado');
			$direccion = $this->input->post('direccion');
			$telefono = $this->input->post('telefono');			
			$clabe = $this->input->post('clabe');
			$bank = $this->input->post('bank');
			$uniqueString = $this->input->post('uniqueString');
		}
		//Movemos los archivos de la persona
		$sourcePath = './temporales/' . $uniqueString; // Ruta de origen de la carpeta
		$destinationPath =  './boveda/' . $uniqueString; // Ruta de destino de la carpeta

		$renombre = rename($sourcePath, $destinationPath);

		$datos_compania = array(
            'legal_name' => $bussinesName,
            'short_name' => $nameComercial,
            'id_type' => $type,
            'rfc' => $rfc,
            'id_fiscal' => $fiscal,
            'id_postal_code' => $codigoPostal,
            'id_country' => $estado,
            'address' => $direccion,
            'telephone' => $telefono,
            'account_clabe' => $clabe,
            'id_broadcast_bank' => $bank,
            'unique_key' => $uniqueString
        );

        $id_insertado = $this->company_model->insert_company($datos_compania);
		$datos['id_company'] = $id_insertado;
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($datos));
	}
	public function registraUsuario()
	{
		$this->form_validation->set_rules('user', 'Usuario', 'required');
		$this->form_validation->set_rules('name', 'Nombre', 'required');
		$this->form_validation->set_rules('lastname', 'Apellidos', 'required');
		$this->form_validation->set_rules('email', 'Correo', 'required|valid_email');
		$this->form_validation->set_rules('validateEmail', 'Confirmar Correo', 'required');
		$this->form_validation->set_rules('number', 'Teléfono Móvil', 'required|exact_length[10]|numeric');
		$this->form_validation->set_rules('validateNumber', 'Confirmar Teléfono Móvil', 'required|exact_length[10]|numeric');
		$this->form_validation->set_rules('question', 'Pregunta Secreta', 'required');
		$this->form_validation->set_rules('answer', 'Respuesta', 'required');
		$this->form_validation->set_rules('idEmpresa', 'ID', 'required');
		$this->form_validation->set_rules('uniqueString', 'UniqueString', 'required');
		if ($this->form_validation->run() === FALSE) {
			// Si la validación falla, puedes mostrar errores o redirigir al formulario
			// redirect('controlador/metodo');
			$validation_errors = validation_errors();
			//echo $validation_errors;
		} else {

			// Si la validación es exitosa, obtén los datos del formulario
			$user = $this->input->post('user');
			$name = $this->input->post('name');
			$lastname = $this->input->post('lastname');
			$email = $this->input->post('email');
			$validateEmail = $this->input->post('validateEmail');
			$number = $this->input->post('number');
			$validateNumber = $this->input->post('validateNumber');
			$question = $this->input->post('question');
			$answer = $this->input->post('answer');
			$idEmpresa = $this->input->post('idEmpresa');
			$uniqueString = $this->input->post('uniqueString');
		}
        $datos_usuario = array(
            'user' => $user,
			'password' => '',
			'profile' => 1,
			'name' => $name,
            'last_name' => $lastname,
            'email' => $email,
            'telephone' => $number,
            'id_question' => $question,
            'answer' => $answer,
            'id_company' => $idEmpresa,
            'unique_key' => $uniqueString
        );
		// echo json_encode($datos_usuario);
        $id_insertado = $this->user_model->insert_user($datos_usuario);

		$encodedParams = array();
		$encodedParams['nombre'] = urlencode($name . ' ' . $lastname);
		$encodedParams['correo'] = urlencode($email);

		$dato = array();
		$dato['url'] = 'registro/finalizado/' . implode('/', $encodedParams);
		// // Enviamos el correo

		// //asi es como
		$this->enviarCorreo($id_insertado);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
	public function enviarCorreo($id)
	{

		//echo cifrarAES($id);
		//return cifrarAES($idEmpresa);
	}
	public function catalogoBancos()
	{
		$clabe = $this->input->get('clabe');


		//llamamos la funcion que trae el banco dependiendo los 3 digitos de la clabe
		$clabe = substr(strval($clabe), 0, 3);
		//Esta es la funcion de israel
		function clabe3($clabe3)
		{
			$data['nombre'] = $clabe3;
			return json_encode($data);
		}
	}
	public function regimenFiscal()
	{
		$dato = array();
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
	//Nos permite ver las variables que queramos
	public function verVariables()
	{
		echo 'hola desde verVariable';
	}
	public function registraOpenpay(){
		$this->load->model('Openpay_model', 'dataOp');
		$id = $this->session->userdata('id');
		return $this->dataOp->NewClient(1);
	}
}

