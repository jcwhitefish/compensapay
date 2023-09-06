<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
<!-- importamos materialize usando base_url() -->
<link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css">
</head>
<body>
<div class="collection">
    <a href="#!" class="collection-item"><span class="badge">1</span>Alan</a>
    <a href="#!" class="collection-item"><span class="new badge">4</span>Alan</a>
    <a href="#!" class="collection-item">Alan</a>
    <a href="#!" class="collection-item"><span class="badge">14</span>Alan</a>
  </div>

<!-- Ejecutor de scripts de materialize -->
<script src="<?php echo base_url();?>js/materialize.min.js"></script>
<script>  M.AutoInit();</script>

</body>
</html>
