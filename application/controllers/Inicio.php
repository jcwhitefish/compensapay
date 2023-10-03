<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Loggedin {

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
		if ($_SERVER['HTTP_HOST'] != 'localhost') {
			redirect('');
		} else {
			//mostramos en pantalla welcome_message.php
			$data['main'] = $this->load->view('inicio','', true);
			$this->load->view('plantilla', $data);
		}
	}			
}