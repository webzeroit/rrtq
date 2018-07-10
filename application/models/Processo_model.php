<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Processo_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    /* TABELLA */
    public function datatables_processo()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_processo, id_sep, codice_processo, descrizione_processo')
                ->from('rrtq_sep_processo');

        return $this->datatables->generate();
    }
    
}