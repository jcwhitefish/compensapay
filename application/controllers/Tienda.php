<?php
	/**
	 *@property Settings_model $conf
	 * @property Openpay_model $dataOp
	 */
	
	class tienda extends MY_Loggedin {
		public function index(): void
		{
			$this->load->model('Openpay_model','dataOp');
			$this->load->model('Settings_model' , 'conf');
			$id = $this->session->userdata('id');
			$conf['card'] = $this->dataOp->getActiveCard($id);
//		var_dump($conf);
			$conf['notifications'] = $this->conf->getNotificationsSettings($id);
			$data['main'] = $this->load->view('market', $conf, true);
			$this->load->view('plantilla', $data);
		}
	}
