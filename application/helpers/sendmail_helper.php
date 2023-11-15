<?php

function send_mail($mail, $data, $view, $date=null){
    if ($date === null){
        $date = date('Y-m-d');
    }
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

        $CI =& get_instance();
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('hola@compensapay.xyz', 'Equipo Solve');
	$CI->email->set_newline("\r\n");
        $CI->email->to($mail);

        if($view===1){
			$CI->email->set_newline("\r\n");
            $CI->email->subject('Prueba envio de correos');
//            $CI->email->attach('FarmaListo '.$date.'.xlsx');
//            $CI->email->attach('SanPablo '.$date.'.xlsx');
            //$CI->email->attach('Rappi '.$date.'.xlsx');
//            $CI->email->cc( array('cecilia.tornel@integramed.mx','oscar.velazquez@integramed.mx','uriel.magallon@integramed.mx','vianey.anduaga@integramed.mx'));
            $html = $CI->load->view('mailReport', $data, true);
        }
		$CI->email->set_newline("\r\n");
        $CI->email->message($html);
		$CI->email->set_newline("\r\n");
        $CI->email->send();
        $debug = $CI->email->print_debugger();
		var_dump($debug);
}
