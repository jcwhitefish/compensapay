<?php
// application/core/MY_LoggedIn.php
// Aqui son las paginas que puede entrar si esta logueado

class MY_Loggedon extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); // Redirigir al inicio de sesión si no está autenticado
        }
    }
}