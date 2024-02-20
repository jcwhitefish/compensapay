<?php
	/**
	 * @param array $args La información que será incrustada en el cuerpo del mensaje
	 * @param int   $cat  La categoría, esto elige el cuerpo y título de la notificación.
	 *
	 * @return string[] Devuelve el título y cuerpo de la notificación
	 */
	function notificationBody ( array $args, int $cat ): array {
		
		$body = $title = '';
		switch ( $cat ) {
			case 1:
				$body = "La operaci&oacute;n <strong>{$args['operationNumber']}</strong> ha sido creada por tu socio de negocios
<strong>{$args['cliente']}</strong>. Recuerda que tu socio iniciar&aacute; la operaci&oacute;n al hacer la primer transferencia.";
				$title = "Operación creada";
				break;
			case 2:
				$body = "La operaci&oacute;n <strong>{$args['opNumber']}</strong> ha sido creada, recuerda iniciar
la operaci&oacute;n transfiriendo con los siguientes detalles: <br><table><tr><td>Monto</td><td>N&uacute;mero de referencia</td>
<td>Descripci&oacute;n</td></tr><tr><td>$ {$args['inCash']}</td><td>{$args['opNumber']}</td><td>{$args['opNumber']}</td></tr></table>";
				$title = "Operación creada";
				break;
			case 3:
				$body = "Te informamos que la operaci&oacute;n <strong>{$args['opNumber']}</strong> ha sido autorizada.
<br>Te notificaremos en cuanto la operaci&oacute;n sea ejecutada.";
				$title = "Operación autorizada";
				break;
			case 4:
				$body = "Te informamos que la operación <strong>{$args['opNumber']}</strong> ha sido aprobada con éxito.
<br>Recuerda iniciar la operación transifiriendo con los siguientes detalles:
<br><table><tr><td>Monto</td><td>N&uacute;mero de referencia</td><td>Descripci&oacute;n</td><td>Clabe bancaria</td></tr>
<tr><td>$ {$args['amount']}</td><td>{$args['opNumber']}</td><td>{$args['opNumber']}</td><td>{$args['clabe']}</td>
</tr></table>";
				$title = "Operación autorizada";
				break;
			case 5:
				$body = "No se pudo procesar el pago por la operaci&oacute;n <strong>{$args['operationNumber']}</strong> debido a que ingres&oacute;
un monto diferente al de la factura: <br><table><tr><td>Monto pagado</td><td>Monto factura</td></tr><tr><td>" . ( $args[ 'data' ][ 'amount' ] / 100 ) . "</td>
<td>{$args['OpEntrty']}</td></tr></table><br>Por este motivo se le ha realizado un reembolso total de su pago, realize nuevamente la
tranferencia por el monto correcto con el siguiente n&uacute;mero de referencia y descripci&oacute;n: <br><table><tr><td>Monto</td><td>N&uacute;mero
de referencia</td><td>Descripci&oacute;n</td></tr><tr><td>$ {$args['OpEntrty']}</td><td>{$args['NewOpNumber']}</td><td>{$args['NewOpNumber']}</td>
</tr></table>";
				$title = 'Operación rechazada';
				break;
			case 6:
				$body = "Te informamos que se hizo un dep&oacute;sito a tu cuenta clabe en solve por $ {$args['amount']} MXN.
Debido a que el monto transferido no corresponde a la operaci&oacute;n <strong>{$args['operationNumber']}</strong>, se hizo la
devoluci&oacute;n del monto al cliente en su totalidad, por lo cual se ver&aacute; reflejado en tus movimientos y estados de cuenta.
<br>Estaremos enviando notificaci&oacute;n de esto a tu cliente <strong>{$args['client']}</strong> para que vuelva a hacer el pago
con los datos correctos.";
				$title = "Devolución de pago";
				break;
			case 7:
				$body = "Te informamos que la operaci&oacute;n <strong>" . $args[ 'operationNumber' ] . "</strong>. ha sido ejecutada con &eacute;xito";
				$title = 'Operación realizada';
				break;
			case 13:
				$url = base_url ( '/Conciliaciones' );
				$body = "Te informamos que la operaci&oacute;n <strong>{$args['operationNumber']}</strong> ha sido creada por tu proveedor,
es necesario validarla ingresando en el m&oacute;dulo de <strong>conciliaciones</strong> dando clic <a href='$url'>aquí</a>";
				$title = "Operación creada";
				break;
			case 100:
				$body = "Se genero una transferencia a la cuenta clabe {$args['clabe']}, por un monto de $ {$args['monto']} ";
				$title = "Transferencia realizada";
				break;
			case 101:
				$body = "Se generó una devolución por la cantidad de <strong>${$args['amount']}</strong>, en la cuenta clabe
				<strong>{$args['clabe']}</strong>, con el motivo de que no se encontró una conciliacion con el número de referencia o
				descripción con el que se hizo la transferencia.";
				$title = "Devolución por conciliación no encontrada";
				break;
		}
		return [ 'body' => $body, 'title' => $title ];
	}
