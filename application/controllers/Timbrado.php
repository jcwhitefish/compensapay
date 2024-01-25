<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timbrado extends MY_Loggedin {
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

	function __construct()
    {

      parent:: __construct();
      $this->load->model('Timbrado_model'); 

	  // load Session Library 
	  $this->load->library('session');
    }

    public function index(){

		$dato = array(
			"empresa" => $this->Timbrado_model->empresa()
		);


		$data['main'] = $this->load->view('timbrado/timbrado', $dato, true);
		$this->load->view('plantilla', $data);
		

	}

    public function nueva_factura(){

        $dato = array(
            "dfactura" => $this->Timbrado_model->timbrado()
        );

        $data['main'] = $this->load->view('timbrado/nueva_factura', $dato, true);
		$this->load->view('plantilla', $data);
    }

    public function partidas($partida){

        $dato = $this->Timbrado_model->partidas($partida);
		
		$this->load->view('timbrado/partidas', $dato);
    }

	public function guardar_factura(){

		//aqui recibe los datos
		$cliente = $this->input->post('cliente');
		$descuento = $this->input->post('descuento');
		$apretiva = $this->input->post('apretiva');
		$retiva = $this->input->post('retiva');
		$apretisr = $this->input->post('apretisr');
		$retisr = $this->input->post('retisr');
		$usocfdi = $this->input->post('usocfdi');
		$formadepago = $this->input->post('formadepago');
		$nummetodopago = $this->input->post('nummetodopago');
		$moneda = $this->input->post('moneda');
		$tipocambio = $this->input->post('tipocambio');
		$metododepago = $this->input->post('metododepago');

		//partidas
		$partidas = array();
		for($a=0;$a<$this->input->post('partidas'); $a++)
        {
			//                 cantidad 							unidad   						 clave    								  noident  									   concept  						   preciou  						 subtota  						  apiiva   						  partiva  						   partisr  						iva    								 retiva  							   retisr  								 importe
       		//             0   1        							2        						 3        								  4        									   5        						   6        						 7        						  8        						  9        						   10       						11     								 12      							   13      								 14       
			$arreglo=array($a, $this->input->post('cantidad_'.$a), $this->input->post('unidad_'.$a), $this->input->post('claveprodserv_'.$a), $this->input->post('numidentificacion_'.$a), $this->input->post('producto_'.$a), $this->input->post('precio_'.$a), $this->input->post('total_'.$a), $this->input->post('ivap_'.$a), $this->input->post('rivap_'.$a), $this->input->post('risrp_'.$a), $this->input->post('aplicaiva_'.$a), $this->input->post('aplicariva_'.$a), $this->input->post('aplicarisr_'.$a), $this->input->post('importep_'.$a));
            array_push($partidas, $arreglo);
        }

		$subtotalf = $this->input->post('subtotalf');
		$ivaf = $this->input->post('ivaf');
		$risr = $this->input->post('risr');
		$riva = $this->input->post('riva');
		$totalf = $this->input->post('totalf');

		$factura = [
			'cliente' => $cliente,
			'descuento' => $descuento, 
			'apretiva' => $apretiva,
			'retiva' => $retiva,
			'apretisr' => $apretisr, 
			'retisr' => $retisr, 
			'usocfdi' => $usocfdi, 
			'formadepago' => $formadepago,
			'nummetodopago' => $nummetodopago, 
			'moneda' => $moneda,
			'tipocambio' => $tipocambio,
			'metododepago' => $metododepago, 
			'partidas' => $partidas,
			'subtotalf' => $subtotalf, 
			'ivaf' => $ivaf,
			'risr' => $risr,
			'riva' => $riva, 
			'totalf' => $totalf
		];

		//print_r($factura);

		$dato = array(
            "factura" => $this->Timbrado_model->guardar_factura($factura)
        );

		$data['main'] = $this->load->view('timbrado/guardar_factura', $dato, true);
		//$this->load->view('plantilla', $data);
	}

	public function configuracion(){

		$data['main'] = $this->load->view('timbrado/configuracion', '', true);
		$this->load->view('plantilla', $data);
	}
}