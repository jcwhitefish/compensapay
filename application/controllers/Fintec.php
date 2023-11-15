<?php

class Fintec extends MY_Loggedout{
	public function createLog ($logname, $message){
//		$logDir = '/home/compensatest/logs/';
		$logDir = 'C:\web\logs\\';
		$this->logFile = fopen($logDir . $logname.'.log', 'a+');
		if ($this->logFile !== FALSE) {
			fwrite($this->logFile, '|'.date('Y-m-d H:i:s').'|   '.$message. "\r\n");
			fclose($this->logFile);
		}
	}
	public function getEvents() {
		$this->load->model('response');
		$error = 0;
		$resp = ["response" => 'ok'];
		if (Request::getStaticMethod() == 'POST' && ($body = Request::getBody())) {
			$this->createLog('ping', json_encode($body, JSON_PRETTY_PRINT));
			$this->load->model('Arteria_model','dataArt');
			$data = $body ?? NULL;
			if ($data['object_type'] === 'transaction' && $data['data']['type']  === 'deposit') {
				$args = [
					'trakingKeyReceived' => $data['data']['reference_number'],
					'trakingKeySend' => NULL,
					'arteriaId' => $data['id'],
					'amount' => $data['data']['amount'],
					'descriptor' => $data['data']['descriptor'],
					'sourceBank' => substr($data['data']['source']['account_number'], 0, 3),
					'receiverBank' => substr($data['data']['destination']['account_number'], 0, 3),
					'sourceRfc' => $data['data']['source']['rfc'],
					'receiverRfc' => $data['data']['destination']['rfc'],
					'sourceClabe' => $data['data']['source']['account_number'],
					'receiverClabe' => $data['data']['destination']['account_number'],
					'transactionDate' => $data['data']['created_at'],
				];
				$res = $this->dataArt->AddMovement($args, 'SANDBOX');
				if ($res){
					if ($op = $this->dataArt->SearchOperations($args, 'SANDBOX')){
						$exitMoney = $op['exitD'] === NULL || $op['exitD'] === '' || empty($op['exitD']) ? $op['exitF'] : $op['exitD'];
						if ($op['operationNumber'] != $args['trakingKeyReceived']){
							$rollback = [
								'clabe' => $args['sourceClabe'],
								'amount' => $args['amount'],
								'descriptor' => 'Devolucion por referencia no encontrada',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $args['trakingKeyReceived'].'01',
							];
							$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
							$this->createLog('CreateTransfer', json_encode($back, JSON_PRETTY_PRINT));
							if ($back){
								$argsR = [
									'trakingKeyReceived' => $data['data']['tracking_key'],
									'trakingKeySend' => $rollback['idempotency_key'],
									'arteriaId' => $back['id'],
									'amount' => $back['amount'],
									'descriptor' => $back['descriptor'],
									'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
									'receiverBank' => substr($data['data']['source']['account_number'], 0, 3),
									'sourceRfc' => $data['data']['destination']['rfc'],
									'receiverRfc' => $data['data']['source']['rfc'],
									'sourceClabe' => $data['data']['destination']['account_number'],
									'receiverClabe' => $data['data']['source']['account_number'],
									'transactionDate' => $back['created_at'],
								];
								$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
								return $this->response->sendResponse(["response" => 'Operación correcta err 1'], $error);
							}
						}else if (($op['entry']) != $args['amount']){
							$rollback = [
								'clabe' => $args['sourceClabe'],
								'amount' => $args['amount'],
								'descriptor' => 'Devolucion por monto incorrecto',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $args['trakingKeyReceived'].'03',
							];
							$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
							$this->createLog('CreateTransfer', json_encode($back, JSON_PRETTY_PRINT));
							if ($back){
								$argsR = [
									'trakingKeyReceived' => $data['data']['tracking_key'],
									'trakingKeySend' => $rollback['idempotency_key'],
									'arteriaId' => $back['id'],
									'amount' => $back['amount'],
									'descriptor' => $back['descriptor'],
									'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
									'receiverBank' => substr($data['data']['source']['account_number'], 0, 3),
									'sourceRfc' => $data['data']['destination']['rfc'],
									'receiverRfc' => $data['data']['source']['rfc'],
									'sourceClabe' => $data['data']['destination']['account_number'],
									'receiverClabe' => $data['data']['source']['account_number'],
									'transactionDate' => $back['created_at'],
								];
								$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
								return $this->response->sendResponse(["response" => 'Operación correcta err 2'], $error);

							}
						}else{
							//====| Comenzamos a enviar el dinero del cliente |=====
							$clientT = [
								'clabe' => $args['sourceClabe'],
								'amount' => $exitMoney,
								'descriptor' => 'Pago por '.$op['uuid'],
								'name' => $data['data']['source']['name'],
								'idempotency_key' => rand(1000000,9999999),
							];
							$transferCliente = json_decode($this->dataArt->CreateTransfer($clientT, 'SANDBOX'), true);
							$this->createLog('CreateTransfer', 'Send ->'.json_encode($clientT, JSON_PRETTY_PRINT));
							$this->createLog('CreateTransfer', 'Response ->'.json_encode($transferCliente, JSON_PRETTY_PRINT));
							$argsR = [
								'trakingKeyReceived' => $data['data']['reference_number'],
								'trakingKeySend' => $clientT['idempotency_key'],
								'arteriaId' => $transferCliente['id'],
								'amount' => ($exitMoney),
								'descriptor' => 'Pago por '.$op['uuid'],
								'sourceBank' => $data['data']['destination']['bank_code'],
								'receiverBank' => $data['data']['source']['bank_code'],
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['source']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $data['data']['source']['account_number'],
								'transactionDate' => $transferCliente['created_at'],
							];
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
							//====| Comenzamos a enviar el dinero del proveedor |=====
							$amountP = $op['entry']-$exitMoney;
//							var_dump($amountP);
							$provedor = [
								'clabe' => $op['companyClabe'],
								'amount' => $amountP,
								'descriptor' => 'Movimiento entre cuentas',
								'name' => $op['companyName'],
								'idempotency_key' => rand(1000000,9999999),
							];
//							var_dump($provedor);
							$prov = json_decode($this->dataArt->CreateTransfer($provedor, 'SANDBOX'), true);
							$this->createLog('CreateTransfer', 'Send ->'.json_encode($provedor, JSON_PRETTY_PRINT));
							$this->createLog('CreateTransfer', 'Response ->'.json_encode($prov, JSON_PRETTY_PRINT));
							$argsR = [
								'trakingKeyReceived' => $data['data']['reference_number'],
								'trakingKeySend' => $provedor['idempotency_key'],
								'arteriaId' => $prov['id'],
								'amount' => $amountP,
								'descriptor' => 'Movimiento entre cuentas',
								'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
								'receiverBank' => substr($op['companyBank'], 0, 3),
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['destination']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $op['companyClabe'],
								'transactionDate' => $prov['created_at'],
							];
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
//							$this->load->helper('sendmail_helper');
							return $this->response->sendResponse(["response" => 'Operación correcta'], $error);
						}
					}
				}
			}
		}
		return $this->response->sendResponse($resp, $error);
	}
	public function getCEP(){
		$args = [
			'tipoCriterio' => 'T',
			'receptorParticipante' => 0,
			'captcha' => 'c',
			'tipoConsulta' => 1,
			'fecha' => '15-10-2021',
			'criterio' => 'CUENCA180822236927',
			'emisor' => '90646',
			'receptor' => '40012',
			'cuenta' => '012180015782098848',
			'monto' => '16000.00'
		];
		$this->load->model('Arteria_model', 'dataArt');
		$res = $this->dataArt->DownloadCEP($args, 'SANDBOX');

	}
	/**
	 * @param string $texto texto a encriptar
	 * @param string $key llave que será usada en la encriptación y necesaria para desencriptar
	 * @return string Devuelve el texto encriptado
	 */
	function encriptar(string $texto, string $key){
		return base64_encode($texto.'-'.$key);
		//return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $texto, MCRYPT_MODE_CBC, md5(md5($key))));
	}
	function desencriptar(string $texto, string $key){
		return base64_decode($texto.$key);
		//return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($texto), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	}

}
