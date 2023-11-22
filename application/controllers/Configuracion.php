<?php

class Configuracion extends MY_Loggedin{
	private int $amount = 600;
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
}
