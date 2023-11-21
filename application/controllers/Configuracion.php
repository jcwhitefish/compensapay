<?php

class Configuracion extends MY_Loggedin{
	private $amount = 600;
	public function index(){
		$this->load->model('Openpay_model','dataOP');
		$id = $this->session->userdata('id');
		$card['card'] = $this->dataOP->getActiveCard($id);
		$data['main'] = $this->load->view('configuracion',$card, true);
		$this->load->view('plantilla', $data);
	}

	public function newSubscription(){
		$this->load->model('Openpay_model', 'dataOp');

		$id = $this->session->userdata('id');
		$customerDAta = $this->dataOp->NewClient($id, 'SANDBOX');

		$customerId = $customerDAta['customerId'];
		$recordId = $customerDAta['recordId'];
		$cardNumber = $this->input->post('cardNumber');
		$holderName = $this->input->post('holderName');
		$expirationMonth = $this->input->post('expirationMonth');
		$expirationYear = $this->input->post('expirationYear');
		$cvv = $this->input->post('cvv');
		$sessionId = $this->input->post('sessionID');
		$cardType = $this->input->post('cardType');
		$args = [
			'card_number' => $cardNumber,
			'holder_name' => $holderName,
			'expiration_year' => $expirationYear,
			'expiration_month' => $expirationMonth,
			'cvv' => $cvv,
			'session_id' => $sessionId,
			'customer_id' => $customerId,
			'recordId' => $recordId,
			'cardType' => $cardType,
		];
//		var_dump($args);
		$cardData = $this->dataOp->NewCard($args, 'SANDBOX');
//		die(json_encode($cardData));
		if ($cardData > 0){
			$args['cardRecordID'] =  $cardData;
			$args['amount'] = $this->amount;
			$subscription = $this->dataOp->NewCharge($args, $id,'SANDBOX');
			echo(json_encode($subscription));
			return true;
		}
		return false;
	}

	public function changeCard(){
		$this->load->model('Openpay_model', 'dataOp');
		$id = $this->session->userdata('id');
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
}
