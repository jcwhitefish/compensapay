<script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		crossorigin="anonymous"
></script>
<script	src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
		   integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
		   crossorigin="anonymous"
		   referrerpolicy="no-referrer"
></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<div class="p-5">
	<div>
		<div class="yellow center">
			<div class="col 12"><span></span> Invita a tus clientes y/o proveedores. <a href="">aquí</a></div>
		</div>
	</div>
	<div class="row">
		<div class="col l12">
			<div><h5 style="font-weight: bold">Configuración para Transfigura</h5></div>
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
						<input type="checkbox" id="newOp" name="newOp" class="filled-in"/>
						<span>Nueva operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" id="ClienteAOP" name="ClienteAOP" class="filled-in"/>
						<span>Cliente autoriza operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Cambio estatus de operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Pago de operación</span>
					</label></p>
				<p></p><label>
					<input type="checkbox" name="" class="filled-in"/>
					<span>Devolución del pago</span>
				</label><p
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Rechazo a operación</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Autorización de operación y cambio de fecha</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Solicitud de factura</span>
					</label></p>
			</div>
			<section>
				<h6>Solicitudes o invitaciones</h6>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Invitación de un cliente a ser proveedor</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Aprobación de solicitud</span>
					</label></p>
			</section>
			<section><h5>Generales</h5></section>
			<div class="divider"></div>
			<div class="section">
				<h6>Operaciones</h6>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Pago a cuenta externa</span>
					</label></p>
				<h6>Documentos</h6>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Estado de cuennta</span>
					</label></p>

				<h6>Programación de pagos</h6>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>7 días antes del vencimiento de una factura</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>3 días antes del vencimiento de una factura</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>1 día antes del vencimiento de una factura</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>El día del vencimiento de una factura</span>
					</label></p>
				<h6>Subscripción</h6>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Cobro de subscripción</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Rechazo de cobro de subscripción</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Suspension de la  cuenta</span>
					</label></p>
				<h6>Soporte</h6>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Tickets y cambio de status</span>
					</label></p>
				<p><label>
						<input type="checkbox" name="" class="filled-in"/>
						<span>Mensaje de respuesta</span>
					</label></p>
			</div>
		</div>
	</div>

	<div id="addCardM" class="modal modal-fixed-footer">
		<div class="modal-content">
			<h5 id="folio_modal" style="margin-top: 1px;">Método de pago</h5>
			<p>Completa los datos requeridos para poder generar los pagos correspondientes al uso de la plataforma</p>
			<div class="">
				<div class="row" style="margin-bottom: 1px;">
					<div class="col l7">
						<label>
							<span>Número de tarjeta</span>
							<input type="text" id="cardNumber" name="cardNumber" class="validate" required  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
						</label>
					</div>
					<div class="col l3" id="cardTypeImg">

					</div>
				</div>
				<label>
					<span>Nombre en la tarjeta</span>
					<input type="text" id="nameHolder" name="nameHolder" class="validate" required oninput="this.value = this.value.replace(/[^a-z. A-Z]/g, '').replace(/(\..*?)\..*/g, '$1');">
				</label>
				<div class="row" style="margin-bottom: 1px;">
					<div class="col l6">
						<span>Fecha de vencimiento</span>
						<div class="row" style="margin-bottom: 5px;">
							<div class="col l3">
								<select id="expMonth" name="expMonth" class="col l6">
									<?php
									for ($i = 1; $i <= 12; $i++) {
										echo '<option value="'. $i. '">'.str_pad($i, 2, "0", STR_PAD_LEFT). '</option>';
									}
									?>
								</select>
							</div>
							<div class="col l3">
								<select id="expYear" name="expYear" class="col l6">
									<?php
									for ($i = 23; $i <= 28; $i++) {
										echo '<option value="'. $i. '">'. $i. '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="col l6">
						<span>cvc</span>
						<div >
							<label >
								<input type="text" id="cvv" name="cvv" class="col s3 validate" placeholder="123" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
							</label>
						</div>
					</div>
				</div>
				<input type="hidden" name="deviceID" id="deviceID" value=""/>
				<input type="hidden" name="cardType" id="cardType" value=""/>
				<input type="hidden" name="cardFlag" id="cardFlag" value="<?=$flag= empty($card) ? 1 : 2;?>"/>
				<div class="row" style="margin-bottom: 1px;margin-top: 4px;">
					<div class="col l3">
						<img src="/assets/images/openpay.png" alt="taretas" height="30px">
					</div>
					<div class="col l6">
						<img src="/assets/images/tarjets-de-credito.png" alt="taretas" height="30px">
					</div>
					<div class="col l3"><button class="btn waves-effect waves-light grey right" type="submit" id="sendCard" name="sendCard" disabled>
							Enviar
							<i class="material-icons right">send</i>
						</button></div>
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
		background-color: rgba(255, 255, 255, 0.5);
		background-image: url('/assets/images/loader.gif') !important;
		background-repeat: no-repeat;
		background-position: center center;
		background-size: 150px 150px;
		top: 0;
		width: 100px;
		height: 100px;
	}
</style>
<script type="text/javascript" src="https://resources.openpay.mx/lib/openpay-js/1.2.38/openpay.v1.min.js"></script>
<script type="text/javascript" src="https://resources.openpay.mx/lib/openpay-data-js/1.2.38/openpay-data.v1.min.js"></script>
<script>
	$(document).ready(function() {
		var sandbox = true;
		var deviceDataId = '';
		OpenPay.setId('mhcmkrgyxbjfw9vb9cqc');
		OpenPay.setApiKey('sk_10a295f448a043a9ab582aa200552647');
		OpenPay.setSandboxMode(sandbox);
		deviceDataId = OpenPay.deviceData.setup("subscription");
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
		$('#sendCard').on('click', function() {
			const flag = $('#cardFlag').val();
			console.log(flag);
			if (flag === 1 || flag === '1'){
				newCard();
			}else{
				shiftCard();
			}
		});
		$('#changeCard').on('click', function(){
			$('#addCardM').modal('open');
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
