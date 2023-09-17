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

    /*
    VerBanco
    Entrada -> Cadena de 3 posiciones con los 3 primero digitos correspondientes a la CLABE
    Salida -> Cadena con el Alias del Banco al que corresponde la CLABE
    */
    public function VerBanco($cadenaclabe)
    {
       $sql="select verbanco('".$cadenaclabe."') as existe;";
       echo $sql;
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
           if ($tempo==NULL)
           {
            $tempo=0;
           }
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

  /*
    /  AgragaContacto 
    /  Entrada -> cadena JSON con datos para tipo de contacto
    /  Salida ->    1 Guardado
    /               0 No se guardo
    */
    public function AgregaContacto($cadenajsoncontacto)
    {
       $sql="select AgregaContacto('".$cadenajsoncontacto."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

    /*
    /  ExisteRFC 
    /  Entrada -> cadena corresponde al rfc a consultar
    /  Salida ->   JSON Si existe
    /              0    No existe
    */
    public function ExisteRFC($rfc)
    {
       $sql="select existerfc('".$rfc."','".keyvalue."') as existe;";
      
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
            if ($tempo == NULL)
           {
               $tempo=0;
            }
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

    /*
    /  ExisteUsuario 
    /  Entrada -> cadena corresponde al usuario
    /  Salida ->    1 Si existe
    /               0 No existe
    */
    public function ExisteUsuario($usuario)
    {
       $sql="select existeUsuario('".$usuario."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

    /*
    /  AgragaUsuario 
    /  Entrada -> cadena JSON con datos sobre Usuario
    /  Salida ->    1 Guardado
    /               0 No se guardo
    */
    public function AgregaUsuario($cadenajsonusuario)
    {
       $sql="select AgregaUsuario('".$cadenajsonusuario."','".keyvalue."') as existe;";
       echo $sql;
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;// "Algo fallo"
        }
       return $tempo;
    }

    /*
    /  AgragarPersona 
    /  Entrada -> cadena JSON con datos sobre Persona Fiscal o Moral
    /  Salida ->    1 Guardado
    /               0 No se guardo
    */
    public function AgregaPersona($cadenajsonpersona)
    {
       $sql="select AgregaPersona('".$cadenajsonpersona."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

    /*
    /  AgragarRepresentanteLegal 
    /  Entrada -> cadena JSON con datos sobre Representante Legal
    /  Salida ->    1 Guardado
    /               0 No se guardo
    */
    public function AgregaRepresentante($cadenajsonpersona)
    {
       $sql="select AgregaRepresentante('".$cadenajsonpersona."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

/*
    /  Agraga Direccion 
    /  Entrada -> cadena JSON con datos sobre Direccion
    /  Salida ->    1 Guardado
    /               0 No se guardo
    	$direccion=$this->Interaccionbd->AgregaDireccion('{
			"idPersona":1,
			"CalleyNumero": "En la calle con el numero X",
			"Colonia": "No conocida",
			"Ciudad":"",
			"Estado":"CDMX",
			"CodPostal":"06000"}');
		echo $direccion;
    */
    public function AgregaDireccion($cadenajsondireccion)
    {
       $sql="select AgregaDireccion('".$cadenajsondireccion."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }



     /*
    /  ValidarAcceso 
    /  Entrada -> cadena JSON con datos sobre Representante Legal
    /  Salida ->    1 Guardado
    /               0 No se guardo
    */
    public function ValidarAcceso($cadenajsonvalidar)
    {
       $sql="select ValidarLlave('".$cadenajsonvalidar."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
           if ($tempo==NULL)
           {
            $tempo='{"Perfil": 0}';
        }
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

    /*
    /  Lista Estados Republica Mexicana 
    /  Entrada -> N/A
    /  Salida ->    JSON con IdEstado, Nombre y Alias
    */
    public function ConsutlarEstadosMX()
    {
       $sql="select ConsutlarEstadosMX() as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
            $tempo=500;//echo "Algo fallo";
        }
       return $tempo;
    }

    
}