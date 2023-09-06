<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Compensapay</title>
<!-- importamos materialize usando base_url() -->
<link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css">
</head>
<body>


    <?php
    if (isset($main)) {
        echo $main;
    }

    ?>


<!-- Ejecutor de scripts de materialize -->
<script src="<?php echo base_url();?>js/materialize.min.js"></script>
<script>  M.AutoInit();</script>

</body>
</html>
