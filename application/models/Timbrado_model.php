<?php 
class Timbrado_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function empresa(){
		$idCompanie = $this->session->userdata('datosEmpresa')['id'];

        return $idCompanie;
	}

    public function timbrado(){
        $idCompanie = $this->session->userdata('datosEmpresa')['id'];

        //clientes
        $ResClientes = "SELECT c.legal_name, c.id FROM clientprovider  AS cp 
                        INNER JOIN companies AS c ON c.id = cp.client_id 
                        WHERE cp.provider_id='".$idCompanie."' 
                        ORDER BY c.legal_name ASC ";
        if ($RResClientes = $this->db->query($ResClientes)) {
            if ($RResClientes->num_rows() > 0){
                $RResC = $RResClientes->result_array();
            }
            else {
                $RResC = '';
            }
        }

        //uso cfdi
        $ResUsoCfdi = "SELECT * FROM c_usocfdi ORDER BY UsoCFDI ASC";
        if ($RResUsoCfdi = $this->db->query($ResUsoCfdi)) {
            if ($RResUsoCfdi->num_rows() > 0){
                $RResUCFDI = $RResUsoCfdi->result_array();
            }
            else {
                $RResUCFDI = '';
            }
        }

        //formas de pago
        $ResFormasPago = "SELECT * FROM c_formadepago ORDER BY c_FormaPago ASC";
        if ($RResFormasPago = $this->db->query($ResFormasPago)) {
            if ($RResFormasPago->num_rows() > 0){
                $RResFP = $RResFormasPago->result_array();
            }
            else {
                $RResFP = '';
            }
        }

		//unidades
		$ResUnidad = "SELECT cu.Id, cu.ClaveUnidad, cu.Descripcion FROM c_claveunidad AS cu 
						INNER JOIN c_claveunidad_emp AS cue ON cu.Id=cue.IdClaveUnidad
						WHERE cue.Empresa = '".$idCompanie."' ORDER BY cu.ClaveUnidad ASC";
		if ($RResUnidad = $this->db->query($ResUnidad)) {
			if ($RResUnidad->num_rows() > 0){
				$RResU = $RResUnidad->result_array();
			}
			else {
				$RResU = '';
			}
		}

		//productos y servicios
		$ResProdServ= "SELECT cp.Id, cp.ClaveProdServ, cp.Descripcion FROM c_claveprodserv AS cp 
						INNER JOIN c_claveprodserv_emp AS cpe ON cp.Id=cpe.IdClaveProdServ
						WHERE cpe.Empresa = '".$idCompanie."' ORDER BY cp.ClaveProdServ ASC";
		if ($RResProdServ = $this->db->query($ResProdServ)) {
			if ($RResProdServ->num_rows() > 0){
				$RResPS = $RResProdServ->result_array();
			}
			else {
				$RResPS = '';
			}
		}

        //respuesta
        $res_array = array (
            "clientes" => $RResC,
            "usocfdi" => $RResUCFDI,
            "formasdepago" => $RResFP,
			"unidad" => $RResU,
			"prodserv" => $RResPS,
			"empresa" => $idCompanie
        );

		return $res_array;
    }

    public function partidas($partida){

        $pr = array(
            "partida" => $partida
        );

        return $pr;
    }

    public function guardar_factura($factura){

        $idCompanie = $this->session->userdata('datosEmpresa')['id'];

        //emisor
        $ResEmisor = "SELECT * FROM companies AS c 
                        INNER JOIN cat_zipcode AS zc ON zc.zip_id = c.id_postal_code 
                        INNER JOIN cat_regimenfiscal AS rf ON rf.rg_id = c.id_fiscal
                        WHERE c.id='".$idCompanie."' LIMIT 1";

        if ($RResE = $this->db->query($ResEmisor)) {
            if ($RResE->num_rows() > 0){
                $Emisor = $RResE->result_array();
            }
            else {
                $Emisor = '';
            }
        }

        //receptor
        $ResReceptor = "SELECT * FROM companies AS c 
                        INNER JOIN cat_zipcode AS zc ON zc.zip_id = c.id_postal_code 
                        INNER JOIN cat_regimenfiscal AS rf ON rf.rg_id = c.id_fiscal
                        WHERE c.id='".$factura["cliente"]."' LIMIT 1";

        if ($RResR = $this->db->query($ResReceptor)) {
            if ($RResR->num_rows() > 0){
                $Receptor = $RResR->result_array();
            }
            else {
                $Receptor = '';
            }
        }

        //Uso CFDI
        $usoCFDI = "SELECT * FROM c_usocfdi WHERE Id='".$factura["usocfdi"]."' LIMIT 1";

        if ($Rucfd = $this->db->query($usoCFDI)) {
            if ($Rucfd->num_rows() > 0){
                $RRuCfdi = $Rucfd->result_array();
            }
            else {
                $RRuCfdi = '';
            }
        }

        $fechafactura=date('d-m-Y').'T'.date('H:i:s');

        //crea cadena original
        //version
		$cadenaoriginal='||4.0|';
        //fecha
		$cadenaoriginal.$fechafactura.'|';
        //formadepago
        $cadenaoriginal.=$factura["formadepago"].'|';
        //numero de certificado
		$cadenaoriginal.='AQUIVAELNUMERODELCERTIFICADO//DELETETHISMOTHERLATER|';
        //subtotal
		$cadenaoriginal.=number_format($factura["subtotalf"],2,'.','').'|';
        //descuento
		if($factura["descuento"]>0)
		{
			$desc='0.'.$factura["descueto"];
			$sdescuento=$factura["subtotalf"]*$desc;
			$cadenaoriginal.=number_format($sdescuento, 2, '.', '').'|';
		}
        //Moneda
		$cadenaoriginal.=$factura["moneda"].'|';
        //Tipo de Cambio
		if($factura["tipocambio"]==1){$cadenaoriginal.='1|';}else{$cadenaoriginal.=$factura["tipocambio"].'|';}
        //Total
		$cadenaoriginal.=number_format($factura["totalf"],2,'.','').'|';
        //Tipo de comprobante
		$cadenaoriginal.='I|';
        //Exportación
		$cadenaoriginal.='01|';
        //metodo de pago
		$cadenaoriginal.=$factura["metododepago"].'|';
        //lugar de expedicion
		$cadenaoriginal.=$Emisor[0]["zip_code"].'|';
        //certificados relacionados 
		//if($factura["sustituyefactura"]!=0)
		//{
		//	//tipo relacionado
		//	$cadenaoriginal.='04|';
		//	//uuid
		//	$cadenaoriginal.=$uuid_rel["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"].'|';
		//}
        //emisor
		//rfc del emisor
		$cadenaoriginal.=$Emisor[0]["rfc"].'|';
        //nombre del emisor
		$cadenaoriginal.=$Emisor[0]["legal_name"].'|';
        //regimen fiscal del emisor
		$cadenaoriginal.=$Emisor[0]["rg_clave"].'|';
        //receptor
		//rfc del receptor
		$cadenaoriginal.=$Receptor[0]["rfc"].'|';
        //nombre del receptor
		$cadenaoriginal.=$Receptor[0]["legal_name"].'|';
        //Domicilio Fiscal Receptor
		$cadenaoriginal.=$Receptor[0]["zip_code"].'|';
        //Regimen fiscal receptor
		$cadenaoriginal.=$Receptor[0]["rg_clave"].'|';
        //Uso CFDI
		$cadenaoriginal.=$RRuCfdi[0]["UsoCFDI"].'|';
        //conceptos
        foreach($factura["partidas"] AS $value)
        {
            //Clave Producto/Servicio
			$cadenaoriginal.=$value[3].'|';
            //cantidad
			$cadenaoriginal.=$value[1].'|';
            //Clave Unidad
			$cadenaoriginal.=$value[2].'|';
            //Unidad
			//if($RResPartidas["Unidad"]!='')
			//{
			//	$cadenaoriginal.=$RResPartidas["Unidad"].'|';
			//}
            //Descripcion
			$cadenaoriginal.=$value[5].'|';	
            //Valor Unitario
			$cadenaoriginal.=$value[6].'|';
            //importe
			$cadenaoriginal.=$value[7].'|';
            //objeto impuesto
			if($value[11]>0.00)
			{
				$cadenaoriginal.='02|';
			}
			elseif($value[11]==0.00)
			{
				$cadenaoriginal.='01|';
			}
            //Impuestos
			//Traslados
			if($value[8]==1)
			{
				//Base
				$cadenaoriginal.=$value[7].'|';
				//Impuesto iva
				$cadenaoriginal.='002|';
				//Tipo Factor
				$cadenaoriginal.='Tasa|';
				//Tasa o Cuota
				$cadenaoriginal.='0.160000|';
				//Importe
				$cadenaoriginal.=$value[11].'|';
			}
            //Retenciones
			//retencion iva
			if($value[9]==1)
			{
				//Base
				$cadenaoriginal.=$value[7].'|';
				//impuesto iva
				$cadenaoriginal.='002|';
				//Tipo Factor
				$cadenaoriginal.='Tasa|';
				//Tasa o Cuota
				$cadenaoriginal.=number_format(($factura["retiva"]/100),6,'.','').'|';
				//importe
				$cadenaoriginal.=$value[12].'|';
			}
            //retencion isr
			if($value[10]>0)
			{
				//Base
				$cadenaoriginal.=$value[7].'|';
				//impuesto iva
				$cadenaoriginal.='001|';
				//Tipo Factor
				$cadenaoriginal.='Tasa|';
				//Tasa o Cuota
				$cadenaoriginal.='0.100000|';
				//importe
				$cadenaoriginal.=$value[13].'|';
			}
        }
        //impuestos
		//Retenciones
		//retencion iva
		if($factura["riva"]>0)
		{
			//impuesto
			$cadenaoriginal.='002|';
			//importe
			$cadenaoriginal.=number_format($factura["riva"],2,'.','').'|';
		}
        //retencon isr
		if($factura["risr"]>0)
		{
			//impuesto
			$cadenaoriginal.='001|';
			//importe
			$cadenaoriginal.=number_format($factura["risr"],2,'.','').'|';
		}
        //tralados
		//base
		$cadenaoriginal.=number_format($factura["subtotalf"], 2, '.', '').'|';
        //impuesto
		$cadenaoriginal.='002|';
        //Tipo Factor
		$cadenaoriginal.='Tasa|';
        //tasa o cuota
		if($factura["ivaf"]>0)
		{
			$cadenaoriginal.='0.160000|';
		}
		else
		{
			$cadenaoriginal.='0.000000|';
		}
        //importe
		$cadenaoriginal.=number_format($factura["ivaf"],2,'.','').'|'.number_format($factura["ivaf"],2,'.','').'||';
        //reemplaza espacios en blanco
		$cadenaoriginal=str_replace(' | ','|',$cadenaoriginal);
		$cadenaoriginal=str_replace(' |','|',$cadenaoriginal);
		$cadenaoriginal=str_replace('| ','|',$cadenaoriginal);
		$cadenaoriginal=str_replace('  ',' ',$cadenaoriginal);

        //sellamos cadena
		//guardamos en archivo
		//$fp = fopen ("certificados2/sellos2/".$idfactura["Id"].".txt", "w+");
        //fwrite($fp, $cadenaoriginal);
        //fclose($fp);
        ////archivo .key
        //$key='certificados/'.$ResFFacturas["ArchivoCadena"];
        ////sellamos archivo
        //exec("openssl dgst -sha256 -sign $key certificados2/sellos2/".$idfactura["Id"].".txt | openssl enc -base64 -A > certificados2/sellos2/sello_".$idfactura["Id"].".txt");
        ////leer sello
        //$f=fopen("certificados2/sellos2/".$idfactura["Id"].".txt",'r');
        //$selloemisor=file_get_contents('certificados2/sellos2/sello_'.$idfactura["Id"].'.txt');
        //fclose($f);

        //generamos el XML
		//$cer=file_get_contents('certificados/'.$ResFFacturas["NumCertificado"].'.cer.pem'); //leemos el certificado
		//$cer1=str_replace('-----BEGIN CERTIFICATE-----','',$cer);
		//$certificado=str_replace('-----END CERTIFICATE-----','',$cer1);
		$certificado='AQUIVAELCERTIFICADOYAPROCESADO';

        $xml='<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante';
        //version
		$xml.=' Version="4.0"';
        //fecha
		$xml.=' Fecha="'.$fechafactura.'"';
        //sello
		//$xml.=' Sello="'.file_get_contents('certificados2/sellos2/sello_'.$idfactura["Id"].'.txt').'"';
		$xml.=' Sello="AQUIVAELSELLODELAFACTURA"';
        //forma de pago
		$xml.=' FormaPago="'.$factura["formadepago"].'"';
        //No. de certificado
		$xml.=' NoCertificado="00001000000519410674"';
        //certificado
		$xml.=' Certificado="'.$certificado.'"';
        //subtotal
		$xml.=' SubTotal="'.number_format($factura["subtotalf"],2,'.','').'"';
        //Moneda
		$xml.=' Moneda="'.$factura["moneda"].'"';
        //TipoCambio
		if($factura["tipocambio"]==1){$xml.=' TipoCambio="1"';}else{$xml.=' TipoCambio="'.$factura["tipocambio"].'"';}
        //total
		$xml.=' Total="'.number_format($factura["totalf"],2,'.','').'"';
        //tipo de comprobante
		$xml.=' TipoDeComprobante="I"';
        //Exportacion
		$xml.=' Exportacion="01"';
        //metodo de pago
		$xml.=' MetodoPago="'.$factura["metododepago"].'"';
        //Lugar de expedicion
		$xml.=' LugarExpedicion="'.$Emisor[0]["zip_code"].'"';
        //xsi
		$xml.=' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        //cfdi
		$xml.=' xmlns:cfdi="http://www.sat.gob.mx/cfd/4"';
        //schemaLocation
		$xml.=' xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd">';
        //cfdi relacionado
		//if($ResFactura["SustituyeFactura"]!=0)
		//{
		//	$xml.='<cfdi:CfdiRelacionados TipoRelacion="04">
		//		<cfdi:CfdiRelacionado UUID="'.$uuid_rel["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"].'" />
		//	</cfdi:CfdiRelacionados>';
		//}
        //Emisor
		//RFC
		$xml.='<cfdi:Emisor Rfc="'.$Emisor[0]["rfc"].'"';
        //nombre
		$xml.=' Nombre="'.$Emisor[0]["legal_name"].'"';
        //regimen fiscal
		$xml.=' RegimenFiscal="'.$Emisor[0]["rg_clave"].'" />';
        //receptor
		//rfc
		$xml.='<cfdi:Receptor Rfc="'.$Receptor[0]["rfc"].'"';
        //nombre
		$xml.=' Nombre="'.$Receptor[0]["legal_name"].'"';
        //Domicilio fiscal receptor
		$xml.=' DomicilioFiscalReceptor="'.$Receptor[0]["zip_code"].'"';
        //regimen fiscal receptor
		$xml.=' RegimenFiscalReceptor="'.$Receptor[0]["rg_clave"].'"';
        //uso cfdi
		$xml.=' UsoCFDI="'.$RRuCfdi[0]["UsoCFDI"].'" />';
        //Conceptos
		$xml.='<cfdi:Conceptos>';
        //partidas
		foreach($factura["partidas"] AS $value)
		{
            //Clave Producto/Servicio
			$xml.='<cfdi:Concepto ClaveProdServ="'.$value[3].'"';
            //Num. Identificacion (clave)
			$xml.=' NoIdentificacion="'.$value[4].'"';
            //cantidad
			$xml.=' Cantidad="'.$value[1].'"';
            //Clave Unidad
			$xml.=' ClaveUnidad="'.$value[2].'"';
            //Unidad
			//if($RResPartidasX["Unidad"]!='')
			//{
			//	$xml.=' Unidad="'.$RResPartidasX["Unidad"].'"';
			//}
            //Descripcion
			$xml.=' Descripcion="'.$value[5].'"';
            //Valor Unitario
			$xml.=' ValorUnitario="'.$value[6].'"';
            //importe
			$xml.=' Importe="'.$value[7].'"';
            //objeto impuesto
			if($value[11]>0.00)
			{
				$xml.=' ObjetoImp="02"';
			}
			elseif($value[11]==0.00)
			{
				$xml.=' ObjetoImp="01"';
			}
            $xml.='>';
            //Impuestos
			//Traslados
			//Base
			$xml.='<cfdi:Impuestos>';
            if($value[8]==1)
			{
				$xml.='<cfdi:Traslados><cfdi:Traslado Base="'.$value[7].'"';
                //Impuesto iva
				$xml.=' Impuesto="002"';
                //Tipo Factor
				$xml.=' TipoFactor="Tasa"';
                //Tasa o Cuota
				$xml.=' TasaOCuota="0.160000"';
                //Importe
				$xml.=' Importe="'.$value[11].'" /></cfdi:Traslados>';
            }
			//Retenciones
			if($value[9]>0 OR $value[10]>0)
			{
				$xml.='<cfdi:Retenciones>';
			}
            //retencion iva
			if($value[9]>0)
			{
                //Base
				$xml.='<cfdi:Retencion Base="'.$value[7].'"';
                //impuesto iva
				$xml.=' Impuesto="002"';
                //Tipo Factor
				$xml.=' TipoFactor="Tasa"';
                //Tasa o Cuota
				$xml.=' TasaOCuota="'.number_format(($factura["retiva"]/100),6,'.','').'"';
                //importe
				$xml.=' Importe="'.$value[12].'" />';
            }
			//retencion isr
			if($value[10]>0)
			{
                //Base
				$xml.='<cfdi:Retencion Base="'.$value[7].'"';
                //impuesto iva
				$xml.=' Impuesto="001"';
                //Tipo Factor
				$xml.=' TipoFactor="Tasa"';
                //Tasa o Cuota
				$xml.=' TasaOCuota="0.100000"';
                //importe
				$xml.=' Importe="'.$value[13].'" />';
            }
			if($value[9]>0 OR $value[10]>0)
			{
				$xml.='</cfdi:Retenciones>';
			}
			$xml.='</cfdi:Impuestos></cfdi:Concepto>';
        }
		$xml.='</cfdi:Conceptos>';
        //Impuestos
		$xml.='<cfdi:Impuestos';
        if($factura["riva"]>0 OR $factura["risr"]>0)
		{
			$xml.=' TotalImpuestosRetenidos="'.number_format(($factura["riva"]+$ResFactura["RetISR"]),2,'.','').'"';
		}
        $xml.=' TotalImpuestosTrasladados="'.number_format($factura["ivaf"],2,'.','').'">';
        //retenciones
		if($factura["riva"]>0 OR $factura["risr"]>0)
		{
			$xml.='<cfdi:Retenciones>';
		}
        //retencion iva
		if($factura["riva"]>0)
		{
			$xml.='<cfdi:Retencion Importe="'.number_format($factura["riva"],2,'.','').'" Impuesto="002" />';
		}
        //retencion isr
		if($factura["risr"]>0)
		{
			$xml.='<cfdi:Retencion Importe="'.number_format($factura["risr"],2,'.','').'" Impuesto="001" />';
		}
        if($factura["riva"]>0 OR $factura["risr"]>0)
		{
			$xml.='</cfdi:Retenciones>';
		}
        //traslados
		if($factura["ivaf"]>0)
		{
            $xml.='<cfdi:Traslados><cfdi:Traslado';
            //base
			$xml.=' Base="'.number_format($factura["subtotalf"], 2, '.', '').'"';
            //impuesto
			$xml.=' Impuesto="002"';
            //tipo factor
			$xml.=' TipoFactor="Tasa"';
            //importe
			$xml.=' Importe="'.number_format($factura["ivaf"],2,'.','').'" /></cfdi:Traslados>';
		}
        $xml.='</cfdi:Impuestos>';
		$xml.='</cfdi:Comprobante>';

        $xml=str_replace('&', '&amp;', $xml);


        //print_r($Emisor);

        //echo '<br /><br />';

        //print_r($Receptor);

        //echo '<br /><br />';

        echo $cadenaoriginal;

        echo '<br /><br />';

        $xml=str_replace('<','&lt;',$xml);
        $xml=str_replace('>','&gt;',$xml);

        echo '<pre><code>'.$xml.'</code></pre>';


        //crea xml

        //guardar en db

    }
}
