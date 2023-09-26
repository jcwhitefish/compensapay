-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-09-2023 a las 18:15:55
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `compensapay`
--
DROP DATABASE IF EXISTS `compensapay`;
CREATE DATABASE IF NOT EXISTS `compensapay` DEFAULT CHARACTER SET utf8mb4 ;
USE compensapay;

DELIMITER $$
--
-- Funciones
--
DROP FUNCTION IF EXISTS `AgregaContacto`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaContacto` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4  begin

  	declare resultado text;

	declare contenido varchar(50);

	declare idPersona int(3);

	declare idTipoContacto int(3);

	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Contenido'));

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

	set idTipoContacto = JSON_UNQUOTE(json_extract(entrada,'$.idTipoContacto'));

	insert into compensapay.contacto (c_idTipoContacto,

 									c_idPersona,

 									c_Descripcion,

 									c_Activo) values

 									(to_base64(idTipoContacto),

 									to_base64(idPersona),

 									to_base64(contenido),

 									1

 									);

  select

	count(c_Descripcion)

into

	resultado

from

	compensapay.contacto c 

where

	from_base64(c_idTipoContacto) = idTipoContacto and 

	from_base64(c_idPersona) = idPersona and 

	from_base64(c_Descripcion) = Contenido

	and c_Activo = 1;

  RETURN resultado;

END$$

DROP FUNCTION IF EXISTS `AgregaCtaBancaria`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaCtaBancaria` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4  begin

  	declare resultado text;

  	declare idPersona int(3);

  	declare idBanco int(3);

  	declare contenido varchar(50);

  	declare idcuenta int(3);

    declare existe int (3);

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

	set idBanco = JSON_UNQUOTE(json_extract(entrada,'$.idBanco'));

	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.CLABE'));

select c.b_idCtaBancaria into existe

from compensapay.cuentabancaria c 

where from_base64(b_CLABE)=contenido;

if existe then

	set resultado = 0;

else 

	insert into compensapay.cuentabancaria (

								b_idCatBanco,

								b_CLABE,

								b_Activo 

								)

							values

								(

								idBanco,

								to_base64(contenido),

								1

								);

select c.b_idCtaBancaria into idcuenta 

from compensapay.cuentabancaria c 

where from_base64(b_CLABE)=contenido and b_Activo = 1 ;


update compensapay.persona p 

set p.per_idCtaBanco = to_base64(idcuenta) 

where from_base64(p.per_idPersona)=idPersona

and p.per_Activo = 1;


select

	count( p.per_idCtaBanco )

into

	resultado

from

	compensapay.persona p 

where

	p.per_idPersona =  idPersona and 

	p.per_Activo = 1;

end if;



RETURN resultado;



END$$

DROP FUNCTION IF EXISTS `AgregaDireccion`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaDireccion` (`entrada` TEXT) RETURNS BLOB  begin

  	declare resultado blob;

  	declare idPersona int(3);

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

insert into compensapay.direccion (	d_idPersona,

 									d_CalleYNumero,

 									d_Colonia,

 									d_Ciudad,

 									d_Estado,

 									d_CodPost,

 									d_Activo) values

 									(

 									idPersona,

 									JSON_UNQUOTE(json_extract(entrada,'$.CalleyNumero')),

 									JSON_UNQUOTE(json_extract(entrada,'$.Colonia')),

 									JSON_UNQUOTE(json_extract(entrada,'$.Ciudad')),

 									JSON_UNQUOTE(json_extract(entrada,'$.Estado')),

 									JSON_UNQUOTE(json_extract(entrada,'$.CodPostal')),

 									1

 									);

select

	count(d_CalleyNumero)

into

	resultado

from

	compensapay.direccion d  

where

	d.d_idPersona  = idPersona  

and d.d_Activo  = 1 ;

  RETURN resultado;



END$$

DROP FUNCTION IF EXISTS `AgregaPersona`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPersona` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4  begin

  	declare resultado text;

	declare rfc varchar(16);
	
set rfc = JSON_UNQUOTE(json_extract(entrada,'$.RFC'));

 insert into compensapay.persona (per_Nombre,

 									per_Apellido,

 									per_Alias,

 									per_RFC,

 									per_idTipoPrersona,

 									per_idRol,

 									per_ActivoFintec,

 									per_RegimenFiscal,

 									per_idCtaBanco,

 									per_logo,

 									per_Activo) values

 									(

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Nombre'))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Apellido'))),

 									to_base64(JSON_UNQUOTE(json_extract (entrada,'$.Alias'))),

 									to_base64(rfc),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.TipoPersona'))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Rol'))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.ActivoFintec'))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.RegimenFical'))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.idCtaBanco'))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Logo'))),

 									1

 									);



  select per_idPersona  
 into resultado 
from compensapay.persona p 
where from_base64(per_RFC) = rfc and per_Activo = 1;								


  RETURN resultado;



END$$

DROP FUNCTION IF EXISTS `AgregaPregunta`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPregunta` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin

  	declare resultado blob;

  	declare contenido varchar(50);

	declare idPersona int(3);

	declare idPregunta int(3);

set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

set idPregunta = JSON_UNQUOTE(json_extract(entrada,'$.idPregunta'));

set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Respuesta'));



insert into compensapay.preguntapersona (

										pp_idpersona,

										pp_idpregunta,

										pp_respuestapregunta,

										pp_Activo

 									) values

 									(idPersona,

 									idPregunta,

 									to_base64(upper(trim(contenido))),

 									1

 									);



  select

	count(pp_idpregunta)

into

	resultado

from

	compensapay.preguntapersona p 

where

	pp_idpersona = idPersona and 

	pp_idpregunta = idPregunta 

	and pp_Activo = 1;

  RETURN resultado;

END$$

DROP FUNCTION IF EXISTS `AgregaRepresentante`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaRepresentante` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin

  	declare resultado blob;

	declare nombre varchar(30);

set nombre = JSON_UNQUOTE(json_extract(entrada,'$.NombreRepresentante'));

insert

	into

	compensapay.representantelegal (rl_Nombre,

	rl_RFC,

	rl_idPersona,

	rl_Activo)

values

 									(
 									to_base64(nombre),
 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.RFC'))),
 									to_base64(JSON_UNQUOTE(json_extract (entrada,'$.idPersona'))),

 									1);



select

	count(rl_Nombre)

into

	resultado

from

	compensapay.representantelegal

where

	from_base64(rl_Nombre) = nombre

	and rl_Activo = 1;



return resultado;



end$$

DROP FUNCTION IF EXISTS `AgregarOperacion`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregarOperacion` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin

	declare resultado blob;

	declare nombre varchar(30);

set nombre = JSON_UNQUOTE(json_extract(entrada,'$.NombreRepresentante'));
insert

	into

	compensapay.representantelegal (rl_Nombre,

	rl_RFC,

	rl_idPersona,

	rl_Activo)

values

 									(
 									to_base64(nombre),
 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.RFC'))),
 									to_base64(JSON_UNQUOTE(json_extract (entrada,'$.idPersona'))),
 									1);



select

	count(rl_Nombre)

into

	resultado

from

	compensapay.representantelegal

where

	from_base64(rl_Nombre) = nombre

	and rl_Activo = 1;

return resultado;



end$$

DROP FUNCTION IF EXISTS `AgregaUsuario`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaUsuario` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin

  declare resultado blob;

  declare nomuser varchar(30);

set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));

 insert into compensapay.usuario (u_NombreUsuario,
 									u_Nombre ,
 									u_Apellidos ,

 									u_Llaveacceso,

 									u_idPersona,

 									u_idPerfil,

 									u_imagenUsuario,

 									u_Activo) values

 									(
 									to_base64(nomuser),
 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Nombre'))),
 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Apellidos'))),
 									to_base64(MD5(JSON_UNQUOTE(json_extract(entrada,'$.LlaveAcceso')))),

 									to_base64(JSON_UNQUOTE(json_extract(entrada,'$.idPersona'))),

 									to_base64(JSON_UNQUOTE(json_extract (entrada,'$.idPerfil'))),

 									to_base64(JSON_UNQUOTE(json_extract (entrada,'$.urlImagen'))),

 									1

 									);

  select count(u_NombreUsuario) into resultado 

  from compensapay.usuario 

  where from_base64(u_NombreUsuario) = nomuser 

  and u_Activo = 1;								



  RETURN resultado;

