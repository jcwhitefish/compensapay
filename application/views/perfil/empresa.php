<?php
//TODO: en todos los registros existe la clase invalid de materialize y es la que se tendrria que ocupar para poner el borde rojo se llama validate
$unique = $this->session->userdata('datosEmpresa')['unique_key'];
//var_dump($this->session->userdata('datosEmpresa'));
$urlArchivos = base_url('boveda/'.$unique.'/'.$unique.'-');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
    integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#btn-fase-1').on('click', function() {
            var bandera = false;
            var msg = '';
            var emailField = document.getElementById('emailForm');
            var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

            $(".form-1").each(function(){
                if ($(this).val() == '' ||  $(this).val() == null){
                 bandera = true;
                }
            });

            if (bandera){
               msg = "Debe llenar todos los campos para continuar."
            }

            
            if( validEmail.test(emailField.value) ){
                
            }else{
                msg += "\nEl Email no tiene un formato valido.";
            }

            if ($("#phoneForm").val().length != 10) {
                msg += "\nEl teléfono debe ser de 10 carácteres.";
            }else if(isNaN($("#phoneForm").val())){
                msg += "\nEl teléfono solo debe contener números.";
            }

            if(msg == ''){
                hideForms();
                $("#div-fase-2").show();
                $("#btn-fase-2").show();
                $("#back-fase-1").show();

            }else{
                alert (msg);
                return false;

            }       
        });

        $('#btn-fase-2').on('click', function() {
            var bandera = false;
            var msg = '';
            var emailField = document.getElementById('emailForm2');
            var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

            $(".form-2").each(function(){
                if ($(this).val() == '' ||  $(this).val() == null){
                 bandera = true;
                }
            });

            if (bandera){
               msg = "Debe llenar todos los campos para continuar."
            }

            
            if( validEmail.test(emailField.value) ){
                
            }else{
                msg += "\nEl Email no tiene un formato valido.";
            }

            if ($("#phoneForm2").val().length != 10) {
                msg += "\nEl teléfono debe ser de 10 carácteres.";
            }else if(isNaN($("#phoneForm").val())){
                msg += "\nEl teléfono solo debe contener números.";
            }

            if(msg == ''){
                hideForms();
                $("#div-fase-3").show();
                $("#btn-fase-3").show();
                $("#back-fase-2").show();

            }else{
                alert (msg);
                return false;

            }       
        });

        $('#back-fase-1').on('click', function() {
            hideForms();
            $("#div-fase-1").show();
            $("#btn-fase-1").show();
        });

        $('#back-fase-2').on('click', function() {
            hideForms();
            $("#div-fase-2").show();
            $("#btn-fase-2").show();
            $("#back-fase-1").show();
        });

        $('#back-fase-3').on('click', function() {
            hideForms();
            $("#div-fase-3").show();
            $("#btn-fase-3").show();
            $("#back-fase-2").show();

        });

        $('#cancelForm').on('click', function() {
            hideForms();
            $("#div-fase-1").show();
            $("#btn-fase-1").show();
        });


    });
    function hideForms(){
        $("#div-fase-1").hide();
        $("#div-fase-2").hide();
        $("#div-fase-3").hide();
        $("#div-fase-4").hide();
        $("#back-fase-1").hide();
        $("#back-fase-2").hide();
        $("#back-fase-3").hide();
        $("#btn-fase-1").hide();
        $("#btn-fase-2").hide();
        $("#btn-fase-3").hide();
        $("#btn-fase-4").hide();
    }
</script>

