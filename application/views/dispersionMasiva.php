<style>
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
	<h5>Dispersion masiva</h5>
	<!-- head con el calendario -->
	<div class="row card esquinasRedondas" style="padding: 10px;">
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
			<div class="col l3 filter" style="padding: 5px; margin-left: auto;margin-right: auto;">
				<a id="masiva" class="modal-trigger button-gray right" href="#modal-dispersion">Crear dispersion</a>
			</div>
		</div>
		<input type="hidden" name="idInc" id="idInc" value="<?= $id ?>">
	</div>
	<!-- Tabla Container -->
	<div class="card esquinasRedondas" id="tblsViewer">
		<div class="card-content" style="padding: 10px; ">
			<!-- Table buttons -->
			<div id="Menus" class="row l12 p-3" style="margin-bottom: 5px">
			</div>
			<!-- Tabla -->
			<div style="overflow-x: auto; max-height: 500px" id="tablaActiva"></div>
		</div>
	</div>
</div>
<!-- Modales -->
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
<script>
	// const url = "https://api-solve.local";                     //Local
	let url = "https://apisandbox.solve.com.mx/public";     //Sandbox
	// // let url = "https://apisandbox.solve.com.mx/public/";     //Live
	const tblActiva = $("#tablaActiva");
	$(document).ready(function () {
		DispersionPlus();
		$("#start").on("change", function () {
			DispersionPlus();
		});
		$("#fin").on("change", function () {
			DispersionPlus();
		});
		$("#searchFolio").on("keyup", function (){
			DispersionPlus();
		});
		$("#searchRNumerica").on("keyup", function (){
			DispersionPlus();
		});
	});
	function DispersionPlus() {
		tblActiva.empty();
		const tableBase = "<table id=\"tabla_conciliaciones\" class=\"stripe row-border order-column nowrap\"><thead><tr>" +
			"<th class=\"center-align\">Estatus</th>" +
			"<th class=\"center-align\">Detalles</th>" +
			"<th class=\"center-align\">Acciones</th>" +
			"<th class='center-align'>Referencia númerica</th>" +
			"<th class=\"center-align\">Folio de dispersión</th>" +
			"<th class=\"center-align\">Balance antes</th>" +
			"<th class=\"center-align\">Balance necesario</th>" +
			"<th class=\"center-align\">Balance despues</th>" +
			"<th class=\"center-align\">Clabe bancaria</th>" +
			"<th class=\"center-align\">Fecha de Alta<br />de operación</th>" +
			"<th class=\"center-align\">Fecha de ultima<br />modificación</th>" +
			"</tr></thead>" +
			"<tbody id=\"tblBody\"></tbody></table>";
		tblActiva.append(tableBase);
		$.ajax({
			url: url+"/dispersionPlus",
			data: {
				from: $("#start").val(),
				to: $("#fin").val(),
				folio: $("#searchFolio").val(),
				numeric : $("#searchRNumerica").val(),
				company: $("#idInc").val(),
				environment:"SANDBOX",
			},
			dataType: "json",
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
				if (data.code === 500) {
					let toastHTML = "<span><strong>" + data.message + " </strong> </span>&nbsp;<br><p><span><strong>" + data.reason +
						"</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				} else if (data.code === 404) {
					console.log("");
				} else {
					$("#tblBody").empty();
					$.each(data, function (index, value) {
						let status, aut;
						let after = '---';
						if(value.balance_after !== null){
							after = '$ '+value.balance_after;
						}
						let update = '---';
						if(value.updated_at !== null){
							update = value.updated_at;
						}
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
						switch (value.status) {
							case "1":
								status = "<p><span>Autorizada</span></p>";
								break;
							case "2":
								status = "<p><span>Rechazada</span></p>";
								break;
							case "3":
								status = "<p><span>Realizada</span></p>";
								break;
						}
						let details = $("<a style='cursor: pointer;'>Ver detalles</a>");
						details.click(function () {
							$("#tblBodyCfdi").empty();
							let $dat = value.details;
							fillDPlusDetails($dat);
						});
						let actions = $("<a style='cursor: pointer;'>Ejecutar</a>");
						actions.click(function () {
							playDispercion(value.id);
						});
						const tr = $("<tr>" +
							"<td class='tabla-celda center-align' id='aut" + value.id + "'>" + status + "</td>" +
							"<td class='center-align' id='dPlus" + value.id + "'></td>" +
							"<td class='center-align' id='ddPlus" + value.id + "'></td>" +
							"<td class='center-align'>" + value.reference_number + "</td>" +
							"<td class='center-align'>" + value.folio + "</td>" +
							"<td class='center-align'>$ " + value.balance_before + "</td>" +
							"<td class='center-align'>$ " + value.balance_needed + "</td>" +
							"<td class='center-align'>" + after + "</td>" +
							"<td class='center-align'>" + value.clabe + "</td>" +
							"<td class='center-align'>" + value.created_at + "</td>" +
							"<td class='center-align'>" + update + "</td>" +
							"</tr>");
						$("#tblBody").append(tr);
						$("#aut" + value.id).append(aut);
						$("#dPlus" + value.id).append(details);
						$("#ddPlus" + value.id).append(actions);
					});
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
				let dat = JSON.parse(data.responseText);
				if (dat.error == 404){
					let toastHTML = "<span><strong>"+dat.reason+"</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 1000, duration: 1000});
				}else if(dat.error == 500){
					let toastHTML = "<span><strong>"+dat.description+"</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 1000, duration: 1000});
					toastHTML = "<span>"+dat.reason+"</span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 1000, duration: 1000});
				}
			}
		});
	}
	function fillDPlusDetails ($data){
		$("#tblBodyDPDetails").empty();
		$.each($data, function(index, value){
			const tr = $("<tr>" +
				"<td class='center-align'>" + value.reference_number + "</td>" +
				"<td class='center-align'> $ " + value.amount + "</td>" +
				"<td class='center-align'>"+value.account_clabe+"</td>" +
				"<td class='center-align' >"+ value.bnk_alias + "</td>" +
				"</tr>");
			$("#tblBodyDPDetails").append(tr);
		});
		$("#modal-dPlusDetail").modal("open");
	}
	function playDispercion(id){
		$.ajax({
			url: url+"/playDispercion",
			data: {
				id: id,
				environment:"SANDBOX",
			},
			dataType: "json",
			method: "POST",
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
					let toastHTML = "<span><strong>" + data.message + " </strong> </span>&nbsp;<br><p><span><strong>" + data.reason +
						"</strong></span>" +
						"<button onclick='M.Toast.dismissAll()' class='btn-flat toast-action'>" +
						"<span class='material-icons' style='display: block; color: white;'>cancel</span></button>";
					M.toast({html: toastHTML, displayLength: 20000, duration: 20000});
				} else if (data.code === 404) {
					console.log("");
				} else {
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
				let toastHTML = "<span><strong>Ha ocurrido un problema, por favor intente mas tarde</strong></span>" +
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
</script>
