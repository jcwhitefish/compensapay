<?php
class Perfil_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function empresa(){

        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $query = "SELECT c.legal_name AS legal_name, c.short_name AS short_name, c.id_fiscal AS regimen, c.rfc AS rfc, zc.zip_id AS zip_id, 
                            zc.zip_code AS zip_code, zc.zip_town AS colonia, m.cnty_name AS municipio, e.stt_name AS estado, c.address AS address, 
                            c.telephone AS telephone, c.correoe AS correoe, c.account_clabe AS account_clabe, b.bnk_nombre AS banco, cd.Logotipo AS Logotipo, 
                            cd.ActaConstitutiva AS ActaConstitutiva, cd.ConstanciaSituacionF AS ConstanciaSituacionF, cd.ComprobanteDomicilio AS ComprobanteDomicilio,
                            cd.IdenRepresentante AS IdenRepresentante 
                    FROM companies AS c 
                    INNER JOIN companies_docs AS cd ON cd.idCompanie = c.id
                    INNER JOIN cat_zipcode AS zc ON c.id_postal_code = zc.zip_id 
                    INNER JOIN cat_county AS m ON m.cnty_id = zc.zip_county 
                    INNER JOIN cat_state AS e ON zc.zip_state = e.stt_id 
                    INNER JOIN cat_bancos AS b ON SUBSTRING(c.account_clabe,1,3) = b.bnk_clave 
                    WHERE c.id = $idcompanie LIMIT 1";

        if ($ResEmp = $this->db->query($query)) {
			if ($ResEmp->num_rows() > 0){
                $empresa = $ResEmp->result_array();
            }
            else {
                $empresa = '';
            }
		}

        return $empresa;
    }

    public function estado($codigopostal){

        $ResEstado = "SELECT s.stt_name AS estado 
                        FROM cat_zipcode AS cp 
                        INNER JOIN cat_state aS s ON cp.zip_state = s.stt_id 
                        WHERE cp.zip_code = $codigopostal LIMIT 1;";

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

    public function municipio($codigopostal){

        $ResMunicipio = "SELECT c.cnty_name AS municipio
                        FROM cat_zipcode AS zc 
                        INNER JOIN cat_county AS c ON zc.zip_county = c.cnty_id
                        WHERE zc.zip_code = $codigopostal GROUP BY zc.zip_county;";

        if($RResMunicipio = $this->db->query($ResMunicipio)){

            if($RResMunicipio->num_rows()>0){
                $resmunicipio = $RResMunicipio->result_array();
            }
            else  {
                $resmunicipio = '';
            }
        }

        return $resmunicipio;

    }

    public function colonia($codigopostal){

        $ResColonias = "SELECT zip_id, zip_town FROM cat_zipcode WHERE zip_code = $codigopostal ORDER BY zip_town ASC";

        if($RResColonias = $this->db->query($ResColonias)){

            if($RResColonias->num_rows()>0){
                $rescolonias = $RResColonias->result_array();
            }
            else  {
                $rescolonias = '';
            }
        }

        return $rescolonias;
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

    public function updateempresa($empresa)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $clabe = $empresa["clabe"][0].$empresa["clabe"][1].$empresa["clabe"][2];

        $query = "UPDATE companies 
                    INNER JOIN ( SELECT bnk_id AS idbanco FROM cat_bancos WHERE bnk_clave='".$clabe."') AS banco 
                    SET legal_name = '".$empresa["legal_name"]."', 
                        short_name = '".$empresa["short_name"]."', 
                        id_fiscal = '".$empresa["regimen"]."', 
                        id_postal_code = '".$empresa["colonia"]."', 
                        address = '".$empresa["direccion"]."', 
                        telephone = '".$empresa["telefono"]."', 
                        correoe = '".$empresa["correoe"]."',
                        account_clabe = '".$empresa["clabe"]."',
                        id_broadcast_bank = banco.idbanco
                    WHERE id = '".$idcompanie."'";

        $this->db->query($query);

        $this->session->set_userdata('datosEmpresa',$this->company_model->get_company(array('id' => $idcompanie)));

        return $this->empresa();
    }

    public function registra_file($file)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $query = "UPDATE companies_docs SET $file = 1 WHERE idCompanie = $idcompanie";

        $this->db->query($query);

        //echo $query;

        return TRUE;
    }

}
?>