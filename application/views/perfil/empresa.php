<?php
	//TODO: en todos los registros existe la clase invalid de materialize y es la que se tendrria que ocupar para poner el borde rojo se llama validate
	$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];
	
	$urlArchivos = base_url ( 'boveda/' . $unique . '/' );

	//datos empresa
	if(is_array($empresa))
	{
		foreach($empresa AS $value){
			$legal_name = $value["legal_name"];
			$short_name = $value["short_name"];
			$regimen = $value["regimen"];
			$rfc = $value["rfc"];
			$direccion = $value["address"];
			$telefono = $value["telephone"];
			$correoe = $value["correoe"];
			$clabe = $value["account_clabe"];
			$cp = $value["zip_code"];
			$colonia = $value["colonia"];
			$municipio = $value["municipio"];
			$estado = $value["estado"];
			$banco = $value["banco"];
			$zipid = $value["zip_id"];
			$logotipo = $value["Logotipo"];
			$actac = $value["ActaConstitutiva"];
			$constanciasf = $value["ConstanciaSituacionF"];
			$comprobanted = $value["ComprobanteDomicilio"];
			$identificacionrl = $value["IdenRepresentante"];
			$escriturasp = $value["EscriturasPublicas"];
			$poderrl = $value["PoderRepresentanteLegal"];
			$efirma = $value["eFirma"];
			$propietarior = $value["IdenPropietarioReal"];
			$documentoa = $value["DocumentoAdicional"];
		}
	}

	//datos propietario
	if(is_array($propietario))
	{
		foreach($propietario AS $value)
		{
			$domiciliopr = $value["Domicilio"];
			$correoepr = $value["CorreoE"];
			$curppr = $value["Curp"];
			$telefonopr = $value["Telefono"];
			$ocupacionpr = $value["Ocupacion"];
		}
	}