END$$

DROP FUNCTION IF EXISTS `ConsultaEmpresa`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaEmpresa` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1  begin

	declare resultado text;

	declare idPersona int;

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

select

concat('[',

        GROUP_CONCAT(

	JSON_OBJECT (

	'Nombre', from_base64(per_Nombre),

	'Alias', from_base64(per_Alias),

	'RFC', from_base64(per_RFC),

	'idTipoPersona', from_base64(per_idTipoPrersona),

	'idRol', from_base64(per_idRol),

	'ActivoFintec', from_base64(per_ActivoFintec),

	'idRegimenFiscal', from_base64(per_RegimenFiscal),

	'idCuentaBanco', from_base64(per_idCtaBanco),

	'Banco', c2.Alias,

	'imagenPersona', from_base64(per_logo),

	'imagenUsuario', from_base64(u.u_imagenUsuario),

	'idUsuario', u.u_idUsuario)

	  SEPARATOR ',')

    ,']')



	into resultado

from

	persona p

inner join representantelegal r  

on

	p.per_idPersona = from_base64(r.rl_idPersona)

inner join usuario u 

on

	from_base64(r.rl_idPersona) = from_base64(u.u_idPersona)

inner join tipopersona t 

on

	t.tp_idTipoPersona = from_base64(p.per_idTipoPrersona)

inner join cuentabancaria c on

	c.b_idCatBanco = from_base64(per_idCtaBanco)

inner join catbancos c2 on

	c.b_idCatBanco = c2.id 

where

	per_Activo = 1

	and u_Activo = 1

	and rl_Activo = 1

	and t.tp_Activo = 1

	and per_idPersona = idPersona;

return resultado;



END$$

DROP FUNCTION IF EXISTS `ConsultaPersona`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaPersona` (`entrada` INT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1  begin

declare salida text;
	select
	concat_ws("|",
	concat('nombre:',from_base64(per_Nombre)),
 	concat('alias:',from_base64(per_Alias)),
	concat('rfc:', from_base64(per_RFC)),
	concat('idtipopersona:', from_base64(per_idTipoPrersona)),
	concat('idrol:', from_base64(per_idRol)),
	concat('activofintec:',from_base64(per_ActivoFintec)),
	concat('regimenfiscal:',from_base64(per_RegimenFiscal)),
	concat('idCatBanco:',from_base64(per_idCtaBanco)),
	concat('AliasBanco:',c2.Alias),
	concat('CLABE:', from_base64(c.b_CLABE)),
	concat('logo_persona:',from_base64(per_logo)),
	concat('logo_usuario:',from_base64(u.u_imagenUsuario)),
	concat('usuario:',from_base64(u.u_NombreUsuario)),
	concat('representante:',from_base64(r.rl_Nombre)),
	concat('nombreusuario:',from_base64(u.u_Nombre)),
	concat('apellidousuario:',from_base64(u.u_Apellidos)),
	concat('idusuario:',u.u_idUsuario))
		into salida
from

	persona p

inner join representantelegal r  

on

	p.per_idPersona = from_base64(r.rl_idPersona)

inner join usuario u 

on

	from_base64(r.rl_idPersona) = from_base64(u.u_idPersona)

inner join tipopersona t 

on

	t.tp_idTipoPersona = from_base64(p.per_idTipoPrersona)

inner join cuentabancaria c on

	c.b_idCatBanco = from_base64(per_idCtaBanco)

inner join catbancos c2 on

	c.b_idCatBanco = c2.id 

inner join compensapay.rol on

	rol.r_idRol= from_base64(p.per_idRol)

inner join compensapay.perfil on

	perfil.p_idPerfil = from_base64(u.u_idPerfil) 

where

	per_Activo = 1

	and u_Activo = 1

	and rl_Activo = 1

	and t.tp_Activo = 1

	and per_idPersona = entrada;



 return salida;



END$$

DROP FUNCTION IF EXISTS `ConsutlarEstadosMX`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsutlarEstadosMX` () RETURNS TEXT CHARSET latin1  begin

  declare salida text;

select

	concat('[',

        GROUP_CONCAT(

            JSON_OBJECT (

				'id_estado', e.e_IdEstado,

				'Nombre', e.e_Descripcion,

				'alias', e.e_alias)

            SEPARATOR ',')

    ,']')



into

	salida

from

	estados e;



return salida;

end$$

DROP FUNCTION IF EXISTS `ExisteRFC`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteRFC` (`entrada` VARCHAR(20), `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1  begin



  declare salida text;

select

	concat_ws("|",
	
	concat('RFC:',from_base64(per_RFC)),
	concat('Nombre:',from_base64(per_Nombre)),
	concat('alias:',from_base64(per_Alias)))

into

	salida

from

	persona

where

	from_base64(per_RFC) = entrada;

return salida;

end$$

DROP FUNCTION IF EXISTS `ExisteUsuario`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteUsuario` (`entrada` VARCHAR(50), `llave` VARCHAR(100)) RETURNS INT  BEGIN

  DECLARE salida int;

 	select count(u_NombreUsuario) 

	into salida 

	from usuario 

	where from_base64(u_NombreUsuario) = entrada;

  RETURN salida;

END$$

DROP FUNCTION IF EXISTS `UpdateContacto`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateContacto` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4  begin

  	declare resultado text;

	declare contenido varchar(50);

	declare idPersona int(3);

	declare idTipoContacto int(3);

	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Contenido'));

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

	set idTipoContacto = JSON_UNQUOTE(json_extract(entrada,'$.idTipoContacto'));

	update
	compensapay.contacto c
set
	c.c_Activo = 0
where
	c_idPersona = idPersona
	and c_idTipoContacto = idTipoContacto
	and c.c_Activo = 1;

	insert into compensapay.contacto (c_idTipoContacto,

 									c_idPersona,

 									c_Descripcion,

 									c_Activo) values

 									(to_base64(idTipoContacto),

 									to_base64(idPersona),

 									to_base64(contenido),

 									1

 									);

  select

	count(c_Descripcion)

into

	resultado

from

	compensapay.contacto c 

where

	from_base64(c_idTipoContacto) = idTipoContacto and 

	from_base64(c_idPersona) = idPersona and 

	from_base64(c_Descripcion) = Contenido

	and c_Activo = 1;

  RETURN resultado;

END$$

DROP FUNCTION IF EXISTS `UpdateDireccion`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateDireccion` (`entrada` TEXT) RETURNS BLOB  begin

  	declare resultado blob;

  	declare idPersona int(3);

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

update compensapay.direccion set d_Activo = 0 where d_idPersona = idPersona and d_Activo = 1;

insert into compensapay.direccion (	d_idPersona,

 									d_CalleYNumero,

 									d_Colonia,

 									d_Ciudad,

 									d_Estado,

 									d_CodPost,

 									d_Activo) values

 									(

 									idPersona,

 									JSON_UNQUOTE(json_extract(entrada,'$.CalleyNumero')),

 									JSON_UNQUOTE(json_extract(entrada,'$.Colonia')),

 									JSON_UNQUOTE(json_extract(entrada,'$.Ciudad')),

 									JSON_UNQUOTE(json_extract(entrada,'$.Estado')),

 									JSON_UNQUOTE(json_extract(entrada,'$.CodPostal')),

 									1

 									);

select

	count(d_CalleyNumero)

into

	resultado

from

	compensapay.direccion d  

where

	d.d_idPersona  = idPersona  

and d.d_Activo  = 1 ;

  RETURN resultado;



END$$

DROP FUNCTION IF EXISTS `UpdateLlaveUsuario`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateLlaveUsuario` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1  begin

	declare resultado text;

  	declare iduser varchar(100);

  	declare llave_interna varchar(100);

  	declare nueva_llave blob;

  	set iduser = JSON_UNQUOTE(json_extract(entrada,'$.idUsuario'));

  	set llave_interna = JSON_UNQUOTE(json_extract(entrada,'$.Llave'));

    set nueva_llave = to_base64(md5(llave_interna));



 update

	usuario u

 set

	u.u_Llaveacceso = nueva_llave

 where

	u.u_idUsuario = iduser;

 select

 concat_ws("|",
	concat('idperfil:',p.p_idPerfil) ,

	concat('idpersona:',from_base64(u.u_idPersona)),

	concat('nombreusuario:',from_base64(u.u_NombreUsuario))) 

 into

	resultado

 from

	compensapay.usuario u

 inner join compensapay.perfil p on from_base64(u.u_idPerfil) = p.p_idPerfil 

	where

	u.u_idUsuario = iduser

	and from_base64(u.u_Llaveacceso) = md5(llave_interna);

return resultado;



END$$

DROP FUNCTION IF EXISTS `UpdatePersona`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdatePersona` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1  begin

	declare resultado text;
	declare rfc varchar(16);
	declare idpersona varchar(4);

	set idpersona = JSON_UNQUOTE(json_extract(entrada,'$.idpersona'));
	set rfc = JSON_UNQUOTE(json_extract(entrada,'$.RFC'));

update
	compensapay.persona p
set 
	p.per_Nombre = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Nombre'))) ,
	p.per_Apellido = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Apellido'))),
	p.per_Alias = to_base64(JSON_UNQUOTE(json_extract (entrada,'$.Alias'))),
	p.per_RFC = to_base64(rfc),
	p.per_idTipoPrersona = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.TipoPersona'))),
	p.per_idRol = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Rol'))),
	p.per_ActivoFintec = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.ActivoFintec'))),
	p.per_RegimenFiscal = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.RegimenFical'))),
	p.per_logo = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Logo'))),
	p.per_Activo = JSON_UNQUOTE(json_extract(entrada,'$.Activo'))
where
	p.per_idPersona = idpersona;


select
	p.per_idPersona  
 into
	resultado
from
	compensapay.persona p
where
	p.per_idPersona = idpersona
	and p.per_Activo = 1;

return resultado;
end$$

DROP FUNCTION IF EXISTS `UpdateUsuario`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateUsuario` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin

  declare resultado blob;
  declare nomuser varchar(30);

	set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));


update compensapay.usuario 
set 
	u_Nombre = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Nombre'))),
 	u_Apellidos = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.Apellidos'))),
	u_idPersona = to_base64(JSON_UNQUOTE(json_extract(entrada,'$.idPersona'))),
	u_idPerfil = to_base64(JSON_UNQUOTE(json_extract (entrada,'$.idPerfil'))),
	u_imagenUsuario = to_base64(JSON_UNQUOTE(json_extract (entrada,'$.urlImagen'))),
	u_Activo = json_unquote(json_extract (entrada,'$.Activo'))
where 
	from_base64(u_NombreUsuario) = nomuser;
	
	
  select count(u_NombreUsuario) into resultado
  from compensapay.usuario 

  where from_base64(u_NombreUsuario) = nomuser 

  and u_Activo = 1;								




return resultado;

END$$

DROP FUNCTION IF EXISTS `ValidarLlave`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ValidarLlave` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1  begin

  declare resultado text;

  declare usuario varchar(100);

  declare llave_interna varchar(100);

  set usuario = JSON_UNQUOTE(json_extract(entrada,'$.Usuario'));

  set llave_interna = JSON_UNQUOTE(json_extract(entrada,'$.Llave'));

 select
 concat_ws("|",
	concat('Perfil:',p.p_idPerfil),
	concat('Persona:',from_base64(u.u_idPersona)),
	concat('Usuario:',from_base64(u.u_NombreUsuario)))
into
	resultado
from
	compensapay.usuario u
inner join compensapay.perfil p on from_base64(u.u_idPerfil) = p.p_idPerfil 
	where
	from_base64(u_NombreUsuario) = usuario
	and from_base64(u_Llaveacceso) = md5(llave_interna);
RETURN resultado;
end$$

DROP FUNCTION IF EXISTS `VerBanco`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerBanco` (`entrada` VARCHAR(4)) RETURNS VARCHAR(100) CHARSET utf8mb4  begin

  declare salida varchar(100);

select

	JSON_OBJECT (

		'Clave',Clave,

		'Alias',Alias  

	)

into

	salida

from

	catbancos 

where

	compensapay.catbancos.Clave = entrada;



return salida;



end$$

DROP FUNCTION IF EXISTS `VerCatPreguntas`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerCatPreguntas` () RETURNS TEXT CHARSET latin1  begin

	declare salida text;

	select	

		concat('[',

        GROUP_CONCAT(

			JSON_OBJECT (

				'idpregunta',pg_idpregunta,

				'pregunta',pg_pregunta

			 ) 

	separator ',')

    , ']')

into

	salida

from

	catpreguntas 

where

	pg_activo  = 1;

return salida;



END$$

DROP FUNCTION IF EXISTS `verGiro`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `verGiro` () RETURNS TEXT CHARSET utf8mb4  begin
	declare salida text;
select	
		concat('[',
        GROUP_CONCAT(
			JSON_OBJECT (
				'id_Giro', g_idGiro,
				'Giro', g_Giro ) 
	separator ',')
    , ']')
into
	salida
from
	catgiro
where
	g_Activo = 1;
return salida;
end$$

DROP FUNCTION IF EXISTS `VerOperaciones`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerOperaciones` (`entrada` INT(4), `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4  begin
	
	 declare salida text;
	
	select
	 GROUP_CONCAT(
	concat_ws('|',
       
	concat('FechaEmision:', o.o_FechaEmision),
	concat('FechaUpdate:',o.o_FechaUpload) ,
	concat('Total:',o.o_Total) ,
	concat('Impuestos:',o.o_Impuesto) ,
	concat('Subtotal:',o.o_SubTotal) ,
	concat('TipoDocumento:',t.td_Descripcion) ,
	concat('EstatusClienteProveedor:',c.cp_idEstatusCP ),
	concat('UUID:',o.o_UUID) ,
	concat('AliasCliente:',from_base64(p.per_Alias)), -- as aliascliente,
	concat('RFCCliente:',from_base64(p.per_RFC)), -- as rfccliente,
	concat('AliasProvedor:',(
	select
		from_base64(per_Alias)
	from
		persona
	where
		persona.per_idPersona = c.cp_idPersonaProveedor)),
	concat('RFCProveedor:', (
	select
		from_base64(per_RFC)
	from
		persona
	where
		persona.per_idPersona = c.cp_idPersonaProveedor))
))
	   
	into salida
from
	operacion o
inner join persona p on
	o.o_idPersona = p.per_idPersona
inner join clienteproveedor c on
	c.cp_idPersonaCliente = p.per_idPersona
	inner join tipodocumento t on
	t.td_idTipoDocumento = o.o_idTipoDocumento
where
	o.o_Activo = 1
	and c.cp_Activo = 1
	and t.td_Activo = 1
	and p.per_Activo = 1
	and p.per_idPersona = entrada;

return salida;
end$$

DROP FUNCTION IF EXISTS `VerRegimenFiscal`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerRegimenFiscal` (`tipopersona` INT) RETURNS TEXT CHARSET latin1  begin

	declare salida text;

	declare fisica int;

	declare moral int;



if tipopersona = 1

	then

		select	

		concat('[',

        GROUP_CONCAT(

			JSON_OBJECT (

				'id_regimen',rg_id_regimen,

				'Clave',rg_Clave,

				'Regimen',rg_Regimen ) 

	separator ',')

    , ']')

into

	salida

from

	catregimenfiscal

where

	rg_P_Fisica = 1;



elseif tipopersona = 2 then

		select

		concat('[',

        GROUP_CONCAT(

			JSON_OBJECT (

				'id_regimen',rg_id_regimen,

				'Clave',rg_Clave,

				'Regimen',rg_Regimen  

	) separator ',')

    , ']')

into

	salida

from

	catregimenfiscal

where

	rg_P_Moral = 1;

end if;

return salida;



end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

DROP TABLE IF EXISTS `acceso`;
CREATE TABLE IF NOT EXISTS `acceso` (
  `a_idAcceso` int NOT NULL AUTO_INCREMENT,
  `a_idUsuario` int NOT NULL,
  `a_Llave` varchar(255) NOT NULL,
  `a_Sesion` varchar(127) NOT NULL,
  `a_CambiarLlave` tinyint(1) DEFAULT NULL,
  `a_UlimoAcceso` datetime DEFAULT NULL,
  `a_Activo` tinyint(1) NOT NULL,
  `PreguntaSeguridad` varchar(255) DEFAULT NULL,
  `RespuestaSeguridad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`a_idAcceso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `acceso`
--

TRUNCATE TABLE `acceso`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catbancos`
--

DROP TABLE IF EXISTS `catbancos`;
CREATE TABLE IF NOT EXISTS `catbancos` (
  `id` int NOT NULL,
  `Clave` varchar(3) DEFAULT NULL,
  `Alias` varchar(50) DEFAULT NULL,
  `Nombre` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `catbancos`
--

TRUNCATE TABLE `catbancos`;
--
-- Volcado de datos para la tabla `catbancos`
--

INSERT INTO `catbancos` (`id`, `Clave`, `Alias`, `Nombre`) VALUES
(1, '002', 'BANAMEX', ' Banco Nacional de México, S.A., Institución de Banca Múltiple, Grupo Financiero Banamex '),
(2, '006', 'BANCOMEXT', ' Banco Nacional de Comercio Exterior, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),
(3, '009', 'BANOBRAS', ' Banco Nacional de Obras y Servicios Públicos, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),
(4, '012', 'BBVA BANCOMER', ' BBVA Bancomer, S.A., Institución de Banca Múltiple, Grupo Financiero BBVA Bancomer '),
(5, '014', 'SANTANDER', ' Banco Santander (México), S.A., Institución de Banca Múltiple, Grupo Financiero Santander '),
(6, '019', 'BANJERCITO', ' Banco Nacional del Ejército, Fuerza Aérea y Armada, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),
(7, '021', 'HSBC', ' HSBC México, S.A., institución De Banca Múltiple, Grupo Financiero HSBC '),
(8, '030', 'BAJIO', ' Banco del Bajío, S.A., Institución de Banca Múltiple '),
(9, '032', 'IXE', ' IXE Banco, S.A., Institución de Banca Múltiple, IXE Grupo Financiero '),
(10, '036', 'INBURSA', 'Banco Inbursa, S.A., Institución de Banca Múltiple, Grupo Financiero Inbursa '),
(11, '037', 'INTERACCIONES', ' Banco Interacciones, S.A., Institución de Banca Múltiple '),
(12, '042', 'MIFEL', ' Banca Mifel, S.A., Institución de Banca Múltiple, Grupo Financiero Mifel '),
(13, '044', 'SCOTIABANK', ' Scotiabank Inverlat, S.A. '),
(14, '058', 'BANREGIO', ' Banco Regional de Monterrey, S.A., Institución de Banca Múltiple, Banregio Grupo Financiero '),
(15, '059', 'INVEX', ' Banco Invex, S.A., Institución de Banca Múltiple, Invex Grupo Financiero '),
(16, '060', 'BANSI', ' Bansi, S.A., Institución de Banca Múltiple '),
(17, '062', 'AFIRME', ' Banca Afirme, S.A., Institución de Banca Múltiple '),
(18, '072', 'BANORTE', ' Banco Mercantil del Norte, S.A., Institución de Banca Múltiple, Grupo Financiero Banorte '),
(19, '102', 'THE ROYAL BANK', ' The Royal Bank of Scotland México, S.A., Institución de Banca Múltiple '),
(20, '103', 'AMERICAN EXPRESS', 'American Express Bank (México), S.A., Institución de Banca Múltiple'),
(21, '106', 'BAMSA', ' Bank of America México, S.A., Institución de Banca Múltiple, Grupo Financiero Bank of America '),
(22, '108', 'TOKYO', 'Bank of Tokyo-Mitsubishi UFJ '),
(23, '110', 'JP MORGAN', ' Banco J.P. Morgan, S.A., Institución de Banca Múltiple, J.P. Morgan Grupo Financiero '),
(24, '112', 'BMONEX', ' Banco Monex, S.A., Institución de Banca Múltiple '),
(25, '113', 'VE POR MAS', ' Banco Ve Por Mas, S.A. Institución de Banca Múltiple '),
(26, '116', 'ING', ' ING Bank (México), S.A., Institución de Banca Múltiple, ING Grupo Financiero'),
(27, '124', 'DEUTSCHE', ' Deutsche Bank México, S.A., Institución de Banca Múltiple '),
(28, '126', 'CREDIT SUISSE', 'Banco Credit Suisse (México), S.A. Institución de Banca Múltiple, Grupo Financiero Credit Suisse (México) '),
(29, '127', 'AZTECA', ' Banco Azteca, S.A. Institución de Banca Múltiple. '),
(30, '128', 'AUTOFIN', ' Banco Autofin México, S.A. Institución de Banca Múltiple'),
(31, '129', 'BARCLAYS', 'Barclays Bank México, S.A., Institución de Banca Múltiple, Grupo Financiero Barclays México.'),
(32, '130', 'COMPARTAMOS', ' Banco Compartamos, S.A., Institución de Banca Múltiple '),
(33, '131', 'BANCO FAMSA', ' Banco Ahorro Famsa, S.A., Institución de Banca Múltiple '),
(34, '132', 'BMULTIVA', 'Banco Multiva, S.A., Institución de Banca Múltiple, Multivalores Grupo Financiero '),
(35, '133', 'ACTINVER', 'Banco Actinver, S.A. Institución de Banca Múltiple, Grupo Financiero Actinver '),
(36, '134', 'WAL-MART', 'Banco Wal-Mart de México Adelante, S.A., Institución de Banca Múltiple '),
(37, '135', 'NAFIN', 'Nacional Financiera, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),
(38, '136', 'INTERBANCO', 'Inter Banco, S.A. Institución de Banca Múltiple '),
(39, '137', 'BANCOPPEL', 'BanCoppel, S.A., Institución de Banca Múltiple '),
(40, '138', 'ABC CAPITAL', 'ABC Capital, S.A., Institución de Banca Múltiple '),
(41, '139', 'UBS BANK', 'UBS Bank México, S.A., Institución de Banca Múltiple, UBS Grupo Financiero '),
(42, '140', 'CONSUBANCO', 'Consubanco, S.A. Institución de Banca Múltiple '),
(43, '141', 'VOLKSWAGEN', 'Volkswagen Bank, S.A., Institución de Banca Múltiple '),
(44, '143', 'CIBANCO', 'CIBanco, S.A. '),
(45, '145', 'BBASE', 'Banco Base, S.A., Institución de Banca Múltiple '),
(46, '166', 'BANSEFI', 'Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),
(47, '168', 'HIPOTECARIA FEDERAL', 'Sociedad Hipotecaria Federal, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),
(48, '600', 'MONEXCB', 'Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero '),
(49, '601', 'GBM', 'GBM Grupo Bursátil Mexicano, S.A. de C.V. Casa de Bolsa '),
(50, '602', 'MASARI', 'Masari Casa de Bolsa, S.A. '),
(51, '605', 'VALUE', 'Value, S.A. de C.V. Casa de Bolsa '),
(52, '606', 'ESTRUCTURADORES', 'Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V. '),
(53, '607', 'TIBER', 'Casa de Cambio Tiber, S.A. de C.V. '),
(54, '608', 'VECTOR', 'Vector Casa de Bolsa, S.A. de C.V. '),
(55, '610', 'B&B', 'B y B, Casa de Cambio, S.A. de C.V. '),
(56, '614', 'ACCIVAL', 'Acciones y Valores Banamex, S.A. de C.V., '),
(57, '615', 'MERRILL LYNCH', 'Merrill Lynch México, S.A. de C.V. Casa de Bolsa '),
(58, '616', 'FINAMEX', 'Casa de Bolsa Finamex, S.A. de C.V. '),
(59, '617', 'VALMEX', 'Valores Mexicanos Casa de Bolsa, S.A. de C.V. '),
(60, '618', 'UNICA', 'Unica Casa de Cambio, S.A. de C.V. '),
(61, '619', 'MAPFRE', 'MAPFRE Tepeyac, S.A. '),
(62, '620', 'PROFUTURO', 'Profuturo G.N.P., S.A. de C.V., Afore '),
(63, '621', 'CB ACTINVER', 'Actinver Casa de Bolsa, S.A. de C.V. '),
(64, '622', 'OACTIN', 'OPERADORA ACTINVER, S.A. DE C.V. '),
(65, '623', 'SKANDIA', 'Skandia Vida, S.A. de C.V. '),
(66, '626', 'CBDEUTSCHE', 'Deutsche Securities, S.A. de C.V. CASA DE BOLSA '),
(67, '627', 'ZURICH', 'Zurich Compañía de Seguros, S.A. '),
(68, '628', 'ZURICHVI', 'Zurich Vida, Compañía de Seguros, S.A. '),
(69, '629', 'SU CASITA', 'Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR '),
(70, '630', 'CB INTERCAM', 'Intercam Casa de Bolsa, S.A. de C.V. '),
(71, '631', 'CI BOLSA', 'CI Casa de Bolsa, S.A. de C.V. '),
(72, '632', 'BULLTICK CB', 'Bulltick Casa de Bolsa, S.A., de C.V. '),
(73, '633', 'STERLING', 'Sterling Casa de Cambio, S.A. de C.V. '),
(74, '634', 'FINCOMUN', 'Fincomún, Servicios Financieros Comunitarios, S.A. de C.V. '),
(75, '636', 'HDI SEGUROS', 'HDI Seguros, S.A. de C.V. '),
(76, '637', 'ORDER', 'Order Express Casa de Cambio, S.A. de C.V '),
(77, '638', 'AKALA', 'Akala, S.A. de C.V., Sociedad Financiera Popular '),
(78, '640', 'CB  JPMORGAN', 'J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero '),
(79, '642', 'REFORMA', 'Operadora de Recursos Reforma, S.A. de C.V., S.F.P. '),
(80, '646', 'STP', 'Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR '),
(81, '647', 'TELECOMM', 'Telecomunicaciones de México '),
(82, '648', 'EVERCORE', 'Evercore Casa de Bolsa, S.A. de C.V. '),
(83, '649', 'SKANDIA', 'Skandia Operadora de Fondos, S.A. de C.V. '),
(84, '651', 'SEGMTY', 'Seguros Monterrey New York Life, S.A de C.V '),
(85, '652', 'ASEA', 'Solución Asea, S.A. de C.V., Sociedad Financiera Popular '),
(86, '653', 'KUSPIT', 'Kuspit Casa de Bolsa, S.A. de C.V. '),
(87, '655', 'SOFIEXPRESS', 'J.P. SOFIEXPRESS, S.A. de C.V., S.F.P. '),
(88, '656', 'UNAGRA', 'UNAGRA, S.A. de C.V., S.F.P. '),
(89, '659', 'OPCIONES EMPRESARIALES DEL NOROESTE', 'OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P. '),
(90, '670', 'LIBERTAD', 'Cls Bank International '),
(91, '901', 'CLS', 'SD. Indeval, S.A. de C.V. '),
(92, '902', 'INDEVAL', 'Libertad Servicios Financieros, S.A. De C.V. '),
(93, '999', 'N/A', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catgiro`
--

DROP TABLE IF EXISTS `catgiro`;
CREATE TABLE IF NOT EXISTS `catgiro` (
  `g_idGiro` int NOT NULL AUTO_INCREMENT,
  `g_Giro` varchar(255) NOT NULL,
  `g_Activo` int NOT NULL,
  PRIMARY KEY (`g_idGiro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `catgiro`
--

TRUNCATE TABLE `catgiro`;
--
-- Volcado de datos para la tabla `catgiro`
--

INSERT INTO `catgiro` (`g_idGiro`, `g_Giro`, `g_Activo`) VALUES
(1, 'Producción', 1),
(2, 'Transformación', 1),
(3, 'Servicios', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catpreguntas`
--

DROP TABLE IF EXISTS `catpreguntas`;
CREATE TABLE IF NOT EXISTS `catpreguntas` (
  `pg_idpregunta` int NOT NULL AUTO_INCREMENT,
  `pg_pregunta` varchar(255) NOT NULL,
  `pg_activo` int NOT NULL,
  PRIMARY KEY (`pg_idpregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `catpreguntas`
--

TRUNCATE TABLE `catpreguntas`;
--
-- Volcado de datos para la tabla `catpreguntas`
--

INSERT INTO `catpreguntas` (`pg_idpregunta`, `pg_pregunta`, `pg_activo`) VALUES
(1, '¿Cuál es tu película favorita?', 1),
(2, '¿Nombre de tu primera mascota?', 1),
(3, '¿Segundo apellido de tu mamá?', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catregimenfiscal`
--

DROP TABLE IF EXISTS `catregimenfiscal`;
CREATE TABLE IF NOT EXISTS `catregimenfiscal` (
  `rg_id_regimen` int DEFAULT NULL,
  `rg_Clave` int DEFAULT NULL,
  `rg_Regimen` varchar(128) DEFAULT NULL,
  `rg_P_Fisica` int DEFAULT NULL,
  `rg_P_Moral` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `catregimenfiscal`
--

TRUNCATE TABLE `catregimenfiscal`;
--
-- Volcado de datos para la tabla `catregimenfiscal`
--

INSERT INTO `catregimenfiscal` (`rg_id_regimen`, `rg_Clave`, `rg_Regimen`, `rg_P_Fisica`, `rg_P_Moral`) VALUES
(1, 601, 'General de Ley Personas Morales', 0, 1),
(2, 603, 'Personas Morales con Fines no Lucrativos', 0, 1),
(3, 605, 'Sueldos y Salarios e Ingresos Asimilados a Salarios', 1, 0),
(4, 606, 'Arrendamiento', 1, 0),
(5, 607, 'Régimen de Enajenación o Adquisición de Bienes', 1, 0),
(6, 608, 'Demás ingresos', 1, 0),
(7, 610, 'Residentes en el Extranjero sin Establecimiento Permanente en México', 1, 1),
(8, 611, 'Ingresos por Dividendos (socios y accionistas)', 1, 0),
(9, 612, 'Personas Físicas con Actividades Empresariales y Profesionales', 1, 0),
(10, 614, 'Ingresos por intereses', 1, 0),
(11, 615, 'Régimen de los ingresos por obtención de premios', 1, 0),
(12, 616, 'Sin obligaciones fiscales', 1, 0),
(13, 620, 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos', 0, 1),
(14, 621, 'Incorporación Fiscal', 1, 0),
(15, 622, 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras', 0, 1),
(16, 623, 'Opcional para Grupos de Sociedades', 0, 1),
(17, 624, 'Coordinados', 0, 1),
(18, 625, 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas', 1, 0),
(19, 626, 'Régimen Simplificado de Confianza', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cattipovalor`
--

DROP TABLE IF EXISTS `cattipovalor`;
CREATE TABLE IF NOT EXISTS `cattipovalor` (
  `cv_idTipoValor` int NOT NULL AUTO_INCREMENT,
  `cv_Descripcion` varchar(255) NOT NULL,
  `cv_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cv_idTipoValor`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `cattipovalor`
--

TRUNCATE TABLE `cattipovalor`;
--
-- Volcado de datos para la tabla `cattipovalor`
--

INSERT INTO `cattipovalor` (`cv_idTipoValor`, `cv_Descripcion`, `cv_Activo`) VALUES
(1, 'Cadena', 1),
(2, 'Numerico', 1),
(3, 'Logico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clienteproveedor`
--

DROP TABLE IF EXISTS `clienteproveedor`;
CREATE TABLE IF NOT EXISTS `clienteproveedor` (
  `cp_idClienteProveedor` int NOT NULL AUTO_INCREMENT,
  `cp_idPersonaCliente` int NOT NULL,
  `cp_idPersonaProveedor` varchar(100) NOT NULL,
  `cp_Nota` varchar(50) NOT NULL,
  `cp_idEstatusCP` int DEFAULT NULL,
  `cp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cp_idClienteProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `clienteproveedor`
--

TRUNCATE TABLE `clienteproveedor`;
--
-- Volcado de datos para la tabla `clienteproveedor`
--

INSERT INTO `clienteproveedor` (`cp_idClienteProveedor`, `cp_idPersonaCliente`, `cp_idPersonaProveedor`, `cp_Nota`, `cp_idEstatusCP`, `cp_Activo`) VALUES
(1, 1, '2', 'na', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compensacion`
--

DROP TABLE IF EXISTS `compensacion`;
CREATE TABLE IF NOT EXISTS `compensacion` (
  `cm_idCompensacion` int NOT NULL AUTO_INCREMENT,
  `cm_idPersonaCliente` int NOT NULL,
  `cm_idPersonaProveedor` varchar(100) NOT NULL,
  `cm_idEstatusCM` varchar(50) NOT NULL,
  `cm_idOperacion` int DEFAULT NULL,
  `cm_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cm_idCompensacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `compensacion`
--

TRUNCATE TABLE `compensacion`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `cnf_idConfiguracion` int NOT NULL AUTO_INCREMENT,
  `cnf_idPersona` int NOT NULL,
  `cnf_idElementoConfigurable` int NOT NULL,
  `cnf_Valor` varchar(100) NOT NULL,
  `cnf_Activo` int NOT NULL,
  PRIMARY KEY (`cnf_idConfiguracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `configuracion`
--

TRUNCATE TABLE `configuracion`;
--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`cnf_idConfiguracion`, `cnf_idPersona`, `cnf_idElementoConfigurable`, `cnf_Valor`, `cnf_Activo`) VALUES
(1, 1, 1, '/nombre_archivo.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

DROP TABLE IF EXISTS `contacto`;
CREATE TABLE IF NOT EXISTS `contacto` (
  `c_idContacto` int NOT NULL AUTO_INCREMENT,
  `c_idTipoContacto` varchar(255) NOT NULL,
  `c_idPersona` varchar(255) NOT NULL,
  `c_Descripcion` varchar(255) NOT NULL,
  `c_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`c_idContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `contacto`
--

TRUNCATE TABLE `contacto`;
--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`c_idContacto`, `c_idTipoContacto`, `c_idPersona`, `c_Descripcion`, `c_Activo`) VALUES
(1, 'Mw==', 'MQ==', 'dWlzdWFyaW9AZG9taW5pby5jb20=', 1),
(2, 'Mw==', 'Mg==', 'dWlzdWFyaW9AZG9taW5pby5jb20=', 1),
(3, 'MQ==', 'Mg==', 'NTUzNjM5MTY5Mg==', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentabancaria`
--

DROP TABLE IF EXISTS `cuentabancaria`;
CREATE TABLE IF NOT EXISTS `cuentabancaria` (
  `b_idCtaBancaria` int NOT NULL AUTO_INCREMENT,
  `b_idCatBanco` int NOT NULL,
  `b_CLABE` varchar(255) NOT NULL,
  `b_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`b_idCtaBancaria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `cuentabancaria`
--

TRUNCATE TABLE `cuentabancaria`;
--
-- Volcado de datos para la tabla `cuentabancaria`
--

INSERT INTO `cuentabancaria` (`b_idCtaBancaria`, `b_idCatBanco`, `b_CLABE`, `b_Activo`) VALUES
(1, 1, 'MTIzNDQ1Njc4OTk=', 1),
(2, 1, 'OTk5OTk5OTk5OTk=', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `datos_persona`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `datos_persona`;
CREATE TABLE IF NOT EXISTS `datos_persona` (
`id_persona` int
,`nombre` blob
,`alias` blob
,`rfc` blob
,`idtipopersona` blob
,`idrol` blob
,`activofintec` blob
,`idregimenfiscal` blob
,`idcuentabanco` blob
,`banco` varchar(50)
,`clabe` blob
,`logo_persona` blob
,`logo_usuario` blob
,`nombre_usuario` blob
,`nombre_representante` blob
,`nombre_d_usaurio` blob
,`apellido_usuario` blob
,`id_usuario` int
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

DROP TABLE IF EXISTS `direccion`;
CREATE TABLE IF NOT EXISTS `direccion` (
  `d_idDireccion` int NOT NULL AUTO_INCREMENT,
  `d_idPersona` int NOT NULL,
  `d_CalleYNumero` varchar(100) NOT NULL,
  `d_Colonia` varchar(50) NOT NULL,
  `d_Ciudad` varchar(50) DEFAULT NULL,
  `d_Estado` varchar(50) DEFAULT NULL,
  `d_CodPost` int DEFAULT NULL,
  `d_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`d_idDireccion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `direccion`
--

TRUNCATE TABLE `direccion`;
--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`d_idDireccion`, `d_idPersona`, `d_CalleYNumero`, `d_Colonia`, `d_Ciudad`, `d_Estado`, `d_CodPost`, `d_Activo`) VALUES
(1, 1, 'Calle en una ciudad 34', 'Colonia conocida', 'Ciudad perdida', 'México', 66666, 1),
(2, 2, 'Calle en una ciudad X 34', 'Colonia desconocida', 'Ciudad encontrada', 'México', 66666, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementoconfigurable`
--

DROP TABLE IF EXISTS `elementoconfigurable`;
CREATE TABLE IF NOT EXISTS `elementoconfigurable` (
  `ec_idElementoConfigurable` int NOT NULL AUTO_INCREMENT,
  `ec_Descripcion` varchar(255) NOT NULL,
  `ec_idTipoValor` int NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ec_idElementoConfigurable`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `elementoconfigurable`
--

TRUNCATE TABLE `elementoconfigurable`;
--
-- Volcado de datos para la tabla `elementoconfigurable`
--

INSERT INTO `elementoconfigurable` (`ec_idElementoConfigurable`, `ec_Descripcion`, `ec_idTipoValor`, `ec_Activo`) VALUES
(1, 'ImagenPerfil', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `e_IdEstado` int DEFAULT NULL,
  `e_Descripcion` varchar(50) DEFAULT NULL,
  `e_alias` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `estados`
--

TRUNCATE TABLE `estados`;
--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`e_IdEstado`, `e_Descripcion`, `e_alias`) VALUES
(1, 'Aguascalientes', 'Ags.'),
(2, 'Baja California', 'BC'),
(3, 'Baja California Sur', 'BCS'),
(4, 'Campeche', 'Camp.'),
(5, 'Coahuila de Zaragoza', 'Coah.'),
(6, 'Colima', 'Col.'),
(7, 'Chiapas', 'Chis.'),
(8, 'Chihuahua', 'Chih.'),
(9, 'Ciudad de México', 'CDMX'),
(10, 'Durango', 'Dgo.'),
(11, 'Guanajuato', 'Gto.'),
(12, 'Guerrero', 'Gro.'),
(13, 'Hidalgo', 'Hgo.'),
(14, 'Jalisco', 'Jal.'),
(15, 'México', 'Mex.'),
(16, 'Michoacán de Ocampo', 'Mich.'),
(17, 'Morelos', 'Mor.'),
(18, 'Nayarit', 'Nay.'),
(19, 'Nuevo León', 'NL'),
(20, 'Oaxaca', 'Oax.'),
(21, 'Puebla', 'Pue.'),
(22, 'Querátaro', 'Qro.'),
(23, 'Quintana Roo', 'Q. Roo'),
(24, 'San Luis Potosí', 'SLP'),
(25, 'Sinaloa', 'Sin.'),
(26, 'Sonora', 'Son.'),
(27, 'Tabasco', 'Tab.'),
(28, 'Tamaulipas', 'Tamps.'),
(29, 'Tlaxcala', 'Tlax.'),
(30, 'Veracruz de Ignacio de la Llave', 'Ver.'),
(31, 'Yucatán', 'Yuc.'),
(32, 'Zacatecas', 'Zac.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatuscm`
--

DROP TABLE IF EXISTS `estatuscm`;
CREATE TABLE IF NOT EXISTS `estatuscm` (
  `ec_idEstatusCM` int NOT NULL AUTO_INCREMENT,
  `ec_Descripcion` varchar(16) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ec_idEstatusCM`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `estatuscm`
--

TRUNCATE TABLE `estatuscm`;
--
-- Volcado de datos para la tabla `estatuscm`
--

INSERT INTO `estatuscm` (`ec_idEstatusCM`, `ec_Descripcion`, `ec_Activo`) VALUES
(1, 'Alta', 1),
(2, 'Conciliada', 1),
(3, 'Pagada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatuscp`
--

DROP TABLE IF EXISTS `estatuscp`;
CREATE TABLE IF NOT EXISTS `estatuscp` (
  `ecp_idEstatusCP` int NOT NULL AUTO_INCREMENT,
  `ecp_Descripcion` varchar(16) NOT NULL,
  `ecp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ecp_idEstatusCP`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `estatuscp`
--

TRUNCATE TABLE `estatuscp`;
--
-- Volcado de datos para la tabla `estatuscp`
--

INSERT INTO `estatuscp` (`ecp_idEstatusCP`, `ecp_Descripcion`, `ecp_Activo`) VALUES
(1, 'Alta', 1),
(2, 'Baja', 1),
(3, 'En aprobación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatuso`
--

DROP TABLE IF EXISTS `estatuso`;
CREATE TABLE IF NOT EXISTS `estatuso` (
  `eo_idEstatusO` int NOT NULL AUTO_INCREMENT,
  `eo_Descripcion` varchar(16) NOT NULL,
  `eo_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`eo_idEstatusO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `estatuso`
--

TRUNCATE TABLE `estatuso`;
--
-- Volcado de datos para la tabla `estatuso`
--

INSERT INTO `estatuso` (`eo_idEstatusO`, `eo_Descripcion`, `eo_Activo`) VALUES
(1, 'Cargada', 1),
(2, 'Por autroizar', 1),
(3, 'Autorizada', 1),
(4, 'Proceso pago', 1),
(5, 'Pagada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moduloperfil`
--

DROP TABLE IF EXISTS `moduloperfil`;
CREATE TABLE IF NOT EXISTS `moduloperfil` (
  `mp_idModuloPerfil` int NOT NULL AUTO_INCREMENT,
  `mp_idModulo` tinyint DEFAULT NULL,
  `mp_idPerfil` tinyint DEFAULT NULL,
  `mp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`mp_idModuloPerfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `moduloperfil`
--

TRUNCATE TABLE `moduloperfil`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE IF NOT EXISTS `modulos` (
  `m_idModulo` tinyint NOT NULL AUTO_INCREMENT,
  `m_Descripcion` varchar(30) NOT NULL,
  `m_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`m_idModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `modulos`
--

TRUNCATE TABLE `modulos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

DROP TABLE IF EXISTS `operacion`;
CREATE TABLE IF NOT EXISTS `operacion` (
  `o_idOperacion` int NOT NULL AUTO_INCREMENT,
  `o_NumOperacion` varchar(10) NOT NULL,
  `o_idPersona` int NOT NULL,
  `o_FechaEmision` datetime NOT NULL,
  `o_Total` float DEFAULT NULL,
  `o_ArchivoXML` text NOT NULL,
  `o_UUID` varchar(20) NOT NULL,
  `o_idTipoDocumento` int NOT NULL,
  `o_SubTotal` float DEFAULT NULL,
  `o_Impuesto` float NOT NULL,
  `o_FechaUpload` datetime NOT NULL,
  `o_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`o_idOperacion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `operacion`
--

TRUNCATE TABLE `operacion`;
--
-- Volcado de datos para la tabla `operacion`
--

INSERT INTO `operacion` (`o_idOperacion`, `o_NumOperacion`, `o_idPersona`, `o_FechaEmision`, `o_Total`, `o_ArchivoXML`, `o_UUID`, `o_idTipoDocumento`, `o_SubTotal`, `o_Impuesto`, `o_FechaUpload`, `o_Activo`) VALUES
(1, '123', 1, '2023-09-12 00:00:00', 100000, 'texto', '8383382', 1, 116000, 16000, '2023-09-12 00:00:00', 1),
(2, '432', 1, '2023-09-20 00:00:00', 100, 'Algooafdkasdfjasd', '8383383', 2, 116, 16, '2023-09-20 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `p_idPerfil` tinyint NOT NULL AUTO_INCREMENT,
  `p_Descripcion` varchar(50) NOT NULL,
  `p_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`p_idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `perfil`
--

TRUNCATE TABLE `perfil`;
--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`p_idPerfil`, `p_Descripcion`, `p_Activo`) VALUES
(1, 'Administrador', 1),
(2, 'Administrador Ex', 1),
(3, 'Colaborador Editor', 1),
(4, 'Colaborador Consulta', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `per_idPersona` int NOT NULL AUTO_INCREMENT,
  `per_Nombre` varchar(255) DEFAULT NULL,
  `per_Apellido` varchar(255) DEFAULT NULL,
  `per_Alias` varchar(255) DEFAULT NULL,
  `per_RFC` varchar(255) DEFAULT NULL,
  `per_idTipoPrersona` varchar(255) DEFAULT NULL,
  `per_idRol` varchar(255) DEFAULT NULL,
  `per_ActivoFintec` varchar(255) DEFAULT NULL,
  `per_RegimenFiscal` varchar(255) DEFAULT NULL,
  `per_idCtaBanco` varchar(255) DEFAULT NULL,
  `per_logo` varchar(255) DEFAULT NULL,
  `per_Activo` int DEFAULT NULL,
  PRIMARY KEY (`per_idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `persona`
--

TRUNCATE TABLE `persona`;
--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`per_idPersona`, `per_Nombre`, `per_Apellido`, `per_Alias`, `per_RFC`, `per_idTipoPrersona`, `per_idRol`, `per_ActivoFintec`, `per_RegimenFiscal`, `per_idCtaBanco`, `per_logo`, `per_Activo`) VALUES
(1, 'Q2xpZW50ZSBOb21icmU=', 'QXBlbGxpZG8gQ2xpZW50ZQ==', 'QWxpYXNDMg==', 'WFhYWEFBTU1ERFhY', 'MQ==', 'MQ==', 'MA==', 'MQ==', 'MQ==', NULL, 1),
(2, 'Q2xpZW50ZSBOb21icmUy', 'QXBlbGxpZG8gQ2xpZW50ZTI=', 'QWxpYXNDX290cm8=', 'WFhYWEFBTU1ERDk5', 'MQ==', 'Mg==', 'MA==', 'MQ==', 'MQ==', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntapersona`
--

DROP TABLE IF EXISTS `preguntapersona`;
CREATE TABLE IF NOT EXISTS `preguntapersona` (
  `pp_idpreguntapersona` int NOT NULL AUTO_INCREMENT,
  `pp_idpersona` int DEFAULT NULL,
  `pp_idpregunta` int NOT NULL,
  `pp_respuestapregunta` varchar(255) NOT NULL,
  `pp_Activo` int DEFAULT NULL,
  PRIMARY KEY (`pp_idpreguntapersona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `preguntapersona`
--

TRUNCATE TABLE `preguntapersona`;
--
-- Volcado de datos para la tabla `preguntapersona`
--

INSERT INTO `preguntapersona` (`pp_idpreguntapersona`, `pp_idpersona`, `pp_idpregunta`, `pp_respuestapregunta`, `pp_Activo`) VALUES
(1, 1, 1, 'U1RBUldBUlM=', 1),
(2, 2, 1, 'U1VQRVJNQU4=', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representantelegal`
--

DROP TABLE IF EXISTS `representantelegal`;
CREATE TABLE IF NOT EXISTS `representantelegal` (
  `rl_idRepresentante` int NOT NULL AUTO_INCREMENT,
  `rl_Nombre` varchar(255) DEFAULT NULL,
  `rl_RFC` varchar(255) DEFAULT NULL,
  `rl_idPersona` varchar(255) DEFAULT NULL,
  `rl_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`rl_idRepresentante`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `representantelegal`
--

TRUNCATE TABLE `representantelegal`;
--
-- Volcado de datos para la tabla `representantelegal`
--

INSERT INTO `representantelegal` (`rl_idRepresentante`, `rl_Nombre`, `rl_RFC`, `rl_idPersona`, `rl_Activo`) VALUES
(1, 'Tm9tYnJlIFJlcHJlc2VudGFudGU=', 'WFhYWDk5OTk5OVhYWA==', 'MQ==', 1),
(2, 'Tm9tYnJlIFJlcHJlc2VudGFudGUy', 'WFhYWDk5OTk5OUFBQQ==', 'Mg==', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `r_idRol` tinyint NOT NULL AUTO_INCREMENT,
  `r_Descripcion` varchar(50) DEFAULT NULL,
  `r_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`r_idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `rol`
--

TRUNCATE TABLE `rol`;
--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`r_idRol`, `r_Descripcion`, `r_Activo`) VALUES
(1, 'Cliente', 1),
(2, 'Proveedor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

DROP TABLE IF EXISTS `seguimiento`;
CREATE TABLE IF NOT EXISTS `seguimiento` (
  `s_idSeguimiento` int NOT NULL AUTO_INCREMENT,
  `s_idOperacion` varchar(10) NOT NULL,
  `s_FechaSeguimiento` datetime NOT NULL,
  `s_DescripcionOperacion` varchar(255) NOT NULL,
  `s_idEstatusO` float DEFAULT NULL,
  `s_UsuarioActualizo` int NOT NULL,
  `s_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`s_idSeguimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `seguimiento`
--

TRUNCATE TABLE `seguimiento`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontacto`
--

DROP TABLE IF EXISTS `tipocontacto`;
CREATE TABLE IF NOT EXISTS `tipocontacto` (
  `tc_idTipoContacto` int NOT NULL AUTO_INCREMENT,
  `tc_Descripcion` varchar(30) NOT NULL,
  `tc_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`tc_idTipoContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `tipocontacto`
--

TRUNCATE TABLE `tipocontacto`;
--
-- Volcado de datos para la tabla `tipocontacto`
--

INSERT INTO `tipocontacto` (`tc_idTipoContacto`, `tc_Descripcion`, `tc_Activo`) VALUES
(1, 'Fijo', 1),
(2, 'Movil', 1),
(3, 'eMail', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `td_idTipoDocumento` int NOT NULL AUTO_INCREMENT,
  `td_Descripcion` varchar(16) NOT NULL,
  `td_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`td_idTipoDocumento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `tipodocumento`
--

TRUNCATE TABLE `tipodocumento`;
--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`td_idTipoDocumento`, `td_Descripcion`, `td_Activo`) VALUES
(1, 'Factura', 1),
(2, 'Comp Egreso', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopersona`
--

DROP TABLE IF EXISTS `tipopersona`;
CREATE TABLE IF NOT EXISTS `tipopersona` (
  `tp_idTipoPersona` tinyint NOT NULL AUTO_INCREMENT,
  `tp_Descripcion` varchar(50) DEFAULT NULL,
  `tp_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tp_idTipoPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `tipopersona`
--

TRUNCATE TABLE `tipopersona`;
--
-- Volcado de datos para la tabla `tipopersona`
--

INSERT INTO `tipopersona` (`tp_idTipoPersona`, `tp_Descripcion`, `tp_Activo`) VALUES
(1, 'Fisica', 1),
(2, 'Moral', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `u_idUsuario` int NOT NULL AUTO_INCREMENT,
  `u_idPersona` varchar(255) DEFAULT NULL,
  `u_NombreUsuario` varchar(255) DEFAULT NULL,
  `u_Nombre` varchar(255) DEFAULT NULL,
  `u_Apellidos` varchar(255) DEFAULT NULL,
  `u_Llaveacceso` varchar(255) DEFAULT NULL,
  `u_idPerfil` varchar(255) DEFAULT NULL,
  `u_imagenUsuario` varchar(255) DEFAULT NULL,
  `u_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Truncar tablas antes de insertar `usuario`
--

TRUNCATE TABLE `usuario`;
--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`u_idUsuario`, `u_idPersona`, `u_NombreUsuario`, `u_Nombre`, `u_Apellidos`, `u_Llaveacceso`, `u_idPerfil`, `u_imagenUsuario`, `u_Activo`) VALUES
(1, 'MQ==', 'RGVtb1VzZXI=', 'Tm9tYnJlIFVzZXI=', 'QXBlbGxpZG8gVXNlcg==', 'ZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2U=', 'MQ==', 'L3RlbXByYWwvaW1hZ2VuLnBuZw==', 1),
(2, 'Mg==', 'RGVtb1VzZXIy', 'Tm9tYnJlIFVzdWFyaW8y', 'QXBlbGxpZG8gVXN1YXJpbzI=', NULL, 'MQ==', 'L3RlbXByYWwvaW1hZ2VuLnBuZw==', 1);

-- --------------------------------------------------------

--
-- Estructura para la vista `datos_persona`
--
DROP TABLE IF EXISTS `datos_persona`;

DROP VIEW IF EXISTS `datos_persona`;
CREATE VIEW `datos_persona`  AS SELECT `p`.`per_idPersona` AS `id_persona`, from_base64(`p`.`per_Nombre`) AS `nombre`, from_base64(`p`.`per_Alias`) AS `alias`, from_base64(`p`.`per_RFC`) AS `rfc`, from_base64(`p`.`per_idTipoPrersona`) AS `idtipopersona`, from_base64(`p`.`per_idRol`) AS `idrol`, from_base64(`p`.`per_ActivoFintec`) AS `activofintec`, from_base64(`p`.`per_RegimenFiscal`) AS `idregimenfiscal`, from_base64(`p`.`per_idCtaBanco`) AS `idcuentabanco`, `c2`.`Alias` AS `banco`, from_base64(`c`.`b_CLABE`) AS `clabe`, from_base64(`p`.`per_logo`) AS `logo_persona`, from_base64(`u`.`u_imagenUsuario`) AS `logo_usuario`, from_base64(`u`.`u_NombreUsuario`) AS `nombre_usuario`, from_base64(`r`.`rl_Nombre`) AS `nombre_representante`, from_base64(`u`.`u_Nombre`) AS `nombre_d_usaurio`, from_base64(`u`.`u_Apellidos`) AS `apellido_usuario`, `u`.`u_idUsuario` AS `id_usuario` FROM (((((((`persona` `p` join `representantelegal` `r` on((`p`.`per_idPersona` = from_base64(`r`.`rl_idPersona`)))) join `usuario` `u` on((from_base64(`r`.`rl_idPersona`) = from_base64(`u`.`u_idPersona`)))) join `tipopersona` `t` on((`t`.`tp_idTipoPersona` = from_base64(`p`.`per_idTipoPrersona`)))) join `cuentabancaria` `c` on((`c`.`b_idCatBanco` = from_base64(`p`.`per_idCtaBanco`)))) join `catbancos` `c2` on((`c`.`b_idCatBanco` = `c2`.`id`))) join `rol` on((`rol`.`r_idRol` = from_base64(`p`.`per_idRol`)))) join `perfil` on((`perfil`.`p_idPerfil` = from_base64(`u`.`u_idPerfil`)))) WHERE ((`p`.`per_Activo` = 1) AND (`u`.`u_Activo` = 1) AND (`r`.`rl_Activo` = 1) AND (`t`.`tp_Activo` = 1))  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
