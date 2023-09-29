<?php
class Factura {

    public $NumOperacion; 
    public $FechaEmision;
    public $FechaUpdate;
    public $Total;
    public $Impuestos;
    public $Subtotal;
    public $TipoDocumento;
    public $Estatus;
    public $UUID;
    public $AliasCliente;
    public $RFCCliente;
    public $AliasProvedor;
    public $RFCProveedor;
    public $Usuario;
    public $IdUsuario;

    function __construct(
        $numOperacion = null,
        $fechaEmision = null,
        $fechaUpdate = null,
        $total = null,
        $impuestos = null,
        $subtotal = null,
        $tipoDocumento = null,
        $estatus = null,
        $uuid = null,
        $aliasCliente = null,
        $rfcCliente = null,
        $aliasProvedor = null,
        $rfcProveedor = null,
        $usuario = null,
        $idUsuario = null
    ) {
        $this->NumOperacion = $numOperacion; // Asignar el nuevo parámetro
        $this->FechaEmision = $fechaEmision;
        $this->FechaUpdate = $fechaUpdate;
        $this->Total = $total;
        $this->Impuestos = $impuestos;
        $this->Subtotal = $subtotal;
        $this->TipoDocumento = $tipoDocumento;
        $this->Estatus = $estatus;
        $this->UUID = $uuid;
        $this->AliasCliente = $aliasCliente;
        $this->RFCCliente = $rfcCliente;
        $this->AliasProvedor = $aliasProvedor;
        $this->RFCProveedor = $rfcProveedor;
        $this->Usuario = $usuario;
        $this->IdUsuario = $idUsuario;
    }
}
