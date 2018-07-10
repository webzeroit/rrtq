<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Competenza_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function list_competenza()
    {
        $this->db->cache_on();
        $this->db->select('id_competenza, titolo_competenza, descrizione_competenza, risultato_competenza, oggetto_di_osservazione, indicatori, livello_eqf');
        $this->db->from('rrtq_competenza');
        $query = $this->db->get();
        $this->db->cache_off();
        return $query->result_array();
    }

    public function get_competenza($id)
    {
        $this->db->select('id_competenza, titolo_competenza, descrizione_competenza, risultato_competenza, oggetto_di_osservazione, indicatori, livello_eqf');
        $this->db->where('id_competenza', $id);
        $this->db->from('rrtq_competenza');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function save_competenza($data, $id)
    {
        if ($id === "")
        {
            //INSERIMENTO NUOVA COMPETENZA
            $id_competenza = $this->select_max_id_competenza();

            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            $this->db->set('id_competenza', $id_competenza);
            $this->db->set($data['competenza']);
            $this->db->insert('rrtq_competenza');

            //INSERIMENTO ASSOCIAZIONE ABILITA
            foreach ($data['competenza_abilita'] as $abilita)
            {
                $competenza_abilita[] = array(
                    'id_competenza' => $id_competenza,
                    'id_abilita' => $abilita
                );
            }
            $this->db->insert_batch('rrtq_competenza_abilita', $competenza_abilita);

            //INSERIMENTO ASSOCIAZIONE CONOSCENZE
            foreach ($data['competenza_conoscenza'] as $conoscenza)
            {
                $competenza_conoscenza[] = array(
                    'id_competenza' => $id_competenza,
                    'id_conoscenza' => $conoscenza
                );
            }
            $this->db->insert_batch('rrtq_competenza_conoscenza', $competenza_conoscenza);

            // INSERIMENTO ASSOCIAZIONE CODICI PROFESSIONI 
            // PER IL MOMENTO NON OBBLIGATORIO
            if (isset($data['competenza_cp2011']))
            {
                foreach ($data['competenza_cp2011'] as $cp2011)
                {
                    $competenza_cp2011[] = array(
                        'id_competenza' => $id_competenza,
                        'codice_cp2011' => $cp2011
                    );
                }
                $this->db->insert_batch('rrtq_competenza_cp2011', $competenza_cp2011);
            }
            //FINE TRANSAZIONE
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                $this->db->cache_delete_all();
                /* LOG ACTIVITY */
                $this->activity->log("add", array(
                    'id' => $id_competenza,
                    'table' => 'Competenza',
                    'extra_info' => 'con titolo ' . $data['competenza']['titolo_competenza']
                ));
                /* END LOG */
                return $id_competenza;
            }
        }
        else
        {
            //AGGIORNAMENTO COMPETENZA
            $id_competenza = $id;
            //AVVIO TRANSAZIONE
            $this->db->trans_start();


            /* SELEZIONA I PROFILI CHE USANO LA COMPETENZA E LI METTE IN REVISIONE */
            $this->db->select('id_profilo')
                    ->from('rrtq_profilo_competenza')
                    ->where('id_competenza', $id_competenza);
            $query = $this->db->get();
            $ids = array();
            foreach ($query->result_array() as $id)
            {
                $ids[] = $id['id_profilo'];
            }
            $this->load->model("profilo_model");
            $this->profilo_model->setta_revisione_profili($ids);
            /* FINE */

            $this->db->where('id_competenza', $id_competenza);
            $this->db->update('rrtq_competenza', $data['competenza']);

            //MODIFICA ASSOCIAZIONE ABILITA
            $this->db->where('id_competenza', $id_competenza);
            $this->db->delete('rrtq_competenza_abilita');
            foreach ($data['competenza_abilita'] as $abilita)
            {
                $competenza_abilita[] = array(
                    'id_competenza' => $id_competenza,
                    'id_abilita' => $abilita
                );
            }
            $this->db->insert_batch('rrtq_competenza_abilita', $competenza_abilita);

            //MODIFICA ASSOCIAZIONE CONOSCENZE
            $this->db->where('id_competenza', $id_competenza);
            $this->db->delete('rrtq_competenza_conoscenza');
            foreach ($data['competenza_conoscenza'] as $conoscenza)
            {
                $competenza_conoscenza[] = array(
                    'id_competenza' => $id_competenza,
                    'id_conoscenza' => $conoscenza
                );
            }
            $this->db->insert_batch('rrtq_competenza_conoscenza', $competenza_conoscenza);

            //MODIFICA ASSOCIAZIONE CODICI PROFESSIONI
            $this->db->where('id_competenza', $id_competenza);
            $this->db->delete('rrtq_competenza_cp2011');
            if (isset($data['competenza_cp2011']))
            {
                foreach ($data['competenza_cp2011'] as $cp2011)
                {
                    $competenza_cp2011[] = array(
                        'id_competenza' => $id_competenza,
                        'codice_cp2011' => $cp2011
                    );
                }
                $this->db->insert_batch('rrtq_competenza_cp2011', $competenza_cp2011);
            }

            //FINE TRANSAZIONE
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                $this->db->cache_delete_all();
                /* LOG ACTIVITY */
                $this->activity->log("edit", array(
                    'id' => $id_competenza,
                    'table' => 'Competenza',
                    'extra_info' => 'con titolo ' . $data['competenza']['titolo_competenza']
                ));
                return $id_competenza;
            }
        }
    }

    /* TABELLA DELLE COMPETENZE */

    public function datatables_competenza()
    {
        $this->load->library('datatables');
        $this->load->helper('MY_datatable_helper');

        $this->datatables
                ->select('id_competenza, titolo_competenza, descrizione_competenza, profili_associati')
                ->from('v_rrtq_competenza');

        $this->datatables->add_column('azione', '$1', 'dt_uc_action(id_competenza,profili_associati)');

        return $this->datatables->generate();
    }

    /* TABELLA DEI PROFILI ASSOCIATI ALLA COMPETENZA */

    public function datatables_competenza_profili($id_competenza)
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('rrtq_profilo.id_profilo,id_sep,titolo_profilo,flg_regolamentato,rrtq_profilo.id_stato_profilo')
                ->from('rrtq_profilo')
                ->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo')
                ->select('des_stato_profilo')
                ->join('rrtq_profilo_competenza', 'rrtq_profilo.id_profilo = rrtq_profilo_competenza.id_profilo')
                ->where('id_competenza', $id_competenza);

        $action_link = '<a href="' . base_url() . 'admin/qualificazione/gestione/$1" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';

        $this->datatables->add_column('azione', $action_link, 'id_profilo');

        return $this->datatables->generate();
    }

    private function select_max_id_competenza()
    {
        $maxid = 1;
        $row = $this->db->query('SELECT MAX(id_competenza)+1 AS maxid FROM rrtq_competenza')->row();
        if ($row)
        {
            $maxid = $row->maxid;
        }
        return $maxid;
    }

    public function elimina_competenza($id)
    {
        if ($id !== "")
        {
            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            $this->db->where('id_competenza', $id);
            $this->db->delete('rrtq_competenza_abilita');

            $this->db->where('id_competenza', $id);
            $this->db->delete('rrtq_competenza_conoscenza');

            $this->db->where('id_competenza', $id);
            $this->db->delete('rrtq_competenza');


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
                    'table' => 'Competenza',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }

}
