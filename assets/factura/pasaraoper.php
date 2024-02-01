<?php 
include ('../../db/conexion.php');

$ResInvoice=mysqli_fetch_array(mysqli_query($conn, "SELECT i.id, i.receiver_rfc, i.uuid, c.short_name, c.legal_name  
                                                    FROM invoices AS i
                                                    INNER JOIN companies AS c ON c.rfc = i.receiver_rfc
                                                    WHERE i.id='".$_POST["idinvoice"]."' LIMIT 1"));

$cadena='<p class="flow-text">Se enviara la factura <a href="'.$_POST["url"].'assets/factura/factura.php?idfactura='.$ResInvoice["id"].'" target="_blank">'.$ResInvoice["uuid"].'</a> de ';if($ResInvoice["short_name"]!=NULL){$cadena.=$ResInvoice["short_name"];}else{$cadena.=$ResInvoice["legal_name"];}$cadena.=' para poder ser utilizada en una conciliación</p>
        <div class="row">
            <div class="col s6">
            </div>
            <div class="col s3">
                <a class="modal-close button-gray">Cancelar</a>
            </div>
            <div class="col s3">
                <form method="POST" action="'.$_POST["url"].'Timbrado">
                    <input type="hidden" name="idipasaoper" id="idipasaoper" value="'.$ResInvoice["id"].'">
                    <input type="submit" name="botpasaoper" id="botpasaoper" value="Aceptar" class="btn waves-effect waves-light" onclick="">
                </form>
            </div>
        </div>';

echo $cadena;