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
		$query = "SELECT * FROM ( SELECT balance.*, CONCAT('$', FORMAT(balance.amount, 2)) as ammountf, invoices.uuid,
                       t3.bnk_alias as 'bank_source', t4.bnk_alias as 'bank_receiver',
(IF((balance.receiver_clabe = t2.account_clabe OR balance.receiver_clabe = t5.arteria_clabe), t2.legal_name, t1.legal_name)) as 'client',
(IF((balance.source_clabe = t5.arteria_clabe OR balance.source_clabe = t2.account_clabe), t2.legal_name, t1.legal_name)) as 'provider',
(IF((balance.receiver_clabe = t2.account_clabe OR balance.receiver_clabe = t5.arteria_clabe), t2.id, t1.id)) as 'clientId',
(IF((balance.source_clabe = t5.arteria_clabe OR balance.source_clabe = t2.account_clabe), t2.id, t1.id)) as 'providerId',
(IF((balance.receiver_clabe = t2.account_clabe OR balance.receiver_clabe = t5.arteria_clabe), t2.rfc, t1.rfc)) as 'clientRFC',
(IF((balance.source_clabe = t5.arteria_clabe OR balance.source_clabe = t2.account_clabe), t2.rfc, t1.rfc)) as 'providerRFC',
                    FROM_UNIXTIME(balance.created_at, '%d/%m/%Y') AS 'created_atb',
                    FROM_UNIXTIME(balance.transaction_date, '%d/%m/%Y') AS 'transaction_dateb',
                    CONCAT('$cep',balance.url_cep) AS 'cepUrl'
FROM balance as balance
                    LEFT JOIN operations ON balance.operationNumber = operations.operation_number
                    LEFT JOIN invoices ON invoices.id = operations.id_invoice
                    LEFT JOIN companies t1 ON t1.id = operations.id_client
                    LEFT JOIN companies t2 ON t2.id = operations.id_provider
                    LEFT JOIN cat_bancos t3 ON t3.bnk_code = balance.source_bank
                    LEFT JOIN cat_bancos t4 ON t4.bnk_code = balance.receiver_bank
                    LEFT JOIN fintech t5 ON t5.companie_id = operations.id_provider) b
WHERE (clientId = '$id' OR providerId = '$id') AND created_at >= '$from' AND created_at <= '$to' ORDER BY created_at DESC";
//		var_dump($query);
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
