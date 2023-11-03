<?php 

 



require('fpdf/fpdf.php');

require('xml2array.php');



//conecto a la base de datos

include("../conexion.php");

//LIBRERIA QR

include ("phpqrcode/qrlib.php"); 

//set it to writable location, a place for temp generated PNG files

$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

//html PNG location prefix

$PNG_WEB_DIR = 'temp/';



//recibo el id de la factura

if(isset($_POST["idfactura"])){$idfactura=$_POST["idfactura"];}

elseif(isset($_GET["idfactura"])){$idfactura=$_GET["idfactura"];}



//datos de la factura

$ResFactura=mysql_fetch_array(mysql_query("SELECT * FROM facturas WHERE Id='".$idfactura."' LIMIT 1"));

$ResFFacturas=mysql_fetch_array(mysql_query("SELECT * FROM ffacturas WHERE FolioI<='".$ResFactura["NumFactura"]."' AND FolioF>='".$ResFactura["NumFactura"]."' AND Empresa='".$ResFactura["Empresa"]."' AND Sucursal='".$ResFactura["Sucursal"]."' AND Serie='".$ResFactura["Serie"]."' ORDER BY Id DESC LIMIT 1"));

$ResPartidas=mysql_query("SELECT * FROM detfacturas WHERE IdFactura='".$idfactura."' ORDER BY Id ASC");

$paginas=ceil(mysql_num_rows($ResPartidas)/20); $cuentapaginas=1;

$xml=xml2array($ResFactura["XMLTimbrado"]); //lee el xml y lo convierte en array



//Datos del Emisor y del Receptor

$ResEmisor=mysql_fetch_array(mysql_query("SELECT * FROM sucursales WHERE Id='".$ResFactura["Sucursal"]."' AND Empresa='".$ResFactura["Empresa"]."' LIMIT 1"));

$ResCliente=mysql_fetch_array(mysql_query("SELECT * FROM clientes WHERE Id='".$ResFactura["Cliente"]."' LIMIT 1"));



//genera codigo QR

$filename = $PNG_TEMP_DIR.$ResFactura["Serie"].'_'.$ResFactura["NumFactura"].'.png';

