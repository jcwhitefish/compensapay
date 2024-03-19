<div class="p-5">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <h2 class="card-title">Registro de usuario</h2>
            <form class="col l12" method="POST" action="<?php echo base_url('registro/registrarCompanie'); ?>">
                <div class="row">
                    <div class="col l6 line-card-right especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Datos del usuario</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="name" id="name" class="input-name" required>
                                <label for="name">Nombre *</label>
                            </div>
                            <div class="input-border col l6">
                                <input type="text" name="lastname" id="lastname" class="input-lastname" required>
                                <label for="lastname">Apellidos *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="email" name="email" id="email" class="input-email" required>
                                <label for="email">Correo *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="email" name="validate-email" id="validate-email" class="input-validate-email" required>
                                <label for="validate-email">Confirmar Correo *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l12">
                                <input type="text" name="phone-number" id="phone-number" pattern="[0-9]{10}" minlength="10" maxlength="10">
                                <label for="phone-number">Teléfono Movil (opcional)</label>
                            </div>
                        </div>
                    </div>
                    <div class="col l6 line-card-right especial-p">
                        <div class="row">
                            <div class="col l12" style="margin-bottom: 30px;">
                                <p class="bold">Datos de la empresa</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="razonsocial" id="razonsocial" class="input-razon-social" required>
                                <label for="name">Razón Social *</label>
                            </div>
                            <div class="input-border col l6">
                                <input type="text" name="nombrecomercial" id="nombrecomercial" class="input-nombre-comercial" required>
                                <label for="lastname">Nombre Comercial *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-border col l6">
                                <input type="text" name="rfc" id="rfc" class="input-rfc" required>
                                <label for="name">RFC *</label>
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
                            <div class="right-align col l12">
                                <button class="button-gray" type="submit" name="action">Guardar</button>
                            </div>
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

    .especial-p {
        padding-right: 3% !important;
    }

    .line-card {
        border-right: 1px solid #ddd;
        height: 400;
    }

    .line-card-right {
        border-right: 1px solid #ddd;
        height: 800px;
    }
    .invalid { border-color: red; }
    .valid { border-color: green; }
</style>

<script>
// Obtener el elemento input text
var input = $(".input");

// Añadir un evento blur para detectar cuando el input pierde el foco
input.blur(function() {
  // Si el input tiene algún valor
  if (input.val() != "") {
    // Cambiar el color del borde a verde
    input.css("border-color", "green");
  }
  // Si el input no tiene ningún valor
  else {
    // Cambiar el color del borde a rojo
    input.css("border-color", "red");
  }
});


// Obtener el elemento input text
var inputn = $(".input-name");
var inputln = $(".input-lastname");
var inpute = $(".input-email");
var inputve = $(".input-validate-email");
var inputrs = $(".input-razon-social");
var inputnc = $(".input-nombre-comercial");
var inputrfc = $(".input-rfc");
//
inputn.blur(function() {if (inputn.val() != "") { inputn.css("border-color", "green"); } else { inputn.css("border-color", "red"); }});
inputln.blur(function() {if (inputln.val() != "") { inputln.css("border-color", "green"); } else { inputln.css("border-color", "red"); }});
inpute.blur(function() {if (inpute.val() != "") { inpute.css("border-color", "green"); } else { inpute.css("border-color", "red"); }});
inputve.blur(function() {if (inputve.val() == inpute.val()) { inputve.css("border-color", "green"); } else { inputve.css("border-color", "red"); }})
inputrs.blur(function() {if (inputrs.val() != "") { inputrs.css("border-color", "green"); } else { inputrs.css("border-color", "red"); }}); 
inputnc.blur(function() {if (inputnc.val() != "") { inputnc.css("border-color", "green"); } else { inputnc.css("border-color", "red"); }}); 
inputrfc.blur(function() {if (inputrfc.val() != "") { inputrfc.css("border-color", "green"); } else { inputrfc.css("border-color", "red"); }}); 

</script>