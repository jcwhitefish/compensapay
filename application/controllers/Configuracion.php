<?php
use /application/models/Settings_model::;

class Configuracion extends \MY_Loggedin {
	private int $amount = 600;
	public function index(){
		$this->load->model('Openpay_model','dataOP');
		$this->load->model('Settings_model' , 'dataConf');
		$id = $this->session->userdata('id');
		$conf['card'] = $this->dataOP->getActiveCard($id);
		$conf['notifications'] = $this->dataConf->getNotificationsSettings($id);
		$data['main'] = $this->load->view('configuracion', $conf, true);
		$this->load->view('plantilla', $data);
	}

	public function newSubscription(){
		$this->load->model('Openpay_model', 'dataOp');

		$id = $this->session->userdata('id');
		$customerDAta = $this->dataOp->NewClient($id, 'SANDBOX');

		$args = [
			'card_number' => $this->input->post('cardNumber'),
			'holder_name' => $this->input->post('holderName'),
			'expiration_year' => $this->input->post('expirationYear'),
			'expiration_month' => $this->input->post('expirationMonth'),
			'cvv' => $this->input->post('cvv'),
			'session_id' => $this->input->post('sessionID'),
			'customer_id' => $customerDAta['id'],
			'cardType' => $this->input->post('cardType'),
		];

		$cardData = $this->dataOp->NewCard($args, 'SANDBOX');
		if (!empty($cardData['code'])){
			echo json_encode($cardData);
			return false;
		}

		if ($cardData > 0){
			$args['cardRecordID'] =  $cardData;
			$args['amount'] = $this->amount;
			$payment = $this->dataOp->NewCharge($args, $id,'SANDBOX');
			$args['payment'] = $payment;
			echo json_encode($this->dataOp->SuccessfulSubscription($args, $id, 'SANDBOX'));
			return true;
		}
		return false;
	}

	public function changeCard(){
		$this->load->model('Openpay_model', 'dataOp');
		$id = $this->session->userdata('id');
		$subs =  $this->dataOp->getSubscription($id, 'SANDBOX');
		$subs = $subs[0];
		var_dump($subs);
		$args = [
			'card_number' => $this->input->post('cardNumber'),
			'holder_name' => $this->input->post('holderName'),
			'expiration_year' => $this->input->post('expirationYear'),
			'expiration_month' => $this->input->post('expirationMonth'),
			'cvv' => $this->input->post('cvv'),
			'session_id' => $this->input->post('sessionID'),
			'customer_id' => $subs['customer_id'],
			'cardType' => $this->input->post('cardType'),
		];
		$cardData = $this->dataOp->NewCard($args, 'SANDBOX');

		if (!empty($cardData['code'])){
			echo json_encode($cardData);
			return false;
		}

		if ($cardData > 0){
			$args['cardRecordID'] =  $cardData;
			$args['amount'] = $this->amount;
			if (strtotime('NOW') <= $subs['nextPay'] ){
				$subsData= $this->dataOp->DeleteCard($args, $subs['card_id'], 'SANDBOX');
				var_dump('aun no hay que pagar');
			}else{
				var_dump('Se hace el cobro');
			}
//			$payment = $this->dataOp->NewCharge($args, $id,'SANDBOX');
//			$args['payment'] = $payment;
//			echo json_encode($this->dataOp->SuccessfulSubscription($args, $id, 'SANDBOX'));
//			return true;
		}

		var_dump($subs);
		die();
		$subsData= $this->dataOp->DeleteCard($id, 'SANDBOX');
		var_dump($subsData);
		if ($subsData != 0){
			$cardNumber = $this->input->post('cardNumber');
			$holderName = $this->input->post('holderName');
			$expirationMonth = $this->input->post('expirationMonth');
			$expirationYear = $this->input->post('expirationYear');
			$cvv = $this->input->post('cvv');
			$sessionId = $this->input->post('sessionID');
			$cardType = $this->input->post('cardType');
			$customerID =$subsData['customer_id'];
			$recordId = $subsData['record_id'];
			$args = [
				'card_number' => $cardNumber,
				'holder_name' => $holderName,
				'expiration_year' => $expirationYear,
				'expiration_month' => $expirationMonth,
				'cvv' => $cvv,
				'session_id' => $sessionId,
				'cardType' => $cardType,
				'customer_id' => $customerID,
				'recordId' => $recordId,
			];
			$cardData = $this->dataOp->NewCard($args, 'SANDBOX');
			if ($cardData > 0){
				$args['cardRecordID'] =  $cardData;
				$args['amount'] = $this->amount;
				$subscription = $this->dataOp->NewCharge($args, $id,'SANDBOX');
				echo(json_encode($subscription));
				return true;
			}
		}
	}
	public function saveChanges(){
		$data = [
			'nt_OperationNew' => filter_var($this->input->post('nt_OperationNew'), FILTER_VALIDATE_INT),
			'nt_OperationApproved' => filter_var($this->input->post('nt_OperationApproved'), FILTER_VALIDATE_INT),
			'nt_OperationStatus' => filter_var($this->input->post('nt_OperationStatus'), FILTER_VALIDATE_INT),
			'nt_OperationPaid' => filter_var($this->input->post('nt_OperationPaid'), FILTER_VALIDATE_INT),
			'nt_OperationReturn' => filter_var($this->input->post('nt_OperationReturn'), FILTER_VALIDATE_INT),
			'nt_OperationReject' => filter_var($this->input->post('nt_OperationReject'), FILTER_VALIDATE_INT),
			'nt_OperationDate' => filter_var($this->input->post('nt_OperationDate'), FILTER_VALIDATE_INT),
			'nt_OperationInvoiceRequest' => filter_var($this->input->post('nt_OperationInvoiceRequest'), FILTER_VALIDATE_INT),
			'nt_OperationExternalAccount' => filter_var($this->input->post('nt_OperationExternalAccount'), FILTER_VALIDATE_INT),
			'nt_InviteNew' => filter_var($this->input->post('nt_InviteNew'), FILTER_VALIDATE_INT),
			'nt_InviteStatus' => filter_var($this->input->post('nt_InviteStatus'), FILTER_VALIDATE_INT),
			'nt_DocumentStatementReady' => filter_var($this->input->post('nt_DocumentStatementReady'), FILTER_VALIDATE_INT),
			'nt_SupportTicketStatus' => filter_var($this->input->post('nt_SupportTicketStatus'), FILTER_VALIDATE_INT),
			'nt_SupportReply' => filter_var($this->input->post('nt_SupportReply'), FILTER_VALIDATE_INT),
		];
		var_dump($data);
		$settings = new Settings;
		$settings->updateNotifications($data, 'SANDBOX');

	}
}
