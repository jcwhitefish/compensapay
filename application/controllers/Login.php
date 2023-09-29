<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Loggedout
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

	public function index()
	{
		$data['main'] = $this->load->view('login/entrar', '', true);
		$this->load->view('plantilla', $data);
	}
	public function validarCuenta($AESEmpresa = null)
	{

		if (isset($AESEmpresa)) {
			$empresaDecode = urldecode($AESEmpresa);
			$empresa = descifrarAES($empresaDecode);
			//echo $empresa;
			$persona = json_decode($this->Interaccionbd->consultaPersona($empresa));
			echo ($persona[0]->id_usuario);
			if ($persona[0]->id_usuario != 0) {
				$data['id_usuario'] = $persona[0]->id_usuario;
				$data['nombre_usuario'] = $persona[0]->nombre_usuario;
				$data['nombre_d_usaurio'] = $persona[0]->nombre_d_usaurio;
				$data['apellido_usuario'] = $persona[0]->apellido_usuario;
				$data['main'] = $this->load->view('login/crear_contrasena', $data, true);
				$this->load->view('plantilla', $data);
			} else {
				redirect('registro/empresa');
			}
		} else {
			redirect('registro/empresa');
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

			$cambio = $this->Interaccionbd->UpdateLlaveUsuario('{"idUsuario":' . $user . ',"Llave":"' . $pass . '"}');
			$dato['status'] = $cambio;
		}
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
	public function validaAcceso()
	{

		//TODO: Asi es como debe de hacerse un envio de datos por GET y todas las acciones se deben de hacer si se envian los datos correctos dentro del if no fuera
		$dato = array();



		$user = $this->input->get('user');
		$password = $this->input->get('password');
		$resultado = $this->Interaccionbd->ValidarAcceso('{"Usuario":"' . $user . '","Llave":"' . $password . '"}');
		//Verificamos que no si exista el usuario

		if ($resultado !== 0) {
			//TODO:Esto es para tener los datos del usuario que inicio sesion
			$resultadoJSON = json_encode($resultado);

			$this->session->set_userdata('logged_in', TRUE);

			$dato['status'] = 1;
		} else {
			$dato['status'] = 0;
		}
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
}
