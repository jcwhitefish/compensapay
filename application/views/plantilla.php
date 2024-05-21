<?php
	defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
	if ( $this->session->userdata ( 'logged_in' ) ) {
		$urlEmpresa = base_url ( 'boveda/' . $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ] . '/' . $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ] . '-' );
		$urlUsuario = base_url ( 'boveda/' . $this->session->userdata ( 'datosUsuario' )[ 'unique_key' ] . '/' . $this->session->userdata ( 'datosUsuario' )[ 'unique_key' ] . '-' );
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Solve</title>
	<!-- importamos materialize usando base_url() -->
	<link rel="stylesheet" href="<?php echo base_url ( 'assets/css/materialize.min.css' ); ?>">
	<link rel="stylesheet" href="<?php echo base_url ( 'assets/css/style.css' ); ?>">
	<!-- importamos iconos -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a5e678cc82.js" crossorigin="anonymous"></script>
	<!-- datatables -->
	<script
		src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		crossorigin="anonymous"></script>
	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
		integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" rel="stylesheet">
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
</head>
<body>
<style>
	#solveLoader {
		display: none;
		position: absolute;
		background-color: rgba(255, 255, 255, .8);
		background-image: url('/assets/images/loader.gif') !important;
		background-repeat: no-repeat;
		background-position: center;
		background-size: 200px 200px;
		top: 0;
		z-index: 999;
		transition: opacity 5s ease, visibility 5s ease;
	}
</style>
<div id="solveLoader"></div>
<!-- Cargamos VUE ya sea para servidor o local -->
<script
	src="https://unpkg.com/vue@3.3.4/dist/vue.global<?= ( $_SERVER[ 'HTTP_HOST' ] != 'localhost' && $_SERVER[ 'HTTP_HOST' ] != 'localhost:8080' ) ? '.prod' : '' ?>.js"></script>
<!-- Cargamos los scripts de Materialize -->
<script src="<?php echo base_url ( 'assets/js/materialize.min.js' ); ?>"></script>
<!-- Insertamos el nav -->
<nav class="main-nav">
	<div class="nav nav-wrapper navegador d-flex">
		<div class="d-flex justificarVertical">
			
			<img src="<?= base_url ( 'assets/images/logo_solve_2.svg' ); ?>" alt="Logo" class="nav-image">
		</div>
		
		
		<!-- If the user is log show the $navbar complements -->
		<?php if ( $this->session->userdata ( 'logged_in' ) ) : ?>
			<div class="d-flex justificarVertical">
				<!-- If the user has a photo show that if not show the name -->
				<div class="logoEmpresa d-flex justificarVertical">
					<?php if ( file_exists ( $urlEmpresa . 'logo.jpg' ) ) {
						echo '<img id="logoValidar" src="' . $urlEmpresa . 'logo.jpg" alt="Logo" class="logoEmpresa image-center hide-on-med-and-down">';
					} else {
						echo '<h6 class="nombreEmpresa hide-on-med-and-down">' . $this->session->userdata ( 'datosEmpresa' )[ 'short_name' ] . '</h6>';
					}
					?>
				
				
				</div>
			</div>
			<div class="d-flex justificarVertical" style="height: 80px!important;">
				<!--<div class="hide-on-med-and-down d-flex flex-direction-column justificarVertical">
					<p class="balance nav-max">Balance</p>
					<a class="nav-max" style="top:-25px;" href="">$200.000</a>
				</div>-->
				<div class="hide-on-med-and-down d-flex flex-direction-column justificarVertical">
					<p
						class="nav-max"
						style="padding-left:10px;top:-15px;padding-right:10px;"><?= $this->session->userdata ( 'datosUsuario' )[ 'user' ] ?></p>
				</div>
				<div class="d-flex justificarVertical alinearVertical">
					<a
						class="d-flex justificarVertical alinearVertical" href="<?= base_url ( 'perfil/usuario' ) ?>"
						target="_self" rel="noopener noreferrer">
						<img
							src="<?= $urlUsuario . 'foto.jpg' ?>" alt="Logo"
							class="custom-logo hide-on-med-and-down logoUsuario">
					</a>
				</div>
			</div>
		<?php endif; ?>
	
	
	</div>
