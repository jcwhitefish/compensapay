<?php
require_once __DIR__ . '/vendor/autoload.php';

class Proveedor_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Guarda el resgistro de un nuevo proveedor
	 *
	 *
	 * @return void
	 * @author  Fernando Alarcon <fernando_alarcon_r@hotmail.com>.
	 * @version 1.0.0
	 */
	public function registrarProveedor (array $args, ?string $env = 'SANDBOX'){

		$query = "INSERT INTO compensapay.rec_supplier (id_com, nationality, date_const, num_rpc, e_firma, e_mail, website, obj_social, desc_operation, transact_month, ammount, person_incharge, person_name, person_curp, person_rfc, person_id, person_adress, person_email, person_phone, natural_person_benef, benef_legal_entity, license_services, supervisor_name, license_type, license_date, been_audited, anticorruption, data_protection, vul_activity, regist_sat, up_to_date) 
            VALUES ({$args['companie']}, '{$args['nationality']}', '{$args['dateConst']}','{$args['folio']}', '{$args['efirma']}', '{$args['emailForm']}', '{$args['web']}', '{$args['socialobj']}', '{$args['descOperation']}', '{$args['transactMonth']}', '{$args['amount']}', '{$args['charge']}', '{$args['nameForm2']}', '{$args['curp']}', '{$args['rfcForm2']}', '{$args['idNumber']}', '{$args['domForm2']}', '{$args['emailForm2']}', '{$args['phoneForm2']}', {$args['fisica']}, {$args['moral']}, {$args['license']}, '{$args['supervisor']}', '{$args['typeLicense']}', '{$args['dateAward']}', {$args['audited']}, {$args['anticorruption']}, {$args['dataProtection']}, {$args['vulnerable']}, '{$args['servTrib']}', '{$args['obligations']}')";
		if ($result = $this->db->query($query)){
			$id = $this->db->insert_id();
			return ['id'=>$id];
			
		}else{
			return ($result->error());
		}
	}

	public function createPDF (array $args, ?string $env = 'SANDBOX'){
		

		$query = "INSERT INTO compensapay.rec_supplier (id_com, nationality, date_const, num_rpc, e_firma, e_mail, website, obj_social, desc_operation, transact_month, ammount, person_incharge, person_name, person_curp, person_rfc, person_id, person_adress, person_email, person_phone, natural_person_benef, benef_legal_entity, license_services, supervisor_name, license_type, license_date, been_audited, anticorruption, data_protection, vul_activity, regist_sat, up_to_date) 
            VALUES ({$args['companie']}, '{$args['nationality']}', '{$args['dateConst']}','{$args['folio']}', '{$args['efirma']}', '{$args['emailForm']}', '{$args['web']}', '{$args['socialobj']}', '{$args['descOperation']}', '{$args['transactMonth']}', '{$args['amount']}', '{$args['charge']}', '{$args['nameForm2']}', '{$args['curp']}', '{$args['rfcForm2']}', '{$args['idNumber']}', '{$args['domForm2']}', '{$args['emailForm2']}', '{$args['phoneForm2']}', {$args['fisica']}, {$args['moral']}, {$args['license']}, '{$args['supervisor']}', '{$args['typeLicense']}', '{$args['dateAward']}', {$args['audited']}, {$args['anticorruption']}, {$args['dataProtection']}, {$args['vulnerable']}, '{$args['servTrib']}', '{$args['obligations']}')";
		if ($result = $this->db->query($query)){
			$id = $this->db->insert_id();
			return ['id'=>$id];
			
		}else{
			return ($result->error());
		}
	}

}
