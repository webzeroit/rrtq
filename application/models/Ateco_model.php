<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ateco_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function list_ateco()
    {
        
        $this->db->select('codice_ateco,CONCAT(codice_ateco," - ", descrizione_ateco) as descrizione_ateco', FALSE);
        $this->db->from('rrtq_istat_ateco2007');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ateco($id)
    {
        $this->db->select('codice_ateco,CONCAT(codice_ateco," - ", descrizione_ateco) as descrizione_ateco', FALSE);
        $this->db->where('codice_ateco', $id);
        $this->db->from('rrtq_istat_ateco2007');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /* TABELLA */
    public function datatables_ateco()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('codice_ateco, descrizione_ateco')
                ->from('rrtq_istat_ateco2007');

        return $this->datatables->generate();
    }    

}
