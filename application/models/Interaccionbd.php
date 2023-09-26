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
   /  Update Usuario (Fisica o Moral) 
   /  Entrada -> cadena JSON con los datos de la persona (fisica o moral) modificados
   /  Salida ->    1 Idpersona actualizado
   /               0 No se guardo
   $update=$this->Interaccionbd->updateUsuario('{   
			"NombreUsuario": "DemoUser",
			"Nombre": "Nombre User",
			"Apellidos": "Apellido User",
			"idPersona": 1,
			"idPerfil": 1,
			"urlImagen": "/tempral/imagen.png",
			"Activo":1
		}');
		
		$salida=$this->Interaccionbd->consultaPersona(1);
    */
    public function updateUsuario($cadenajsonusuario)
    {

      $sql="select UpdateUsuario('".$cadenajsonusuario."','".keyvalue."') as existe;";
      $regreso = $this->db->query ($sql); 
    if ($regreso)
      {
         $tempo =  $regreso->result_array()[0]['existe'];
        }
      else
      {
         $tempo=-1;//echo "Algo fallo";
      }
     return $tempo;
    }   



    /*
   /  Update Persona (Fisica o Moral) 
   /  Entrada -> cadena JSON con los datos de la persona (fisica o moral) modificados
   /  Salida ->    1 Idpersona actualizado
   /               0 No se guardo
   $res=$this->Interaccionbd->updatePersona('{
			"idpersona":"1",   
			"Nombre": "Cliente Nombre",
			"Apellido": "Apellido Cliente",
			"Alias": "AliasC2",
			"RFC": "XXXXAAMMDDXX9",
			"TipoPersona": "1",
			"Rol": "1",
			"ActivoFintec": "0",
			"RegimenFical":"1",
			"Activo":"1"}');
		echo $res;	
    */
    public function updatePersona($cadenajsonpersona)
    {

      $sql="select UpdatePersona('".$cadenajsonpersona."','".keyvalue."') as existe;";
      $regreso = $this->db->query ($sql); 

      if ($regreso)
      {
         $tempo =  $regreso->result_array()[0]['existe'];
       }
      else
      {
         $tempo=-1;//echo "Algo fallo";
      }
     return $tempo;
    }   

   /*
   /  Consulta Persona (Fisica o Moral) 
   /  Entrada -> Numero de id de la persona (fisica o moral)
   /  Salida ->    cadena JSON con los datos de la persona, usuario 
   /               0 No se guardo
   $persona = $this->Interaccionbd->consultaPersona(1);
		echo $persona;
    */
    public function consultaPersona($valoridpersona)
    {
       $this->db->select("*");
       $this->db->from("datos_persona");
       $this->db->where("id_persona=".$valoridpersona);
      
       $resultados = $this->db->get();
      $regreso=json_encode($resultados->result());
      
      $tempo= $regreso;
        if ($regreso)
        {
           if ($tempo==NULL)
           {
            $tempo=0;
           }
        }
        else
        {
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }   

   /*
   /  Actualiza Llave de acceso 
   /  Entrada -> cadena JSON con idUsuario, NuevaLlave
   /  Salida ->    cadena JSON con idPersona, idUsuario y idPerfil
   /               0 No se guardo
   $cambio=$this->Interaccionbd->UpdateLlaveUsuario('{"idUsuario":1,"Llave":"llave"}');
		echo $cambio;
    */
    public function UpdateLlaveUsuario($cadenajsonnuevallave)
    {
       $sql="select UpdateLlaveUsuario('".$cadenajsonnuevallave."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 


        if ($regreso)
        {
           $tempo = json_encode(explode('|', $regreso->result_array()[0]['existe']));
           $tempo = $this->ajson($tempo);
         }
        else
        {
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }   

   /*
   /  Agraga Cuenta Bancaria 
   /  Entrada -> cadena JSON con idPersona, idBanco, CLABE
   /  Salida ->    1 Guardado
   /               0 No se guardo
   $resultado=$this->Interaccionbd->AgregaCuentaBancaria('{"idPersona":2,
			"idBanco":1,
			"CLABE": "1309434901823"}');
		echo $resultado;

    */
    public function AgregaCuentaBancaria($cadenajsoncuenta)
    {
       $sql="select AgregaCtaBancaria('".$cadenajsoncuenta."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }   

/*
   /  Agraga Pregunta secreta 
   /  Entrada -> cadena JSON con idPregunta, idPersona, Respuesta
   /  Salida ->    1 Guardado
   /               0 No se guardo
   $cadena=$this->Interaccionbd->AgregaPregunta('{"idPersona":1,
			"idPregunta":1,
			"Respuesta":"StarWars"}');
		echo $cadena;
    */
    public function AgregaPregunta($cadenajsonrespuesta)
    {
       $sql="select AgregaPregunta('".$cadenajsonrespuesta."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }   



    /*
    VerBanco
    Entrada -> Cadena de 3 posiciones con los 3 primero digitos correspondientes a la CLABE
    Salida -> Cadena con el Alias del Banco al que corresponde la CLABE
    */
    public function VerBanco($cadenaclabe)
    {
       $sql="select verbanco('".$cadenaclabe."') as existe;";
       //echo $sql;
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
           $tempo=-1;//echo "Algo fallo";
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
           $tempo=-1;//echo "Algo fallo";
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
         $regreso = $regreso->result_array()[0]['existe'];
         if ($regreso != "")
         {
            $tempo=json_encode(explode('|',$regreso));
            $tempo = $this->ajson($tempo);
          
         }
         elseif ($regreso == NULL)
           {
               $tempo=0;
            }
        }
        else
        {
           $tempo=-1;//echo "Algo fallo";
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
           $tempo=-1;//echo "Algo fallo";
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
      
        $regreso = $this->db->query ($sql); 
        if ($regreso)
        {
           $tempo = $regreso->result_array()[0]['existe'];
        }
        else
        {
           $tempo=-1;// "Algo fallo"
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
           $tempo=-1;//echo "Algo fallo";
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
           $tempo=-1;//echo "Algo fallo";
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
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }
    /*
    /  ValidarAcceso 
    /  Entrada -> cadena JSON con datos de acceso
    /  Salida ->    cadena con datoss de acceso

    /               0 No se guardo
    */
    public function ValidarAcceso($cadenajsonvalidar)
    {
       $sql="select ValidarLlave('".$cadenajsonvalidar."','".keyvalue."') as existe;";
        $regreso = $this->db->query ($sql); 
        if ($regreso)
         {
            $tempo=json_encode(explode('|', $regreso->result_array()[0]['existe']));
			   $final = $this->ajson($tempo);
         }
        else
        {
           $final=-1;//echo "Algo fallo";
        }
       return $final;
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
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }
    /*
    /  Lista Regimen Fiscal de acuerdo a tipo de persona 
    /  Entrada -> Int Tipo persona 1 para persona Fisica y 2 para persona moral
    /  Salida ->  JSON con Id_RegimenFiscal, ClaveRegimen, DescripcionRegimen
      * $resultado=$this->Interaccionbd->ConsutlaRegimenFiscal(1);
		echo $resultado;
    */
    public function ConsutlaRegimenFiscal($tipopersona)
    {
       $sql="select verRegimenFiscal($tipopersona) as existe;";
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
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }

    /*
    /  Lista Preguntas para recuperacion de acceso 
    /  Entrada -> N/A
    /  Salida ->  JSON con idpregunta, Pregunta
      * $resultado=$this->Interaccionbd->ConsutlaCatPreguntas();
		echo $resultado;
    */
    public function ConsutlaCatPreguntas()
    {
       $sql="select vercatpreguntas() as existe;";
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
           $tempo=-1;//echo "Algo fallo";
        }
       return $tempo;
    }
   
/* ajson 
Entrada, resulado comun de consultas con pipe de separacion
Salida, json con los datos recibidos
*/
public function ajson ($pasarjson)
{
   if ($pasarjson !="")
   {
   $perfil= explode(",",$pasarjson);
   $j_valida='{';
   foreach ($perfil as $elemento)
   {
     $campo=str_replace("[","",$elemento);
      $campo=str_replace('"',"",$campo);
      $campo=str_replace(']',"",$campo);
      $campos=explode(":",$campo);
   
      $j_valida=$j_valida.'"'.$campos[0].'":"'.$campos[1].'",';
   
   }
   $j_valida=substr($j_valida, 0, -1); 
   $j_valida=$j_valida."}";
   
   $final=json_encode($j_valida);
   switch(json_last_error()) {
      case JSON_ERROR_NONE:
          $final= $final;
      break;
      case JSON_ERROR_DEPTH:
         $final= ' - Excedido tamaño máximo de la pila';
      break;
      case JSON_ERROR_STATE_MISMATCH:
         $final= ' - Desbordamiento de buffer o los modos no coinciden';
      break;
      case JSON_ERROR_CTRL_CHAR:
         $final= ' - Encontrado carácter de control no esperado';
      break;
      case JSON_ERROR_SYNTAX:
         $final= ' - Error de sintaxis, JSON mal formado';
      break;
      case JSON_ERROR_UTF8:
         $final= ' - Caracteres UTF-8 malformados, posiblemente están mal codificados';
      break;
      default:
      $final= ' - Error desconocido';
      break;
      }
      return json_decode($final);
   }
   else
{
   return NULL;
}
  
}





}