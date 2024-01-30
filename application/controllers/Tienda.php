<?php
	/**
	 * @property Settings_model $conf
	 * @property Openpay_model  $dataOp
	 */
	
	class tienda extends MY_Loggedin {
		private string $env = 'SANDBOX';
		public function index (): void {
			$this->load->model ( 'Openpay_model', 'dataOp' );
			$this->load->model ( 'Settings_model', 'conf' );
			$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
			$conf[ 'card' ] = $this->dataOp->getActiveCard ( $id );
			$conf[ 'notifications' ] = $this->conf->getNotificationsSettings ( $id );
			$data[ 'main' ] = $this->load->view ( 'market', $conf, TRUE );
			$this->load->view ( 'plantilla', $data );
		}
	}
