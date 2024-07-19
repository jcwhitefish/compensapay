<?php
	$factura = base_url ( 'assets/factura/factura.php?idfactura=' );
	$company = base64_encode ( json_encode ( $company ) ) ?? '';
	$rfcActual = json_decode ( base64_decode ( $company ), TRUE )[ 'rfc' ];
	$id = json_decode ( base64_decode ( $company ), TRUE )[ 'id' ];
	$user = base64_encode ( json_encode ( $user ) ) ?? '';
?>
<script>
	let btnActive = 0;
	$(document).ready(function () {
		$("#download").on("click", function () {
			const resume_table = document.getElementById("tabla_d_cfdis");
			const menu = document.getElementsByClassName("selected")[0].id;
			
			const inputCheck = resume_table.querySelectorAll("input[id=\"checkTbl\"]");
			const inputChecked = resume_table.querySelectorAll("input[id=\"checkTbl\"]:checked");
			if (inputChecked.length === 0) {
				return false;
			}
			let numCheck = 0;
			let content = "";
			const doc = [];
			
			for (let i = 1, row; row = resume_table.rows[i]; i++) {
				if (inputCheck[numCheck].checked) {
					for (let j = 1, col; col = row.cells[j]; j++, content += "|") {
						content += col.innerText;
					}
					doc.push(content);
					content = "";
				}
				numCheck++;
			}
			$.ajax({
				url: "/Facturas/crearExcel",
				data: {
					info: doc,
					menu: menu
				},
				dataType: "json",
				method: "post",
				success: function (data) {
					let opResult = data;
					let $a = $("<a>");
					$a.attr("href", opResult.data);
					$("body").append($a);
					$a.attr("download", menu + ".xlsx");
					$a[0].click();
					$a.remove();
				},
				error: function (data) {
					alert("Ha ocurrido un problema");
					console.log(data);
					//location.reload();
				}
			});
			
		});
		$("#downloadGral").on("click", function () {
			let tables = ['tabla_d_cfdis', 'tabla_d_comprobantes', 'tabla_d_movimientos', 'tabla_d_estados'];
			const resume_table = document.getElementById(tables[btnActive]);
			const menu = document.getElementsByClassName("selected")[0].id;
			
			const inputCheck = resume_table.querySelectorAll("input[id=\"checkTbl\"]");
			const inputChecked = resume_table.querySelectorAll("input[id=\"checkTbl\"]:checked");
			if (inputChecked.length === 0) {
				return false;
			}
			let numCheck = 0;
			let content = "";
			const doc = [];
			
			for (let i = 1, row; row = resume_table.rows[i]; i++) {
				if (inputCheck[numCheck].checked) {
					for (let j = 1, col; col = row.cells[j]; j++, content += "|") {
						content += col.innerText;
					}
					doc.push(content);
					content = "";
				}
				numCheck++;
			}
			$.ajax({
				url: "/Facturas/crearExcel",
				data: {
					info: doc,
					menu: menu
				},
				dataType: "json",
				method: "post",
				success: function (data) {
					let opResult = data;
					let $a = $("<a>");
					$a.attr("href", opResult.data);
					$("body").append($a);
					$a.attr("download", menu + ".xlsx");
					$a[0].click();
					$a.remove();
				},
				error: function (data) {
					alert("Ha ocurrido un problema");
					console.log(data);
					//location.reload();
				}
			});
			
		});
	});
	
	function hideForms() {
	}