QRcode::png('?re='.$xml["cfdi:Comprobante"]["cfdi:Emisor_attr"]["Rfc"].'&rr='.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["Rfc"].'&tt='.$ResFactura["Total"].'0000&id='.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"], $filename, 'H', '4', 2);

//crear el nuevo archivo pdf

$pdf=new FPDF();



//desabilitar el corte automatico de pagina

$pdf->SetAutoPageBreak(false);



//Agregamos la primer pagina

$pdf->AddPage();



//posicion inicial y por pagina

$y_axis_initial = 25;



//Imprimir Datos de la Empresa

$ResEmpresa=mysql_query("SELECT * FROM empresas WHERE ID='".$ResFactura["Empresa"]."' LIMIT 1");

$RResEmpresa=mysql_fetch_array($ResEmpresa);

//logo empresda

if($RResEmpresa["Logo"]!='')

{

$pdf->Image('../images/'.$RResEmpresa["Logo"],8,10,40);

}

//nombre de la empresa

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(4);

$pdf->SetX(55);

$pdf->Cell(120,4,utf8_decode(strtoupper($xml["cfdi:Comprobante"]["cfdi:Emisor_attr"]["Nombre"])),0,0,'L',1);

//RFC del emisor

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(8);

$pdf->SetX(55);

$pdf->Cell(120,4,'RFC.: '.$xml["cfdi:Comprobante"]["cfdi:Emisor_attr"]["Rfc"],0,0,'L',1);

//Domicilio del Emisor

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(12);

$pdf->SetX(55);

$dome=$ResEmisor["Calle"].' No. '.$ResEmisor["NoExterior"];if($ResEmisor["NoInterior"]!=''){$dome.=' Interior '.$ResEmisor["NoInterior"];}

//$dome=$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:DomicilioFiscal_attr"]["calle"].' No. '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:DomicilioFiscal_attr"]["noExterior"];if($xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:DomicilioFiscal_attr"]["noInterior"]){$dome.=' '.$xml["cfdi:Comprobante"]["cfdi:Emisor"]["cfdi:DomicilioFiscal_attr"]["noInterior"];}

$pdf->Cell(120,4,$dome,0,0,'L',1);

//Colonia del Emisor

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(16);

$pdf->SetX(55);

$pdf->Cell(120,4,'COL. '.utf8_decode($ResEmisor["Colonia"]),0,0,'L',1);

//Localidad del emisor

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(20);

$pdf->SetX(55);

$pdf->Cell(120,4,utf8_decode($ResEmisor["Municipio"]),0,0,'L',1);

$pdf->SetY(24);

$pdf->SetX(55);

$pdf->Cell(120,4,utf8_decode($ResEmisor["Estado"]),0,0,'L',1);

//codigo postal y pais del emisor

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(28);

$pdf->SetX(55);

$pdf->Cell(120,4,'C. P.: '.$ResEmisor["CodPostal"].' '.utf8_decode($ResEmisor["Pais"]),0,0,'L',1);

//Telefonos

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',9);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(32);

$pdf->SetX(55);

$telefonos=$ResEmisor["Telefono1"];if($ResEmisor["Telefono2"]!=''){$telefonos.=', '.$ResEmisor["Telefono2"];}

$pdf->Cell(120,4,'TELEFONO: '.$telefonos,0,0,'L',1);

//Correo electronico

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(36);

$pdf->SetX(55);

$pdf->Cell(120,4,'Correo Electronico: '.$ResEmisor["CorreoE"],0,0,'L',1);

//DATOS DE LA FACTURA

//folio

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(6);

$pdf->SetX(140);

$pdf->Cell(60,4,'Tipo de Comprobante: I Ingreso',1,0,'C',1);

//serie y numero

if($ResFactura["Serie"])

{

	$pdf->SetFillColor(255,255,255);

	$pdf->SetFont('Arial','',8);

	$pdf->SetTextColor(000,000,000);

	$pdf->SetY(10);

	$pdf->SetX(140);

	$pdf->Cell(60,4,'Serie: '.$ResFactura["Serie"].' No. '.$ResFactura["NumFactura"],1,0,'C',1);

}

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(14);

$pdf->SetX(140);

$pdf->Cell(60,4,'Folio Fiscal',1,0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(18);

$pdf->SetX(140);

$pdf->Cell(60,4,strtoupper($xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"]),1,0,'C',1);

//certificado 

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(22);

$pdf->SetX(140);

$pdf->Cell(60,4,'Certificado del Emisor',1,0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(26);

$pdf->SetX(140);

$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["NoCertificado"],1,0,'C',1);

//certificado SAT

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(30);

$pdf->SetX(140);

$pdf->Cell(60,4,'Certificado del SAT',1,0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(34);

$pdf->SetX(140);

$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["NoCertificadoSAT"],1,0,'C',1);

//Fecha y Hora de Certificación

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(38);

$pdf->SetX(140);

$pdf->Cell(60,4,utf8_decode('Fecha y Hora de Certificación'),1,0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(42);

$pdf->SetX(140);

$pdf->Cell(60,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"],1,0,'C',1);

//Lugar de Elaboración

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(46);

$pdf->SetX(140);

$pdf->Cell(60,4,utf8_decode('Lugar de Expedición'),1,0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(50);

$pdf->SetX(140);

$ResLugar=mysql_fetch_array(mysql_query("SELECT * FROM c_codigopostal WHERE c_CodigoPostal='".$xml["cfdi:Comprobante_attr"]["LugarExpedicion"]."' LIMIT 1"));

$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["LugarExpedicion"].' '.$ResLugar["c_Estado"],'LTR',0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(54);

$pdf->SetX(140);

$pdf->Cell(60,4,$xml["cfdi:Comprobante_attr"]["Fecha"][0].$xml["cfdi:Comprobante_attr"]["Fecha"][1].$xml["cfdi:Comprobante_attr"]["Fecha"][2].$xml["cfdi:Comprobante_attr"]["Fecha"][3].$xml["cfdi:Comprobante_attr"]["Fecha"][4].$xml["cfdi:Comprobante_attr"]["Fecha"][5].$xml["cfdi:Comprobante_attr"]["Fecha"][6].$xml["cfdi:Comprobante_attr"]["Fecha"][7].$xml["cfdi:Comprobante_attr"]["Fecha"][8].$xml["cfdi:Comprobante_attr"]["Fecha"][9].'T'.$xml["cfdi:Comprobante_attr"]["Fecha"][11].$xml["cfdi:Comprobante_attr"]["Fecha"][12].$xml["cfdi:Comprobante_attr"]["Fecha"][13].$xml["cfdi:Comprobante_attr"]["Fecha"][14].$xml["cfdi:Comprobante_attr"]["Fecha"][15].$xml["cfdi:Comprobante_attr"]["Fecha"][16].$xml["cfdi:Comprobante_attr"]["Fecha"][17].$xml["cfdi:Comprobante_attr"]["Fecha"][18],'LRB',0,'C',1);

//Regimen Fiscal

$pdf->SetFillColor(204,204,204);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(58);

$pdf->SetX(140);

$pdf->Cell(60,4,utf8_decode('Régimen Fiscal'),1,0,'C',1);

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(62);

$pdf->SetX(140);

$Regimen=mysql_fetch_array(mysql_query("SELECT Descripcion FROM c_regimenfiscal WHERE c_RegimenFiscal='".$xml["cfdi:Comprobante"]["cfdi:Emisor_attr"]["RegimenFiscal"]."' LIMIT 1"));

$pdf->MultiCell(60,4,$xml["cfdi:Comprobante"]["cfdi:Emisor_attr"]["RegimenFiscal"].' '.utf8_decode($Regimen["Descripcion"]),1,'C',1);

//separador

$pdf->Line(8, 42, 200, 42);

//DATOS DEL RECEPTOR

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(40);

$pdf->SetX(8);

$pdf->Cell(16,4,'Cliente: ',0,0,'L',1);

//RFC

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(44);

$pdf->SetX(8);

$pdf->Cell(8,4,'RFC.: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["Rfc"].' Domicilio Fiscal: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["DomicilioFiscalReceptor"],0,0,'L',1);

//Nombre

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(48);

$pdf->SetX(8);

$pdf->Cell(8,4,$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["Nombre"],0,0,'L',1);

//Uso CFDI

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(52);

$pdf->SetX(8);

$uso=mysql_fetch_array(mysql_query("SELECT Descripcion FROM c_usocfdi WHERE UsoCFDI='".$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["UsoCFDI"]."' LIMIT 1"));

$pdf->Cell(8,4,'Uso CFDI: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["UsoCFDI"].' '.$uso["Descripcion"],0,0,'L',1);

//regimen fiscal

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY(56);

$pdf->SetX(8);

$regimen=mysql_fetch_array(mysql_query("SELECT Descripcion FROM c_regimenfiscal WHERE c_RegimenFiscal='".$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["RegimenFiscalReceptor"]."' LIMIT 1"));

$pdf->Cell(8,4,'Regimen Fiscal: '.$xml["cfdi:Comprobante"]["cfdi:Receptor_attr"]["RegimenFiscalReceptor"].' '.$regimen["Descripcion"],0,0,'L',1);

//separador

$pdf->Line(8, 70, 200, 70);

//posicion inicial y por pagina

$y_axis_initial = 72; $y_axis=76;

//titulos de las columnas

$pdf->SetFillColor(000,000,000);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(255,255,255);

$pdf->SetY($y_axis_initial);

$pdf->SetX(5);

$pdf->Cell(25,4,'CPS',1,0,'C',1);

$pdf->Cell(25,4,utf8_decode('No Identificación'),1,0,'C',1);

$pdf->Cell(20,4,'Cantidad',1,0,'C',1);

$pdf->Cell(20,4,'Clave Unidad',1,0,'C',1);

$pdf->Cell(70,4,'Descripcion',1,0,'C',1);

$pdf->Cell(20,4,'Valor Unitario',1,0,'C',1);

$pdf->Cell(20,4,'Importe',1,0,'C',1);





$partidas=1;

$pdf->SetY($y_axis);

while($RResPartidas=mysql_fetch_array($ResPartidas))

{

	$pdf->SetFillColor(255,255,255);

	$pdf->SetFont('Arial','',7);

	$pdf->SetTextColor(000,000,000);

	

	$pdf->SetX(5);

	$pdf->Cell(25,4,$RResPartidas["ClaveProdServ"],0,0,'C',1);

	$pdf->Cell(25,4,$RResPartidas["Clave"],0,0,'C',1);

	$pdf->Cell(20,4,$RResPartidas["Cantidad"],0,0,'C',1);

	$pdf->SetX(165);

	$pdf->Cell(20,4,'$ '.number_format($RResPartidas["PrecioUnitario"],2,'.',','),0,0,'R',1);

	$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Subtotal"],2,'.',','),0,0,'R',1);

	

	// $pdf->SetX(75);

	//retencion IVA partida

	// if($RResPartidas["Riva"]>0)

	// {

		// $pdf->SetY($y_axis+20);

		// $pdf->SetX(165);

		// $pdf->SetFont('Arial','B',7);

		// $pdf->Cell(20,4,'Retención',0,0,'L',1);

		// $pdf->SetFont('Arial','',7);

		// $pdf->Cell(20,4,'002 IVA',0,0,'R',1);

		// $pdf->SetY($y_axis+24);

		// $pdf->SetX(165);

		// $pdf->SetFont('Arial','B',7);

		// $pdf->Cell(20,4,'TipoFactor',0,0,'L',1);

		// $pdf->SetFont('Arial','',7);

		// $pdf->Cell(20,4,'Tasa',0,0,'R',1);

		// $pdf->SetY($y_axis+28);

		// $pdf->SetX(165);

		// $pdf->SetFont('Arial','B',7);

		// $pdf->Cell(20,4,'TasaOCuota',0,0,'L',1);

		// $pdf->SetFont('Arial','',7);

		// $pdf->Cell(20,4,$xml["cfdi:Comprobante"]["cfdi:Conceptos"]["cfdi:Concepto"]["cfdi:Impuestos"]["cfdi:Retenciones"]["cfdi:Retencion_attr"]["TasaOCuota"],0,0,'R',1);

		// $pdf->SetY($y_axis+32); $y_axis_2=$y_axis+20;

		// $pdf->SetX(165);

		// $pdf->SetFont('Arial','B',7);

		// $pdf->Cell(20,4,'Importe',0,0,'L',1);

		// $pdf->SetFont('Arial','',7);

		// $pdf->Cell(20,4,'$ '.$RResPartidas["Iva"],0,0,'R',1);

		// $pdf->SetY($y_axis);

		// $pdf->SetX(75);

	// }

	$pdf->SetX(75);

	$ResClaveUnidad=mysql_fetch_array(mysql_query("SELECT Descripcion FROM c_claveunidad WHERE ClaveUnidad='".$RResPartidas["ClaveUnidad"]."' LIMIT 1"));

	$pdf->MultiCell(20,4,$RResPartidas["ClaveUnidad"].' '.$ResClaveUnidad["Descripcion"],0,'C',1);

	$pdf->SetY($y_axis);

	$pdf->SetX(95);

	$pdf->MultiCell(70,4,utf8_decode($RResPartidas["Descripcion"]),0,'C',1);

	

	$y_axis=$pdf->GetY()+2;

	

	//impuesto partida

	$pdf->SetY($y_axis+4);

	$pdf->SetX(71);

	$pdf->SetFont('Arial','B',7);

	$pdf->Cell(14,4,'Impuesto: ',0,0,'L',1);

	$pdf->SetFont('Arial','',7);

	$pdf->Cell(14,4,'002 IVA',0,0,'R',1);

	$pdf->SetFont('Arial','B',7);

	$pdf->Cell(16,4,'TipoFactor: ',0,0,'L',1);

	$pdf->SetFont('Arial','',7);

	$pdf->Cell(14,4,'Tasa',0,0,'R',1);

	$pdf->SetFont('Arial','B',7);

	$pdf->Cell(18,4,'TasaOCuota',0,0,'L',1);

	$pdf->SetFont('Arial','',7);

	$pdf->Cell(20,4,'0.160000',0,0,'R',1);

	$pdf->SetFont('Arial','B',7);

	$pdf->Cell(18,4,'Importe',0,0,'L',1);

	$pdf->SetFont('Arial','',7);

	$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Iva"],2,'.',','),0,0,'R',1);

	$y_axis=$y_axis+4;

	

	//retención Iva

	 if($RResPartidas["Riva"]>0)

	 {

		$pdf->SetY($y_axis+4);

		$pdf->SetX(71);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(14,4,utf8_decode('Retención: '),0,0,'L',1); 

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(14,4,'002 IVA',0,0,'R',1);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(16,4,'TipoFactor: ',0,0,'L',1);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(14,4,'Tasa',0,0,'R',1);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(18,4,'TasaOCuota',0,0,'L',1);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(20,4,number_format(($RResPartidas["Riva"]/$RResPartidas["Subtotal"]),6,'.',''),0,0,'R',1);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(18,4,'Importe',0,0,'L',1);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Riva"],2,'.',','),0,0,'R',1);

		$y_axis=$y_axis+4;

	 }

	 

	 //retencion isr

	 if($RResPartidas["Risr"]>0)

	 {

		$pdf->SetY($y_axis+4);

		$pdf->SetX(71);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(14,4,utf8_decode('Retención: '),0,0,'L',1); 

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(14,4,'001 ISR',0,0,'R',1);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(16,4,'TipoFactor: ',0,0,'L',1);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(14,4,'Tasa',0,0,'R',1);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(18,4,'TasaOCuota',0,0,'L',1);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(20,4,number_format(($RResPartidas["Risr"]/$RResPartidas["Subtotal"]),6,'.',''),0,0,'R',1);

		$pdf->SetFont('Arial','B',7);

		$pdf->Cell(18,4,'Importe',0,0,'L',1);

		$pdf->SetFont('Arial','',7);

		$pdf->Cell(20,4,'$ '.number_format($RResPartidas["Risr"],2,'.',','),0,0,'R',1);

		$y_axis=$y_axis+4;

	 }

	

	$y_axis_2=$y_axis+5;

	

	if($y_axis < $y_axis_2){$y_axis=$y_axis_2+4;}

	

	//crea otra pagina

    if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

	

	$pdf->SetY($y_axis);

}



//separador

$pdf->Line(8, $y_axis, 200, $y_axis);



$y_axis++;





if($y_axis>=230)

{

	$pdf->AddPage();

	$y_axis=10;

}



//desplegar subtotal, descuento, Iva y total

//desplegar subtotal

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetY($y_axis);

$pdf->SetX(165);

$pdf->Cell(20,4,'Subtotal: ',0,0,'R',1);

$pdf->SetFont('Arial','',7);

if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Subtotal"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Subtotal"], 2),0,0,'R',1);}

$y_axis=$y_axis+4;

if($ResFactura["Descuento"]!=0)

{

//desplegar descuento

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(163);

$pdf->Cell(20,4,'Desc. '.$ResFactura["Descuento"].'%: ',0,0,'R',1);

$pdf->SetFont('Arial','',7);

$pdf->Cell(20,4,'$ '.number_format($sdescuento, 2),0,0,'R',1);

$y_axis=$y_axis+4;

//desplegar subtotal condescuento

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(163);

$pdf->Cell(20,4,'Subtotal: ',0,0,'R',1);

$pdf->SetFont('Arial','',7);

$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Subtotal"]-$sdescuento), 2),0,0,'R',1);

$y_axis=$y_axis+4;

}

//desplegar numero en letra

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(8);

if($ResFactura["Moneda"]=='USD'){$numero=explode('.', ($ResFactura["Total"]/$ResFactura["TipoCambio"]));}else{$numero=explode('.', $ResFactura["Total"]);}

if($ResFactura["Moneda"]=='USD'){$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' dolares '.$numero[1][0].$numero[1][1].'/100 USD'),0,0,'L',1);}else{$pdf->Cell(100,4,strtoupper(num2letras($numero[0]).' pesos '.$numero[1].'/100 M. N.'),0,0,'L',1);}

//despliega Iva

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetX(125);

$pdf->Cell(60,4,'Tasa Iva Traslado 16%: ',0,0,'R',1);

$pdf->SetFont('Arial','',7);

if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Iva"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Iva"], 2),0,0,'R',1);}

