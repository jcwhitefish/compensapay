<?php

class Configuracion extends MY_Loggedin
{
	public function index(){
		$data['main'] = $this->load->view('configuracion','', true);
		$this->load->view('plantilla', $data);



	}

}
