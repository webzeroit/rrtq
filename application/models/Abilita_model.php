<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Abilita_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function list_abilita()
    {
        $this->db->from('rrtq_abilita');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_abilita($id)
    {
        $this->db->where('id_abilita', $id);
        $this->db->from('rrtq_abilita');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function search_abilita($parola_chiave)
    {
        $this->db->select('id_abilita as id, descrizione_abilita as text');
        $this->db->like('descrizione_abilita', $parola_chiave);
        $this->db->from('rrtq_abilita');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_abilita($data, $id)
    {
        if ($id === "")
        {
            //INSERIMENTO NUOVA 
            $id_abilita = $this->select_max_id_abilita();
            $this->db->set('id_abilita', $id_abilita);
            $this->db->set($data['abilita']);
            $this->db->insert('rrtq_abilita');
        }
        else
        {
            //MODIFICA ESITENTE
            $id_abilita = $id;
            $this->db->where('id_abilita', $id_abilita);
            $this->db->update('rrtq_abilita', $data['abilita']);
        }
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* LOG ACTIVITY */
        $activity_op = ($id === "" ? "add" : "edit");
        $this->activity->log($activity_op, array('id' => $id_abilita, 'table' => 'Abilità'));
        /* END LOG */
        return $id_abilita;
    }

    /* TABELLA DELLE ABILITA */

    public function datatables_abilita()
    {
        $this->load->library('datatables');
        $this->load->helper('MY_datatable_helper');
        
        $this->datatables
                ->select('id_abilita, descrizione_abilita, competenze_associate')
                ->from('v_rrtq_abilita');

        $this->datatables->add_column('azione', '$1', 'dt_abilita_action(id_abilita,competenze_associate)');
       
        return $this->datatables->generate();
    }

    /* TABELLA DELLE COMPETENZE ASSOCIATE ALL'ABILITA' */

    public function datatables_competenze_abilita($id_abilita)
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('v_rrtq_competenza.id_competenza,titolo_competenza,risultato_competenza,profili_associati')
                ->from('v_rrtq_competenza')
                ->join('rrtq_competenza_abilita', 'v_rrtq_competenza.id_competenza = rrtq_competenza_abilita.id_competenza')
                ->where('id_abilita', $id_abilita);

        $action_link = '<a href="' . base_url() . 'admin/unitacompetenza/gestione/$1" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';

        $this->datatables->add_column('azione', $action_link, 'id_competenza');

        return $this->datatables->generate();
    }
    
    
    private function select_max_id_abilita()
    {
        $maxid = 1;
        $row = $this->db->query('SELECT MAX(id_abilita)+1 AS maxid FROM rrtq_abilita')->row();
        if ($row)
        {
            $maxid = $row->maxid;
        }
        return $maxid;
    }
    
    public function elimina_abilita($id)
    {
        if ($id !== "")
        {
            $this->db->where('id_abilita', $id);
            $ret = $this->db->delete('rrtq_abilita');

            if ($ret === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->activity->log("delete", array(
                    'id' => $id,
                    'table' => 'Abilità',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }


}
