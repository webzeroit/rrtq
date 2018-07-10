<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Sep_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function list_sep()
    {
        $this->db->select('id_sep,CONCAT(codice_sep," - ", descrizione_sep) as descrizione_sep', FALSE);
        $this->db->from('rrtq_sep');
        $query = $this->db->get();
        return $query->result_array();
        
    }
    
    public function get_sep($id)
    {
        $this->db->select('id_sep,CONCAT(codice_sep," - ", descrizione_sep) as descrizione_sep', FALSE);
        $this->db->where('id_sep', $id);
        $this->db->from('rrtq_sep');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /* TABELLA DEI SEP */
    public function datatables_sep()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_sep, codice_sep, descrizione_sep')
                ->from('rrtq_sep');

        return $this->datatables->generate();
    }
    
}