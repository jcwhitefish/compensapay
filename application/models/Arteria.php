<?php

class Arteria extends CI_Model
{
	private $environment = 'SANDBOX';
	private $ArteriaSandbox = 'https://sandbox-api.arteria.xyz/';
	private $ArteriaLive = '';

	private $usernameSandbox = 'AKsbIRh8GhQA--avQliNyzGQ';
	private $passwordSandbox = 'bRQCqvlR7r0BbLSa2JV1Qf1PM-YPbDSLzsiQhxfer-T9fTG0a-zKO0BcjrCwH6XsdSLp9nUo0mCdYDxzo8KdIA';

	private $usernameProd = 'mhcmkrgyxbjfw9vb9cqc';
	private $passwordProd = 'sk_10a295f448a043a9ab582aa200552647';
	private $headers = [
		'Content-Type: application/json; charset=utf-8',
	];

	public function createClabe($args){
		$state = $country = '';
		$birthDate = date('Y-m-d', strtotime($args['birthDate']));

		$data = [
			'names' => $args['name'],
			'first_surname' => $args['lastname'],
			'second_surname' => $args['surname'],
			'date_of_birth' => $birthDate,
			'state_of_birth' => $state,
			'country_of_birth' => $country,
			'gender' => $args
		];
	}
	private function sendRequest(string $endpoint, array $data,
								 ?string $data_type, ?string $env, ?string $method, ?string $host,
		&$error = 0) {
		$data_type ?: 'string';
		$env = strtoupper($env) ?? 'SANDBOX';
		$method = strtoupper($method) ?? 'POST';
		$url = ($env == 'SANDBOX') ? $this->ArteriaSandbox : $this->ArteriaLive;
		$secret=base64_encode(($env == 'SANDBOX') ? $this->usernameSandbox.':'.$this->passwordSandbox :
			$this->usernameProd.':'.$this->passwordProd);
		if ($data_type != 'array') {
			$data = json_encode($data);
			$this->headers[] = 'Content-Length: ' . strlen($data);
		}
		$this->headers[] = 'Authorization: Basic '.$secret;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);
		curl_setopt($ch, CURLOPT_URL, "{$url}/{$endpoint}/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 200);
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
		} else {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		}
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

		$response = curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = ($code == 200) ? 0 : $code;

		if ($response === false) {
			$error = 500;
			curl_close($ch);
			$resp = ['error' => 500, 'error_description' => 'SAPLocalTransport'];
			$response = json_encode($resp);
		}
		curl_close($ch);

		return $response;
	}

}
