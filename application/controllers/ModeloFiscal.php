<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloFiscal extends MY_Loggedin {

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
	public function index(){

		$isClient = $this->session->userdata('vista');

		// If is client
		if ($isClient == 1) {
			$data['main'] = $this->load->view('modelofiscal/cliente', '', true);
			$this->load->view('plantilla', $data);
		} else {
			$data['main'] = $this->load->view('modelofiscal/proveedor', '', true);
			$this->load->view('plantilla', $data);
		}

	}	

	

}