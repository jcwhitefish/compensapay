<?php

class Dispersiones extends MY_Loggedin {
	public function index (): void {
		$data = [
			'user' => $this->session->userdata ( 'datosUsuario' ),
			'company' => $this->session->userdata ( 'datosEmpresa' ),
		];
		$data[ 'main' ] = $this->load->view ( 'dispersionMasiva', $data, TRUE );
		$this->load->view ( 'plantilla', $data );
	}
}
