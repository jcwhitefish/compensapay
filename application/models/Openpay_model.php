<?php
class Openpay_model extends CI_Model
{
	private string $environment = 'SANDBOX';
	private string $openPaySandbox = 'https://sandbox-api.openpay.mx/v1';
	private string $openPayLive = '';
	private string $customerID = 'mhcmkrgyxbjfw9vb9cqc';
	private string $usernameSandbox = 'sk_10a295f448a043a9ab582aa200552647';
	private string $passwordSandbox = '';
	private string $usernameProd = '';
	private string $passwordProd = '';
	private array $headers = [];
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function SendNewClient(array $args){
		$request = [
			'name' => $args['name'],
			'email' => $args['email'],
			'requires_account' => FALSE,
		];
		$endpoint = $this->customerID.'/customers';
		return $this->sendRequest($endpoint, $request, 'SANDBOX', 'POST', 'JSON');
	}
	public function SendNewSubscription(array $args){
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
		$endpoint = $this->customerID.'/customers/'.$args['customer_id'].'/subscriptions';
		return $this->sendRequest($endpoint, $request, 'SANDBOX', 'POST', 'JSON');
	}
	public function SendnewCard(array $args){
		$request = [
			'card_number' => $args['card_number'],
			'holder_name' => $args['holder_name'],
			'expiration_year' => $args['expiration_year'],
			'expiration_month' => $args['expiration_month'],
			'cvv2' => $args['cvv'],
			'device_session_id' => $args['session_id']
		];
		$endpoint = $this->customerID.'/customers/'.$args['customer_id'].'/cards';
		return $this->sendRequest($endpoint, $request, 'SANDBOX', 'POST', 'JSON');
	}
	public function SenddeleteCard(array $args){
		$endpoint = $this->customerID.'/customers/'.$args['customer_id'].'/cards/'.$args['card_id'];
		return $this->sendRequest($endpoint, null, 'SANDBOX', 'DELETE', NULL);
	}
	private function SendRequest(string $endpoint, $data, ?string $env, ?string $method, ?string $dataType) {
		$env = strtoupper($env) ?? 'SANDBOX';
		$url = ($env == 'SANDBOX') ? $this->openPaySandbox : $this->openPayLive;
		$method = !empty($method) ? strtoupper($method) : 'POST';
		$resp = ['error' => 500, 'error_description' => 'AxadataCloudTransport'];
		$data = json_encode($data);
		$method = strtoupper($method) ?? 'POST';
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
			$error = ($code == 200) ? 0 : $code;
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
