<?php 
include ('../../db/conexion.php');

$ResU=mysqli_num_rows(mysqli_query($conn, "SELECT * FROM c_claveunidad_emp WHERE IdClaveUnidad='".$_POST["idunidad"]."' AND Empresa='".$_POST["empresa"]."' LIMIT 1"));

if($ResU==0)
{
    mysqli_query($conn, "INSERT INTO c_claveunidad_emp (Empresa, IdClaveUnidad) VALUES ('".$_POST["empresa"]."', '".$_POST["idunidad"]."')");

    $checked=1;
}
elseif($ResU>0)
{
    mysqli_query($conn, "DELETE FROM c_claveunidad_emp WHERE Empresa='".$_POST["empresa"]."' AND IdClaveUnidad='".$_POST["idunidad"]."'");

    $checked=0;
}

$cadena=' <label>
            <input type="checkbox" ';if($checked==1){$cadena.=' checked';}$cadena.=' onchange="activaru(\''.$_POST["idunidad"].'\')">
            <span class="lever"></span>
        </label>';

echo $cadena;