<style>
	td, th {
		padding: 15px !important;
	}
	[type="checkbox"]:not(:checked), [type="checkbox"]:checked {
		opacity: 0 !important;
	}
	input:disabled::placeholder {
		color: #ad8db8 !important;
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
	[type="radio"]{display: none}
	th {
		background: white;
		position: sticky;
		top: 0; /* Don't forget this, required for the stickiness */
		box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
	}
	.filter{
		height: 55px;
		vertical-align:center;
		align-content: center;
		text-align: center;
	}
</style>
<div class="p-5">
	<?php
		$company = base64_encode ( json_encode ( $company ) ) ?? '';
		$rfcActual = json_decode ( base64_decode ( $company ), TRUE )[ 'rfc' ];
		$id = json_decode ( base64_decode ( $company ), TRUE )[ 'id' ];
		$user = base64_encode ( json_encode ( $user ) ) ?? '';
	?>
	<h5>Conciliaciones masivas</h5>
	<!-- head con el calendario -->
	<div class="row card esquinasRedondas" style="padding-top: 10px;">
		<div class="row" style="display: flex;justify-content: center;">
			<div class="col l5 center" style="border: 1px rgba(0,0,0,0.1) solid; border-radius:25px; padding: 5px; margin-left: auto;margin-right: auto;">
				<div class="row center-align" style="padding: 0; margin: 0;">Alta de operación</div>
				<div class="row center-align" style="margin: 0;">
					<div class="col l6 center-align">
						<div class="col center-align"><p>Desde:</p></div>
						<div class="col center-align">
							<label for="start">
								<input type="date" id="start" name="trip-start" value="2023-10-01" min="2023-10-01"
								       max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
							</label>
						</div>
					</div>
					<div class="col l6 center-align">
						<div class="col center-align"><p>Hasta:</p></div>
						<div class="col center-align">
							<label for="fin">
								<input type="date" id="fin" name="trip-start"
								       value="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" min="2023-10-01"
								       max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col l5 center" style="border: 1px rgba(0,0,0,0.1) solid; border-radius:25px; padding: 5px; margin-left: auto;margin-right: auto;">
				<div class="row center-align" style="padding: 0; margin: 0;">Ultima modificación</div>
				<div class="row center-align" style="margin: 0;">
					<div class="col l6 center-align">
						<div class="col center-align"><p>Desde:</p></div>
						<div class="col center-align">
							<label for="startMod">
								<input type="date" id="startMod" name="startMod" value="2023-10-01" min="2023-10-01"
								       max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
							</label>
						</div>
					</div>
					<div class="col l6 center-align">
						<div class="col center-align"><p>Hasta:</p></div>
						<div class="col center-align">
							<label for="finMod">
								<input type="date" id="finMod" name="finMod"
								       value="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" min="2023-10-01"
								       max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="display: flex;justify-content: center;">
			<div class="col l3 filter" style="padding: 5px; margin-left: auto;margin-right: auto;">
				<div class="row" style="margin-bottom: 0;">
					<div class="col valign-wrapper"><p>Folio:</p></div>
					<div class="col">
						<label for="searchFolio">
							<input type="text" id="searchFolio" name="searchFolio" placeholder="3X3WAW1Y1J4792P"
							       oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').replace(/(\..*?)\..*/g, '$1').toUpperCase();" maxlength="50"/>
						</label>
					</div>
				</div>
			</div>
			<div class="col l3 filter" style="padding: 5px; margin-left: auto;margin-right: auto;">
				<div class="row" style="margin-bottom: 0;">
					<div class="col valign-wrapper"><p>Referencia númerica:</p></div>
					<div class="col" style="max-width: 100px">
						<label for="searchRNumerica">
							<input type="text" id="searchRNumerica" name="searchRNumerica" placeholder="6465825"
							       oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="7"/>
						</label>
					</div>
				</div>
			</div>
			<div class="col l2 filter" style="padding: 5px; margin-left: auto;margin-right: auto;">
				<a id="masiva" class="modal-trigger button-gray right" href="#modal-conciliacionPlus">Crear Conciliación Masiva</a>
			</div>
		</div>
		<input type="hidden" name="idInc" id="idInc" value="<?= $id ?>">
	</div>
	<!-- Tabla Container-->
	<div class="card esquinasRedondas" id="tblsViewer">
		<div class="card-content" style="padding: 10px; ">
			<!-- Table buttons -->
			<div id="Menus" class="row l12 p-3" style="margin-bottom: 5px">
			
			</div>
			<!-- Tabla -->
			<div style="overflow-x: auto; max-height: 500px" id="tablaActiva"></div>
		</div>
	</div>
	<!-- Modales -->
	<div id="modal-conciliacionPlus" class="modal" style=" height: 95%; width: 90% !important">
		<div class="modal-content">
			<h5>Carga de conciliaciones masivas</h5>
			<div class="card esquinasRedondas">
				<input type="hidden" name="rfcActual" id="rfcActual" value="<?= $rfcActual ?>">
				<div class="card-content" id="contentCPlus">
					<h6 class="p-3">Carga múltiples .xml en un archivo .zip</h6>
					<form id="uploadCFDIPlus" enctype="multipart/form-data">
						<div class="file-field input-field">
							<div class="file-path-wrapper" style="width: 75%;margin-left: auto;float: left;">
								<label>
									<input
										class="file-path validate" type="text"
										placeholder="Facturas en .zip" disabled>
								</label>
							</div>
							<div style="width: 25%;margin-left: auto;">
								<label
									for="containerCFDIPlus" class="custom-file-upload button-gray">Seleccionar</label>
								<input name="containerCFDIPlus" id="containerCFDIPlus" type="file" accept=".zip" required />
								<input type="hidden" name="sCompany" id="sCompany" value="<?= $company ?>">
								<input type="hidden" name="sUser" id="sUser" value="<?= $user ?>">
							</div>
						</div>
						<div class="row">
							<div class="col l12 center-align">
								<a href="<?= base_url ( 'ConciliacionMasiva' ) ?>" class="modal-close button-orange">Cancelar</a>
								<input class="button-gray" type="submit" value="Siguiente">
							</div>
						</div>
						<div class="row">
							<div class="col l12 d-flex">
								<div class="p-5">
									<div class="switch">
										<label>
											<input type="checkbox" required>
											<span class="lever"></span>
										</label>
									</div>
								</div>
								<p class="text-modal" style="text-align: justify;">
									En caso de utilizar la presente factura para conciliar con una nota de crédito, el
									Proveedor acepta y otorga su
									consentimiento en este momento para que, una vez recibido el pago por la misma,
									Solve descuente y transfiere
									de manera automática a nombre y cuenta del Proveedor, el monto debido por el
									Proveedor en relación con dicha
									factura en favor del Cliente. Los términos utilizados en mayúscula tendrán el
									significado que se le atribuye
									dicho término en los Términos y Condiciones. En caso de utilizar esta factura para
									conciliar con una factura
									de un Proveedor, al momento de dar clic en “Aceptar” el Cliente acuerda que la
									factura en cuestión será utilizada
									para efectos de las operaciones en la Plataforma conforme a los <a
										href="/terminosycondiciones">Términos y Condiciones</a>.
								</p><br>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-cfdi" class="modal" style=" height: 95%; width: 90% !important">
		<div class="modal-content">
			<h5>CFDI de la conciliación</h5>
			<div class="card esquinasRedondas">
				<table id="tabla_cfdi_cp" class="stripe row-border order-column nowrap"><thead><tr>
						<th >Emisor</th>
						<th >Receptor</th>
						<th class="center-align">CFDI</th>
						<th >Fecha de CFDI</th>
						<th >Fecha de recepción</th>
						<th >Total</th>
						<th >Tipo de documento</th>
					</tr></thead>
					<tbody id="tblBodyCfdi"></tbody></table>
			</div>
			<a  class="modal-close button-orange">Cerrar</a>
		</div>
	</div>
	<div id="modal-dPlusDetail" class="modal" style=" height: 95%; width: 90% !important">
		<div class="modal-content">
			<h5>Operaciones individuales</h5>
			<div class="card esquinasRedondas">
				<table id="tabla_Dplus_cp" class="stripe row-border order-column nowrap"><thead><tr>
						<th class='center-align'>Numero de referencia</th>
						<th class='center-align'>Monto</th>
						<th class='center-align'>Clabe bancarias</th>
						<th class='center-align'>Banco destino</th>
					</tr></thead>
					<tbody id="tblBodyDPDetails"></tbody></table>
			</div>
			<a  class="modal-close button-orange">Cerrar</a>
		</div>
	</div>
</div>
<script>
	let url = "https://api-solve.local";                     //Local
	// let url = "https://apisandbox.solve.com.mx/public";     //Sandbox
	// // let url = "https://apisandbox.solve.com.mx/public/";     //Live
	$(document).ready(function () {
		conciliationPlus();
		$(".dropdown-button").dropdown({hover: true, gutter: 0,});
		$("select").formSelect();
		$("#btndrop").dropdown({
			constrainWidth: true, // Does not change width of dropdown to that of the activator
			hover: true, // Activate on hover
			closeOnClick: false,
		});
		$("#start").on("change", function () {
			conciliationPlus();
		});
		$("#fin").on("change", function () {
			conciliationPlus();
		});
		$("#uploadCFDIPlus").on("submit", function (e) {
			e.preventDefault();
			const formData = new FormData($("#formulario")[0]);
			const files = $("#containerCFDIPlus")[0].files[0];
			const company = $("#sCompany").val();
			const user = $("#sUser").val();
			formData.append("file", files);
			formData.append("company", company);
			formData.append("user", user);
			$.ajax({
				url: url+"/uploadCFDIPlus",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function () {
					const obj = $("#contentCPlus");
					const left = obj.offset().left;
					const top = obj.offset().top;
					const width = obj.width();
					const height = obj.height();
					$("#solveLoader").delay(50000).css({
						display: "block",
						opacity: 1,
						visibility: "visible",
						left: left,
						top: top,
						width: width,
						height: height,
						zIndex: 999999
					}).focus();
				},
				success: function (response) {
					if (response.conciliaciones !== null) {
						chooseCPlus(response, user, company);
					}
					console.log("Respuesta del servidor:", response);
				},
				complete: function () {
					$("#solveLoader").css({
						display: "none"
					});
				},
				error: function (status) {
					// Maneja los errores de la solicitud
					console.error("Error en la solicitud:", status);
				}
			});
			
		});
		$("li.optgroup").on("click", function () {
			$("li.optgroup-option").trigger("click");
		});
	});
	function chooseCPlus(response, user, company){
		let rfcActual = $("#rfcActual").val();
		const contPlus = $("#contentCPlus");
		contPlus.empty();
		let chooseC = "<h6 class=\"p-3\">Seleccionar conciliaciones</h6>" +
			"<form id=\"chooseCPlus\"><div class=\"row\">" +
			"<select multiple id=\"conciliaItems\" name=\"conciliaItems\">" +
			"</select><label for=\"conciliaItems\">Conciliaciones</label></div>" +
			"<div class=\"row\"><div class=\"col l12 center-align\">" +
			'<a  href="<?=base_url ( 'ConciliacionMasiva' )?>" class="modal-close button-orange">Cancelar</a>' +
			"<input class=\"button-gray\" type=\"submit\" value=\"Siguiente\"></div></div></form>";
		contPlus.append(chooseC);
		let opt = $("<optgroup label=\"Seleccionar todas\" id=\"optGpo\"></optgroup>");
		$("#conciliaItems").append(opt);
		let conciliation = response.conciliaciones;
		let optionsC = "";
		$.each(conciliation, function (index, value) {
			if (value.sender === rfcActual) {
				if(value.out > value. in){
					optionsC += "<option value=\"" + value.receiver  + "|" + value.sender + "|" + value.tmp + "|" + value.in + "|" + value.out +"\"> <strong>" + value.receiver + "</strong> | ↑ Envias $" + value.out + " | ↓ Recibes $" + value.in + "</option>";
				}else{
					optionsC += "<option value=\"" + value.sender  + "|" + value.receiver + "|" + value.tmp + "|" + value.out + "|" + value.in +"\"> <strong>" + value.receiver + "</strong> | ↑ Recibes $" + value.out + " | ↓ Envias $" + value.in + "</option>";
				}
			} else {
				if(value.out > value. in){
					optionsC += "<option value=\"" + value.sender  + "|" + value.receiver + "|" + value.tmp + "|" + value.out + "|" + value.in +"\"> <strong>" + value.sender + "</strong> |  ↑ Envias $" + value.in + "| ↓ Recibes $" + value.out + " </option>";
				}else{
					optionsC += "<option value=\"" + value.receiver + "|" + value.sender + "|" + value.tmp + "|" + value.in + "|" + value.out + "\"> <strong>" + value.sender + "</strong> | ↓ Recibes $" + value.out + " | ↑ Envias $" + value.in + "</option>";
				}
			}
		});
		$("#optGpo").append(optionsC);
		$("select").formSelect();
		$("li.optgroup").on("click", function () {
			$("li.optgroup-option").trigger("click");
		});
		$("#chooseCPlus").on("submit", function (e) {
			e.preventDefault();
			const formData2 = new FormData($("#formulario2")[0]);
			const conciliationSelected = $("#conciliaItems").val();
			formData2.append("conciliaciones", conciliationSelected);
			formData2.append("company", company);
			formData2.append("user", user);
			$.ajax({
				url: url+"/chosenConciliation",
				type: "POST",
				data: formData2,
				processData: false,
				contentType: false,
				beforeSend: function () {
					const obj = $("#contentCPlus");
					const left = obj.offset().left;
					const top = obj.offset().top;
					const width = obj.width();
					const height = obj.height();
					$("#solveLoader").delay(50000).css({
						display: "block",
						opacity: 1,
						visibility: "visible",
						left: left,
						top: top,
						width: width,
						height: height,
						zIndex: 999999
					}).focus();
				},
				success: function (response) {
					if (response.error == null){
						chooseDPlus(response,user, company);
					}
				},
				complete: function () {
					$("#solveLoader").css({
						display: "none"
					});
				},
				error: function (status) {
					// Maneja los errores de la solicitud
					console.error("Error en la solicitud:", status);
				}
			});
		});
	}
	function chooseDPlus (response, user, company) {
		let content = $("#contentCPlus");
		let rfcActual = $('#rfcActual').val();
		content.empty();
		let base = "<h6 class='p-3'>¿Deseas crear una dispersion masiva?</h6>" +
			"<form id='chooseCPlus'><div class='row'>" +
			"<p><label><input name='makeDPlus' id='SiConciliation' value='1' type='radio' /> <span>Si</span></label></p>"+
			"<p><label><input name='makeDPlus' id='NoConciliation' value='2' type='radio' checked/> <span>No</span></label></p>"+
			"<div id='chooseD' class='row'></div>"+
			"<div id='buttonsSpace' class='row'><div class='col l12 center-align'>" +
			'<a href="<?=base_url ( 'Conciliaciones' )?>" class="modal-close button-orange">Terminar</a>'+
			"</div></div></form>";
		content.append(base);
		let chooseD = $('#chooseD');
		let buttonsSpace = $('#buttonsSpace');
		$('input[type=radio][name=makeDPlus]').change(function() {
			if (this.value === '1') {
				chooseD.empty();
				buttonsSpace.empty();
				let selector = "<select multiple id='dispersionItems' name='dispersionItems'></select><label for='dispersionItems'>Conciliaciones</label>";
				let opt = $("<optgroup label=\"Seleccionar todas\" id=\"optGpo2\"></optgroup>");
				chooseD.append(selector);
				$("#dispersionItems").append(opt);
				let options = '';
				$.each(response[0], function (index, value) {
					if (value[1] === rfcActual) {
						options += "<option value='" + value.idConciliation + "' >" + value[1] + " | " + value[0] + " | Depositan ↓ $" + value[3] + " | Regresas ↑ $" + value[4] + "</option> ";
					} else {
						options += "<option value='" + value.idConciliation + "' >" + value[1] + " | " + value[0] + " | Depositas ↑ $" + value[3] + " | Regresan ↓ $" + value[4] + "</option> ";
					}
				});
				$('#optGpo2').append(options);
				$("select").formSelect();
				$("li.optgroup").on("click", function () {
					$("li.optgroup-option").trigger("click");
				});
				let buttons = "<div class='col l12 center-align'>" +
					'<a href="<?=base_url ( 'Conciliaciones' )?>" class="modal-close button-orange">Terminar</a>' +
					"<input class='button-gray' type='submit' value='Siguiente'></div>";
				buttonsSpace.append(buttons);
				$('#chooseCPlus').on("submit", function (e) {
					e.preventDefault();
					const formData3 = new FormData();
					const conciliationSelected = $("#dispersionItems").val();
					formData3.append("conciliaciones", conciliationSelected);
					formData3.append("company", company);
					formData3.append("user", user);
					$.ajax({
						url: url+"/chosenForDispersion",
						type: "POST",
						data: formData3,
						processData: false,
						contentType: false,
						beforeSend: function () {
							const obj = $("#contentCPlus");
							const left = obj.offset().left;
							const top = obj.offset().top;
							const width = obj.width();
							const height = obj.height();
							$("#solveLoader").delay(50000).css({
								display: "block",
								opacity: 1,
								visibility: "visible",
								left: left,
								top: top,
								width: width,
								height: height,
								zIndex: 999999
							}).focus();
						},
						success: function (response) {
							if (response.error === null){
								toastHTML = "<span>Dispersion masiva creada correctamente</span>" +
									"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
									"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
								M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
								conciliationPlus();
								$('#modal-conciliacionPlus').modal('close');
								setTimeout(function() {
									location.reload();
								}, 2000);
							}
						},
						complete: function () {
							$("#solveLoader").css({
								display: "none"
							});
						},
						error: function (status) {
							// Maneja los errores de la solicitud
							console.error("Error en la solicitud:", status);
						}
					});
				});
			}else if (this.value === '2') {
				chooseD.empty();
				buttonsSpace.empty();
				let buttons = "<div class='col l12 center-align'>" +
					'<a href="<?=base_url( 'Conciliaciones' )?>" class="modal-close button-orange">Terminar</a></div>';
				buttonsSpace.append(buttons);
			}
		});
	}
	function conciliationPlus (){
		const tableA = $("#tablaActiva");
		tableA.empty();
		$("#btnConciliationPlus").addClass("selected");
		let btnAction = $("#btnAction").append("Subir CFDI");
		btnAction.attr("href", "#modal-CFDI");
		const tableBase = "<table id=\"tabla_conciliaciones\" class=\"stripe row-border order-column nowrap\"><thead><tr>" +
			"<th>Autorizar</th>" +
			"<th class=\"center-align\">Estatus<br />conciliación</th>" +
			"<th class='center-align'>Clabe Interbancaria Transferencia Inicial</th>" +
			"<th style=\"min-width: 142px; text-align: center\">Número de Referencia</th>" +
			"<th style=\"min-width: 142px; text-align: center\">Folio</th>" +
			"<th class=\"center-align\">Grupo de CFDI</th>" +
			"<th style=\"min-width: 128px; text-align: center\" class=\"center-align\">Monto a pagar</th>" +
			"<th style=\"min-width: 128px; text-align: center\" class=\"center-align\">Monto de regreso</th>" +
			"<th style=\"text-align: center\" class=\"center-align\">Emisor del pago</th>" +
			"<th style=\"text-align: center\" class=\"center-align\">Receptor del pago</th>" +
			"<th class=\"center-align\">Fecha<br />Conciliación</th>" +
			"</tr></thead>" +
			"<tbody id=\"tblBody\"></tbody></table>";
		tableA.append(tableBase);
		$.ajax({
			url: url+"/conciliationPlus",
			data:{
				from: $("#start").val(),
				to: $("#fin").val(),
				company: $("#idInc").val(),
				environment:"SANDBOX",
			},
			dataType: "JSON",
			method: "GET",
			beforeSend: function () {
				const obj = $("#tblsViewer");
				const left = obj.offset().left;
				const top = obj.offset().top;
				const width = obj.width();
				const height = obj.height();
				$("#solveLoader").delay(50000).css({
					display: "block",
					opacity: 1,
					visibility: "visible",
					left: left,
					top: top,
					width: width,
					height: height,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
					$("#tblBody").empty();
					let rfcActual = $('#rfcActual').val();
					$.each(data, function (index, value) {
						let uuid, status, uuid2, clabe;
						let aut, cancel, acept;
						let exitMoney, entryMoney;
						let flag = 'receptor';
						exitMoney = value.exit_money;
						entryMoney = value.entry_money;
						if (value.rfc === rfcActual) {
							flag = 'emisor';
							switch (value.status) {
								case "0":
									aut = $("<a class=\"modal-trigger\" href=\"#modal-aut-conciliation\">Autorizar</a>");
									cancel = $("<a class=\"modal-trigger button-orange modal-close\" href=\"#modal-rechazo\">Rechazar</a>");
									acept = $("<a style='cursor: pointer;' class=\"button-gray \">Aceptar</a>");
									cancel.click(function () {
										$("#rejectText").empty();
										$("#idReject").val(value.id);
									});
									acept.click(function () {
										aceptOp(value.id, $("#autPayDate").val());
									});
									aut.click(function () {
										let autEmisor = $("#autEmisor");
										let autCFDI = $("#autCFDI");
										let autConciliador = $("#autConciliador");
										let autReferencia = $("#autReferencia");
										let autMonto1 = $("#autMonto1");
										let autMonto2 = $("#autMonto2");
										let autClabe = $("#autClabe");
										let autPayDate = $("#autPayDate");
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
										autMonto1.append("$" + value.total1);
										autMonto2.append("$" + value.total2);
										autClabe.append(value.account_clabe);
										let dateS = (value.datePago);
										dateS = dateS.split("-");
										autPayDate.attr("value", dateS[2] + "-" + dateS[1] + "-" + dateS[0]);
										$("#autAceptar").empty();
										$("#autCancel").empty();
										$("#autAceptar").append(acept);
										$("#autCancel").append(cancel);
									});
									break;
								case "1":
								case "3":
									aut = "<i class=\"small material-icons\" style=\"color: green;\">check_circle</i>";
									break;
								case "2":
									aut = "<i class=\"small material-icons\" style=\"color: red;\">cancel</i>";
									break;
							}
							clabe = value.clabeTransferencia;
							exitMoney = value.entry_money;
							entryMoney = value.exit_money;
							312
						} else if (flag === "receptor" && (value.status === 3 || value.status ===4)) {
							switch (value.status) {
								case "0":
									aut = "<i class=\"small material-icons\">panorama_fish_eye</i>";
									break;
								case "3":
								case "1":
									aut = "<i class=\"small material-icons\" style=\"color: green;\">check_circle</i>";
									break;
								case "2":
									aut = "<i class=\"small material-icons\" style=\"color: red;\">cancel</i>";
									break;
							}
							clabe = "xxxxxxxxxxxxxx" + value.clabeTransferencia.substring(value.clabeTransferencia.length - 4);
						} else {
							switch (value.status) {
								case "0":
									aut = "<i class=\"small material-icons\">panorama_fish_eye</i>";
									break;
								case "3":
								case "1":
									aut = "<i class=\"small material-icons\" style=\"color: green;\">check_circle</i>";
									break;
								case "2":
									aut = "<i class=\"small material-icons\" style=\"color: red;\">cancel</i>";
									break;
							}
							clabe = "-";
						}
						switch (value.status) {
							case "0":
								status = "<p><span class=\"estatus\">Por autorizar</span></p>";
								break;
							case "1":
								status = "<p><span class=\"estatus\" style=\"background-color:#8225fc\">Autorizada</span></p>";
								break;
							case "2":
								status = "<p><span class=\"estatus\" style=\"background-color:#c20005\">Rechazada</span></p>";
								break;
							case "3":
								status = "<p><span class=\"estatus\" style=\"background-color:#52A447\">Realizada</span></p>";
								break;
							case "4":
								status = "<p><span class=\"estatus\" style=\"background-color:#dedc48\">Vencida</span></p>";
								break;
						}
						let cfdiM = $("<a style='cursor: pointer;'>Ver CFDI</a>");
						cfdiM.click(function () {
							$("#tblBodyCfdi").empty();
							let $dat = value.cfdi;
							fillCfdi($dat);
						});
						const tr = $("<tr " + flag + ">" +
							"<td class='tabla-celda center-align' id='aut" + value.id + "'></td>" +
							"<td class='tabla-celda center-align' style='text-wrap: nowrap;'>" + status + "</td>" +
							"<td class='center-align " + flag + "'>" + clabe + "</td>" +
							"<td class='center-align " + flag + "'>" + value.reference_number + "</td>" +
							"<td class='center-align'>" + value.folio + "</td>" +
							"<td class='center-align' id='cfdi" + value.id + "'></td>" +
							"<td class='center-align' >$ "+ exitMoney + "</td>" +
							"<td class='center-align' >$ "+ entryMoney + "</td>" +
							"<td class='center-align'> " + value.deudor + "</td>" +
							"<td class='center-align'>" + value.receptor + "</td>" +
							"<td class='center-align'  style='text-wrap: nowrap;' id=\"tblPayD" + value.id + "\" >" + value.payment_date + "</td>" +
							"</tr>");
						$("#tblBody").append(tr);
						$("#aut" + value.id).append(aut);
						$("#cfdi" + value.id).append(cfdiM);
					});
			},
			complete: function () {
				$("#solveLoader").css({
					display: "none"
				});
			},
			error: function (data) {
				$("#solveLoader").css({
					display: "none"
				});
				let dat = JSON.parse(data.responseText);
				if (dat.error == 404){
					let toastHTML = "<span><strong>"+dat.reason+"</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 10000, duration: 10000});
				}else if(dat.error == 500){
					let toastHTML = "<span><strong>"+dat.description+"</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 10000, duration: 10000});
					toastHTML = "<span>"+dat.reason+"</span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 10000, duration: 10000});
				}
			}
		});
	}
	function fillCfdi ($data){
		$.each($data, function(index, value){
			const tr = $("<tr>" +
				"<td class='center-align'>" + value.sender + "</td>" +
				"<td class='center-align'>" + value.receiber + "</td>" +
				"<td class='center-align'>"+value.uuid+"</td>" +
				"<td class='center-align' >"+ value.payment_date + "</td>" +
				"<td class='center-align' >"+ value.created_at + "</td>" +
				"<td class=''>$ " + value.total + "</td>" +
				"<td class='center-align'>" + value.tipo + "</td>" +
				"</tr>");
			$("#tblBodyCfdi").append(tr);
		});
		$("#modal-cfdi").modal("open");
	}
</script>
