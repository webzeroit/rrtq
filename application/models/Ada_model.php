<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ada_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    //$my_where = array('id_sep' => $id_sep);
    //$this->db->where($my_where);
    public function list_ada($my_where = NULL)
    {
        if ($my_where !== NULL)
        {
            $this->db->where($my_where);
        }
        $this->db->select('id_ada,CONCAT(codice_ada," - ", descrizione_ada) as descrizione_ada', FALSE);
        $this->db->from('rrtq_ada');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ada($id)
    {
        $this->db->select('id_ada,CONCAT(codice_ada," - ", descrizione_ada) as descrizione_ada', FALSE);
        $this->db->where('id_ada', $id);
        $this->db->from('rrtq_ada');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /* TABELLA */
    public function datatables_ada()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_ada, id_sep, codice_ada, descrizione_ada')
                ->from('rrtq_ada');

        return $this->datatables->generate();
    }

}
