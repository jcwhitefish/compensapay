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
			//save the variables 
            $user = $this->input->post('user');
            $password = $this->input->post('password');
			//change variables in json
            $data = array(
                'Usuario' => $user,
                'Llave' => $password
            );
            $cadenajsonvalidar = json_encode($data);
            $resultado = $this->Interaccionbd->ValidarAcceso($cadenajsonvalidar);
    	    $perfil = json_decode($resultado, true)['Perfil'];
			//assign isLog for validate de login view
			$data['isLog'] = false;
			
            if ($resultado == 0) {
                //redirect if your id profile is 0
				$data['error_message'] = 'Usuario o contraseña incorrectos.';
				$data['main'] = $this->load->view('login/login',$data ,true);
				$this->load->view('plantilla',$data);
            } else {
                //print your profile id
				print_r($perfil);
            }
        } else {
			//normal view
			//assign isLog for validate de login view
			$data['isLog'] = true;
            $data['main'] = $this->load->view('login/login',$data,true);
			$this->load->view('plantilla',$data);
        }
	}
	public function validadorCuenta($user = null, $password = null, $passwordValidate = null) {
		if ($user && $password && $passwordValidate) {
			//in this part you can use your information 
		} else {
			$data['isLog'] = false;
			$data['main'] = $this->load->view('login/login', $data, true);
			$this->load->view('plantilla', $data);
		}
	}
	
}
