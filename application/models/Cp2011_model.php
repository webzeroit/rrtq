<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cp2011_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function list_cp2011()
    {
        $this->db->cache_on();
        $this->db->select('codice_cp2011,CONCAT(codice_cp2011," - ", descrizione_cp2011) as descrizione_cp2011', FALSE);
        $this->db->from('rrtq_istat_cp2011');
        $query = $this->db->get();
        $this->db->cache_off();
        return $query->result_array();
    }

    public function get_cp2011($id)
    {
        $this->db->select('codice_cp2011,CONCAT(codice_cp2011," - ", descrizione_cp2011) as descrizione_cp2011', FALSE);
        $this->db->where('codice_cp2011', $id);
        $this->db->from('rrtq_istat_cp2011');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /* TABELLA */
    public function datatables_cp2011()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('codice_cp2011, descrizione_cp2011')
                ->from('rrtq_istat_cp2011');

        return $this->datatables->generate();
    }   

}
