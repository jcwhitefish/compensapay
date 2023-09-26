<?php
class Factura {
    public $version;
    public $date;
    public $seal;
    public $paymentMethod;
    public $certificateNumber;
    public $certificate;
    public $subtotal;
    public $currency;
    public $exchangeRate;
    public $totalAmount;
    public $invoiceType;
    public $export;
    public $expeditionPlace;
    
    public $issuerRfc;
    public $issuerName;
    public $issuerTaxRegime;
    
    public $receiverRfc;
    public $receiverName;
    public $receiverUsageCFDI;
    
    public $items = [];

    public $totalTransferredTaxes;
    
    public function __construct($xmlContent) {
        $xml = new DOMDocument();
        $xml->loadXML($xmlContent);

        // Assign the main dates about factura
        $this->version = $xml->documentElement->getAttribute('Version');
        $this->date = $xml->documentElement->getAttribute('Fecha');
        $this->seal = $xml->documentElement->getAttribute('Sello');
        $this->paymentMethod = $xml->documentElement->getAttribute('FormaPago');
        $this->certificateNumber = $xml->documentElement->getAttribute('NoCertificado');
        $this->certificate = $xml->documentElement->getAttribute('Certificado');
        $this->subtotal = $xml->documentElement->getAttribute('SubTotal');
        $this->currency = $xml->documentElement->getAttribute('Moneda');
        $this->exchangeRate = $xml->documentElement->getAttribute('TipoCambio');
        $this->totalAmount = $xml->documentElement->getAttribute('Total');
        $this->invoiceType = $xml->documentElement->getAttribute('TipoDeComprobante');
        $this->export = $xml->documentElement->getAttribute('Exportacion');
        $this->expeditionPlace = $xml->documentElement->getAttribute('LugarExpedicion');
        
        // ..Emisor
        $issuer = $xml->getElementsByTagName('Emisor')->item(0);
        $this->issuerRfc = $issuer->getAttribute('Rfc');
        $this->issuerName = $issuer->getAttribute('Nombre');
        $this->issuerTaxRegime = $issuer->getAttribute('RegimenFiscal');
        
        // ..Receptor
        $receiver = $xml->getElementsByTagName('Receptor')->item(0);
        $this->receiverRfc = $receiver->getAttribute('Rfc');
        $this->receiverName = $receiver->getAttribute('Nombre');
        $this->receiverUsageCFDI = $receiver->getAttribute('UsoCFDI');
        
        // ..Items
        $items = $xml->getElementsByTagName('Concepto');
        foreach ($items as $item) {
            $itemData = [
                'productServiceKey' => $item->getAttribute('ClaveProdServ'),
                'identificationNumber' => $item->getAttribute('NoIdentificacion'),
                'quantity' => $item->getAttribute('Cantidad'),
                'unitKey' => $item->getAttribute('ClaveUnidad'),
                'description' => $item->getAttribute('Descripcion'),
                'unitValue' => $item->getAttribute('ValorUnitario'),
                'amount' => $item->getAttribute('Importe'),
                'taxObject' => $item->getAttribute('ObjetoImp'),
                'taxes' => []
            ];
            
            $taxes = $item->getElementsByTagName('Traslado');
            foreach ($taxes as $tax) {
                $itemData['taxes'][] = [
                    'taxBase' => $tax->getAttribute('Base'),
                    'taxId' => $tax->getAttribute('Impuesto'),
                    'taxTypeFactor' => $tax->getAttribute('TipoFactor'),
                    'taxRateOrAmount' => $tax->getAttribute('TasaOCuota'),
                    'taxAmount' => $tax->getAttribute('Importe')
                ];
            }
            
            $this->items[] = $itemData;
        }

        // ..Impuestos
        $generalTaxes = $xml->getElementsByTagName('Impuestos')->item(0);
        $this->totalTransferredTaxes = $generalTaxes->getAttribute('TotalImpuestosTrasladados');
    }
}