?>
<div class="p-5">
	<h5>Configuración de la empresa</h5>
	<div class="row">
		<div class="col l12 card esquinasRedondas right-align" style="padding: 20px;">
			<a class="linkConfiguracion" href="<?= base_url ( 'Configuracion' ); ?>" style="color: #9118bd">
				Configuración Avanzada
				<i class="material-icons iconoSetting">
					settings
				</i></a>
		</div>
	</div>
	<div class="row card esquinasRedondas">
		<div class="col l9">
			<form name="fdatempresa" id="fdatempresa" method="POST" action="<?php echo base_url('perfil/updatedatosempresa');?>">
			<div class="col l4 especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Detalles de la empresa</p>
					</div>
					<div class="input-border col l12">
						<input type="text" name="bussinesName" id="bussinesName" value="<?php echo $legal_name;?>" required>
						<label for="bussinesName">Razón Social *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="nameComercial"	id="nameComercial" value="<?php echo $short_name;?>" required>
						<label for="nameComercial">Nombre Comercial *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}" value="<?php echo $rfc;?>" title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
						<label for="rfc">RFC *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<select name="regimen" id="regimen" required>
							<?php
								if(is_array($detalles["regimenfiscal"]))
								{
									foreach($detalles["regimenfiscal"] AS $rf)
									{
										echo '<option value="'.$rf["rg_id"].'"';if($regimen == $rf["rg_id"]){echo ' selected';} echo '>'.$rf["rg_clave"].' - '.$rf["rg_regimen"].'</option>';
									}
								}
							?>
						</select>
						<label for="regimen">Regimen Fiscal *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="telefono" id="telefono" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa exactamente 10 dígitos numéricos." value="<?php echo $telefono;?>">
						<label for="telefono">Telefono </label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="email" name="correoe" id="correoe" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" title="Por favor, ingresa un correo electrónico de contacto." value="<?php echo $correoe;?>">
						<label for="telefono">Correo Electrónico</label>
					</div>
				</div>
			</div>
			<div class="col l4 line-card line-card-l especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Domicilio de la empresa</p>
					</div>
					<div class="input-border col l12">
						<input type="text" name="direccion" id="direccion" required value="<?php echo $direccion;?>">
						<label for="direccion">Direccion *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12">
						<input type="text" name="codigoPostal" id="codigoPostal" maxlength="5" pattern="[0-9]{5}" required onchange="datos_estado(this.value)" value="<?php echo $cp;?>">
						<label for="codigoPostal">Codigo Postal *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="nombre_estado">
						<input type="text" name="estado" id="estado" disabled required value="<?php echo $estado;?>">
						<label for="estado">Estado</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="nombre_municipio">
						<input type="text" name="municipio" id="municipio" required disabled value="<?php echo $municipio;?>">
						<label for="municipio">Municipio *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="nombre_colonia">
						<select name="colonia" id="colonia" required>
							<?php
								if(is_array($detalles["colonias"]))
								{
									foreach($detalles["colonias"] AS $value)
									{
										echo '<option value="'.$value["id"].'"';if($zipid == $value["id"]){echo ' selected';} echo '>'.$value["colonia"].'</option>';
									}
								}
							?>
						</select>
						<label for="colonia">Colonia *</label>
					</div>
				</div>
			</div>
			<div class="col l4 line-card line-card-1 especial-p">
				<div class="row">
					<div class="col l12" style="margin-bottom: 30px;">
						<p class="bold">Datos Bancarios</p>
					</div>
					<div class="input-border col l12">
						<input type="text" name="clabe" id="clabe" required pattern="[0-9]{18}" maxlength="18" title="Por favor, ingresa exactamente 18 dígitos numéricos." onchange="datos_banco(this.value)" value="<?php echo $clabe;?>">
						<label for="clabe" style="margin-bottom: 10px !important;">Cuenta CLABE *</label>
					</div>
				</div>
				<div class="row">
					<div class="input-border col l12" id="bancoemisor">
						<input type="text" name="bank" id="bank" disabled required value="<?php echo $banco;?>">
						<label for="bank">Banco emisor *</label>
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<button class="button-gray" style="margin-left: 20px;" type="submit" name="action">Guardar datos de la empresa</button>	
				</div>
			</div>
			</form>
		</div>
		<div class="col l3 center-align">
			<div class="container" id="logotipo">
				<form id="fadlogotipo" name="fadlogotipo">
					<h5 class="card-title">Seleccionar logotipo</h5>
					<img src="<?php if ($logotipo == 1){ echo base_url('boveda/' . $unique . '/logotipo.jpg'); } else if ($logotipo == 0) { echo 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg'; }?>" alt="" style="max-width: 140px; max-height: 140px;"><br>
					<label for="imglogotipo" class="button-gray p-5">
						<?php if($logotipo == 0){ echo 'Seleccionar Imagen'; } else { echo 'Cambiar Imagen'; }?>
					</label>
					<input name="imglogotipo" id="imglogotipo" type="file" accept="image/jpeg" maxFileSize="1048576" />
				</form>
			</div>
		</div>
	</div>
		<div class="row card esquinasRedondas" style="padding:20px">
			<h5 class="card-title">Documentos requeridos para la creación de la cuenta</h5>
			<p>Es necesario que adjunte los siguientes documentos a su cuenta para poder generar su clabe interbancaria dentro de la plataforma Solve</p>
			
			<div class="row line-card-2" id="divactac">
				<p><strong>1. Acta Constitutiva (obligatorio)</strong></p>
				<div class="col s3">
					<form id="fadactac" name="fadactac">
						<label for="actac" class="button-gray p-5">
							<?php if($actac == 0){echo 'Seleccionar Archivo'; } else if ($actac == 1){ echo 'Actualizar Archivo';} ?>
						</label>
						<input name="actac" id="actac" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($actac == 0){echo 'No existe documento';}else if ($actac == 1){echo '<a href="'.$urlArchivos.'acta_constitutiva.pdf" target="_blank">Ver Acta Constitutiva</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Acta constitutiva (que incluya la constancia de inscripción en el RPPyC o una carta del notario en caso de que se encuentre en proceso de inscripción en el RPPyC)</p>
				</div>
			</div>
			
			<div class="row line-card-2" id="divescriturasp">
				<p><strong>2. Escrituras Públicas (obligatorio)</strong></p>
				<div class="col s3">
					<form id="fadescriturasp" name="fadescriturasp">
						<label for="escriturasp" class="button-gray p-5">
							<?php if($escriturasp == 0){echo 'Seleccionar Archivo'; } else if ($escriturasp == 1){ echo 'Actualizar Archivo';} ?>
						</label>
						<input name="escriturasp" id="escriturasp" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($escriturasp == 0){echo 'No existe documento';}else if ($escriturasp == 1){echo '<a href="'.$urlArchivos.'escrituras_publicas.pdf" target="_blank">Ver Escrituras Públicas</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Escrituras públicas en donde consten modificaciones en la empresa (aplica para casos de transformación, fusión, escisión o cambio de denominación)</p>
				</div>
			</div>

			<div class="row line-card-2" id="divpoderrl">
				<p><strong>3. Poder del representante legal </strong></p>
				<div class="col s3">
					<form id="fadpoderrl" name="fadpoderrl">
						<label for="poderrl" class="button-gray p-5">
							<?php if($poderrl == 0){echo 'Seleccionar Archivo'; } else if ($poderrl == 1){ echo 'Actualizar Archivo';} ?>
						</label>
						<input name="poerrl" id="poderrl" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($poderrl == 0){echo 'No existe documento';}else if ($poderrl == 1){echo '<a href="'.$urlArchivos.'poder_representante_legal.pdf" target="_blank">Ver Poder del Representante Legal</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Poder del representante legal (solo cuando no se encuentre contenido en el acta constitutiva de la empresa)</p>
				</div>
			</div>

			<div class="row line-card-2" id="dividentificacionrl">
				<p><strong>4. Identificación del representante legal (obligatorio)</strong></p>
				<div class="col s3">
					<form id="fadidentificacionrl" name="fadidentificacionrl">
						<label for="identificacionrl" class="button-gray p-5">
							<?php if($identificacionrl == 0){echo 'Seleccionar Archivo';}else if($identificacionrl == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="identificacionrl" id="identificacionrl" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($identificacionrl == 0){echo 'No existe documento';}else if($identificacionrl == 1){echo '<a href="'.$urlArchivos.'identificacion_representante_legal.pdf" target="_blank">Ver Identificacion de Representante Legal</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Identificación oficial y vigente del representante legal</p>
				</div>
			</div>

			<div class="row line-card-2"  id="divconstanciasf">
				<p><strong>5. Constancia de Situación Fiscal (obligatorio)</strong></p>
				<div class="col s3">
					<form id="fadconstanciasf" name="fadconstanciasf">
						<label for="constanciasf" class="button-gray p-5">
							<?php if($constanciasf == 0){echo 'Seleccionar Archivo';}else if($constanciasf == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="constanciasf" id="constanciasf" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($constanciasf == 0){echo 'No existe documento';}else if ($constanciasf == 1){echo '<a href="'.$urlArchivos.'constancia_situacion_fistcal.pdf" target="_blank">Ver Constancia de Situación Fiscal</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Constancia de situación fiscal de reciente emisión (del año en curso)</p>
				</div>
			</div>

			<div class="row line-card-2" id="divcomprobanted">
				<p><strong>6. Comprobante de Domicilio (obligatorio)</strong></p>
				<div class="col s3">
					<form id="fadcomprobanted" name="fadcomprobanted">
						<label for="comprobanted" class="button-gray p-5">
							<?php if($comprobanted == 0){echo 'Seleccionar Archivo';}else if($comprobanted == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="comprobanted" id="comprobanted" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($comprobanted == 0){echo 'No existe documento';}else if($comprobanted == 1){echo '<a href="'.$urlArchivos.'comprobante_domicilio.pdf" target="_blank">Ver Comprobante de domicilio</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Comprobante de domicilio no mayor a 3 meses de antigüedad (únicamente si es diferente al domicilio fiscal)</p>
				</div>
			</div>

			<div class="row line-card-2" id="divefirma">
				<p><strong>7. Documento e.firma (obligatorio)</strong></p>
				<div class="col s3">
					<form id="fadefirma" name="fadefirma">
						<label for="efirma" class="button-gray p-5">
							<?php if($efirma == 0){echo 'Seleccionar Archivo';}else if($efirma == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="efirma" id="efirma" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($efirma == 0){echo 'No existe documento';}else if($efirma == 1){echo '<a href="'.$urlArchivos.'e_firma.pdf" target="_blank">Ver Documento e.firma</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Documento donde conste la e.firma de la empresa</p>
				</div>
			</div>

			<div class="row line-card-2" id="divpropietarior">
				<p><strong>8. Propietario Real</strong></p>
				<div class="col s3">
					<form id="fadpropietarior" name="fadpropietarior">
						<label for="propietarior" class="button-gray p-5">
							<?php if($propietarior == 0){echo 'Seleccionar Archivo';}else if($propietarior == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="propietarior" id="propietarior" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($propietarior == 0){echo 'No existe documento';}else if($propietarior == 1){echo '<a href="'.$urlArchivos.'propietario_real.pdf" target="_blank">Ver Identificación Propietario Real</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Identificación oficial vigente del propietario real</p>
				</div>
			</div>

			<div class="row line-card-2" id="divinfopropietarior">
				<p><strong>9. Información del Propietario Real</strong></p>
				<form id="fadinfopropietarior" name="fadinfopropietarior">
					<div class="row">
						<div class="col s4">
							<div class="input-border col l12">
								<input type="email" name="correoepr" id="correoepr" required pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" title="Por favor, ingresa un correo electrónico de contacto." value="<?php if(isset($correoepr)){echo $correoepr;}?>">
								<label for="correoepr">Correo Electrónico *</label>
							</div>
						</div>
						<div class="col s4">
							<div class="input-border col l12">
								<input type="text" name="domiciliopr" id="domiciliopr" required title="Por favor, ingresa el domicilio completo." value="<?php if(isset($domiciliopr)){echo $domiciliopr;}?>">
								<label for="domiciliopr">Domiclio *</label>
							</div>
						</div>
						<div class="col s4">
							<div class="input-border col l12">
								<input type="text" name="curppr" id="curppr" required pattern="^[A-Z]{4}\d{6}[H,M][A-Z]{5}[A-Z0-9]{2}$" title="Por favor, ingresa el curp." value="<?php if(isset($curppr)){echo $curppr;}?>">
								<label for="curppr">CURP *</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							<div class="input-border col l12">
								<input type="text" name="telefonopr" id="telefonopr" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa un teléfono de contacto." value="<?php if(isset($telefonopr)){echo $telefonopr;}?>">
								<label for="telefonopr">Numero Telefonico *</label>
							</div>
						</div>
						<div class="col s4">
							<div class="input-border col l12">
								<input type="text" name="ocupacionpr" id="ocupacionpr" required title="Por favor, ingresa la ocupación del propietario real." value="<?php if(isset($ocupacionpr)){ echo $ocupacionpr;}?>">
								<label for="ocupacionpr">Ocupación *</label>
							</div>
						</div>
						
						<div class="col s4">
							<div style="padding: 20px;">
								<input type="submit" name="savepr" id="savepr" value="Guardar Datos del propietario real" class="button-gray">
							</div>
						</div>
					</div>
				</form>
			</div>

			<div class="row line-card-2" id="divdocumentoa">
				<p><strong>10. Documentación Adicional</strong></p>
				<div class="col s3">
					<form id="faddocumentoa" name="faddocumentoa">
						<label for="documentoa" class="button-gray p-5">
							<?php if($documentoa == 0){echo 'Seleccionar Archivo';}else if($documentoa == 1){echo 'Actualizar Archivo';} ?>
						</label>
						<input name="documentoa" id="documentoa" type="file" accept="application/pdf" maxFileSize="5242880" />
					</form>
				</div>
				<div class="col s3">
					<p><?php if($documentoa == 0){echo 'No existe documento';}else if($documentoa == 1){echo '<a href="'.$urlArchivos.'documento_adicional.pdf" target="_blank">Ver Documento Adicional</a>';}?></p>
				</div>
				<div class="col s6">
					<p>Solo en caso de pertenecer a alguno de estos sectores:</p>
					<ul>
						<li>Para actividades de <strong style="text-decoration: underline">outsourcing</strong>, su registro ante el REPSE</li>
						<li>Para actividades relacionadas con <strong style="text-decoration: underline">activos virtuales</strong>, su acuse como actividad vulnerable</li>
						<li>Para actividades relacionadas con <strong style="text-decoration: underline">juegos y apuestas</strong>, su autorización ante SEGOB</li>
					</ul>
				</div>
			</div>

			
		
		</div>
	
	<!-- Modal KYC -->
	<div id="modal-kyc-stp" class="modal">
		<div class="modal-content" id="formulario_stp_kyc">
			<h5 class="card-title">Formato Solicitud de Servicio STP</h5>
			<p>Como parte de la solicitud de servicio STP, requerimos su apoyo para contestar el siguiente cuestionario:</p>
			<p><strong>KYC</strong></p>
			<form name="fkyc" id="fkyc">
				<div class="row">
					<div class="col s12">
						<div class="input-border col l12">
							<input type="text" name="personalc" id="personalc" required title="Por favor, introduzca la información requerida.">
							<label for="personalc">1. Personal contactado para entregar la documentación e información (nombre y cargo): </label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-border col l12">
							<input type="text" name="origene" id="origene" required title="Por favor, introduzca la información requerida.">
							<label for="origene">2. Mencionar origen de la empresa, giro del negocio, mercado objetivo, si forman parte de algún grupo empresarial en México o en el extranjero, etc.:  </label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s3">
						<div class="input-border col l12">
							<select name="dedicae" id="dedicae" required>
								<option value="0">Elija un elemento</option>
								<option value="1">Agregador de pagos</option>
								<option value="2">Caja de ahorrros</option>
								<option value="3">Casa de bolsa</option>
								<option value="4">Comercio</option>
								<option value="5">Crowdfunding</option>
								<option value="6">Desarrollo de software</option>
								<option value="7">Escolar</option>
								<option value="8">Factoraje y arrendamiento</option>
								<option value="9">Financiero- Criptomonedas y/o Activos Virtuales</option>
								<option value="10">Financiero- NO Regulado (SOFOM)</option>
								<option value="11">Financiero- Regulado (SOFIPO & SOCAP)</option>
								<option value="12">Financiero- Regulado (SOFOM)</option>
								<option value="13">Fondo de inversión</option>
								<option value="14">Inmobiliaria - Administración</option>
								<option value="15">Inmobiliaria - Comercialización</option>
								<option value="16">Inmobiliaria - Construcción</option>
								<option value="17">Interno</option>
								<option value="18">Manufactura</option>
								<option value="19">Mutuo, préstamo o crédito</option>
								<option value="20">Nómina a terceros</option>
								<option value="21">Pago de servicios</option>
								<option value="22">Remesas- Transmisor Extranjeros</option>
								<option value="23">Remesas- Transmisor Nacional</option>
								<option value="24">Remesas- Transmisor Nacional</option>
								<option value="25">SAB DE CV</option>
								<option value="26">SAPI DE CV</option>
								<option value="27">Seguros y Fianzas</option>
								<option value="28">Servicios - Alimentos</option>
								<option value="29">Servicios - Contabilidad y auditoría</option>
								<option value="30">Servicios - Consultoría</option>
								<option value="31">Servicios - Juegos y Apuestas</option>
								<option value="32">Servicios - Mensajería y Paquetería</option>
								<option value="33">Servicios - Mercadotecnia y Publicidad</option>
								<option value="34">Servicios - Mantenimiento y Limpieza</option>
								<option value="35">Servicios - Perforación de pozos</option>
								<option value="36">Servicios - Tarjeta de servicios y/o Crédito</option>
								<option value="37">Servicios agrícolas, ganaderas, silvívolas y pesqueras</option>
								<option value="38">Servicios - Energía Renovable</option>
								<option value="39">Servicios - Gasera</option>
								<option value="40">Servicios - Gasolinera</option>
								<option value="41">Servicios - Telecomunicaciones</option>
								<option value="42">Servicios - Telepeaje</option>
								<option value="43">Servicios - Transporte</option>
								<option value="44">Servicios - Salud</option>
								<option value="45">Servicios - Seguridad y alarmas</option>
								<option value="46">Sindicato</option>
								<option value="47">Tarjetas de prepago, cupones, devoluciones y recompensas</option>
								<option value="48">Wallet</option>
							</select>
							<label for="dedicae">3.¿a qué se dedica la empresa?: </label>
						</div>
					</div>
					<div class="col s4">
						<div class="input-border col l12">
							<select name="serviciosc" id="serviciosc" required>
								<option value="0">Elija un elemento</option>
								<option value="1">Dispersión</option>
								<option value="2">Cobranza</option>
								<option value="3">CODI</option>
								<option value="4">CEP</option>
								<option value="5">Pago de servicios</option>
								<option value="6">Participación Indirecta</option>
							</select>
							<label for="serviciosc">¿Qué servicios implementarán en la cuenta?: </label>
						</div>
					</div>
					<div class="col s5">
						<div class="input-border col l12">
							<input type="text" name="usarac" id="usarac" required title="Por favor, introduzca la información requerida.">
          					<label for="usarac">¿para qué usarán la cuenta de STP?:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-border col l12">
							<input type="text" name="recursos" id="recursos" required title="Por favor, introduzca la información requerida.">
							<label for="recursos">4. Mencionar, ¿de dónde provienen los recursos (con los que opera la empresa) ?, sobre todo para el caso de reciente constitución o de propietarios reales no nacionales:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-border col l12">
							<input type="text" name="medios" id="medios" required title="Por favor, introduzca la información requerida.">
							<label for="medios">5. Indicar medios válidos (link) por los que captan a sus clientes (página web, app, facebook, instagram, etc.) o en su defecto indicar cómo atraen:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<div class="input-border col l12 right-align">
							<input type="submit" name="savekyc" id="savekyc" value="Guardar" class="button-gray">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Modal Perfil Transaccional -->
	<div id="modal-pt-stp" class="modal">
		<div class="modal-content" id="formulario_stp_pt">
			<h5 class="card-title">Formato Solicitud de Servicio STP</h5>
			<p>Como parte de la solicitud de servicio STP, requerimos su apoyo para contestar el siguiente cuestionario:</p>
			<p><strong>Perfil Transaccional</strong></p>
			<p>Para esta sección colocar el saldo mensual esperado de cobro y pago en pesos mexicanos; y la información solicitada:</p>
			<form name="fpt" id="fpt">
				<div class="row">
					<div class="col s6">
						<div class="input-border col l12">
							<input type="number" name="smec" id="smec" required title="Saldo de cobro (MX)">
							<label for="smec">Saldo mensual esperado de cobro: </label>
						</div>
					</div>
					<div class="col s6">
						<div class="input-border col l12">
							<input type="number" name="smep" id="smep" required title="Saldo de cobro (MX)">
							<label for="smep">Saldo mensual esperado de pago:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s6">
						<div class="input-border col l12">
							<input type="number" name="ntc" id="ntc" required title="Transacciones de cobro">
							<label for="ntc">Núm. de transacciones esperadas de cobro:</label>
						</div>
					</div>
					<div class="col s6">
						<div class="input-border col l12">
							<input type="number" name="ntp" id="ntp" required title="STransacciones de pago">
							<label for="ntp">Núm. de transacciones esperadas de pago:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s6">
						<div class="input-border col l12">
							<select name="or" id="or" required>
								<option value="0">Elija un elemento.</option>
								<option value="1">Pagos de Clientes</option>
								<option value="2">Arrendamientos de inmuebles (Rentas)</option>
								<option value="3">Recursos de Terceros</option>
								<option value="4">Aportaciones a Capital de accionistas</option>
								<option value="5">Cobranza de créditos</option>
								<option value="6">Aportaciones o Cuotas Sindicales</option>
								<option value="7">Cuenta Puente Para Inversión </option>
								<option value="8">Préstamos</option>
								<option value="9">Manejo de Divisas</option>
								<option value="10">Desarrollo del Giro del Negocio</option>
								<option value="11">Tesorería-Capital de Trabajo del Negocio</option>
								<option value="12">Partidas Presupuestales</option>
								<option value="13">Negocio Propio</option>
								<option vlaue="14">Herencia/Donación</option>
							</select>
							<label for="or">Origen de los recursos:</label>
						</div>
					</div>
					<div class="col s6">
						<div class="input-border col l12">
						<select name="dr" id="dr" required>
								<option value="0">Elija un elemento.</option>
								<option value="1">Administración de Gastos</option>
								<option value="2">Administración de Pagos de Bienes </option>
								<option value="3">Administración de Pagos de Servicios</option>
								<option value="4">Administración de Inversiones</option>
								<option value="5">Concentración y Dispersión de Fondos</option>
								<option value="6">Pago a Comisionistas</option>
								<option value="7">Pago de Renta o Compra de Bienes</option>
								<option value="8">Pago a Proveedores</option>
								<option value="9">Dispersión de Créditos</option>
								<option value="10">Pago de Nómina/Primas de Seguro</option>
								<option value="11">Impuestos/Pago de Servicios</option>
								<option value="12">Cuenta Puente Para Inversión</option>
								<option value="13">Pago Dividendos Accionistas</option>
							</select>
							<label for="dr">Destino de los recursos:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s6">
						<div class="input-border col l12">
							<select name="me" id="me" required>
								<option value="0">Elija un elemento.</option>
								<option value="1">21 a 50 %</option>
								<option value="2">Hasta 20%</option>
								<option value="3">Más de 51%</option>
								<option value="4">No Manejo Efectivo</option>
							</select>
							<label for="me">Manejo de Efectivo:</label>
						</div>
					</div>
					<div class="col s6">
						<div class="input-border col l12">
						<select name="fo" id="fo" required>
								<option value="0">Elija un elemento.</option>
								<option value="1">Manual</option>
								<option value="2">Integrado</option>
							</select>
							<label for="fo">Forma de operar:</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s10">
						<div class="input-border col l12">
							<select name="s247" id="s247" required>
								<option value="0">Elija un elemento.</option>
								<option value="1">Servicio Estándar</option>
								<option value="2">Servicio 24/7</option>
							</select>
							<label for="s247">Confirmar si desean operar con el servicio 24/ 7 (costo adicional de 1500 USD) o servicio estándar:</label>
						</div>
					</div>
					<div class="col s2">
						<div class="input-border col l12 right-align">
							<input type="submit" name="savept" id="savept" value="Guardar" class="button-gray">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal datos faltantes -->
	<div id="modal-datos-empresa" class="modal">
		<div class="modal-content">
			<h5>Datos empresa</h5>
			<div class="card-content" id="form_accionistas">
				<p>Por favor completa los datos restantes para poder activar tu cuenta</p>
			</div>
		</div>
	</div>

	<!-- Modal STP usuarios -->
	<div id="modal-usuarios-stp" class="modal">
		<div class="modal-content" id="formulario_stp_usuarios">
			<h5 class="card-title">Formato Solicitud de Servicio STP</h5>
			<p>Como parte de la solicitud de servicio STP, requerimos su apoyo para contestar el siguiente cuestionario:</p>
			<p><strong>Usuarios: Enlace Financiero</strong></p>
			<p>Por medio del presente, solicitamos se proporcionen los siguientes datos de los usuarios que tendrán acceso para operar en Enlace Financiero considerando los siguientes perfiles:</p>
			<form name="fusuariosstp" id="fusuariosstp">
				<div class="row">
					<div class="col l12">
						<table>
							<thead>
								<tr>
									<th>Nombre Completo<br />(Exactamente como en la Identificación Oficial)</th>
									<th>Correo Electrónico</th>
									<th>Fecha de Nacimiento</th>
									<th># Celular</th>
									<th>Perfil</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" name="nombre1" id="nombre1" required></td>
									<td><input type="text" name="correo1" id="correo1" required></td>
									<td><input type="date" name="fechanacimiento1" id="fechanacimiento1" required></td>
									<td><input type="text" name="celular1" id="celular1"></td>
									<td>
										<select name="perfil1" id="perfil1" required>
											<option value="0">Elija un Elemento</option>
											<option value="1">1) Administrador</option>
											<option value="2">2) Autorizador</option>
											<option value="3">3) Captura</option>
											<option value="4">4) Consulta</option>
											<option value="5">5) Consulta Históricos</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><input type="text" name="nombre2" id="nombre2" required></td>
									<td><input type="text" name="correo2" id="correo2" required></td>
									<td><input type="date" name="fechanacimiento2" id="fechanacimiento2" required></td>
									<td><input type="text" name="celular2" id="celular2" required></td>
									<td>
										<select name="perfil2" id="perfil2" required>
											<option value="0">Elija un Elemento</option>
											<option value="1">1) Administrador</option>
											<option value="2">2) Autorizador</option>
											<option value="3">3) Captura</option>
											<option value="4">4) Consulta</option>
											<option value="5">5) Consulta Históricos</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><input type="text" name="nombre3" id="nombre3"></td>
									<td><input type="text" name="correo3" id="correo3"></td>
									<td><input type="date" name="fechanacimiento3" id="fechanacimiento3"></td>
									<td><input type="text" name="celular3" id="celular3"></td>
									<td>
										<select name="perfil3" id="perfil3">
											<option value="0">Elija un Elemento</option>
											<option value="1">1) Administrador</option>
											<option value="2">2) Autorizador</option>
											<option value="3">3) Captura</option>
											<option value="4">4) Consulta</option>
											<option value="5">5) Consulta Históricos</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col l12 right-align">
						<input type="submit" name="botsaveusuariosstp" id="botsabeusuariosstp" value="Guardar" class="button-gray">
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal STP contactos -->
	<div id="modal-contactos-stp" class="modal">
		<div class="modal-content" id="formulario_stp_contactos">
			<h5 class="card-title">Formato Solicitud de Servicio STP</h5>
			<p>Como parte de la solicitud de servicio STP, requerimos su apoyo para contestar el siguiente cuestionario:</p>
			<p><strong>Contactos Autorizados</strong></p>
			<p>A continuación colocar a las personas/responsables de las áreas indicadas en los recuadros siguientes, serán los únicos autorizados para solicitar/proporcionar información relacionada con la empresa de acuerdo con su respectiva área </p>
			<form name="fcontactosstp" id="fcontactosstp">
				<div class="row">
					<div class="col s3">
						<div class="input-border col l12">
							<input type="text" name="nombre" id="nombre" required title="Exactamente como en la Identificación Oficial">
							<label for="nombre">Nombre Completo</label>
						</div>
					</div>
					<div class="col s3">
						<div class="input-border col l12">
							<input type="text" name="telefono" id="telefono" required >
							<label for="telefono">teléfono</label>
						</div>
					</div>
					<div class="col s3">
						<div class="input-border col l12">
							<input type="text" name="extension" id="extension" >
							<label for="extension">Extension</label>
						</div>
					</div>
					<div class="col s3">
						<div class="input-border col l12">
							<input type="text" name="celular" id="celular" required >
							<label for="celular">Celular</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s3">
						<div class="input-border col l12">
							<input type="text" name="correoe" id="correoe" required >
							<label for="correoe">Correo Electrónico</label>
						</div>
					</div>
					<div class="col s3">
						<div class="input-border col l12">
							<select name="area" id="area" required >
								<option value="0">Elija un elemento</option>
								<option value="1">Responsable Operativo</option>
								<option value="2">Responsable del área de sistemas</option>
								<option value="3">Responsable del área de cuentas por pagar</option>
								<option value="4">Responsable Jurídico y/o oficial de complimiento</option>
							</select>
							<label for="area">Area</label>
						</div>
					</div>
					<div class="col s6">
						<div class="input-border col l12 right-align">
							<input type="submit" name="botadcontacto" id="botadcontacto" value="Agregar Contacto" class="button-gray">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
	.card-title {
		margin-bottom: 30px !important;
		font-weight: bold !important;
	}
	
	.modal {
		max-height: 83% !important;
		width: 80% !important;
	}
	
	.h5-modular {
		line-height: 0%;
	}
	
	.btn {
		background: #444444;
	}
	
	.btn:hover {
		background: #e0e51d;
	}
	
	.especial-p {
		padding-right: 4% !important;
	}
	
	.cover {
		width: 99%;
	}
	
	input[type="file"] {
		display: none;
	}
	
	.custom-file-upload {
		color: white;
		background: #444;
		display: inline-block;
		padding: 10px 40px;
		cursor: pointer;
		border-radius: 3px !important;
	}
	
	.error-message {
		color: red;
		font-size: 10px;
		top: -25px;
		position: relative;
	}
	
	.iconoSetting {
		position: relative;
		top: 6px;
	}
	
	.linkConfiguracion {
		color: black;
	}
	
	.custom-file-upload:hover {
		border: none;
	}
	
	.cancelar:hover,
	.cancelar:focus {
		background-color: #444 !important;
	}
	
	.guardar,
	.cancelar:focus {
		background-color: #e0e51d !important;
	}
	
	]


