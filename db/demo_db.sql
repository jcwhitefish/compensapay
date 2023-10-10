-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2023 at 11:58 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compensapay`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaContacto` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
  	declare resultado text;
	declare contenido varchar(50);
	declare idPersona int(3);
	declare idTipoContacto int(3);
set contenido = JSON_UNQUOTE(json_extract(entrada, '$.Contenido'));
set idPersona = JSON_UNQUOTE(json_extract(entrada, '$.idPersona'));
set idTipoContacto = JSON_UNQUOTE(json_extract(entrada, '$.idTipoContacto'));
insert
	into
	contacto (c_idTipoContacto,
	c_idPersona,
	c_Descripcion,
	c_Activo)
values
	(
	to_base64(aes_encrypt(idTipoContacto,llave)),
	to_base64(aes_encrypt(idPersona,llave)),
	to_base64(aes_encrypt(contenido,llave)),
	1
 	);
select
	count(c_Descripcion)
into
	resultado
from
	contacto c
where
	aes_decrypt(from_base64(c_idTipoContacto),llave) = idTipoContacto
	and 
	aes_decrypt(from_base64(c_idPersona),llave) = idPersona
	and 
	aes_decrypt(from_base64(c_Descripcion),llave) = Contenido
	and c_Activo = 1;

return resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaCtaBancaria` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin

	declare resultado text;
	declare idPersona int(3);
	declare idBanco int(3);
	declare contenido varchar(50);
	declare idcuenta int(3);
	declare existe int (3);
set idPersona = JSON_UNQUOTE(json_extract(entrada, '$.idPersona'));
set idBanco = JSON_UNQUOTE(json_extract(entrada, '$.idBanco'));
set contenido = JSON_UNQUOTE(json_extract(entrada, '$.CLABE'));
select
	c.b_idCtaBancaria
into
	existe
from
	cuentabancaria c
where
	aes_decrypt(from_base64(b_CLABE),llave)= contenido;

if existe then
	set resultado = 0;
else 
	insert
	into
	cuentabancaria (
								b_idCatBanco,
								b_CLABE,
								b_Activo 
								)
values
								(
								idBanco,
								to_base64(aes_encrypt(contenido,llave)),
								1
								);
select
	c.b_idCtaBancaria
into
	idcuenta
from
	cuentabancaria c
where
	aes_decrypt(from_base64(b_CLABE),llave)= contenido
	and b_Activo = 1 ;

update
	persona p
set
	p.per_idCtaBanco = to_base64(aes_encrypt(idcuenta,llave))
where
	p.per_idPersona = idPersona
	and p.per_Activo = 1;

select
	count(p.per_idCtaBanco)
into
	resultado
from
	persona p
where
	p.per_idPersona = idPersona
	and 
	p.per_Activo = 1;
end if;

return resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaDireccion` (`entrada` TEXT) RETURNS BLOB  begin
  	declare resultado blob;
  	declare idPersona int(3);
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
insert into direccion (	d_idPersona,
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
	direccion d  
where
	d.d_idPersona  = idPersona  
and d.d_Activo  = 1 ;
  RETURN resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPersona` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
  	declare resultado text;
	declare rfc varchar(16);
	set rfc = JSON_UNQUOTE(json_extract(entrada,'$.RFC'));
 insert into persona (per_Nombre,
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
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Nombre')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Apellido')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.Alias')),llave)),
 									to_base64(aes_encrypt(rfc,llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.TipoPersona')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Rol')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.ActivoFintec')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RegimenFical')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idCtaBanco')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Logo')),llave)),
 									1
 									);

select
	per_idPersona
into
	resultado
from
	persona p
where
	aes_decrypt(from_base64(per_RFC),llave) = rfc
	and per_Activo = 1;

  RETURN resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPregunta` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin
  	declare resultado blob;
  	declare contenido varchar(50);
	declare idPersona int(3);
	declare idPregunta int(3);
set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
set idPregunta = JSON_UNQUOTE(json_extract(entrada,'$.idPregunta'));
set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Respuesta'));
insert into preguntapersona (
										pp_idpersona,
										pp_idpregunta,
										pp_respuestapregunta,
										pp_Activo
 									) values
 									(idPersona,
 									idPregunta,
 									to_base64(aes_encrypt(upper(trim(contenido)),llave)),
 									1
 									);

  select
	count(pp_idpregunta)
into
	resultado
from
	preguntapersona p 
where
	pp_idpersona = idPersona and 
	pp_idpregunta = idPregunta 
	and pp_Activo = 1;
  RETURN resultado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaRepresentante` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin
  	declare resultado blob;
	declare nombre varchar(30);
set nombre = JSON_UNQUOTE(json_extract(entrada,'$.NombreRepresentante'));
insert
	into
	representantelegal (rl_Nombre,
	rl_RFC,
	rl_idPersona,
	rl_Activo)
values
	(
	to_base64(aes_encrypt(nombre,llave)),
	to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RFC')),llave)),
	to_base64(aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPersona')),llave)),
	1);

select
	count(rl_Nombre)
into
	resultado
from
	representantelegal
where
	aes_decrypt(from_base64(rl_Nombre),llave) = nombre
	and rl_Activo = 1;

return resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregarOperacion` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
	declare resultado text;
	declare idOperacion int;
	
	declare NumOperacion int;
	declare idPersona int;
	declare FechaEmision text;
	declare SubTotal float;
	declare Impuesto float;
	declare Total float;
	declare ArchivoXML longtext;
	declare UID text;
	declare idTipoDocumento int;
	declare idUsuario int;

	set NumOperacion = JSON_UNQUOTE(json_extract(entrada,'$.NumOperacion'));
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
	set FechaEmision = JSON_UNQUOTE(json_extract(entrada,'$.FechaEmision'));
	set SubTotal = JSON_UNQUOTE(json_extract(entrada,'$.SubTotal'));
	set Impuesto = JSON_UNQUOTE(json_extract(entrada,'$.Impuesto'));
	set Total = JSON_UNQUOTE(json_extract(entrada,'$.Total'));
	set ArchivoXML = JSON_UNQUOTE(json_extract(entrada,'$.ArchivoXML'));
	set UID = JSON_UNQUOTE(json_extract(entrada,'$.UID'));
	set idTipoDocumento = JSON_UNQUOTE(json_extract(entrada,'$.idTipoDocumento'));
	set idUsuario =  JSON_UNQUOTE(json_extract(entrada,'$.idUsuario'));

insert into operacion 
(
	o_NumOperacion,
	o_idPersona,
	o_FechaEmision,
	o_subtotal,
	o_impuesto,
	o_total,
	o_ArchivoXML,
	o_UUID,
	o_idTipoDocumento,
	o_FechaUpload,
	o_Activo
) values (
	NumOperacion,
	idPersona,
	FechaEmision,
	SubTotal,
	Impuesto,
	Total,
	to_base64(ArchivoXML),
	to_base64(UID),
	idTipoDocumento,
	now(),
	1
);




select
	o_idOperacion
into
	idOperacion
from
	operacion o
where
	o.o_NumOperacion = NumOperacion and
	o.o_idPersona = idPersona and 
	o.o_UUID = to_base64(UID) 
	and o.o_Activo = 1;

insert into seguimiento
(
	s_idOperacion,
	s_FechaSeguimiento,
	s_DescripcionOperacion,
	s_idEstatusO,
	s_UsuarioActualizo,
	s_Activo
)
values
(
	idOperacion,
	now(),
	concat("Alta de Documento ",(select td_Descripcion from tipodocumento where td_idTipoDocumento=idTipoDocumento)),
	1,
	idUsuario,
	1
);

select
	o_idOperacion
into
	resultado
from
	operacion o
where
	o.o_NumOperacion = NumOperacion and
	o.o_idPersona = idPersona and 
	o.o_UUID = to_base64(UID) 
	and o.o_Activo = 1;

return resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaUsuario` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin
  	declare resultado blob;
  	declare nomuser varchar(30);
	set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));
	insert into usuario (u_NombreUsuario,
 									u_Nombre ,
 									u_Apellidos ,
 									u_Llaveacceso,
 									u_idPersona,
 									u_idPerfil,
 									u_imagenUsuario,
 									u_Activo) values
 									(
 									to_base64(aes_encrypt(nomuser,llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Nombre')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Apellidos')),llave)),
 									to_base64(aes_encrypt(MD5(JSON_UNQUOTE(json_extract(entrada,'$.LlaveAcceso'))),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idPersona')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPerfil')),llave)),
 									to_base64(aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.urlImagen')),llave)),
 									1
 									);

  select
	count(u_NombreUsuario)
into
	resultado
from
	usuario
where
	aes_decrypt(from_base64(u_NombreUsuario),llave) = nomuser
	and u_Activo = 1;								

  RETURN resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaEmpresa` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin
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
on p.per_idPersona = from_base64(r.rl_idPersona)
inner join usuario u 
on from_base64(r.rl_idPersona) = from_base64(u.u_idPersona)
inner join tipopersona t 
on t.tp_idTipoPersona = from_base64(p.per_idTipoPrersona)
inner join cuentabancaria c
	on c.b_idCatBanco = from_base64(per_idCtaBanco)
inner join catbancos c2 
	on c.b_idCatBanco = c2.id 
where
	per_Activo = 1
and u_Activo = 1
and rl_Activo = 1
and t.tp_Activo = 1
and per_idPersona = idPersona;

return resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaPersona` (`entrada` INT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin

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
inner join cuentabancaria c 
	on c.b_idCatBanco = from_base64(per_idCtaBanco)
inner join catbancos c2 
	on c.b_idCatBanco = c2.id 
inner join compensapay.rol 
	on rol.r_idRol= from_base64(p.per_idRol)
inner join compensapay.perfil 
	on perfil.p_idPerfil = from_base64(u.u_idPerfil) 
where
	per_Activo = 1
	and u_Activo = 1
	and rl_Activo = 1
	and t.tp_Activo = 1
	and per_idPersona = entrada;

 return salida;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ConsutlarEstadosMX` () RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin

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

CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteRFC` (`entrada` VARCHAR(20), `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin
  declare salida text;
select
	concat_ws("|",
	concat('RFC:',aes_decrypt(from_base64(per_RFC),llave)),
	concat('Nombre:',aes_decrypt(from_base64(per_Nombre),llave)),
	concat('alias:',aes_decrypt(from_base64(per_Alias),llave))
	)
into
	salida
from
	persona
where
	aes_decrypt(from_base64(per_RFC),llave) = entrada;
return salida;

end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteUsuario` (`entrada` VARCHAR(50), `llave` VARCHAR(100)) RETURNS INT(11)  BEGIN

  DECLARE salida int;
 	select count(u_NombreUsuario) 
	into salida 
	from usuario 
	where aes_decrypt(from_base64(u_NombreUsuario),llave) = entrada;
  RETURN salida;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateContacto` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
  	declare resultado text;
	declare contenido varchar(50);
	declare idPersona int(3);
	declare idTipoContacto int(3);
	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Contenido'));
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
	set idTipoContacto = JSON_UNQUOTE(json_extract(entrada,'$.idTipoContacto'));

update
	contacto c
set
	c.c_Activo = 0
where
	aes_decrypt(from_base64(c_idPersona),llave) = idPersona
and aes_decrypt(from_base64(c_idTipoContacto),llave) = idTipoContacto
and c.c_Activo = 1;

insert into contacto (
		c_idTipoContacto,
 		c_idPersona,
 		c_Descripcion,
 		c_Activo) 
 		values
 		(to_base64(aes_encrypt(idTipoContacto,llave)),
 		to_base64(aes_encrypt(idPersona,llave)),
 		to_base64(aes_encrypt(contenido,llave)),
 		1
 		);
  
 	select
		count(c_Descripcion)
	into
		resultado
	from
		contacto c 
	where
		aes_decrypt(from_base64(c_idTipoContacto),llave) = idTipoContacto and 
		aes_decrypt(from_base64(c_idPersona),llave) = idPersona and 
		aes_decrypt(from_base64(c_Descripcion),llave) = Contenido
	and c_Activo = 1;
  RETURN resultado;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateCtaBancaria` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin

	declare resultado text;
	declare idPersona int(3);
	declare idBanco int(3);
	declare contenido varchar(50);
	declare idcuenta int(3);
	declare existe int (3);
set idPersona = JSON_UNQUOTE(json_extract(entrada, '$.idPersona'));
set idBanco = JSON_UNQUOTE(json_extract(entrada, '$.idBanco'));
set contenido = JSON_UNQUOTE(json_extract(entrada, '$.CLABE'));

select
	c.b_idCtaBancaria
into
	existe
from
	cuentabancaria c
where
	from_base64(b_CLABE)= contenido;


update cuentabancaria ct
set 
	b_idCatBanco = idBanco,
	b_CLABE = to_base64(contenido),
	b_Activo = 1	
where ct.b_idCtaBancaria = existe;
			 				
select
	count(p.per_idCtaBanco)
into
	resultado
from
	persona p
inner join cuentabancaria c on
p.per_idCtaBanco = c.b_idCtaBancaria 
where
	p.per_idPersona = idPersona
	and 
	p.per_Activo = 1
	and c.b_CLABE = from_base64(contenido); 

return resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateDireccion` (`entrada` TEXT) RETURNS BLOB  begin

  	declare resultado blob;
  	declare idPersona int(3);
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
update 
	direccion 
set 
	d_Activo = 0 
where d_idPersona = idPersona and d_Activo = 1;

insert into direccion (	d_idPersona,
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
	direccion d  
where
	d.d_idPersona  = idPersona  
and d.d_Activo  = 1 ;
  RETURN resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateLlaveUsuario` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin

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
	usuario u
 inner join perfil p on from_base64(u.u_idPerfil) = p.p_idPerfil 
	where
	u.u_idUsuario = iduser
	and from_base64(u.u_Llaveacceso) = md5(llave_interna);
return resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UpdatePersona` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin

	declare resultado text;
	declare rfc varchar(16);
	declare idpersona varchar(4);
	set idpersona = JSON_UNQUOTE(json_extract(entrada,'$.idpersona'));
	set rfc = JSON_UNQUOTE(json_extract(entrada,'$.RFC'));
update
	persona p
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
	persona p
where
	p.per_idPersona = idpersona
	and p.per_Activo = 1;

return resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateUsuario` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS BLOB  begin

  	declare resultado blob;
 	declare nomuser varchar(30);
	set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));

update usuario 
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
  from usuario 
  where from_base64(u_NombreUsuario) = nomuser 
  and u_Activo = 1;								

return resultado;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `ValidarLlave` (`entrada` TEXT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin

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
	usuario u
inner join perfil p on from_base64(u.u_idPerfil) = p.p_idPerfil 
	where
	from_base64(u_NombreUsuario) = usuario
	and from_base64(u_Llaveacceso) = md5(llave_interna);
RETURN resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `VerBanco` (`entrada` VARCHAR(4)) RETURNS VARCHAR(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
  declare salida varchar(100);
select
	JSON_OBJECT (
		'idBanco',b.id,
		'Clave',b.Clave,
		'Alias',b.Alias  
	)
into
	salida
from
	catbancos b
where
	b.Clave = entrada;
return salida;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `VerCatPreguntas` () RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin

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

CREATE DEFINER=`root`@`localhost` FUNCTION `verContacto` (`entrada` INT, `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin

  declare resultado text;
 
 select
 GROUP_CONCAT(
  concat_ws("|",
	concat('TipoContacto:',t.tc_Descripcion),
	concat('Contacto:',aes_decrypt(from_base64(c.c_Descripcion ),llave))
	))
into
	resultado
from
	contacto c 
inner join tipocontacto t on t.tc_idTipoContacto = aes_decrypt(from_base64(c.c_idTipoContacto),llave) 
	where
	 aes_decrypt(from_base64(c.c_idPersona),llave) = entrada
	and c.c_Activo = 1;
RETURN resultado;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `verGiro` () RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
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

CREATE DEFINER=`root`@`localhost` FUNCTION `VerOperaciones` (`entrada` INT(4), `llave` VARCHAR(100)) RETURNS TEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  begin
	 declare salida text;
	select
		GROUP_CONCAT(
			concat_ws('|', 
				concat('NumOperacion:', o.o_NumOperacion),
				concat('FechaEmision:', o.o_FechaEmision),
				concat('FechaUpdate:',o.o_FechaUpload) ,
				concat('Total:',o.o_Total) ,
				concat('Impuestos:',o.o_Impuesto) ,
				concat('Subtotal:',o.o_SubTotal) ,
				concat('TipoDocumento:',t.td_Descripcion) ,
				concat('UUID:',from_base64(o.o_UUID)) ,
				concat('AliasCliente:',from_base64(p.per_Alias)),
				concat('Estatus: ',eo.eo_Descripcion),
				concat('RFCCliente:',from_base64(p.per_RFC)) 
				))
	   		into salida
		from
			operacion o
		inner join persona p on
			o.o_idPersona = p.per_idPersona
		inner join tipodocumento t on
			t.td_idTipoDocumento = o.o_idTipoDocumento
		inner join seguimiento s on
			s.s_idOperacion = o.o_idOperacion 
		inner join estatuso eo on
			eo.eo_idEstatusO = s.s_idEstatusO 
		where
			o.o_Activo = 1
		and t.td_Activo = 1
		and p.per_Activo = 1
		and p.per_idPersona = entrada;
return salida;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `VerRegimenFiscal` (`tipopersona` INT) RETURNS TEXT CHARSET latin1 COLLATE latin1_swedish_ci  begin

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
-- Table structure for table `acceso`
--

CREATE TABLE `acceso` (
  `a_idAcceso` int(11) NOT NULL,
  `a_idUsuario` int(11) NOT NULL,
  `a_Llave` varchar(255) NOT NULL,
  `a_Sesion` varchar(127) NOT NULL,
  `a_CambiarLlave` tinyint(1) DEFAULT NULL,
  `a_UlimoAcceso` datetime DEFAULT NULL,
  `a_Activo` tinyint(1) NOT NULL,
  `PreguntaSeguridad` varchar(255) DEFAULT NULL,
  `RespuestaSeguridad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catbancos`
--

CREATE TABLE `catbancos` (
  `id` int(11) NOT NULL,
  `Clave` varchar(3) DEFAULT NULL,
  `Alias` varchar(50) DEFAULT NULL,
  `Nombre` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catbancos`
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
-- Table structure for table `catgiro`
--

CREATE TABLE `catgiro` (
  `g_idGiro` int(11) NOT NULL,
  `g_Giro` varchar(255) NOT NULL,
  `g_Activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catgiro`
--

INSERT INTO `catgiro` (`g_idGiro`, `g_Giro`, `g_Activo`) VALUES
(1, 'Producción', 1),
(2, 'Transformación', 1),
(3, 'Servicios', 1);

-- --------------------------------------------------------

--
-- Table structure for table `catpreguntas`
--

CREATE TABLE `catpreguntas` (
  `pg_idpregunta` int(11) NOT NULL,
  `pg_pregunta` varchar(255) NOT NULL,
  `pg_activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catpreguntas`
--

INSERT INTO `catpreguntas` (`pg_idpregunta`, `pg_pregunta`, `pg_activo`) VALUES
(1, '¿Cuál es tu película favorita?', 1),
(2, '¿Nombre de tu primera mascota?', 1),
(3, '¿Segundo apellido de tu mamá?', 1);

-- --------------------------------------------------------

--
-- Table structure for table `catregimenfiscal`
--

CREATE TABLE `catregimenfiscal` (
  `rg_id_regimen` int(11) DEFAULT NULL,
  `rg_Clave` int(11) DEFAULT NULL,
  `rg_Regimen` varchar(128) DEFAULT NULL,
  `rg_P_Fisica` int(11) DEFAULT NULL,
  `rg_P_Moral` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catregimenfiscal`
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
-- Table structure for table `cattipovalor`
--

CREATE TABLE `cattipovalor` (
  `cv_idTipoValor` int(11) NOT NULL,
  `cv_Descripcion` varchar(255) NOT NULL,
  `cv_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cattipovalor`
--

INSERT INTO `cattipovalor` (`cv_idTipoValor`, `cv_Descripcion`, `cv_Activo`) VALUES
(1, 'Cadena', 1),
(2, 'Numerico', 1),
(3, 'Logico', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clienteproveedor`
--

CREATE TABLE `clienteproveedor` (
  `cp_idClienteProveedor` int(11) NOT NULL,
  `cp_idPersonaCliente` int(11) NOT NULL,
  `cp_idPersonaProveedor` varchar(100) NOT NULL,
  `cp_Nota` varchar(50) NOT NULL,
  `cp_idEstatusCP` int(11) DEFAULT NULL,
  `cp_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clienteproveedor`
--

INSERT INTO `clienteproveedor` (`cp_idClienteProveedor`, `cp_idPersonaCliente`, `cp_idPersonaProveedor`, `cp_Nota`, `cp_idEstatusCP`, `cp_Activo`) VALUES
(1, 1, '2', 'na', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `compensacion`
--

CREATE TABLE `compensacion` (
  `cm_idCompensacion` int(11) NOT NULL,
  `cm_idPersonaCliente` int(11) NOT NULL,
  `cm_idPersonaProveedor` varchar(100) NOT NULL,
  `cm_idEstatusCM` varchar(50) NOT NULL,
  `cm_idOperacion` int(11) DEFAULT NULL,
  `cm_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `cnf_idConfiguracion` int(11) NOT NULL,
  `cnf_idPersona` int(11) NOT NULL,
  `cnf_idElementoConfigurable` int(11) NOT NULL,
  `cnf_Valor` varchar(100) NOT NULL,
  `cnf_Activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`cnf_idConfiguracion`, `cnf_idPersona`, `cnf_idElementoConfigurable`, `cnf_Valor`, `cnf_Activo`) VALUES
(1, 1, 1, '/nombre_archivo.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE `contacto` (
  `c_idContacto` int(11) NOT NULL,
  `c_idTipoContacto` text NOT NULL,
  `c_idPersona` text NOT NULL,
  `c_Descripcion` text NOT NULL,
  `c_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacto`
--

INSERT INTO `contacto` (`c_idContacto`, `c_idTipoContacto`, `c_idPersona`, `c_Descripcion`, `c_Activo`) VALUES
(1, 'Mw==', 'MQ==', 'dWlzdWFyaW9AZG9taW5pby5jb20=', 1),
(2, 'Mw==', 'Mg==', 'dWlzdWFyaW9AZG9taW5pby5jb20=', 1),
(3, 'MQ==', 'Mg==', 'NTUzNjM5MTY5Mg==', 1),
(4, 'MQ==', 'Mw==', 'NTUzNjM5MTY5Mg==', 1),
(5, 'MQ==', 'NA==', 'NTUzNjM5MTY5Mg==', 1),
(6, 'Mw==', 'Mw==', 'dXN1YXJpb0Bjb250YWN0by5jb20=', 1),
(7, 'Mw==', 'NA==', 'dXN1YXJpb2UyQGNvbnRhY3RvLmNvbQ==', 1),
(8, 'CgTW1WFYeoUO9082GFnvGA==', '1dvx9EtS/l7Bdfg2ms3o8g==', '2ROSMSdob4DOgpQohDNgWVqdnrbrXiOqYQ9IV4g79Nc=', 1),
(9, 'vAFnCnmxypZh26+H5VW3Wg==', '1dvx9EtS/l7Bdfg2ms3o8g==', '87ka+UID7q5iineMC94Drg==', 0),
(10, 'vAFnCnmxypZh26+H5VW3Wg==', '1dvx9EtS/l7Bdfg2ms3o8g==', 'Nbx8PYbJ3mCpP3mdpN1cQA==', 0),
(11, 'vAFnCnmxypZh26+H5VW3Wg==', '1dvx9EtS/l7Bdfg2ms3o8g==', 'Nbx8PYbJ3mCpP3mdpN1cQA==', 0),
(12, 'vAFnCnmxypZh26+H5VW3Wg==', '1dvx9EtS/l7Bdfg2ms3o8g==', '/NPGcR+MbdguKvugDUi/zg==', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuentabancaria`
--

CREATE TABLE `cuentabancaria` (
  `b_idCtaBancaria` int(11) NOT NULL,
  `b_idCatBanco` int(11) NOT NULL,
  `b_CLABE` varchar(255) NOT NULL,
  `b_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuentabancaria`
--

INSERT INTO `cuentabancaria` (`b_idCtaBancaria`, `b_idCatBanco`, `b_CLABE`, `b_Activo`) VALUES
(1, 1, 'MTIzNDQ1Njc4OTk=', 1),
(2, 1, 'OTk5OTk5OTk5OTk=', 1),
(3, 1, 'OTk5OTk4OTk5OTk5', 1),
(4, 1, 'OTk5OTk3OTk5OTk5', 1),
(5, 1, 'OTk5OTk2OTk5OTk5', 1),
(6, 1, 'OTk5OTk1OTk5OTk5', 1),
(7, 1, 'OTk5OTk5OTk5OTk5', 1),
(8, 1, 'MTIzMTIzMTIzMTIz', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `datos_persona`
-- (See below for the actual view)
--
CREATE TABLE `datos_persona` (
`id_persona` int(11)
,`nombre` mediumblob
,`alias` mediumblob
,`rfc` mediumblob
,`idtipopersona` mediumblob
,`idrol` mediumblob
,`activofintec` mediumblob
,`idregimenfiscal` mediumblob
,`idcuentabanco` mediumblob
,`banco` varchar(50)
,`clabe` blob
,`logo_persona` mediumblob
,`logo_usuario` blob
,`nombre_usuario` blob
,`nombre_representante` blob
,`nombre_d_usaurio` blob
,`apellido_usuario` blob
,`id_usuario` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `direccion`
--

CREATE TABLE `direccion` (
  `d_idDireccion` int(11) NOT NULL,
  `d_idPersona` int(11) NOT NULL,
  `d_CalleYNumero` varchar(100) NOT NULL,
  `d_Colonia` varchar(50) NOT NULL,
  `d_Ciudad` varchar(50) DEFAULT NULL,
  `d_Estado` varchar(50) DEFAULT NULL,
  `d_CodPost` int(11) DEFAULT NULL,
  `d_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `direccion`
--

INSERT INTO `direccion` (`d_idDireccion`, `d_idPersona`, `d_CalleYNumero`, `d_Colonia`, `d_Ciudad`, `d_Estado`, `d_CodPost`, `d_Activo`) VALUES
(1, 1, 'Calle en una ciudad 34', 'Colonia conocida', 'Ciudad perdida', 'México', 66666, 1),
(2, 2, 'Calle en una ciudad X 34', 'Colonia desconocida', 'Ciudad encontrada', 'México', 66666, 1),
(3, 3, 'Calle en una ciudad X 34', 'Colonia desconocida', 'Ciudad encontrada', 'México', 66666, 0),
(4, 4, 'Calle en una ciudad X 34', 'Colonia desconocida', 'Ciudad encontrada', 'México', 66666, 0),
(5, 3, 'Calle en una ciudad 34', 'Colonia conocida', 'Ciudad perdida', 'México', 66666, 1),
(6, 4, 'Calle en una ciudad 34', 'Colonia conocida', 'Ciudad perdida', 'México', 66666, 1);

-- --------------------------------------------------------

--
-- Table structure for table `elementoconfigurable`
--

CREATE TABLE `elementoconfigurable` (
  `ec_idElementoConfigurable` int(11) NOT NULL,
  `ec_Descripcion` varchar(255) NOT NULL,
  `ec_idTipoValor` int(11) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elementoconfigurable`
--

INSERT INTO `elementoconfigurable` (`ec_idElementoConfigurable`, `ec_Descripcion`, `ec_idTipoValor`, `ec_Activo`) VALUES
(1, 'ImagenPerfil', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `estados`
--

CREATE TABLE `estados` (
  `e_IdEstado` int(11) DEFAULT NULL,
  `e_Descripcion` varchar(50) DEFAULT NULL,
  `e_alias` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estados`
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
-- Table structure for table `estatuscm`
--

CREATE TABLE `estatuscm` (
  `ec_idEstatusCM` int(11) NOT NULL,
  `ec_Descripcion` varchar(16) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estatuscm`
--

INSERT INTO `estatuscm` (`ec_idEstatusCM`, `ec_Descripcion`, `ec_Activo`) VALUES
(1, 'Alta', 1),
(2, 'Conciliada', 1),
(3, 'Pagada', 1);

-- --------------------------------------------------------

--
-- Table structure for table `estatuscp`
--

CREATE TABLE `estatuscp` (
  `ecp_idEstatusCP` int(11) NOT NULL,
  `ecp_Descripcion` varchar(16) NOT NULL,
  `ecp_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estatuscp`
--

INSERT INTO `estatuscp` (`ecp_idEstatusCP`, `ecp_Descripcion`, `ecp_Activo`) VALUES
(1, 'Alta', 1),
(2, 'Baja', 1),
(3, 'En aprobación', 1);

-- --------------------------------------------------------

--
-- Table structure for table `estatuso`
--

CREATE TABLE `estatuso` (
  `eo_idEstatusO` int(11) NOT NULL,
  `eo_Descripcion` varchar(16) NOT NULL,
  `eo_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estatuso`
--

INSERT INTO `estatuso` (`eo_idEstatusO`, `eo_Descripcion`, `eo_Activo`) VALUES
(1, 'Cargada', 1),
(2, 'Por autroizar', 1),
(3, 'Autorizada', 1),
(4, 'Proceso pago', 1),
(5, 'Pagada', 1);

-- --------------------------------------------------------

--
-- Table structure for table `moduloperfil`
--

CREATE TABLE `moduloperfil` (
  `mp_idModuloPerfil` int(11) NOT NULL,
  `mp_idModulo` tinyint(4) DEFAULT NULL,
  `mp_idPerfil` tinyint(4) DEFAULT NULL,
  `mp_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modulos`
--

CREATE TABLE `modulos` (
  `m_idModulo` tinyint(4) NOT NULL,
  `m_Descripcion` varchar(30) NOT NULL,
  `m_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operacion`
--

CREATE TABLE `operacion` (
  `o_idOperacion` int(11) NOT NULL,
  `o_NumOperacion` varchar(13) NOT NULL,
  `o_idPersona` int(11) NOT NULL,
  `o_FechaEmision` datetime NOT NULL,
  `o_Total` float DEFAULT NULL,
  `o_ArchivoXML` text NOT NULL,
  `o_UUID` text NOT NULL,
  `o_idTipoDocumento` int(11) NOT NULL,
  `o_SubTotal` float DEFAULT NULL,
  `o_Impuesto` float NOT NULL,
  `o_FechaUpload` datetime NOT NULL,
  `o_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operacion`
--

INSERT INTO `operacion` (`o_idOperacion`, `o_NumOperacion`, `o_idPersona`, `o_FechaEmision`, `o_Total`, `o_ArchivoXML`, `o_UUID`, `o_idTipoDocumento`, `o_SubTotal`, `o_Impuesto`, `o_FechaUpload`, `o_Activo`) VALUES
(13, 'OPQR345678STU', 6, '2023-09-20 00:00:00', 13200000, '', '1b9e3f5d-6c6a-4e8e-af3a-8c11dab7c943\n', 2, 114000, 18000, '2023-09-28 14:06:11', 0),
(28, 'OPQR345678STU', 6, '2023-09-20 00:00:00', 64800, '', 'c15a8a57-708d-48d6-883f-19e7c6fbd7d0\n', 2, 56000, 8800, '2023-09-28 14:24:23', 0),
(29, 'VWXY901234ZAB', 6, '2023-09-20 00:00:00', 179200, '', '9517a20a-617c-4224-bcb4-be2da726cfb4', 2, 154000, 25200, '2023-09-28 14:24:25', 1),
(41, 'JKLM123456NOP', 6, '2023-06-29 14:51:30', 104000, 'xd', '9517a20a-617c-4224-bcb4-be2da726cfb4', 2, 90000, 14000, '2023-06-29 14:51:30', 1),
(42, 'XYZA234567BCD', 6, '2023-06-29 14:51:30', 45600, 'xd', '9517a20a-617c-4224-bcb4-be2da726cfb4', 2, 39000, 6600, '2023-06-29 14:51:30', 1),
(43, 'STUV901234WXY', 6, '2023-06-29 14:51:30', 198000, 'xd', '9517a20a-617c-4224-bcb4-be2da726cfb4', 0, 170000, 28000, '2023-06-29 14:51:30', 0),
(44, 'ZABC456789DEF', 6, '2023-06-29 14:51:30', 27600, 'xd', '9517a20a-617c-4224-bcb4-be2da726cfb4', 0, 24000, 3600, '2023-06-29 14:51:30', 1),
(45, 'IJKL901234MNO', 6, '2023-06-29 14:51:30', 72800, 'xd', '9517a20a-617c-4224-bcb4-be2da726cfb4', 0, 62500, 10300, '2023-06-29 14:51:30', 1),
(59, 'CAFJ741213143', 6, '2023-06-29 14:51:30', 162400, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" Certificado=\"MIIF5jCCA86gAwIBAgIUMDAwMDEwMDAwMDA1MTIyMjk4NTgwDQYJKoZIhvcNAQELBQAwggGEMSAwHgYDVQQDDBdBVVRPUklEQUQgQ0VSVElGSUNBRE9SQTEuMCwGA1UECgwlU0VSVklDSU8gREUgQURNSU5JU1RSQUNJT04gVFJJQlVUQVJJQTEaMBgGA1UECwwRU0FULUlFUyBBdXRob3JpdHkxKjAoBgkqhkiG9w0BCQEWG2NvbnRhY3RvLnRlY25pY29Ac2F0LmdvYi5teDEmMCQGA1UECQwdQVYuIEhJREFMR08gNzcsIENPTC4gR1VFUlJFUk8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQQ0lVREFEIERFIE1FWElDTzETMBEGA1UEBwwKQ1VBVUhURU1PQzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMVwwWgYJKoZIhvcNAQkCE01yZXNwb25zYWJsZTogQURNSU5JU1RSQUNJT04gQ0VOVFJBTCBERSBTRVJWSUNJT1MgVFJJQlVUQVJJT1MgQUwgQ09OVFJJQlVZRU5URTAeFw0yMjA0MDQxNTUxMzhaFw0yNjA0MDQxNTUxMzhaMIG0MSMwIQYDVQQDFBpKVUFOIENBUkxPUyBDQVJSRdFPIEZMT1JFUzEjMCEGA1UEKRQaSlVBTiBDQVJMT1MgQ0FSUkXRTyBGTE9SRVMxIzAhBgNVBAoUGkpVQU4gQ0FSTE9TIENBUlJF0U8gRkxPUkVTMRYwFAYDVQQtEw1DQUZKNzQxMjEzVUc0MRswGQYDVQQFExJDQUZKNzQxMjEzSERGUkxOMDgxDjAMBgNVBAsTBVVOSUNBMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhkE5K+3EKPhX2P8Fe7PCLmECCOocG60/dakiRwCIesw1AK0cs2n9XHb5cyA/CNvnSfRBBH7Xjq+rWfbtb6219ZIGCONQnt4ovg54brIq5jxHOPz0t3HAqSbqZnx3WyQHCrF/eUd/grwSGUU+0EhN6EfHHqXaXIi1UfKqE3EdbH+xlHcDXMwiGIo8wSXPKQwdUQwHGlKZfzh/oOLZBOQ8znCZrz0dCdZ8t9gYIHRYbgPE8Vthm7vxWP+oQI/60u0f6MsFcgcai/9vD7pCOvjP9OMC43xs4eOQ4ifWh7QQLAtqpjdBzx3OHS6I3j2kZgIQi5U0K08A15qZGA/2M2j+uwIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAegSc+m1ZX27e9tKKQd0HtZl/PLwjK/MSD0keO58Z1n4Jf5GwvxGIgwlsY5vGX9EmglJTKpf9Q33xM5N0Suy/YZfaU5UwvsM3I15jcr1Fgfpghn109KZaBGikP6YHMO4nUqEB6/3Lpm4K0QnY1hLiKfLJkJfVi8HPJ3T4b1txBJpHOl9TjpXvMuZV+kustiyFPG01A3d47NBJQQ5yr82XkWIdZkJqjhTGOags5SBJyUPZydY/JkbLkxGWlP00yu5qPy5VWnByzucEBKihry+sLx922p7ZsH/RfU/WqAIanB1DnBZ1r7YkIaejuzEtJqfMe1vJtpUaMhBoG/uOeTNF2cHi91FOApJOUHwZ0+DWtEKtfuVCXhEoMFaO/Xp99JMTOA68AgOjIdthNKcZnYto+X0g/lbjvdxdviXG+4PYeuLdXmx6vS6vkO6jhfBG0bQL93BxhiSd3mMGZKB3+Q/u5GjwR+d4wdsdNemXbF8JNDoQiAer6j/cLPR+1dRJgWgdNl8QgsdoMnq9YifsiliZpS7OB2ueXosUlDwzZYYvZUusv7QXTXEKpRh6jtfFFvYJjGKYXPQD6i9TU3qrV2n82oStMfFEIwftiiGbFGdeWtBsXiNxAnl2Ohiy/YFmfZLPt9/bFW6eILMuBBTolnPeCCahGeyH83rRQjOGodkK85s=\" Exportacion=\"01\" Fecha=\"2023-06-29T14:51:30\" FormaPago=\"03\" LugarExpedicion=\"55404\" MetodoPago=\"PUE\" Moneda=\"MXN\" NoCertificado=\"00001000000512229858\" Sello=\"STWGz81fpnDXd0BDXhImys5vpWG9Wib/LYgZb8Ar8fJaktfTuAkIe8ftYq6+lJs2NOYhKcrcXmi2pcT+CgXdc4a5ciJjTu1djF5raYUGh1mLzWpyQBBlda+J9KklXmvNd1uCJJ8lfrvjHteTqAdI/kJmlloloAPNb8++sEcZrF6fTpcn8uXorai0sG542yBYUb/ElrcTq+NLrvQIU4vAWY9iNwmxj2XuItA1mIBbqWOo3EKC8YmFRdeCW/okpQfDqMw1R18wI0IRIcUDGZvr+bRlDhO2XG1ednvtDa1DYGby/NzspDd8DV1JHN4Tz5ZVGubkfvRf+OXYFb2A/PL1wg==\" SubTotal=\"3000.00\" TipoCambio=\"1\" TipoDeComprobante=\"I\" Total=\"3480.00\" Version=\"4.0\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd\">\n    <cfdi:Emisor Nombre=\"JUAN CARLOS CARREÑO FLORES\" RegimenFiscal=\"621\" Rfc=\"CAFJ741213UG4\"/>\n    <cfdi:Receptor DomicilioFiscalReceptor=\"06400\" Nombre=\"VANYA PEREZ HERRERA\" RegimenFiscalReceptor=\"612\" Rfc=\"PEHV751002371\" UsoCFDI=\"G03\"/>\n    <cfdi:Conceptos>\n        <cfdi:Concepto Cantidad=\"1\" ClaveProdServ=\"81112106\" ClaveUnidad=\"ACT\" Descripcion=\"Desarrollo de Encuesta\" Importe=\"3000.00\" NoIdentificacion=\"NO APLICA\" ObjetoImp=\"02\" ValorUnitario=\"3000.00\">\n            <cfdi:Impuestos>\n                <cfdi:Traslados>\n                    <cfdi:Traslado Base=\"3000.00\" Importe=\"480.00\" Impuesto=\"002\" TasaOCuota=\"0.160000\" TipoFactor=\"Tasa\"/>\n                </cfdi:Traslados>\n            </cfdi:Impuestos>\n        </cfdi:Concepto>\n    </cfdi:Conceptos>\n    <cfdi:Impuestos TotalImpuestosTrasladados=\"480.00\">\n        <cfdi:Traslados>\n            <cfdi:Traslado Base=\"3000.00\" Importe=\"480.00\" Impuesto=\"002\" TasaOCuota=\"0.160000\" TipoFactor=\"Tasa\"/>\n        </cfdi:Traslados>\n    </cfdi:Impuestos>\n    <cfdi:Complemento>\n        <tfd:TimbreFiscalDigital xmlns:tfd=\"http://www.sat.gob.mx/TimbreFiscalDigital\" FechaTimbrado=\"2023-06-29T14:51:32\" NoCertificadoSAT=\"00001000000506403528\" RfcProvCertif=\"CCC1007293K0\" SelloCFD=\"STWGz81fpnDXd0BDXhImys5vpWG9Wib/LYgZb8Ar8fJaktfTuAkIe8ftYq6+lJs2NOYhKcrcXmi2pcT+CgXdc4a5ciJjTu1djF5raYUGh1mLzWpyQBBlda+J9KklXmvNd1uCJJ8lfrvjHteTqAdI/kJmlloloAPNb8++sEcZrF6fTpcn8uXorai0sG542yBYUb/ElrcTq+NLrvQIU4vAWY9iNwmxj2XuItA1mIBbqWOo3EKC8YmFRdeCW/okpQfDqMw1R18wI0IRIcUDGZvr+bRlDhO2XG1ednvtDa1DYGby/NzspDd8DV1JHN4Tz5ZVGubkfvRf+OXYFb2A/PL1wg==\" SelloSAT=\"t3qBhVJINlkWRR6636WEL7yH+h/jiIQpx9+itMsGRi/iq/VLfUn/7pDvji6C/EdHxe3pEbCM6a8K5mYkYTkhRZy/rij0Aar+T73qezJswcvGyj4U2LXt6Kt7JcYu8zy6ESdkIp3GVQBpnpnBfc9KMB8qbNGE+w+ck/n72YnKsmShdCbpGRAgjDJof1HoN/UNddLFBsVZIHrlVBJPuJjQgnGDmmJwa1GiHPf0m8kpAbcvOswf2AhadZawiNMJf+9s2dzZ1OMt9d8kwitotRIWHIt96kAtqjqYVIt91zIJbfJReSsVbWJ1SunPC2SpoDFoFQ+vwfXWsixLWLqRj9gWHA==\" UUID=\"9517a20a-617c-4224-bcb4-be2da726cfb4\" Version=\"1.1\" xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd\"/>\n        </cfdi:Complemento>\n    </cfdi:Comprobante>\n', '9517a20a-617c-4224-bcb4-be2da726cfb4', 0, 140000, 22400, '2023-10-05 19:18:04', 1),
(103, 'pruebaLMNO345', 6, '2023-06-29 14:51:30', 126400, '<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" Certificado=\"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\" Exportacion=\"01\" Fecha=\"2023-06-29T14:51:30\" FormaPago=\"03\" LugarExpedicion=\"55404\" MetodoPago=\"PUE\" Moneda=\"MXN\" NoCertificado=\"00001000000512229858\" Sello=\"STWGz81fpnDXd0BDXhImys5vpWG9Wib/LYgZb8Ar8fJaktfTuAkIe8ftYq6+lJs2NOYhKcrcXmi2pcT+CgXdc4a5ciJjTu1djF5raYUGh1mLzWpyQBBlda+J9KklXmvNd1uCJJ8lfrvjHteTqAdI/kJmlloloAPNb8++sEcZrF6fTpcn8uXorai0sG542yBYUb/ElrcTq+NLrvQIU4vAWY9iNwmxj2XuItA1mIBbqWOo3EKC8YmFRdeCW/okpQfDqMw1R18wI0IRIcUDGZvr+bRlDhO2XG1ednvtDa1DYGby/NzspDd8DV1JHN4Tz5ZVGubkfvRf+OXYFb2A/PL1wg==\" SubTotal=\"3000.00\" TipoCambio=\"1\" TipoDeComprobante=\"I\" Total=\"3480.00\" Version=\"4.0\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd\">\n    <cfdi:Emisor Nombre=\"JUAN CARLOS CARREÑO FLORES\" RegimenFiscal=\"621\" Rfc=\"prueba\"/>\n    <cfdi:Receptor DomicilioFiscalReceptor=\"06400\" Nombre=\"VANYA PEREZ HERRERA\" RegimenFiscalReceptor=\"612\" Rfc=\"PEHV751002371\" UsoCFDI=\"G03\"/>\n    <cfdi:Conceptos>\n        <cfdi:Concepto Cantidad=\"1\" ClaveProdServ=\"81112106\" ClaveUnidad=\"ACT\" Descripcion=\"Desarrollo de Encuesta\" Importe=\"3000.00\" NoIdentificacion=\"NO APLICA\" ObjetoImp=\"02\" ValorUnitario=\"3000.00\">\n            <cfdi:Impuestos>\n                <cfdi:Traslados>\n                    <cfdi:Traslado Base=\"3000.00\" Importe=\"480.00\" Impuesto=\"002\" TasaOCuota=\"0.160000\" TipoFactor=\"Tasa\"/>\n                </cfdi:Traslados>\n            </cfdi:Impuestos>\n        </cfdi:Concepto>\n    </cfdi:Conceptos>\n    <cfdi:Impuestos TotalImpuestosTrasladados=\"480.00\">\n        <cfdi:Traslados>\n            <cfdi:Traslado Base=\"3000.00\" Importe=\"480.00\" Impuesto=\"002\" TasaOCuota=\"0.160000\" TipoFactor=\"Tasa\"/>\n        </cfdi:Traslados>\n    </cfdi:Impuestos>\n    <cfdi:Complemento>\n        <tfd:TimbreFiscalDigital xmlns:tfd=\"http://www.sat.gob.mx/TimbreFiscalDigital\" FechaTimbrado=\"2023-06-29T14:51:32\" NoCertificadoSAT=\"00001000000506403528\" RfcProvCertif=\"CCC1007293K0\" SelloCFD=\"STWGz81fpnDXd0BDXhImys5vpWG9Wib/LYgZb8Ar8fJaktfTuAkIe8ftYq6+lJs2NOYhKcrcXmi2pcT+CgXdc4a5ciJjTu1djF5raYUGh1mLzWpyQBBlda+J9KklXmvNd1uCJJ8lfrvjHteTqAdI/kJmlloloAPNb8++sEcZrF6fTpcn8uXorai0sG542yBYUb/ElrcTq+NLrvQIU4vAWY9iNwmxj2XuItA1mIBbqWOo3EKC8YmFRdeCW/okpQfDqMw1R18wI0IRIcUDGZvr+bRlDhO2XG1ednvtDa1DYGby/NzspDd8DV1JHN4Tz5ZVGubkfvRf+OXYFb2A/PL1wg==\" SelloSAT=\"t3qBhVJINlkWRR6636WEL7yH+h/jiIQpx9+itMsGRi/iq/VLfUn/7pDvji6C/EdHxe3pEbCM6a8K5mYkYTkhRZy/rij0Aar+T73qezJswcvGyj4U2LXt6Kt7JcYu8zy6ESdkIp3GVQBpnpnBfc9KMB8qbNGE+w+ck/n72YnKsmShdCbpGRAgjDJof1HoN/UNddLFBsVZIHrlVBJPuJjQgnGDmmJwa1GiHPf0m8kpAbcvOswf2AhadZawiNMJf+9s2dzZ1OMt9d8kwitotRIWHIt96kAtqjqYVIt91zIJbfJReSsVbWJ1SunPC2SpoDFoFQ+vwfXWsixLWLqRj9gWHA==\" UUID=\"9517a20a-617c-4224-bcb4-be2da726cfb4\" Version=\"1.1\" xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd\"/>\n        </cfdi:Complemento>\n    </cfdi:Comprobante>\n', '9517a20a-617c-4224-bcb4-be2da726cfb4', 0, 109000, 17400, '2023-10-09 23:37:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `p_idPerfil` tinyint(4) NOT NULL,
  `p_Descripcion` varchar(50) NOT NULL,
  `p_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`p_idPerfil`, `p_Descripcion`, `p_Activo`) VALUES
(1, 'Administrador', 1),
(2, 'Administrador Ex', 1),
(3, 'Colaborador Editor', 1),
(4, 'Colaborador Consulta', 1);

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `per_idPersona` int(11) NOT NULL,
  `per_Nombre` text DEFAULT NULL,
  `per_Apellido` text DEFAULT NULL,
  `per_Alias` text DEFAULT NULL,
  `per_RFC` text DEFAULT NULL,
  `per_idTipoPrersona` text DEFAULT NULL,
  `per_idRol` text DEFAULT NULL,
  `per_ActivoFintec` text DEFAULT NULL,
  `per_RegimenFiscal` text DEFAULT NULL,
  `per_idCtaBanco` text DEFAULT NULL,
  `per_logo` text DEFAULT NULL,
  `per_Activo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`per_idPersona`, `per_Nombre`, `per_Apellido`, `per_Alias`, `per_RFC`, `per_idTipoPrersona`, `per_idRol`, `per_ActivoFintec`, `per_RegimenFiscal`, `per_idCtaBanco`, `per_logo`, `per_Activo`) VALUES
(1, 'Q2xpZW50ZSBOb21icmU=', 'QXBlbGxpZG8gQ2xpZW50ZQ==', 'QWxpYXNDMg==', 'WFhYWEFBTU1ERFhY', 'MQ==', 'MQ==', 'MA==', 'MQ==', 'MQ==', NULL, 1),
(2, 'Q2xpZW50ZSBOb21icmUy', 'QXBlbGxpZG8gQ2xpZW50ZTI=', 'QWxpYXNDX290cm8=', 'WFhYWEFBTU1ERDk5', 'MQ==', 'Mg==', 'MA==', 'MQ==', 'MQ==', NULL, 1),
(3, 'RW1wcmVzYSAx', '', 'RW1wcmVzYSAx', 'WFhYQUFNTUREOTk=', 'Mg==', 'MQ==', 'MA==', 'MQ==', 'Nw==', NULL, 1),
(4, 'RW1wcmVzYSAy', '', 'RW1wcmVzYSAy', 'WFhYQUFNTUREMDA=', 'Mg==', 'MQ==', 'MA==', 'MQ==', 'OA==', NULL, 1),
(6, 'RW1wcmVzYSAy', '', 'RW1wcmVzYSAy', 'WFhYQUFNTUREMDE=', 'Mg==', 'MQ==', 'MA==', 'MQ==', '', NULL, 1),
(7, 'c0VmnIsLJkKNqkx+vGRysQ==', 'iuq6KlbY9OlVMHCefk57Bg==', 'c0VmnIsLJkKNqkx+vGRysQ==', 'vf/p/N4KmlIM6+yAXZtmPQ==', 'vAFnCnmxypZh26+H5VW3Wg==', 'vKXSNjBv1J1oMS4D9Tx7IQ==', '+XlymiNGtLOhl0Sv+osIpQ==', 'vKXSNjBv1J1oMS4D9Tx7IQ==', 'iuq6KlbY9OlVMHCefk57Bg==', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `preguntapersona`
--

CREATE TABLE `preguntapersona` (
  `pp_idpreguntapersona` int(11) NOT NULL,
  `pp_idpersona` int(11) DEFAULT NULL,
  `pp_idpregunta` int(11) NOT NULL,
  `pp_respuestapregunta` varchar(255) NOT NULL,
  `pp_Activo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preguntapersona`
--

INSERT INTO `preguntapersona` (`pp_idpreguntapersona`, `pp_idpersona`, `pp_idpregunta`, `pp_respuestapregunta`, `pp_Activo`) VALUES
(1, 1, 1, 'U1RBUldBUlM=', 1),
(2, 2, 1, 'U1VQRVJNQU4=', 1),
(3, 3, 1, 'U1VQRVJNQU4=', 1),
(4, 4, 1, 'U1VQRVJNQU4=', 1);

-- --------------------------------------------------------

--
-- Table structure for table `representantelegal`
--

CREATE TABLE `representantelegal` (
  `rl_idRepresentante` int(11) NOT NULL,
  `rl_Nombre` varchar(255) DEFAULT NULL,
  `rl_RFC` varchar(255) DEFAULT NULL,
  `rl_idPersona` varchar(255) DEFAULT NULL,
  `rl_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `representantelegal`
--

INSERT INTO `representantelegal` (`rl_idRepresentante`, `rl_Nombre`, `rl_RFC`, `rl_idPersona`, `rl_Activo`) VALUES
(1, 'Tm9tYnJlIFJlcHJlc2VudGFudGU=', 'WFhYWDk5OTk5OVhYWA==', 'MQ==', 1),
(2, 'Tm9tYnJlIFJlcHJlc2VudGFudGUy', 'WFhYWDk5OTk5OUFBQQ==', 'Mg==', 1),
(3, 'Tm9tYnJlIFJlcHJlc2VudGFudGUy', 'WFhYWDk5OTk5OUFBQQ==', 'Mw==', 1),
(4, 'Tm9tYnJlIFJlcHJlc2VudGFudGUy', 'WFhYWDk5OTk5OUFBQQ==', 'NA==', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `r_idRol` tinyint(4) NOT NULL,
  `r_Descripcion` varchar(50) DEFAULT NULL,
  `r_Activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`r_idRol`, `r_Descripcion`, `r_Activo`) VALUES
(1, 'Cliente', 1),
(2, 'Proveedor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `seguimiento`
--

CREATE TABLE `seguimiento` (
  `s_idSeguimiento` int(11) NOT NULL,
  `s_idOperacion` varchar(10) NOT NULL,
  `s_FechaSeguimiento` datetime NOT NULL,
  `s_DescripcionOperacion` varchar(255) NOT NULL,
  `s_idEstatusO` float DEFAULT NULL,
  `s_UsuarioActualizo` int(11) NOT NULL,
  `s_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seguimiento`
--

INSERT INTO `seguimiento` (`s_idSeguimiento`, `s_idOperacion`, `s_FechaSeguimiento`, `s_DescripcionOperacion`, `s_idEstatusO`, `s_UsuarioActualizo`, `s_Activo`) VALUES
(1, '1', '2023-09-28 13:54:10', 'Alta de Documento Factura', 1, 2, 1),
(2, '10', '2023-09-28 13:56:02', 'Alta de Documento Comp Egreso', 1, 2, 1),
(3, '11', '2023-09-28 14:05:15', 'Alta de Documento Comp Egreso', 1, 1, 1),
(4, '12', '2023-09-28 14:05:48', 'Alta de Documento Comp Egreso', 1, 1, 1),
(5, '13', '2023-09-28 14:06:11', 'Alta de Documento Comp Egreso', 1, 1, 1),
(6, '14', '2023-09-28 14:06:14', 'Alta de Documento Comp Egreso', 1, 1, 1),
(7, '15', '2023-09-28 14:17:43', 'Alta de Documento Comp Egreso', 1, 1, 1),
(8, '16', '2023-09-28 14:23:15', 'Alta de Documento Comp Egreso', 1, 1, 1),
(9, '17', '2023-09-28 14:23:23', 'Alta de Documento Comp Egreso', 1, 1, 1),
(10, '18', '2023-09-28 14:23:29', 'Alta de Documento Comp Egreso', 1, 1, 1),
(11, '19', '2023-09-28 14:23:35', 'Alta de Documento Comp Egreso', 1, 1, 1),
(12, '20', '2023-09-28 14:23:39', 'Alta de Documento Comp Egreso', 1, 1, 1),
(13, '21', '2023-09-28 14:23:41', 'Alta de Documento Comp Egreso', 1, 1, 1),
(14, '22', '2023-09-28 14:23:48', 'Alta de Documento Comp Egreso', 1, 1, 1),
(15, '24', '2023-09-28 14:24:04', 'Alta de Documento Comp Egreso', 1, 1, 1),
(16, '25', '2023-09-28 14:24:10', 'Alta de Documento Comp Egreso', 1, 1, 1),
(17, '26', '2023-09-28 14:24:13', 'Alta de Documento Comp Egreso', 1, 1, 1),
(18, '27', '2023-09-28 14:24:16', 'Alta de Documento Comp Egreso', 1, 1, 1),
(19, '28', '2023-09-28 14:24:23', 'Alta de Documento Comp Egreso', 1, 1, 1),
(20, '29', '2023-09-28 14:24:25', 'Alta de Documento Comp Egreso', 1, 1, 1),
(21, '30', '2023-09-28 14:24:27', 'Alta de Documento Comp Egreso', 1, 1, 1),
(22, '31', '2023-09-28 14:24:29', 'Alta de Documento Comp Egreso', 1, 1, 1),
(23, '32', '2023-09-28 14:24:35', 'Alta de Documento Comp Egreso', 1, 1, 1),
(24, '33', '2023-09-28 14:24:38', 'Alta de Documento Comp Egreso', 1, 1, 1),
(25, '34', '2023-09-28 14:24:40', 'Alta de Documento Comp Egreso', 1, 1, 1),
(26, '35', '2023-09-28 14:24:42', 'Alta de Documento Comp Egreso', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabla_ejemplo`
--

CREATE TABLE `tabla_ejemplo` (
  `ID` int(11) NOT NULL,
  `ID_Persona` int(11) NOT NULL,
  `Aprobacion` int(11) DEFAULT NULL,
  `ID_Operacion` int(11) DEFAULT NULL,
  `Proveedor` varchar(255) DEFAULT NULL,
  `Fecha_Factura` date DEFAULT NULL,
  `Fecha_Alta` date DEFAULT NULL,
  `Factura` varchar(255) DEFAULT NULL,
  `Nota_Debito_Factura_Proveedor` varchar(255) DEFAULT NULL,
  `Fecha_Nota_Debito_Fact_Proveedor` date DEFAULT NULL,
  `Fecha_Transaccion` date DEFAULT NULL,
  `Estatus` varchar(255) DEFAULT NULL,
  `Monto_Ingreso` decimal(10,2) DEFAULT NULL,
  `Monto_Egreso` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabla_ejemplo`
--

INSERT INTO `tabla_ejemplo` (`ID`, `ID_Persona`, `Aprobacion`, `ID_Operacion`, `Proveedor`, `Fecha_Factura`, `Fecha_Alta`, `Factura`, `Nota_Debito_Factura_Proveedor`, `Fecha_Nota_Debito_Fact_Proveedor`, `Fecha_Transaccion`, `Estatus`, `Monto_Ingreso`, `Monto_Egreso`) VALUES
(1, 6, 1, 52147483, 'Frontier', '2023-01-15', '2023-01-20', 'FAC001', 'ND001', '2023-01-22', '2023-01-25', 'Aprobada', '1500.00', '320.00'),
(2, 6, 0, 13234343, 'Frontier', '2023-02-10', '2023-02-12', 'FAC002', NULL, NULL, '2023-02-15', 'Pendiente', '21576.00', '750.00'),
(3, 6, 1, 89023923, 'Frontier', '2023-03-05', '2023-03-08', 'FAC003', 'ND002', '2023-03-10', '2023-03-12', 'Aprobada', '2000.00', '600.00'),
(15, 6, 0, 19504132, 'Frontier', '2023-05-15', '2023-10-05', 'FAC002', 'ND001', '0000-00-00', '2023-10-09', 'Pendiente', '12322.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tipocontacto`
--

CREATE TABLE `tipocontacto` (
  `tc_idTipoContacto` int(11) NOT NULL,
  `tc_Descripcion` varchar(30) NOT NULL,
  `tc_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipocontacto`
--

INSERT INTO `tipocontacto` (`tc_idTipoContacto`, `tc_Descripcion`, `tc_Activo`) VALUES
(1, 'Fijo', 1),
(2, 'Movil', 1),
(3, 'eMail', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `td_idTipoDocumento` int(11) NOT NULL,
  `td_Descripcion` varchar(16) NOT NULL,
  `td_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipodocumento`
--

INSERT INTO `tipodocumento` (`td_idTipoDocumento`, `td_Descripcion`, `td_Activo`) VALUES
(1, 'Factura', 1),
(2, 'Comp Egreso', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tipopersona`
--

CREATE TABLE `tipopersona` (
  `tp_idTipoPersona` tinyint(4) NOT NULL,
  `tp_Descripcion` varchar(50) DEFAULT NULL,
  `tp_Activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipopersona`
--

INSERT INTO `tipopersona` (`tp_idTipoPersona`, `tp_Descripcion`, `tp_Activo`) VALUES
(1, 'Fisica', 1),
(2, 'Moral', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `u_idUsuario` int(11) NOT NULL,
  `u_idPersona` varchar(255) DEFAULT NULL,
  `u_NombreUsuario` varchar(255) DEFAULT NULL,
  `u_Nombre` varchar(255) DEFAULT NULL,
  `u_Apellidos` varchar(255) DEFAULT NULL,
  `u_Llaveacceso` varchar(255) DEFAULT NULL,
  `u_idPerfil` varchar(255) DEFAULT NULL,
  `u_imagenUsuario` varchar(255) DEFAULT NULL,
  `u_Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`u_idUsuario`, `u_idPersona`, `u_NombreUsuario`, `u_Nombre`, `u_Apellidos`, `u_Llaveacceso`, `u_idPerfil`, `u_imagenUsuario`, `u_Activo`) VALUES
(1, 'MQ==', 'RGVtb1VzZXI=', 'Tm9tYnJlIFVzZXI=', 'QXBlbGxpZG8gVXNlcg==', 'OWNlYmMxMTE5NjJkZjIxMGYwOWE5OGVkNmMwMDAwMzQ=', 'MQ==', 'L3RlbXByYWwvaW1hZ2VuLnBuZw==', 1),
(2, 'Mg==', 'RGVtb1VzZXIy', 'Tm9tYnJlIFVzdWFyaW8y', 'QXBlbGxpZG8gVXN1YXJpbzI=', 'NDI0YTRlNGFiZGUyOTc2MzNkYWU2ZDE2YzcxMGYyYTA=', 'MQ==', 'L3RlbXByYWwvaW1hZ2VuLnBuZw==', 1),
(4, 'Mw==', 'VXN1YXJpb0Ux', 'Tm9tYnJlIFVzdWFyaW9FMQ==', 'QXBlbGxpZG8gVXN1YXJpb0Ux', 'OWNlYmMxMTE5NjJkZjIxMGYwOWE5OGVkNmMwMDAwMzQ=', 'MQ==', 'L3RlbXByYWwvaW1hZ2VuLnBuZw==', 1),
(5, 'NA==', 'VXN1YXJpb0Uy', 'Tm9tYnJlIFVzdWFyaW9FMg==', 'QXBlbGxpZG8gVXN1YXJpb0Uy', 'OWNlYmMxMTE5NjJkZjIxMGYwOWE5OGVkNmMwMDAwMzQ=', 'MQ==', 'L3RlbXByYWwvaW1hZ2VuLnBuZw==', 1);

-- --------------------------------------------------------

--
-- Structure for view `datos_persona`
--
DROP TABLE IF EXISTS `datos_persona`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datos_persona`  AS SELECT `p`.`per_idPersona` AS `id_persona`, from_base64(`p`.`per_Nombre`) AS `nombre`, from_base64(`p`.`per_Alias`) AS `alias`, from_base64(`p`.`per_RFC`) AS `rfc`, from_base64(`p`.`per_idTipoPrersona`) AS `idtipopersona`, from_base64(`p`.`per_idRol`) AS `idrol`, from_base64(`p`.`per_ActivoFintec`) AS `activofintec`, from_base64(`p`.`per_RegimenFiscal`) AS `idregimenfiscal`, from_base64(`p`.`per_idCtaBanco`) AS `idcuentabanco`, `c2`.`Alias` AS `banco`, from_base64(`c`.`b_CLABE`) AS `clabe`, from_base64(`p`.`per_logo`) AS `logo_persona`, from_base64(`u`.`u_imagenUsuario`) AS `logo_usuario`, from_base64(`u`.`u_NombreUsuario`) AS `nombre_usuario`, from_base64(`r`.`rl_Nombre`) AS `nombre_representante`, from_base64(`u`.`u_Nombre`) AS `nombre_d_usaurio`, from_base64(`u`.`u_Apellidos`) AS `apellido_usuario`, `u`.`u_idUsuario` AS `id_usuario` FROM (((((((`persona` `p` join `representantelegal` `r` on(`p`.`per_idPersona` = from_base64(`r`.`rl_idPersona`))) join `usuario` `u` on(from_base64(`r`.`rl_idPersona`) = from_base64(`u`.`u_idPersona`))) join `tipopersona` `t` on(`t`.`tp_idTipoPersona` = from_base64(`p`.`per_idTipoPrersona`))) join `cuentabancaria` `c` on(`c`.`b_idCtaBancaria` = from_base64(`p`.`per_idCtaBanco`))) join `catbancos` `c2` on(`c`.`b_idCatBanco` = `c2`.`id`)) join `rol` on(`rol`.`r_idRol` = from_base64(`p`.`per_idRol`))) join `perfil` on(`perfil`.`p_idPerfil` = from_base64(`u`.`u_idPerfil`))) WHERE `p`.`per_Activo` = 1 AND `u`.`u_Activo` = 1 AND `r`.`rl_Activo` = 1 AND `t`.`tp_Activo` = 11  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`a_idAcceso`);

--
-- Indexes for table `catgiro`
--
ALTER TABLE `catgiro`
  ADD PRIMARY KEY (`g_idGiro`);

--
-- Indexes for table `catpreguntas`
--
ALTER TABLE `catpreguntas`
  ADD PRIMARY KEY (`pg_idpregunta`);

--
-- Indexes for table `cattipovalor`
--
ALTER TABLE `cattipovalor`
  ADD PRIMARY KEY (`cv_idTipoValor`);

--
-- Indexes for table `clienteproveedor`
--
ALTER TABLE `clienteproveedor`
  ADD PRIMARY KEY (`cp_idClienteProveedor`);

--
-- Indexes for table `compensacion`
--
ALTER TABLE `compensacion`
  ADD PRIMARY KEY (`cm_idCompensacion`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`cnf_idConfiguracion`);

--
-- Indexes for table `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`c_idContacto`);

--
-- Indexes for table `cuentabancaria`
--
ALTER TABLE `cuentabancaria`
  ADD PRIMARY KEY (`b_idCtaBancaria`);

--
-- Indexes for table `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`d_idDireccion`);

--
-- Indexes for table `elementoconfigurable`
--
ALTER TABLE `elementoconfigurable`
  ADD PRIMARY KEY (`ec_idElementoConfigurable`);

--
-- Indexes for table `estatuscm`
--
ALTER TABLE `estatuscm`
  ADD PRIMARY KEY (`ec_idEstatusCM`);

--
-- Indexes for table `estatuscp`
--
ALTER TABLE `estatuscp`
  ADD PRIMARY KEY (`ecp_idEstatusCP`);

--
-- Indexes for table `estatuso`
--
ALTER TABLE `estatuso`
  ADD PRIMARY KEY (`eo_idEstatusO`);

--
-- Indexes for table `moduloperfil`
--
ALTER TABLE `moduloperfil`
  ADD PRIMARY KEY (`mp_idModuloPerfil`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`m_idModulo`);

--
-- Indexes for table `operacion`
--
ALTER TABLE `operacion`
  ADD PRIMARY KEY (`o_idOperacion`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`p_idPerfil`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`per_idPersona`);

--
-- Indexes for table `preguntapersona`
--
ALTER TABLE `preguntapersona`
  ADD PRIMARY KEY (`pp_idpreguntapersona`);

--
-- Indexes for table `representantelegal`
--
ALTER TABLE `representantelegal`
  ADD PRIMARY KEY (`rl_idRepresentante`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`r_idRol`);

--
-- Indexes for table `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`s_idSeguimiento`);

--
-- Indexes for table `tabla_ejemplo`
--
ALTER TABLE `tabla_ejemplo`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tipocontacto`
--
ALTER TABLE `tipocontacto`
  ADD PRIMARY KEY (`tc_idTipoContacto`);

--
-- Indexes for table `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`td_idTipoDocumento`);

--
-- Indexes for table `tipopersona`
--
ALTER TABLE `tipopersona`
  ADD PRIMARY KEY (`tp_idTipoPersona`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`u_idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acceso`
--
ALTER TABLE `acceso`
  MODIFY `a_idAcceso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catgiro`
--
ALTER TABLE `catgiro`
  MODIFY `g_idGiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `catpreguntas`
--
ALTER TABLE `catpreguntas`
  MODIFY `pg_idpregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cattipovalor`
--
ALTER TABLE `cattipovalor`
  MODIFY `cv_idTipoValor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clienteproveedor`
--
ALTER TABLE `clienteproveedor`
  MODIFY `cp_idClienteProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compensacion`
--
ALTER TABLE `compensacion`
  MODIFY `cm_idCompensacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `cnf_idConfiguracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacto`
--
ALTER TABLE `contacto`
  MODIFY `c_idContacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cuentabancaria`
--
ALTER TABLE `cuentabancaria`
  MODIFY `b_idCtaBancaria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `direccion`
--
ALTER TABLE `direccion`
  MODIFY `d_idDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `elementoconfigurable`
--
ALTER TABLE `elementoconfigurable`
  MODIFY `ec_idElementoConfigurable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `estatuscm`
--
ALTER TABLE `estatuscm`
  MODIFY `ec_idEstatusCM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estatuscp`
--
ALTER TABLE `estatuscp`
  MODIFY `ecp_idEstatusCP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estatuso`
--
ALTER TABLE `estatuso`
  MODIFY `eo_idEstatusO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `moduloperfil`
--
ALTER TABLE `moduloperfil`
  MODIFY `mp_idModuloPerfil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `m_idModulo` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operacion`
--
ALTER TABLE `operacion`
  MODIFY `o_idOperacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `p_idPerfil` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `per_idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `preguntapersona`
--
ALTER TABLE `preguntapersona`
  MODIFY `pp_idpreguntapersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `representantelegal`
--
ALTER TABLE `representantelegal`
  MODIFY `rl_idRepresentante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `r_idRol` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `s_idSeguimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tabla_ejemplo`
--
ALTER TABLE `tabla_ejemplo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tipocontacto`
--
ALTER TABLE `tipocontacto`
  MODIFY `tc_idTipoContacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `td_idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipopersona`
--
ALTER TABLE `tipopersona`
  MODIFY `tp_idTipoPersona` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `u_idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