$y_axis=$y_axis+4;



//despliega retención Iva

if($ResFactura["RetIVA"]>0)

{

	if($y_axis>=240)

		{

			$pdf->AddPage();

			$y_axis=10;

		}

	$pdf->SetFillColor(255,255,255);

	$pdf->SetFont('Arial','B',8);

	$pdf->SetTextColor(000,000,000);

	$pdf->Ln();

	$pdf->SetX(125);

	$pdf->Cell(60,4,utf8_decode('Retención Iva: '),0,0,'R',1);

	$pdf->SetFont('Arial','',7);

	if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["RetIVA"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["RetIVA"], 2),0,0,'R',1);}

	$y_axis=$y_axis+4;	

}



//despliega retención isr

if($ResFactura["RetISR"]>0)

{

	if($y_axis>=240)

		{

			$pdf->AddPage();

			$y_axis=10;

		}

	$pdf->SetFillColor(255,255,255);

	$pdf->SetFont('Arial','B',8);

	$pdf->SetTextColor(000,000,000);

	$pdf->Ln();

	$pdf->SetX(125);

	$pdf->Cell(60,4,utf8_decode('Retención ISR: '),0,0,'R',1);

	$pdf->SetFont('Arial','',7);

	if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["RetISR"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["RetISR"], 2),0,0,'R',1);}

	$y_axis=$y_axis+4;	

}



//despliega total

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(165);

$pdf->Cell(20,4,'Total: ',0,0,'R',0);

$pdf->SetFont('Arial','',7);

if($ResFactura["Moneda"]=='USD'){$pdf->Cell(20,4,'$ '.number_format(($ResFactura["Total"]/$ResFactura["TipoCambio"]), 2),0,0,'R',1);}else{$pdf->Cell(20,4,'$ '.number_format($ResFactura["Total"], 2),0,0,'R',1);}

$y_axis=$y_axis+8;

//forma de pago

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

	//separador

$pdf->Line(5, $y_axis, 205, $y_axis);

$y_axis=$y_axis+4;

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',7);

$pdf->SetTextColor(000,000,000);

$pdf->SetY($y_axis);

$pdf->SetX(5);

if(isset($xml["cfdi:Comprobante_attr"]["NumCtaPago"])){$cta='Num. Cuenta: '.$xml["cfdi:Comprobante_attr"]["NumCtaPago"].' ';}else{$cta='';}

if($xml["cfdi:Comprobante_attr"]["MetodoPago"]=='PUE'){$mpago='Pago en una sola exhibición';}

if($xml["cfdi:Comprobante_attr"]["MetodoPago"]=='PPD'){$mpago='Pago en parcialidades o diferido';}

$ResFP=mysql_fetch_array(mysql_query("SELECT Descripcion FROM c_formadepago WHERE c_FormaPago='".$xml["cfdi:Comprobante_attr"]["FormaPago"]."' LIMIT 1"));

$pdf->Cell(205,4,'Metodo de Pago: '.$xml["cfdi:Comprobante_attr"]["MetodoPago"].' '.utf8_decode($mpago).' | Forma de Pago: '.$xml["cfdi:Comprobante_attr"]["FormaPago"].' '.utf8_decode($ResFP["Descripcion"]).' '.$cta.'| Moneda: '.$xml["cfdi:Comprobante_attr"]["Moneda"].' | Tipo de Cambio: '.$xml["cfdi:Comprobante_attr"]["TipoCambio"],0,0,'L',1);



if($ResFactura["SustituyeFactura"]!=0)

{

	$ResXMLSus=mysql_fetch_array(mysql_query("SELECT XMLTimbrado FROM facturas WHERE Id='".$ResFactura["SustituyeFactura"]."' LIMIT 1"));

	$uuid_rel=xml2array($ResXMLSus["XMLTimbrado"]);

			

	$y_axis=$y_axis+4;

	$pdf->SetFillColor(255,255,255);

	$pdf->SetFont('Arial','',7);

	$pdf->SetTextColor(000,000,000);

	$pdf->SetY($y_axis);

	$pdf->SetX(5);

	$pdf->Cell(205,4,'CFDI Relacionado: '.$uuid_rel["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"],0,0,'L',1);

	

}

