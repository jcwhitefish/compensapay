<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Compensapay</title>
    <!-- Importamos materialize usando base_url() -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/materialize.min.css">
    <!-- Importamos el estilo personalizado -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">
</head>
<body>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <div id="app">
        <?php
        if (isset($main)) {
            echo $main;
        }
        ?>
    </div>

    <!-- Formulario -->
    <div class="container">
        <div class="card">
            <div class="card-content">
                <h2 class="card-title">Registro de usuario</h2>
                <h4 class="card-title">Datos generales</h4>
                <form method="post" action="<?php echo site_url('controladorcontroller/save_xd'); ?>" class="col s12" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field col s6">
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="user" id="user" required>
                                    <label for="user">Usuario</label>
                                </div>
                                <div class="input-field col s6">
                                    <select name="profile" id="profile">
                                        <option value="perfil1">Perfil 1</option>
                                        <option value="perfil2">Perfil 2</option>
                                        <option value="perfil3">Perfil 3</option>
                                    </select>            
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="email" name="email" id="email" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="name" id="name" required>
                                    <label for="name">Nombre</label>
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" name="lastname" id="lastname" required>
                                    <label for="lastname">Apellidos</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s6 center-align">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Foto de Perfil</span>
                                    <input type="file" name="photo" id="photo">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label>
                                <input id="indeterminate-checkbox" class="filled-in" type="checkbox" />
                                <span>Enviar confirmación por correo electrónico</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 center-align">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Registrarse</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ejecutor de scripts de materialize -->
    <script src="<?php echo base_url(); ?>js/materialize.min.js"></script>
    <script>  M.AutoInit();</script>
</body>
</html>
