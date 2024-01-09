<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloFiscal extends MY_Loggedin {

	public function index(){
		$isClient = $this->session->userdata('vista');
		// If is client
		//if ($isClient == 1) {
			$data['main'] = $this->load->view('modelofiscal/cliente', '', true);
			$this->load->view('plantilla', $data);
		//} else {
		//	$data['main'] = $this->load->view('modelofiscal/proveedor', '', true);
		//	$this->load->view('plantilla', $data);
		//}
	}

	public function tablaCEP(){
		$this->load->model('Fiscal_model', 'fdata');
		$companie = $this->session->userdata('id');
		$dato = [];
		$dato['CEPS'] = $this->fdata->getInfoCEP($companie);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}

}
