<!--<script type="text/javascript" src="/assets/js/jquery-git.js"></script>-->
<!--<script type="text/javascript" src="/assets/js/jquery-3.3.1.min.js"></script>-->
<!--<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>-->
<!--<script type="text/javascript" src="/assets/js/jquery-ui.js"></script>-->
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/black-tie/jquery-ui.css">-->
<link
	href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"
	rel="stylesheet"
/>
<script
	src="https://code.jquery.com/jquery-3.6.0.min.js"
	integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
	crossorigin="anonymous"
></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
	integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
	crossorigin="anonymous"
	referrerpolicy="no-referrer"
></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>



<div class="p-5" id="app">
	<div class="nav-wrapper">
		<div class="yellow center">
			<div class="col 12"><span></span> Invita a tus clientes y/o proveedores. <a href="">aquí</a></div>
		</div>
	</div>
	<div class="row">
		<div class="col l12">
			<div><h5 style="font-weight: bold">Configuración para Transfigura</h5></div>
		</div>
		<div class="col l6 m6">
			<form>
				<fieldset>
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

					<!--<div class="section">
						<label>
							<input type="checkbox" id="OnlyInvitedProv" name="OnlyInvitedProv" class="filled-in"/>
							<span>Solo pueden ser mis proveedores a través de invitación</span>
						</label>
						<label>
							<input type="checkbox" id="OnlyInvitedProv" name="OnlyInvitedProv" class="filled-in"/>
							<span>Los proveedores pueden crear operaciones<i class="material-icons right">help</i></span>
						</label>
						<div>
							<div class="row">
								<div class="col l12"><h6>Operaciones</h6></div>
								<div class="row" style="font-size: 12px">
									<p class="col s4 left" style="margin-left: 12px">Programar pago de factura a: </p>
									<label>
										<input type="text" id="PdiasFac" name="PdiasFac" placeholder="45" class="col s1"/>
									</label>
									<p class="col s1">días</p>
									<label>
										<select id="Tdias" name="Tdias" class="browser-default col s2">
											<option value="1">Hábiles</option>
											<option value="2">No hábiles</option>
										</select>
										<i class="material-icons left" style="font-size: small; padding-left: 8px">help</i>
									</label>
									<p class="col s3"><a href="">Detalles por proveedor</a></p>
								</div>
							</div>
						</div>
					</div>-->

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
							<div class="col l3 white">
								<img src="/assets/images/cardtype/Mastercard.svg" alt="branch" width="100px" >
							</div>
							<div class="col l4">
								<p id="cardInfo"><strong>MasterdCard:</strong> ****4242</p>
								<p id="cardExp">Vence en enero del 2024</p>
							</div>
							<div class="col l4">
								<input type="button" id="changeCard" name="changeCard" value="Cambiar" class="waves-effect blue waves-light btn-large l12" style="width: 100%">
							</div>
						</div>
						<h6 style="margin-top: 1px">Historial de facturación</h6>
						<div class="divider"></div>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="col l6 m6">
			<form>
				<fieldset>
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
							<input type="checkbox" id="" name="" class="filled-in"/>
							<span>Cambio estatus de operación</span>
							</label></p>
						<p><label>
							<input type="checkbox" id="" name="" class="filled-in"/>
							<span>Pago de operación</span>
						</label></p>
						<p></p><label>
							<input type="checkbox" id="" name="" class="filled-in"/>
							<span>Devolución del pago</span>
						</label><p
						<p><label>
							<input type="checkbox" id="" name="" class="filled-in"/>
							<span>Rechazo a operación</span>
						</label></p>
						<p><label>
							<input type="checkbox" id="" name="" class="filled-in"/>
							<span>Autorización de operación y cambio de fecha</span>
						</label></p>
						<p><label>
							<input type="checkbox" id="" name="" class="filled-in"/>
							<span>Solicitud de factura</span>
						</label></p>
					</div>
					<section>
						<h6>Solicitudes o invitaciones</h6>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Invitación de un cliente a ser proveedor</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Aprobación de solicitud</span>
							</label></p>
					</section>
					<section><h5>Generales</h5></section>
					<div class="divider"></div>
					<div class="section">
						<h6>Operaciones</h6>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Pago a cuenta externa</span>
							</label></p>
						<h6>Documentos</h6>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Estado de cuennta</span>
							</label></p>

						<h6>Programación de pagos</h6>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>7 días antes del vencimiento de una factura</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>3 días antes del vencimiento de una factura</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>1 día antes del vencimiento de una factura</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>El día del vencimiento de una factura</span>
							</label></p>
						<h6>Subscripción</h6>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Cobro de subscripción</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Rechazo de cobro de subscripción</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Suspension de la  cuenta</span>
							</label></p>
						<h6>Soporte</h6>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Tickets y cambio de status</span>
							</label></p>
						<p><label>
								<input type="checkbox" id="" name="" class="filled-in"/>
								<span>Mensaje de respuesta</span>
							</label></p>
					</div>
				</fieldset>
			</form>
		</div>
	</div>

	<div id="addCardM" class="modal">
		<div class="modal-content">
			<h4 id="folio_modal">Método de pago</h4>
			<form class="form-group">
				<p>Completa los datos requeridos para poder generar los pagos correspondientes al uso de la plataforma</p>
				<div class="section">
					<label class="">
						<span>Número de tarjeta</span>
						<input type="text" id="cardNumber" name="cardNumber" class="validate" required>
					</label>
					<label class="">
						<span>Nombre en la tarjeta</span>
						<input type="text" id="nameHolder" name="nameHoler" class="validate" required>
					</label>
					<span>Fecha de vencimiento</span>
					<div class="row">
						<div class="col l6">
							<select id="expMonth" name="expMonth" class="col l6">
								<?php
								for ($i = 1; $i <= 12; $i++) {
									echo '<option value="'. $i. '">'.str_pad($i, 2, "0", STR_PAD_LEFT). '</option>';
								}
								?>
							</select>
						</div>
						<div class="col l6">
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
			</form>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
		</div>
	</div>

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
</style>
<script>
	$(document).ready(function() {
		$('#addCardM').modal('open');
	});
</script>
