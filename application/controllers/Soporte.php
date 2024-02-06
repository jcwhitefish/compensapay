<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soporte extends MY_Loggedin{


	/**
	 * Función index de para soporte
	 *
	 * Carga la pantalla de soporte y obtiene los datos de los tickets que ya tenga asignado el usuario
	 * con anterioridad para mostrarlos al cargar la pantalla.
	 *
	 * @return void regresa la pantalla de soporte y el historial de tickets
	 * @author Uriel Magallon <skdkuriel@hotmail.com>.
	 * @version 1.0.0
	 */
	public function index(){
		$this->load->model('Soporte_model', 'datat');
		$res = $this->datat->getModules();
		$tck = $this->datat->getTicketsFromCompanie(1);
		$dataTck['modules'] = $res;
		$dataTck['tickets'] = $tck;

		$data['main'] = $this->load->view('soporte',$dataTck, true);
		$this->load->view('plantilla', $data);
	}

	/**
	 * Obtener los subtemas para el <select> de subtemas de tickets
	 *
	 *Obtiene de desde la base de datos la lista de subtemas que puede elegir
	 * el usuario para la generación de tickets, los datos dependen del ID del módulo
	 * que se le envía por ajax y post
	 * @return true
	 * @author  Uriel Magallon <skdkuriel@hotmail.com>.
	 * @version 1.0.0
	 */
	public function getTopics(){
		$this->load->model('Soporte_model', 'datat');
		$id = $this->input->post('id', true);
		$res = $this->datat->getTopic($id);
		echo json_encode($res);
		return true;
	}

	/**
	 * Genera un nuevo ticket
	 *
	 *
	 * @return void
	 * @author  Uriel Magallon <skdkuriel@hotmail.com>.
	 * @version 1.0.0
	 */
	public function newTicket(){
		$this->load->model('Soporte_model', 'datat');
		$topic = $this->input->post('topic');
		$issue = $this->input->post('issue');
		$description = $this->input->post('description');
		$status = 1;//$this->input->post('status');
		$companie = $this->session->userdata('id');

		$args = [
			'topic' => $topic,
			'issue' => $issue,
			'description' => $description,
			'status' => $status,
			'companie' => $companie,
			'lastId' => null,
		];
		$res = $this->datat->newTicket($args);
		echo json_encode($res);
	}

	/**
	 * @return true
	 */
	public function getTickets(){
		$this->load->model('Soporte_model', 'datat');
		$id = $this->session->userdata('id');
        $tickets = $this->datat->getTicketsFromCompanie($id);
		echo json_encode($tickets);
		return true;
	}

	/**
	 * @return true
	 */
	public function getTrackingFolio(){
		$this->load->model('Soporte_model', 'datat');
		$folio = $this->input->post('folio');
		$res = $this->datat->getTickettraking($folio);
		echo json_encode($res);
		return true;
	}

	/**
	 * @return true
	 */
	public function newMssUser(){
		$this->load->model('Soporte_model', 'datat');
        $msg = $this->input->post('msg');
        $folio = $this->input->post('folio');
        $args = [
            'msg' => $msg,
            'folio' => $folio,
        ];
        $res = $this->datat->newMssUser($args);
        echo json_encode($res);
		return true;
	}

	public function seeMail(){
		$userData = ['name' => 'Uriel', 'lastName' => 'Magallon', 'company' => 'WHITEFISH SOLVE TECH'];
		$text = 'Esto es una prueba que se est&aacute; realizando para ver el funcionamiento de nuestro sistema de notificaciones por correo, Lo que se intenta es ver que el dise&ntilde;o, estructura y la informaci&oacute;n del correo lleguen de forma correcta y se muestren bien ya estando en un gestor de correos electr&oacute;nicos, <br>Por su atenci&oacute;n gracias. ';
		$urlDetail = ['url' => base_url('/soporte'), 'name' => 'Soporte'];
		$urlSoporte = ['url' => base_url('/soporte'), 'name' => base_url('/soporte')];
		$data = [
			'user' => $userData,
			'text' => $text,
			'urlDetail' => $urlDetail,
			'urlSoporte' => $urlSoporte,
		];
		$this->load->view('email/notifications', $data);
	}

	public function tryMail(){
		$this->load->helper('sendmail_helper');
		$mail       = 'ury197@hotmail.com';
		$userData = ['name' => 'Uriel', 'lastName' => 'Magallon', 'company' => 'WHITEFISH SOLVE TECH'];
		$text = 'Esto es una prueba que se est&aacute; realizando para ver el funcionamiento de nuestro sistema de notificaciones por correo,
Lo que se intenta es ver que el dise&ntilde;o, estructura y la informaci&oacute;n del correo lleguen de forma correcta y se muestren bien ya
estando en un gestor de correos electr&oacute;nicos, <br>Por su atenci&oacute;n gracias. ';
		$urlDetail = ['url' => base_url('/soporte'), 'name' => 'Soporte'];
		$urlSoporte = ['url' => base_url('/soporte'), 'name' => base_url('/soporte')];
		$data = [
			'user' => $userData,
			'text' => $text,
			'urlDetail' => $urlDetail,
			'urlSoporte' => $urlSoporte,
		];
		send_mail($mail, $data, 2, date('Y-m-d'));

	}
}
