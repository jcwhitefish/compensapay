-- compensapay.datos_persona source

create or replace
algorithm = UNDEFINED view `compensapay`.`datos_persona` as
select
    `p`.`per_idPersona` as `id_persona`,
    from_base64(`p`.`per_Nombre`) as `nombre`,
    from_base64(`p`.`per_Alias`) as `alias`,
    from_base64(`p`.`per_RFC`) as `rfc`,
    from_base64(`p`.`per_idTipoPrersona`) as `idtipopersona`,
    from_base64(`p`.`per_idRol`) as `idrol`,
    from_base64(`p`.`per_ActivoFintec`) as `activofintec`,
    from_base64(`p`.`per_RegimenFiscal`) as `idregimenfiscal`,
    from_base64(`p`.`per_idCtaBanco`) as `idcuentabanco`,
    `c2`.`Alias` as `banco`,
    from_base64(`c`.`b_CLABE`) as `clabe`,
    from_base64(`p`.`per_logo`) as `logo_persona`,
    from_base64(`u`.`u_imagenUsuario`) as `logo_usuario`,
    from_base64(`u`.`u_NombreUsuario`) as `nombre_usuario`,
    from_base64(`r`.`rl_Nombre`) as `nombre_representante`,
    from_base64(`u`.`u_Nombre`) as `nombre_d_usaurio`,
    from_base64(`u`.`u_Apellidos`) as `apellido_usuario`,
    `u`.`u_idUsuario` as `id_usuario`
from
    (((((((`compensapay`.`persona` `p`
join `compensapay`.`representantelegal` `r` on
    ((`p`.`per_idPersona` = from_base64(`r`.`rl_idPersona`))))
join `compensapay`.`usuario` `u` on
    ((from_base64(`r`.`rl_idPersona`) = from_base64(`u`.`u_idPersona`))))
join `compensapay`.`tipopersona` `t` on
    ((`t`.`tp_idTipoPersona` = from_base64(`p`.`per_idTipoPrersona`))))
join `compensapay`.`cuentabancaria` `c` on
    ((`c`.`b_idCatBanco` = from_base64(`p`.`per_idCtaBanco`))))
join `compensapay`.`catbancos` `c2` on
    ((`c`.`b_idCatBanco` = `c2`.`id`)))
join `compensapay`.`rol` on
    ((`compensapay`.`rol`.`r_idRol` = from_base64(`p`.`per_idRol`))))
join `compensapay`.`perfil` on
    ((`compensapay`.`perfil`.`p_idPerfil` = from_base64(`u`.`u_idPerfil`))))
where
    ((`p`.`per_Activo` = 1)
        and (`u`.`u_Activo` = 1)
            and (`r`.`rl_Activo` = 1)
                and (`t`.`tp_Activo` = 1));