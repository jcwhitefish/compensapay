<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soporte extends MY_Loggedin{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
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

	public function getTopics(){
		$this->load->model('Soporte_model', 'datat');
		$id = $this->input->post('id', true);
//        var_dump($id);
		$res = $this->datat->getTopic($id);
//        var_dump($res);
		echo json_encode($res);
		return true;
	}

	public function newTicket(){
		$this->load->model('Soporte_model', 'datat');
		$topic = $this->input->post('topic');
		$issue = $this->input->post('issue');
		$description = $this->input->post('description');
		$status = 1;//$this->input->post('status');
		$companie = $this->session->userdata('idPersona');

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

	public function getTickets(){
		$this->load->model('Soporte_model', 'datat');
		$id = $this->session->userdata('id');
        $tickets = $this->datat->getTicketsFromCompanie($id);
		echo json_encode($tickets);
		return true;
	}
}
