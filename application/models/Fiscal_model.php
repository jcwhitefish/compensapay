<?php
/**
 * Class Fiscal_model model
 * @property Fiscal_model $fData Fiscal_model module
 */
class Fiscal_model extends CI_Model
{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function getInfoCEP(int $idCompany){
		$cepUrl = base_url('boveda/CEP/');
		$query = "SELECT t1.operationNumber, t1.traking_key, t1.created_at, t5.bnk_alias AS 'source_bank', t1.receiver_clabe, 
					t6.bnk_alias AS 'receiver_bank', FROM_UNIXTIME(t1.transaction_date, '%m/%d/%Y %H:%i:%s') AS 'transaction_date',
					CONCAT('$', FORMAT(t1.amount, 2, 'es_MX')) AS 'amount', 
					CONCAT('{$cepUrl}', t1.url_cep) AS'cepUrl' 
					FROM compensatest_base.balance t1 
					LEFT JOIN compensatest_base.operations t2 ON t2.operation_number = t1.operationNumber
					LEFT JOIN compensatest_base.companies t3 ON t3.id = t2.id_client
					LEFT JOIN compensatest_base.companies t4 ON t4.id = t2.id_provider
					LEFT JOIN compensatest_base.cat_bancos t5 ON t5.bnk_code = t1.source_bank
					LEFT JOIN compensatest_base.cat_bancos t6 ON t6.bnk_code = t1.receiver_bank
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
