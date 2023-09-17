<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xml extends CI_Controller {

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
		$data['main'] = $this->load->view('xml','',true);
		$this->load->view('plantilla',$data);
	}
	public function xmlTemp(){
		// Verificar si el formulario se ha enviado y el archivo se ha subido correctamente
		if ($this->input->post('action') && isset($_FILES['xmlUpload']) && $_FILES['xmlUpload']['error'] === UPLOAD_ERR_OK) {
			// Configurar opciones de carga de archivos para XML
			$config['upload_path'] = './temporales/'; // Ruta donde se guardarán los archivos
			$config['allowed_types'] = 'xml'; // Permitir solo archivos XML
			$config['max_size'] = 1024; // Tamaño máximo en KB (2 MB)

			$this->load->library('upload', $config);

			// Realizar la carga del archivo XML
			if ($this->upload->do_upload('xmlUpload')) {
				// El archivo se cargó correctamente
				$xmlFilePath = $this->upload->data('full_path');

				// Aquí puedes procesar el contenido del archivo XML como desees
				// Por ejemplo, puedes leerlo y almacenar los datos en una variable
				$xmlContent = file_get_contents($xmlFilePath);

				// Ahora $xmlContent contiene el contenido del archivo XML

				// Puedes realizar cualquier otra acción necesaria con $xmlContent aquí

				// Redirigir o mostrar una vista con los resultados
			} else {
				// Si la carga falla, muestra un mensaje de error o realiza una acción adecuada
				$error = $this->upload->display_errors();
				echo $error;
			}
		} else {
			// Manejar el caso en el que el formulario no se haya enviado o el archivo no se haya subido
		}
	}


		// Carga tu vista o realiza cualquier otra acción necesaria aqu
}