<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends MY_Loggedin
{
	public function __construct()
	{
		parent::__construct();

		// Cargar la biblioteca de sesión
		$this->load->library('session');
		//Cargamos modelo de postal
		$this->load->model('postal_model');
		//Cargamos modelo de state
		$this->load->model('state_model');	
		//Cargamos modelo de banco
		$this->load->model('bank_model');
		//cargamos modelo de perfil
		$this->load->model('perfil_model');
		//cargamos modelo de registro
		$this->load->model('registro_model');
		
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
		//Obtenermos los datos de datosEmpresa y los enviamos al front

		$data['main'] = $this->load->view('perfil/empresa', '', true);

		$this->load->view('plantilla', $data);

	}
	public function empresa()
	{
		//Obtenermos los datos de datosEmpresa y los enviamos al front

		$data['empresa'] = $this->perfil_model->empresa();
		$data['detalles'] = $this->registro_model->detalles();
		
		if($this->session->userdata('datosEmpresa')['id_postal_code']!=0)
		{
			$idPostal  = $this->session->userdata('datosEmpresa')['id_postal_code'];
			$data['postal'] = $this->postalCodebyId($idPostal);
		}

		if($this->session->userdata('datosEmpresa')['id_country']!=0)
		{
			$idState  = $this->session->userdata('datosEmpresa')['id_country'];
			$data['state'] = $this->stateCodebyId($idState);
		}
		
		if($this->session->userdata('datosEmpresa')['account_clabe']!=NULL)
		{
			//De clabe lo convertimos a string y solo obtenemos las primeras 3 letras para el banco 
			$clabe  = $this->session->userdata('datosEmpresa')['account_clabe'];
			// convertimos a string
			$clabe = strval($clabe);
			$data['bank'] = $this->bankCode(substr($clabe, 0, 3));
		}
		
		$data['main'] = $this->load->view('perfil/empresa', $data, true);
		$this->load->view('plantilla', $data);


	}
	public function usuario()
	{
		//Obtenermos los datos de datosEmpresa y los enviamos al front
		$this->load->model('user_model', 'dataUsr');
		$id = $this->session->userdata('id');
		$usr['usuario'] = $this->dataUsr->get_userById($id);
		$data['usuario'] = $this->dataUsr->get_userById($id);
		$data['main'] = $this->load->view('perfil/usuario', $usr, true);

		$this->load->view('plantilla', $data);

	}
	public function postalCodebyId($idPostal)
	{
		// traemos el codigo postal
		$postal = $this->postal_model->get_postal(array('zip_id' => $idPostal));
		// enviamos el codigo postal al front
		return $postal['zip_code'];

	}
	public function stateCodebyId($idState)
	{
		// traemos el codigo State
		$state = $this->state_model->get_state($idState);
		// enviamos el codigo State al front
		return $state[0] -> stt_name;

	}
	public function bankCode($clabe)
	{
		// traemos el codigo State
		$bank = $this->bank_model->get_bank($clabe);
		// enviamos el codigo State al front
		return $bank[0] -> bnk_alias;
	}
	public function datosempresa()
	{
		//jalamos la vista de datos empresa
		$this->load->view('perfil/datosempresa','');
	}
	public function estado()
	{
		$codigopostal = $this->input->post('codigopostal');

		$datos = array(
			"estado" => $this->perfil_model->estado($codigopostal)	
		);

		$this->load->view('registro/estados', $datos);
	}
	public function colonia()
	{
		$codigopostal = $this->input->post('codigopostal');

		$datos = array(
			"colonias" => $this->perfil_model->colonia($codigopostal)
		);

		$this->load->view('registro/colonias', $datos);
	}
	public function municipio()
	{
		$codigopostal = $this->input->post('codigopostal');

		$datos = array(
			"municipio" => $this->perfil_model->municipio($codigopostal)
		);

		$this->load->view('registro/municipio', $datos);
	}

	public function banco(){
		
		$clabe = $this->input->post('clabe');

		$datos = array(
			"banco" => $this->registro_model->banco($clabe)
		);

		$this->load->view('registro/banco', $datos);
	}

	public function updatedatosempresa()
	{
		$legal_name = $this->input->post('bussinesName');
		$short_name = $this->input->post('nameComercial');
		$rfc = $this->input->post('rfc');
		$regimen = $this->input->post('regimen');
		$telefono = $this->input->post('telefono');
		$correoe = $this->input->post('correoe');
		$correoe = $this->input->post('correoe');
		$direccion = $this->input->post('direccion');
		$colonia = $this->input->post('colonia');
		$clabe = $this->input->post('clabe');

		$empresa = array(
			'legal_name' => $legal_name,
			'short_name' => $short_name,
			'rfc' => $rfc, 
			'regimen' => $regimen, 
			'telefono' => $telefono, 
			'correoe' => $correoe,
			'correoe' => $correoe, 
			'direccion' => $direccion, 
			'colonia' => $colonia, 
			'clabe' => $clabe
		);

		$upEmpresa = $this->perfil_model->updateempresa($empresa);

		$this->empresa();
	}

	public function adlogo()
	{
		
		$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

		$config['upload_path'] = './boveda/' . $unique . '/'; // Directorio de destino
        $config['allowed_types'] = 'jpg|jpeg'; // Tipos de archivos permitidos

		$this->upload->initialize($config);

        if (!$this->upload->do_upload('imglogotipo')) {
            //echo $this->upload->display_errors();
            // Manejar el error, mostrarlo o redirigir al formulario de carga
        } else {
            // Subida exitosa, obten el nombre original del archivo
            $uploaded_data = $this->upload->data();
            $original_name = $uploaded_data['file_name'];
            // Renombra el archivo agregando la el stringUnico al nombre
            //si es jgp lo renombramos a jpeg
            $extension = $uploaded_data['file_ext'];
            
			if ($extension == '.jpeg') {
                $extension = '.jpg';
            }
        
            $new_name = 'logotipo' . $extension;
            // Mueve el archivo con el nuevo nombre al directorio de destino
            rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);

			$this->perfil_model->registra_file('Logotipo');
            
			$this->load->view('registro/logotipo', '');
        }
	}
	public function adactac()
	{
		$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

		$config['upload_path'] = './boveda/' . $unique . '/'; // Directorio de destino
        $config['allowed_types'] = 'pdf'; // Tipos de archivos permitidos

		$this->upload->initialize($config);

        if (!$this->upload->do_upload('actac')) {
            //echo $this->upload->display_errors();
            // Manejar el error, mostrarlo o redirigir al formulario de carga
        } else {
            // Subida exitosa, obten el nombre original del archivo
            $uploaded_data = $this->upload->data();
            $original_name = $uploaded_data['file_name'];
            // Renombra el archivo agregando la el stringUnico al nombre
            //si es jgp lo renombramos a jpeg
            $extension = $uploaded_data['file_ext'];
            
			$new_name = 'acta_constitutiva' . $extension;
            // Mueve el archivo con el nuevo nombre al directorio de destino
            rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);

			$this->perfil_model->registra_file('ActaConstitutiva');
            
			$this->load->view('registro/actaconstitutiva', '');
        }
	}
	public function adconstanciasf()
	{
		$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

		$config['upload_path'] = './boveda/' . $unique . '/'; // Directorio de destino
        $config['allowed_types'] = 'pdf'; // Tipos de archivos permitidos

		$this->upload->initialize($config);

        if (!$this->upload->do_upload('constanciasf')) {
            //echo $this->upload->display_errors();
            // Manejar el error, mostrarlo o redirigir al formulario de carga
        } else {
            // Subida exitosa, obten el nombre original del archivo
            $uploaded_data = $this->upload->data();
            $original_name = $uploaded_data['file_name'];
            // Renombra el archivo agregando la el stringUnico al nombre
            //si es jgp lo renombramos a jpeg
            $extension = $uploaded_data['file_ext'];
            
			$new_name = 'constancia_situacion_fiscal' . $extension;
            // Mueve el archivo con el nuevo nombre al directorio de destino
            rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);

			$this->perfil_model->registra_file('ConstanciaSituacionF');
            
			$this->load->view('registro/constanciasituacionfiscal', '');
        }
	}
	public function adcomprobanted()
	{
		$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

		$config['upload_path'] = './boveda/' . $unique . '/'; // Directorio de destino
        $config['allowed_types'] = 'pdf'; // Tipos de archivos permitidos

		$this->upload->initialize($config);

        if (!$this->upload->do_upload('comprobanted')) {
            //echo $this->upload->display_errors();
            // Manejar el error, mostrarlo o redirigir al formulario de carga
        } else {
            // Subida exitosa, obten el nombre original del archivo
            $uploaded_data = $this->upload->data();
            $original_name = $uploaded_data['file_name'];
            // Renombra el archivo agregando la el stringUnico al nombre
            //si es jgp lo renombramos a jpeg
            $extension = $uploaded_data['file_ext'];
            
			$new_name = 'comprobante_domicilio' . $extension;
            // Mueve el archivo con el nuevo nombre al directorio de destino
            rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);

			$this->perfil_model->registra_file('ComprobanteDomicilio');
            
			$this->load->view('registro/comprobantedomicilio', '');
        }
	}
	public function adidentificacionrl()
	{
		$unique = $this->session->userdata ( 'datosEmpresa' )[ 'unique_key' ];

		$config['upload_path'] = './boveda/' . $unique . '/'; // Directorio de destino
        $config['allowed_types'] = 'pdf'; // Tipos de archivos permitidos

		$this->upload->initialize($config);

        if (!$this->upload->do_upload('identificacionrl')) {
            //echo $this->upload->display_errors();
            // Manejar el error, mostrarlo o redirigir al formulario de carga
        } else {
            // Subida exitosa, obten el nombre original del archivo
            $uploaded_data = $this->upload->data();
            $original_name = $uploaded_data['file_name'];
            // Renombra el archivo agregando la el stringUnico al nombre
            //si es jgp lo renombramos a jpeg
            $extension = $uploaded_data['file_ext'];
            
			$new_name = 'identificacion_representante_legal' . $extension;
            // Mueve el archivo con el nuevo nombre al directorio de destino
            rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);

			$this->perfil_model->registra_file('IdenRepresentante');
            
			$this->load->view('registro/identificacionrl', '');
        }
	}
}
