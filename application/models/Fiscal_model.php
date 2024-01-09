<?php

class Fiscal_model extends CI_Model
{
	private string $dbsandbox = 'appsolve_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';
	private string $enviroment = 'SANDBOX';

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->base = $this->enviroment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
	}

	public function getInfoCEP(int $idCompany, string $env = NULL){
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		$cepUrl = base_url('boveda/CEP/');
		$query = "SELECT t1.operationNumber, t1.traking_key, FROM_UNIXTIME(t1.created_at, '%m/%d/%Y') AS 'created_at', t5.bnk_alias AS 'source_bank', t1.receiver_clabe, 
					t6.bnk_alias AS 'receiver_bank', FROM_UNIXTIME(t1.transaction_date, '%m/%d/%Y') AS 'transaction_date',
					CONCAT('$', FORMAT(t1.amount, 2, 'es_MX')) AS 'amount', 
					CONCAT('{$cepUrl}', t1.url_cep) AS'cepUrl' 
					FROM $this->base.balance t1 
					LEFT JOIN $this->base.operations t2 ON t2.operation_number = t1.operationNumber
					LEFT JOIN $this->base.companies t3 ON t3.id = t2.id_client
					LEFT JOIN $this->base.companies t4 ON t4.id = t2.id_provider
					LEFT JOIN $this->base.cat_bancos t5 ON t5.bnk_code = t1.source_bank
					LEFT JOIN $this->base.cat_bancos t6 ON t6.bnk_code = t1.receiver_bank
            WHERE (t3.id = '{$idCompany}' OR t4.id = '{$idCompany}') ORDER BY created_at DESC ";
//		var_dump($query);
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0)
				return $result->result_array();
		}else{
			return false;
		}
		return false;
	}
}
