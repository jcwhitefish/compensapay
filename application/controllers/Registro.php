<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registro extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
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
	public function empresaTemporal()
	{

		$this->form_validation->set_rules('bussinesName', 'BussinesName', 'required|regex_match[/^[A-Za-z0-9\s]+$/]');
		$this->form_validation->set_rules('nameComercial', 'NameComercial', 'required|regex_match[/^[A-Za-z0-9\s]+$/]');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('rfc', 'RFC', 'trim|required|regex_match[/^[A-Z0-9]{12,13}$/]');
		$this->form_validation->set_rules('fiscal', 'Fiscal', 'required');
		$this->form_validation->set_rules('clabe', 'CLABE', 'trim|required|regex_match[/^[0-9]{18}$/]');

		if ($this->form_validation->run() === FALSE) {
			// Si la validación falla, puedes mostrar errores o redirigir al formulario
			// redirect('controlador/metodo');
			$validation_errors = validation_errors();
			echo $validation_errors;
		} else {
			$uniqueString = uniqid();
			$config['upload_path'] = './temporales/'; // Carpeta donde se guardarán los archivos
			$config['allowed_types'] = 'png|jpg|jpeg'; // Tipos de archivos permitidos
			$config['max_size'] = 1024; // Tamaño máximo en kilobytes (1 MB)

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('imageUpload')) {
				echo $this->upload->display_errors();
				// Manejar el error de "gato", mostrarlo o redirigir al formulario de carga
			} else {
				// Subida exitosa, obten el nombre original del archivo
				$uploaded_data = $this->upload->data();
				$original_name = $uploaded_data['file_name'];
				// Renombra el archivo agregando la el stringUnico al nombre

				$new_name = $uniqueString . '-' . $original_name;
				// Mueve el archivo con el nuevo nombre al directorio de destino
				rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);
			}
			$config['allowed_types'] = 'pdf'; // Tipos de archivos permitidos
			$config['max_size'] = 0; // Sin límite de peso para "perro" y "raton"
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('csfUpload')) {
				echo $this->upload->display_errors();
			} else {
				// Subida exitosa, obten el nombre original del archivo
				$uploaded_data = $this->upload->data();
				$original_name = $uploaded_data['file_name'];
				// Renombra el archivo agregando la el stringUnico al nombre

				$new_name = $uniqueString . '-' . $original_name;
				// Mueve el archivo con el nuevo nombre al directorio de destino
				rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);
			}


			// Si la validación es exitosa, obtén los datos del formulario
			$bussinesName = $this->input->post('bussinesName');
			$nameComercial = $this->input->post('nameComercial');
			$type = $this->input->post('type');
			$rfc = $this->input->post('rfc');
			$fiscal = $this->input->post('fiscal');
			$clabe = $this->input->post('clabe');

			$bank = 'bancoAzteca';
			$data = array(
				'bussinesName' => $bussinesName,
				'nameComercial' => $nameComercial,
				'type' => $type,
				'rfc' => $rfc,
				'fiscal' => $fiscal,
				'clabe' => $clabe,
				'bank' => $bank
			);

			// Ahora puedes hacer lo que necesites con los datos

			// Por ejemplo, guardarlos en una base de datos o realizar alguna acción
			// Configura la respuesta para que sea en formato JSON
			$this->output->set_content_type('application/json');
			// Envía los datos en formato JSON
			$this->output->set_output(json_encode($data));
		}
	}
	public function catalogoBancos()
	{
		$clabe = $this->input->get('clabe');


		//llamamos la funcion que trae el banco dependiendo los 3 digitos de la clabe
		$clabe = substr(strval($clabe), 0, 3);
		//Esta es la funcion de israel
		function clabe3($clabe3)
		{
			$data['nombre'] = $clabe3;
			return json_encode($data);
		}

		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(clabe3($clabe));
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
		);
		// Configura la respuesta para que sea en formato JSON
		$this->output->set_content_type('application/json');
		// Envía los datos en formato JSON
		$this->output->set_output(json_encode($data));
	}
}