</script>
<div class="p-5">
	<h5>Documentos</h5>
	<!-- head con el calendario -->
	<div class="row card esquinasRedondas" style="padding-top: 10px;" id="filterSpace">
		<div id="filterCfdi">
			<div class="row" style="display: flex;justify-content: center;">
				<div
						class="col l5 center"
						style="border: 1px rgba(0,0,0,0.1) solid; border-radius:25px; padding: 5px; margin-left: auto;margin-right: auto;">
					<div class="row center-align" style="padding: 0; margin: 0;">Alta de operación</div>
					<div class="row center-align" style="margin: 0;">
						<div class="col l6 center-align">
							<div class="col center-align"><p>Desde:</p></div>
							<div class="col center-align">
								<label for="start">
									<input
											type="date" id="start" name="trip-start" value="2023-10-01" min="2023-10-01"
											max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
								</label>
							</div>
						</div>
						<div class="col l6 center-align">
							<div class="col center-align"><p>Hasta:</p></div>
							<div class="col center-align">
								<label for="fin">
									<input
											type="date" id="fin" name="trip-start"
											value="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" min="2023-10-01"
											max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
								</label>
							</div>
						</div>
					</div>
				</div>
				<div
						class="col l5 center"
						style="border: 1px rgba(0,0,0,0.1) solid; border-radius:25px; padding: 5px; margin-left: auto;margin-right: auto;">
					<div class="row center-align" style="padding: 0; margin: 0;">Ultima modificación</div>
					<div class="row center-align" style="margin: 0;">
						<div class="col l6 center-align">
							<div class="col center-align"><p>Desde:</p></div>
							<div class="col center-align">
								<label for="startMod">
									<input
											type="date" id="startMod" name="startMod" value="2023-10-01"
											min="2023-10-01"
											max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
								</label>
							</div>
						</div>
						<div class="col l6 center-align">
							<div class="col center-align"><p>Hasta:</p></div>
							<div class="col center-align">
								<label for="finMod">
									<input
											type="date" id="finMod" name="finMod"
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
					<div class="row center-align valign-wrapper" style="margin-bottom: 0; justify-content: center">
						<div class="col valign-wrapper"><p>UUID:</p></div>
						<div class="col">
							<label for="searchFolio">
								<input
										type="text" id="searchUuid" name="searchUuid"
										placeholder="E4890A0F-8375-4D2F-A289-ED9C467433AC"
										oninput="this.value = this.value.replace(/[^a-zA-Z0-9-]/g, '').replace(/(\..*?)\..*/g, '$1').toUpperCase();"
										maxlength="50" />
							</label>
						</div>
					</div>
				</div>
				<div
						class="col l3 filter"
						style="padding: 5px; margin-left: auto;margin-right: auto; justify-content: center; display: flex">
					<div class="row" style="margin-bottom: 0;">
						<div class="col valign-wrapper"><p>Buscar:</p></div>
						<div class="col">
							<label for="searchRNumerica">
								<input
										type="text" id="searchRNumerica" name="searchRNumerica" placeholder="6465825"
										oninput="this.value = this.value.replace(/[^a-zA-Z0-9-]/g, '').replace(/(\..*?)\..*/g, '$1').toUpperCase();"
										maxlength="30" />
							</label>
						</div>
					</div>
				</div>
				<div
						class="col l3 filter"
						style="padding: 5px; margin-left: auto;margin-right: auto; justify-content: center; display: flex">
					<div class="row" style="margin-bottom: 0;">
						<div class="col valign-wrapper"><p>Mostrar CFDI conciliacion:</p></div>
						<div class="col">
							<form action="#">
								<p>
									<label>
										<input
												type="checkbox" id="showSencilla" class="filled-in" checked="checked"
												style="display: none;" />
										<span>Sencilla</span>
									</label>
								</p>
								<p>
									<label>
										<input type="checkbox" id="showPlus" class="filled-in" style="display: none;" />
										<span>Masiva</span>
									</label>
								</p>
							</form>
						</div>
					</div>
				</div>
				<div
						class="col l3 filter"
						style="padding: 5px; margin-left: auto;margin-right: auto; display: flex; justify-content: center; height: 39px">
					<a id="download" class="modal-trigger button-gray" style="padding-bottom: 2px; padding-top: 2px;height: 39px;width: 115px;padding-left: 20px;padding-right: 20px;
							align-content: center; text-align: center" download>Exportar</a>
				</div>
			</div>
		</div>
		<div id="filterGral">
			<div class="row card esquinasRedondas" style="margin: 10px 10px 0 0; padding-top: 10px;">
				<div class="col l3">
					<div class="row" style="margin-bottom: 0;">
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
					<div class="row" style="margin-bottom: 0;">
						<div class="col valign-wrapper"><p>Hasta:</p></div>
						<div class="col">
							<label for="fin">
								<input
										type="date" id="fin" name="trip-start"
										value="
	<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" min="2023-10-01"
										max="<?= date ( 'Y-m-d', strtotime ( 'now' ) ) ?>" />
							</label>
						</div>
					</div>
				</div>
				<div class="col l2"></div>
				<div class="col l2"></div>
				<div class="col l2 valign-wrapper" style="display: block; text-align: center; padding-top: 10px;">
					<a id="downloadGral" class="modal-trigger button-gray" download>Exportar</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Las tablas principales que se muestran -->
	<div class="card esquinasRedondas" id="tblsViewer" style="margin-right: 15px">
		<input type="hidden" name="idInc" id="idInc" value="<?= $id ?>">
		<div class="card-content" style="padding: 10px; margin-right: ">
			<div class="row" style="margin-bottom: 1px">
				<div id="Menus" class="row l12 p-3" style="margin-bottom: 5px">
					<div class="col l2">
						<button id="cfdi" class="button-table" onclick="cfdi();">CFDIs</button>
					</div>
					<div class="col l2">
						<button id="comprobantes" class="button-table" onclick="comprobantesP();">
							Comprobantes de pago
						</button>
					</div>
					<div class="col l2">
						<button id="movimientos" class="button-table" onclick="movimientos();">
							Movimientos
						</button>
					</div>
					<div class="col l2">
						<button id="estados" class="button-table" onclick="estados();">
							Estados de cuenta
						</button>
					</div>
				</div>
			</div>
			<div style="overflow-x: auto;" id="tablaActivaD">
				<!--<table
					id="activeTbl" class="stripe row-border order-column nowrap">
					<tbody>
					<tr>
						<td class="center-align"></td>
					</tr>
					</tbody>
				</table>-->
			</div>
		</div>
	</div>