$y_axis=$y_axis+8;

//observaciones

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

//separador

$pdf->Line(5, $y_axis, 205, $y_axis);

$y_axis=$y_axis+4;

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',10);

$pdf->SetTextColor(000,000,000);

$pdf->SetY($y_axis);

$pdf->SetX(5);

$pdf->MultiCell(205,4,'Observaciones: ',0,'L',1);

$y_axis=$y_axis+4;

//

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',7);

$pdf->SetTextColor(000,000,000);

$pdf->SetY($y_axis+4);

$pdf->SetX(5);

$pdf->MultiCell(205,4,utf8_decode($ResFactura["Observaciones"]),0,'L',1);

//Codigo QR

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }



//titulos de la columna

if($y_axis>=230)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(000,000,000);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(255,255,255);

$pdf->Ln();

$pdf->SetX(5);

$pdf->Cell(150,4,'Cadena Original del Complemento',1,0,'C',1);

$y_axis=$y_axis+8;

//Codigo QR

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(000,000,000);

$pdf->SetX(160);

$pdf->Cell(40,4,'Codigo QR',1,0,'C',1);

$y=$pdf->GetY();

$pdf->Image($PNG_WEB_DIR.basename($filename),160,($y+6),40);

$y_axis=$y_axis+5;

//muestra cadena original

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$cadenao='||1.0|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["UUID"].'|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["FechaTimbrado"].'|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["RfcProvCertif"].'|'.$ResFactura["SelloEmisor"].'|'.$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["NoCertificadoSAT"].'||';

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',5);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(5);