<div class="p-5" id="app">
    <div class="row">
        <div class="col l12 d-flex space-between">
            <h5 class="card-title">Registro de Empresa</h5>

            <a class="linkConfiguracion" href="<?= base_url('Configuracion'); ?>">
                Configuración
                <i class="material-icons iconoSetting">
                    settings
                </i></a>
        </div>
    </div>
    <form @submit.prevent="submitForm" method="post" action="<?php echo base_url(''); ?>" class="col l12" enctype="multipart/form-data">
        <div class="row">
            <div class="col l5 especial-p">
                <div class="row">
                    <div class="col l12" style="margin-bottom: 30px;">
                        <p class="bold">Detalles de la empresa</p>
                    </div>
                    <div class="input-border col l12">
                        <input v-model="data['bussinesName']" @blur="checkFormat('bussinesName')" :style="colorsBorder['bussinesName'] || {}" type="text" name="bussinesName" id="bussinesName" required>
                        <label for="bussinesName">Razón Social *</label>
                        <p v-if="colorsBorder['bussinesName'] && colorsBorder['bussinesName'].border === '1px solid red!important'" class="error-message">¡Razón Social inválida!</p>
                    </div>

                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['nameComercial']" @blur="checkFormat('nameComercial')" :style="colorsBorder['nameComercial'] || {}" type="text" name="nameComercial" id="nameComercial" required>
                        <label for="nameComercial">Nombre Comercial *</label>
                        <p v-if="colorsBorder['nameComercial'] && colorsBorder['nameComercial'].border === '1px solid red!important'" class="error-message">¡Nombre Comercial inválido!</p>
                    </div>
                    <div class="input-border col l6">
                        <select name="giro" id="giro" v-model="data['giro']" required>
                            <option v-for="giro in listaGiros" :key="giro.gro_id" :value="giro.gro_id">{{ giro.gro_giro }}</option>

                        </select>
                        <label for="giro">Giro *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['rfc']" @blur="checkFormat('rfc')" :style="colorsBorder['rfc'] || {}" type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}" title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
                        <label for="rfc">RFC *</label>
                        <p v-if="colorsBorder['rfc'] && colorsBorder['rfc'].border === '1px solid red!important'" class="error-message">¡RFC inválido!</p>
                    </div>
                    <div class="input-border col l6">
                        <select name="regimen" id="regimen" v-model="data['regimen']" required>
                            <option v-for="(regimen,index) in listaRegimenes" :key="regimen.rg_id" :value="regimen.rg_id">{{ regimen.rg_regimen }}</option>

                        </select>
                        <label for="regimen">Regimen Fiscal *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['codigoPostal']" @blur="checkFormat('codigoPostal')" :style="colorsBorder['codigoPostal'] || {}" type="text" name="codigoPostal" id="codigoPostal" maxlength="5" pattern="[0-9]{5}" required>
                        <label for="codigoPostal">Codigo Postal *</label>
                        <p v-if="colorsBorder['codigoPostal'] && colorsBorder['codigoPostal'].border === '1px solid red!important'" class="error-message">¡Código Postal inválido!</p>
                    </div>
                    <div class="input-border col l6">
                        <input type="text" name="estado" id="estado" disabled :placeholder="data['estado']['name']" required>
                        <label for="estado">Estado</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l12">
                        <input v-model="data['direccion']" @blur="checkFormat('direccion')" :style="colorsBorder['direccion'] || {}" type="text" name="direccion" id="direccion" required>
                        <label for="direccion">Direccion *</label>
                        <p v-if="colorsBorder['direccion'] && colorsBorder['direccion'].border === '1px solid red!important'" class="error-message">¡Direccion inválida!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l6">
                        <input v-model="data['telefono']" @blur="checkFormat('telefono')" :style="colorsBorder['telefono'] || {}" type="text" name="telefono" id="telefono" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa exactamente 10 dígitos numéricos.">
                        <label for="telefono">Telefono *</label>
                        <p v-if="colorsBorder['telefono'] && colorsBorder['telefono'].border === '1px solid red!important'" class="error-message">¡Telefono inválido!</p>
                    </div>
                </div>
            </div>
            <div class="col l4 line-card line-card-l especial-p">
                <div class="row">
                    <div class="col l12" style="margin-bottom: 30px;">
                        <p class="bold">Datos Bancarios</p>
                    </div>
                    <div class="input-border col l12">
                        <input v-model="data['clabe']" @blur="checkFormat('clabe')" :style="colorsBorder['clabe'] || {}" type="text" name="clabe" id="clabe" required pattern="[0-9]{18}" maxlength="18" title="Por favor, ingresa exactamente 18 dígitos numéricos.">
                        <label for="clabe">Cuenta CLABE *</label>
                        <p v-if="colorsBorder['clabe'] && colorsBorder['clabe'].border === '1px solid red!important'" class="error-message">¡Cuenta CLABE inválido!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-border col l12">
                        <input type="text" name="bank" id="bank" disabled :placeholder="data['bank']['bnk_alias']" required>
                        <label for="bank">Banco emisor *</label>
                    </div>
                </div>
                <div class="row" style="text-align: center;">
                    <a class="modal-trigger button-blue" href="#modal-proveedor" >
                        Registro Proveedor
                    </a>
                </div>
                
                <div v-if="false" class="row">

                    <p class="bold p-3">
                        Soy Proveedor
                    </p>
                    <div class="input-border col l12">
                        <input type="text" name="partner" id="partner" disabled>
                        <label for="partner">Cliente *</label>
                    </div>
                </div>

            </div>
            <div class="col l3 center-align">
                <div class="container">
                    <h5 class="card-title">Seleccionar logotipo</h5>
                    <img :src="imageUploadURL" alt="" style="max-width: 140px; max-height: 140px;"><br>
                    <label for="imageUpload" class="custom-file-upload p-5">
                        Seleccionar Imagen
                    </label>
                    <input @change="checkFormat('imageUpload')" ref="imageUpload" name="imageUpload" id="imageUpload" type="file" accept="image/jpeg" maxFileSize="1048576" />
                </div>
            </div>
        </div>

    <!-- Modal Registrarse como Proveedor -->
    <div id="modal-proveedor" class="modal">
        <div class="modal-content">
            <h5>Registro de Proveedor</h5>
            <div class="card esquinasRedondas">
                <div class="card-content">
                    <div name="div-fase-1" id="div-fase-1">
                        <h5 class="p-3 h5-modular">A. Informacion General</h5>
                        <div class="row">
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="bussinesName">Denominaci&oacute; o raz&oacute;n social *</label>
                                        <input class="form-1" value="<?php echo $this->session->userdata('datosEmpresa')['legal_name']  ?>" type="text" name="bussinesName" id="bussinesName">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="nationality">Nacionalidad *</label>
                                        <input class="form-1" type="text" name="nationality" id="nationality" value="Mexicana">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="folio">Número de Folio en el Registro Público de Comercio o su equivalente *</label>
                                        <input class="form-1" type="text" name="folio" id="folio" value="1457894">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="efirma">Número de certificado de firma electrónica (e firma) o su equivalente *</label>
                                        <input class="form-1" type="text" name="efirma" id="efirma" value="1457894">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col l6 cover">
                                        <label style="top:auto" for="phoneForm">Número de teléfono *</label>
                                        <input class="form-1" value="<?php echo $this->session->userdata('datosEmpresa')['telephone']  ?>" type="text" name="phoneForm" id="phoneForm">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="web">Sitio web *</label>
                                        <input class="form-1" type="text" name="web" id="web" value="http://www.drakoz.com">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="bank">Banco Emisor *</label>
                                        <input class="form-1" value="<?php echo $bank ?>" type="text" name="bank" id="bank">
                                    </div>
                                </div>
                            </div>
                            <div class="col l6 especial-p">
                                <div style="margin-top: 14px;" class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="nameComercial">Nombre Comercial *</label>
                                        <input class="form-1" value="<?php echo $this->session->userdata('datosEmpresa')['short_name']  ?>" type="text" name="nameComercial" id="nameComercial">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="dateConst">Fecha de constituci&oacute;n *</label>
                                        <input class="form-1" value="2023-11-06" max="<?= date("Y-m-d") ?>" type="date" name="dateConst" id="dateConst">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="rfc">"RFC o equivalente" *</label>
                                        <input class="form-1" value="<?php echo $this->session->userdata('datosEmpresa')['rfc']  ?>" type="text" name="rfc" id="rfc">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="dom">"Domicilio fiscal" *</label>
                                        <input class="form-1" value="<?php echo $this->session->userdata('datosEmpresa')['address']  ?>" type="text" name="dom" id="dom">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="emailForm">"Correo Electrónico" *</label>
                                        <input class="form-1" type="text" name="emailForm" id="emailForm" value="drakoz@hotmail.com">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="clabe">"Número de cuenta, CLABE" *</label>
                                        <input class="form-1" value="<?php echo $this->session->userdata('datosEmpresa')['account_clabe']  ?>" type="text" name="clabe" id="clabe">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div hidden name="div-fase-2" id="div-fase-2">
                        <h5 class="p-3 h5-modular">B. Modelo de negocio</h5>
                        <div class="row">
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="socialobj">Objeto social *</label>
                                        <textarea class="form-2" name="socialobj" id="socialobj" rows="10" cols="50" value="Lorem ipsum"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="descOperation">Describa cómo utilizara la cuenta de fondos de pago electónico para su operación *</label>
                                        <textarea class="form-2" name="descOperation" id="descOperation" rows="10" value="Lorem ipsum"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="p-3 h5-modular">C. Perfil transaccional</h5>
                        <div class="row">
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="transactMonth">Número estimado de transacciones por mes *</label>
                                        <input class="form-2" type="text" name="transactMonth" id="transactMonth" value="Lorem ipsum">
                                    </div>
                                </div>
                            </div>
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="amount">Monto promedio de transacción (MXN o USD) *</label>
                                        <input class="form-2" type="text" name="amount" id="amount" value="Lorem ipsum">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="p-3 h5-modular">D. Administración y representación legal</h5>
                        <label>Porfavor, provea la información relativa a los representantes legales, administración y principales funcionarios de la sociedad</label>
                        <div class="row">
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="charge">Cargo *</label>
                                        <input class="form-2" type="text" name="charge" id="charge" value="Lorem ipsum">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="curp">CURP *</label>
                                        <input class="form-2" type="text" name="curp" id="curp" value="Lorem ipsum">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="idNumber">Tipo y número de identificación oficial *</label>
                                        <input class="form-2" type="text" name="idNumber" id="idNumber" value="Lorem ipsum">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="emailForm2">Correo electrónico *</label>
                                        <input class="form-2" type="text" name="emailForm2" id="emailForm2" value="drakoz@hormail.com">
                                    </div>
                                </div>
                            </div>
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="name">Nombre completo *</label>
                                        <input class="form-2" type="text" name="name" id="name" value="Lorem ipsum">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="rfc">RFC *</label>
                                        <input class="form-2" type="text" name="rfc" id="rfc" value="Lorem ipsum">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="dom">Domicilio *</label>
                                        <input class="form-2" type="text" name="dom" id="dom" value="Lorem ipsum">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="phoneForm2">Numero de teléfono *</label>
                                        <input class="form-2" type="text" name="phoneForm2" id="phoneForm2" value="7754678469">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div hidden name="div-fase-3" id="div-fase-3">
                        <h5 class="p-3 h5-modular">E. Administración y representación legal</h5>
						<p>¿Existe alguna persona que directa o indirectamente ejerza control* o tenga la titularidad del 25% o mas de las acciones o partes sociales de la empresa?</p>
                        <label>
                        	<input type="radio" name="fisica" id="1" value="1" checked>
							<span>Si</span>
						</label>
						<br>
						<label>
							<input name="fisica" type="radio" />
							<span>No</span>
						</label>
                        <label>¿Existe alguna persona moral que directa o indirectamente ejerza control* o tenga la titularidad del 25% o mas de las acciones o partes sociales de la empresa?</label><br>

                        <h5 class="p-3 h5-modular">F. Estatus regulatorio y mejores prácticas</h5>
                        <label>¿La empresa requiere licencia, permiso o registro para la prestación de sus servicios?</label>

                        <label>En caso afirmativo, indicar la información siguiente:</label>
                        <div class="row">
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="supervisor">Nombre de la autoridad supervisora *</label>
                                        <input type="text" name="supervisor" id="supervisor">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="dateAward">Fecha en que fue otorgado *</label>
                                        <input type="date" name="dateAward" id="dateAward">
                                    </div>
                                </div>
                            </div>
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="typeLicense">Tipo de permiso, licencia o registro *</label>
                                        <input type="text" name="typeLicense" id="typeLicense">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label>¿La empresa ha sido auditada o sujeta a un proceso de inspección por la autoridad supervisora? En caso afirmativo, proveer detalles</label>
                        <label>¿La empresa cuenta con manuales o políticas en materia de anticorrupción?</label>
                        <label>¿La empresa cuenta con manuales o políticas en materia de protección de datos y seguridad de la información?</label>
                    </div>
                    <div hidden name="div-fase-4" id="div-fase-4">
                        <h5 class="p-3 h5-modular">G. Actividades vulnerables</h5>
                        <label>¿El giro o actividad de la empresa está regulado como actividad vulnerable?</label>
                        <label>En caso afirmativo, proporcionar la información siguiente:</label>
                        <div class="row">
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="servTrib">¿Se encuentra registrada la actividad ante el Servicio de Administración Tributaria? *</label>
                                        <input type="text" name="servTrib" id="servTrib">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col l6 especial-p">
                                <div class="row">
                                    <div class="input-border col cover">
                                        <label style="top:auto" for="obligations">¿Se encuentra a corriente en el cumplimiento de sus obligaciones en esta materia? *</label>
                                        <input type="text" name="obligations" id="obligations">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col center-align cover">
                            <a class="modal-close button-gray" name="cancelForm" id="cancelForm" style="color:#fff; color:hover:#">Cancelar</a>
                            &nbsp;
                            <button hidden class="button-blue" name="back-fase-1" id="back-fase-1" type="submit">Atrás</button>
                            <button hidden class="button-blue" name="back-fase-2" id="back-fase-2" type="submit">Atrás 2</button>
                            <button hidden class="button-blue" name="back-fase-3" id="back-fase-3" type="submit">Atrás 3</button>
                            &nbsp;
                            <button class="button-blue" name="btn-fase-1" id="btn-fase-1" type="submit">Siguiente</button>
                            <button hidden class="button-blue" name="btn-fase-2" id="btn-fase-2" type="">Siguiente</button>
                            <button hidden class="button-blue" name="btn-fase-3" id="btn-fase-3" type="">Siguiente 3</button>
                            <button hidden class="button-blue" name="btn-fase-4" id="btn-fase-4" type="">Siguiente 4</button>
                            <button hidden class="button-blue" :class="{ 'modal-close': modal-proveedor }" name="btn-fase-5" id="btn-fase-5" type="">Siguiente 5</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th>
                            <p>Documento</p>
                        </th>
                        <th>
                            <p>Archivo</p>
                        </th>
                        <th>
                            <p>Actualizar</p>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <p>Acta Constitutiva</p>
                        </td>
                        <td><a :href="actaConstitutivaUploadURL" target="_blank">{{actaConstitutivaUploadName}}</a></td>
                        <td>
                            <label for="actaConstitutivaUpload" class="custom-file-upload">Agregar</label>
                            <input @change="checkFormat('actaConstitutivaUpload')" name="actaConstitutivaUpload" ref="actaConstitutivaUpload" id="actaConstitutivaUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Constancia de Situacion Fiscal</p>
                        </td>
                        <td><a :href="csfUploadURL" target="_blank">{{csfUploadName}}</a></td>
                        <td>
                            <label for="csfUpload" class="custom-file-upload">Agregar </label>
                            <input @change="checkFormat('csfUpload')" name="csfUpload" ref="csfUpload" id="csfUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Comprobante de Domicilio</p>
                        </td>
                        <td><a :href="comprobanteDomicilioUploadURL" target="_blank">{{comprobanteDomicilioUploadName}}</a></td>
                        <td>
                            <label for="comprobanteDomicilioUpload" class="custom-file-upload">Agregar</label>
                            <input @change="checkFormat('comprobanteDomicilioUpload')" name="comprobanteDomicilioUpload" ref="comprobanteDomicilioUpload" id="comprobanteDomicilioUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Identificacion de Representante Legal</p>
                        </td>
                        <td><a :href="representanteLegalUploadURL" target="_blank">{{representanteLegalUploadName}}</a></td>
                        <td>
                            <label for="representanteLegalUpload" class="custom-file-upload">Agregar</label>
                            <input @change="checkFormat('representanteLegalUpload')" name="representanteLegalUpload" ref="representanteLegalUpload" id="representanteLegalUpload" type="file" accept="application/pdf" maxFileSize="5242880"/>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>
        <div class="row">
            <div class="col l12 right-align p-5">
                <button @click="redireccion" class="btn waves-effect waves-light cancelar" name="action">Cancelar</button>

                <button class="btn waves-effect waves-light" style="margin-left: 20px;" type="submit" name="action">Guardar</button>
            </div>
        </div>
    </form>
