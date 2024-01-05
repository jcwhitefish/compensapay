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
<div class="p-5" style="margin: 0;padding: 0 !important;">
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
					<tr><td class="center-align" colspan="14">No hay datos</td></tr>
					</tbody>
				</table>
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
	<!-- solicitar facturas -->
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
	<!-- darle aceptar a una factura -->
	<div id="modal-aut-conciliation" class="modal modal-fixed-footer" style="max-height 98% !important; height: 95%; width: 90% !important">
		<div class="modal-content" style="padding-top:10px;">
			<h5 >Por favor, autoriza la transacción</h5>
			<div class="card esquinasRedondas">
				<div class="card-content" style="padding-top:0">
					<div class="row" style="margin-bottom: 0">
						<div class="row" style="margin-bottom: 0">
							<div class="col l2"><h6>Emisor:</h6></div>
							<div class="col l5"><h6>CFDI:</h6></div>
							<div class="col l5"><h6>Nota de debito/Factura</h6></div>
						</div>
						<div class="row" style="font-size: 22px;">
							<div class="col l2" id="autEmisor">Emisor:</div>
							<div class="col l5" id="autCFDI" >Factura:</div>
							<div class="col l5" id="autConciliador">Nota de debito/Factura</div>
						</div>
					</div>
					<div class="row" style="margin-bottom: 0">
						<div class="row" style="margin-bottom: 0">
							<div class="col l4"><h6>Referencia:</h6></div>
							<div class="col l4"><h6>Monto inicial:</h6></div>
							<div class="col l4"><h6>Monto conciliador</h6></div>
						</div>
						<div class="row" style="font-size: 22px;">
							<div class="col l4" id="autReferencia">Emisor:</div>
							<div class="col l4" id="autMonto1">Factura:</div>
							<div class="col l4" id="autMonto2">Nota de debito/Factura</div>
						</div>
					</div>
					<div class="row" style="margin-bottom: 0">
						<div class="row" style="margin-bottom: 0">
							<div class="col l4"><h6>Cuenta clabe del proveedor:</h6></div>
							<div class="col l4">
								<h6>Fecha de pago:
									<i class="small material-icons" title="Fecha maxima para realizar el pago" style="cursor: help">help</i>
								</h6>
							</div>
						</div>
						<div class="row" style="font-size: 22px;">
							<div class="col l4" id="autClabe">Emisor:</div>
							<div class="col l4">
								<label>
									<input type="date" id="autPayDate" min = "<?=date('Y-m-d',strtotime('now'))?>"
										   max = "<?=date('Y-m-d',strtotime('now +3 month'))?>"
										   value = "<?=date('Y-m-d',strtotime('now'))?>" />
								</label>
							</div>
						</div>
					</div>
					<div class="row" style="margin-bottom: 0; align-content: center; text-align: center;">
						<div class="col l6" id="autCancel"></div>
						<div class="col l6" id="autAceptar"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
		</div>
	</div>
	<!-- Subir los CFDI -->
	<div id="modal-CFDI" class="modal modal" style="max-height 98% !important; height: 95%; width: 90% !important">
		<div class="modal-content">
			<h5>Carga tus CFDI</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<h6 class="p-3">Carga tu CFDI en formato .xml o múltiples .xml en un archivo .zip</h6>
					<form id="uploadCFDI" enctype="multipart/form-data">
						<div class="file-field input-field" >
							<div class="file-path-wrapper" style="width: 75%;margin-left: auto;float: left;">
								<input class="file-path validate" type="text" placeholder="Una factura en xml o múltiples en .zip" disabled >
							</div>
							<div style="width: 25%;margin-left: auto;">
								<label for="containerCFDI" class="custom-file-upload button-blue">Seleccionar</label>
								<input name="containerCFDI" id="containerCFDI" type="file" accept=".zip, .xml" maxFileSize="5242880" required />
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="col l12 d-flex">
									<div class="p-5">
										<input class="p-5" type="checkbox" required>
									</div>
									<p class="text-modal" style="text-align: justify;">
										Proveedor acepta y otorga su consentimiento en este momento para que una vez recibido el pago por la presente
										factura, Compensa Pay descuente y transfiere de manera automática a nombre y cuenta del Proveedor, el monto
										debido por el Proveedor en relación con dicha factura en favor del Cliente.
										Los términos utilizados en mayúscula tendrán el significado que se le atribuye dicho término en los
										<a href="terminosycondiciones">Términos y Condiciones</a>.
									</p><br>
								</div>
							</div>
							<div class="col l12 center-align">
								<a class="modal-close button-gray" style="color: #fff; color:hover: #">Cancelar</a>
								&nbsp;
								<input class="button-blue" type="submit" value="Siguiente" </input>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- crear conciliacion -->
	<div id="modal-new-conciliation" class="modal modal-fixed-footer" style="max-height 98% !important; height: 95%; width: 90% !important">
		<div class="modal-content">
			<h5>Crear concilicación</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<form id="uploadNoteForm" enctype="multipart/form-data">
						<div class="row">
							<p>
								<label>
									<input name="typeConcilia" id="receptorWay" type="radio" checked />
									<span>Selecciona CFDI de pago inicial</span>
								</label>
							</p>
							<p>
								<label>
									<input name="typeConcilia" id="issuingWay" type="radio"/>
									<span>Cargar nota de debito</span>
								</label>
							</p>
						</div>
						<div class="row" id="contentVariable"></div>
						<div class="row">
							<div class="row" style="margin-bottom: 0">
								<div class="row" style="margin-bottom: 0">
									<div class="col l4">
										<h6>Fecha de pago:
											<i class="small material-icons" title="Fecha maxima para realizar el pago" style="cursor: help">help</i>
										</h6>
									</div>
								</div>
								<div class="row" style="font-size: 22px;">
									<div class="col l4">
										<label>
											<input type="date" id="conciliaDate" min = "<?=date('Y-m-d',strtotime('now'))?>"
												   max = "<?=date('Y-m-d',strtotime('now +3 month'))?>"
												   value = "<?=date('Y-m-d',strtotime('now'))?>" />
										</label>
										<input type="hidden" id="OriginCFDI">
										<input type="hidden" id="OriginAmount">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
						<div class="row">
							<div class="col l12 d-flex">
								<div class="p-5">
									<input class="p-5" type="checkbox" required>
								</div>
								<p class="text-modal" style="text-align: justify;">
									Proveedor acepta y otorga su consentimiento en este momento para que una vez recibido el pago por la presente
									factura, Compensa Pay descuente y transfiere de manera automática a nombre y cuenta del Proveedor, el monto
									debido por el Proveedor en relación con dicha factura en favor del Cliente.
									Los términos utilizados en mayúscula tendrán el significado que se le atribuye dicho término en los
									<a href="terminosycondiciones">Términos y Condiciones</a>.
								</p><br>
							</div>
						</div>
						<div class="col l12 center-align">
							<a class="modal-close button-gray" style="color: #fff; color:hover: #">Cancelar</a>
							&nbsp;
							<input class="button-blue" type="submit" value="Siguiente" </input>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close button-gray">Cancelar</a>
		</div>
	</div>