$pdf->MultiCell(150,2,$cadenao,0,'L');

$y_axis=$y_axis+4;

//sello digital

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(000,000,000);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(255,255,255);

$pdf->Ln();

$pdf->SetX(5);

$pdf->Cell(150,4,'Sello Digital',1,0,'C',1);

$y_axis=$y_axis+4;

//despliega el sello emisor

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',7);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(5);

$pdf->MultiCell(150,4,$ResFactura["SelloEmisor"],0,'J');

//sello sat

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(000,000,000);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(255,255,255);

$pdf->Ln();

$pdf->SetX(5);

$pdf->Cell(150,4,'Sello Digital SAT',1,0,'C',1);

$y_axis=$y_axis+4;

//despliega el sello sat

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',7);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(5);

$pdf->MultiCell(150,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["SelloSAT"],0,'J');

$y_axis=$y_axis+4;

//provedor certificado

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(000,000,000);

$pdf->SetFont('Arial','B',8);

$pdf->SetTextColor(255,255,255);

$pdf->Ln();

$pdf->SetX(5);

$pdf->Cell(150,4,'RFC Provedor Certificado',1,0,'C',1);

$y_axis=$y_axis+4;

//despliega el sello sat

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',7);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(5);

$pdf->MultiCell(150,4,$xml["cfdi:Comprobante"]["cfdi:Complemento"]["tfd:TimbreFiscalDigital_attr"]["RfcProvCertif"],0,'J');

$y_axis=$y_axis+4;

//representacion impresa

if($y_axis>=240)

    {

    	$pdf->AddPage();

    	$y_axis=10;

    }

$pdf->SetFillColor(255,255,255);

$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(000,000,000);

$pdf->Ln();

$pdf->SetX(5);

$pagare=utf8_decode('Este documento es una representación impresa de un CFDI.');

$pdf->MultiCell(205,4,$pagare,0,'C');

$y_axis=$y_axis+4;





//Envio Archivo

$pdf->Output();



// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.



