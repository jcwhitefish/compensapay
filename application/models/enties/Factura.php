<?php
class Factura {
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
        $o_NumOperacion = null,
        $o_idPersona = null,
        $o_FechaEmision = null,
        $o_Total = null,
        $o_ArchivoXML = null,
        $o_UUID = null,
        $o_idTipoDocumento = null,
        $o_SubTotal = null,
        $o_Impuesto = null,
        $o_FechaUpload = null,
        $o_Activo = null
    ) {
        $this->o_NumOperacion = $o_NumOperacion;
        $this->o_idPersona = $o_idPersona;
        $this->o_FechaEmision = $o_FechaEmision;
        $this->o_Total = $o_Total;
        $this->o_ArchivoXML = $o_ArchivoXML;
        $this->o_UUID = $o_UUID;
        $this->o_idTipoDocumento = $o_idTipoDocumento;
        $this->o_SubTotal = $o_SubTotal;
        $this->o_Impuesto = $o_Impuesto;
        $this->o_FechaUpload = $o_FechaUpload;
        $this->o_Activo = $o_Activo;
    }

}