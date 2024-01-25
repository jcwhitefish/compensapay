<?php 
include ('../../db/conexion.php');

if(($_POST["clave"] == 'null' AND $_POST["descripcion"] == 'null' AND $_POST["estatus"] =='null') OR ($_POST["clave"] == '' AND $_POST["descripcion"] == '' AND $_POST["estatus"] =='%'))
{
    $sql="SELECT * FROM c_claveunidad AS c 
            INNER JOIN c_claveunidad_emp AS ce ON c.id = ce.IdClaveUnidad
            WHERE ce.Empresa='".$_POST["empresa"]."' ORDER BY c.ClaveUnidad ASC;";

    $checked = 1; 
}
else
{
    $sql="SELECT * FROM c_claveunidad WHERE";
    
    if($_POST["clave"]!=''){$sql.=" ClaveUnidad LIKE '%".$_POST["clave"]."%'";}
    if($_POST["clave"]!='' AND $_POST["descripcion"]!=''){$sql.=' OR';}
    if($_POST["descripcion"]!=''){$sql.=" Descripcion LIKE '%".$_POST["descripcion"]."%'";}

    $sql.=" ORDER BY ClaveUnidad ASC";
}

$cadena='<div class="p-5" id="app">
            <div class="row">
                <div class="card-content">
                    <form name="fbusunidad" id="fbusunidad">
                        <div class="row">
                            <div class="col s3 input-field">
                                <input type="text" name="unidad" id="unidad" placeholder="Clave Producto/servicio" value="';if($_POST["clave"]!='null'){$cadena.=$_POST["clave"];}$cadena.='">
                            </div>
                            <div class="col s3 input-field">
                                <input type="text" name="descripcionu" id="descripcionu" placeholder="Descripción" value="';if($_POST["descripcion"]!='null'){$cadena.=$_POST["descripcion"];}$cadena.='">
                            </div>
                            <div class="col s3 input-field">
                                <select name="estatusu" id="estatusu">
                                    <option value="%"';if($_POST["estatus"]=='%'){$cadena.=' selected';}$cadena.='>Todos</option>
                                    <option value="1"';if($_POST["estatus"]=='1'){$cadena.=' selected';}$cadena.='>Activos</option>
                                    <option value="0"';if($_POST["estatus"]=='0'){$cadena.=' selected';}$cadena.='>Inactivos</option>
                                </select>
                            </div>
                            <div class="col s3 input-field">
                                <a class="waves-effect waves-light btn" onclick="unidades(document.getElementById(\'unidad\').value, document.getElementById(\'descripcionu\').value, document.getElementById(\'estatusu\').value)">Buscar <i class="material-icons right">search</i></a>
                            </div>
                        </div>
                    </form>
                    <div style="overflow-x: auto;">
                        <table class="visible-table striped">
                            <thead>
                                <tr>
                                    <th>Clave Unidad</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>';
$ResClaveUnidad= mysqli_query($conn, $sql);
while($RResCU=mysqli_fetch_array($ResClaveUnidad))
{
    $act = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM c_claveunidad_emp WHERE Empresa='".$_POST["empresa"]."' AND IdClaveUnidad='".$RResCU["Id"]."'"));
    
    $checked = ($act>0) ? 1 : 0;
    
    if(($_POST["estatus"]=='%' OR $_POST["estatus"] =='null') OR ($_POST["estatus"] == 1 AND $checked == 1) OR ($_POST["estatus"] == 0 AND $checked == 0))
    {
        $cadena.='              <tr>
                                    <td>'.$RResCU["ClaveUnidad"].'</td>
                                    <td>'.$RResCU["Descripcion"].'</td>
                                    <td>
                                        <div class="switch" id="uact_'.$RResCU["Id"].'">
                                            <label>
                                                <input type="checkbox"';if($checked==1){$cadena.=' checked';}$cadena.=' onchange="activaru(\''.$RResCU["Id"].'\')">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>';
    }
}
$cadena.='                  </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';

echo $cadena;

?>
<script>
    $(document).ready(function(){
    $('select').formSelect();
});
</script>