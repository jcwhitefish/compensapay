<?php
class Registro_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function detalles(){

        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        //giro de la empresa
        $ResGiro = "SELECT * FROM cat_giro WHERE gro_activo = 1 ORDER BY gro_giro ASC";
        $ResRegimen = "SELECT rg_id, rg_clave, rg_regimen FROM cat_regimenfiscal ORDER BY rg_clave ASC";
        $ResColonias = "SELECT col.zip_id AS id, col.zip_town AS colonia, col.zip_code as cp
                        FROM cat_zipcode AS col
                        INNER JOIN cat_zipcode AS zc oN zc.zip_code = col.zip_code
                        INNER JOIN companies AS c ON c.id_postal_code = zc.zip_id
                        WHERE c.id = $idcompanie";

        if ($RResGiro = $this->db->query($ResGiro)) {
			if ($RResGiro->num_rows() > 0){
                $resgiros = $RResGiro->result_array();
            }
            else {
                $resgiros = '';
            }
		}

        if($RResRegimen = $this->db->query($ResRegimen)) {
            if ($RResRegimen->num_rows() > 0){
                $resregimen = $RResRegimen->result_array();
            }
            else {
                $resregimen = '';
            }
        }

        if($RResColonias = $this->db->query($ResColonias)) {
            if ($RResColonias->num_rows() > 0){
                $rescolonias = $RResColonias->result_array();
            }
            else {
                $rescolonias = '';
            }
        }

        $ResRegistro = array(
            "giros" => $resgiros,
            "regimenfiscal" => $resregimen, 
            "colonias" => $rescolonias
        );

        return $ResRegistro;
    }

    public function estado($codigopostal){

        $ResEstado = "SELECT zip_town FROM cat_zipcode WHERE zip_code = $codigopostal LIMIT 1";

        if($RResEstado = $this->db->query($ResEstado)){

            if($RResEstado->num_rows()>0){
                $resestado = $RResEstado->result_array();
            }
            else  {
                $resestado = '';
            }
        }

        return $resestado;

    }


    public function banco($clabe){

        $clavebanco = $clabe[0].$clabe[1].$clabe[2];

        $ResBanco = "SELECT bnk_nombre FROM cat_bancos WHERE bnk_clave = $clavebanco LIMIT 1";

        if($RResBanco = $this->db->query($ResBanco)){

            if($RResBanco->num_rows() > 0 ) {
                $res_banco = $RResBanco->result_array();
            }
            else {
                $res_banco = '';
            }
        }

        return $res_banco;
    }

    public function onboardinge ($empresa){

        $uniqueString = uniqid();
        $hora_actual = date("H");
        $uniqueString = $uniqueString . '-' . $hora_actual;

        $data = array(
            'legal_name' => $empresa["razonsocial"],
            'short_name' => $empresa["nombrecomercial"],
            'rfc' => $empresa["rfc"], 
            'id_fiscal' => $empresa["regimen"],
            'unique_key' => $uniqueString, 
            'created_at' => time()
        );

        $this->db->insert('companies', $data);

        $idc = $this->db->insert_id();

        $dato = array(
            'idCompanie' => $idc,
            'Logotipo' => 0,
            'ActaConstitutiva' => 0,
            'ConstanciaSituacionF' => 0,
            'ComprobanteDomicilio' =>  0,
            'IdenRepresentante' => 0
        );

        $this->db->insert('companies_docs', $dato);

        $dato2 = array(
            'idCompanie' => $idc
        );

        $this->db->insert('stp_propietarioreal', $dato2); 

        return $idc;
    }

    public function onboardingu ($usuario){

        $uniqueString = uniqid();
        $hora_actual = date("H");
        $uniqueString = $uniqueString . '-' . $hora_actual;

        $data = array(
            'user' => $usuario["email"],
            'name' => $usuario["name"],
            'last_name' => $usuario["lastname"],
            'email' => $usuario["email"], 
            'telephone' => $usuario["phone_number"],
            'id_company' => $usuario["empresa"], 
            'unique_key' => $uniqueString,
            'created_at' => time()
        );
        
        $this->db->insert('users', $data);

        $userid = $this->db->insert_id();

        //insertar notificaciones

        $datan = array(
            'user_id' => $userid,
            'nt_OperationNew' => 1,
            'nt_OperationApproved' => 1,
            'nt_OperationPaid' => 1,
            'nt_OperationStatus' => 1,
            'nt_OperationExternalAccount' => 1,
            'nt_OperationReturn' => 1,
            'nt_OperationReject' => 1,
            'nt_OperationDate' => 1,
            'nt_OperationInvoiceNew' => 1,
            'nt_OperationInvoiceRequest' => 1,
            'nt_DocumentStatementReady' => 1,
            'nt_InviteNew' => 1,
            'nt_InviteStatus' => 1,
            'nt_SupportTicketStatus' => 1,
            'nt_SupportReply' => 1,
            'nt_CreateAt' => time()
        );

        $this->db->insert(' conf_notifications', $datan);

        return $userid;

    }
}