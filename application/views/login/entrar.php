<div class="p-5">
    <div class="card esquinasRedondas">
        <div class="card-content">
            <div class="row">
                <div class="col l6 center-align">
                    <img src="<?= base_url('assets/images/logo_solve_1.svg'); ?>" alt="Logo" class="custom-image">
                </div>
                <div class="col l6 p-5">
                    <form method="POST" action="<?= base_url('login/validaAcceso'); ?>">
                        <div class="container input-border">
                            <input type="text" name="user" id="user" placeholder="Usuario" required>
                            <label for="user">Usuario</label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" required>
                            <label for="password">Contraseña</label>
                            <?php if(!empty($this->session->userdata('logged_in'))){ ?>
                                <p class="error-message">¡Usuario o contraseña incorrectos!</p>
                            <?php } ?>
                        </div>
                        <?php
                        if (isset($error_message) && !empty($error_message)) {
                            echo $error_message;
                        } ?>
                        <div class="container right-align">
                            <div class="switch">
                                <label>
                                  <input type="checkbox" checked>
                                  <span class="lever"></span>
                                  Guardar datos en este equipo
                                </label>
                              </div>
                            <!--<label>
                                <input v-model="data['session']" class="filled-in" type="checkbox" />
                                <span>Guardar datos en este equipo</span>
                            </label>-->
                        </div>

                        <div class="center-align p-5">
                            <p> </p>
                        </div>

                        <div class="right-align container">
                            <button class="button-gray" type="submit">Iniciar Sesión</button>
                            <p v-if="true" class="p-1"><a href="<?= base_url('login/resetpass');  ?>"><u>Olvidé mi contraseña</u></a></p>
                            
                            <p>¿Aún no eres socio?, regístrate <a href="<?= base_url('registro/Empresa');  ?>">aquí</a></p><br>
                        </div>
                    </form>
                </div>
            </div>
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
    .error-message {
        color: red;
        font-size: 10px;
        top: -25px;
        position: relative;
    }
</style>
