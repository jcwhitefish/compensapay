<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Compensapay</title>
<!-- importamos materialize usando base_url() -->
<link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>css/style.css">
</head>
<body>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <div id="app">
    <?php
    if (isset($main)) {
        echo $main;
    }
    ?>
    </div>


<!-- Ejecutor de scripts de materialize -->
<script src="<?php echo base_url();?>js/materialize.min.js"></script>
<script>  M.AutoInit();</script>

</body>
</html>
