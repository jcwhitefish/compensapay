<?php
/**
 * Class Fiscal_model model
 * @property Fiscal_model $fData Fiscal_model module
 */
class Fiscal_model extends CI_Model {
	private string $enviroment = 'SANDBOX';
	private string $dbsandbox = 'compensatest_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->base = $this->enviroment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
	}

	/**
	 * Función para obtener todos los comprobantes electrónicos que tiene una cuenta.
	 * @param int         $id   id de la compañía de la que se quieren obtener datos
	 * @param int         $from fecha de inicio de búsqueda
	 * @param int         $to   fecha de termino de búsqueda
	 * @param string|null $env ambiente en el que se trabajara
	 * @return array
	 */
	public function getInfoCEP(int $id, int $from, int $to, string $env = null): array {
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//se crea la variable url de las facturas para concatenarlo
		$cep = base_url('boveda/CEP/');
		//Se crea el query para obtener las facturas
		$query = "SELECT t1.operationNumber, t1.traking_key, t1.created_at, t5.bnk_alias AS 'source_bank', t1.receiver_clabe, 
       t6.bnk_alias AS 'receiver_bank', FROM_UNIXTIME(t1.transaction_date, '%m/%d/%Y') AS 'transaction_date',
       CONCAT('$', FORMAT(t1.amount, 2, 'es_MX')) AS 'amount', 
       CONCAT('$cep', t1.url_cep) AS'cepUrl' 
FROM compensatest_base.balance t1 
    LEFT JOIN compensatest_base.operations t2 ON t2.operation_number = t1.operationNumber
    LEFT JOIN compensatest_base.companies t3 ON t3.id = t2.id_client
    LEFT JOIN compensatest_base.companies t4 ON t4.id = t2.id_provider
    LEFT JOIN compensatest_base.cat_bancos t5 ON t5.bnk_code = t1.source_bank
    LEFT JOIN compensatest_base.cat_bancos t6 ON t6.bnk_code = t1.receiver_bank
WHERE (t3.id = '$id' OR t4.id = '$id') 
  AND t1.transaction_date >= '$from' AND t1.transaction_date <= '$to' 
ORDER BY created_at DESC ";
		//Verífica que se ejecute bien el query
		if($res = $this->db->query($query)){
			//Verífica que haya resultados
			if ($res->num_rows() > 0) {
				//se crea un único arreglo con la información de los movimientos y se envía
				return ["code" => 200,"result" => $res->result_array()];
			}
			//En caso de que no hay información lo notifica para que se ingrese otro valor de búsqueda
			return ["code" => 404,"message" => "No se encontraron registros",
				"reason" => "No hay resultados con los criterios de busqueda utilizados"];
		}
		return ["code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información"];
	}
}
