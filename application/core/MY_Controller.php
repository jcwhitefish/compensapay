<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}
// Este es para las paginas que necesitas estar logueado
class MY_Loggedin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->model('company_model');

        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if ($this->session->userdata('logged_in')) {
            //consultamos los datos del usuario cada que se recarga la pagina
			$data['datosUsuario']  = $this->user_model->get_user(array('id' => $this->session->userdata('id')));
//			 var_dump($data['datosUsuario']);
			//consultamos los datos de la empresa
			$data['datosEmpresa']  = $this->company_model->get_company(array('id' => $data['datosUsuario']['id_company']));
			$this->session->set_userdata('datosUsuario', $this->user_model->get_user(array('id' => $this->session->userdata('id'))));

			// var_dump($this->session->userdata('datosUsuario'));
			//consultamos los datos de la empresa con $this->session->set_userdata('datosUsuario',); el id de la empresa
			$this->session->set_userdata('datosEmpresa',$this->company_model->get_company(array('id' => $this->session->userdata('datosUsuario')['id_company'])));
//			var_dump($data['datosEmpresa']);
//            var_dump($this->session->userdata('datosEmpresa'));
        } else {
            redirect(base_url('login')); // Redirigir al inicio de sesión si no está autenticado
        }
    }
}
// Este es para las paginas que NO tienes que estar logueado
class MY_Loggedout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('inicio')); // Redirigir al Dashboard
        } else {
        }
    }
}