</div>
<script>
	
	$(document).ready(function () {
		cfdi();
		$("#start").on("change", function () {
			switch (btnActive) {
				case 0:
					cfdi();
					break;
				case 1:
					comprobantesP();
					break;
				case 2:
					movimientos();
					break;
				case 3:
					estados();
					break;
				default:
				// code block
			}
			
		});
		$("#fin").on("change", function () {
			switch (btnActive) {
				case 0:
					cfdi();
					break;
				case 1:
					comprobantesP();
					break;
				case 2:
					movimientos();
					break;
				case 3:
					estados();
					break;
				default:
				// code block
			}
		});
		$("#showSencilla").change(function () {
			cfdi();
		});
		$("#showPlus").change(function () {
			cfdi();
		});
		$("#searchUuid").on("keyup", function () {
			cfdi();
		});
		$("#searchRNumerica").on("keyup", function () {
			cfdi();
		});
	});
	
	function noSelect() {
		$("#cfdi").removeClass("selected");
		$("#comprobantes").removeClass("selected");
		$("#movimientos").removeClass("selected");
		$("#estados").removeClass("selected");
		$("#tablaActivaD").empty();
		$("#filterCfdi").css("display", "none");
		$("#filterGral").css("display", "none");
	}
	
	function cfdi() {
		noSelect();
		$("#filterCfdi").css("display", "block");
		$("#tablaActivaD").empty();
		btnActive = 0;
		$("#cfdi").addClass("selected");
		const tableBase = "<table id=\"tabla_d_cfdis\" class=\"stripe row-border order-column nowrap\">" +
			"<thead><tr>" +
			"<th>Seleccionar</th>" +
			"<th>Emisor</th>" +
			"<th>Receptor</th>" +
			"<th>CFDI</th>" +
			"<th>Fecha CFDI</th>" +
			"<th>Fecha Alta</th>" +
			"<th style=\"min-width: 135px\">Fecha limite de pago</th>" +
			"<th style=\"min-width: 110px\">Total</th>" +
			"<th>Tipo</th>" +
			"</tr></thead>" +
			"<tbody id=\"tblBody\"></tbody>" +
			"</table>";
		$("#tablaActivaD").append(tableBase);
		let sSencillo = 0;
		let sPlus = 0;
		if ($("#showSencilla").is(":checked")) {
			sSencillo = 1;
		}
		if ($("#showPlus").is(":checked")) {
			sPlus = 1;
		}
		$.ajax({
			url: url + "/getInvoiceDocuments",
			data: {
				from: $("#start").val(),
				to: $("#fin").val(),
				from2: $("#startMod").val(),
				to2: $("#finMod").val(),
				sencilla: sSencillo,
				plus: sPlus,
				uuid: $("#searchUuid").val(),
				args: $("#searchRNumerica").val(),
				company: $("#idInc").val(),
				environment: env,
			},
			dataType: "json",
			method: "get",
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
				if (data.code === 500) {
					let toastHTML = "<span><strong>" + data.message + "</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
					toastHTML = "<span><strong>" + data.reason + "</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				} else if (data.code === 404) {
				} else {
					$("#tblBody").empty();
					$.each(data, function (index, value) {
						let uuid = "<a href=\"" + value.idurl + "\" target=\"_blank\">" + value.uuid + "</a>";
						let datePay = "";
						if (value.dateToPay === null) {
							datePay = "-----";
						} else {
							datePay = value.dateToPay;
						}
						const tr = $("<tr>" +
							"<td>" +
							"<div class=\"switch\">" +
							"<label>" +
							"<input type=\"checkbox\" id=\"checkTbl\">" +
							"<span class=\"lever\"></span>" +
							"</label>" +
							"</div>" +
							"</td>" +
							"<td>" + value.emisor + "</td>" +
							"<td>" + value.receptor + "</td>" +
							"<td>" + uuid + "</td>" +
							"<td>" + value.dateCFDI + "</td>" +
							"<td>" + value.dateCreate + "</td>" +
							"<td>" + datePay + "</td>" +
							"<td>$ " + value.total + "</td>" +
							"<td>" + value.tipo + "</td>" +
							"</tr>");
						$("#tblBody").append(tr);
					});
					//$('#tabla_d_cfdis').DataTable({
					//	deferRender:    true,
					//	language: {
					//		decimal: '.',
					//		thousands: ',',
					//		url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
					//	},
					//	paging: false,
					//	info: false,
					//	searching: false,
					//	sort: true
					//});
				}
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
				let toastHTML = "<span><strong>Ha ocurrido un problema por favor intente mas tarde</strong></span>" +
					"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
					"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
				M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				toastHTML = "<span>Si el problema persiste levante ticket en el apartado de soporte</span>" +
					"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
					"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
				M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
			}
		});
	}
	
	function comprobantesP() {
		$("#tablaActivaD").empty();
		btnActive = 1;
		noSelect();
		$("#filterGral").css("display", "block");
		$("#comprobantes").addClass("selected");
		const tableBase = "<table id=\"tabla_d_comprobantes\" class=\"stripe row-border order-column nowrap\">" +
			"<thead style=\"position:sticky; top: 0;\"><tr>" +
			"<th>Seleccionar</th>" +
			"<th>Descargar CEP</th>" +
			"<th>Institución emisora</th>" +
			"<th>Institución receptora</th>" +
			"<th>Cuenta beneficiaria</th>" +
			"<th>Clave de rastreo</th>" +
			"<th>Id de Operación</th>" +
			"<th>Fecha de pago</th>" +
			"<th>Monto del pago</th>" +
			"</tr></thead>" +
			"<tbody id=\"tblBody\"></tbody>" +
			"</table>";
		$("#tablaActivaD").append(tableBase);
		$.ajax({
			url: "/Documentos/DocsCEP",
			data: {
				from: $("#start").val(),
				to: $("#fin").val(),
			},
			dataType: "json",
			method: "post",
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
				if (data.code === 500) {
					let toastHTML = "<span><strong>" + data.message + "</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
					toastHTML = "<span><strong>" + data.reason + "</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				} else if (data.code === 404) {
				} else {
					$("#tblBody").empty();
					$.each(data, function (index, value) {
						let cepUrl;
						if (value.url_cep === null) {
							cepUrl = "En proceso...";
						} else {
							cepUrl = "<a href=\"" + value.cepUrl + "\" target=\"_blank\">Descargar CEP</a>";
						}
						
						const tr = $("<tr>" +
							"<td>" +
							"<div class=\"switch\">" +
							"<label>" +
							"<input type=\"checkbox\" id=\"checkTbl\">" +
							"<span class=\"lever\"></span>" +
							"</label>" +
							"</div>" +
							"</td>" +
							"<td>" + cepUrl + "</td>" +
							"<td>" + value.bank_source + "</td>" +
							"<td>" + value.bank_receiver + "</td>" +
							"<td>" + value.receiver_clabe + "</td>" +
							"<td>" + value.traking_key + "</td>" +
							"<td>" + value.operationNumber + "</td>" +
							"<td>" + value.transaction_dateb + "</td>" +
							"<td>" + value.ammountf + "</td>" +
							"</tr>");
						$("#tblBody").append(tr);
					});
					//$('#tabla_d_comprobantes').DataTable({
					//	deferRender:    true,
					//	language: {
					//		decimal: '.',
					//		thousands: ',',
					//		url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
					//	},
					//	paging: false,
					//	info: false,
					//	searching: false,
					//	sort: true
					//});
				}
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
				let toastHTML = "<span><strong>Ha ocurrido un problema por favor intente mas tarde</strong></span>" +
					"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
					"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
				M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				toastHTML = "<span>Si el problema persiste levante ticket en el apartado de soporte</span>" +
					"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
					"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
				M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
			}
		});
	}
	
	function movimientos() {
		$("#tablaActivaD").empty();
		noSelect();
		$("#filterGral").css("display", "block");
		btnActive = 2;
		
		$("#movimientos").addClass("selected");
		const tableBase = "<table id=\"tabla_d_movimientos\" class=\"stripe row-border order-column nowrap\">" +
			"<thead style=\"position:sticky; top: 0;\"><tr>" +
			"<th>Seleccionar</th>" +
			"<th>Monto</th>" +
			"<th>Clave de rastreo</th>" +
			"<th>Comprobante electrónico (CEP)</th>" +
			"<th>Descripción</th>" +
			"<th>Banco origen</th>" +
			"<th>Banco destino</th>" +
			"<th>Razón social origen</th>" +
			"<th>RFC Origen</th>" +
			"<th>Razón social destino</th>" +
			"<th>RFC Destino</th>" +
			"<th>CLABE origen</th>" +
			"<th>CLABE destino</th>" +
			"<th>CFDI correspondiente</th>" +
			"<th>Fecha de Transacción</th>" +
			"</tr></thead>" +
			"<tbody id=\"tblBody\"></tbody>" +
			"</table>";
		$("#tablaActivaD").append(tableBase);
		$.ajax({
			url: "/Documentos/DocsMovimientos",
			data: {
				from: $("#start").val(),
				to: $("#fin").val(),
			},
			dataType: "json",
			method: "post",
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
				if (data.code === 500) {
					let toastHTML = "<span><strong>" + data.message + "</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
					toastHTML = "<span><strong>" + data.reason + "</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				} else if (data.code === 404) {
				} else {
					$("#tblBody").empty();
					$.each(data, function (index, value) {
						let uuid;
						let urlCep;
						urlCep = (value.cepUrl === null || value.cepUrl === "") ? "En proceso..." : "<a href=\"" + value.cepUrl + "\" target=\"_blank\">Descargar CEP</a>";
						
						uuid = (value.uuid === "No Aplica") ? value.uuid : "<a href=\"" + value.idurl + "\" target=\"_blank\">" + value.uuid + "</a>";
						
						const tr = $("<tr>" +
							"<td>" +
							"<div class=\"switch\">" +
							"<label>" +
							"<input type=\"checkbox\" id=\"checkTbl\">" +
							"<span class=\"lever\"></span>" +
							"</label>" +
							"</div>" +
							"</td>" +
							"<td>$ " + value.amount + "</td>" +
							"<td>" + value.traking_key + "</td>" +
							"<td style='text-wrap: nowrap;'>" + urlCep + "</td>" +
							"<td style='text-wrap: nowrap;'>" + value.descriptor + "</td>" +
							"<td style='text-wrap: nowrap;'>" + value.bank_source + "</td>" +
							"<td style='text-wrap: nowrap;'>" + value.bank_receiver + "</td>" +
							"<td style='text-wrap: nowrap;'>" + value.provider + "</td>" +
							"<td>" + value.providerRFC + "</td>" +
							"<td style='text-wrap: nowrap;'>" + value.client + "</td>" +
							"<td>" + value.clientRFC + "</td>" +
							"<td>" + value.source_clabe + "</td>" +
							"<td>" + value.receiver_clabe + "</td>" +
							"<td style='white-space: nowrap; max-width: 100px; overflow: hidden; word-wrap: break-word;text-overflow: ellipsis;'>" + uuid + "</td>" +
							"<td style='text-wrap: nowrap;'>" + value.created_at + "</td>" +
							"</tr>");
						$("#tblBody").append(tr);
					});
					//$('#tabla_d_movimientos').DataTable({
					//	deferRender:    true,
					//	language: {
					//		decimal: '.',
					//		thousands: ',',
					//		url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
					//	},
					//	paging: false,
					//	info: false,
					//	searching: false,
					//	sort: true
					//});
				}
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
				let toastHTML = "<span><strong>Ha ocurrido un problema por favor intente mas tarde</strong></span>" +
					"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
					"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
				M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				toastHTML = "<span>Si el problema persiste levante ticket en el apartado de soporte</span>" +
					"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
					"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
				M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
			}
		});
	}
	
	function estados() {
		$("#tablaActivaD").empty();
		noSelect();
		$("#filterGral").css("display", "block");
		$("#estados").addClass("selected");
		const tableBase = "<table id=\"tabla_d_estados\" class=\"stripe row-border order-column nowrap\">" +
			"<thead style=\"position:sticky; top: 0;\"><tr>" +
			"<th>Seleccionar</th>" +
			"<th>Mes</th>" +
			"<th>Días del periodo</th>" +
			"<th>Depósitos</th>" +
			"<th>Retiros</th>" +
			"<th>Saldo inicial</th>" +
			"<th>Saldo Final</th>" +
			"<th>Movimientos</th>" +
			"</tr></thead>" +
			"<tbody id=\"tblBody\"></tbody>";
		$("#tablaActivaD").append(tableBase);
		//$('#tabla_d_estados').DataTable({
		//	deferRender:    true,
		//	language: {
		//		decimal: '.',
		//		thousands: ',',
		//		url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
		//	},
		//	paging: false,
		//	info: false,
		//	searching: false,
		//	sort: false
		//});
	}
</script>
<style>

    /* Fix show checkbox and radiobuttons*/

    [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
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

    /* Buttons */

    .button-table {
        background-color: white;
        border: 2px solid white;
        height: 50px;
        width: 180px
    }

    .button-table:focus {
        background-color: black !important;
        color: white;
        height: 50px;
        border: 2px solid black !important;
        border-radius: 10px;
    }
</style>
