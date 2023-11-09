<?php

class Fintec extends MY_Loggedout{
	public function createLog ($logname, $message){
		$logDir = '/var/www/logs/';
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
			$this->load->model('Arteria_model','dataArt');
			$data = $body ?? NULL;
			if ($data['object_type'] === 'transaction' && $data['data']['type']  === 'deposit') {
				$args = [
					'trakingKeyReceived' => $data['data']['tracking_key'],
					'trakingKeySend' => NULL,
					'arteriaId' => $data['_id'],
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
						if ($op['operationNumber'] != $args['trakingKeyReceived']){
							$rollback = [
								'clabe' => $args['sourceClabe'],
								'amount' => $args['amount'],
								'descriptor' => 'Devolucion por referencia no encontrada',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $data['data']['tracking_key'],
							];
							$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
							if ($back){
								$argsR = [
									'trakingKey' => $back['idempotency_key'],
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
//								var_dump($res);
								return $this->response->sendResponse(["response" => 'Devolucion por referencia'], $error);
							}
						}else if ((floatval($op['entry'])*100) != $args['amount']){
							$rollback = [
								'clabe' => $args['sourceClabe'],
								'amount' => $args['amount'],
								'descriptor' => 'Devolucion por monto incorrecto',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $args['trakingKey'].'02',
							];
							$back = json_decode($this->dataArt->CreateTransfer($rollback, 'SANDBOX'), true);
							if ($back){
								$argsR = [
									'trakingKey' => $back['idempotency_key'],
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
								return $this->response->sendResponse(["response" => 'Devolucion por monto'], $error);
							}
						}else{
							$amountP = (floatval($op['entry']) - floatval($op['exit']))*100;
							$provedor = [
								'clabe' => $op['companyClabe'],
								'amount' => $amountP,
								'descriptor' => 'Movimiento entre cuentas',
								'name' => $op['companyName'],
								'idempotency_key' => $this->encriptar($args['trakingKeyReceived'], $op['companyClabe']),
							];
							$prov = json_decode($this->dataArt->CreateTransfer($provedor, 'SANDBOX'), true);
							var_dump($prov);
							echo "<br><br>";
							$argsR = [
								'trakingKeyReceived' => $data['data']['tracking_key'],
								'trakingKeySend' => $this->encriptar($data['data']['tracking_key'], $op['companyClabe']),
								'arteriaId' => $prov['id'],
								'amount' => $prov['amount'],
								'descriptor' => 'Movimiento entre cuentas',
								'sourceBank' => substr($data['data']['destination']['account_number'], 0, 3),
								'receiverBank' => substr($op['companyBank'], 0, 3),
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['destination']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $op['companyClabe'],
								'transactionDate' => $prov['created_at'],
							];
							var_dump($argsR);
							die();
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');
							$clientT = [
								'clabe' => $args['sourceClabe'],
								'amount' => (floatval($op['exit'])*100),
								'descriptor' => 'Pago ',
								'name' => $data['data']['source']['name'],
								'idempotency_key' => $this->encriptar($data['data']['tracking_key'], $data['data']['destination']['account_number']),
							];
							$transferCliente = json_decode($this->dataArt->CreateTransfer($clientT, 'SANDBOX'), true);
							$argsR = [
								'trakingKeyReceived' => $data['data']['tracking_key'],
								'trakingKeySend' => $this->encriptar($data['data']['tracking_key'], $data['data']['destination']['account_number']),
								'arteriaId' => $transferCliente['id'],
								'amount' => ($op['exit'])*100,
								'descriptor' => 'Pago ',
								'sourceBank' => $data['data']['destination']['bank_code'],
								'receiverBank' => $data['data']['source']['bank_code'],
								'sourceRfc' => $data['data']['destination']['rfc'],
								'receiverRfc' => $data['data']['source']['rfc'],
								'sourceClabe' => $data['data']['destination']['account_number'],
								'receiverClabe' => $data['data']['source']['account_number'],
								'transactionDate' => $transferCliente['created_at'],
							];
							$res = $this->dataArt->AddMovement($argsR, 'SANDBOX');

//							$this->load->helper('sendmail_helper');

							return $this->response->sendResponse(["response" => 'Devolucion correta a ambas partes'], $error);
						}
					}
				}
			}
		}
		return $this->response->sendResponse($resp, $error);
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
