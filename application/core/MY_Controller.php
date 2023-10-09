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
class MY_Loggedin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if ($this->session->userdata('logged_in')) {
            
        }else{
            redirect(base_url('login')); // Redirigir al inicio de sesión si no está autenticado
        }
    }
}
// Este es para las paginas que NO tienes que estar logueado
class MY_Loggedout extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if ($this->session->userdata('logged_in')) {
            redirect(base_url('inicio')); // Redirigir al Dashboard
        }else{
            
        }
    }
}