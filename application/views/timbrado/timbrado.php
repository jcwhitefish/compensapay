<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="p-5" id="app">
    <div class="row">
        <p class="px-3">Periodo:</p>
        <div class="col l3">
            <input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="start">Desde:</label>
        </div>
        <div class="col l3">
            <input type="date" id="fin" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
            <label for="fin">Hasta:</label>
        </div>
        <div class="col l2"></div>
        <div class="col l4 valign-wrapper right">
			<a id="btnAction" class="button-blue" style="margin-right: 40px" href="<?php echo base_url('/timbrado/nueva_factura');?>">Nueva Factura</a>
            <a id="btnAction" class="modal-trigger button-blue" style="margin-right: 40px" href="#modalcf" onclick="productosyservicios();unidades();">Configuración</a>
		</div>
        
    </div>

    <div class="row">
        <div class="card-content">
            <div style="overflow-x: auto;">
                <table class="visible-table striped">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>UUID</th>
                            <th>Fecha</th>
                            <th style="text-align: right;">Importe</th>
                            <th style="text-align: right;">Iva</th>
                            <th style="text-align: right;">Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>

<div id="modalcf" class="modal" style="width: 80% !important; height: 90% !important;">
    <div class="modal-content">
        <h6>Configuración facturas</h6>
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a href="#test1" class="active">Productos y Servicios</a></li>
                    <li class="tab col s3"><a href="#test2">Unidades de medida</a></li>
                </ul>
            </div>
            <div id="test1" class="col s12"></div>
            <div id="test2" class="col s12"></div>
        </div>
    </div>
</div>

<script>
function productosyservicios(clave = null, descripcion = null, estatus = null){
    $.ajax({
		type: 'POST',
		url : '<?php echo base_url('assets/factura/catprodserv.php');?>', 
        data: 'clave=' + clave + '&descripcion=' + descripcion + '&estatus=' + estatus + '&empresa=' + '<?php echo $empresa;?>'
	}).done (function ( info ){
		$('#test1').html(info);
	});
}
function activarps(idprodserv){
    $.ajax({
		type: 'POST',
		url : '<?php echo base_url('assets/factura/activarps.php');?>', 
        data: 'idprodserv=' + idprodserv + '&empresa=' + '<?php echo $empresa;?>'
	}).done (function ( info ){
		$('#psact_' + idprodserv).html(info);
	});
}
function unidades(clave = null, descripcion = null, estatus = null) {
    $.ajax({
		type: 'POST',
		url : '<?php echo base_url('assets/factura/catunidades.php');?>', 
        data: 'clave=' + clave + '&descripcion=' + descripcion + '&estatus=' + estatus + '&empresa=' + '<?php echo $empresa;?>'
	}).done (function ( info ){
		$('#test2').html(info);
	});
}
function activaru(idunidad){
    $.ajax({
		type: 'POST',
		url : '<?php echo base_url('assets/factura/activaru.php');?>', 
        data: 'idunidad=' + idunidad + '&empresa=' + '<?php echo $empresa;?>'
	}).done (function ( info ){
		$('#uact_' + idunidad).html(info);
	});
}
</script>