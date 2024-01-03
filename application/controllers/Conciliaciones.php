<?php
/**
 * @property Invoice_model 		$invData
 * @property Operation_model 	$OpData
 * @property User_model         $dataUsr
 * @property Notification_model $nt
 */
class Conciliaciones extends MY_Loggedin
{
	public function index(): void
	{
		$data['main'] = $this->load->view('conciliaciones', '', true);
		$this->load->view('plantilla', $data);
	}

	public function CFDI()
	{
		//Se obtienen la fecha mínima y máxima para filtrar las facturas
		$from = strtotime($this->input->post('from'));
		$to = strtotime($this->input->post('to') . ' +1 day');
		//Se verifican que sean fechas válidas
		if ($from & $to) {
			//Se carga el modelo de donde se obtendrán los datos y se obtiene el ID de compañía de la sesión
			$this->load->model('Invoice_model', 'invData');
			$id = $this->session->userdata('datosEmpresa')["id"];
			//Se buscan las facturas que coincidan con los criterios enviados
			$res = $this->invData->getCFDIByCompany($id, $from, $to);
			//Si encuentra resultados el arreglo lo envia como JSON
			if ($res['code'] === 200) {
				echo(json_encode($res['result']));
				return true;
			}
			//En caso contrario regresa el error para mostrar una alerta
			echo(json_encode($res));
			return false;
		}
		echo json_encode(["code" => 500, "message" => "Error al extraer la información", "reason" => "No se envió una fecha valida"]);
		return false;
	}

	public function conciliation()
	{
		//Se obtienen la fecha mínima y máxima para filtrar las facturas
		$from = strtotime($this->input->post('from'));
		$to = strtotime($this->input->post('to') . ' +1 day');
		//Se verifican que sean fechas válidas
		if ($from & $to) {
			//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
			$this->load->model('Operation_model', 'OpData');
			$id = $this->session->userdata('datosEmpresa')["id"];
			//Se buscan las facturas que coincidan con los criterios enviados
			$res = $this->OpData->getConciliacionesByCompany($id, $from, $to);
			//Si encuentra resultados el arreglo lo envia como JSON
			if ($res['code'] === 200) {
				echo(json_encode($res['result']));
				return true;
			}
			//En caso contrario regresa el error para mostrar una alerta
			echo(json_encode($res));
			return false;
		}
		echo json_encode(["code" => 500, "message" => "Error al extraer la información", "reason" => "No se envió una fecha valida"]);
		return false;
	}
	public function accept()
	{
		//Se obtienen el ID de la conciliación que se acepta
		$id = $this->input->post('id');
		//Se valida que tengamos un dato valido
		if ($id){
			//Se carga el modelo de donde se obtendrán los datos y se obtiene el ID de compañía de la sesión
			$this->load->model('Operation_model', 'OpData');
			$idCompany = $this->session->userdata('datosEmpresa')["id"];
			//Se envía la instrucción para aceptar la conciliación
			if($this->OpData->acceptConciliation($id,$idCompany,'SANDBOX')['code'] === 200){
				$this->adviseAuthorized($id);
			}
		}
		echo json_encode(["code" => 500, "message" => "Error al actualizar el estatus", "reason" => "No es un Id valido"]);
		return false;
	}

	/**
	 * Función para notificar que se a autorizado una conciliación
	 * @param int $id ID de la conciliación que se a autorizado
	 * @param string $env Ambiente en el que se va a trabajar
	 * @return void
	 */
	public function adviseAuthorized (int $id, string $env = 'SANDBOX')
	{
		//Se cargan los helpers y modelos necesarios
		$this->load->model('User_model', 'dataUsr');
		$this->load->model('Notification_model' , 'nt');
		$this->load->helper('sendmail_helper');
		$this->load->helper('notifications_helper');

		$conciliation = $this->OpData->getConciliacionesByID($id, $env);
		$provider = $this->dataUsr->getInfoFromCompanyPrimary($conciliation['result']['idEmisor'], $env);
//		var_dump($provider);
		$data = ['operationNumber'=>$conciliation['result']['operation_number']];
		$notification = notificationBody($data,4);
		$data = [
			'user' => [
				'name' => $provider['result']['name'],
				'lastName' => $provider['result']['last_name'],
				'company' => $provider['result']['short_name'],
			],
			'text' => $notification['body'],
			'urlDetail' => ['url' => base_url('/Conciliaciones'), 'name' => 'Conciliaciones'],
			'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
		];
		var_dump($notification);
		send_mail('uriel.magallon@whitefish.mx', $data, 2,null , $notification['title']);
		$this->nt->insertNotification(
			['id'=>$provider['result']['id'], 'title' =>$notification['title'], 'body' =>$notification['body'],],$env);
		$data=[
			'operationNumber' => $conciliation['operation_number'],
			'amount' => $conciliation['total1'],
			'clabe' => $conciliation['arteria_clabe'],
		];
		$notification = notificationBody($data,17);
		$data = [
			'user' => [
				'name' => $this->session->userdata('datosUsuario')["name"],
				'lastName' => $this->session->userdata('datosUsuario')["last_name"],
				'company' => $this->session->userdata('datosEmpresa')["short_name"],
			],
			'text' => $notification['body'],
			'urlDetail' => ['url' => base_url('/Conciliaciones'), 'name' => 'Conciliaciones'],
			'urlSoporte' => ['url' => base_url('/soporte'), 'name' => base_url('/soporte')],
		];
		send_mail('uriel.magallon@whitefish.mx', $data, 2,null , $notification['title']);
		$this->nt->insertNotification(
			['id'=>$this->session->userdata('datosUsuario')["id"], 'title' =>$notification['title'], 'body' =>$notification['body'],],$env);
	}
}
