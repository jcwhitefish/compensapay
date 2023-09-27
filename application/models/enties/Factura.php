<?php
class Factura {

    public $o_idOperacion;
    public $o_NumOperacion;
    public $o_idPersona;
    public $o_FechaEmision;
    public $o_Total;
    public $o_ArchivoXML;
    public $o_UUID;
    public $o_idTipoDocumento;
    public $o_SubTotal;
    public $o_Impuesto;
    public $o_FechaUpload;
    public $o_Activo;

    
    public function __construct(
        $idOperacion, 
        $numOperacion, 
        $idPersona, 
        $fechaEmision, 
        $total, 
        $archivoXML, 
        $uuid, 
        $idTipoDocumento, 
        $subTotal, 
        $impuesto, 
        $fechaUpload, 
        $activo
    ) {
        $this->o_idOperacion = $idOperacion;
        $this->o_NumOperacion = $numOperacion;
        $this->o_idPersona = $idPersona;
        $this->o_FechaEmision = $fechaEmision;
        $this->o_Total = $total;
        $this->o_ArchivoXML = $archivoXML;
        $this->o_UUID = $uuid;
        $this->o_idTipoDocumento = $idTipoDocumento;
        $this->o_SubTotal = $subTotal;
        $this->o_Impuesto = $impuesto;
        $this->o_FechaUpload = $fechaUpload;
        $this->o_Activo = $activo;
    }
}

