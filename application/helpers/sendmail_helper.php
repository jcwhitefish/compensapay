<?php
/**
 * Función para poder enviar correos electrónicos generados con estructura html
 * @param string|array      $mail    Correo o correos destinatarios
 * @param array             $data    Arreglo con la información para complementar el correo
 * @param int               $view    Permite seleccionar el correo (tipo / vista) que se enviara
 * @param string|array|null $cc      Opcional | Correo o correos para enviar con copia
 * @param string|null       $subject Opcional | El asunto del correo
 * @return array Devuelve el resultado del envío de correo
 */
function send_mail(string|array $mail, array $data, int $view,
				   string|array$cc = null, string $subject = null): array
{
	//Se crea la configuración básica del correo de envío.
    $config = Array(
            'protocol'      => 'SMTP',
            'smtp_host'     => 'smtpout.secureserver.net ',
            'smtp_auth'     => TRUE,
            'smtp_port'     => 465,
            'smtp_user'     => 'hola@compensapay.xyz',
            'smtp_pass'     => 'compensamail2023#',
            'smtp_timeout'  => '30',
            'mailtype'      => 'html',
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            'charset'       => 'UTF-8',
        );
	//Se carga la configuración y se empieza a crear el correo
	$CI =& get_instance();
	$CI->load->library('email', $config); //Se carga la libreria de correo
	$CI->email->set_newline("\r\n");
	$CI->email->from('hola@compensapay.xyz', 'Equipo Solve'); //Esto es lo que se mostrara como información de remitente
	$CI->email->set_newline("\r\n");
	$CI->email->to($mail); //Se agrega el/los correos destinatarios
	$CI->email->set_newline("\r\n");
	$html = '';
	//Se selecciona el tipo de correo que se enviara.
	if($view===1){
		$CI->email->subject('Prueba envio de correos'); //Se escribe el asunto del correo
		$CI->email->attach($data['registro']); //Esto permite adjuntar un archivo
		$CI->email->attach(__DIR__ . '\/../../boveda/'. $data['uuid'] .'/'. $data['uuid'] .'-actaConstitutiva.pdf');
		$CI->email->attach(__DIR__ . '\/../../boveda/'. $data['uuid'] .'/'. $data['uuid'] .'-comprobanteDomicilio.pdf');
		$CI->email->attach(__DIR__ . '\/../../boveda/'. $data['uuid'] .'/'. $data['uuid'] .'-constanciaSituacionFiscal.pdf');
		$CI->email->attach(__DIR__ . '\/../../boveda/'. $data['uuid'] .'/'. $data['uuid'] .'-representanteLegal.pdf');
		$html = $CI->load->view('email/mailSupplier', $data, true);//Así se crea el cuerpo del correo, se añade además la información
	}else if ($view===2){
		$CI->email->subject('Notificación: '.$subject);
		$html = $CI->load->view('email/notifications', $data, true);
		$CI->email->set_newline("\r\n");
	}
	else if($view===3){
		$CI->email->subject('Cambio de contraseña ');
		$html = $CI->load->view('email/resetpass', $data, true);
	}
	//se añaden los destinatarios copiados si existen
	if($cc != null){
		$CI->email->cc($cc);
		$CI->email->set_newline("\r\n");
	}
	//Se termina de crear el correo
	$CI->email->message($html); //Carga el cuerpo al correo
	$CI->email->set_newline("\r\n");
	$CI->email->send(); //Realiza el intento de envío de correo
	return ['result' => $CI->email->print_debugger()]; //Devuelve el resultado del intento de envío
}
