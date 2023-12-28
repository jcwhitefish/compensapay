<?php
/**
 * @property Fiscal_model  $fData
 * @property Invoice_model $invData
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

	public function Conciliaciones()
	{
		//Se obtienen la fecha mínima y máxima para filtrar las facturas
		$from = strtotime($this->input->post('from'));
		$to = strtotime($this->input->post('to') . ' +1 day');
		//Se verifican que sean fechas válidas
		if ($from & $to) {
			//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
			$this->load->model('Invoice_model', 'invData');
			$id = $this->session->userdata('datosEmpresa')["id"];
			//Se buscan las facturas que coincidan con los criterios enviados
			$res = $this->invData->getDocsCFDI($id, $from, $to);
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

}
