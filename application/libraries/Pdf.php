<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends TCPDF
{

    public $document_id = 0;
    
    public function __construct()
    {
        parent::__construct();
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // document ID
        $this->MultiCell(60, 8, 'doc_id: ' . $this->document_id, 0, 'L', 0, false, '','', true, 0, false, true, 8, 'M');         
        // Page number
        $this->MultiCell(0, 8, 'Pagina ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 'R', 0, false, '', '', true, 0, false, true, 8, 'M');
    }

}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */