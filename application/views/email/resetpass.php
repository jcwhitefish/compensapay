<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Notificaciones</title>
</head>
<body style="margin:0; padding:0;" class="grey darken-4">
<table style="border-collapse: unset; font-family: Arial,serif">
	<tr>
		<td style="background-color: black; text-align: center">
			<image class="center-align responsive-img" style="max-height: 75px; margin: 25px 25px;" id="imgHeader" src="https://compensapay.xyz/assets/images/solveDarkMode.svg" alt="SOLVE"></image>
		</td>
	</tr>
	<tr>
		<td><h5>Estimado <?=$user['lastName'].' '.$user['name']?>.</h5></td>
	</tr>
	<tr>
		<td><p>Te informamos que:</p></td>
	</tr>
	<tr>
		<td><?=$text?></td>
	</tr>
	<tr>
		<td><p>Por favor ingresa a <a target="_blank" href="<?=$urlDetail['url']?>"><?=$urlDetail['name']?></a> para que puedas efectuar dicho cambio</p></td>
	</tr>
	<tr>
		<td><p>Cualquier duda o comentario, no dudes en contactarnos en el módulo de atención a clientes:
			<a href="<?=$urlSoporte['url']?>" target="_blank"><?=$urlSoporte['name']?></a>
				o contáctanos por <a href="mailto:ayuda@solve.com.mx?Subject=Ayuda%20con">ayuda@solve.com.mx</a>.</p></td>
	</tr>
	<tr>
		<td>
			Atentamente,<br>Equipo Solve
		</td>
	</tr>
</table>
</body>
</html>