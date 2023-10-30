<?php

class Arteria extends CI_Model{
	private $ArteriaSandbox = 'https://sandbox-api.arteria.xyz';
	private $ArteriaLive = '';
	private $usernameSandbox = 'AKsbIRh8GhQA--avQliNyzGQ';
	private $passwordSandbox = 'bRQCqvlR7r0BbLSa2JV1Qf1PM-YPbDSLzsiQhxfer-T9fTG0a-zKO0BcjrCwH6XsdSLp9nUo0mCdYDxzo8KdIA';
	private $usernameProd = '';
	private $passwordProd = '';
	private $headers = [];
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
