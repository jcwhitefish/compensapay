<?php

class Configuracion extends MY_Loggedin{
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
		$custumerDAta = $this->dataOp->NewClient(1, 'SANDBOX');

		$customerId = $custumerDAta['custumerId'];
		$recordId = $custumerDAta['recordId'];
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
			$subcription = $this->dataOp->NewSubscription($args, 'SANDBOX');
			echo(json_encode($subcription));
			return true;
		}
		return false;
	}

	public function prueba(){
		echo json_encode(array('message' => 'hola'));
	}
}
