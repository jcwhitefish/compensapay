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
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

        <?php
         $navbar1=true;
         $navbar2=false;
         $sidebar=true;

        if ($navbar1) {
        ?>
            <nav class="hide-on-small-only">
                <div class="nav-wrapperxd nav">
                    <a href="#" class="bold">@Your Company</a>
                    <div class="right hide-on-med-and-down px-3">
                        <button class="button-gray">Sign Up</button>
                        <button class="button-white">Login In</button>
                    </div>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Pages</a></li>
                    </ul>

                </div>
            </nav>
        <?php
        } if($navbar2) {
        ?>
            <nav class="hide-on-small-only">
                <div class="nav-wrapper nav-gray">
                    <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="custom-image">
                </div>
            </nav>
        <?php
        } if($sidebar) {
        ?>
            <div class="sidebar center-align">
                <a href="#"><img src="<?= base_url('assets/images/CompensaPay_Logos-04.png'); ?>" alt="Logo" class="image-side"></img></a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let prevScrollPos = window.pageYOffset;
            let isScrollingUp = false;
            let isAnimating = false;
            let scrollThreshold = 20; // Ajusta este valor según tus necesidades
            let nav = document.querySelector('nav.hide-on-small-only');

            function toggleNavVisibility() {
                isAnimating = true;

                if (isScrollingUp) {
                    nav.classList.remove('hide');
                } else {
                    nav.classList.add('hide');
                }

                setTimeout(function() {
                    isAnimating = false;
                }, 300); // Puedes ajustar la duración de la animación

                prevScrollPos = window.pageYOffset;
            }

            window.addEventListener('scroll', function() {
                const currentScrollPos = window.pageYOffset;

                if (Math.abs(currentScrollPos - prevScrollPos) >= scrollThreshold && !isAnimating) {
                    if (currentScrollPos > prevScrollPos) {
                        // Desplazamiento hacia abajo: ocultar la barra de navegación
                        isScrollingUp = false;
                        toggleNavVisibility();
                    } else {
                        // Desplazamiento hacia arriba: mostrar la barra de navegación
                        isScrollingUp = true;
                        toggleNavVisibility();
                    }
                }
            });

        });

    </script>

 


</body>

<style>
    /* Estilo de la barra lateral */
.sidebar {
    position: fixed;                                                                                                           
    top: 0;
    bottom: 0;
    left: 0;
    width: 4.5%; 
    background-color: #333;
    z-index: 10000; 
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

.container-main{
    padding-left: 5% ;
    flex-grow: 1;
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
    color: #e0e51d; /* Cambia el color a amarillo al pasar el cursor */
}



</style>

</html>