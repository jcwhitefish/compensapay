<?php

class Conciliaciones extends MY_Loggedin
{
	public function index(): void
	{
		$data['main'] = $this->load->view('conciliaciones', '', true);
		$this->load->view('plantilla', $data);
	}

}
