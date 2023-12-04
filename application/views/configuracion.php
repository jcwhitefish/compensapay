<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
<div class="p-5">
	<div>
		<div class="yellow center">
			<div class="col 12"><span></span> Invita a tus clientes y/o proveedores. <a href="">aquí</a></div>
		</div>
	</div>
	<?php $notifications = $notifications[0] ?? '';?>

	<div class="row">
		<div class="col l12">
			<div><h5 style="font-weight: bold">Configuración para <?=$this->session->userdata('datosEmpresa')['short_name']?></h5></div>
		</div>
		<div class="col l6 m6">
			<div class="section"><h5>Mis Contactos</h5></div>
			<div class="divider"></div>
			<div class="section">
				<label>
					<input type="checkbox" id="OnlyInvitedClients" name="OnlyInvitedClients" class="filled-in"/>
					<span>Solo pueden ser mis clientes a través de invitación</span>
				</label>
			</div>
			<div class="section"><h5>Mis Proveedores</h5></div>
			<div class="divider"></div>
			<div class="section">
				<label>
					<input type="checkbox" id="OnlyInvitedProv" name="OnlyInvitedProv" class="filled-in"/>
					<span>Solo pueden ser mis proveedores a través de invitación</span>
				</label>
				<label>
					<input type="checkbox" id="OnlyInvitedProv" name="OnlyInvitedProv" class="filled-in"/>
					<span>Los proveedores pueden crear operaciones<i class="material-icons right">help</i></span>
				</label>
			</div>
			<div class="divider"></div>
			<div class="section"><h5>Usuarios</h5></div>
			<div class="divider"></div>
			<div class="section">
				<p><a>Invitar usuario por correo electrónico</a></p>
				<label>
					<input type="checkbox" id="metricas" name="metricas" class="filled-in"/>
					<span>Todos los usuarios pueden ver métricas de la empresa</span>
				</label>
				<label>
					<input type="checkbox" id="operaciones" name="operaciones" class="filled-in"/>
					<span>Todos los usuarios pueden crear operaciones</span>
				</label>
			</div>
			<div class="section">
				<h5>Subscripción</h5>
				<h6>Método de pago</h6>
				<div class="divider"></div>
				<div class="row align-content-lg-center" style="margin-top: 15px; margin-bottom: 1px">
					<div class="col l2 white" id="cardInfoImg">
						<?php
						if (!empty($card)){
							echo '<img src="/assets/images/cardtype/'.$card['type'].'.svg" alt="'.$card['type'].'" width="100px" >';
						}
						?>
					</div>
					<div class="col l5" id="cardInfoText">
						<?php
						if (!empty($card) ){
							echo '<p id="cardInfo"><strong>'.$card['type'].':</strong> ****'.$card['endCard'].'</p>
<p id="cardExp">Vence en '.$card['month'].' del 20'.$card['year'].'</p>';
						}else{
							echo '<p id="cardInfo"><strong>Por favor registra una nueva tarjeta</strong></p>';
						}
						?>

					</div>
					<div class="col l4">
						<?php $btnVal= empty($card)?'Agregar':'Cambiar';?>
						<a id="changeCard" class="waves-effect blue waves-light btn-large l12" style="width: 100%"><?=$btnVal?></a>
					</div>
				</div>
				<h6 style="margin-top: 1px">Historial de facturación</h6>
				<div class="divider"></div>
			</div>
		</div>
		<div class="col l6 m6">
			<div class="section"><h5>Notificaciones relacionadas con mis clientes</h5></div>
			<div class="divider"></div>
			<div class="section">
				<h6>Operaciones</h6>
				<p><label>
						<input type="checkbox" id="nt_OperationNew" name="nt_OperationNew" <?=$notifications['nt_OperationNew'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Nueva operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" id="nt_OperationApproved" name="nt_OperationApproved" <?=$notifications['nt_OperationApproved'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Cliente autoriza operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" id = "nt_OperationStatus" name="nt_OperationStatus" <?=$notifications['nt_OperationStatus'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Cambio estatus de operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" id = "nt_OperationPaid" name="nt_OperationPaid"  <?=$notifications['nt_OperationPaid'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Pago de operación</span>
					</label></p>
				<p></p><label>
					<input type="checkbox" id = "nt_OperationReturn" name=nt_OperationReturn" <?=$notifications['nt_OperationReturn'] === '1' ? 'checked' : ''?> name="" class="filled-in"/>
					<span>Devolución del pago</span>
				</label><p
				<p><label>
						<input type="checkbox" id = "nt_OperationReject" name="nt_OperationReject"  <?=$notifications['nt_OperationReject'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Rechazo a operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" id = "nt_OperationDate" name="nt_OperationDate" <?=$notifications['nt_OperationDate'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Autorización de operación y cambio de fecha</span>
					</label></p>
				<p><label>
						<input type="checkbox" id = "nt_OperationInvoiceRequest" name="nt_OperationInvoiceRequest" <?=$notifications['nt_OperationInvoiceRequest'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Solicitud de factura</span>
					</label></p>
				<p><label>
						<input type="checkbox"id = "nt_OperationExternalAccount" name="nt_OperationExternalAccount" <?=$notifications['nt_OperationExternalAccount'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Pago a cuenta externa</span>
					</label></p>
			</div>
			<section>
				<h6>Solicitudes o invitaciones</h6>
				<p><label>
						<input type="checkbox" id = "nt_InviteNew" name="nt_InviteNew" <?=$notifications['nt_InviteNew'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Invitación de un cliente a ser proveedor</span>
					</label></p>
				<p><label>
						<input type="checkbox" id = "nt_InviteStatus" name="nt_InviteStatus" <?=$notifications['nt_InviteStatus'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Aprobación de solicitud</span>
					</label></p>
			</section>
			<section><h5>Generales</h5></section>
			<div class="divider"></div>
			<div class="section">
				<h6>Documentos</h6>
				<p><label>
						<input type="checkbox" id = "nt_DocumentStatementReady" name="nt_DocumentStatementReady" <?=$notifications['nt_DocumentStatementReady'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Estado de cuennta</span>
					</label></p>
				<h6>Soporte</h6>
				<p><label>
						<input type="checkbox" id = "nt_SupportTicketStatus" name="nt_SupportTicketStatus" <?=$notifications['nt_SupportTicketStatus'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Tickets y cambio de status</span>
					</label></p>
				<p><label>
						<input type="checkbox" id = "nt_SupportReply" name="nt_SupportReply" <?=$notifications['nt_SupportReply'] === '1' ? 'checked' : ''?> class="filled-in"/>
						<span>Mensaje de respuesta</span>
					</label></p>
			</div>
			<div class="section">
				<a id="saveChanges" class="waves-effect blue waves-light btn-large l12" style="width: 100%">Guardar</a>
			</div>
		</div>
	</div>
	<div id="addCardM" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h5 id="folio_modal" style="margin-top: 1px; margin-bottom: 1px">Método de pago</h5>
			<p>Completa los datos requeridos para poder generar los pagos correspondientes al uso de la plataforma</p>
			<form method="POST" id="payment-form" style="margin-top: 1px; margin-bottom: 1px">
				<input type="hidden" name="token_id" id="token_id">
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<label>
						<span>Nombre del titular</span>
						<input class="validate" type="text" placeholder="Como aparece en la tarjeta"  data-openpay-card="holder_name">
					</label>
				</div>
				<div class="row" style="margin-bottom: 1px; margin-top: 1px">
					<label>
						<span>Número de tarjeta</span>
						<input class="validate" type="text"  data-openpay-card="card_number">
					</label>
				</div>
			<div class="row" style="margin-bottom: 1px; margin-top: 1px">
				<div class="col l6"><label>Fecha de expiración</label></div>
				<div class="col l6"><label>Código de seguridad</label></div>
			</div>
			<div class="row" style="margin-bottom: 1px; margin-top: 1px">
				<div class="col l6">
					<div class="col s4"><input type="text" placeholder="Mes" data-openpay-card="expiration_month"></div>
					<div class="col s1"></div>
					<div class="col s4"><input type="text" placeholder="Año" data-openpay-card="expiration_year"></div>
				</div>
				<div class="col l6">
					<div class="col s4"><input type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2"></div>
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
					<button class="btn waves-effect waves-light grey right" id="sendCard" name="sendCard" >
						Enviar<i class="material-icons right">send</i>
					</button>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
		</div>
	</div>
	<div id="solveLoader" ></div>
</div>
<style>
	div.section{
		padding-bottom: 1px;
		padding-top: 8px;
	}
	p{
		margin-top: 4px;
		margin-bottom: 4px;
	}
	#solveLoader{
		display: none;
		position: absolute;
		/*float: left;*/
		background-color: rgba(255, 255, 255, .8);
		background-image: url('/assets/images/loader.gif') !important;
		background-repeat: no-repeat;
		background-position: center center;
		background-size: 150px 150px;
		top: 0;
		width: 90%;
		height: 100vh;
		z-index: 10;
	}
</style>
<script>
	$(document).ready(function() {
		var sandbox = true;
		var deviceDataId = '';
		OpenPay.setId('mzdtln0bmtms6o3kck8f');
		OpenPay.setApiKey('pk_f0660ad5a39f4912872e24a7a660370c');
		OpenPay.setSandboxMode(true);
		deviceDataId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
		$('#deviceID').val(deviceDataId);
		$('#cardNumber').on('change', function() {
			const cardIMG = $('#cardTypeImg');
			const cardNumber = $('#cardNumber').val();
			const cardType = OpenPay.card.cardType(cardNumber);
			verifyForm();
			const img = '<img src="/assets/images/cardtype/' + cardType + '.svg" alt="' + cardType + '" height="70px">';
			cardIMG.empty();
			cardIMG.append(img);
		});
		$('#nameHolder').on('input', function() {verifyForm();});
		$('#cvv').on('input', function() {verifyForm();});
		$('#sendCard').on('click', function(event) {
			const flag = $('#cardFlag').val();
			console.log(flag);
			// if (flag === 1 || flag === '1'){
			//
			// 	newCard();
			// }else{
			// 	shiftCard();
			// }
			OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
		});
		var sucess_callbak = function (response) {
			var token_id = response.data.id;
			console.log(token_id);
			$('#token_id').val(token_id);
		};

		var error_callbak = function (response) {
			var desc = response.data.description != undefined ? response.data.description : response.message;
			alert("ERROR [" + response.status + "] " + desc);
		};
		$('#changeCard').on('click', function(){
			$('#addCardM').modal('open');
		});
		$('#nt_SupportReply').on('change', function(){
			console.log($('#nt_SupportReply').prop('checked'));
		});
		$('#saveChanges').on('click', function(){
			$.ajax({
				url: 'Configuracion/saveChanges',
				data: {
					nt_OperationNew: $('#nt_OperationNew').prop("checked") ? 1 : 0,
					nt_OperationApproved: $('#nt_OperationApproved').prop("checked") ? 1 : 0,
					nt_OperationStatus: $('#nt_OperationStatus').prop("checked") ? 1 : 0,
					nt_OperationPaid: $('#nt_OperationPaid').prop("checked") ? 1 : 0,
					nt_OperationReturn: $('#nt_OperationReturn').prop("checked") ? 1 : 0,
					nt_OperationReject: $('#nt_OperationReject').prop("checked") ? 1 : 0,
					nt_OperationDate: $('#nt_OperationDate').prop("checked") ? 1 : 0,
					nt_OperationInvoiceRequest: $('#nt_OperationInvoiceRequest').prop("checked") ? 1 : 0,
					nt_OperationExternalAccount: $('#nt_OperationExternalAccount').prop("checked") ? 1 : 0,
					nt_InviteNew: $('#nt_InviteNew').prop("checked") ? 1 : 0,
					nt_InviteStatus: $('#nt_InviteStatus').prop("checked") ? 1 : 0,
					nt_DocumentStatementReady: $('#nt_DocumentStatementReady').prop("checked") ? 1 : 0,
					nt_SupportTicketStatus: $('#nt_SupportTicketStatus').prop("checked") ? 1 : 0,
					nt_SupportReply: $('#nt_SupportReply').prop("checked") ? 1 : 0,
				},
				dataType: 'json',
				method: 'post',
				beforeSend: function () {
				},
				success: function (data) {
					if(data.code === 502){
						$('#addCardM').modal('close');
						alert('Error');
						console.log(data);
					}else if(data.type != null){
						$('#cardInfoImg').empty();
						$('#cardInfoText').empty();
						const img = '<img src="/assets/images/cardtype/'+data.type+'.svg" alt="'+data.type+'" width="100px">';
						const info = '<p id="cardInfo"><strong>'+data.type+':</strong> ****'+data.endCard+'</p> <p id="cardExp">Vence en '+data.month+' del 20'+data.year+'</p>';
						$('#cardInfoImg').append(img);
						$('#cardInfoText').append(info);
						$('#changeCard').empty();
						$('#changeCard').append('Cambiar');
						$('#addCardM').modal('close');
						var toastHTML = '<span><strong>¡Tarjeta agregada exitosamente!</strong></span>';
						M.toast({html: toastHTML});
					}else{
						$('#addCardM').modal('close');
						if (data.error_code === 3002){
							var toastHTML = '<span><strong>Error</strong></span>';
							M.toast({html: toastHTML});
							var toastHTML = '<span><strong>Tarjeta expirada</strong></span>';
							M.toast({html: toastHTML});
						}
					}
				},
				complete: function () {
				}
			});
		});
	});
	function verifyForm(){
		var card = $('#cardNumber').val();
		var name = $('#nameHolder').val();
		var cvv = $('#cvv').val();
		if (card !== '' && name !== '' && cvv !== '') {
			$('#sendCard').prop('disabled', false)
		}else{
			$('#sendCard').prop('disabled', true)
		}
	}
	function newCard(){
		let cardNumber = $('#cardNumber').val();
		let cardType = OpenPay.card.cardType(cardNumber);
		let device = $('#deviceID').val();
		let cvv = $('#cvv').val();
		let month = $('#expMonth').val();
		let year = $('#expYear').val();
		let name = $('#nameHolder').val();
		$.ajax({
			url: 'Configuracion/newSubscription',
			data: {
				cardNumber:cardNumber,
				holderName:name,
				expirationMonth:month,
				expirationYear:year,
				cvv:cvv,
				sessionID:device,
				cardType:cardType,
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
				const left = $('#addCardM').offset().left;
				const top = $('#addCardM').offset().top;
				const width = $('#addCardM').width();
				$('#solveLoader').css({
					display: 'block',
					left: left,
					top: top + 59,
					width: width,
					zIndex: 999999
				}).focus();
			},
			success: function (data) {
				let toastHTML;
				if(data.code === 502){
					$('#addCardM').modal('close');
					toastHTML = '<span><strong>' + data.error + '</strong></span>';
					M.toast({html: toastHTML});
					toastHTML = '<span><strong>'+data.message+'</strong></span>';
					M.toast({html: toastHTML});
				}else if(data.type != null){
					$('#cardInfoImg').empty();
					$('#cardInfoText').empty();
					const img = '<img src="/assets/images/cardtype/'+data.type+'.svg" alt="'+data.type+'" width="100px">';
					const info = '<p id="cardInfo"><strong>'+data.type+':</strong> ****'+data.endCard+'</p> <p id="cardExp">Vence en '+data.month+' del 20'+data.year+'</p>';
					$('#cardInfoImg').append(img);
					$('#cardInfoText').append(info);
					$('#changeCard').empty();
					$('#changeCard').append('Cambiar');
					$('#addCardM').modal('close');
					toastHTML = '<span><strong>¡Tarjeta agregada exitosamente!</strong></span>';
					$('#cardFlag').val('2');
					M.toast({html: toastHTML});
				}else{
					$('#addCardM').modal('close');
					if (data.error_code === 3002){
						toastHTML = '<span><strong>Error</strong></span>';
						M.toast({html: toastHTML});
						toastHTML = '<span><strong>Tarjeta expirada</strong></span>';
						M.toast({html: toastHTML});
					}
				}

			},
			complete: function () {
				$('#solveLoader').css({
					display: 'none'
				});
			}
		});
	}
	function shiftCard(){
		var cardNumber = $('#cardNumber').val();
		var cardType = OpenPay.card.cardType(cardNumber);
		var device = $('#deviceID').val();
		var cvv = $('#cvv').val();
		var month = $('#expMonth').val();
		var year = $('#expYear').val();
		var name = $('#nameHolder').val();
		var newSubscription = '';
		$.ajax({
			url: 'Configuracion/changeCard',
			data: {
				cardNumber:cardNumber,
				holderName:name,
				expirationMonth:month,
				expirationYear:year,
				cvv:cvv,
				sessionID:device,
				cardType:cardType,
			},
			dataType: 'json',
			method: 'post',
			beforeSend: function () {
			},
			success: function (data) {
				if(data.code === 502){
					$('#addCardM').modal('close');
					alert('Error');
					console.log(data);
				}else if(data.type != null){
					$('#cardInfoImg').empty();
					$('#cardInfoText').empty();
					const img = '<img src="/assets/images/cardtype/'+data.type+'.svg" alt="'+data.type+'" width="100px">';
					const info = '<p id="cardInfo"><strong>'+data.type+':</strong> ****'+data.endCard+'</p> <p id="cardExp">Vence en '+data.month+' del 20'+data.year+'</p>';
					$('#cardInfoImg').append(img);
					$('#cardInfoText').append(info);
					$('#changeCard').empty();
					$('#changeCard').append('Cambiar');
					$('#addCardM').modal('close');
					var toastHTML = '<span><strong>¡Tarjeta agregada exitosamente!</strong></span>';
					M.toast({html: toastHTML});
				}else{
					$('#addCardM').modal('close');
					if (data.error_code === 3002){
						var toastHTML = '<span><strong>Error</strong></span>';
						M.toast({html: toastHTML});
						var toastHTML = '<span><strong>Tarjeta expirada</strong></span>';
						M.toast({html: toastHTML});
					}
				}
			},
			complete: function () {
			}
		});
	}
</script>
