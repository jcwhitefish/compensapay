<?php
require_once __DIR__ . '/../../vendor/autoload.php';

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

    public function genera_pdf_stp()
    {
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
		$mpdf->SetHTMLHeader('');

        $idcompanie = $this->session->userdata('datosUsuario')['id_company'];

        $unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

        $querykyc = "SELECT * FROM stp_kyc WHERE idCompanie = $idcompanie"; 
        $querypt = "SELECT * FROM stp_perfiltransaccional WHERE idCompanie = $idcompanie";
        $queryu = "SELECT * FROM stp_usuarios WHERE idCompanie = $idcompanie";
        $queryco = "SELECT * FROM stp_contactos WHERE idCompanie = $idcompanie AND Area = 1";
        $querycs = "SELECT * FROM stp_contactos WHERE idCompanie = $idcompanie AND Area = 2";
        $querycc = "SELECT * FROM stp_contactos WHERE idCompanie = $idcompanie AND Area = 3";
        $querycj = "SELECT * FROM stp_contactos WHERE idCompanie = $idcompanie AND Area = 4";


        if ($ResKyc = $this->db->query($querykyc )) {
			$RResKyc = $ResKyc->result_array();
            foreach($RResKyc AS $value)
			{
                $personalc = $value["PersonalC"];
                $origene = $value["OrigenE"];
                $dedicae = $value["DedicaE"];
                $serviciosc = $value["ServiciosC"];
                $usarac = $value["UsaraC"];
                $recursos = $value["Recursos"];
                $medios = $value["Medios"];
            }
        }

        if($ResPt = $this->db->query($querypt)) {
            $RResPt = $ResPt->result_array();
            foreach($RResPt AS $valuept)
            {
                $saldomensualcobro = $valuept["SaldoMensualCobro"];
                $saldomensualpago = $valuept["SaldoMensualPago"];
                $transaccionescobro = $valuept["TransaccionesCobro"];
                $transaccionespago = $valuept["TransaccionesPago"];
                $origenrecursos = $valuept["OrigenRecursos"];
                $destinorecursos = $valuept["DestinoRecursos"];
                $manejoefectivo = $valuept["ManejoEfectivo"];
                $formaoperar = $valuept["FormaOperar"];
                $servicio247 = $valuept["Servicio247"];
            }
        }

        $cadena='<html lang="es-MX">
				<head>
					<style>
					*{
						margin: 0;
						padding: 0;
						box-sizing: border-box;
						font-family: Verdana;
						font-size: 12px;
					}
                    body{
                        padding: 20px 40px;
                    }
                    h1{
                        display: block;
                        text-align: center;
                        font-size: 26px;
                        margin: 0px;
                        paddin: 0px;
                        color: #224689;
                    }
					h3{
						display: block;
						text-align: left;
						font-size: 14px;
						margin: 0px;
						padding: 0px;
                        color: #224689;
					}
					p{
						display: block;
						text-align: justify;
						font-family: Arial;
						margin: 20px;
						padding: 20px;
					}
					.tabla{
						margin: auto;
						border-spacing: 0 !important;
						border-collapse: collapse !important;
                        width: 100%;
					}
					th{
						padding: 10px 20px;
						text-align: center;
						background: #ccc;
						border: 1px solid #000;
						font-family: Arial;
                        color: #ffffff;
                        background-color: #224689;
					}
					td{
						padding: 10px 20px;
						text-align: center;
						background: #fff;
						border: 1px solid #000;
						font-family: Arial;
					}
					.pageBreak{
						page-break-before: always;
					}
                    .respuesta{
                        color: #224689;
                        text-decoration: underline;
                    }

					</style>
				</head>
				<body>
				
					<h1>Formato Solicitud de Servicio STP</h1>

                    <h3>KYC</h3>

                    <p>Como parte de la solicitud de servicio STP, requerimos su apoyo para contestar el siguiente cuestionario:</p>

                    <ol>
                        <li>Personal contactado para entregar la documentación e información (nombre y cargo): 
                            <br /><span class="respuesta">'.$personalc.'</span></li>
                        <li>Mencionar origen de la empresa, giro del negocio, mercado objetivo, si forman parte de algún grupo empresarial en México o en el extranjero, etc.: 
                            <br /><span class="respuesta">'.$origene.'</span></li>
                        <li>&nbsp;
                            <ul>
                                <li> Mencionar ¿a qué se dedica la empresa?: <span class="respuesta">';
        switch($dedicae){
            case 1: $cadena.='Agregador de pagos'; break;
            case 2: $cadena.='Caja de ahorrros'; break;
            case 3: $cadena.='Casa de bolsa'; break;
            case 4: $cadena.='Comercio'; break;
            case 5: $cadena.='Crowdfunding'; break;
            case 6: $cadena.='Desarrollo de software'; break;
            case 7: $cadena.='Escolar'; break;
            case 8: $cadena.='Factoraje y arrendamiento'; break;
            case 9: $cadena.='Financiero- Criptomonedas y/o Activos Virtuales'; break;
            case 10: $cadena.='>Financiero- NO Regulado (SOFOM)'; break;
            case 11: $cadena.='Financiero- Regulado (SOFIPO & SOCAP)'; break;
            case 12: $cadena.='Financiero- Regulado (SOFOM)'; break;
            case 13: $cadena.='Fondo de inversión'; break;
            case 14: $cadena.='Inmobiliaria - Administración'; break;
            case 15: $cadena.='Inmobiliaria - Comercialización'; break;
            case 16: $cadena.='Inmobiliaria - Construcción'; break;
            case 17: $cadena.='Interno'; break;
            case 18: $cadena.='Manufactura'; break;
            case 19: $cadena.='Mutuo, préstamo o crédito'; break;
            case 20: $cadena.='Nómina a terceros'; break;
            case 21: $cadena.='Pago de servicios'; break;
            case 22: $cadena.='Remesas- Transmisor Extranjeros'; break;
            case 23: $cadena.='Remesas- Transmisor Nacional'; break;
            case 24: $cadena.='Remesas- Transmisor Nacional'; break;
            case 25: $cadena.='SAB DE CV'; break;
            case 26: $cadena.='SAPI DE CV'; break;
            case 27: $cadena.='Seguros y Fianzas'; break;
            case 28: $cadena.='Servicios - Alimentos'; break;
            case 29: $cadena.='Servicios - Contabilidad y auditoría'; break;
            case 30: $cadena.='Servicios - Consultoría'; break;
            case 31: $cadena.='Servicios - Juegos y Apuestas'; break;
            case 32: $cadena.='Servicios - Mensajería y Paquetería'; break;
            case 33: $cadena.='Servicios - Mercadotecnia y Publicidad'; break;
            case 34: $cadena.='Servicios - Mantenimiento y Limpieza'; break;
            case 35: $cadena.='Servicios - Perforación de pozos'; break;
            case 36: $cadena.='Servicios - Tarjeta de servicios y/o Crédito'; break;
            case 37: $cadena.='Servicios agrícolas, ganaderas, silvívolas y pesqueras'; break;
            case 38: $cadena.='Servicios - Energía Renovable'; break;
            case 39: $cadena.='Servicios - Gasera'; break;
            case 40: $cadena.='Servicios - Gasolinera'; break;
            case 41: $cadena.='Servicios - Telecomunicaciones'; break;
            case 42: $cadena.='Servicios - Telepeaje'; break;
            case 43: $cadena.='Servicios - Transporte'; break;
            case 44: $cadena.='Servicios - Salud'; break;
            case 45: $cadena.='Servicios - Seguridad y alarmas'; break;
            case 46: $cadena.='Sindicato'; break;
            case 47: $cadena.='Tarjetas de prepago, cupones, devoluciones y recompensas'; break;
            case 48: $cadena.='Wallet'; break;
        }
        $cadena.='              </span></li>
                                <li>¿Qué servicios implementarán en la cuenta?: <span class="respuesta">';
        switch ($serviciosc){
            case 1: $cadena.='Dispersión'; break;
			case 2: $cadena.='Cobranza'; break;
			case 3: $cadena.='CODI'; break;
			case 4: $cadena.='CEP'; break;
			case 5: $cadena.='Pago de servicios'; break;
			case 6: $cadena.='Participación Indirecta'; break;
        }
        $cadena.='              </span></li>
                                <li>Indicar ¿para qué usarán la cuenta de STP?:
                                    <br /><span class="respuesta">'.$usarac.'</span></li>
                            </ul>
                        </li>
                        <li>Mencionar, ¿de dónde provienen los recursos (con los que opera la empresa) ?, sobre todo para el caso de reciente constitución o de propietarios reales no nacionales:
                            <br /><span class="respuesta">'.$recursos.'</span></li>
                        <li>Indicar medios válidos (link) por los que captan a sus clientes (página web, app, facebook, instagram, etc.) o en su defecto indicar cómo atraen:
                            <br /><span class="respuesta">'.$medios.'</span></li>
                    </ol>

                    <h3>Perfil Transaccional</h3>

                    <p>Para esta sección colocar el saldo mensual esperado de cobro y pago en pesos mexicanos; y la información solicitada: </p>

                    <table class="tabla">
                        <tr>
                            <td style="width: 25%; text-align: left; color: #fff; background-color: #224689;">Saldo mensual<br />esperado de cobro: </td>
                            <td style="width: 25%; text-align: right">$ '.number_format($saldomensualcobro, 2).'</td>
                            <td style="width: 25%; text-align: left; color: #fff; background-color: #224689;">Saldo mensual<br />esperado de pago:</td>
                            <td style="width: 25%; text-align: right">$ '.number_format($saldomensualpago,2).'</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left; color: #fff; background-color: #224689;">Núm. de<br />transacciones<br />esperadas de cobro:</td>
                            <td style="width: 25%; text-align: right">'.$transaccionescobro.'</td>
                            <td style="width: 25%; text-align: left; color: #fff; background-color: #224689;">Núm. de<br />transacciones<br />esperadas de pago:</td>
                            <td style="width: 25%; text-align: right;">'.$transaccionespago.'.</td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left; color: #fff; background-color: #224689;">Origen de los<br />recursos:</td>
                            <td style="width: 25%; text-align: right;">';
        switch ($origenrecursos)   
        {
            case 1 : $cadena.='Pagos de Clientes'; break;
			case 2 : $cadena.='Arrendamientos de inmuebles (Rentas)'; break;
			case 3 : $cadena.='Recursos de Terceros'; break;
			case 4 : $cadena.='Aportaciones a Capital de accionistas'; break;
			case 5 : $cadena.='Cobranza de créditos'; break;
			case 6 : $cadena.='Aportaciones o Cuotas Sindicales'; break;
			case 7 : $cadena.='Cuenta Puente Para Inversión '; break;
			case 8 : $cadena.='Préstamos'; break;
			case 9 : $cadena.='Manejo de Divisas'; break;
			case 10: $cadena.='Desarrollo del Giro del Negocio'; break;
			case 11: $cadena.='Tesorería-Capital de Trabajo del Negocio'; break;
			case 12: $cadena.='Partidas Presupuestales'; break;
			case 13: $cadena.='Negocio Propio'; break;
			case 14: $cadena.='Herencia/Donación'; break;
        }                 
        $cadena.='           </td>
                            <td style="width: 25%; text-align: left; color: #fff; background-color: #224689;">Destino de los<br />recursos:</td>
                            <td style="width: 25%; text-align: right;">';
        switch ($destinorecursos){
            case 1 : $cadena.='Administración de Gastos'; break;
			case 2 : $cadena.='Administración de Pagos de Bienes '; break;
			case 3 : $cadena.='Administración de Pagos de Servicios'; break;
			case 4 : $cadena.='Administración de Inversiones'; break;
			case 5 : $cadena.='Concentración y Dispersión de Fondos'; break;
			case 6 : $cadena.='Pago a Comisionistas'; break;
			case 7 : $cadena.='Pago de Renta o Compra de Bienes'; break;
			case 8 : $cadena.='Pago a Proveedores'; break;
			case 9 : $cadena.='Dispersión de Créditos'; break;
			case 10: $cadena.='Pago de Nómina/Primas de Seguro'; break;
			case 11: $cadena.='Impuestos/Pago de Servicios'; break;
			case 12: $cadena.='Cuenta Puente Para Inversión'; break;
			case 13: $cadena.='Pago Dividendos Accionistas'; break;
        }
        $cadena.='          </td>
                        </tr>
                    </table>

                    <p></p>

                    <table class="tabla">
                        <tr>
                            <td style="width: 50%; text-align: center; color: #fff; background-color: #224689;">Manejo de Efectivo: </td>
                            <td style="width: 50%; text-align: center;">';
        switch($manejoefectivo){
            case 1: $cadena.='21 a 50 %'; break;
			case 2: $cadena.='Hasta 20%'; break;
			case 3: $cadena.='Más de 51%'; break;
			case 4: $cadena.='No Manejo Efectivo'; break;
        }
        $cadena.='          </td>
                        </tr>
                        <tr>
                            <td style="width: 50% text-align: center; color: #fff; background-color: #224689;">Forma de operar: </td>
                            <td style="width: 50% text-align: center;">';
        switch ($formaoperar)
        {
            case 1: $cadena.='Manual'; break;
			case 2: $cadena.='Integrado'; break;
        }
        $cadena.='          </td>
                        </tr>
                    </table>

                    <p>Confirmar si desean operar con el servicio 24/ 7 (costo adicional de 1500 USD) o servicio estándar:
                        <br /><span class="respuesta">';
        switch ($servicio247)
        {
            case 1: $cadena.='Servicio Estándar </span></p>'; break;
			case 2: $cadena.='Servicio 24/7 </span></p>'; break;
        }
                    
        $cadena.='  <h3>Usuarios: Enlace Financiero	</h3>

                    <p>Por medio del presente, solicitamos se proporcionen los siguientes datos de los usuarios que tendrán acceso para operar en Enlace Financiero considerando los siguientes perfiles:  </p>

                    <p><trong>PERFILES.</strong> <em>- 1) Administrador: Captura, Consulta y Autoriza - no operaciones propias, 2) Autorizador: Consulta y Autoriza, 3) Captura: Consulta y Captura, 4) Consulta (ve movimientos y saldo de la empresa) y 5) Consulta Históricos (ve solo movimientos, no saldo)</em></p>

                    <table class="tabla">
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Correo Electrónico</th>
                                <th>Fecha de Nacimiento</th>
                                <th># Celular</th>
                                <th>Perfil</th>
                            </tr>
                        </thead>
                        <tbody>';
        if($ResU = $this->db->query($queryu))
        {
            $RResU = $ResU->result_array();
            foreach($RResU AS $valueu)
            {
                $cadena.='  <tr>
                                <td>'.$valueu["Nombre"].'</td>
                                <td>'.$valueu["CorreoE"].'</td>
                                <td>'.$valueu["FechaNacimiento"].'</td>
                                <td>'.$valueu["Celular"].'</td>
                                <td>';
                switch ($valueu["Perfil"])
                {
                    case 1: $cadena.='1) Administrador'; break;
					case 2: $cadena.='2) Autorizador'; break;
					case 3: $cadena.='3) Captura'; break;
					case 4: $cadena.='4) Consulta'; break;
					case 5: $cadena.='5) Consulta Históricos'; break;
                }
                $cadena.='      </td>
                            </tr>';
            }
        }
        $cadena.='      </tbody>
                    </table>

                    <h3>Contactos Autorizados</h3>

                    <p>A continuación colocar a las personas/responsables de las áreas indicadas en los recuadros siguientes, serán los únicos autorizados para solicitar/proporcionar información relacionada con la empresa de acuerdo con su respectiva área </p>

                    <table class="tabla">
                        <thead>
                            <tr>
                                <th colspan="5">Responsable(s) Operativo(s):</th>
                            </tr>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Teléfono</th>
                                <th>Extensión</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                            </tr>
                        </tehad>
                        <tbody>';
        if($ResCo = $this->db->query($queryco))
        {
            $RResCo = $ResCo->result_array();
            foreach($RResCo AS $valueco)
            {
                $cadena.='  <tr>
                                <td>'.$valueco["Nombre"].'</td>
                                <td>'.$valueco["Telefono"].'</td>
                                <td>'.$valueco["Extension"].'</td>
                                <td>'.$valueco["Celular"].'</td>
                                <td>'.$valueco["CorreoE"].'</td>
                            </tr>';
            }
        }
        $cadena.='      </tbody>
                    </table>

                    <p></p>

                    <table class="tabla">
                        <thead>
                            <tr>
                                <th colspan="5">Responsable(s) del área de Sistemas:</th>
                            </tr>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Teléfono</th>
                                <th>Extensión</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                            </tr>
                        </tehad>
                        <tbody>';
        if($ResCs = $this->db->query($querycs))
        {
            $RResCs = $ResCs->result_array();
            foreach($RResCs AS $valuecs)
            {
                $cadena.='  <tr>
                                <td>'.$valuecs["Nombre"].'</td>
                                <td>'.$valuecs["Telefono"].'</td>
                                <td>'.$valuecs["Extension"].'</td>
                                <td>'.$valuecs["Celular"].'</td>
                                <td>'.$valuecs["CorreoE"].'</td>
                            </tr>';
            }
        }
        $cadena.='      </tbody>
                    </table>

                    <p></p>

                    <table class="tabla">
                        <thead>
                            <tr>
                                <th colspan="5">Responsable(s) del área de Cuentas por Pagar:</th>
                            </tr>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Teléfono</th>
                                <th>Extensión</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                            </tr>
                        </tehad>
                        <tbody>';
        if($ResCc = $this->db->query($querycc))
        {
            $RResCc = $ResCc->result_array();
            foreach($RResCc AS $valuecc)
            {
                $cadena.='  <tr>
                                <td>'.$valuecc["Nombre"].'</td>
                                <td>'.$valuecc["Telefono"].'</td>
                                <td>'.$valuecc["Extension"].'</td>
                                <td>'.$valuecc["Celular"].'</td>
                                <td>'.$valuecc["CorreoE"].'</td>
                            </tr>';
            }
        }
        $cadena.='      </tbody>
                    </table>

                    <p></p>

                    <table class="tabla">
                        <thead>
                            <tr>
                                <th colspan="5">Responsable(s) Jurídico y/o Oficial de Cumplimiento:</th>
                            </tr>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Teléfono</th>
                                <th>Extensión</th>
                                <th>Celular</th>
                                <th>Correo Electrónico</th>
                            </tr>
                        </tehad>
                        <tbody>';
        if($ResCj = $this->db->query($querycj))
        {
            $RResCj = $ResCj->result_array();
            foreach($RResCj AS $valuecj)
            {
                $cadena.='  <tr>
                                <td>'.$valuecj["Nombre"].'</td>
                                <td>'.$valuecj["Telefono"].'</td>
                                <td>'.$valuecj["Extension"].'</td>
                                <td>'.$valuecj["Celular"].'</td>
                                <td>'.$valuecj["CorreoE"].'</td>
                            </tr>';
            }
        }
        $cadena.='      </tbody>
                    </table>

                </body>
            </html>';

        //echo $cadena;

        $mpdf->WriteHTML($cadena);
        $ruta = __DIR__ . '/../../boveda/'.$unique.'/RegistroStp_'.$idcompanie.'.pdf';
        $mpdf->Output($ruta, 'F');

        return TRUE;
    }

}

