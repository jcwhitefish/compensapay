<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends MY_Loggedout
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model'); // Carga el modelo
		$this->load->model('company_model'); // Carga el modelo
		$this->load->model('registro_model');
		$this->load->library('email');

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
	public function usuario()
	{
		$datos = array(
			"detalles" => $this->registro_model->detalles()	
		);

		$data['main'] = $this->load->view('registro/usuario', $datos, true);
		$this->load->view('plantilla', $data);
	}
	public function empresa()
	{
		//guarda el usuario
		$name = $this->input->post('name');
		$lastname = $this->input->post('lastname');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone-number');

		//muestra el formulario de los datos de la empresa
		$datos = array(
			"detalles" => $this->registro_model->detalles()	
		);
		
		$data['main'] = $this->load->view('registro/empresa', $datos, true);
		$this->load->view('plantilla', $data);
	}
	public function finalizado($nombre, $correo)
	{
		$data = array();
		
		$datos = array(
			'nombre' => $nombre,
			'correo' => $decodedParams[1],
		);
		
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
	public function registraEmpresa() //todo: delete this mother later
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
		$this->form_validation->set_rules('diaspago', 'DiasPago', 'required');
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
			$diaspago = $this->input->post('diaspago');
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
			'dias_pago' => $diaspago,
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
		//$this->form_validation->set_rules('user', 'Usuario', 'required');
		//$this->form_validation->set_rules('name', 'Nombre', 'required');
		//$this->form_validation->set_rules('lastname', 'Apellidos', 'required');
		//$this->form_validation->set_rules('email', 'Correo', 'required|valid_email');
		//$this->form_validation->set_rules('validateEmail', 'Confirmar Correo', 'required');
		//$this->form_validation->set_rules('number', 'Teléfono Móvil', 'required|exact_length[10]|numeric');
		//$this->form_validation->set_rules('validateNumber', 'Confirmar Teléfono Móvil', 'required|exact_length[10]|numeric');
		//$this->form_validation->set_rules('question', 'Pregunta Secreta', 'required');
		//$this->form_validation->set_rules('answer', 'Respuesta', 'required');
		//$this->form_validation->set_rules('idEmpresa', 'ID', 'required');
		//$this->form_validation->set_rules('uniqueString', 'UniqueString', 'required');
		//if ($this->form_validation->run() === FALSE) {
		//	// Si la validación falla, puedes mostrar errores o redirigir al formulario
		//	// redirect('controlador/metodo');
		//	$validation_errors = validation_errors();
		//	//echo $validation_errors;
		//} else {

			// Si la validación es exitosa, obtén los datos del formulario
			//$user = $this->input->post('user');
			$name = $this->input->post('name');
			$lastname = $this->input->post('lastname');
			$email = $this->input->post('email');
			$validateEmail = $this->input->post('validateEmail');
			$number = $this->input->post('number');
			//$validateNumber = $this->input->post('validateNumber');
			//$question = $this->input->post('question');
			//$answer = $this->input->post('answer');
			//$idEmpresa = $this->input->post('idEmpresa');
			//$uniqueString = $this->input->post('uniqueString');
		//}
		$datos_usuario = array(
			'user' => $email,
			'name' => $name,
			'last_name' => $lastname,
			'email' => $email,
			'telephone' => $number
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
		$this->enviarCorreo($id_insertado,$email);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
	public function enviarCorreo($id,$email)
	{
		$config = array(
			'protocol' => 'smtp',  // Puedes cambiar a 'mail' si prefieres el protocolo de correo PHP por defecto
			'smtp_host' => 'smtp-mail.outlook.com',
			'smtp_port' => 465,  // El puerto del servidor SMTP
			'smtp_user' => 'hola@compensapay.mx',
			'smtp_pass' => 'hola@compensapay.mx',
			'mailtype' => 'html',  // Puedes cambiar a 'text' si prefieres texto sin formato
			'charset' => 'utf-8',
			'wordwrap' => TRUE
		 );
		$this->email->initialize($config);

		$this->email->from('hola@compensapay.mx', 'compensapay');
		$this->email->to($email);
		$this->email->subject('Creacion de cuenta');
		$this->email->message(base_url('validarCuenta/'.cifrarId($id)));

		if ($this->email->send()) {
			echo 'Correo enviado con éxito';
		} else {
			echo 'Error al enviar el correo: ' . $this->email->print_debugger();
		}
		// echo cifrarAES($id);

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
	public function verVariables($variable)
	{
		echo descifrarAES($variable);
	}

	public function registrarProveedor()
	{
		$this->load->model('Proveedor_model', 'prov');

		//var_dump($this->input->post('bussinesName'));

		$bussinesName = $this->input->post('bussinesName');
        $nationality= $this->input->post('nationality');
        $folio= $this->input->post('folio');
        $efirma= $this->input->post('efirma');
        $phoneForm= $this->input->post('phoneForm');
       	$web= $this->input->post('web');
        $bank= $this->input->post('bank');
        $nameComercial= $this->input->post('nameComercial');
        $dateConst= $this->input->post('dateConst');

        $rfc= $this->input->post('rfc');
        $dom= $this->input->post('dom');
        $emailForm= $this->input->post('emailForm');
        $clabe= $this->input->post('clabe');
        $socialobj= $this->input->post('socialobj');
        $descOperation= $this->input->post('descOperation');
        $transactMonth= $this->input->post('transactMonth');
        $amount= $this->input->post('amount');
        $charge= $this->input->post('charge');
        $curp= $this->input->post('curp');

        $idNumber= $this->input->post('idNumber');
        $emailForm2= $this->input->post('emailForm2');
        $nameForm2= $this->input->post('nameForm2');
        $rfcForm2= $this->input->post('rfcForm2');
        $domForm2= $this->input->post('domForm2');
        $phoneForm2= $this->input->post('phoneForm2');
        $fisica= $this->input->post('fisica');
        $moral= $this->input->post('moral');
        $license= $this->input->post('license');
        $supervisor= $this->input->post('supervisor');

        $dateAward= $this->input->post('dateAward');
        $typeLicense= $this->input->post('typeLicense');
        $audited= $this->input->post('audited');
        $anticorruption= $this->input->post('anticorruption');
        $dataProtection= $this->input->post('dataProtection');
        $vulnerable= $this->input->post('vulnerable');
        $servTrib= $this->input->post('servTrib');
        $obligations= $this->input->post('obligations');

        $firma= $this->input->post('firma');
        $formato= $this->input->post('formato');

		$companie = $this->session->userdata('datosEmpresa')['id'];
		$companieName = $this->session->userdata('datosEmpresa')['legal_name'];

		$args = [
			'bussinesName' => $bussinesName,
			'nationality' => $nationality,
			'folio' => $folio,
			'efirma' => $efirma,
			'phoneForm' => $phoneForm,
			'web' => $web,
			'bank' => $bank,
			'nameComercial' => $nameComercial,
			'dateConst' => strtotime($dateConst),
			'dateConstPdf' => $dateConst,

			'rfc' => $rfc,
			'dom' => $dom,
			'emailForm' => $emailForm,
			'clabe' => $clabe,
			'socialobj' => $socialobj,
			'descOperation' => $descOperation,
			'transactMonth' => $transactMonth,
			'amount' => $amount,
			'charge' => $charge,
			'curp' => $curp,

			'idNumber' => $idNumber,
			'emailForm2' => $emailForm2,
			'nameForm2' => $nameForm2,
			'rfcForm2' => $rfcForm2,
			'domForm2' => $domForm2,
			'phoneForm2' => $phoneForm2,
			'fisica' => $fisica,
			'moral' => $moral,
			'license' => $license,
			'supervisor' => $supervisor,

			'dateAward' => strtotime($dateAward),
			'dateAwardPdf' => $dateAward,
			'typeLicense' => $typeLicense,
			'audited' => $audited,
			'anticorruption' => $anticorruption,
			'dataProtection' => $dataProtection,
			'vulnerable' => $vulnerable,
			'servTrib' => $servTrib,
			'obligations' => $obligations,
			'companie' => $companie,
			'companieName' => $companieName,
			'firma' => $firma,
			'formato' => $formato,
		];
		$res = $this->prov->registrarProveedor($args);
		$this->session->set_userdata('legal_name', $bussinesName);
		$this->session->set_userdata('short_name', $nameComercial);
		$this->session->set_userdata('rfc', $rfc);
		$this->session->set_userdata('address', $dom);
		$this->session->set_userdata('telephone', $phoneForm);
		$this->session->set_userdata('account_clabe', $clabe);
		$pdf = $this->prov->createPDF($args);

		$config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'compensapay.xyz',
            'smtp_port' => '465',
            'smtp_user' => 'hola@compensapay.xyz',
            'smtp_pass' => 'compensamail2023#',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

		$this->email->initialize($config);

		$this->email->to('mega.megaman@hotmail.com');
		$this->email->from('hola@compensapay.xyz', 'Compensapay');
		$this->email->subject('Test Email (TEXT)');
		$this->email->message('<p>Mensaje Funciona</p>');
		$this->email->attach(__DIR__ . '/../../assets/proveedores/RegistroProveedor_'.$companieName.'.pdf');
		if($this->email->send())
         {
          $resp = 'Email send.';
         }
         else
        {
         $resp = $this->email->print_debugger();
        }
        
		echo json_encode($resp);
	}

	public function estado(){

		$codigopostal = $this->input->post('codigopostal');

		$datos = array(
			"estado" => $this->registro_model->estado($codigopostal)	
		);

		//$this->load->view('registro/estados', $datos);

	}

	public function banco(){
		
		$clabe = $this->input->post('clabe');

		$datos = array(
			"banco" => $this->registro_model->banco($clabe)
		);

		$this->load->view('registro/banco', $datos);
	}

	public function registrarCompanie(){

		//leer datos
		$name = $this->input->post('name');
		$lastname = $this->input->post('lastname');
		$email = $this->input->post('email');
		$phone_number = $this->input->post('phone-number');
		$razonsocial = $this->input->post('razonsocial');
		$nombrecomercial = $this->input->post('nombrecomercial');
		$rfc = $this->input->post('rfc');
		$regimen = $this->input->post('regimen');

		$empresa = [
			"razonsocial" => $razonsocial, 
			"nombrecomercial" => $nombrecomercial, 
			"rfc" => $rfc,
			"regimen" => $regimen
		];

		$newEmpr = $this->registro_model->onboardinge($empresa);

		$usuario = [
			"user" => $email,
			"profile" => 0,
			"name" => $name,
			"lastname" => $lastname,
			"email" => $email, 
			"phone_number" => $phone_number, 
			"empresa" => $newEmpr
		]; 
		
		$newUser = $this->registro_model->onboardingu($usuario);

		//manda correo para contaseña
		//$this->enviarCorreo($newUser,$email);

		$datos = array(
			'nombre' => $name.' '.$lastname,
			'correo' => $email,
		);

		echo cifrarId($newUser); //TODO: comment this mother

		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('registro/finalizado', $datos, true);
		$this->load->view('plantilla', $data);
	}
}

