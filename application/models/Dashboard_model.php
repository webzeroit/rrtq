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
        
        //QUALIFICAZIONI
        $output["n_qualificazioni"] = $this->db->count_all_results();
        $output["n_competenze"] = $this->db->count_all('rrtq_competenza');
        $output["n_abilita"] = $this->db->count_all('rrtq_abilita');
        $output["n_conoscenze"] = $this->db->count_all('rrtq_conoscenza');
        
        //STANDARD FORMATIVI
        $this->db->select('id_standard_formativo')
                ->from('rrtq_standard_formativo')
                ->join('rrtq_profilo', 'rrtq_standard_formativo.id_profilo = rrtq_profilo.id_profilo')
                ->where('rrtq_profilo.id_stato_profilo !=', 4);
        
        $output["n_standard_formativi"] = $this->db->count_all_results();
        
        //UNITA FORMATIVE
        $this->db->select('id_unita_formativa')
                ->from('rrtq_standard_formativo_uf')
                ->join('rrtq_profilo', 'rrtq_standard_formativo_uf.id_profilo = rrtq_profilo.id_profilo')
                ->where('rrtq_profilo.id_stato_profilo !=', 4);
        
        $output["n_unita_formative"] = $this->db->count_all_results();     
        
        //MODULI
        $this->db->select('id_modulo')
                ->from('rrtq_standard_formativo_mod')
                ->join('rrtq_profilo', 'rrtq_standard_formativo_mod.id_profilo = rrtq_profilo.id_profilo')
                ->where('rrtq_profilo.id_stato_profilo !=', 4);
        
        $output["n_moduli"] = $this->db->count_all_results();          
        
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

    public function lista_ultimi_export($limit = 0)
    {
        $this->db->select('id_profilo,id_sep,titolo_profilo, DATE_FORMAT(data_ultimo_export,"%d/%m/%Y %H:%i") as data_ultimo_export', FALSE);
        $this->db->where('id_stato_profilo !=', 4);
        $this->db->where('data_ultimo_export !=', NULL);
        $this->db->from('rrtq_profilo');
        $this->db->order_by('data_ultimo_export', 'DESC');
        if ($limit > 0){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function lista_ultimi_profili_mod($limit = 0)
    {
        if (!$this->ion_auth->is_admin())
        {
            $this->db->where('rrtq_profilo.id_stato_profilo !=', 4);
        }
        $this->db
                ->select('id_profilo,id_sep,titolo_profilo, DATE_FORMAT(data_ultima_modifica,"%d/%m/%Y %H:%i") as data_ultima_modifica,rrtq_profilo.id_stato_profilo,des_stato_profilo',FALSE)
                ->from('rrtq_profilo')
                ->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo')
                ->order_by('rrtq_profilo.data_ultima_modifica', 'DESC');
        if ($limit > 0){
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function lista_ultimi_sf_mod($limit = 0)
    {
        if (!$this->ion_auth->is_admin())
        {
            $this->db->where('rrtq_profilo.id_stato_profilo !=', 4);
        }
        $this->db
                ->select('id_standard_formativo,id_sep,des_standard_formativo,DATE_FORMAT(rrtq_standard_formativo.data_ultima_modifica,"%d/%m/%Y %H:%i") as data_ultima_modifica,,rrtq_profilo.id_stato_profilo, des_stato_profilo')
                ->from('rrtq_standard_formativo')
                ->join('rrtq_profilo', 'rrtq_profilo.id_profilo = rrtq_standard_formativo.id_profilo')
                ->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo')
                ->order_by('rrtq_standard_formativo.data_ultima_modifica', 'DESC');
        if ($limit > 0){
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
}
