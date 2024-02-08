<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>


<div class="p-5">
    <h5>Timbrado</h5>
    <div class="row card esquinasRedondas" style="margin: 10px 10px 0 0; padding-top: 10px;">
        <div class="col l3">
            <div class="row" style="margin-bottom: 0px;">
				<div class="col valign-wrapper"><p>Desde:</p></div>
				<div class="col">
					<label for="start">
						<input
							type="date" id="start" name="trip-start" value="2023-10-01" min="2023-10-01"
							max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
					</label>
				</div>
			</div>
        </div>
        <div class="col l3">
            <div class="row" style="margin-bottom: 0px;">
				<div class="col valign-wrapper"><p>Hasta:</p></div>
				<div class="col">
					<label for="fin">
						<input
							type="date" id="fin" name="trip-start"
							value="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" min="2023-10-01"
							max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
					</label>
				</div>
			</div>
        </div>
        <div class="col l2"></div>
        <div class="col l2 valign-wrapper">
			<a id="btnAction" class="button-gray" href="<?php echo base_url('/timbrado/nueva_factura');?>">Nueva Factura</a>
        </div>
        <div class="col l2 valign-wrapper">
            <a id="btnAction" class="modal-trigger button-gray" href="#modalcf" onclick="productosyservicios();unidades();">Configuración</a>
		</div>
        
    </div>

    <div class="card esquinasRedondas">
        <div class="card-content">
            <div style="overflow-x: auto;">
                <table id="tabla_t_cfdis" class="stripe row-border order-column nowrap">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>XML</th>
                            <th>UUID</th>
                            <th>Fecha</th>
                            <th style="text-align: right;">Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(is_array($cfdis))
                        {
                            foreach($cfdis as $value)
                            {
                                switch($value["status"])
                                {
                                    case '-1': $status = '<a class="modal-trigger" href="#modalsf" onclick="pasar_a_oper(\''.$value["id"].'\')">Disponible</a>'; break;
                                    case 0: $status = 'Libre para operación'; break;
                                    case 1: $status = 'En operación'; break;
                                    case 2: $status = 'Cancelada'; break;
                                    case 3: $status = 'Pagada'; break;
                                }
                                echo '<tr>
                                        <td><strong>';if($value["short_name"]!=NULL){echo $value["short_name"];}else{echo $value["legal_name"];}echo '</strong></td>
                                        <td><a href="'.base_url('assets/factura/xml.php?idfactura='.$value["id"]).'"><i class="fa-solid fa-download" style="font-size: 20px"></i></a></td>
                                        <td><a href="'.base_url('assets/factura/factura.php?idfactura='.$value["id"]).'" target="_blank">'.$value["uuid"].'</a></td>
                                        <td>'.date("d-m-Y", $value["invoice_date"]).'</td>
                                        <td style="text-align: right;">$ '.number_format($value["total"], 2).'</td>
                                        <td>'.$status.'</td>
                                        
                                    </tr>';
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div id="modalcf" class="modal" style="width: 80% !important; height: 90% !important;">
    <div class="modal-content" styke="background: #f6f2f7 !important;">
        <h5>Configuración facturas</h5>
        <div class="row card esquinasRedondas">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#test1">Productos y Servicios</a></li>
                    <li class="tab col s3"><a class="" href="#test2">Unidades de medida</a></li>
                </ul>
            </div>
            <div id="test1" class="col s12"></div>
            <div id="test2" class="col s12"></div>
        </div>
    </div>
</div>

<div id="modalsf" class="modal" style="width: 80% !important; height: 90% !important;">
    <div class="modal-content" id="pasaope">
        <p class="flow-text">I am Flow Text</p>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.tabs').tabs();
});

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
function pasar_a_oper(idinvoice){
    $.ajax({
		type: 'POST',
		url : '<?php echo base_url('assets/factura/pasaraoper.php');?>', 
        data: 'idinvoice=' + idinvoice + '&url=' + '<?php echo base_url();?>'
	}).done (function ( info ){
		$('#pasaope').html(info);
	});
}
<?php
if(isset($factura))
{
    echo "M.toast({html: '".$factura["message"]."', displayLength: 1000, duration: 1000, edge: \"rigth\"})";
}
?>

var tabla_41 = $('#tabla_t_cfdis').DataTable({
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
<style>
    #toast-container {
		min-width: 10%;
		top: 50%;
		right: 50%;
		transform: translateX(50%) translateY(50%);
	}
</style>