</div>
<script>
    const {
        createApp,
        computed,
        reactive,
        ref,
        isRef,
        onMounted,
        nextTick
    } = Vue

    const app = createApp({
        setup() {
            const data = reactive({
                bussinesName: ref('<?= $this->session->userdata('datosEmpresa')['legal_name'] ?>'),
                nameComercial: ref('<?= $this->session->userdata('datosEmpresa')['short_name'] ?>'),
                giro: ref(<?= $this->session->userdata('datosEmpresa')['id_type'] ?>),
                rfc: ref('<?= $this->session->userdata('datosEmpresa')['rfc'] ?>'),
                regimen: ref(<?= $this->session->userdata('datosEmpresa')['id_fiscal'] ?>),

                codigoPostal: ref(<?= $postal ?>),
                estado: ref({
                    id: ref(<?= $this->session->userdata('datosEmpresa')['id_country'] ?>),
                    name: ref('<?= $state ?>')
                }),
                direccion: ref('<?= $this->session->userdata('datosEmpresa')['address'] ?>'),
                telefono: ref('<?= $this->session->userdata('datosEmpresa')['telephone'] ?>'),
                clabe: ref('<?= $this->session->userdata('datosEmpresa')['account_clabe'] ?>'),
                createdat: ref('<?= $this->session->userdata('datosEmpresa')['created_at'] ?>'),
                bank: ref({
                    bnk_id: ref(<?= $this->session->userdata('datosEmpresa')['id_broadcast_bank'] ?>),
                    bnk_alias: ref('<?= $bank ?>')
                }),

                imageUpload: ref(''),
                csfUpload: ref(''),
                actaConstitutivaUpload: ref(''),
                comprobanteDomicilioUpload: ref(''),
                representanteLegalUpload: ref(''),



                uniqueString: ref('')

            });

            // partes del image
            const imageUpload = ref(null);
            const imageUploadURL = ref('<?= $urlArchivos ?>logo.jpeg');
            const colorsBorder = reactive({});
            //partes del pdf
            const csfUpload = ref(null);
            const csfUploadName = ref('constanciaSituacionFiscal.pdf');
            const csfUploadURL = ref('<?= $urlArchivos ?>constanciaSituacionFiscal.pdf');
            //partes del pdf
            const actaConstitutivaUpload = ref(null);
            const actaConstitutivaUploadName = ref('actaConstitutiva.pdf');
            const actaConstitutivaUploadURL = ref('<?= $urlArchivos ?>actaConstitutiva.pdf');
            //partes del pdf
            const comprobanteDomicilioUpload = ref(null);
            const comprobanteDomicilioUploadName = ref('comprobanteDomicilio.pdf');
            const comprobanteDomicilioUploadURL = ref('<?= $urlArchivos ?>comprobanteDomicilio.pdf');
            //partes del pdf
            const representanteLegalUpload = ref(null);
            const representanteLegalUploadName = ref('representanteLegal.pdf');
            const representanteLegalUploadURL = ref('<?= $urlArchivos ?>representanteLegal.pdf');
            //partes de listar
            const listaRegimenes = ref([]);
            const listaGiros = ref([]);
            const codigoPostalID = ref('<?= $this->session->userdata('datosEmpresa')['id_postal_code'] ?>');
            // Se pudo haber hecho con evet 
            const checkFormat = (nombreInput) => {
                if (!isRef(colorsBorder[nombreInput])) {
                    colorsBorder[nombreInput] = ref('')
                }

                switch (nombreInput) {
                    case 'telefono':
                        var patron = /[^0-9]/;
                        if (data[nombreInput] != '' && data[nombreInput].length == 10 && !patron.test(data[nombreInput])) {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'codigoPostal':
                        var patron = /[^0-9]/;
                        if (data[nombreInput] != '' && data[nombreInput].length == 5 && !patron.test(data[nombreInput])) {
                            var requestOptions = {
                                method: 'GET',
                                redirect: 'follow'
                            };

                            fetch("<?php echo base_url('herramientas/listaPostal/'); ?>" + data[nombreInput].toString(), requestOptions)
                                .then(response => response.json())
                                .then(result => {
                                    // console.log(typeof result);
                                    if (Object.keys(result).length === 0) {
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid red!important',
                                        }
                                    } else {
                                        codigoPostalID.value = result[0].zip_id;
                                        // console.log(codigoPostalID.value);
                                        data['estado']['id'] = result[0].zip_state;

                                        fetch("<?php echo base_url('herramientas/listaEstado/'); ?>" + String(data['estado']['id']), requestOptions)
                                            .then(response => response.json())
                                            .then(result => {
                                                //console.log(result);
                                                data['estado']['name'] = result[0]['stt_name'];
                                                //console.log(data['estado']['name']);
                                            })
                                            .catch(error => console.log('error', error));
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid #03BB85!important',
                                        }
                                    }
                                })
                                .catch(error => console.log('error', error));



                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'estado':
                        if (data[nombreInput] !== '') {
                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }

                        break;
                    case 'direccion':
                        if (data[nombreInput] !== '') {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }

                        break;
                    case 'bussinesName':
                        if (data[nombreInput] !== '') {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }

                        break;
                    case 'nameComercial':
                        if (data[nombreInput] !== '') {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'rfc':
                        data[nombreInput] = data[nombreInput].toUpperCase();
                        var patron = /[^A-Z0-9]/;
                        if (data[nombreInput] != '' && (data[nombreInput].length == 12 || data[nombreInput].length == 13) && !patron.test(data[nombreInput])) {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'clabe':
                        var patron = /[^0-9]/;
                        if (data[nombreInput] != '' && data[nombreInput].length == 18 && !patron.test(data[nombreInput])) {

                            //Aqui estoy
                            var requestOptions = {
                                method: 'GET',
                                redirect: 'follow'
                            };

                            fetch("<?php echo base_url('herramientas/listaBanco/'); ?>" + data[nombreInput].toString().substring(0, 3), requestOptions)
                                .then(response => response.json())
                                .then(result => {
                                    if (result.length == 0) {
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid red!important',
                                        }
                                    } else {
                                        data['bank'] = result[0];
                                        colorsBorder[nombreInput] = {
                                            border: '1px solid #03BB85!important',
                                        }
                                    }
                                })
                                .catch(error => console.log('error', error));

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'partner':
                        data[nombreInput] = data[nombreInput].toUpperCase();
                        var patron = /[^A-Z0-9]/;
                        if (data[nombreInput] != '' && (data[nombreInput].length == 12 || data[nombreInput].length == 13) && !patron.test(data[nombreInput])) {

                            colorsBorder[nombreInput] = {
                                border: '1px solid #03BB85!important',
                            }

                        } else {
                            colorsBorder[nombreInput] = {
                                border: '1px solid red!important',
                            }

                        }
                        break;
                    case 'imageUpload':
                        if (imageUpload.value.files.length == 1) {

                            if (imageUpload.value.files[0].size <= 1024 * 1024) {
                                imageUploadURL.value = URL.createObjectURL(imageUpload.value.files[0])
                                data[nombreInput] = imageUpload.value;
                                subirArchivo(data[nombreInput], 'logo')

                            } else {
                                imageUploadURL.value = '';

                            }


                        } else if (imageUpload.value.files.length == 0) {}



                        break;
                    case 'csfUpload':
                        //falta el caso en el que se tiene que vaciar la variable porque no aceptamos su archivo creo va en el else
                        if (csfUpload.value.files.length == 1) {

                            if (csfUpload.value.files[0].size <= 1024 * 1024 * 30) {

                                csfUploadURL.value = URL.createObjectURL(csfUpload.value.files[0])
                                csfUploadName.value = csfUpload.value.files[0].name;
                                data[nombreInput] = csfUpload.value;
                                subirArchivo(data[nombreInput], 'constanciaSituacionFiscal')

                            } else {
                                csfUploadName.value = '';
                            }


                        } else if (csfUpload.value.files.length == 0) {}
                        break;
                    case 'actaConstitutivaUpload':
                        if (actaConstitutivaUpload.value.files.length == 1) {

                            if (actaConstitutivaUpload.value.files[0].size <= 1024 * 1024 * 30) {
                                
                                actaConstitutivaUploadURL.value = URL.createObjectURL(actaConstitutivaUpload.value.files[0])
                                actaConstitutivaUploadName.value = actaConstitutivaUpload.value.files[0].name;
                                data[nombreInput] = actaConstitutivaUpload.value;
                                subirArchivo(data[nombreInput], 'actaConstitutiva')

                            } else {
                                actaConstitutivaUploadName.value = '';
                            }


                        } else if (actaConstitutivaUpload.value.files.length == 0) {}
                        break;
                    case 'comprobanteDomicilioUpload':
                        if (comprobanteDomicilioUpload.value.files.length == 1) {

                            if (comprobanteDomicilioUpload.value.files[0].size <= 1024 * 1024 * 30) {

                                comprobanteDomicilioUploadURL.value = URL.createObjectURL(comprobanteDomicilioUpload.value.files[0])
                                comprobanteDomicilioUploadName.value = comprobanteDomicilioUpload.value.files[0].name;
                                data[nombreInput] = comprobanteDomicilioUpload.value;
                                subirArchivo(data[nombreInput], 'comprobanteDomicilio')

                            } else {
                                comprobanteDomicilioUploadName.value = '';
                            }


                        } else if (comprobanteDomicilioUpload.value.files.length == 0) {}
                        break;
                    case 'representanteLegalUpload':
                        if (representanteLegalUpload.value.files.length == 1) {

                            if (representanteLegalUpload.value.files[0].size <= 1024 * 1024 * 30) {

                                representanteLegalUploadURL.value = URL.createObjectURL(representanteLegalUpload.value.files[0])
                                representanteLegalUploadName.value = representanteLegalUpload.value.files[0].name;
                                data[nombreInput] = representanteLegalUpload.value;
                                subirArchivo(data[nombreInput], 'representanteLegal')

                            } else {
                                representanteLegalUploadName.value = '';
                            }


                        } else if (representanteLegalUpload.value.files.length == 0) {}
                        break;
                    default:
                        // Código a ejecutar si valor no coincide con ningún caso
                }

            }

            // Hacer la solicitud Fetch a tu API
            const subirArchivo = (archivo, nombre, lugar = 0) => {
                const formData = new FormData();
                formData.append('archivo', archivo.files[0]);


                var requestOptions = {
                    method: 'POST',
                    body: formData,
                    redirect: 'follow'
                };

                fetch("<?php echo base_url('herramientas/subirArchivo/'); ?>" + data['uniqueString'] + '/' + nombre + '/' + lugar, requestOptions)
                    .then(response => response.json())
                    .then(result => {
                        /*console.log(result)*/
                    })
                    .catch(error => console.log('error', error));
            }
            const idUnico = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };
                fetch("<?php echo base_url('herramientas/idUnico'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        data['uniqueString'] = result.idUnico; // Almacenar los datos en la propiedad listaEstados
                        // console.log(data['uniqueString']);

                    });
            }
            const listarEstados = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };
                fetch("<?php echo base_url('herramientas/listaEstados'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        listaEstados.value = JSON.parse(result); // Almacenar los datos en la propiedad listaEstados
                        // console.log(listaEstados.value);
                        nextTick(() => {
                            M.FormSelect.init(document.getElementById('estado'));
                        });

                    });
            }
            const listarRegimen = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };
                fetch("<?php echo base_url('herramientas/listaRegimenes/2'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        listaRegimenes.value = result; // Almacenar los datos en la propiedad listaRegimenes
                        // console.log(listaRegimenes.value);
                        nextTick(() => {
                            M.FormSelect.init(document.getElementById('regimen'));
                        });

                    });
            }
            const listarGiro = () => {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?php echo base_url('herramientas/listaGiro'); ?>", requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        listaGiros.value = result; // Almacenar los datos en la propiedad listaRegimenes
                        //console.log(listaGiros.value);
                        nextTick(() => {
                            M.FormSelect.init(document.getElementById('giro'));
                        });

                    });
            }
            const submitForm = () => {
                // Obtén el objeto data
                const dataObject = {
                    bussinesName: data.bussinesName,
                    nameComercial: data.nameComercial,
                    codigoPostal: codigoPostalID.value,
                    estado: data.estado.id,
                    direccion: data.direccion,
                    telefono: data.telefono,
                    type: data.giro,
                    rfc: data.rfc,
                    fiscal: data.regimen,
                    clabe: data.clabe,
                    bank: data.bank.bnk_id,
                    documentos: data.uniqueString,
                };

                console.log(dataObject);

            }
            const redireccion = () => {
                window.location.replace("<?php echo base_url(''); ?>");
            }


            onMounted(
                () => {
                    idUnico();
                    listarRegimen();
                    listarGiro();
                }
            )


            return {
                data,
                colorsBorder,
                checkFormat,
                imageUpload,
                imageUploadURL,
                csfUpload,
                csfUploadName,
                csfUploadURL,
                actaConstitutivaUpload,
                actaConstitutivaUploadName,
                actaConstitutivaUploadURL,
                comprobanteDomicilioUpload,
                comprobanteDomicilioUploadName,
                comprobanteDomicilioUploadURL,
                representanteLegalUpload,
                representanteLegalUploadName,
                representanteLegalUploadURL,
                listaRegimenes,
                listaGiros,
                submitForm,
                redireccion,
                actaConstitutivaUploadURL


            }
        }
    });
</script>
<style>
    .card-title {
        margin-bottom: 30px !important;
        font-weight: bold !important;
    }

    .modal {
        max-height: 83% !important;
        width: 80% !important;
    }

    .h5-modular{
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
    .cover{
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
    }]


</style>