</nav>
<?php if ( $this->session->userdata ( 'logged_in' ) ) : ?>
	<div class="sidebar center-align">
		<a href="<?= base_url ( '' ) ?>"><img
				src="<?= base_url ( 'assets/images/logo_purple_s.svg' ); ?>" alt="Logo"
				class="image-side hide-on-med-and-down"></a>
		<!--<hr class="line-side">-->
		<ul>
			<ul class="icon-list">
				<?php if (!empty($this->session->userdata('datosEmpresa')["finclabe"])  AND $this->session->userdata('pago_suscription') == 1) { ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Notificaciones"><i class="material-icons%s">notifications</i></a></li>', base_url ( 'notificaciones' ), ( strpos ( current_url (), 'notificaciones' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Inicio"><i class="material-icons%s">home</i></a></li>', base_url ( 'inicio' ), ( count ( array_intersect ( [ 'notificaciones', 'Conciliaciones', 'reportes', 'calendario', 'clientesproveedores', 'perfil', 'soporte', 'Documentos', 'Timbrado', 'Tienda', 'xml' ], explode ( '/', current_url () ) ) ) == 0 ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf (
					'<li><a href="%s" class="tooltipped dropdown-trigger" data-position="right" data-tooltip="Operaciones" data-target="dropdown1">
<i class="material-icons%s">swap_horiz</i>
</a></li>', base_url ( 'Conciliaciones' ), ( strpos ( current_url (), 'Conciliaciones' ) !== FALSE || strpos ( current_url (), 'facturas/subida' ) !== FALSE ) ? ' icon-list-hover' : '' ); ?>
				<?php echo ('<ul id="dropdown1" class="dropdown-content" style="width: 135px !important;">
  <li><a href="/Conciliaciones">Conciliación sencilla</a></li>
  <li><a href="/ConciliacionMasiva">Conciliacion masiva</a></li>
  <li><a href="/Dispersiones">Dispersión masiva</a></li></ul>');?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Documentos"><i class="material-icons%s">folder</i></a></li>', base_url ( 'Documentos' ), ( strpos ( current_url (), 'Documentos' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Timbrado"><i class="material-icons%s">description</i></a></li>', base_url ( 'Timbrado' ), ( strpos ( current_url (), 'Timbrado' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php //echo sprintf('<li><a href="%s"><i class="material-icons%s">pie_chart</i></a></li>', base_url('reportes'), (strpos(current_url(), 'reportes')) ? ' icon-list-hover' : ''); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Calendario"><i class="material-icons%s">today</i></a></li>', base_url ( 'calendario' ), ( strpos ( current_url (), 'calendario' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Socios de negocio"><i class="material-icons%s">people</i></a></li>', base_url ( 'ClientesProveedores' ), ( strpos ( current_url (), 'clientesproveedores' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Configuración"><i class="material-icons%s">settings</i></a></li>', base_url ( 'perfil/empresa' ), ( strpos ( current_url (), 'perfil/empresa' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Soporte"><i class="material-icons%s">headset_mic</i></a></li>', base_url ( 'soporte' ), ( strpos ( current_url (), 'soporte' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php echo sprintf ( '<li><a href="%s" class="tooltipped" data-position="right" data-tooltip="Tienda"><i class="material-icons%s">storefront</i></a></li>', base_url ( 'Tienda' ), ( strpos ( current_url (), 'Tienda' ) ) ? ' icon-list-hover' : '' ); ?>
				<?php } ?>
				<li><a
						href="<?= base_url ( 'logout' ); ?>" class="tooltipped" data-position="right"
						data-tooltip="Salir"><i class="material-icons">exit_to_app</i></a></li>
			</ul>
		</ul>
	</div>
<?php endif; ?>
<!-- Imprimimos el contenido -->
<?= isset( $main ) ? ( ( $this->session->userdata ( 'logged_in' ) ) ? '<div class="container-main">' . $main . '</div>' : $main ) : '' ?>


<!-- Validamos que se use app de vue entonces tenemos que ver que app no sea una etiqueta verficiando que su id no sea string si lo es, app es una etiqueta -->
<script>
	(typeof (app) == "undefined" || typeof (app.id) == "string") ? null : app.mount("#app");
</script>

<script>
	M.AutoInit();
</script>


<script>
	function cambiarVista(valor = "") {
		var requestOptions = {
			method: "GET",
			redirect: "follow"
		};
		
		fetch("<?php echo base_url ( 'herramientas/cambiarVista/' ); ?>" + valor.toString(), requestOptions)
			.then((response) => response.json())
			.then((result) => {
				// let resultado = result;
				// console.log(resultado);
				location.reload(true);
				
			})
			.catch(error => console.log("error", error));
		
		
	}
	
	<?php if ($this->session->userdata ( 'logged_in' )) { ?>
	//let miImagen = document.getElementById('logoValidar');
	//miImagen.onload = function() {
	//    //console.log('La imagen se ha cargado correctamente.');
	//    // Aquí puedes realizar acciones adicionales después de que la imagen se ha cargado.
	//};
	//
	//miImagen.onerror = function() {
	//    // console.log('Error al cargar la imagen.');
	//    // Crea un nuevo elemento 'h4'
	//    var nuevoH4 = document.createElement('h6');
	//    nuevoH4.className = 'nombreEmpresa hide-on-med-and-down'; // Agrega las clases necesarias
	//
	//    // Agrega el texto que deseas dentro del h4
	//    nuevoH4.textContent = '<?php //= $this->session->userdata('datosEmpresa')['short_name'] ?>//';
	//
	//    // Reemplaza la imagen con el nuevo h4
	//    miImagen.parentNode.replaceChild(nuevoH4, miImagen);
	//    console.log(miImagen);
	//};
	<?php } ?>

</script>
<style>
	.dropdown-content{
		min-width: 200px !important;
	}
	.nav-max {
		height: 40px !important;
		position: relative;
	}
	
	/* Styles sidebar */
	.sidebar {
		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		width: 60px;
		background-color: #333;
		color: #fff;
		z-index: 3;
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
		padding-top: 10px;
		max-width: 50px;
		max-height: 50px;
		width: auto;
		height: auto;
	}
	
	.icon-list li a:hover i {
		color: #8520ef;
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
	
	.nombreEmpresa {
		min-width: 200px;
		text-align: center;
		font-weight: bold;
	}
	
	.nav h4,
	.nav h6 {
		color: #444;
	}
	
	.nav p {
		color: #888;
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
		max-width: 60px;
	}
	
	.logoUsuario {
		width: 40px;
		height: 40px;
        border-radius: 50%;
	}
	
	.justificarVertical {
		justify-content: center;
	}
	
	.alinearVertical {
		align-items: center;
	}
	
	.balance {
		font-size: 12px;
		color: #bdbdbd;
	}
</style>
</body>
</html>
