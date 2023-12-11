<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Herramientas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('type_model'); // Carga el modelo
        $this->load->model('regimen_model'); // Carga el modelo
        $this->load->model('postal_model'); // Carga el modelo
        $this->load->model('state_model'); // Carga el modelo
        $this->load->model('bank_model'); // Carga el 
        $this->load->model('question_model'); // Carga el modelo
    }

    public function index()
    {
    }
    public function idUnico($tipo = 2)
    {
        $uniqueString = uniqid();
        $hora_actual = date("H");
        $uniqueString = $uniqueString . '-' . $hora_actual;
        $datos = array("idUnico" => $uniqueString);
        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function subirArchivo($uniqueString, $documentoNombre, $numeroCarpeta = 0)
    {

        $datos = array();
        switch ($numeroCarpeta) {
            case 1:
                $carpetaGuardado = 'boveda';
                break;

            default:
                $carpetaGuardado = 'temporales';
                break;
        }
        $nombre_carpeta = './' . $carpetaGuardado . '/' . $uniqueString;
        if (!file_exists($nombre_carpeta)) {
            if (mkdir($nombre_carpeta, 0777, true)) {
                //echo "Carpeta creada correctamente: $nombre_carpeta";
            } else {
                //echo "No se pudo crear la carpeta: $nombre_carpeta";
            }
        } else {
            //echo "La carpeta ya existe: $nombre_carpeta";
        }
        $config['upload_path'] = './' . $carpetaGuardado . '/' . $uniqueString . '/'; // Carpeta donde se guardarán los archivos
        $config['allowed_types'] = 'jpeg|jpg|pdf'; // Tipos de archivos permitidos
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('archivo')) {
            //echo $this->upload->display_errors();
            // Manejar el error, mostrarlo o redirigir al formulario de carga
        } else {
            // Subida exitosa, obten el nombre original del archivo
            $uploaded_data = $this->upload->data();
            $original_name = $uploaded_data['file_name'];
            // Renombra el archivo agregando la el stringUnico al nombre
            //si es jgp lo renombramos a jpeg
            $extension = $uploaded_data['file_ext'];
            if ($extension == '.jpg') {
                $extension = '.jpeg';
            }
            $new_name = $uniqueString . '-' . $documentoNombre . $extension;
            // Mueve el archivo con el nuevo nombre al directorio de destino
            rename($config['upload_path'] . $original_name, $config['upload_path'] . $new_name);
            if (($uploaded_data['file_type'] == 'image/jpeg') && $uploaded_data['file_size'] > 1024) {
                // Elimina el archivo con el nuevo nombre
                unlink($config['upload_path'] . $new_name);
                $datos['error'] = 'El archivo jpg o jpeg debe ser menor a 1MB.';
            }
        }
        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }

    public function listaRegimenes($tipo)
    {
        $datos = array();

        if ($tipo == 1) {
            $datos =  $this->regimen_model->get_all_regimenes('Fisica');
        } elseif ($tipo == 2) {
            $datos =  $this->regimen_model->get_all_regimenes('Moral');
        }

        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function listaGiro()
    {
        $datos = array();

        $datos =  $this->type_model->get_all_types();

        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function listaPostal($zip = '')
    {
        $datos = array();
        //validamos que el codigo postal solo sea nummero y de 5 digitos con reg
        if (preg_match('/^\d{5}$/', $zip)) {
            $datos =  $this->postal_model->get_all_postal($zip);
        }

        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function listaBanco($clabe = '')
    {
        $datos = array();
        if (preg_match('/^\d{3}$/', $clabe)) {
            $datos = $this->bank_model->get_bank($clabe);
        }
        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function listaPreguntas()
    {
        $datos = array();
        $datos = $this->question_model->get_all_questions();

        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function listaEstado($id = '')
    {
        $datos = array();
        //evaluamos que $id sea entero mayor a 0
        if (is_numeric($id) && $id > 0) {
            $datos = $this->state_model->get_state($id);
        }

        // Configura la respuesta para que sea en formato JSON
        $this->output->set_content_type('application/json');
        // Envía los datos en formato JSON
        $this->output->set_output(json_encode($datos));
    }
    public function cambiarVista($valor = '')
    {
        $datos = array();
        $this->load->library('session');


        // Verificar si el usuario ha iniciado sesión en todas las páginas protegidas
        if ($this->session->userdata('logged_in')) {


            switch ($valor) {
                case 1:
                    $this->session->set_userdata('vista', 1);
                    $datos['status'] = 'ok';
                    break;
                case 2:
                    $this->session->set_userdata('vista', 2);
                    $datos['status'] = 'ok';
                    break;
                default:
                    $datos['status'] = 'Error en los parametros';
                    # code...
                    break;
            }
            // Configura la respuesta para que sea en formato JSON
            $this->output->set_content_type('application/json');
            // Envía los datos en formato JSON
            $this->output->set_output(json_encode($datos));
        } else {
            redirect(base_url('login')); // Redirigir al inicio de sesión si no está autenticado
        }
    }
}
