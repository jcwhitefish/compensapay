<?php

function send_mail($mail, $data, $view, $mailData=null, $mailFiles=null){
    $config = Array(
            'protocol'      => 'smtp',
            'smtp_host'     => 'smtp.hostinger.mx',
            'smtp_auth'     => TRUE,
            'smtp_port'     => 587,
            'smtp_user'     => 'smartrx@tratamientos.mx',
            'smtp_pass'     => 'Tratamientos2019',
            'smtp_timeout'  => '30',
            'mailpath'      => '/usr/sbin/sendmail',
            'mailtype'      => 'html', 
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            'charset'       => 'UTF-8'
    );
        $CI =& get_instance();
        $CI->load->library('email', $config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('smartrx@tratamientos.mx', 'Equipo Integramed');
        $CI->email->to($mail);   
        
        if ($view===1){
            $CI->email->subject('Por favor valide su dirección de correo');
            $html = $CI->load->view('registerMail', $data, true);
        }else if($view===2){
            $CI->email->subject('Renovar contraseña');
            $html = $CI->load->view('resetPwdMail', $data, true);
        }else if($view===3){
            $CI->email->subject('Resumen de reporte');
            $CI->email->bcc('vianey.anduaga@integramed.mx');
            $html = $CI->load->view('reportMail', $data, true);
        }else if($view===4){
            $CI->email->subject('Comentarios');
            $html = $CI->load->view('comentsMail', $data, true);
        }else if($view===5){
            $CI->email->subject('Comentarios');
            $html = $CI->load->view('mailClose', $data, true);
        }else if($view===6){
            $CI->email->subject('Bolsa de apartado');
            $html = $CI->load->view('apartadoMail', $data, true);
        }else if($view===7){
            $mailsCC=$mailData['mailsCC'];
            if ($mailData['docGender'] === 1){
                $CI->email->subject('Receta del doctor '.$mailData['docName']);
            }else{
                $CI->email->subject('Receta de la doctora '.$mailData['docName']);
            }

            $CI->email->attach($mailFiles.'.pdf');
            $CI->email->cc($mailsCC);
            $html = $CI->load->view('mailRecipie', $data, true);
        }

        $CI->email->message($html);
        $CI->email->send();
        $debug = $CI->email->print_debugger();

}