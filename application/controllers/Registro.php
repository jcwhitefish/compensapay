<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends CI_Controller
{
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
	public function index()
	{
		//mostramos en pantalla welcome_message.php
		$this->load->view('welcome_message');
	}
	public function usuario()
	{
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('registro/usuario', '', true);
		$this->load->view('plantilla', $data);
	}
	public function empresa()
	{
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('registro/empresa', '', true);
		$this->load->view('plantilla', $data);
	}
	public function finalizado()
	{
		//mostramos en pantalla welcome_message.php
		$data['main'] = $this->load->view('registro/finalizado', '', true);
		$this->load->view('plantilla', $data);
	}
	public function usuarioUnico()
	{
		$nombre = $this->uri->segment(3);
		$data = array(
			'nombre' => $nombre,
			'email' => 'johndoe@example.com'
		);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($data));
	}
	//Nos permite ver las variables que queramos
	public function verVariables()
	{

		$bussinesName = $this->input->post('bussinesName');
		$nameComercial = $this->input->post('nameComercial');
		$rfc = $this->input->post('rfc');
		$clabe = $this->input->post('clabe');
		$bank = $this->input->post('bank');
		$imageUpload = $this->input->post('imageUpload');
		$csfUpload = $this->input->post('csfUpload');
		$actaConstitutivaUpload = $this->input->post('actaConstitutivaUpload');
		$comprobanteDomicilioUpload = $this->input->post('comprobanteDomicilioUpload');
		//creamos un data
		$data = array(
			'bussinesName' => $bussinesName,
			'nameComercial' => $nameComercial,
			'rfc' => $rfc,
			'clabe' => $clabe,
			'bank' => $bank,
			'imageUpload' => $imageUpload,
			'csfUpload' => $csfUpload,
			'actaConstitutivaUpload' => $actaConstitutivaUpload,
			'comprobanteDomicilioUpload' => $comprobanteDomicilioUpload
		);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($data));
	}
}
