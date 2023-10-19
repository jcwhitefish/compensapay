<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compensapay</title>
    <!-- importamos materialize usando base_url() -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/materialize.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- importamos iconos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <!-- Cargamos VUE ya sea para servidor o local -->
    <script src="https://unpkg.com/vue@3.3.4/dist/vue.global<?= ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != 'localhost:8080') ? '.prod' : '' ?>.js"></script>
    <!-- Cargamos los scripts de Materialize -->
    <script src="<?php echo base_url('assets/js/materialize.min.js'); ?>"></script>
    <!-- Insertamos el nav -->
    <nav class="main-nav">
        <div class="nav navegador d-flex">
            <div class="d-flex justificarVertical">
                <img src="<?= base_url('assets/images/CompensaPay_Logos-01.png'); ?>" alt="Logo" class="nav-image">
            </div>


            <!-- If the user is log show the $navbar complements -->
           




        </div>
    </nav>
    <!-- Imprimimos el contenido -->
    <?= isset($main) ? $main : '' ?>

    <!-- Validamos que se use app de vue entonces tenemos que ver que app no sea una etiqueta verficiando que su id no sea string si lo es, app es una etiqueta -->
    <script>
        typeof app.id == 'string' ? null : app.mount('#app');
    </script>

    <script>
        M.AutoInit();
    </script>

    <script>
        function verificarExistenciaImagen(url, callback) {
            var img = new Image();
            img.onload = function() {
                callback(true);
            };
            img.onerror = function() {
                callback(false);
            };
            img.src = url;
        }

        var urlImagen = "";

        verificarExistenciaImagen(urlImagen, function(existe) {
            let logoEmpresaDiv = document.getElementById("logoEmpresa");
            if (existe) {
                logoEmpresaDiv.innerHTML = "<img class='logoEmpresa image-center hide-on-med-and-down' src='" + urlImagen + "' alt='Imagen'> ";
            } else {
                logoEmpresaDiv.innerHTML = ' < h4 class = "image-center p-3 hide-on-med-and-down" > <?php echo 'hola' ?> < /h4>';
            }
        });
    </script>
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
            z-index: 2;
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
            border: 1px solid #e0e51d;
        }

        .image-side {
            max-width: 50px;
            max-height: 50px;
            width: auto;
            height: auto;
        }

        .icon-list li a:hover i {
            color: #e0e51d;
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
            max-width: 150px;
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

        .logoEmpresa {
            max-width: 80px;
        }

        .logoUsuario {
            max-width: 50px;
            max-height: 50px;
        }

        .justificarVertical {
            justify-content: center;
        }
        .alinearVertical {
            align-items: center;
        }
    </style>
</body>

</html>