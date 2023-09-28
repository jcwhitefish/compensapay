<?php
class Factura {

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

    function __construct($fechaEmision, $fechaUpdate, $total, $impuestos, $subtotal, $tipoDocumento, $estatus, $uuid, $aliasCliente, $rfcCliente, $aliasProvedor = null, $rfcProveedor = null) {
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
    }
}

