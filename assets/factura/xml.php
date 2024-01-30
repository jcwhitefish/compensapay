<?php 
include ('../../db/conexion.php');

if(isset($_POST["idfactura"])){$idfactura=$_POST["idfactura"];}
elseif(isset($_GET["idfactura"])){$idfactura=$_GET["idfactura"];}
//generales de la factura
$ResFactura=mysqli_fetch_array(mysqli_query($conn, "SELECT uuid, xml_document FROM invoices WHERE id='".$idfactura."' LIMIT 1"));
	
$xml=$ResFactura["xml_document"];

$cIniHexXML = hex2bin("efbbbf");
$NuevoXML = $cIniHexXML.$xml;

header( "Content-Type: application/octet-stream");
header( "Content-Disposition: attachment; filename=".$ResFactura["uuid"].".xml"); 
print($NuevoXML);