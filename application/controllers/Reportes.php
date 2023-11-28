<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends MY_Loggedin {

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

	function __construct()
 	{

 	  parent:: __construct();
 	  $this->load->model('Reportes_model'); 
 	}
	
	public function index(){

		$dato = array(
			"repor" => $this->Reportes_model->reportes(),
			"dump" => 0
		);


		$data['main'] = $this->load->view('reportes/reportes', $dato, true);
		$this->load->view('plantilla', $data);
		

	}				

}