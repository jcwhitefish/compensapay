<?php
defined('BASEPATH') or exit('No direct script access allowed');
$factura = base_url('assets/factura/factura.php?idfactura=');
?>
<style>
	input:disabled::placeholder {
		color: black !important;
		/* Cambia el color según tus preferencias */
		/* Otros estilos que desees aplicar al marcador de posición */
	}

	/* Modal */

	.text-modal {
		font-size: 13px;
	}

	.modal {
		max-height: 83% !important;
		width: 80% !important;
	}

	/* Fix show checkbox and radiobuttons*/

	[type="checkbox"]:not(:checked),
	[type="checkbox"]:checked {
		opacity: 1;
		position: relative;
		pointer-events: auto;
	}

	[type="radio"]:not(:checked),
	[type="radio"]:checked {
		opacity: 1;
		position: relative;
		pointer-events: auto;
	}

	/* Puntos suspensivos a fila donde se muestrael UUID */
	.uuid-text{
		width: 105px;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	/* Estilo vista de operacion */
	.font_head_op_info{
		font-weight: bold;
		font-size: 20px;
	}

	/* Fix button selected but all class selected afect */
	.selected {
		background-color: black !important;
		color: white !important;
		height: 50px;
		border: 2px solid black !important;
		border-radius: 10px;
	}
</style>
<div class="p-5" id="app" style="margin: 0;padding: 0 !important;">
	<!-- head con el calendario -->
	<div class="card esquinasRedondas" style="margin-right: 15px; margin-bottom: 5px">
		<div class="row" style="margin-left: 30px; margin-bottom: 1px">
			<h6>Periodo:</h6>
		</div>
		<div class="row" style="margin-bottom: 10px">
			<div class="col l3">
				<div class="row" style="margin-bottom: 0px;">
					<div class="col valign-wrapper"><p>Desde:</p></div>
					<div class="col">
						<label for="start">
							<input type="date" id="start" name="trip-start" value="2023-10-01" min="2023-10-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
						</label>
					</div>
				</div>
			</div>
			<div class="col l3">
				<div class="row" style="margin-bottom: 0px;">
					<div class="col valign-wrapper"><p>Hasta:</p></div>
					<div class="col">
						<label for="fin">
							<input type="date" id="fin" name="trip-start" value="<?=date('Y-m-d', strtotime('now'))?>" min="2023-10-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
						</label>
					</div>
				</div>
			</div>
			<div class="col l3"></div>
			<div class="col l3 valign-wrapper">
				<a id="btnAction" class="modal-trigger button-blue" href="#modal-factura">Crear conciliación</a>
			</div>
		</div>
	</div>
	<!-- Las tablas principales que se muestran Facturas-->
	<div class="card esquinasRedondas" id="tblsViewer" style="margin-right: 15px">
		<div class="card-content" style="padding: 10px; margin-right: ">
			<div class="row" style="margin-bottom: 1px">
				<div id="Menus" class="row l12 p-3" style="margin-bottom: 5px">
					<div class="col l3">
						<button id="btnConciliation" class="button-table" style="margin-right: 0.75rem" onclick="conciliation()">
							Conciliación
						</button>
						<button id="btnInvoice" class="button-table" style="margin-right: 0.75rem; margin-left: 0.75rem" onclick="cfdi()">
							Facturas
						</button>
					</div>
					<div class="col l2">

					</div>
				</div>
			</div>
			<div style="overflow-x: auto;">
				<table id="activeTbl" class="visible-table striped responsive-table" style="display: block; max-height: 400px">
					<tbody>
					<tr><td class="center-align">No hay datos</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Subir una factura -->
	<div id="modal-factura" class="modal">
		<div class="modal-content">
			<h5>Carga tus facturas</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<h6 class="p-3">Carga tu factura en formato .xml o múltiples facturas en un archivo .zip</h6>
					<form id="uploadForm" enctype="multipart/form-data">
						<div class="row">

							<div class="row">
								<div class="col l9 input-border">
									<input type="text" name="invoiceDisabled" id="invoiceDisabled" disabled v-model="invoiceUploadName" />
									<label for="invoiceDisabled">Una factura en xml o múltiples en .zip</label>
								</div>
								<div class="col l3 center-align p-5">
									<label for="invoiceUpload" class="custom-file-upload button-blue">Seleccionar</label>
									<input @change="checkFormatInvoice" name="invoiceUpload" ref="invoiceUpload" id="invoiceUpload" type="file" accept=".zip, .xml" maxFileSize="5242880" required />
								</div>
							</div>
							<div class="row">
								<div class="col l12 d-flex">
									<div class="p-5">
										<input class="p-5" type="checkbox" v-model="checkboxChecked" required>
									</div>
									<p class="text-modal">
										El Proveedor acepta y otorga su consentimiento en este momento para que una vez recibido el pago por la presente factura, Compensa Pay descuente y transfiere de manera automática a nombre y cuenta del Proveedor, el monto debido por el Proveedor en relación con dicha factura en favor del Cliente.
										Los términos utilizados en mayúscula tendrán el significado que se le atribuye dicho término en los <a href="terminosycondiciones">Términos y Condiciones</a>.
									</p><br>
								</div>
							</div>
							<div class="col l12 center-align">
								<a class="modal-close button-gray" style="color: #fff; color:hover: #">Cancelar</a>
								&nbsp;
								<button class="button-blue modal-close" type="button" name="action" @click="uploadFile">Siguiente</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Crear una conciliacion -->
	<div id="modal-conciliation" class="modal">
		<div class="modal-content">
			<h5>Crear Operación</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<h6 class="p-3">Carga tu nota xml relacionada a una factura</h6>
					<form id="uploadForm" enctype="multipart/form-data">
						<div class="row">
							<div class="col l3 input-border">
								<input type="text" name="operationDisabled" id="operationDisabled" disabled v-model="operationUploadName">
								<label for="operationDisabled">Tu Nota de Crédito XML</label>
							</div>
							<div class="col l4 left-align p-5">
								<label for="operationUpload" class="custom-file-upload button-blue">Seleccionar</label>
								<input @change="checkFormatOperation" name="operationUpload" ref="operationUpload" id="operationUpload" type="file" accept="application/xml" maxFileSize="5242880" required/>
							</div>
							<div class="col l5 input-border select-white">
								<input type="text" name="providerDisabled" id="providerDisabled" disabled v-model="clientUploadName">
								<label for="providerDisabled">Cliente</label>
							</div>
							<div class="col l12" style="overflow: scroll">
								<table class="visible-table striped">
									<thead>
									<tr>
										<th>Crear Operación</th>
										<th>Cliente</th>
										<th>RFC Cliente</th>
										<th>UUID Factura</th>
										<th>Fecha Factura</th>
										<th>Fecha Alta</th>
										<th>Fecha Transacción</th>
										<th>Subtotal</th>
										<th>IVA</th>
										<th>Total</th>
									</tr>
									</thead>
									<tbody>
									<tr v-for="facturaClient in facturasProveedor">
										<td class="tabla-celda center-align">
											<input type="radio" name="grupoRadio" :value="facturaClient.id" ref="grupoRadio" id="grupoRadio" v-model="radioChecked" required></i>
										</td>
										<td>{{facturaClient.name_client}}</td>
										<td>{{facturaClient.sender_rfc}}</td>
										<td><p class="uuid-text"><a :href="'assets/factura/factura.php?idfactura='+facturaClient.id" target="_blank">{{facturaClient.uuid}}</a></p></td>
										<td class="uuid-text">{{facturaClient.invoice_date}}</td>
										<td class="uuid-text">{{facturaClient.created_at}}</td>
										<td>
											<p v-if="facturaClient.transaction_date == '0000-00-00' " >Pendiente</p>
											<p class="uuid-text" v-if="facturaClient.transaction_date != '0000-00-00' " >{{facturaClient.transaction_date}}</p>
										</td>
										<td>${{facturaClient.subtotal}}</td>
										<td>${{facturaClient.iva}}</td>
										<td>${{facturaClient.total}}</td>
									</tr>
									</tbody>
								</table>
							</div><br>
							<div class="col l8">
								<a class="modal-trigger modal-close button-blue" href="#modal-solicitar-factura" v-if="clientUploadName != ''">Solicitar otra factura</a>
							</div>
							<div class="col l4 center-align">
								<a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
								&nbsp;
								<button class="button-blue" :class="{ 'modal-close': radioChecked }" name="action" type="reset" @click="uploadOperation">Siguiente</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Desde cliente creara operacion especifica a factura -->
	<div id="modal-operacion-unica" class="modal">
		<div class="modal-content">
			<h5>Crear Operación</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<h6 class="p-3">Carga tu xml relacionada a una factura</h6>
					<form id="uploadForm" enctype="multipart/form-data">
						<div class="row">
							<div class="col l3 input-border">
								<input type="text" name="operationDisabledUnique" id="operationDisabledUnique" disabled v-model="operationUploadNameUnique">
								<label for="operationDisabledUnique">Tu Nota de Crédito XML</label>
							</div>
							<div class="col l0 left-align p-5">
								<label for="uniqueOperationUpload" class="custom-file-upload button-blue">Seleccionar</label>
								<input @change="checkFormatOperationUnique" name="uniqueOperationUpload" ref="uniqueOperationUpload" id="uniqueOperationUpload" type="file" accept="application/xml" maxFileSize="5242880" required/>
							</div>
							<div class="col l5 input-border select-white">
								<input type="text" name="providerDisabledUnique" id="providerDisabledUnique" disabled v-model="clientUploadNameUnique">
								<label for="providerDisabledUnique">Cliente</label>
							</div>
							<div class="col l12" style="overflow: scroll">
								<table class="visible-table striped">
									<thead>
									<tr>
										<th>Cliente</th>
										<th>RFC Cliente</th>
										<th>UUID Factura</th>
										<th>Fecha Factura</th>
										<th>Fecha Alta</th>
										<th>Fecha Transacción</th>
										<th>Subtotal</th>
										<th>IVA</th>
										<th>Total</th>
									</tr>
									</thead>
									<tbody>
									<tr v-for="factura in facturasUnique">
										<td>{{factura.name_client }}</td>
										<td>{{factura.receiver_rfc }}</td>
										<td><p class="uuid-text"><a :href="'assets/factura/factura.php?idfactura='+factura.id" target="_blank">{{factura.uuid}}</a></p></td>
										<td class="uuid-text">{{factura.invoice_date}}</td>
										<td class="uuid-text">{{factura.created_at}}</td>
										<td>
											<p v-if="factura.transaction_date == '0000-00-00' " >Pendiente</p>
											<p class="uuid-text" v-if="factura.transaction_date != '0000-00-00' " >{{factura.transaction_date}}</p>
										</td>
										<td>${{factura.subtotal}}</td>
										<td>${{factura.iva}}</td>
										<td>${{factura.total}}</td>
									</tr>
									</tbody>
								</table>
							</div><br>
							<div class="col l8"></div>
							<div class="col l4 center-align">
								<a class="modal-close button-gray" style="color:#fff; color:hover:#">Cancelar</a>
								&nbsp;
								<button class="button-blue modal-close" name="action" type="reset" @click="uploadOperationUnica">Siguiente</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- solicitar factura -->
	<div id="modal-solicitar-factura" class="modal p-5">
		<h5>Solicitar Factura</h5>
		<div class="card esquinasRedondas">
			<form>
				<div class="card-content ">
					<div class="row">
						<div class="col l12">
							<label style="top: 0!important;" for="descripcion">Mensaje para Solicitar</label>
							<textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>
						</div>
						<div class="col l12 d-flex justify-content-flex-end">
							<a class="button-gray modal-close " style="color:#fff; color:hover:#">Cancelar</a>
							&nbsp;
							<button class="button-blue modal-close" onclick="M.toast({html: 'Se solicito Factura'})">Solicitar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- darle aceptar a una factura (el feo) -->
	<div id="modal-cargar-factura" class="modal">
		<div class="modal-content">
			<h5>Por favor, autoriza la transacción</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<h6 class="p-3">Carga tu factura en formato .xml o múltiples facturas en un archivo .zip</h6>
					<form @submit.prevent="actualizacion()" id="uploadForm" enctype="multipart/form-data">

						<div class="row">

							<div class="row">
								<div class="col l4 input-border">
									<input type="text" placeholder="Frontier" disabled />
									<label for="invoiceDisabled">Proveedor</label>
								</div>
								<div class="col l4 input-border">
									<input type="text" placeholder="XYZ832HS" disabled />
									<label for="invoiceDisabled">Factura</label>
								</div>
								<div class="col l4 input-border">
									<input type="text" placeholder="XYZ832HS" disabled />
									<label for="invoiceDisabled">Nota de Crédito</label>
								</div>
							</div>
							<div class="row">
								<div class="col l4 input-border">
									<input type="text" placeholder="TRA10035904" disabled />
									<label for="invoiceDisabled">ID Transacción</label>
								</div>
								<div class="col l4 input-border">
									<input type="text" placeholder="$ 21,576.00" disabled />
									<label for="invoiceDisabled">Monto Factura</label>
								</div>
								<div class="col l4 input-border">
									<input type="text" placeholder="$10,501.00" disabled />
									<label for="invoiceDisabled">Monto Nota de Débito (ingreso):</label>
								</div>
							</div>
							<div class="row">
								<div class="col l4 input-border">
									<input type="date" id="start" name="trip-start" value="2023-07-22" min="2023-01-01" max="2040-12-31" />
									<label for="start">Inicio:</label>
								</div>
								<div class="col l4 input-border p-1">
									<input type="text" placeholder="123456789098745612" disabled />
									<label for="invoiceDisabled">Cuenta CLABE del proveedor</label>
								</div>
							</div>
							<div class="col l12">
								<div class="col l8">
									<a class="button-gray modal-close">Cancelar</a>
								</div>
								<div class="col l4 center-align">
									<a onclick="M.toast({html: 'Se rechazo'})" class="button-white modal-close">Rechazar</a>
									&nbsp;
									<button class="button-blue modal-close" type="submit">Autorizar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- darle rechazar una factura -->
	<div id="modal-rechazo" class="modal p-5">
		<h5>Operación rechazada</h5>
		<div class="card esquinasRedondas">
			<form>
				<div class="card-content ">
					<div class="row">
						<div class="col l12">
							<label style="top: 0!important;" for="descripcion">Indique la razón específica de la cancelación de la operacion.</label>
							<textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>
						</div>
						<div class="col l12 d-flex justify-content-flex-end">
							<a class="button-gray modal-close " style="color:#fff; color:hover:#">Cancelar</a>
							&nbsp;
							<button class="button-blue modal-close" name="action" type="reset"  @click="changeStatus('2')">Enviar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	let btnActive = 0;
	$(document).ready(function() {
		conciliation();
		$('#start').on('change', function (){
			switch(btnActive) {
				case 0:
					conciliation();
					break;
				case 1:
					cfdi()
					break;
			}

		});
		$('#fin').on('change', function (){
			switch(btnActive) {
				case 0:
					conciliation();
					break;
				case 1:
					cfdi()
					break;
			}

		});
	});
	function noSelect(){
		$('#btnConciliation').removeClass("selected");
		$('#btnInvoice').removeClass("selected");
		$('#activeTbl').empty();
		$('#btnAction').empty();
	}
	function conciliation(){
		btnActive = 0;
		noSelect();
		$('#btnConciliation').addClass("selected");
		let btnAction = $('#btnAction').append('Crear conciliación');
		btnAction.attr('href', '#modal-conciliation');
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Emisor</th>' +
			'<th>Receptor</th>' +
			'<th class="center-align">CFDI</th>' +
			'<th>Fecha CFDI</th>' +
			'<th>Fecha Alta</th>' +
			'<th style="min-width: 135px">Fecha limite de pago</th>' +
			'<th style="min-width: 110px">Subtotal</th>' +
			'<th style="min-width: 110px">IVA</th>' +
			'<th style="min-width: 110px">Total</th>' +
			'<th>tipo</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan=11" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
	}
	function cfdi(){
		btnActive = 1;
		noSelect();
		$('#btnInvoice').addClass("selected");
		let btnAction = $('#btnAction').append('Añadir facturas');
		btnAction.attr('href', '#modal-factura');
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Emisor</th>' +
			'<th>Receptor</th>' +
			'<th class="center-align">CFDI</th>' +
			'<th>Fecha CFDI</th>' +
			'<th>Fecha Alta</th>' +
			'<th style="min-width: 135px">Fecha limite de pago</th>' +
			'<th style="min-width: 110px">Subtotal</th>' +
			'<th style="min-width: 110px">IVA</th>' +
			'<th style="min-width: 110px">Total</th>' +
			'<th>tipo</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan=11" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
	}

	function cfdi(){
		btnActive = 0;
		noSelect();
		$('#cfdi').addClass("selected");
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Emisor</th>' +
			'<th>Receptor</th>' +
			'<th class="center-align">CFDI</th>' +
			'<th>Fecha CFDI</th>' +
			'<th>Fecha Alta</th>' +
			'<th style="min-width: 135px">Fecha limite de pago</th>' +
			'<th style="min-width: 110px">Total</th>' +
			'<th>tipo</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan=11" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
		$.ajax({
			url: '/Conciliaciones/CFDI',
			data: {
				from: $('#start').val(),
				to: $('#fin').val(),
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
				const obj = $('#tblsViewer');
				const left = obj.offset().left;
				const top = obj.offset().top;
				const width = obj.width();
				const height = obj.height();
				$('#solveLoader').css({
					display: 'block',
					left: left,
					top: top,
					width: width,
					height: height,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				if (data.code === 500 || data.code === 404){
					let toastHTML = '<span><strong>'+data.message+'</strong></span>';
					M.toast({html: toastHTML});
					toastHTML = '<span><strong>'+data.reason+'</strong></span>';
					M.toast({html: toastHTML});
				}else{
					$('#tblBody').empty();
					$.each(data, function(index, value){
						let uuid;
						let subtotal;
						let iva;
						if (value.tipo === 'factura') {
							uuid = '<a href="' + value.idurl + '" target="_blank">' + value.uuid + '</a>';
						} else {
							uuid = value.uuid;
						}
						const tr = $('<tr>' +
							'<td><input id="checkTbl" type="checkbox" style="position:static"></td>' +
							'<td>' + value.emisor + '</td>' +
							'<td>' + value.receptor + '</td>' +
							'<td>' + uuid + '</td>' +
							'<td>' + value.dateCFDI + '</td>' +
							'<td>' + value.dateCreate + '</td>' +
							'<td>' + value.dateToPay + '</td>' +
							'<td>$ ' + value.total + '</td>' +
							'<td>' + value.tipo + '</td>' +
							'</tr>');
						$('#tblBody').append(tr);
					});
				}
			},
			complete: function () {
				$('#solveLoader').css({
					display: 'none'
				});
			},
			error: function (data){
				$('#solveLoader').css({
					display: 'none'
				});
				let toastHTML = '<span><strong>Ha ocurrido un problema</strong></span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML});
			}
		});
	}
</script>
