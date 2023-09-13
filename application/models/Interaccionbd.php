<?php

/**
 * Description of DataBase Interaction
 * @author JIsraelHS
 * @email  israel.hernandez@whitefish.mx
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Interaccionbd extends CI_Model
{
	// declare private variable
    private $sql;
    private $regreso;
    private $tempo;

    public function ExisteUsuario($usuario)
    {
       $sql="select existeUsuario('".$usuario."','valor llave') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
         //   echo $tempo;
            if ($tempo == 0)
            {
           //     echo "No hay datos";
            
            }
            else
            {
             //   echo "Regreso distinto a 0";
            }
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       
       return $tempo;
    }


}