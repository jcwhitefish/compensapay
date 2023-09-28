<?php
// application/core/MY_LoggedOut.php
// Aqui son las paginas que no puede entrar si esta logueado

class MY_Loggedout extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        
        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if ($this->session->userdata('logged_in')) {
            redirect('inicio'); // Redirigir al Dashboard
        }
    }
}