<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'models/enties/Factura.php';

class Xml extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index(){
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('xml','',true);
		$this->load->view('plantilla',$data);
	}
	public function factura() {
		if ($_FILES['invoiceUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['invoiceUpload']['tmp_name']);

			//Create the instance about "Factura"
			$factura = new Factura($xmlContent);

			echo $factura->version; 
			echo "<br>";
			echo $factura->date;
			echo "<br>";
	
			// Items
			foreach ($factura->items as $item) {
				echo $item['description'];
				echo "<br>";
			}
	
			echo $factura->issuerRfc;
			echo "<br>";
			echo $factura->receiverRfc;
			echo "<br>";
	
			// Impuestos
			echo $factura->totalTransferredTaxes;
		}
	}	
	public function notaCredito(){

		if ($_FILES['creditNoteUpload']['error'] == UPLOAD_ERR_OK) {
			$xmlContent = file_get_contents($_FILES['creditNoteUpload']['tmp_name']);
			$xml = simplexml_load_string((string)$xmlContent);

			print_r($xml);
		} 
	}

}