function num2letras($num, $fem = true, $dec = true) { 

//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 

   $matuni[2]  = "dos"; 

   $matuni[3]  = "tres"; 

   $matuni[4]  = "cuatro"; 

   $matuni[5]  = "cinco"; 

   $matuni[6]  = "seis"; 

   $matuni[7]  = "siete"; 

   $matuni[8]  = "ocho"; 

   $matuni[9]  = "nueve"; 

   $matuni[10] = "diez"; 

   $matuni[11] = "once"; 

   $matuni[12] = "doce"; 

   $matuni[13] = "trece"; 

   $matuni[14] = "catorce"; 

   $matuni[15] = "quince"; 

   $matuni[16] = "dieciseis"; 

   $matuni[17] = "diecisiete"; 

   $matuni[18] = "dieciocho"; 

   $matuni[19] = "diecinueve"; 

   $matuni[20] = "veinte"; 

   $matunisub[2] = "dos"; 

   $matunisub[3] = "tres"; 

   $matunisub[4] = "cuatro"; 

   $matunisub[5] = "quin"; 

   $matunisub[6] = "seis"; 

   $matunisub[7] = "sete"; 

   $matunisub[8] = "ocho"; 

   $matunisub[9] = "nove"; 



   $matdec[2] = "veint"; 

   $matdec[3] = "treinta"; 

   $matdec[4] = "cuarenta"; 

   $matdec[5] = "cincuenta"; 

   $matdec[6] = "sesenta"; 

   $matdec[7] = "setenta"; 

   $matdec[8] = "ochenta"; 

   $matdec[9] = "noventa"; 

   $matsub[3]  = 'mill'; 

   $matsub[5]  = 'bill'; 

   $matsub[7]  = 'mill'; 

   $matsub[9]  = 'trill'; 

   $matsub[11] = 'mill'; 

   $matsub[13] = 'bill'; 

   $matsub[15] = 'mill'; 

   $matmil[4]  = 'millones'; 

   $matmil[6]  = 'billones'; 

   $matmil[7]  = 'de billones'; 

   $matmil[8]  = 'millones de billones'; 

   $matmil[10] = 'trillones'; 

   $matmil[11] = 'de trillones'; 

   $matmil[12] = 'millones de trillones'; 

   $matmil[13] = 'de trillones'; 

   $matmil[14] = 'billones de trillones'; 

   $matmil[15] = 'de billones de trillones'; 

   $matmil[16] = 'millones de billones de trillones'; 



   $num = trim((string)@$num); 

   if ($num[0] == '-') { 

      $neg = 'menos '; 

      $num = substr($num, 1); 

   }else 

      $neg = ''; 

   while ($num[0] == '0') $num = substr($num, 1); 

   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 

   $zeros = true; 

   $punt = false; 

   $ent = ''; 

   $fra = ''; 

   for ($c = 0; $c < strlen($num); $c++) { 

      $n = $num[$c]; 

      if (! (strpos(".,'''", $n) === false)) { 

         if ($punt) break; 

         else{ 

            $punt = true; 

            continue; 

         } 



      }elseif (! (strpos('0123456789', $n) === false)) { 

         if ($punt) { 

            if ($n != '0') $zeros = false; 

            $fra .= $n; 

         }else 



            $ent .= $n; 

      }else 



         break; 



   } 

   $ent = '     ' . $ent; 

   if ($dec and $fra and ! $zeros) { 

      $fin = ' coma'; 

      for ($n = 0; $n < strlen($fra); $n++) { 

         if (($s = $fra[$n]) == '0') 

            $fin .= ' cero'; 

         elseif ($s == '1') 

            $fin .= $fem ? ' uno' : ' un'; 

         else 

            $fin .= ' ' . $matuni[$s]; 

      } 

   }else 

      $fin = ''; 

   if ((int)$ent === 0) return 'Cero ' . $fin; 

   $tex = ''; 

   $sub = 0; 

   $mils = 0; 

   $neutro = false; 

   while ( ($num = substr($ent, -3)) != '   ') { 

      $ent = substr($ent, 0, -3); 

      if (++$sub < 3 and $fem) { 

         $matuni[1] = 'un'; 

         $subcent = 'os'; 

      }else{ 

         $matuni[1] = $neutro ? 'un' : 'un'; 

         $subcent = 'os'; 

      } 

      $t = ''; 

      $n2 = substr($num, 1); 

      if ($n2 == '00') { 

      }elseif ($n2 < 21) 

         $t = ' ' . $matuni[(int)$n2]; 

      elseif ($n2 < 30) { 

         $n3 = $num[2]; 

         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 

         $n2 = $num[1]; 

         $t = ' ' . $matdec[$n2] . $t; 

      }else{ 

         $n3 = $num[2]; 

         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 

         $n2 = $num[1]; 

         $t = ' ' . $matdec[$n2] . $t; 

      } 

      $n = $num[0]; 

      if ($n == 1) { 

         $t = ' ciento' . $t; 

      }elseif ($n == 5){ 

         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 

      }elseif ($n != 0){ 

         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 

      } 

      if ($sub == 1) { 

      }elseif (! isset($matsub[$sub])) { 

         if ($num == 1) { 

            $t = ' mil'; 

         }elseif ($num > 1){ 

            $t .= ' mil'; 

         } 

      }elseif ($num == 1) { 

         $t .= ' ' . $matsub[$sub] . 'on'; 

      }elseif ($num > 1){ 

         $t .= ' ' . $matsub[$sub] . 'ones'; 

      }   

      if ($num == '000') $mils ++; 

      elseif ($mils != 0) { 

         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 

         $mils = 0; 

      } 

      $neutro = true; 

      $tex = $t . $tex; 

   } 

   $tex = $neg . substr($tex, 1) . $fin; 

   return ucfirst($tex); 

} 

?>