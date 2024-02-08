<?php 
include ('../../db/conexion.php');

if(($_POST["clave"] == 'null' AND $_POST["descripcion"] == 'null' AND $_POST["estatus"] =='null') OR ($_POST["clave"] == '' AND $_POST["descripcion"] == '' AND $_POST["estatus"] =='%'))
{
    $sql="SELECT * FROM c_claveprodserv AS c 
            INNER JOIN c_claveprodserv_emp AS ce ON c.id = ce.IdClaveProdServ
            WHERE ce.Empresa='".$_POST["empresa"]."' ORDER BY c.ClaveProdServ ASC;";

    $checked = 1; 
}
else
{
    $sql="SELECT * FROM c_claveprodserv WHERE";
    
    if($_POST["clave"]!=''){$sql.=" ClaveProdServ LIKE '%".$_POST["clave"]."%'";}
    if($_POST["clave"]!='' AND $_POST["descripcion"]!=''){$sql.=' OR';}
    if($_POST["descripcion"]!=''){$sql.=" Descripcion LIKE '%".$_POST["descripcion"]."%'";}

    $sql.=" ORDER BY ClaveProdServ ASC";
}

$cadena='<div class="p-5" id="app">
            <div class="row">
                <div class="card-content">
                    <form name="fbusprodserv" id="fbusprodserv">
                        <div class="row">
                            <div class="col s3 input-field">
                                <input type="text" name="prodserv" id="prodserv" placeholder="Clave Producto/servicio" value="';if($_POST["clave"]!='null'){$cadena.=$_POST["clave"];}$cadena.='">
                            </div>
                            <div class="col s3 input-field">
                                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción" value="';if($_POST["descripcion"]!='null'){$cadena.=$_POST["descripcion"];}$cadena.='">
                            </div>
                            <div class="col s3 input-field">
                                <select name="estatus" id="estatus">
                                    <option value="%"';if($_POST["estatus"]=='%'){$cadena.=' selected';}$cadena.='>Todos</option>
                                    <option value="1"';if($_POST["estatus"]=='1'){$cadena.=' selected';}$cadena.='>Activos</option>
                                    <option value="0"';if($_POST["estatus"]=='0'){$cadena.=' selected';}$cadena.='>Inactivos</option>
                                </select>
                            </div>
                            <div class="col s3 input-field">
                                <a class="waves-effect waves-light button-gray" onclick="productosyservicios(document.getElementById(\'prodserv\').value, document.getElementById(\'descripcion\').value, document.getElementById(\'estatus\').value)">Buscar <i class="material-icons right">search</i></a>
                            </div>
                        </div>
                    </form>
                    <div style="overflow-x: auto;">
                        <table id="tabla_t_prodserv" class="stripe row-border order-column nowrap">
                            <thead>
                                <tr>
                                    <th>Clave Producto/Servicio</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>';
$ResClaveProdServicios= mysqli_query($conn, $sql);
while($RResCPS=mysqli_fetch_array($ResClaveProdServicios))
{
    $act = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM c_claveprodserv_emp WHERE Empresa='".$_POST["empresa"]."' AND IdClaveProdServ='".$RResCPS["Id"]."'"));

    $checked = ($act>0) ? 1 : 0;

    if(($_POST["estatus"]=='%' OR $_POST["estatus"] =='null') OR ($_POST["estatus"] == 1 AND $checked == 1) OR ($_POST["estatus"] == 0 AND $checked == 0))
    {
        $cadena.='              <tr>
                                    <td>'.$RResCPS["ClaveProdServ"].'</td>
                                    <td>'.$RResCPS["Descripcion"].'</td>
                                    <td>
                                        <div class="switch" id="psact_'.$RResCPS["Id"].'">
                                            <label>
                                                <input type="checkbox" ';if($checked== 1){$cadena.=' checked';}$cadena.=' onchange="activarps(\''.$RResCPS["Id"].'\')">
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

var tabla_42 = $('#tabla_t_prodserv').DataTable({
			deferRender:    true,
			language: {
				decimal: '.',
				thousands: ',',
				url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
			},
			paging: false,
			info: false,
			searching: false,
			sort: true
		});
</script>