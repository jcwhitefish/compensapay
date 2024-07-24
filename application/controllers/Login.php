<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Loggedout
{
	public function __construct() {
        parent::__construct();
        $this->load->model('user_model'); // Carga el modelo
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
		$data['main'] = $this->load->view('login/entrar', '', true);
		$this->load->view('plantilla', $data);
	}
	public function resetpass()
	{

		if(!isset($_POST["user"]))
		{
			$data['main'] = $this->load->view('login/resetpass', '', true);
			$this->load->view('plantilla', $data);
		}	
		else{
			//busca al usuario
			$correouser = $this->user_model->reset_password($_POST["user"]);
			
			foreach($correouser AS $value)
			{
				$id = $value["id"];
				$correo = $value["email"];
				$name = $value["name"];
				$lastname = $value["last_name"];
			}

			//envia el correo
			$this->load->helper('sendmail_helper');

			$data = [
				'user' => [
					'name' => $name,
					'lastName' => $lastname,
				],
				'text' => 'Haz solicitado un cambio de contraseña',
				'urlDetail' => ['url' => base_url('login/validarCuenta/'.cifrarAES($id)), 'name' => 'cambiar contraseña'],
				'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
			];

			send_mail($correo, $data, 3, 'uriel.magallon@whitefish.mx', 'Cambiar contraseña');

			$dato = array(
				"correo" => $correo,
				"dump" => 0
			);

			$data['main'] = $this->load->view('registro/resetpass', $dato, true);
			$this->load->view('plantilla', $data);
		}
		
	}
	public function validarCuenta($AESEmpresa = null)
	{

		$this->load->helper('herramientas_helper');

		if (isset($AESEmpresa)) {
			//$empresaDecode = urldecode($AESEmpresa);
			$empresa = dIrarfic($AESEmpresa);
			//var_dump($empresa);
			//echo '-'.$empresaDecode;
			//echo '-'.$empresa;
			$condiciones = array('id' => $empresa);
			$persona = $this->user_model->get_user($condiciones);
			//var_dump($persona);
			if (!is_null($persona)) {
				//valimados que password este vacia
				if ($persona['password'] == '') {
					$data['id_usuario'] = $persona['id'];
					$data['nombre_usuario'] = $persona['user'];
					$data['nombre_d_usaurio'] = $persona['name'];
					$data['apellido_usuario'] = $persona['last_name'];
					$data['main'] = $this->load->view('login/crear_contrasena', $data, true);
					$this->load->view('plantilla', $data);
				}else {
					//('registro/empresa');
					redirect('login');
				}

			} else {
				//redirect('registro/empresa');
				redirect('registro/usuario');
				//echo 'Hola 1 '.$AESEmpresa;
			}
		} else {
			//redirect('registro/empresa');
			redirect('registro/usuario');
			//echo 'Hola 2';
		}
	}
	public function crearContrasena()
	{
		$dato = array();
		$this->form_validation->set_rules('userId', 'UserId', 'required');
		$this->form_validation->set_rules('passwordValidate', 'PasswordValidate', 'required|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*[#$%@&?!])(?=.*\d).{8,15}$/]');

		if ($this->form_validation->run() === FALSE) {
			// Si la validación falla, puedes mostrar errores o redirigir al formulario
			// redirect('controlador/metodo');
			$dato['status'] = validation_errors();
			//echo $validation_errors;
		} else {

			// Si la validación es exitosa, obtén los datos del formulario
			$user = $this->input->post('userId');
			$pass = $this->input->post('passwordValidate');
			$nuevos_datos = array(
				'password' => cifrarId($pass)
			);
			$cambio = $this->user_model->update_user($user, $nuevos_datos);
			$this->user_model->setInitialConf($user);
			$dato['status'] = $cambio;

			//echo cifrarId($pass);
		}
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
	public function validaAcceso()
	{

		//TODO: Asi es como debe de hacerse una extraccion de datos por GET y todas las acciones se deben de hacer si se envian los datos correctos dentro del if no fuera
		$dato = array();

		$user = $this->input->post('user');
		$password = $this->input->post('password');
		//Verificamos que no si exista el usuario
		$condiciones = array('user' => $user, 'password' => cifrarId($password));
//		var_dump($condiciones);
		$persona = $this->user_model->get_user($condiciones);
//        var_dump($persona);
		$dato['condiciones'] = $persona;
		if (!is_null($persona)) {
			//TODO:Esto es para tener los datos del usuario que inicio sesion
			$this->session->set_userdata('logged_in', true);
			$this->session->set_userdata('id', $persona['id']);
			$this->session->set_userdata('vista', 1);
			$dato['status'] = 1;
			redirect(base_url('inicio'));
		} else {
			$this->session->set_userdata('logged_in', false);
			$dato['status'] = 0;
			redirect(base_url('login'));
		}
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
}
