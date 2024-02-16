<?php
	/**
	 * @property Settings_model $conf
	 * @property Openpay_model  $dataOp
	 */
	
	class Configuracion extends MY_Loggedin {
		private int $amount = 600;
		private string $env = 'SANDBOX';
		public function index (): void {
			$this->load->model ( 'Openpay_model', 'dataOp' );
			$this->load->model ( 'Settings_model', 'conf' );
			$id = $this->session->userdata ( 'id' );
			$company = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
			$conf[ 'card' ] = $this->dataOp->getActiveCard ( $company );
//		var_dump($conf);
			$conf[ 'notifications' ] = $this->conf->getNotificationsSettings ( $id );
			$data[ 'main' ] = $this->load->view ( 'configuracion', $conf, TRUE );
			$this->load->view ( 'plantilla', $data );
		}
		public function newSubscription (): bool { //guarda los datos de la tarjeta
			$this->load->model ( 'Openpay_model', 'dataOp' );
			$id = $this->session->userdata ( 'datosEmpresa' )[ "id" ];
			$customerDAta = $this->dataOp->NewClient ( $id, $this->env );
//		var_dump ($customerDAta);
			$args = [
				'card_number' => $this->input->post ( 'cardNumber' ),
				'holder_name' => $this->input->post ( 'holderName' ),
				'expiration_year' => $this->input->post ( 'expirationYear' ),
				'expiration_month' => $this->input->post ( 'expirationMonth' ),
				'cvv' => $this->input->post ( 'cvv' ),
				'session_id' => $this->input->post ( 'sessionID' ),
				'customer_id' => $customerDAta[ 'id' ],
				'cardType' => $this->input->post ( 'cardType' ),
				'tokenCard' => $this->input->post ( 'tokenCard' ),
			];
			$cardData = $this->dataOp->NewCard ( $args, $this->env );
			if ( $cardData[ 'code' ] !== 200 ) {
				echo json_encode ( $cardData );
				return FALSE;
			} else if ( $cardData[ 'insertId' ] > 0 ) {
				$args[ 'OpId' ] = $cardData[ 'opId' ];
				echo json_encode ( $this->NewSubscriptionCharge ( $cardData[ 'insertId' ], $args, $id ) ); //aqui hace el cargo de la suscripción
				return TRUE;
			}
			return FALSE;
		}
		public function changeCard () {
			$this->load->model ( 'Openpay_model', 'dataOp' );
			$id = $this->session->userdata ( 'id' );
			$subs = $this->dataOp->getSubscription ( $id, $this->env );
			$subs = $subs[ 0 ];
//		var_dump($subs);
			$args = [
				'user' => $id,
				'card_number' => $this->input->post ( 'cardNumber' ),
				'holder_name' => $this->input->post ( 'holderName' ),
				'expiration_year' => $this->input->post ( 'expirationYear' ),
				'expiration_month' => $this->input->post ( 'expirationMonth' ),
				'cvv' => $this->input->post ( 'cvv' ),
				'session_id' => $this->input->post ( 'sessionID' ),
				'customer_id' => $subs[ 'customer_id' ],
				'cardType' => $this->input->post ( 'cardType' ),
				'tokenCard' => $this->input->post ( 'tokenCard' ),
			];
			$cardData = $this->dataOp->NewCard ( $args, $this->env );
			if ( !empty( $cardData[ 'code' ] ) ) {
				echo json_encode ( $cardData );
				return FALSE;
			}
			if ( $cardData[ 'insertId' ] > 0 ) {
				$args[ 'cardRecordID' ] = $cardData[ 'insertId' ];
				$args[ 'amount' ] = $this->amount;
				$args[ 'opId' ] = $cardData[ 'opId' ];
				$subsData = $this->dataOp->DeleteCard ( $args, $id, $this->env );
				if ( strtotime ( 'NOW' ) <= $subs[ 'nextPay' ] ) {
					echo json_encode ( $this->dataOp->ChangeSubscription ( $args, $subs, $id ) );
					return TRUE;
				} else {
					return $this->NewSubscriptionCharge ( $cardData[ 'insertId' ], $args, $id );
				}
//			$payment = $this->dataOp->NewCharge($args, $id,'SANDBOX');
//			$args['payment'] = $payment;
//			echo json_encode($this->dataOp->SuccessfulSubscription($args, $id, 'SANDBOX'));
//			return true;
			}
		}
		public function saveChanges (): void {
			$id = $this->session->userdata ( 'id' );
			$data = [
				'nt_OperationNew' => filter_var ( $this->input->post ( 'nt_OperationNew' ), FILTER_VALIDATE_INT ),
				'nt_OperationApproved' => filter_var ( $this->input->post ( 'nt_OperationApproved' ), FILTER_VALIDATE_INT ),
				'nt_OperationStatus' => filter_var ( $this->input->post ( 'nt_OperationStatus' ), FILTER_VALIDATE_INT ),
				'nt_OperationPaid' => filter_var ( $this->input->post ( 'nt_OperationPaid' ), FILTER_VALIDATE_INT ),
				'nt_OperationReturn' => filter_var ( $this->input->post ( 'nt_OperationReturn' ), FILTER_VALIDATE_INT ),
				'nt_OperationReject' => filter_var ( $this->input->post ( 'nt_OperationReject' ), FILTER_VALIDATE_INT ),
				'nt_OperationDate' => filter_var ( $this->input->post ( 'nt_OperationDate' ), FILTER_VALIDATE_INT ),
				'nt_OperationInvoiceRequest' => filter_var ( $this->input->post ( 'nt_OperationInvoiceRequest' ), FILTER_VALIDATE_INT ),
				'nt_OperationExternalAccount' => filter_var ( $this->input->post ( 'nt_OperationExternalAccount' ), FILTER_VALIDATE_INT ),
				'nt_InviteNew' => filter_var ( $this->input->post ( 'nt_InviteNew' ), FILTER_VALIDATE_INT ),
				'nt_InviteStatus' => filter_var ( $this->input->post ( 'nt_InviteStatus' ), FILTER_VALIDATE_INT ),
				'nt_DocumentStatementReady' => filter_var ( $this->input->post ( 'nt_DocumentStatementReady' ), FILTER_VALIDATE_INT ),
				'nt_SupportTicketStatus' => filter_var ( $this->input->post ( 'nt_SupportTicketStatus' ), FILTER_VALIDATE_INT ),
				'nt_SupportReply' => filter_var ( $this->input->post ( 'nt_SupportReply' ), FILTER_VALIDATE_INT ),
			];
			$this->load->model ( 'Settings_model', 'conf' );
			$res = $this->conf->updateNotifications ( $data, $id, $this->env );
			if ( $res ) {
				header ( 'HTTP/1.0 200 Configuración guardada con éxito' );
				echo json_encode ( [ 'code' => '200', 'message' => 'Configuración guardada con éxito', 'details' => $res[ 'message' ] ] );
			} else {
				header ( 'HTTP/1.0 500 Internal Server Error' );
				echo json_encode ( [ 'code' => '500', 'message' => 'No se pudo guardar la configuración' ] );
			}
		}
		/**
		 * @param       $insertId
		 * @param array $args
		 * @param       $id
		 *
		 * @return array
		 */
		public function NewSubscriptionCharge ( $insertId, array $args, $id ): array {
			$args[ 'cardRecordID' ] = $insertId;
			$args[ 'amount' ] = $this->amount;
			$payment = $this->dataOp->SendNewSubscription ( $args, $this->env );
			$args[ 'payment' ] = $payment;
			return $this->dataOp->SuccessfulSubscription2 ( $args, $id, $this->env );
		}
	}
