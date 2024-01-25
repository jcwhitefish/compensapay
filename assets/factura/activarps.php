<?php 
include ('../../db/conexion.php');

$ResPS=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM c_claveprodserv_emp WHERE Empresa='".$_POST["empresa"]."' AND IdClaveProdServ='".$_POST["idprodserv"]."' LIMIT 1"));

if($ResPS==0)
{
    mysqli_query($conn, "INSERT INTO c_claveprodserv_emp (Empresa, IdClaveProdServ) VALUES ('".$_POST["empresa"]."', '".$_POST["idprodserv"]."')") or die(mysqli_error($conn));

    $checked=1;
}
elseif($ResPS>0)
{
    mysqli_query($conn, "DELETE FROM c_claveprodserv_emp WHERE Empresa='".$_POST["empresa"]."' AND IdClaveProdServ='".$_POST["idprodserv"]."'");

    $checked=0;
}

$cadena=' <label>
            <input type="checkbox" ';if($checked==1){$cadena.=' checked';}$cadena.=' onchange="activarps(\''.$_POST["idprodserv"].'\')">
            <span class="lever"></span>
        </label>';

echo $cadena;