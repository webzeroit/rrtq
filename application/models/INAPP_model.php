<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class INAPP_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function select_profili_export($ids)
    {
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        $output = array();
        $this->db->select('id_profilo,titolo_profilo,"" as descrizione_profilo,livello_eqf,id_sep');
        $this->db->where_in('id_profilo', $ids);
        $this->db->from('rrtq_profilo');
        $query = $this->db->get();
        $results = $query->result_array();
        foreach ($results as $row)
        {
            $curr_id = $row['id_profilo'];
            $curr_ada_seq = 1;
            $this->db->select('codice_ada');
            $this->db->from('rrtq_profilo_ada');
            $this->db->join('rrtq_ada', 'rrtq_profilo_ada.id_ada = rrtq_ada.id_ada');
            $this->db->where('id_profilo', $curr_id);
            $query = $this->db->get();
            $adas = $query->result_array();
            foreach ($adas as $ada)
            {
                $key = "codice_ada_" . $curr_ada_seq;
                $row[$key] = $ada['codice_ada'];
                $curr_ada_seq++;
            }
            $output[] = $row;
        }
        return $output;
    }

    public function select_competenze_export($ids)
    {
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        $this->db->select('id_profilo,id_competenza,titolo_competenza,descrizione_competenza,risultato_competenza');
        $this->db->where_in('id_profilo', $ids);
        $this->db->from('v_rrtq_profilo_competenze');
        $query = $this->db->get();
        $results = $query->result_array();
        
        return $results;
    }
    
    public function select_abilita_export($ids)
    {
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        
        $this->db->select('id_competenza,id_abilita,descrizione_abilita');
        $this->db->distinct();
        $this->db->where_in('id_profilo', $ids);
        $this->db->from('v_rrtq_profilo_competenze_abilita');
        $query = $this->db->get();
        $results = $query->result_array();
        
        return $results;
    }    
    
    public function select_conoscenze_export($ids)
    {
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        
        $this->db->select('id_competenza,id_conoscenza,descrizione_conoscenza');
        $this->db->distinct();
        $this->db->where_in('id_profilo', $ids);
        $this->db->from('v_rrtq_profilo_competenze_conoscenza');
        $query = $this->db->get();
        $results = $query->result_array();
        
        return $results;
    }   
    
    public function set_data_export($ids)
    {
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        
        $this->db->set('data_ultimo_export', 'NOW()', FALSE);  
        $this->db->where_in('id_profilo', $ids);
        $output = $this->db->update('rrtq_profilo');
      
        
        
        $this->activity->log("export", array(
            'id' => implode(",",$ids), 
            'table' => 'Qualificazione',
            'extra_info' => 'attraverso la funzionalità Interscambio Dati Atlante'
        ));
        
        
        return $output;
    }   

}
