<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<div class="p-5">
	<div class="row">
		<div class="col l6 m6">
			<div class="section">
				<h5>Subscripción</h5>
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
							id="changeCard" class="waves-effect blue waves-light btn-large l12"
							style="width: 100%"><?= $btnVal ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col l6 m6" style="text-align: center;">
			<div class="col l6">
				<div>
					<div class="section" style="border: 1px solid #e8e6e3; padding: 10px">
						<h6>Paquete 1</h6>
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<img
									src="<?= base_url ( 'assets/images/logo_purple_s.png' ); ?>" alt="Logo"
									class="image-side hide-on-med-and-down">
							</div>
							<div class="col">
								<h6>$150.00 MXN</h6>
								<p>200 operaciones</p>
							</div>
						</div>
						<div>
							<a class="waves-effect waves-light btn-large" id="buyOp1">
								<i class="material-icons right">shopping_cart</i>Comprar
							</a>
						</div>
					</div>
					<!--<div class="section" style="border: 1px solid #e8e6e3; padding: 10px">
						<h6>Paquete 1</h6>
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<img
									src="<?php /*= base_url ( 'assets/images/logo_purple_s.png' ); */ ?>" alt="Logo"
									class="image-side hide-on-med-and-down">
							</div>
							<div class="col">
								<h6>$150.00 MXN</h6>
								<p>200 operaciones</p>
							</div>
						</div>
						<div>
							<a class="waves-effect waves-light btn-large" id="buyOp1">
								<i class="material-icons right">shopping_cart</i>Comprar
							</a>
						</div>
					</div>
					<div class="section" style="border: 1px solid #e8e6e3; padding: 10px">
						<h6>Paquete 1</h6>
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<img
									src="<?php /*= base_url ( 'assets/images/logo_purple_s.png' ); */ ?>" alt="Logo"
									class="image-side hide-on-med-and-down">
							</div>
							<div class="col">
								<h6>$150.00 MXN</h6>
								<p>200 operaciones</p>
							</div>
						</div>
						<div>
							<a class="waves-effect waves-light btn-large" id="buyOp1">
								<i class="material-icons right">shopping_cart</i>Comprar
							</a>
						</div>
					</div>-->
				</div>
			</div>
			<!--<div class="col l6">
				<div>
					<div class="section" style="border: 1px solid #e8e6e3; padding: 10px">
						<h6>Paquete 1</h6>
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<img
									src="<?php /*= base_url ( 'assets/images/logo_purple_s.png' ); */ ?>" alt="Logo"
									class="image-side hide-on-med-and-down">
							</div>
							<div class="col">
								<h6>$150.00 MXN</h6>
								<p>200 operaciones</p>
							</div>
						</div>
						<div>
							<a class="waves-effect waves-light btn-large" id="buyOp1">
								<i class="material-icons right">shopping_cart</i>Comprar
							</a>
						</div>
					</div>
					<div class="section" style="border: 1px solid #e8e6e3; padding: 10px">
						<h6>Paquete 1</h6>
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<img
									src="<?php /*= base_url ( 'assets/images/logo_purple_s.png' ); */ ?>" alt="Logo"
									class="image-side hide-on-med-and-down">
							</div>
							<div class="col">
								<h6>$150.00 MXN</h6>
								<p>200 operaciones</p>
							</div>
						</div>
						<div>
							<a class="waves-effect waves-light btn-large" id="buyOp1">
								<i class="material-icons right">shopping_cart</i>Comprar
							</a>
						</div>
					</div>
					<div class="section" style="border: 1px solid #e8e6e3; padding: 10px">
						<h6>Paquete 1</h6>
						<div class="divider"></div>
						<div class="row">
							<div class="col">
								<img
									src="<?php /*= base_url ( 'assets/images/logo_purple_s.png' ); */ ?>" alt="Logo"
									class="image-side hide-on-med-and-down">
							</div>
							<div class="col">
								<h6>$150.00 MXN</h6>
								<p>200 operaciones</p>
							</div>
						</div>
						<div>
							<a class="waves-effect waves-light btn-large" id="buyOp1">
								<i class="material-icons right">shopping_cart</i>Comprar
							</a>
						</div>
					</div>
				</div>
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
					<button class="btn waves-effect waves-light blue right" id="sendCard" name="sendCard">
						Enviar<i class="material-icons right">send</i>
					</button>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-orange btn-flat">Cerrar</a>
		</div>
	</div>
	<div id="buyModal" class="modal modal-fixed-footer" style="max-height 90% !important;">
		<div class="modal-content">
			<h5 id="folio_modal" style="margin-top: 1px; margin-bottom: 1px">Comprar Operaciones</h5>
			<p>Completa los datos requeridos para poder generar el pago correspondientes a la compra de operaciones</p>
			<p>Se le realizará un cargo único por $150.00 MXN</p>
			<form method="POST" id="payment-form2" style="margin-top: 1px; margin-bottom: 1px;">
				<input type="hidden" name="token_id2" id="token_id2">
				<input type="hidden" name="deviceID2" id="deviceID2" value="" />
				<input type="hidden" name="cardType2" id="cardType2" value="" />
				<input type="hidden" name="cardFlag2" id="cardFlag2" value="<?= $flag = empty( $card ) ? 1 : 2; ?>" />
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<div class="col l12">
						<label>
							<span>Nombre del titular</span>
							<input
								id="nameHolder2" name="nameHolder2" class="validate" type="text"
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
								id="cardNumber2" name="cardNumber2" maxlength="16" class="validate" type="text"
								data-openpay-card="card_number" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</label>
					</div>
					<div class="col l3" id="cardTypeImg2"></div>
				</div>
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<div class="col l6"><label>Fecha de expiración</label></div>
					<div class="col l6"><label>Código de seguridad</label></div>
				</div>
				<div class="row" style="margin-bottom: 15px; margin-top: 1px">
					<div class="col l6">
						<div class="col s4"><input
								id="expMonth2" name="expMonth2" maxlength="2" class="validate" type="text"
								placeholder="Mes" data-openpay-card="expiration_month" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</div>
						<div class="col s1"></div>
						<div class="col s4"><input
								id="expYear2" name="expYear2" maxlength="2" class="validate" type="text"
								placeholder="Año"
								data-openpay-card="expiration_year" required
								oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
						</div>
					</div>
					<div class="col l6">
						<div class="col s4"><input
								id="cvv2" name="cvv2" type="text" maxlength="3" class="validate" placeholder="3 dígitos"
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
					<button class="btn waves-effect waves-light blue right" id="sendCard2" name="sendCard2">
						Enviar<i class="material-icons right">send</i>
					</button>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="/Tienda" class="modal-close waves-effect orange btn-flat">Cancelar</a>
		</div>
	</div>
	<div id="3dModal" class="modal modal-fixed-footer" role="dialog" style="max-height 90% !important;">
		<div class="modal-content" id="3dContent">
		
		</div>
		<div class="modal-footer">
			<a href="/Tienda" class="modal-close waves-effect orange btn-flat">Cerrar</a>
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
		// $("#3dModal").modal("open");
		const sandbox = true;
		let deviceDataId;
		let deviceDataId2;
		
		// OpenPay.setId('mtcyupm65psrjreromun');
		// OpenPay.setApiKey('pk_88137bbfe9d94c208d6741754c9e24d4');
		
		$("#cardNumber").on("change", function () {
			const cardIMG = $("#cardTypeImg");
			const cardNumber = $("#cardNumber").val();
			const cardType = OpenPay.card.cardType(cardNumber);
			verifyForm();
			const img = "<img src=\"/assets/images/cardtype/" + cardType + ".svg\" alt=\"" + cardType + "\" height=\"70px\">";
			cardIMG.empty();
			cardIMG.append(img);
		});
		$("#cardNumber2").on("change", function () {
			const cardIMG = $("#cardTypeImg2");
			const cardNumber = $("#cardNumber2").val();
			const cardType = OpenPay.card.cardType(cardNumber);
			verifyForm2();
			const img = "<img src=\"/assets/images/cardtype/" + cardType + ".svg\" alt=\"" + cardType + "\" height=\"70px\">";
			cardIMG.empty();
			cardIMG.append(img);
		});
		$("#nameHolder").on("input", function () {
			verifyForm();
		});
		$("#nameHolder2").on("input", function () {
			verifyForm2();
		});
		$("#cvv").on("input", function () {
			verifyForm();
		});
		$("#cvv2").on("input", function () {
			verifyForm2();
		});
		$("#sendCard").on("click", function (event) {
			OpenPay.setSandboxMode(true);
			OpenPay.setId("mhcmkrgyxbjfw9vb9cqc");
			OpenPay.setApiKey("pk_e09cd1f4b4c542e6adbf1f132d8d9ebb");
			deviceDataId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
			$("#deviceID").val(deviceDataId);
			const flag = $("#cardFlag").val();
			if (flag === 1 || flag === "1") {
				OpenPay.token.extractFormAndCreate("payment-form", newCard, error_callbak);
			} else {
				OpenPay.token.extractFormAndCreate("payment-form", shiftCard, error_callbak);
			}
		});
		$("#sendCard2").on("click", function (event) {
			OpenPay.token.extractFormAndCreate("payment-form2", buyOp, error_callbak);
			
		});
		$("#changeCard").on("click", function () {
			$("#addCardM").modal("open");
		});
		$("#buyOp1").on("click", function () {
			$("#buyModal").modal("open");
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
	
	function verifyForm2() {
		var card = $("#cardNumber2").val();
		var name = $("#nameHolder2").val();
		var cvv = $("#cvv2").val();
		if (card !== "" && name !== "" && cvv !== "") {
			$("#sendCard2").prop("disabled", false);
		} else {
			$("#sendCard2").prop("disabled", true);
		}
	}
	
	function buyOp(response) {
		OpenPay.setSandboxMode(true);
		OpenPay.setId("mhcmkrgyxbjfw9vb9cqc");
		OpenPay.setApiKey("pk_e09cd1f4b4c542e6adbf1f132d8d9ebb");
		deviceDataId2 = OpenPay.deviceData.setup("payment-form2", "deviceIdHiddenFieldName");
		
		let cardNumber = $("#cardNumber2").val();
		let cardType = OpenPay.card.cardType(cardNumber);
		// let device = $("#deviceID2").val();
		let cvv = $("#cvv2").val();
		let month = $("#expMonth2").val();
		let year = $("#expYear2").val();
		let name = $("#nameHolder2").val();
		let tokenCard = response.data.id;
		$("#token_id2").val(tokenCard);
		$.ajax({
			url: "Tienda/BuyOperations",
			data: {
				cardNumber: cardNumber,
				holderName: name,
				expirationMonth: month,
				expirationYear: year,
				cvv: cvv,
				sessionID: deviceDataId2,
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
				if (data.code === 500) {
					$("#addCardM").modal("close");
					toastHTML = "<span><strong>" + data.error + "</strong></span>";
					M.toast({html: toastHTML});
					toastHTML = "<span><strong>" + data.message + "</strong></span>";
					M.toast({html: toastHTML});
				} else {
					$("#addCardM").modal("close");
					const frame = '<iframe id="3dFrame" title="3D Secure Validation" width="100%" height="100%" src="'+data.payment_method.url+'"></iframe>';
					$('#3dContent').append(frame);
					$('#3dModal').modal('open');
				}
			},
			complete: function () {
				$("#solveLoader").css({
					display: "none"
				});
			}
		});
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
