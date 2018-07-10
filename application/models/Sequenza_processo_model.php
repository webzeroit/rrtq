<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Sequenza_processo_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    /* TABELLA */
    public function datatables_sequenza_processo()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_sequenza, id_sep, codice_sequenza, descrizione_sequenza')
                ->from('rrtq_sep_processo_sequenza');

        return $this->datatables->generate();
    }
    
}