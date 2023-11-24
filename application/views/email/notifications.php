<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notificaciones</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body style="margin:0; padding:0;" class="grey darken-4">
<table class=" grey darken-4 white-text" style="border-collapse: unset">
	<tr>
		<td class="black center-align">
			<image class="center-align responsive-img" style="max-height: 75px; margin: 25px 25px;" id="imgHeader" src="/assets/images/solveDarkMode.svg" alt="SOLVE"></image>
		</td>
	</tr>
	<tr>
		<td><h5>Estimado <?=$user['lastName'].' '.$user['name']?>, de la empresa <?=$user['company']?>.</h5></td>
	</tr>
	<tr>
		<td>Te informamos que:</td>
	</tr>
	<tr>
		<td><?=$text?></td>
	</tr>
	<tr>
		<td>Para más detalles ingresa con tu cuenta a  nuestra plataforma en <a target="_blank" href="<?=$urlDetail['url']?>"><?=$urlDetail['name']?></a></td>
	</tr>
	<tr>
		<td>Cualquier duda o comentario, no dudes en contactarnos en el módulo de atención a clientes:
			<a href="<?=$urlSoporte['url']?>" target="_blank"><?=$urlSoporte['name']?></a>
			o contáctanos por <a href="mailto:ayuda@solve.com.mx?Subject=Ayuda%20con">ayuda@solve.com.mx</a>.</td>
	</tr>
	<tr>
		<td>
			Atentamente,<br>Equipo Solve
		</td>
	</tr>
</table>
</body>
</html>
