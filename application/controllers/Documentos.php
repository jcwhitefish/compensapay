<?php
/**
 * @property Fiscal_model $fData
 */
class Documentos extends MY_Loggedin{
	public function index(){
//		$isClient = $this->session->userdata('vista');
//		if ($isClient == 1) {
//			$data['main'] = $this->load->view('modelofiscal/cliente', '', true);
//			$this->load->view('plantilla', $data);
//		} else {
		$data['main'] = $this->load->view('documents', '', true);
		$this->load->view('plantilla', $data);
//		}
	}

	public function tablaCEP(){
		$this->load->model('Fiscal_model', '$fData');
		$companie = $this->session->userdata('id');
		$dato = [];
		$dato['CEPS'] = $this->$fData->getInfoCEP($companie);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
}
