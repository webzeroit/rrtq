<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Conoscenza_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function list_conoscenza()
    {
        $this->db->cache_on();
        $this->db->from('rrtq_conoscenza');
        $query = $this->db->get();
        $this->db->cache_off();
        return $query->result_array();
    }

    public function get_conoscenza($id)
    {
        $this->db->where('id_conoscenza', $id);
        $this->db->from('rrtq_conoscenza');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function search_conoscenza($parola_chiave)
    {
        $this->db->select('id_conoscenza as id, descrizione_conoscenza as text');
        $this->db->like('descrizione_conoscenza', $parola_chiave);
        $this->db->from('rrtq_conoscenza');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_conoscenza($data, $id)
    {
        if ($id === "")
        {
            //INSERIMENTO NUOVA 
            $id_conoscenza = $this->select_max_id_conoscenza();
            $this->db->set('id_conoscenza', $id_conoscenza);
            $this->db->set($data['conoscenza']);
            $this->db->insert('rrtq_conoscenza');
        }
        else
        {
            //MODIFICA ESITENTE
            $id_conoscenza = $id;
            $this->db->where('id_conoscenza', $id_conoscenza);
            $this->db->update('rrtq_conoscenza', $data['conoscenza']);
        }
        $db_error = $this->db->error();
        if (!$db_error["code"] === 0)
        {
            return FALSE;
        }
        $this->db->cache_delete_all();
        /* LOG ACTIVITY */
        $activity_op = ($id === "" ? "add" : "edit");
        $this->activity->log($activity_op, array('id' => $id_conoscenza, 'table' => 'Conoscenza'));
        /* END LOG */
        
        return $id_conoscenza;
    }

    /* TABELLA DELLE CONOSCENZE */
    public function datatables_conoscenza()
    {
        $this->load->library('datatables');
        $this->load->helper('MY_datatable_helper');
        
        $this->datatables
                ->select('id_conoscenza, descrizione_conoscenza, competenze_associate')
                ->from('v_rrtq_conoscenza');

        $this->datatables->add_column('azione', '$1', 'dt_conoscenza_action(id_conoscenza,competenze_associate)');
         
        return $this->datatables->generate();
    }

    /* TABELLA DELLE COMPETENZE ASSOCIATE ALLA CONOSCENZA */
    public function datatables_competenze_conoscenza($id_conoscenza)
    {
        $this->load->library('datatables');
        
        
        $this->datatables
                ->select('v_rrtq_competenza.id_competenza,titolo_competenza,descrizione_competenza,profili_associati')
                ->from('v_rrtq_competenza')
                ->join('rrtq_competenza_conoscenza', 'v_rrtq_competenza.id_competenza = rrtq_competenza_conoscenza.id_competenza')
                ->where('id_conoscenza', $id_conoscenza);

        $action_link = '<a href="' . base_url() . 'admin/unitacompetenza/gestione/$1" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
        $this->datatables->add_column('azione', $action_link, 'id_competenza');

        return $this->datatables->generate();
    }
        
    private function select_max_id_conoscenza()
    {
        $maxid = 1;
        $row = $this->db->query('SELECT MAX(id_conoscenza)+1 AS maxid FROM rrtq_conoscenza')->row();
        if ($row)
        {
            $maxid = $row->maxid;
        }
        return $maxid;
    }
    
    public function elimina_conoscenza($id)
    {
        if ($id !== "")
        {
            $this->db->where('id_conoscenza', $id);
            $ret = $this->db->delete('rrtq_conoscenza');

            if ($ret === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->db->cache_delete_all();
                $this->activity->log("delete", array(
                    'id' => $id,
                    'table' => 'Conoscenza',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }
}
