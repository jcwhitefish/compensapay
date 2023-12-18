<?php
/**
 * @property Fiscal_model $fData
 * @property Invoice_model $invData
 */
class Documentos extends MY_Loggedin{
	public function index(){
//		$isClient = $this->session->userdata('vista');
//		if ($isClient == 1) {
//			$data['main'] = $this->load->view('modelofiscal/cliente', '', true);
//			$this->load->view('plantilla', $data);
//		} else {
		$data['main'] = $this->load->view('documents', '', true);
		$this->load->view('plantilla', $data);
//		}
	}
	/**
	 * Esta función obtiene los CFDI (Facturas y Notas de debito) que estan ligadas a una operación y a la compañia del usuario que consulta
	 * @return bool
	 */
	public function DocsCFDI(): bool{
		//Se obtienen la fecha mínima y máxima para filtrar las facturas
		$from = strtotime($this->input->post('from'));
		$to = strtotime($this->input->post('to').' +1 day');
		//Se verifican que sean fechas válidas
		if ($from & $to){
			//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
			$this->load->model('Invoice_model', 'invData');
			$id = $this->session->userdata('datosEmpresa')["id"];
			//Se buscan las facturas que coincidan con los criterios enviados
			$res = $this->invData->getDocsCFDI($id,$from,$to);
			//Si encuentra resultados el arreglo lo envia como JSON
			if($res['code'] === 200){
				echo( json_encode($res['result']));
				return true;
			}
			//En caso contrario regresa el error para mostrar una alerta
			echo( json_encode($res));
			return false;
		}
		echo json_encode(["code" => 500, "message" => "Error al extraer la información", "reason" => "No se envió una fecha valida"]);
		return false;
	}
	public function DocsMovimientos(){
		//Se obtienen la fecha mínima y máxima para filtrar las facturas
		$from = strtotime($this->input->post('from'));
		$to = strtotime($this->input->post('to').' +1 day');
		//Se verifican que sean fechas válidas
		if ($from & $to){
			//Se carga el modelo de donde se obtendran los datos y se obtiene el id de compañia de la sesión
			$this->load->model('Invoice_model', 'invData');
			$id = $this->session->userdata('datosEmpresa')["id"];
			//Se buscan los movimientos que coincidan con los criterios enviados
			$res = $this->invData->getDocsMovements($id,$from,$to);
			//Si encuentra resultados el arreglo lo envia como JSON
			if($res['code'] === 200){
				echo( json_encode($res['result']));
				return true;
			}
			//En caso contrario regresa el error para mostrar una alerta
			echo( json_encode($res));
			return false;
		}
		echo json_encode(["code" => 500, "message" => "Error al extraer la información", "reason" => "No se envió una fecha valida"]);
		return false;
	}

	public function tablaCEP(){
		$this->load->model('Fiscal_model', '$fData');
		$companie = $this->session->userdata('id');
		$dato = [];
		$dato['CEPS'] = $this->$fData->getInfoCEP($companie);
		$dato['status'] = 'ok';
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($dato));
	}
}
