<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Compensapay</title>
    <!-- importamos materialize usando base_url() -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/materialize.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- importamos iconos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <script src="https://unpkg.com/vue@3.3.4/dist/vue.global.js"></script>

        <?php
         $navbar=true;
         $sidebar=false;
         $isLog=false;

        if($navbar) {
        ?>
            <nav>
                <div class="nav nav-wrapper">
                    <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="custom-image">
                    <?php if ($isLog): ?> 
                        <?php if (true): ?>
                            <img src="<?= base_url('assets/images/CompensaPay_Logos-02.png'); ?>" alt="Logo" class="custom-image image-center hide-on-med-and-down">
                        <?php else: ?>
                            <h4 class="image-center p-3 hide-on-med-and-down">Name</h4>
                        <?php endif; ?>
                        <ul class="right hide-on-med-and-down px-3">
                            <li class=""><a href="#"><i class="material-icons p-1">notifications_none</i></a></li>
                        </ul>
                        <div class="right hide-on-med-and-down px-3">
                            <p class="right-align">Display Name</p>
                            <select name="type" id="type" class="browser-default input-nav">
                                <option value="perfil1">Vista Cliente</option>
                                <option value="perfil2">Vista Cliente 2</option>
                                <option value="perfil3">Vista Cliente 3</option>
                            </select>
                        </div>
                        <img src="<?= base_url('assets/images/CompensaPay_Logos-02.png'); ?>" alt="Logo" class="custom-image hide-on-med-and-down">
                    <?php endif; ?>
                </div>
            </nav>
        <?php
        } if($sidebar) {
        ?>
            <div class="sidebar center-align">
                <a href="#"><img src="<?= base_url('assets/images/CompensaPay_Logos-04.png'); ?>" alt="Logo" class="image-side hide-on-med-and-down"></img></a>
                <hr class="line-side">
                <ul>
                <ul class="icon-list">
                    <li><a href="#"><i class="Tiny material-icons p-1">search</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">home</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">import_export</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">pie_chart</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">mail</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">collections</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">today</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">people</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">settings</i></a></li>
                    <li><a href="#"><i class="Tiny material-icons p-1">headset_mic</i></a></li>
                </ul>
            </div>
            <div class="container-main">
        <?php
        } if (isset($main)) {
            echo $main;
        }
        if ($sidebar) {
            echo '</div>';
        }
        ?>

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
 


</body>

<style>
    /* Estilos de la barra lateral */
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
    .line-side{
        border: 1px solid #e0e51d;
    }
    .image-side{
        max-width: 50px; 
        max-height: 50px; 
        width: auto; 
        height: auto;
    }
    .icon-list li a:hover i {
        color: #e0e51d;
    }

    /* Padding si se tiene la barra lateral */
    .container-main{
        padding-left: 5% ;
        flex-grow: 1;
    }

    .nav{
        background: #fff;
        padding-left: 7% !important;
        padding-right: 7%!important;
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        margin-bottom: 0px !important;
    }

    .nav h4{
        color: #444;
    }

    .nav p{
        color: #888;
        margin: 0;
        padding: 0;
        margin-top: -15px;
    }

    .image-center{
        margin: 0 auto;
    }

    .input-nav{
        margin-top: -30px;
        border: none; 
        background-color: transparent;
    }
    .input-nav:focus {
        outline: none; /* Eliminar el borde al enfocar */
    }

    #header{
  position: fixed;
  width: 100%;
  z-index: 1000;
}

</style>

</html>