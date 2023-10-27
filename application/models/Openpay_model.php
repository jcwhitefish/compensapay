<?php
class Openpay_model extends CI_Model
{
	private string $openPaySandbox = 'https://sandbox-api.openpay.mx/v1';
	private string $openPayLive = '';
	private string $customerIDSandBox = 'mhcmkrgyxbjfw9vb9cqc';
	private string $customerIDProd = '';
	private string $planIdSandbox = 'pvnhncnq55gwfjulrbiq';
	private string $planIdProd = '';
	private string $usernameSandbox = 'sk_10a295f448a043a9ab582aa200552647';
	private string $usernameProd = '';
	private string $passwordSandbox = '';
	private string $passwordProd = '';
	private array $headers = [];

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function NewClient($id, string $env = 'SANDBOX'){
		$data = [];
		$prevPay = strtotime("now");
		$nextPay = strtotime('+1 month' );
		$query = "SELECT name, last_name, email FROM compensapay.users WHERE id = '{$id}'";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row){
					$data = [
						'name'        => $row['name'].' '.$row['last_name'],
						'email'     => $row['email'],
					];
				}
				$res = json_decode($this->SendNewClient($data, $env), true);
				$query = "INSERT INTO compensapay.subscription (company_id, customer_id, prevPay, nextPay, dealings, statusSupplier)
							VALUES ('{$id}','{$res['id']}', '{$prevPay}', '{$nextPay}',300,1)";
				if ($this->db->query($query)){
					$id = $this->db->insert_id();
					return ['customerId' =>$res['id'], 'recordId' => $id];
				}
			}
		}
		return false;
	}
	public function SendNewClient(array $args,  string $env){
		$request = [
			'name' => $args['name'],
			'email' => $args['email'],
			'requires_account' => FALSE,
		];
		$custommer = strtoupper($env) === 'SANDBOX' ? $this->customerIDSandBox : $this->customerIDProd;
		$endpoint = $custommer.'/customers/';
		$this->headers=[];
		return $this->sendRequest($endpoint, $request, 'SANDBOX', 'POST', 'JSON');
	}
	public function NewSubscription(array $args, string $env = 'SANDBOX'){
		$args['plan_id'] = (strtoupper($env) == 'SANDBOX') ? $this->planIdSandbox : $this->planIdProd;
		$res = json_decode($this->SendNewSubscription($args, $env), true);
		if (!empty($res['id'])){
			$query = "UPDATE compensapay.subscription SET subscriptionOp_id = '{$res['id']}', active = 1 WHERE id = '{$args['recordId']}'";
			if ($this->db->query($query)){
				$query = "INSERT INTO compensapay.payments (subscription_id, card_id, amount) VALUES ('{$args['recordId']}', '{$args['cardRecordID']}',300)";
				if ($this->db->query($query)){
					$endCard = substr($args['card_number'], -4);
					$monthText = $this->monthTranslate($args['expiration_month']);
					return [
						'endCard' => $endCard,
						'month' =>  $monthText,
						'year' => $args['expiration_year'],
						'type' => $args['cardType'],
					];
				}
			}
		}else{
			return $res;
		}
		return -1;
	}
	public function SendNewSubscription(array $args, string $env){
		$request = [
			'card' => [
				'card_number' => $args['card_number'],
				'holder_name' => $args['holder_name'],
				'expiration_year' => $args['expiration_year'],
				'expiration_month' => $args['expiration_month'],
				'cvv2' => $args['cvv'],
				'device_session_id' => $args['session_id']
			],
			'plan_id' => $args['plan_id'],
		];
		$this->headers=[];
		$custommer = strtoupper($env) === 'SANDBOX' ? $this->customerIDSandBox : $this->customerIDProd;
		$endpoint = $custommer.'/customers/'.$args['customer_id'].'/subscriptions';
		return $this->sendRequest($endpoint, $request, 'SANDBOX', 'POST', 'JSON');
	}
	public function NewCard(array $args, string $env = 'SANDBOX'){
		$res = json_decode($this->SendNewCard($args, $env), true);
//		var_dump($res);
		if (!empty($res['id'])){
			$endCard = substr($args['card_number'], -4);
			$query = "INSERT INTO compensapay.cards (cardType_id, openpay_id, year, month, endCard, active) 
					VALUES ((SELECT id FROM compensapay.cat_cardtype WHERE type = '{$args['cardType']}'), '{$res['id']}', '{$args['expiration_year']}', '{$args['expiration_month']}', '{$endCard}', 1)";
			if ($this->db->query($query)){
				$id = $this->db->insert_id();
				$query = "UPDATE compensapay.subscription set card_id = '{$id}' 
					WHERE id = '{$args['recordId']}'";
				if ($this->db->query($query)){
					return $id;
				}else{
					return -2;
				}
			}else{
				return -1;
			}
		}
		return $res;
	}
	public function SendNewCard(array $args, string $env){
		$request = [
			'card_number' => $args['card_number'],
			'holder_name' => $args['holder_name'],
			'expiration_year' => $args['expiration_year'],
			'expiration_month' => $args['expiration_month'],
			'cvv2' => $args['cvv'],
			'device_session_id' => $args['session_id']
		];
		$custommer = strtoupper($env) === 'SANDBOX' ? $this->customerIDSandBox : $this->customerIDProd;
		$endpoint = $custommer.'/customers/'.$args['customer_id'].'/cards';
		$this->headers=[];
		return $this->sendRequest($endpoint, $request, 'SANDBOX', 'POST', 'JSON');
	}
	public function DeleteCard(int $id, string $env = 'SANDBOX'){
		$card = $this->getActiveCard($id);
		$args = [
			'customer_id' => $card['customer_id'],
			'card_id' => $card['openpay_id']
		];
		$res = $this->SendDeleteCard($args,$env);
		var_dump($res);
		if($res===''){
			$query = "UPDATE compensapay.cards SET active = 0 WHERE openpay_id ='{$args['openpay_id']}'";
			if ($this->db->query($query)){
				$query = "UPDATE compensapay.subscription SET card_id = NULL, active=0 WHERE id = '{$card['record_id']}'";
				if ($this->db->query($query)){
					return $card;
				}
			}
		}
		return 0;
	}

	/**
	 * @param array $args customer_id & card_id
	 * @param string $env Environment
	 * @return mixed|string
	 */
	public function SendDeleteCard(array $args, string $env = 'SANDBOX'){
		$custommer = strtoupper($env) === 'SANDBOX' ? $this->customerIDSandBox : $this->customerIDProd;
		$endpoint = $custommer.'/customers/'.$args['customer_id'].'/cards/'.$args['card_id'];
		return $this->sendRequest($endpoint, null, 'SANDBOX', 'DELETE', NULL);
	}
	public function getActiveCard(int $id){
		$card = [];
		$query = "SELECT t1.id, t1.customer_id, t2.endCard, t2.month, t2.year, t2.openpay_id, t3.type, t3.img_url
			FROM compensapay.subscription t1
			    INNER JOIN compensapay.cards t2 ON t1.card_id = t2.id
			    INNER JOIN compensapay.cat_cardtype t3 ON t2.cardType_id = t3.id
			    WHERE t1.company_id = '{$id}' AND t1.active = 1 AND t2.active = 1";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row){
					$monthName = $this->monthTranslate($row['month']);
					$card = [
						'record_id'=> $row['id'],
						'endCard' => $row['endCard'],
						'month' => $monthName,
						'year' => $row['year'],
						'type' => $row['type'],
						'openpay_id' => $row['openpay_id'],
						'customer_id' => $row['customer_id'],
						];
				}
				return $card;
			}
		}
		return false;
	}
	public function NewCharge(array $args, int $id, string $env = 'SANDBOX') {
		$query = "SELECT openpay_id FROM compensapay.cards WHERE id = '{$args['cardRecordID']}'";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				foreach ($result->result_array() as $row) {
					$args['openCardId'] = $row['openpay_id'];
				}
				$query = "SELECT name, last_name, email FROM compensapay.users WHERE id = '{$id}'";
				if ($result = $this->db->query($query)) {
					if ($result->num_rows() > 0) {
						foreach ($result->result_array() as $row) {
							$args['clientName'] = $row['name'];
							$args['email'] = $row['email'];
						}
						$args['orderId'] = 'SB-'.str_pad($id, 5, "0", STR_PAD_LEFT).strtotime("now");
						$res = $this->SendCharges($args, $env);
						var_dump($res);
						return $res;
					}
				}
			}
		}
		return false;
	}
	public function SendCharges(array $args, $env){
		$data = [
			'source_id' => $args['openCardId'],
			'method' => 'card',
			'amount' => $args['amount'],
			'currency' => 'USD',
			'description'=> 'Cargo de suscripcion',
			'order_id' => $args['orderId'],
			'device_session_id' => $args['session_id'],
			'customer'=>[
				'name' => $args['clientName'],
				'email' => $args['email']
			],
		];
		var_dump($data);
		$this->headers=[];
		$custommer = strtoupper($env) === 'SANDBOX' ? $this->customerIDSandBox : $this->customerIDProd;
		$endpoint = $custommer.'/charges';
		return $this->sendRequest($endpoint, $data, 'SANDBOX', 'POST', 'JSON');
	}
	private function monthTranslate(int $month){
		$text = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
		return $text[intval($month-1)];
	}
	private function SendRequest(string $endpoint, $data, ?string $env, ?string $method, ?string $dataType) {
		$env = strtoupper($env) ?? 'SANDBOX';
		$url = ($env == 'SANDBOX') ? $this->openPaySandbox : $this->openPayLive;
		$method = !empty($method) ? strtoupper($method) : 'POST';
		$resp = ['error' => 500, 'error_description' => 'OpenPayTransport'];
		$data = json_encode($data);
		$method = strtoupper($method) ?? 'POST';
		if (strtoupper($dataType) === 'JSON'){
			$this->headers[] = 'Content-Type: application/json; charset=utf-8';
		}
		$secret=base64_encode(($env == 'SANDBOX') ? $this->usernameSandbox.':'.$this->passwordSandbox :
			$this->usernameProd.':'.$this->passwordProd);
		$this->headers[] = 'Authorization: Basic '.$secret;
		var_dump("$url/$endpoint/");
		var_dump($data);

		if (($ch = curl_init())) {
			curl_setopt($ch, CURLOPT_URL, "$url/$endpoint/");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 200);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			if ($method == 'POST') {
				curl_setopt($ch, CURLOPT_POST, true);
			} else {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);

			$response = curl_exec($ch);
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($response === false) {
				$error = 500;
				curl_close($ch);
				$resp = ['error' => 500, 'error_description' => 'SAPLocalTransport'];
				$response = json_encode($resp);
			}
			curl_close($ch);
			return $response;

		}else {
			$resp['reason'] = 'No se pudo inicializar cURL';
			$response = json_encode($resp);
		}
		return $response;
	}
}
