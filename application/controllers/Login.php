<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Interaccionbd');
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

    public function index() {
		
        if ($this->input->post()) {
            $user = $this->input->post('user');
            $password = $this->input->post('password');
			$password = $this->input->post('password');
            
            $data = array(
                'Usuario' => $user,
                'Llave' => $password
            );
            
            $cadenajsonvalidar = json_encode($data);
            
            $resultado = $this->Interaccionbd->ValidarAcceso($cadenajsonvalidar);
    
    	    $perfil = json_decode($resultado, true)['Perfil'];

			
            //print_r($data);
            if ($resultado == 0) {
                //redirect('main');
				$data['error_message'] = 'Usuario o contraseña incorrectos.';
				$data['main'] = $this->load->view('login/login',$data ,true);
				$this->load->view('plantilla',$data);
				//print_r($perfil);
            } else {
                //$data['error_message'] = 'Usuario o contraseña incorrectos.';
                //$this->load->view('plantilla', $data);
				print_r($perfil);
            }
        } else {
            $data['main'] = $this->load->view('login/login','',true);
			$this->load->view('plantilla',$data);
        }
	}
}
