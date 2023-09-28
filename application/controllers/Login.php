<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
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

	 public function index() {
		if ($this->input->post()) {
			$user = $this->input->post('user');
			$password = $this->input->post('password');
			// Change the array in json
			$data = [
				'Usuario' => $user,
				'Llave' => $password
			];
			$cadenajsonvalidar = json_encode($data);
			$resultado = $this->Interaccionbd->ValidarAcceso($cadenajsonvalidar);
			$perfil = json_decode($resultado, true);
	
	
			if ($perfil['Perfil'] === 0) {
				// if your profile is 0 

				//$data['error_message'] = 'Usuario o contraseña incorrectos.';
				print_r($perfil['Perfil']);
			} else {
				print_r($perfil['Perfil']);
			}
		} 

		// assign isLog for validate if show in the screen
		$data['main'] = $this->load->view('login/entrar', '', true);
		$this->load->view('plantilla', $data);
	}	
	public function validarCuenta($AESEmpresa = null)
	{

		if (isset($AESEmpresa)) {
			$empresaDecode = urldecode($AESEmpresa);
			$empresa = descifrarAES($empresaDecode);
			echo $empresa;
			$persona = json_decode($this->Interaccionbd->consultaPersona($empresa));
			if ($persona[0]->id_usuario != 0) {
				$data['nombre_usuario'] = $persona[0]->nombre_usuario;
				$data['nombre_d_usaurio'] = $persona[0]->nombre_d_usaurio;
				$data['apellido_usuario'] = $persona[0]->apellido_usuario;
				$data['main'] = $this->load->view('login/crear_contrasena',$data, true);
				$this->load->view('plantilla', $data);
			}else{
				redirect('registro/empresa');
			}
		} else {
			redirect('registro/empresa');
		}
	}
	public function crearContrasena()
	{
		
	}
	
}
