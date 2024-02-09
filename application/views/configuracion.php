<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<div class="p-5">

	<?php $notifications = $notifications[ 0 ] ?? ''; ?>
	<h5>Configuración avanzada <?= $this->session->userdata ( 'datosEmpresa' )[ 'short_name' ] ?></h5>
	<div class="row card esquinasRedondas" style="padding: 20px">
		<div class="col l6 m6">
			<!--<div class="section"><h5>Mis Contactos</h5></div>
			<div class="divider"></div>
			<div class="section">
				<label>
					<input type="checkbox" id="OnlyInvitedClients" name="OnlyInvitedClients" class="filled-in" />
					<span>Solo pueden ser mis clientes a través de invitación</span>
				</label>
			</div>
			<div class="section"><h5>Mis Proveedores</h5></div>
			<div class="divider"></div>
			<div class="section">
				<label>
					<input type="checkbox" id="OnlyInvitedProv" name="OnlyInvitedProv" class="filled-in" />
					<span>Solo pueden ser mis proveedores a través de invitación</span>
				</label>
				<label>
					<input type="checkbox" id="OnlyInvitedProv" name="OnlyInvitedProv" class="filled-in" />
					<span>Los proveedores pueden crear operaciones<i class="material-icons right">help</i></span>
				</label>
			</div>
			<div class="divider"></div>
			<div class="section"><h5>Usuarios</h5></div>
			<div class="divider"></div>
			<div class="section">
				<p><a>Invitar usuario por correo electrónico</a></p>
				<label>
					<input type="checkbox" id="metricas" name="metricas" class="filled-in" />
					<span>Todos los usuarios pueden ver métricas de la empresa</span>
				</label>
				<label>
					<input type="checkbox" id="operaciones" name="operaciones" class="filled-in" />
					<span>Todos los usuarios pueden crear operaciones</span>
				</label>
			</div>-->
			<div class="section">
				<h5>Subscripción</h5>
				<h6>Método de pago</h6>
				<div class="divider"></div>
				<div class="row align-content-lg-center" style="margin-top: 15px; margin-bottom: 1px">
					<div class="col l2 white" id="cardInfoImg">
						<?php
							if ( !empty( $card ) ) {
								echo '<img src="/assets/images/cardtype/' . $card[ 'type' ] . '.svg" alt="' . $card[ 'type' ] . '" width="100px" >';
							}
						?>
					</div>
					<div class="col l5" id="cardInfoText">
						<?php
							if ( !empty( $card ) ) {
								echo '<p id="cardInfo"><strong>' . $card[ 'type' ] . ':</strong> ****' . $card[ 'endCard' ] . '</p>
<p id="cardExp">Vence en ' . $card[ 'month' ] . ' del 20' . $card[ 'year' ] . '</p>';
							} else {
								echo '<p id="cardInfo"><strong>Por favor registra una nueva tarjeta</strong></p>';
							}
						?>
					
					</div>
					<div class="col l4">
						<?php $btnVal = empty( $card ) ? 'Agregar' : 'Cambiar'; ?>
						<a
							id="changeCard" class="waves-effect button-gray waves-light btn-large l12"
							style="width: 100%; padding: 0;"><?= $btnVal ?></a>
					</div>
				</div>
				<h6 style="margin-top: 1px">Historial de facturación</h6>
				<div class="divider"></div>
			</div>
		</div>
		<div class="col l6 m6">
			<!--<div class="section"><h5>Notificaciones relacionadas con mis clientes</h5></div>
			<div class="divider"></div>
			<div class="section">
				<h6>Operaciones</h6>
				<p><label>
						<input
							type="checkbox" id="nt_OperationNew"
							name="nt_OperationNew" <?= $notifications[ 'nt_OperationNew' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Nueva operación</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_OperationApproved"
							name="nt_OperationApproved" <?= $notifications[ 'nt_OperationApproved' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Cliente autoriza operación</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_OperationStatus"
							name="nt_OperationStatus" <?= $notifications[ 'nt_OperationStatus' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Cambio estatus de operación</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_OperationPaid"
							name="nt_OperationPaid" <?= $notifications[ 'nt_OperationPaid' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Pago de operación</span>
					</label></p>
				<p></p><label>
					<input
						type="checkbox" id="nt_OperationReturn"
						name=nt_OperationReturn" <?= $notifications[ 'nt_OperationReturn' ] === '1' ? 'checked' : '' ?>
						name="" class="filled-in" />
					<span>Devolución del pago</span>
				</label>
				<p
				<p><label>
						<input
							type="checkbox" id="nt_OperationReject"
							name="nt_OperationReject" <?= $notifications[ 'nt_OperationReject' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Rechazo a operación</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_OperationDate"
							name="nt_OperationDate" <?= $notifications[ 'nt_OperationDate' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Autorización de operación y cambio de fecha</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_OperationInvoiceRequest"
							name="nt_OperationInvoiceRequest" <?= $notifications[ 'nt_OperationInvoiceRequest' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Solicitud de factura</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_OperationExternalAccount"
							name="nt_OperationExternalAccount" <?= $notifications[ 'nt_OperationExternalAccount' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Pago a cuenta externa</span>
					</label></p>
			</div>
			<section>
				<h6>Solicitudes o invitaciones</h6>
				<p><label>
						<input
							type="checkbox" id="nt_InviteNew"
							name="nt_InviteNew" <?= $notifications[ 'nt_InviteNew' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Invitación de un cliente a ser proveedor</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_InviteStatus"
							name="nt_InviteStatus" <?= $notifications[ 'nt_InviteStatus' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Aprobación de solicitud</span>
					</label></p>
			</section>
			<section><h5>Generales</h5></section>
			<div class="divider"></div>
			<div class="section">
				<h6>Documentos</h6>
				<p><label>
						<input
							type="checkbox" id="nt_DocumentStatementReady"
							name="nt_DocumentStatementReady" <?= $notifications[ 'nt_DocumentStatementReady' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Estado de cuennta</span>
					</label></p>
				<h6>Soporte</h6>
				<p><label>
						<input
							type="checkbox" id="nt_SupportTicketStatus"
							name="nt_SupportTicketStatus" <?= $notifications[ 'nt_SupportTicketStatus' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Tickets y cambio de status</span>
					</label></p>
				<p><label>
						<input
							type="checkbox" id="nt_SupportReply"
							name="nt_SupportReply" <?= $notifications[ 'nt_SupportReply' ] === '1' ? 'checked' : '' ?>
							class="filled-in" />
						<span>Mensaje de respuesta</span>
					</label></p>
			</div>
			<div class="section">
				<a id="saveChanges" class="waves-effect blue waves-light btn-large l12" style="width: 100%">Guardar</a>
			</div>-->
		</div>
	</div>
	<div id="addCardM" class="modal modal-fixed-footer" style="max-height 90% !important;">
		<div class="modal-content">
			<h5 id="folio_modal" style="margin-top: 1px; margin-bottom: 1px">Método de pago</h5>
			<p>Completa los datos requeridos para poder generar los pagos correspondientes al uso de la plataforma</p>
			<p>Se le realizara un cargo mensual por $600.00 USD</p>
			<form method="POST" id="payment-form" style="margin-top: 1px; margin-bottom: 1px;">
				<input type="hidden" name="token_id" id="token_id">
				<input type="hidden" name="deviceID" id="deviceID" value="" />
				<input type="hidden" name="cardType" id="cardType" value="" />
				<input type="hidden" name="cardFlag" id="cardFlag" value="<?= $flag = empty( $card ) ? 1 : 2; ?>" />
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<div class="col l12">
						<label>
							<span>Nombre del titular</span>
							<input
								id="nameHolder" name="nameHolder" class="validate" type="text"
								placeholder="Como aparece en la tarjeta" data-openpay-card="holder_name" required
								oninput="this.value = this.value.replace(/[^a-z. A-Z]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</label>
					</div>
				</div>
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<div class="col l9">
						<label>
							<span>Número de tarjeta</span>
							<input
								id="cardNumber" name="cardNumber" maxlength="16" class="validate" type="text"
								data-openpay-card="card_number" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</label>
					</div>
					<div class="col l3" id="cardTypeImg"></div>
				</div>
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<div class="col l6"><label>Fecha de expiración</label></div>
					<div class="col l6"><label>Código de seguridad</label></div>
				</div>
				<div class="row" style="margin-bottom: 15px; margin-top: 1px">
					<div class="col l6">
						<div class="col s4"><input
								id="expMonth" name="expMonth" maxlength="2" class="validate" type="text"
								placeholder="Mes" data-openpay-card="expiration_month" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</div>
						<div class="col s1"></div>
						<div class="col s4"><input
								id="expYear" name="expYear" maxlength="2" class="validate" type="text" placeholder="Año"
								data-openpay-card="expiration_year" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</div>
					</div>
					<div class="col l6">
						<div class="col s4"><input
								id="cvv" name="cvv" type="text" maxlength="3" class="validate" placeholder="3 dígitos"
								autocomplete="off" data-openpay-card="cvv2" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</div>
					</div>
				</div>
			</form>
			<div class="row" style="margin-bottom: 1px;margin-top: 4px;">
				<div class="col l3">
					<img src="/assets/images/openpay.png" alt="taretas" height="30px">
				</div>
				<div class="col l6">
					<img src="/assets/images/tarjets-de-credito.png" alt="taretas" height="30px">
				</div>
				<div class="col l3">
					<button class="button-gray waves-effect waves-light right" id="sendCard" name="sendCard">
						Guardar
					</button>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
		</div>
	</div>

</div>
<style>
	.open {
		max-height: 90%;
		height: 85% !important;
	}
	
	div.section {
		padding-bottom: 1px;
		padding-top: 8px;
	}
	
	p {
		margin-top: 4px;
		margin-bottom: 4px;
	}
</style>
<script>
	const sucess_callbak = function (response) {
		const token_id = response.data.id;
		console.log(token_id);
		$("#token_id").val(token_id);
	};
	const error_callbak = function (response) {
		const desc = response.data.description !== undefined ? response.data.description : response.message;
		alert("ERROR [" + response.status + "] " + desc);
	};
	$(document).ready(function () {
		const sandbox = true;
		let deviceDataId;
		OpenPay.setSandboxMode(true);
		OpenPay.setId("mhcmkrgyxbjfw9vb9cqc");
		OpenPay.setApiKey("pk_e09cd1f4b4c542e6adbf1f132d8d9ebb");
		// OpenPay.setId('mtcyupm65psrjreromun');
		// OpenPay.setApiKey('pk_88137bbfe9d94c208d6741754c9e24d4');
		deviceDataId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
		$("#deviceID").val(deviceDataId);
		$("#cardNumber").on("change", function () {
			const cardIMG = $("#cardTypeImg");
			const cardNumber = $("#cardNumber").val();
			const cardType = OpenPay.card.cardType(cardNumber);
			verifyForm();
			const img = "<img src=\"/assets/images/cardtype/" + cardType + ".svg\" alt=\"" + cardType + "\" height=\"70px\">";
			cardIMG.empty();
			cardIMG.append(img);
		});
		$("#nameHolder").on("input", function () {
			verifyForm();
		});
		$("#cvv").on("input", function () {
			verifyForm();
		});
		$("#sendCard").on("click", function (event) {
			const flag = $("#cardFlag").val();
			if (flag === 1 || flag === "1") {
				OpenPay.token.extractFormAndCreate("payment-form", newCard, error_callbak);
			} else {
				OpenPay.token.extractFormAndCreate("payment-form", shiftCard, error_callbak);
			}
		});
		
		$("#changeCard").on("click", function () {
			$("#addCardM").modal("open");
		});
		$("#nt_SupportReply").on("change", function () {
			console.log($("#nt_SupportReply").prop("checked"));
		});
		$("#saveChanges").on("click", function () {
			$.ajax({
				url: "Configuracion/saveChanges",
				data: {
					nt_OperationNew: $("#nt_OperationNew").prop("checked") ? 1 : 0,
					nt_OperationApproved: $("#nt_OperationApproved").prop("checked") ? 1 : 0,
					nt_OperationStatus: $("#nt_OperationStatus").prop("checked") ? 1 : 0,
					nt_OperationPaid: $("#nt_OperationPaid").prop("checked") ? 1 : 0,
					nt_OperationReturn: $("#nt_OperationReturn").prop("checked") ? 1 : 0,
					nt_OperationReject: $("#nt_OperationReject").prop("checked") ? 1 : 0,
					nt_OperationDate: $("#nt_OperationDate").prop("checked") ? 1 : 0,
					nt_OperationInvoiceRequest: $("#nt_OperationInvoiceRequest").prop("checked") ? 1 : 0,
					nt_OperationExternalAccount: $("#nt_OperationExternalAccount").prop("checked") ? 1 : 0,
					nt_InviteNew: $("#nt_InviteNew").prop("checked") ? 1 : 0,
					nt_InviteStatus: $("#nt_InviteStatus").prop("checked") ? 1 : 0,
					nt_DocumentStatementReady: $("#nt_DocumentStatementReady").prop("checked") ? 1 : 0,
					nt_SupportTicketStatus: $("#nt_SupportTicketStatus").prop("checked") ? 1 : 0,
					nt_SupportReply: $("#nt_SupportReply").prop("checked") ? 1 : 0,
				},
				dataType: "json",
				method: "post",
				beforeSend: function () {
				},
				success: function (data) {
					if (data.code === 502) {
						$("#addCardM").modal("close");
						alert("Error");
						console.log(data);
					} else if (data.type != null) {
						$("#cardInfoImg").empty();
						$("#cardInfoText").empty();
						const img = "<img src=\"/assets/images/cardtype/" + data.type + ".svg\" alt=\"" + data.type + "\" width=\"100px\">";
						const info = "<p id=\"cardInfo\"><strong>" + data.type + ":</strong> ****" + data.endCard + "</p> <p id=\"cardExp\">Vence en " + data.month + " del 20" + data.year + "</p>";
						$("#cardInfoImg").append(img);
						$("#cardInfoText").append(info);
						$("#changeCard").empty();
						$("#changeCard").append("Cambiar");
						$("#addCardM").modal("close");
						var toastHTML = "<span><strong>¡Tarjeta agregada exitosamente!</strong></span>";
						M.toast({html: toastHTML});
					} else {
						$("#addCardM").modal("close");
						if (data.error_code === 3002) {
							var toastHTML = "<span><strong>Error</strong></span>";
							M.toast({html: toastHTML});
							var toastHTML = "<span><strong>Tarjeta expirada</strong></span>";
							M.toast({html: toastHTML});
						}
					}
				},
				complete: function () {
				}
			});
		});
	});
	
	function verifyForm() {
		var card = $("#cardNumber").val();
		var name = $("#nameHolder").val();
		var cvv = $("#cvv").val();
		if (card !== "" && name !== "" && cvv !== "") {
			$("#sendCard").prop("disabled", false);
		} else {
			$("#sendCard").prop("disabled", true);
		}
	}
	
	function newCard(response) {
		let cardNumber = $("#cardNumber").val();
		let cardType = OpenPay.card.cardType(cardNumber);
		let device = $("#deviceID").val();
		let cvv = $("#cvv").val();
		let month = $("#expMonth").val();
		let year = $("#expYear").val();
		let name = $("#nameHolder").val();
		let tokenCard = response.data.id;
		$("#token_id").val(tokenCard);
		$.ajax({
			url: "Configuracion/newSubscription",
			data: {
				cardNumber: cardNumber,
				holderName: name,
				expirationMonth: month,
				expirationYear: year,
				cvv: cvv,
				sessionID: device,
				cardType: cardType,
				tokenCard: tokenCard
			},
			dataType: "json",
			method: "post",
			beforeSend: function () {
				const left = $("#addCardM").offset().left;
				const top = $("#addCardM").offset().top;
				const width = $("#addCardM").width();
				$("#solveLoader").css({
					display: "block",
					left: left,
					top: top + 59,
					width: width,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				let toastHTML;
				if (data.code === 502) {
					$("#addCardM").modal("close");
					toastHTML = "<span><strong>" + data.error + "</strong></span>";
					M.toast({html: toastHTML});
					toastHTML = "<span><strong>" + data.message + "</strong></span>";
					M.toast({html: toastHTML});
				} else if (data.type != null) {
					$("#cardInfoImg").empty();
					$("#cardInfoText").empty();
					const img = "<img src=\"/assets/images/cardtype/" + data.type + ".svg\" alt=\"" + data.type + "\" width=\"100px\">";
					const info = "<p id=\"cardInfo\"><strong>" + data.type + ":</strong> ****" + data.endCard + "</p> <p id=\"cardExp\">Vence en " + data.month + " del 20" + data.year + "</p>";
					$("#cardInfoImg").append(img);
					$("#cardInfoText").append(info);
					$("#changeCard").empty();
					$("#changeCard").append("Cambiar");
					$("#addCardM").modal("close");
					toastHTML = "<span><strong>¡Tarjeta agregada exitosamente!</strong></span>";
					$("#cardFlag").val("2");
					M.toast({html: toastHTML});
				} else {
					$("#addCardM").modal("close");
					if (data.error_code === 3002) {
						toastHTML = "<span><strong>Error</strong></span>";
						M.toast({html: toastHTML});
						toastHTML = "<span><strong>Tarjeta expirada</strong></span>";
						M.toast({html: toastHTML});
					}
				}
				
			},
			complete: function () {
				$("#solveLoader").css({
					display: "none"
				});
			}
		});
	}
	
	function shiftCard(response) {
		var cardNumber = $("#cardNumber").val();
		var cardType = OpenPay.card.cardType(cardNumber);
		var device = $("#deviceID").val();
		var cvv = $("#cvv").val();
		var month = $("#expMonth").val();
		var year = $("#expYear").val();
		var name = $("#nameHolder").val();
		var newSubscription = "";
		let tokenCard = response.data.id;
		$.ajax({
			url: "Configuracion/changeCard",
			data: {
				cardNumber: cardNumber,
				holderName: name,
				expirationMonth: month,
				expirationYear: year,
				cvv: cvv,
				sessionID: device,
				cardType: cardType,
				tokenCard: tokenCard
			},
			dataType: "json",
			method: "post",
			beforeSend: function () {
				const left = $("#addCardM").offset().left;
				const top = $("#addCardM").offset().top;
				const width = $("#addCardM").width();
				$("#solveLoader").css({
					display: "block",
					left: left,
					top: top + 59,
					width: width,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				if (data.code === 502) {
					$("#addCardM").modal("close");
					alert("Error");
					console.log(data);
				} else if (data.type != null) {
					$("#cardInfoImg").empty();
					$("#cardInfoText").empty();
					const img = "<img src=\"/assets/images/cardtype/" + data.type + ".svg\" alt=\"" + data.type + "\" width=\"100px\">";
					const info = "<p id=\"cardInfo\"><strong>" + data.type + ":</strong> ****" + data.endCard + "</p> <p id=\"cardExp\">Vence en " + data.month + " del 20" + data.year + "</p>";
					$("#cardInfoImg").append(img);
					$("#cardInfoText").append(info);
					$("#changeCard").empty();
					$("#changeCard").append("Cambiar");
					$("#addCardM").modal("close");
					var toastHTML = "<span><strong>¡Tarjeta agregada exitosamente!</strong></span>";
					M.toast({html: toastHTML});
				} else {
					$("#addCardM").modal("close");
					if (data.error_code === 3002) {
						var toastHTML = "<span><strong>Error</strong></span>";
						M.toast({html: toastHTML});
						var toastHTML = "<span><strong>Tarjeta expirada</strong></span>";
						M.toast({html: toastHTML});
					}
				}
			},
			complete: function () {
				$("#solveLoader").css({
					display: "none"
				});
			}
		});
	}
</script>