</div>
<script>
	let btnActive = 0;
	let conciliateWay = 0;
	$(document).ready(function() {
		conciliation();
		// $('#modal-new-conciliation').modal('open');/
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
		$('#uploadCFDI').on('submit', function (e) {
			e.preventDefault();
			const formData = new FormData();
			const files = $('#containerCFDI')[0].files[0];
			formData.append('file',files);
			$.ajax({
				url: '/Conciliaciones/cargarComprobantes',
				data: formData	,
				dataType: 'json',
				contentType: false,
				processData: false,
				method: 'post',
				beforeSend: function () {
					const obj = $('#modal-CFDI');
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
					let toastHTML;
					if (data.code === 500 || data.code === 404) {
						let toastHTML = '<span><strong>' + data.message + '</strong></span>';
						M.toast({html: toastHTML});
						toastHTML = '<span><strong>' + data.reason + '</strong></span>';
						M.toast({html: toastHTML});
						// location.reload()
					} else {
						$('#modal-CFDI').modal('close');
						toastHTML = '<span>' + data.message + '</span>';
						M.toast({html: toastHTML});
					}
				},
				complete: function () {
					$('#solveLoader').css({
						display: 'none'
					}).delay(2000);
					cfdi();
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
		})
		$('#uploadNoteForm').on('submit', function (e) {
			e.preventDefault();
			if (conciliateWay === 0){
				const formData = new FormData();
				const files = $('#containerNote')[0].files[0];
				formData.append('file', files);
				formData.append('conciliaDate', $('#conciliaDate').val());
				formData.append('OriginCFDI', $('#OriginCFDI').val());
				formData.append('OriginAmount', $('#OriginAmount').val());
				$.ajax({
					url: '/Conciliaciones/cargarNote',
					data: formData	,
					dataType: 'json',
					contentType: false,
					processData: false,
					method: 'post',
					beforeSend: function () {
						const obj = $('#modal-CFDI');
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
						let toastHTML;
						if (data.code === 500 || data.code === 404) {
							let toastHTML = '<span><strong>' + data.message + '</strong></span>';
							M.toast({html: toastHTML});
							toastHTML = '<span><strong>' + data.reason + '</strong></span>';
							M.toast({html: toastHTML});
							// location.reload()
						} else {
							$('#modal-CFDI').modal('close');
							toastHTML = '<span>' + data.message + '</span>';
							M.toast({html: toastHTML});
						}
					},
					complete: function () {
						$('#solveLoader').css({
							display: 'none'
						}).delay(2000);
						cfdi();
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
			}else{

			}
		})
		document.querySelectorAll("input[name='typeConcilia']").forEach((input) => {
			input.addEventListener('change', function (e){
				if (e.target.id === 'issuingWay'){
					conciliateWay = 0;
					let debit = '<div class="file-field input-field" ><div class="file-path-wrapper" style="width: 75%;margin-left: auto;float: left;">' +
						'<input class="file-path validate" type="text" placeholder="Sube tu nota de debito en formato .xml" disabled ></div>' +
						'<div style="width: 25%;margin-left: auto;"><label for="containerNote" class="custom-file-upload button-blue">Seleccionar</label>' +
						'<input name="containerNote" id="containerNote" type="file" accept=".xml" maxFileSize="5242880" required /></div></div>'
					$('#contentVariable').empty();
					$('#contentVariable').append(debit);
				}else{
					$('#contentVariable').empty();
				}

			});
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
		let btnAction = $('#btnAction').append('Subir CFDI');
		btnAction.attr('href', '#modal-CFDI');
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Autorización</th>' +
			'<th class="center-align">Estatus conciliación</th>' +
			'<th style="min-width: 130px; text-align: center">Numero de referencia</th>' +
			'<th class="center-align">Emisor</th>' +
			'<th class="center-align">Receptor</th>' +
			'<th style="min-width: 345px; text-align: center" class="center-align">CFDI Inicial</th>' +
			'<th class="center-align">Monto</th>' +
			'<th class="center-align">Fecha Alta CFDI</th>' +
			'<th style="min-width: 346px; text-align: center">CFDI Conciliación</th>' +
			'<th class="center-align">Monto</th>' +
			'<th class="center-align">Fecha Alta CFDI</th>' +
			'<th class="center-align">Fecha limite de pago</th>' +
			'<th class="center-align">Fecha de conciliación</th>' +
			'</tr></thead>' +
			'<tbody id="tblBody"><tr><td colspan="14" class="center-align">No hay datos</td></tr></tbody>';
		$('#activeTbl').append(tableBase);
		$.ajax({
			url: '/Conciliaciones/conciliation',
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
						let uuid, status, uuid2;
						let aut,cancel,acept;
						uuid = '<a href="' + value.idurl + '" target="_blank">' + value.uuid1 + '</a>';
						uuid2 = '<a href="' + value.idur2 + '" target="_blank">' + value.uuid2 + '</a>';
						if(value.role === 'receptor'){
							switch (value.status){
								case '0':
									aut = $('<a class="modal-trigger" href="#modal-aut-conciliation">Autorizar</a>');
									cancel = $('<a class="modal-trigger button-orange modal-close" href="#modal-rechazo">Rechazar</a>');
									acept = $('<a class="button-blue ">Aceptar</a>');
									cancel.click(function (){

									});
									acept.click(function (){
										aceptOp(value.id, $('#autPayDate').val());
									});
									aut.click(function (){
										let autEmisor = $('#autEmisor');
										let autCFDI = $('#autCFDI');
										let autConciliador = $('#autConciliador');
										let autReferencia = $('#autReferencia');
										let autMonto1 = $('#autMonto1');
										let autMonto2 = $('#autMonto2');
										let autClabe = $('#autClabe');
										let autPayDate = $('#autPayDate');
										autEmisor.empty();
										autCFDI.empty();
										autConciliador.empty();
										autReferencia.empty();
										autMonto1.empty();
										autMonto2.empty();
										autClabe.empty();
										autEmisor.append(value.emisor);
										autCFDI.append(uuid);
										autConciliador.append(uuid2);
										autReferencia.append(value.operation_number);
										autMonto1.append('$'+value.total1);
										autMonto2.append('$'+value.total2);
										autClabe.append(value.account_clabe);
										let dateS = (value.datePago);
										dateS = dateS.split('-');
										autPayDate.attr('value', dateS[2]+'-'+dateS[1]+'-'+dateS[0]);
										$('#autAceptar').empty();
										$('#autCancel').empty();
										$('#autAceptar').append(acept);
										$('#autCancel').append(cancel);
									});
									break;
								case '1':
									aut = '<i class="small material-icons" style="color: green;">check_circle</i>';
									break;
								case '2':
									aut = '<i class="small material-icons" style="color: red;">cancel</i>';
									break;
							}
						}else{
							switch (value.status){
								case '0':
									aut = '<i class="small material-icons">panorama_fish_eye</i>';
									break;
								case '1':
									aut = '<i class="small material-icons" style="color: green;">check_circle</i>';
									break;
								case '2':
									aut = '<i class="small material-icons" style="color: red;">cancel</i>';
									break;
							}
						}
						switch (value.status){
							case '0':
								status = '<p>Pendiente de autorización</p>';
								break;
							case '1':
								status = '<p>Autorizada</p>';
								break;
							case '2':
								status = '<p>Rechazada</p>';
								break;
							case '3':
								status = '<p>Realizada</p>';
								break;
							case '4':
								status = '<p>Vencida</p>';
								break;
						}
						const tr = $('<tr>' +
							'<td><input id="checkTbl" type="checkbox" style="position:static"></td>' +
							'<td class="tabla-celda center-align" id="aut'+value.id+'"></td>' +
							'<td class="tabla-celda center-align">' + status + '</td>' +
							'<td>' + value.operation_number + '</td>' +
							'<td>' + value.emisor + '</td>' +
							'<td>' + value.receptor + '</td>' +
							'<td>' + uuid + '</td>' +
							'<td>$ ' + value.total1 + '</td>' +
							'<td>' + value.dateCFDI1 + '</td>' +
							'<td>' + uuid2 + '</td>' +
							'<td>$ ' + value.total2 + '</td>' +
							'<td>' + value.dateCFDI2 + '</td>' +
							'<td id="tblPayD'+value.id+'">' + value.datePago + '</td>' +
							'<td>' + value.conciliationDate + '</td>' +
							'</tr>');
						$('#tblBody').append(tr);
						$('#aut'+value.id).append(aut);
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
	function cfdi(){
		btnActive = 0;
		noSelect();
		$('#cfdi').addClass("selected");
		let btnAction = $('#btnAction').append('Subir CFDI');
		btnAction.attr('href', '#modal-CFDI');
		const tableBase = '<thead style="position:sticky; top: 0;"><tr>' +
			'<th>Seleccionar</th>' +
			'<th>Concilición</th>' +
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
						let initC = $('<a class="modal-trigger" href="#modal-new-conciliation">Crear conciliación</a>');
						switch (value.status){
							case '0':
								initC.click(function(){
									let dateS = (value.dateToPay);
									dateS = dateS.split('-');
									console.log(dateS);
									$('#conciliaDate').attr('value', dateS[2]+'-'+dateS[1]+'-'+dateS[0]);
									$('#OriginCFDI').val(value.id)
									$('#OriginAmount').val(value.total)
								});
								break;
							case '1':
								initC = '<i class="small material-icons" style="color: green;">check_circle</i>';
								break;
							case '2':
								initC = '<i class="small material-icons" style="color: red;">cancel</i>';
								break;
						}
						const tr = $('<tr>' +
							'<td><input id="checkTbl" type="checkbox" style="position:static"></td>' +
							'<td id="initC'+value.id+'"></td>' +
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
						$('#initC'+value.id).append(initC);
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
	function aceptOp(id, payDate){
		$.ajax({
			url: '/Conciliaciones/accept',
			data: {
				id:id,
				payDate: payDate,
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
				const obj = $('#modal-aut-conciliation');
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
				let toastHTML;
				if (data.code === 500 || data.code === 404) {
					let toastHTML = '<span><strong>' + data.message + '</strong></span>';
					M.toast({html: toastHTML});
					toastHTML = '<span><strong>' + data.reason + '</strong></span>';
					M.toast({html: toastHTML});
					// location.reload()
				} else {
					$('#modal-aut-conciliation').modal('close');
					toastHTML = '<span>' + data.message + '</span>';
					M.toast({html: toastHTML});
					$('#aut'+id).empty();
					$('#tblPayD'+id).empty()
					let aut = '<i class="small material-icons" style="color: green;">check_circle</i>';
					$('#aut'+id).append(aut);
					let dateS = (payDate);
					dateS = dateS.split('-');
					$('#tblPayD'+id).append(dateS[2]+'-'+dateS[1]+'-'+dateS[0]);
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
