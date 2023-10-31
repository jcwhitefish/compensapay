<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Solve</title>
    <!-- importamos materialize usando base_url() -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/materialize.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- importamos iconos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php if ($_SERVER['HTTP_HOST'] != 'localhost') { ?>
        <script src="https://unpkg.com/vue@3.3.4/dist/vue.global.prod.js"></script>
    <?php } else { ?>
        <script src="https://unpkg.com/vue@3.3.4/dist/vue.global.js"></script>
    <?php } ?>

    <?php

    if ($this->session->userdata('logged_in')) {
        $sidebar = true;
        $isLog = true;
    } else {
        $sidebar = false;
        $isLog = false;
    }
    ?>
    <nav>
        <div class="nav nav-wrapper navegador">
            <img src="<?= base_url('assets/images/logo_solve_2.jpg'); ?>" alt="Logo" class="nav-image">
            <!-- If the user is log show the $navbar complements -->
            <?php if ($isLog) : ?>
                <!-- If the user has a photo show that if not show the name -->
                <?php //if (true) : ?>
                    <!--<img src="<?= base_url('assets/images/trafiguraoLogo.png'); ?>" alt="Logo" class="custom-image image-center hide-on-med-and-down">-->
                <?php //else : ?>
                    <h4 class="image-center p-3 hide-on-med-and-down">&nbsp;</h4>
                <?php //endif; ?>
                <div class="right hide-on-med-and-down px-3">
                    <label class="px-3">Balance</label>
                    <p class="nav-price"><a href="">$200.000</a></p>
                </div>
                <div class="right hide-on-med-and-down px-3 d-flex flex-direction-column ">
                    <p style="padding-left: 10px;">Noe Salgado</p>
                    <select onchange="cambiarVista(this.value)" name="type" id="type" class="browser-default input-nav">
                        <!-- cliente 1 provedor 2 -->
                        <option value="1" <?= $this->session->userdata('vista') == 1 ? 'selected' : '' ?>>Vista Cliente</option>
                        <option value="2" <?= $this->session->userdata('vista') == 2 ? 'selected' : '' ?>>Vista Proveedor</option>
                    </select>
                </div>
                <img src="<?= base_url('assets/images/mark-zuckerberg-bio.png'); ?>" alt="Logo" class="custom-logo hide-on-med-and-down">
            <?php endif; ?>
        </div>
    </nav>
    <?php
    if ($sidebar) { ?>
        <div class="sidebar center-align">
            <a href="#"><img src="<?= base_url('assets/images/logo_blanco_s.png'); ?>" alt="Logo" class="image-side hide-on-med-and-down"></a>
            <!--<hr class="line-side">-->
            <ul>
                <ul class="icon-list">
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">notifications</i></a></li>', base_url('notificaciones'), (strpos(current_url(), 'notificaciones')) ? ' icon-list-hover' : ''); ?>
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">home</i></a></li>', base_url('inicio'), (count(array_intersect(['notificaciones', 'facturas', 'calendario', 'clientesproveedores', 'perfil', 'soporte', 'modelofiscal', 'xml'], explode('/', current_url()))) == 0) ? ' icon-list-hover' : ''); ?>
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">swap_horiz</i></a></li>', base_url('facturas'), (strpos(current_url(), 'facturas') !== false || strpos(current_url(), 'facturas/subida') !== false) ? ' icon-list-hover' : ''); ?>
                    <!-- <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">pie_chart</i></a></li>', base_url('xml'), (strpos(current_url(), ' ')) ? ' icon-list-hover' : ''); ?> -->
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">insert_drive_file</i></a></li>', base_url('modelofiscal'), (strpos(current_url(), 'modelofiscal')) ? ' icon-list-hover' : ''); ?>
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">today</i></a></li>', base_url('calendario'), (strpos(current_url(), 'calendario')) ? ' icon-list-hover' : ''); ?>
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">people</i></a></li>', base_url('clientesproveedores'), (strpos(current_url(), 'clientesproveedores')) ? ' icon-list-hover' : ''); ?>
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">settings</i></a></li>', base_url('perfil'), (strpos(current_url(), 'perfil')) ? ' icon-list-hover' : ''); ?>
                    <?php echo sprintf('<li><a href="%s"><i class="material-icons%s">headset_mic</i></a></li>', base_url('soporte'), (strpos(current_url(), 'soporte')) ? ' icon-list-hover' : ''); ?>
                    <li><a href="<?= base_url('logout'); ?>"><i class="material-icons">exit_to_app</i></a></li>
                </ul>
            </ul>
        </div>
        <div class="container-main">
        <?php } if (isset($main)) {
                echo $main;
            }
            if ($sidebar) {
                echo '</div>';
            } ?>
        <script>
            if (typeof app !== 'undefined') {
                app.mount('#app');
            }
        </script>
        <!-- Ejecutor de scripts de materialize -->
        <script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
        <script>
            function cambiarVista(valor = '') {
                var requestOptions = {
                    method: 'GET',
                    redirect: 'follow'
                };

                fetch("<?php echo base_url('herramientas/cambiarVista/'); ?>" + valor.toString() , requestOptions)
                    .then((response) => response.json())
                    .then((result) => {
                        // let resultado = result;
                        // console.log(resultado);
                        location.reload(true);

                    })
                    .catch(error => console.log('error', error));


            }
        </script>
</body>

<style>
    /* Styles sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        width: 60px;
        background-color: #333;
        color: #fff;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        padding: 10px;
    }

    .sidebar a {
        text-decoration: none;
        color: #fff;
    }

    .line-side {
        border: 1px solid #8127ff;
    }

    .image-side {
        max-width: 40px;
        max-height: 40px;
        width: auto;
        height: auto;
        margin-top: 10px;
    }

    .icon-list li a:hover i {
        color: #8127ff;
    }

    .icon-list-hover {
        color: #444;
        background-color: #fff;
        border-radius: 60%;
        padding: 5px;
    }

    /* Styles navbar */

    .nav {
        background: #fff;
        padding-left: 7% !important;
        padding-right: 7% !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0px !important;
    }

    .nav h4 {
        color: #444;
    }

    .nav p {
        color: #888;
        margin: 0;
        padding: 0;
        margin-top: -15px;
    }

    .nav-price {
        margin: 0 !important;
        padding: 5px !important;
        margin-top: -45px !important;
    }

    .nav-image {
        height: 40px;
    }

    .image-center {
        margin: 0 auto;
    }

    .input-nav {
        margin-top: -30px;
        border: none;
        background-color: transparent;
    }

    .input-nav:focus {
        outline: none;
        /* Eliminar el borde al enfocar */
    }

    /* Padding si se tiene la barra lateral */
    .container-main {
        padding-left: 5%;
        flex-grow: 1;
    }

    #header {
        position: fixed;
        width: 100%;
        z-index: 1000;
    }
</style>

</html>