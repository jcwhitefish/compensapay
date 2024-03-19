<?php
//TODO: en todos los registros existe la clase invalid de materialize y es la que se tendrria que ocupar para poner el borde rojo se llama validate
?>
<div class="p-5">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title">Registro de Empresa</h2>
            <form method="post" action="<?php echo base_url('registro/empresaTemporal'); ?>" class="col l12" enctype="multipart/form-data" onsubmit="return validar()">
                <div class="row">
                    <div class="col l5 especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Detalles de la empresa</p>
                            </div>
                            <div class="input-border col l12">
                                <input type="text" name="bussinesName" id="bussinesName" required>
                                <label for="bussinesName">Razón Social *</label>
                                <p class="error-message">¡Razón Social inválida!</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="text" name="nameComercial" id="nameComercial" required>
                                <label for="nameComercial">Nombre Comercial *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="rfc" id="rfc" minlength="12" maxlength="13" pattern="[A-Z0-9]{12,13}" title="Debe tener de 12 a 13 caracteres alfanuméricos" required>
                                <label for="rfc">RFC *</label>
                                <p class="error-message">¡RFC inválido!</p>
                            </div>
                            <div class="input-border col l6">
                                <select name="regimen" id="regimen" required>
                                    <?php
                                        if(is_array($detalles["regimenfiscal"])) {
                                            foreach($detalles["regimenfiscal"] AS $value) {
                                                echo '<option value="'.$value["rg_id"].'">'.$value["rg_clave"].' - '.$value["rg_regimen"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <label for="regimen">Regimen Fiscal *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="codigoPostal" id="codigoPostal" maxlength="5" pattern="[0-9]{5}" required onchange="datos_estado(this.value)">
                                <label for="codigoPostal">Codigo Postal *</label>
                                <p class="error-message">¡Código Postal inválido!</p>
                            </div>
                            <div class="input-border col l6" id="nombre_estado">
                                <input type="text" name="estado" id="estado" disabled required>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="text" name="direccion" id="direccion" required>
                                <label for="direccion">Direccion *</label>
                                <p class="error-message">¡Direccion inválida!</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="telefono" id="telefono" required pattern="[0-9]{10}" maxlength="10" title="Por favor, ingresa exactamente 10 dígitos numéricos.">
                                <label for="telefono">Telefono *</label>
                                <p class="error-message">¡Telefono inválido!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col l4 line-card line-card-l especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Datos Bancarios</p>
                            </div>
                            <div class="input-border col l12">
                                <input type="text" name="clabe" id="clabe" required pattern="[0-9]{18}" maxlength="18" title="Por favor, ingresa exactamente 18 dígitos numéricos." onchange="datos_banco(this.value)">
                                <label for="clabe">Cuenta CLABE *</label>
                                <p class="error-message">¡Cuenta CLABE inválido!</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12" id="bancoemisor">
                                <input type="text" name="bank" id="bank" disabled required>
                                <label for="bank">Banco emisor *</label>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col l12" style="margin-bottom: 30px;">
                                <p>Número de días en los que se pagará la factura una vez recibida en la plataforma. (Puede personalizar los datos por proveedor posteriormente en el apartado de configuración avanzada).</p>
                            </div>
                            <div class="input-border col l12">
                                <input value="45" type="number" name="diaspago" id="diaspago" required pattern="[0-9]{3}" maxlength="3" required>
                            </div>
                        </div>
                        <div class="row">
                            
                        </div>
                    </div>
                    <div class="col l3 center-align">
                        <div class="container">
                            <h2 class="card-title">Seleccionar logotipo</h2>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg" id="img" alt="" style="max-width: 140px; height: 140px;"><br>
                            <label for="imageUpload" class=" p-5 button-gray">
                                Seleccionar Imagen
                            </label>
                            <input ref="imageUpload" name="imageUpload" id="imageUpload" type="file" accept="image/jpeg" maxFileSize="1048576" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l12 ">
                        <div class="col l12">
                            <p class="bold">Sube tus documentos</p><br>
                        </div>
                    
                        <div class="row">
                            <div class="col l12">
                                <label for="csfUpload" class="filupp">
                                    <span class="filupp-file-name c-s-f">Constancia de Situación Fiscal *</span>
                                    <input type="file" name="csfUpload" accept=".pdf" id="csfUpload" class=".pdf"/>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col l12">
                                <label for="actaConstitutivaUpload" class="filupp">
                                    <span class="filupp-file-name a-c">Acta Constitutiva *</span>
                                    <input type="file" name="actaConstitutivaUpload" accept=".pdf" id="actaConstitutivaUpload" class=".pdf"/>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col l12">
                                <label for="comprobanteDomicilioUpload" class="filupp">
                                    <span class="filupp-file-name c-d">Comprobante de Domicilio *</span>
                                    <input type="file" name="comprobanteDomicilioUpload" accept=".pdf" id="comprobanteDomicilioUpload" class=".pdf"/>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col l12">
                                <label for="representanteLegalUpload" class="filupp">
                                    <span class="filupp-file-name r-l">Identificacion de Representante Legal *</span>
                                    <input type="file" name="representanteLegalUpload" accept=".pdf" id="representanteLegalUpload" class=".pdf"/>
                                </label>
                            </div>
                        </div>

                        <!--<div class="col l9 input-border">
                            <input type="text" name="cSfDisabled" id="cSfDisabled" disabled>
                            <label for="cSfDisabled"> Constancia de Situación Fiscal *</label>
                        </div>
                        <div class="col l3 center-align p-5">
                            <label for="csfUpload" class="button-gray">Agregar </label>
                            <input name="csfUpload" ref="csfUpload" id="csfUpload" type="file" accept="application/pdf" maxFileSize="5242880" value="" required />
                        </div>
                        <div class="col l9 input-border">
                            <input type="text" name="actaConstitutivaDisabled" id="actaConstitutivaDisabled" disabled :value="actaConstitutivaUploadName">
                            <label for="actaConstitutivaDisabled">Acta Constitutiva *</label>
                        </div>
                        <div class="col l3 center-align p-5">
                            <label for="actaConstitutivaUpload" class="button-gray">Agregar</label>
                            <input @change="checkFormat('actaConstitutivaUpload')" name="actaConstitutivaUpload" ref="actaConstitutivaUpload" id="actaConstitutivaUpload" type="file" accept="application/pdf" maxFileSize="5242880" required />
                        </div>
                        <div class="col l9 input-border">
                            <input type="text" name="comprobanteDomicilioDisabled" id="comprobanteDomicilioDisabled" disabled :value="comprobanteDomicilioUploadName">
                            <label for="comprobanteDomicilioDisabled">Comprobante de Domicilio *</label>
                        </div>
                        <div class="col l3 center-align p-5">
                            <label for="comprobanteDomicilioUpload" class="button-gray">Agregar</label>
                            <input @change="checkFormat('comprobanteDomicilioUpload')" name="comprobanteDomicilioUpload" ref="comprobanteDomicilioUpload" id="comprobanteDomicilioUpload" type="file" accept="application/pdf" maxFileSize="5242880" required />
                        </div>
                        <div class="col l9 input-border">
                            <input type="text" name="representanteLegalDisabled" id="representanteLegalDisabled" disabled :value="representanteLegalUploadName">
                            <label for="representanteLegalDisabled">Identificacion de Representante Legal *</label>
                        </div>
                        <div class="col l3 center-align p-5">
                            <label for="representanteLegalUpload" class="button-gray">Agregar</label>
                            <input @change="checkFormat('representanteLegalUpload')" name="representanteLegalUpload" ref="representanteLegalUpload" id="representanteLegalUpload" type="file" accept="application/pdf" maxFileSize="5242880" required />
                        </div>-->
                    </div>
                    <div class="col l12 right-align p-5">
                        <button class="button-gray waves-effect waves-light" type="submit" name="action">Siguiente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>
<style>
    .card-title {
        margin-bottom: 30px !important;
        font-weight: bold !important;
    }

    /*.btn {
        background: #444444;
    }

    .btn:hover {
        background: #e0e51d;
    }*/

    .especial-p {
        padding-right: 4% !important;
    }

    /*input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        color: white;
        background: #444;
        display: inline-block;
        padding: 10px 40px;
        cursor: pointer;
        border-radius: 3px !important;
    }*/

    .error-message {
        color: red;
        font-size: 10px;
        top: -25px;
        position: relative;
        display: none;
    }

    .filupp-file-name {
    width: 75%;
    display: inline-block;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    word-wrap: normal;
    }   
    .filupp {
    position: relative;
    background: #f7f7f7;
    display: block;
    padding: 1em;
    font-size: 1em;
    width: 100%;
    height: 3.5em;
    color: #9118bd;
    cursor: pointer;
    }
    input[type="file"] {
    width: 100%;
    height: 35px;
    border: 0px solid;
    font-family: 'Roboto', sans-serif;
    font-size: 13px;
    color: #9118bd;
    font-weight: bold;
    background: #f7f7f7;
    padding-left: 10px;
    border-radius: 5px;
    }
    .filupp:after {
    font-family: 'FontAwesome';
    content: "\f093";
    position: absolute;
    top: 0.85em;
    right: 0.45em;
    font-size: 2em;
    color: #9118bd;
    line-height: 0;
}
</style>

<script>
//funciones input constancia situación fiscal
$(document).on('change','.pdf',function(){
	// this.files[0].size recupera el tamaño del archivo
	// alert(this.files[0].size);
	
	var fileName = this.files[0].name;
	var fileSize = this.files[0].size;

	if(fileSize > 2000000){
		alert('El archivo no debe superar los 2MB');
		this.value = '';
		this.files[0].name = '';
	}else {
		// recuperamos la extensión del archivo
		var ext = fileName.split('.').pop();
		
		// Convertimos en minúscula porque 
		// la extensión del archivo puede estar en mayúscula
		ext = ext.toLowerCase();
    
		// console.log(ext);
		switch (ext) {
			case 'pdf': break;
			default:
				alert('El archivo no tiene la extensión adecuada');
				this.value = ''; // reset del valor
				this.files[0].name = '';
		}
	}
});


$(document).ready(function() {

    // get the name of uploaded file
    $('#csfUpload').change(function(){
        var nombreConRuta1 = $("#csfUpload").val();
        var arreglo1 = nombreConRuta1.split("\\");
        var nombreSinRuta1 = arreglo1.pop();
        $('.c-s-f').text(nombreSinRuta1);
    });
    $('#actaConstitutivaUpload').change(function(){
        var nombreConRuta2 = $("#actaConstitutivaUpload").val();
        var arreglo2 = nombreConRuta2.split("\\");
        var nombreSinRuta2 = arreglo2.pop();
        $('.a-c').text(nombreSinRuta2);
    });
    $('#comprobanteDomicilioUpload').change(function(){
        var nombreConRuta3 = $("#comprobanteDomicilioUpload").val();
        var arreglo3 = nombreConRuta3.split("\\");
        var nombreSinRuta3 = arreglo3.pop();
        $('.c-d').text(nombreSinRuta3);
    });
    $('#representanteLegalUpload').change(function(){
        var nombreConRuta4 = $("#representanteLegalUpload").val();
        var arreglo4 = nombreConRuta4.split("\\");
        var nombreSinRuta4 = arreglo4.pop();
        $('.r-l').text(nombreSinRuta4);
    });
    

});

const defaultimage = 'https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg';
const imagen = document.getElementById('imageUpload');
const img = document.getElementById('img');
imagen.addEventListener('change', e => {
    if (e.target.files[0]){
        const reader = new FileReader();
        reader.onload = function (e){
            img.src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);
    }
    else {
        img.src = defaultimage;
    }
})

function datos_estado(cp){
    $.ajax({
		url: "<?= base_url('Registro/estado'); ?>",
		type: "POST",
		data: 'codigopostal=' + cp
	}).done(function(echo){
		$("#nombre_estado").html(echo);
	});
}

function datos_banco(clabe){
    $.ajax({
		url: "<?= base_url('Registro/banco'); ?>",
		type: "POST",
		data: 'clabe=' + clabe
	}).done(function(echo){
		$("#bancoemisor").html(echo);
	});
}

function validar() {
        
    bussinesName = document.getElementById("bussinesName").value;
    nameComercial = document.getElementById("nameComercial").value;
    giro = document.getElementById("giro").value;
    rfc = document.getElementById("rfc").value;
    regimen = document.getElementById("regimen").value;
    codigoPostal = document.getElementById("codigoPostal").value;
    direccion = document.getElementById("direccion").value;
    telefono = document.getElementById("telefono").value;
    clabe = document.getElementById("clabe").value;
    
    if (bussinesName.length == 0) {
        document.getElementById(bussinesName).focus();
        return false;
    }
    else if(nameComercial.length == 0){
        document.getElementById(nameComercial).focus();
        return false;
    }
    else if(giro.lenght == 0){
        document.getElementById(giro).focus();
        return false;
    }
    else if(rfc.length == 0){
        document.getElementById(rfc).focus();
        return false;
    }
    else if(regimen.length == 0){
        document.getElementById(regimen).focus();
        return false;
    }
    else if(codigoPostal.length == 0){
        document.getElementById(codigoPostal).focus();
        return false;
    }
    else if(direccion.length == 0){
        document.getElementById(direccion).focus();
        return false;
    }
    else if(telefono.length == 0){
        document.getElementById(telefono).focus();
        return false;
    }
    else if(clabe.length == 0){
        document.getElementById(clabe).focus();
        return false;
    }
    else{
         return true;
    }
   
}
</script>