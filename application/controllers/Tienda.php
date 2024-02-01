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
		public function BuyOperations (): bool {
			$this->load->model ( 'Openpay_model', 'dataOp' );
			$id = $this->session->userdata ( 'datosUsuario' )[ "id" ];
			$args = [
				'card_number' => $this->input->post ( 'cardNumber' ),
				'holder_name' => $this->input->post ( 'holderName' ),
				'expiration_year' => $this->input->post ( 'expirationYear' ),
				'expiration_month' => $this->input->post ( 'expirationMonth' ),
				'cvv' => $this->input->post ( 'cvv' ),
				'session_id' => $this->input->post ( 'sessionID' ),
				'cardType' => $this->input->post ( 'cardType' ),
				'tokenCard' => $this->input->post ( 'tokenCard' ),
			];
			$cardData = $this->dataOp->charge3DS ( $args, $this->env );
			if ( isset ( $cardData[ 'code' ] ) ) {
				echo json_encode ( $cardData );
				return FALSE;
			} else {
				echo json_encode ( $cardData );
				return TRUE;
			}
			return FALSE;
		}
		
	}
