-- -------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`AgregaContacto`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;
  
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
 									(aes_encrypt(idTipoContacto,llave),
 									aes_encrypt(idPersona,llave),
 									aes_encrypt(contenido,llave),
 									1
 									);
  select
	count(c_Descripcion)
into
	resultado
from
	compensapay.contacto c 
where
	aes_decrypt(c_idTipoContacto,llave) = idTipoContacto and 
	aes_decrypt(c_idPersona,llave) = idPersona and 
	aes_decrypt(c_Descripcion,llave) = Contenido
	and c_Activo = 1;
  RETURN resultado;
END;
-- -------------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`AgregaPersona`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  	declare resultado blob;
	declare rfc varchar(16);

set
rfc = JSON_UNQUOTE(json_extract(entrada,'$.RFC'));
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
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Nombre')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Apellido')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.Alias')),llave),
 									aes_encrypt(rfc,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.TipoPersona')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Rol')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.ActivoFintec')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RegimenFical')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idCtaBanco')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Logo')),llave),
 									1
 									);
  select count(per_RFC) into resultado from compensapay.persona p where aes_decrypt(per_RFC,llave) = rfc and per_Activo = 1;								
  RETURN resultado;
END;
-- ------------------------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`AgregaRepresentante`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;

declare nombre varchar(30);

set
nombre = JSON_UNQUOTE(json_extract(entrada,
'$.NombreRepresentante'));

insert
	into
	compensapay.representantelegal (rl_Nombre,
	rl_RFC,
	rl_idPersona,
	rl_Activo)
values
 									(aes_encrypt (nombre,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RFC')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPersona')),llave),
 									1);
select
	count(rl_Nombre)
into
	resultado
from
	compensapay.representantelegal
where
	aes_decrypt(rl_Nombre,
	llave) = nombre
	and rl_Activo = 1;

return resultado;
end;
-- -------------------------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`AgregarOperacion`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;

declare nombre varchar(30);

set
nombre = JSON_UNQUOTE(json_extract(entrada,
'$.NombreRepresentante'));

insert
	into
	compensapay.representantelegal (rl_Nombre,
	rl_RFC,
	rl_idPersona,
	rl_Activo)
values
 									(aes_encrypt (nombre,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RFC')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPersona')),llave),
 									1);
select
	count(rl_Nombre)
into
	resultado
from
	compensapay.representantelegal
where
	aes_decrypt(rl_Nombre,
	llave) = nombre
	and rl_Activo = 1;

return resultado;
end;
-- --------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`AgregaUsuario`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;
  declare nomuser varchar(30);

set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));
 insert into compensapay.usuario (u_NombreUsuario,
 									u_idPersona,
 									u_idPerfil,
 									u_imagenUsuario,
 									u_Activo) values
 									(aes_encrypt(nomuser,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idPersona')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPerfil')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.urlImagen')),llave),
 									1
 									);
  select count(u_NombreUsuario) into resultado from compensapay.usuario where aes_decrypt(u_NombreUsuario,llave) = nomuser and u_Activo = 1;								
  RETURN resultado;
END;
-- -----------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`ExisteUsuario`(entrada VARCHAR(50),llave varchar(100)) RETURNS int(1)
BEGIN
  DECLARE salida int;
 	select count(u_NombreUsuario) into salida 
	from usuario 
	where aes_decrypt
		(u_NombreUsuario,llave) = entrada;
  RETURN salida;
END;
-- ----------------------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`VerBanco`(entrada VARCHAR(4)) RETURNS varchar(100)
begin
  declare salida varchar(100);

select
	JSON_OBJECT ('Clave',
	Clave,
	'Alias',
	Alias  
	)
into
	salida
from
	catbancos 
where
	compensapay.catbancos.Clave = entrada;

return salida;
end;
-- -----------------------------------------------
CREATE DEFINER=`root`@`localhost` FUNCTION `compensapay`.`VerFirma`(entrada VARCHAR(20)) RETURNS int(11)
BEGIN
  DECLARE salida int;
  select count(u_NombreUsuario) into salida from usuario where usuario.u_NombreUsuario=entrada; 
  -- SET salida = 1;
  RETURN salida;
END;