</style>
<script>

	<?php if( $this->session->userdata('datosEmpresa')["address"] == '' OR 
				$this->session->userdata('datosEmpresa')["telephone"] == '' OR 
				$this->session->userdata('datosEmpresa')["account_clabe"] == '' OR 
				empty($this->session->userdata('datosEmpresa')["propietarioReal"]) OR
				$actac == 0 OR $constanciasf == 0 OR $comprobanted == 0 OR $identificacionrl == 0 OR 
				$escriturasp == 0 OR $efirma == 0 ) { ?>
	
	$(document).ready(function(){
		$('#modal-datos-empresa').modal('open');
	});
	
	<?php }	else if ( empty( $this->session->userdata ( 'datosEmpresa' )[ 'kyc_id' ] ) ) { ?>

	$(document).ready(function(){
		$('#modal-kyc-stp').modal('open');
	});

	<?php } else if( empty($this->session->userdata('datosEmpresa')['pt_id']) )	{ ?>
		
	$(document).ready(function(){
		$('#modal-pt-stp').modal('open');
	});

	<?php } else if( $this->session->userdata('datosEmpresa')['StpUsuarios'] < 2 )	{ ?>

	$(document).ready(function(){
		$('#modal-usuarios-stp').modal('open');
	});

	<?php } else if( $this->session->userdata('datosEmpresa')['StpContactos'] == 0 ) { ?>

	$(document).ready(function(){
		$('#modal-contactos-stp').modal('open');
	});

	<?php } ?>

