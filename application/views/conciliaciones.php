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
	/* Fix show checkbox and radiobutton*/
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
	/* Fix button selected but all class selected afect */
	.selected {
		background-color: black !important;
		color: white !important;
		height: 50px;
		border: 2px solid black !important;
		border-radius: 10px;
	}
	#toast-container {
		min-width: 10%;
		top: 50%;
		right: 50%;
		transform: translateX(50%) translateY(50%);
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
				<div class="row" style="margin-bottom: 0;">
					<div class="col valign-wrapper"><p>Desde:</p></div>
					<div class="col">
						<label for="start">
							<input type="date" id="start" name="trip-start" value="2023-10-01" min="2023-10-01" max="<?=date('Y-m-d', strtotime('now'))?>" />
						</label>
					</div>
				</div>
			</div>
			<div class="col l3">
				<div class="row" style="margin-bottom: 0;">
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
				<a id="btnAction" class="modal-trigger button-blue" href="#modal-CFDI">Subir CFDI</a>
			</div>
		</div>
	</div>
	<!-- Las tablas principales que se muestran Facturas-->
	<div class="card esquinasRedondas" id="tblsViewer" style="margin-right: 15px">
		<div class="card-content" style="padding: 10px; ">
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
	<!-- darle rechazar una factura -->
	<div id="modal-rechazo" class="modal p-5">
		<h5>Operación rechazada</h5>
		<div class="card esquinasRedondas">
			<form>
				<div class="card-content ">
					<div class="row">
						<div class="col l12">
							<label style="top: 0!important;" for="descripcion">Indique la razón específica de la cancelación de la operación.</label>
							<textarea style="min-height: 30vh;" id="descripcion" name="descripcion" class="materialize-textarea validate" required></textarea>
						</div>
						<div class="col l12 d-flex justify-content-flex-end">
							<a class="button-gray modal-close ">Cancelar</a>
							<button class="button-blue modal-close" name="action" type="reset">Enviar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- darle aceptar a una factura -->
	<div id="modal-aut-conciliation" class="modal modal-fixed-footer" style="max-height: 98% !important; height: 95%; width: 90% !important">
		<div class="modal-content" style="padding-top:10px;">
			<h5 >Por favor, autoriza la transacción</h5>
			<div class="card esquinasRedondas">
				<div class="card-content" style="padding-top:0">
					<div class="row" style="margin-bottom: 0">
						<div class="row" style="margin-bottom: 0">
							<div class="col l2"><h6>Emisor:</h6></div>
							<div class="col l5"><h6>CFDI:</h6></div>
							<div class="col l5"><h6>Nota de crédito/Factura</h6></div>
						</div>
						<div class="row" style="font-size: 22px;">
							<div class="col l2" id="autEmisor">Emisor:</div>
							<div class="col l5" id="autCFDI" >Factura:</div>
							<div class="col l5" id="autConciliador">Nota de crédito/Factura</div>
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
							<div class="col l4" id="autMonto2">Nota de crédito/Factura</div>
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
	<div id="modal-CFDI" class="modal modal" style="max-height: 98% !important; height: 95%; width: 90% !important">
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
								<a class="modal-close button-gray" >Cancelar</a>
								<input class="button-blue" type="submit" value="Siguiente" </input>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- crear conciliación -->
	<div id="modal-new-conciliation" class="modal modal-fixed-footer" style="max-height: 98% !important; height: 95%; width: 90% !important">
		<div class="modal-content">
			<h5>Crear conciliación</h5>
			<div class="card esquinasRedondas">
				<div class="card-content">
					<form id="uploadNoteForm" enctype="multipart/form-data">
						<div class="row">
							<p>
								<input name="typeConcilia" id="receptorWay" type="radio"/>
								<label for="receptorWay">
									<span>Selecciona CFDI de pago inicial</span>
								</label>
							</p>
							<p>
								<input name="typeConcilia" id="issuingWay" type="radio"/>
								<label for="issuingWay">
									<span>Cargar nota de crédito</span>
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
										<input type="hidden" id="ReceiverId">
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
							<a class="modal-close button-gray">Cancelar</a>
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
						M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
						toastHTML = '<span><strong>' + data.reason + '</strong></span>';
						M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
						
						// location.reload()
					} else {
						$('#modal-CFDI').modal('close');
						toastHTML = '<span>' + data.message + '</span>';
						M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
						
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
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
					toastHTML = '<span>Por favor intente mas tarde</span>';
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
					toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
					
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
							M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
							toastHTML = '<span><strong>' + data.reason + '</strong></span>';
							M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
							
							// location.reload()
						} else {
							$('#modal-new-conciliation').modal('close');
							toastHTML = '<span>' + data.message + '</span>';
							M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
							
							conciliation();
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
						M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
						toastHTML = '<span>Por favor intente mas tarde</span>';
						M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
						toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
						M.toast({html: toastHTM, displayLength:1000, duration: 1000, edge: 'rigth'});
						
					}
				});
			}else{

			}
		})
		document.querySelectorAll("input[name='typeConcilia']").forEach((input) => {
			input.addEventListener('change', function (e){
				let contenVar = $('#contentVariable');
				if (e.target.id === 'issuingWay'){
					conciliateWay = 0;
					let debit = '<div class="file-field input-field" ><div class="file-path-wrapper" style="width: 75%;margin-left: auto;float: left;">' +
						'<input class="file-path validate" type="text" placeholder="Sube tu nota de crédito en formato .xml" disabled ></div>' +
						'<div style="width: 25%;margin-left: auto;"><label for="containerNote" class="custom-file-upload button-blue">Seleccionar</label>' +
						'<input name="containerNote" id="containerNote" type="file" accept=".xml" maxFileSize="5242880" required /></div></div>'
					contenVar.empty();
					contenVar.append(debit);
				}else{
					conciliateWay = 1;
					contenVar.empty();
					$.ajax({
						url: '/Conciliaciones/ContraCFDI',
						data: {
							amount: $('#OriginAmount').val(),
							receiverId: $('#ReceiverId').val(),
						},
						dataType: 'json',
						method: 'post',
						beforeSend: function () {
							const obj = $('#modal-new-conciliation');
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
							let contra = '<ul class="collection" id="contraCFDI"></ul>';
							contenVar.append(contra);
							if (data.code === 500 || data.code === 404){
								let toastHTML = '<span><strong>'+data.message+'</strong></span>';
								M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
								toastHTML = '<span><strong>'+data.reason+'</strong></span>';
								M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});

							}else{
								$.each(data, function(index, value){
									let li = $('<select  class="browser-default" multiple style="height:250px">' +
										'<option value="0">' +
											'<li class="collection-item avatar">' +
											'<i class="material-icons circle">description</i>' +
											'<span class="title"><a href="'+value.idurl+'" target="_blank">'+value.uuid+'</a></span>' +
											'<p><strong>Emisor: </strong>'+value.sender+'<br><strong>Total: </strong>$'+value.total+'</p>' +
											'<a href="#!" class="secondary-content"><i class="material-icons">send</i></a></li>' +
										'</option>' +
										'<option value="1">Option 1</option>' +
										'<option value="2">Option 2</option>' +
										'<option value="3">Option 3</option>' +
										'</select><label>Seleccione el CFDI para hacer conciliación.</label>');
									// let li = $('<li class="collection-item avatar">' +
									// 	'<i class="material-icons circle">description</i>' +
									// 	'<span class="title"><a href="'+value.idurl+'" target="_blank">'+value.uuid+'</a></span>' +
									// 	'<p><strong>Emisor: </strong>'+value.sender+'<br><strong>Total: </strong>$'+value.total+'</p>' +
									// 	'<a href="#!" class="secondary-content"><i class="material-icons">send</i></a>' +
									// 	'</li>');
									$('#contraCFDI').append(li);
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
							M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
							toastHTML = '<span>Por favor intente mas tarde</span>';
							M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
							toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
							M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});

						}
					});
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
					let toastHTML = '<span><strong>'+data.message+' </strong> </span>&nbsp;<br><p><span><strong>' +data.reason+'</strong></span>';
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
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
				M.toast({html: toastHTML, displayLength:1000, duration: 1000});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML, displayLength:1000, duration: 1000});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML, displayLength:1000, duration: 1000});
				
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
					let toastHTML = '<span><strong>'+data.message+' </strong> </span>&nbsp;<br><p><span><strong>' +data.reason+'</strong></span>';
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
					
				}else{
					$('#tblBody').empty();
					$.each(data, function(index, value){
						let uuid;
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
									$('#conciliaDate').attr('value', dateS[2]+'-'+dateS[1]+'-'+dateS[0]);
									$('#OriginCFDI').val(value.id);
									$('#OriginAmount').val(value.total);
									$('#ReceiverId').val(value.receptorId);
									$('#receptorWay').trigger('change');
									$('#receptorWay').trigger('click');
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
				M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
				
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
					let toastHTML = '<span><strong>'+data.message+' </strong> </span>&nbsp;<br><p><span><strong>' +data.reason+'</strong></span>';
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
					
					// location.reload()
				} else {
					$('#modal-aut-conciliation').modal('close');
					toastHTML = '<span>' + data.message + '</span>';
					M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
					
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
				M.toast({html: toastHTM, displayLength:1000, duration: 1000, edge: 'rigth'});
				toastHTML = '<span>Por favor intente mas tarde</span>';
				M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
				toastHTML = '<span>Si el problema persiste levante ticket en el apartado de soporte</span>';
				M.toast({html: toastHTML, displayLength:1000, duration: 1000, edge: 'rigth'});
				
			}
		});
	}
</script>
