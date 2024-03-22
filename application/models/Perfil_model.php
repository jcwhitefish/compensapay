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
                            cd.IdenRepresentante AS IdenRepresentante, cd.EscriturasPublicas AS EscriturasPublicas, cd.PoderRepresentanteLegal AS PoderRepresentanteLegal, 
                            cd.eFirma AS eFirma, cd.IdenPropietarioReal AS IdenPropietarioReal, cd.DocumentoAdicional AS DocumentoAdicional
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

    public function savepropietarior($propietario = NULL)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        if($propietario != NULL)
        {
            $query = "SELECT Id FROM stp_propietarioreal WHERE idCompanie = $idcompanie LIMIT 1";

            if($ResQuery = $this->db->query($query)){

                if($ResQuery->num_rows() == 0 ) {
                    //insertamos registro
                    $query1 = "INSERT INTO stp_propietarioreal (idCompanie, CorreoE, Domicilio, Curp, Telefono, Ocupacion)
                                                        VALUES ('".$idcompanie."', '".$propietario["correopr"]."', '".$propietario["domiciliopr"]."', 
                                                                '".$propietario["curppr"]."', '".$propietario["telefonopr"]."', '".$propietario["ocupacionpr"]."')";
                }
                else {
                    //actualizamos registro
                    $query1 = "UPDATE stp_propietarioreal SET CorreoE = '".$propietario["correopr"]."',
                                                                Domicilio = '".$propietario["domiciliopr"]."',
                                                                Curp = '".$propietario["curppr"]."',
                                                                Telefono = '".$propietario["telefonopr"]."', 
                                                                Ocupacion = '".$propietario["ocupacionpr"]."' 
                                                        WHERE idCompanie = '".$idcompanie."'";
                }

                $this->db->query($query1);
            }
        }

        $query2 = "SELECT * FROM stp_propietarioreal WHERE idCompanie = $idcompanie LIMIT 1";

        if($ResPR = $this->db->query($query2)){
            if($ResPR->num_rows() > 0 ) {
                $propietarioreal = $ResPR->result_array();
            }
            else{
                $propietarioreal = '';
            }
        }

        return $propietarioreal;

    }

    public function registra_file($file)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $query = "UPDATE companies_docs SET $file = 1 WHERE idCompanie = $idcompanie";

        $this->db->query($query);

        //echo $query;

        return TRUE;
    }

    public function savestpkyc($datoskyc)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $datos = array(
            'idCompanie' => $idcompanie,
            'PersonalC' => $datoskyc["personalc"],
            'OrigenE' => $datoskyc["origene"],
            'DedicaE' => $datoskyc["dedicae"],
            'ServiciosC' => $datoskyc["serviciosc"],
            'UsaraC' => $datoskyc["usarac"],
            'Recursos' => $datoskyc["recursos"],
            'Medios' => $datoskyc["medios"]
        );

        if($this->db->insert('stp_kyc', $datos)){

            $id = $this->db->insert_id();

            $this->session->set_userdata('datosEmpresa',$this->company_model->get_company(array('id' => $idcompanie)));

            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function savestppt($datospt)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $datos = array(
            'idCompanie' => $idcompanie,
            'SaldoMensualCobro' => $datospt["smec"],
            'SaldoMensualPago' => $datospt["smep"],
            'TransaccionesCobro' => $datospt["ntc"],
            'TransaccionesPago' => $datospt["ntp"],
            'OrigenRecursos' => $datospt["or"],
            'DestinoRecursos' => $datospt["dr"],
            'ManejoEfectivo' => $datospt["me"],
            'FormaOperar' => $datospt["fo"],
            'Servicio247' => $datospt["s247"]
        );

        if($this->db->insert('stp_perfiltransaccional', $datos)){

            $id = $this->db->insert_id();

            $this->session->set_userdata('datosEmpresa',$this->company_model->get_company(array('id' => $idcompanie)));

            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    public function savestpusuarios($datosu)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $datos1 = array(
            'idCompanie' => $idcompanie,
            'Nombre' => $datosu["nombre1"],
            'CorreoE' => $datosu["correo1"],
            'FechaNacimiento' => $datosu["fechanacimiento1"],
            'Celular' => $datosu["celular1"],
            'Perfil' => $datosu["perfil1"]
        );
        $datos2 = array(
            'idCompanie' => $idcompanie,
            'Nombre' => $datosu["nombre2"],
            'CorreoE' => $datosu["correo2"],
            'FechaNacimiento' => $datosu["fechanacimiento2"],
            'Celular' => $datosu["celular2"],
            'Perfil' => $datosu["perfil2"]
        );

        $this->db->insert('stp_usuarios', $datos1);
        $this->db->insert('stp_usuarios', $datos2);

        if($datosu["nombre3"]!='' OR $datosu["correo3"]!='' OR $datosu["fechanacimiento3"]!='0000-00-00' OR $datosu["celular3"]!='' OR $datosu["perfil3"]!='')
        {
            $datos3 = array(
                'idCompanie' => $idcompanie,
                'Nombre' => $datosu["nombre3"],
                'CorreoE' => $datosu["correo3"],
                'FechaNacimiento' => $datosu["fechanacimiento3"],
                'Celular' => $datosu["celular3"],
                'Perfil' => $datosu["perfil3"]
            );
            
            $this->db->insert('stp_usuarios', $datos3);
        }
       

        $this->session->set_userdata('datosEmpresa',$this->company_model->get_company(array('id' => $idcompanie)));

        return TRUE;
    }

    public function savestpcontactos($contacto)
    {
        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $datos = array(
            'idCompanie' => $idcompanie,
            'Nombre' => $contacto["nombre"],
            'Telefono' => $contacto["telefono"],
            'Extension' => $contacto["extension"],
            'Celular' => $contacto["celular"],
            'CorreoE' => $contacto["correoe"],
            'Area' => $contacto["area"]
        );

        $this->db->insert('stp_contactos', $datos);

        $this->session->set_userdata('datosEmpresa',$this->company_model->get_company(array('id' => $idcompanie)));

        //usuarios operativos
        $queryo = "SELECT * FROM stp_contactos WHERE Area = 1 AND idCompanie = $idcompanie ORDER BY Id ASC";

        if($ResCO = $this->db->query($queryo)){
            if($ResCO->num_rows() > 0 ) {
                $contactoso = $ResCO->result_array();
            }
            else{
                $contactoso = '';
            }
        }

        //usuarios sistemas
        $querys = "SELECT * FROM stp_contactos WHERE Area = 2 AND idCompanie = $idcompanie ORDER BY Id ASC";

        if($ResCS = $this->db->query($querys)){
            if($ResCS->num_rows() > 0 ) {
                $contactoss = $ResCS->result_array();
            }
            else{
                $contactoss = '';
            }
        }

        //usuarios cuentas por pagar
        $queryc = "SELECT * FROM stp_contactos WHERE Area = 3 AND idCompanie = $idcompanie ORDER BY Id ASC";

        if($ResCC = $this->db->query($queryc)){
            if($ResCC->num_rows() > 0 ) {
                $contactosc = $ResCC->result_array();
            }
            else{
                $contactosc = '';
            }
        }

        //usuarios juridico
        $queryj = "SELECT * FROM stp_contactos WHERE Area = 4 AND idCompanie = $idcompanie ORDER BY Id ASC";

        if($ResCJ = $this->db->query($queryj)){
            if($ResCJ->num_rows() > 0 ) {
                $contactosj = $ResCJ->result_array();
            }
            else{
                $contactosj = '';
            }
        }

        $contactos = array(
            'contactoso' => $contactoso,
            'contactoss' => $contactoss,
            'contactosc' => $contactosc,
            'contactosj' => $contactosj
        );

        return $contactos;

    }

}
?>