function ad_acc(nombreacc, capital, tipo){
	$.ajax({
		type: 'POST',
		url : '<?php echo base_url('Proveedor/registra_accionista');?>',
		data: 'nombreacc=' + nombreacc + '&capitalsocial=' + capital + '&tipoa=' + tipo
    }).done (function ( info ){
		$('#accionistas' + tipo).html(info);
	});
}

function datos_estado(cp){
    $.ajax({
		url: "<?= base_url('perfil/estado'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_estado").html(echo);
	});

    $.ajax({
		url: "<?= base_url('perfil/municipio'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_municipio").html(echo);
	});

	$.ajax({
		url: "<?= base_url('perfil/colonia'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_colonia").html(echo);
	});
}

function datos_banco(clabe){
    $.ajax({
		url: "<?= base_url('perfil/banco'); ?>",
		type: "POST",
		data: 'clabe=' + clabe
	}).done(function(echo){
		$("#bancoemisor").html(echo);
	});
}

$("#imglogotipo").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadlogotipo"));
    $.ajax({
		url: "<?= base_url('perfil/adlogo'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#logotipo").html(echo);
	});
});

$("#actac").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadactac"));
    $.ajax({
		url: "<?= base_url('perfil/adactac'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divactac").html(echo);
	});
});

$("#escriturasp").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadescriturasp"));
    $.ajax({
		url: "<?= base_url('perfil/adescriturasp'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divescriturasp").html(echo);
	});
});

