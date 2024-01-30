<?php
defined('BASEPATH') or exit('No direct script access allowed');

?>

<div class="p-5" id="app">
    <div class="row">
        <form name="ffactura" id="ffactura" method="POST" action="<?php echo base_url('/timbrado/guardar_factura');?>">
            <p class="px-3">Nueva Factura</p>
            <div class="row">
                <div class="col s8">
                    <label for="cliente">Cliente:</label>
                    <select name="cliente" id="cliente" class="browser-default">
                        <option value="">Seleccione</option>
                        <?php
                            if(is_array($dfactura["clientes"]))
                            {
                                foreach($dfactura["clientes"] AS $value)
                                {
                                    echo '<option value="'.$value["id"].'"';if(isset($_POST["cliente"]) AND $_POST["cliente"]==$value["id"]){echo ' selected';}echo '>'.$value["legal_name"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <!--<div class="col s4">
                    <label for="sustituye">Sustituye CFDI:</label>
                    <select name="sustituye" id="sustituye" class="browser-default">
                        <option value="0">Seleccione</option>
                    </select>
                </div>-->
            </div>

            <div class="row">
                <div class="col s2">
                    <label for="descuento">Descuento (en %):</label>
                    <input type="text" name="descuento" id="descuento" size="5" value="<?php if(isset($_POST["descuento"])){echo $_POST["descuento"];}else{echo '0';}?>">
                </div>
                <div class="col s2">
                    <div class="switch">
                        <label>
                            <input id="apretiva" name="apretiva" type="checkbox" value="1" <?php if(isset($_POST["apretiva"]) AND $_POST["apretiva"]==1){echo ' checked';}?> onclick="document.ffactura.aplicariva.disabled=!document.ffactura.aplicariva.disabled; document.ffactura.aplicariva.checked=!document.ffactura.aplicariva.checked;">
                            <span class="lever"></span>
                                Aplica Retención Iva  
                        </label>
                    </div>
                    <input type="text" name="retiva" id="retiva" size="5"  value="<?php if(isset($_POST["retiva"])){echo $_POST["retiva"];}else{echo '10.6667';}?>">
                </div>
                <div class="col s2">
                    <div class="switch">
                        <label>
                            <input id="apretisr" name="apretisr" type="checkbox" value="1" <?php if(isset($_POST["apretisr"]) AND $_POST["apretisr"]==1){echo ' checked';}?> onclick="document.ffactura.aplicarisr.disabled=!document.ffactura.aplicarisr.disabled; document.ffactura.aplicarisr.checked=!document.ffactura.aplicarisr.checked;">
                            <span class="lever"></span>
                                Aplica Retención ISR  
                        </label>
                    </div>
                    <input type="text" name="retisr" id="retisr" size="5"  value="<?php if(isset($_POST["retisr"])){echo $_POST["retisr"];}?>">
                </div>
                <div class="col s6">
                    <label for="usocfdi">Uso de CFDI:</label>
                    <select name="usocfdi" id="usocfdi" class="browser-default">
                        <option value="0">Seleccione</option>
                        <?php 
                            if(is_array($dfactura["usocfdi"]))
                            {
                                foreach($dfactura["usocfdi"] AS $value)
                                {
                                    echo '<option value="'.$value["Id"].'"';if(isset($_POST["usocfdi"]) AND $_POST["usocfdi"]==$value["id"]){echo ' selected';}echo '>'.$value["UsoCFDI"].' - '.$value["Descripcion"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col s4">
                    <label for="formadepago">Forma de Pago:</label>
                    <select name="formadepago" id="formadepago" class="browser-default">
                        <option value="0">Seleccione</option>
                        <?php 
                            if(is_array($dfactura["formasdepago"]))
                            {
                                foreach($dfactura["formasdepago"] AS $value)
                                {
                                    echo '<option value="'.$value["c_FormaPago"].'"';if(isset($_POST["formadepago"]) AND $_POST["formadepago"]==$value["c_FormaPago"]){echo ' selected';}echo '>'.$value["c_FormaPago"].' - '.$value["Descripcion"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col s2">
                    <label for="nummetodopago">Cuenta:</label>
                    <input type="text" name="nummetodopago" id="nummetodopago" size="5" value="<?php if(isset($_POST["nummetodopago"])){echo $_POST["nummetodopago"];}?>">
                </div>
                <div class="col s2">
                    <label for="moneda">Moneda:</label>
                    <select name="moneda" id="moneda" class="browser-default">
						<option value="MXN" <?php if(isset($_POST["moneda"]) AND $_POST["moneda"]=='MXN'){echo 'selected';}?>>Peso Mexicano</option>
					</select>
                </div>
                <div class="col s2">
                    <label for="tipocambio">Tipo Cambio:</label>
                    <input type="number" name="tipocambio" id="tipocambio" value="<?php if(isset($_POST["tipocambio"])){echo $_POST["tipocambio"];}else{echo '1';}?>">
                </div>
                <div class="col s2">
                    <label for="metododepago">Metodo de Pago:</label>
                    <select name="metododepago" id="metododepago" class="browser-default">
                        <option value="PUE" <?php if(isset($_POST["metododepago"]) AND $_POST["metododepago"]=='PUE'){echo 'selected';}?>>Pago en una sola exhibición</option>
						<option value="PPD" <?php if(isset($_POST["metododepago"]) AND $_POST["metododepago"]=='PPD'){echo 'selected';}?>>Pago en parcialidades o diferido</option>
                    </select>
                </div>
            </div>
            <div style="overflow-x: auto;" id="partidas">
                <table class="visible-table">
                    <thead>
                        <tr>
                            <th align="center" class="texto3">IVA</th>
                            <th align="center" class="texto3">R. IVA</th>
                            <th align="center" class="texto3">R. ISR</th>
                            <th align="center" class="texto3">Cantidad</th>
                            <th align="center" class="texto3">Unidad</th>
                            <th align="center" class="texto3">Clave</th>
                            <th align="center" class="texto3">No. Identificación</th>
                            <th align="center" class="texto3">Concepto</th>
                            <th align="center" class="texto3">Precio</th>
                            <th align="center" class="texto3">Importe</th>
                            <th align="center" class="texto3">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td bgcolor="#dfe1e7" align="center" class="texto">
                                <div class="switch">
                                    <label>
                                        <input name="aplicaiva" id="aplicaiva" type="checkbox" value="1" checked>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto">
                                <div class="switch">
                                    <label>
                                        <input name="aplicariva" id="aplicariva" type="checkbox" value="1">
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto">
                                <div class="switch">
                                    <label>
                                        <input name="aplicarisr" id="aplicarisr" type="checkbox" value="1" <?php if(isset($_POST["apretisr"]) AND $_POST["apretisr"]==1){echo ' checked';}?>>
                                        <span class="lever"></span>
                                    </label>
                                </div>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="cantidad" id="cantidad" size="5"  value="1" onKeyUp="calculo(this.value,precio.value,total);">
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <select name="unidad" id="unidad"  class="browser-default">
                                    <option value="0">Seleccione</option>
                                    <?php
                                        if(is_array($dfactura["unidad"]))
                                        {
                                            foreach($dfactura["unidad"] AS $value)
                                            {
                                                echo '<option value="'.$value["Id"].'">'.$value["ClaveUnidad"].' - '.$value["Descripcion"].'</option>';
                                            }
                                        }
                                    ?>
                                </selec>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <select name="claveprodserv" id="claveprodserv"  class="browser-default">
                                    <option value="0">Seleccione</option>
                                    <?php
                                        if(is_array($dfactura["prodserv"]))
                                        {
                                            foreach($dfactura["prodserv"] AS $value)
                                            {
                                                echo '<option value="'.$value["Id"].'">'.$value["ClaveProdServ"].' - '.$value["Descripcion"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="numidentificacion" id="numidentificacion" size="10"  value="NO APLICA">
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <textarea name="producto" id="producto" style="height: 70px"></textarea>
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="precio" id="precio" size="10"  onKeyUp="calculo(cantidad.value,this.value,total)">
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <input type="text" name="total" id="total" size="10" >
                            </td>
                            <td bgcolor="#dfe1e7" align="center" class="texto" valign="top">
                                <!--<input type="button" name="botadprod" id="botadprod" value="+" class="btn waves-effect waves-light" onclick="partidas('hola')">-->
                                <input type="hidden" name="nuevafactura" id="nuevafactura" value="1">
                                <a class="modal-trigger button-blue" onclick="partidas()">+</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">Subtotal: </td>
                            <td align="right" bgcolor="">
                                <input type="hidden" name="subtotalf" id="subtotalf" value="">$ 
                            </td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">Iva 16 %: </td>
                            <td align="right" class="texto" bgcolor="">
                                <input type="hidden" name="ivaf" id="ivaf" value="">$ 
                            </td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">RET. I.S.R.: </td>
                            <td align="right" class="texto" bgcolor="">
                                <input type="hidden" name="risr" id="risr" value=""  size="3">$ 
                            </td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">RET. I.V.A.: </td>
                            <td align="right" class="texto" bgcolor="">
                                <input type="hidden" name="riva" id="riva" value=""  size="3">$ </td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9" bgcolor="" style="text-align: right">Total: </td>
                            <td align="right" class="texto" bgcolor="">
                                <input type="hidden" name="totalf" id="totalf" value="">$ </td>
                            <td align="center" clasS="texto" bgcolor="">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="15" align="center" bgcolor="" style="text-align: right">
                                <input type="hidden" name="partidas" id="partidas" value="">
                                <input type="submit" name="botfinfact" id="botfinfact" value="Guardar Factura>>" class="btn waves-effect waves-light" onclick="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</form>
    </div>
</div>

<script>
function calculo(cantidad,precio,inputtext){
    // Calculo del subtotal
    subtotal = precio*cantidad;
    inputtext.value=subtotal;
}

function partidas(borrapar = null){
    var apiva;
    var apretiva;
    var apretisr;
    var cantidad = document.getElementById('cantidad').value;
    var unidad = document.getElementById('unidad').value;
    var clave = document.getElementById('claveprodserv').value;
    var nidentificacion = document.getElementById('numidentificacion').value;
    var concepto = document.getElementById('producto').value;
    var precio = document.getElementById('precio').value;
    var total = document.getElementById('total').value;
    var riva = document.getElementById('retiva').value;
    var nuevafactura = document.getElementById('nuevafactura').value;
    var descuento = document.getElementById('descuento').value;

    if (document.getElementById('aplicaiva').checked){apiva = 1;}else{apiva = 0;}
    if (document.getElementById('aplicariva').checked){apretiva = 1;}else{apretiva = 0;}
    if (document.getElementById('aplicarisr').checked){apretisr = 1;}else{apretisr = 0;}

    var partida = apiva + '|' + apretiva + '|' + apretisr + '|' + cantidad + '|' + unidad + '|' + clave + '|' + nidentificacion + '|' + concepto + '|' + precio + '|' + total + '|' + riva;

    //console.log(apiva);

    $.ajax({
		type: 'POST',
		url : '<?php echo base_url('assets/factura/partidas.php');?>',
        data: 'partida=' + partida + '&borrapar=' + borrapar + '&nuevafactura=' + nuevafactura + '&empresa=' + '<?php echo $dfactura["empresa"];?>' + '&descuento=' + descuento
	}).done (function ( info ){
		$('#partidas').html(info);
	});
}
</script>