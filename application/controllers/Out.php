<?php
	class Out extends MY_Loggedout {
		public function succesBuy () {
			$this->load->view ( 'chargeSucces' );
		}
}