$("#poderrl").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadpoderrl"));
    $.ajax({
		url: "<?= base_url('perfil/adpoderrl'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divpoderrl").html(echo);
	});
});

$("#constanciasf").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadconstanciasf"));
    $.ajax({
		url: "<?= base_url('perfil/adconstanciasf'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divconstanciasf").html(echo);
	});
});

$("#comprobanted").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadcomprobanted"));
    $.ajax({
		url: "<?= base_url('perfil/adcomprobanted'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divcomprobanted").html(echo);
	});
});

$("#identificacionrl").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadidentificacionrl"));
    $.ajax({
		url: "<?= base_url('perfil/adidentificacionrl'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#dividentificacionrl").html(echo);
	});
});

$("#efirma").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadefirma"));
    $.ajax({
		url: "<?= base_url('perfil/adefirma'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divefirma").html(echo);
	});
});

$("#propietarior").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadpropietarior"));
    $.ajax({
		url: "<?= base_url('perfil/adpropietarior'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divpropietarior").html(echo);
	});
});

$("#fadinfopropietarior").on("submit", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fadinfopropietarior"));
    $.ajax({
		url: "<?= base_url('perfil/adinfopropietarior'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divinfopropietarior").html(echo);
	});
});

$("#documentoa").on("change", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("faddocumentoa"));
    $.ajax({
		url: "<?= base_url('perfil/addocumentoa'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#divdocumentoa").html(echo);
	});
});

$("#fkyc").on("submit", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fkyc"));
    $.ajax({
		url: "<?= base_url('perfil/savestpkyc'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#formulario_stp_kyc").html(echo);
	});
});

$("#fpt").on("submit", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fpt"));
    $.ajax({
		url: "<?= base_url('perfil/savestppt'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#formulario_stp_pt").html(echo);
	});
});

$("#fusuariosstp").on("submit", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fusuariosstp"));
    $.ajax({
		url: "<?= base_url('perfil/savestpusuarios'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#formulario_stp_ususarios").html(echo);
	});
});

$("#fcontactosstp").on("submit", function(e){
	e.preventDefault();
    var formData = new FormData(document.getElementById("fcontactosstp"));
    $.ajax({
		url: "<?= base_url('perfil/savestpcontactos'); ?>",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#formulario_stp_contactos").html(echo);
	});
});


</script>
