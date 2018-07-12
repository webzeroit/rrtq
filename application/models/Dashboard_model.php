<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indicatori_totali()
    {
        $output = array();
        $this->db->where('id_stato_profilo !=', 4);
        $this->db->from('rrtq_profilo');

        $output["n_qualificazioni"] = $this->db->count_all_results();
        $output["n_competenze"] = $this->db->count_all('rrtq_competenza');
        $output["n_abilita"] = $this->db->count_all('rrtq_abilita');
        $output["n_conoscenze"] = $this->db->count_all('rrtq_conoscenza');


        return $output;
    }

    public function indicatori_stato()
    {
        $this->db->select('id_stato_profilo as label, COUNT(id_profilo) as value');
        $this->db->from('rrtq_profilo');
        $this->db->where('id_stato_profilo !=', 4);
        $this->db->group_by('id_stato_profilo');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function lista_ultimi_export()
    {
        $this->db->select('titolo_profilo, data_ultimo_export');
        $this->db->where('id_stato_profilo !=', 4);
        $this->db->where('data_ultimo_export !=', NULL);
        $this->db->from('rrtq_profilo');
        $this->db->order_by('data_ultimo_export', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function lista_ultimi_profili_mod()
    {
        if (!$this->ion_auth->is_admin())
        {
            $this->db->where('rrtq_profilo.id_stato_profilo !=', 4);
        }
        $this->db
            ->select('id_profilo,id_sep,titolo_profilo,data_ultima_modifica,rrtq_profilo.id_stato_profilo,des_stato_profilo')
            ->from('rrtq_profilo')
            ->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo')
            ->order_by('data_ultima_modifica','DESC')
            ->limit(10);

        $query = $this->db->get();
        return $query->result_array();
        
    }

}
