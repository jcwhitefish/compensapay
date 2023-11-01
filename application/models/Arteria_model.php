<?php

class Arteria_model extends CI_Model{
	private $ArteriaSandbox = 'https://sandbox-api.arteria.xyz';
	private $ArteriaLive = '';
	private $usernameSandbox = 'AKsbIRh8GhQA--avQliNyzGQ';
	private $passwordSandbox = 'bRQCqvlR7r0BbLSa2JV1Qf1PM-YPbDSLzsiQhxfer-T9fTG0a-zKO0BcjrCwH6XsdSLp9nUo0mCdYDxzo8KdIA';
	private $usernameProd = '';
	private $passwordProd = '';
	private $headers = [];
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function CreateClabe(array $args, string $env){
		$data = [
			'names' => $args['name'],
			'first_surname' => $args['lastname'],
		];
		$endpoint = 'clabes';
		return $this->SendRequest($endpoint, $data, $env, 'POST', 'JSON');
	}
	public function CreateTransfer(array $args, string $env){
		$data = [
			'account_number' => $args['name'],
			'amount' => $args['lastname'],
			'descriptor' => $args['descriptor'],
			'recipient_name' => $args[''],
			'idempotency_key' => $args['idempotency_key'],
		];
		$endpoint = 'transfers';
		return $this->SendRequest($endpoint, $data, $env, 'POST', 'JSON');
	}
	public function AddMovement(array $args, string $env){
		$query = "INSERT INTO compensapay.balance (trakig_key, arteriaD_id, amount, descriptor, 
                                 source_bank, receiver_bank, source_rfc, receiver_rfc, 
                                 source_clabe, receiver_clabe, transaction_date) 
					VALUES ('{$args['trakingKey']}', '{$args['arteriaId']}', '{$args['amount']}', '{$args['descriptor']}', 
					        '{$args['sourceBank']}', '{$args['receiverBank']}', '{$args['sourceRfc']}', '{$args['receiverRfc']}', 
					        '{$args['sourceClabe']}', '{$args['receiverClabe']}', '{$args['transactionDate']}')";
		if($result = $this->db->query($query)){
			return $this->db->insert_id();
		}
		return false;
	}
	public function SearchOperations(array $args, string $env){
		$query = "";
	}
	function MakeTrackingKey(array $ids): string{
		$trash = 'GHIJKLMNOPQRSTUVWXYZ';
		$hash = '';
		for ($i = 0; $i < 3; $i++) {
			if($i <= 1){
				$hash .= str_pad(dechex($ids[$i]), 4, substr(str_shuffle($trash), 0, 4), STR_PAD_LEFT);
			}else{
				$hash .= str_pad(dechex($ids[$i]), 7, substr(str_shuffle($trash), 0, 7), STR_PAD_LEFT);
			}
		}
		return $hash;
	}
	private function SendRequest(string $endpoint, $data, ?string $env, ?string $method, ?string $dataType) {
		$env = strtoupper($env) ?? 'SANDBOX';
		$url = ($env == 'SANDBOX') ? $this->ArteriaSandbox : $this->ArteriaLive;
		$method = !empty($method) ? strtoupper($method) : 'POST';
		$resp = ['error' => 500, 'error_description' => 'OpenPayTransport'];
		$data = json_encode($data);
		if (strtoupper($dataType) === 'JSON'){
			$this->headers[] = 'Content-Type: application/json; charset=utf-8';
		}
		$secret=base64_encode(($env == 'SANDBOX') ? $this->usernameSandbox.':'.$this->passwordSandbox :
			$this->usernameProd.':'.$this->passwordProd);
		$this->headers[] = 'Authorization: Basic '.$secret;
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
