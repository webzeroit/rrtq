<?php

/**
 * Name:    Repertorio Model
 * Author:  Raffaele Lanzetta
 *           r.lanzetta@gmail.com
 * 
 *
 *
 * Created:  10.01.2009
 *
 * Description:  La classe è responsabile della lettura della qualificazione con relative 
 * Unità di Competenza (Abilità e Conscenze), A.D.A., Referenziazioni CP ed ATECO per la
 * generazione della scheda in pdf/xml/json
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Qualificazione_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function select_profilo($id)
    {
        $this->db->where('id_profilo', $id);
        $this->db->from('rrtq_profilo');
        $this->db->join('rrtq_sep', 'rrtq_profilo.id_sep = rrtq_sep.id_sep');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function list_profilo_cp2011($id)
    {
        $this->db->from('rrtq_profilo_cp2011');
        $this->db->join('rrtq_istat_cp2011', 'rrtq_profilo_cp2011.codice_cp2011 = rrtq_istat_cp2011.codice_cp2011');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_ateco2007($id)
    {
        $this->db->from('rrtq_profilo_ateco2007');
        $this->db->join('rrtq_istat_ateco2007', 'rrtq_profilo_ateco2007.codice_ateco = rrtq_istat_ateco2007.codice_ateco');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_processo($id)
    {
        $this->db->select('codice_processo, descrizione_processo');
        $this->db->distinct();
        $this->db->from('v_rrtq_profilo_ada_seq_proc');
        $this->db->where('id_profilo', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_seq_processo($id)
    {
        $this->db->select('codice_sequenza, descrizione_sequenza');
        $this->db->distinct();
        $this->db->from('v_rrtq_profilo_ada_seq_proc');
        $this->db->where('id_profilo', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_ada($id)
    {
        $this->db->select('id_ada, codice_ada, descrizione_ada');
        $this->db->from('v_rrtq_profilo_ada_seq_proc');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_competenza($id)
    {
        $this->db->from('rrtq_profilo_competenza');
        $this->db->join('rrtq_competenza', 'rrtq_profilo_competenza.id_competenza = rrtq_competenza.id_competenza');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_competenza_abilita($id)
    {
        $this->db->from('rrtq_competenza_abilita');
        $this->db->join('rrtq_abilita', 'rrtq_competenza_abilita.id_abilita = rrtq_abilita.id_abilita');
        $this->db->where('id_competenza', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_competenza_conoscenza($id)
    {
        $this->db->from('rrtq_competenza_conoscenza');
        $this->db->join('rrtq_conoscenza', 'rrtq_competenza_conoscenza.id_conoscenza = rrtq_conoscenza.id_conoscenza');
        $this->db->where('id_competenza', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_competenza_cp2011($id)
    {
        $this->db->from('rrtq_competenza_cp2011');
        $this->db->join('rrtq_istat_cp2011', 'rrtq_competenza_cp2011.codice_cp2011 = rrtq_istat_cp2011.codice_cp2011');
        $this->db->where('id_competenza', $id);
        $query = $this->db->get();
        return $query->result_array();
    }    

    public function select_qualificazione($id)
    {
        $data = array();
        $data["profilo"] = $this->select_profilo($id);
        $data["profilo"]["processo"] = $this->list_profilo_processo($id);
        $data["profilo"]["seq_processo"] = $this->list_profilo_seq_processo($id);
        $data["profilo"]["ada"] = $this->list_profilo_ada($id);
        $data["profilo"]["ateco2007"] = $this->list_profilo_ateco2007($id);
        $data["profilo"]["cp2011"] = $this->list_profilo_cp2011($id);
        $competenze = $this->list_profilo_competenza($id);
        $i = 0;
        foreach ($competenze as $competenza)
        {
            $id_competenza = $competenza["id_competenza"];
            $data["profilo"]["competenze"][$i] = $competenza;
            $data["profilo"]["competenze"][$i]["abilita"] = $this->list_competenza_abilita($id_competenza);
            $data["profilo"]["competenze"][$i]["conoscenza"] = $this->list_competenza_conoscenza($id_competenza);
            $i++;
        }
        return $data;
    }

    public function select_qualificazione_serialized($id)
    {
        $this->db->select('file_qualificazione');
        $this->db->from('rrtq_profilo');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        $data = $query->row_array();
        return unserialize($data['file_qualificazione']);
    }

    public function elimina_qualificazione($id)
    {
        if ($id !== "")
        {
            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_cp2011');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_ateco2007');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_competenza');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_ada');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo');

            //FINE TRANSAZIONE
            $this->db->trans_complete();


            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->db->cache_delete_all();
                $this->activity->log("delete", array(
                    'id' => $id,
                    'table' => 'Qualificazione',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }

}
