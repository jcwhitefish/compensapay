<?php

class Fintec extends MY_Loggedout
{
	public function ping(){
	}
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
			$data = $body ?? NULL;
			if ($data['object_type'] === 'transaction' && $data['data']['type']  === 'deposit'){
				$args=[];
				var_dump($data['data']['reference_number']);
			}
		}
		return $this->response->sendResponse($resp, $error);
	}
}
