<?php
class Factura {

    public $FechaEmision;
    public $FechaUpdate;
    public $Total;
    public $Impuestos;
    public $Subtotal;
    public $TipoDocumento;
    public $EstatusClienteProveedor;
    public $UUID;
    public $AliasCliente;
    public $RFCCliente;
    public $AliasProvedor;//whitout e
    public $RFCProveedor;

    
    function __construct($fechaEmision, $fechaUpdate, $total, $impuestos, $subtotal, $tipoDocumento, $estatusClienteProveedor, $uuid, $aliasCliente, $rfcCliente, $aliasProvedor, $rfcProveedor) {
        $this->FechaEmision = $fechaEmision;
        $this->FechaUpdate = $fechaUpdate;
        $this->Total = $total;
        $this->Impuestos = $impuestos;
        $this->Subtotal = $subtotal;
        $this->TipoDocumento = $tipoDocumento;
        $this->EstatusClienteProveedor = $estatusClienteProveedor;
        $this->UUID = $uuid;
        $this->AliasCliente = $aliasCliente;
        $this->RFCCliente = $rfcCliente;
        $this->AliasProvedor = $aliasProvedor;
        $this->RFCProveedor = $rfcProveedor;
    }
}

