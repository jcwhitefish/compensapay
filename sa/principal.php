<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solve Super Admin</title>

    <!-- importamos materialize  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">

    <link rel="stylesheet" type="text/css" href="estilos/estilos.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://kit.fontawesome.com/a5e678cc82.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>

<body onload="dashboard('2023-01-01', '<?php echo date("Y-m-d");?>');">
    <nav class="main-nav">
        <div class="nav nav-wrapper navegador d-flex">
            <div class="d-flex justificarVertical">
                
            </div>
            
            <div class="d-flex justificarVertical">
                <div class="logoEmpresa d-flex justificarVertical">
                    <img id="logoValidar" src="images/logo_solve_2.png" alt="Logo" class="logoEmpresa image-center hide-on-med-and-down">
                </div>
            </div>
            <div class="d-flex justificarVertical" style="height: 80px!important;">
                <div class="hide-on-med-and-down d-flex flex-direction-column justificarVertical">
                    <p class="nav-max" style="padding-left: 10px;top:-15px"></p>
                </div>
                <div class="d-flex justificarVertical alinearVertical">
                    
                </div>
            </div>
        </div>
    </nav>
    <div class="sidebar center-align">
        <a href=""><img src="images/logo_purple_s.png" alt="Logo" class="image-side hide-on-med-and-down"></a>
        <!--<hr class="line-side">-->
        <ul>
            <ul class="icon-list">
                <li><a href="#" onclick="dashboard(document.getElementById('fechai').value, document.getElementById('fechaf').value)"><i class="material-icons">dashboard</i></a></li>
                <li><a href="%s"><i class="material-icons">warning</i></a></li>
                <li><a href="#" onclick="costos_operacion(document.getElementById('fechai').value, document.getElementById('fechaf').value)"><i class="material-icons">monetization_on</i></a></li>
                <li><a href="%s"><i class="fa-solid fa-cash-register"></i></a></li>
                <li><a href="#" onclick="tickets(document.getElementById('fechai').value, document.getElementById('fechaf').value)"><i class="material-icons">headset_mic</i></a></li>
                <li><a href="#" onclick="empresas(document.getElementById('fechai').value, document.getElementById('fechaf').value)"><i class="material-icons">business</i></a></li>
                <li><a href="#" onclick="usuarios(document.getElementById('fechai').value, document.getElementById('fechaf').value)"><i class="material-icons">people</i></a></li>
                <li><a href="#" onclick="operaciones(document.getElementById('fechai').value, document.getElementById('fechaf').value)"><i class="material-icons">swap_horiz</i></a></li>
                <li><a href="%s"><i class="fa-solid fa-clipboard-list"></i></a></li>
                <li><a href=""><i class="material-icons">exit_to_app</i></a></li>
            </ul>
        </ul>
    </div>

    <div class="contenido" id="contenido">

	</div>

	<!-- The Modal -->
    <div id="myModal" class="modal_1">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-body" id="modal-body">
    
            </div>
    
        </div>
    </div>

</body>

</html>
<script src="js/codigo.js"></script>