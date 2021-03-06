<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profilo_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        /*
         * MESSAGGISTICA                
         */
        $this->load->library('messaggistica');
    }

    public function datatables_profili()
    {
        $this->load->library('datatables');
        $this->load->helper('MY_datatable_helper');

        $this->datatables
                ->select('id_profilo,id_sep,titolo_profilo,rrtq_profilo.id_stato_profilo')
                ->from('rrtq_profilo')
                ->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo')
                ->select('des_stato_profilo');
        /*
         * FILTRO AVANZATO
         */
        if ($this->input->post("id_sep"))
        {
            $this->datatables->where('id_sep =', $this->input->post("id_sep"));
        }
        if ($this->input->post("livello_eqf"))
        {
            $this->datatables->where('livello_eqf =', $this->input->post("livello_eqf"));
        }
        if (intval($this->input->post("id_stato_profilo")) >= 0)
        {
            $this->datatables->where('rrtq_profilo.id_stato_profilo', intval($this->input->post("id_stato_profilo")));
        }
        if ($this->input->post("titolo_profilo"))
        {
            $this->datatables->like('titolo_profilo', $this->input->post("titolo_profilo"));
        }
        if (intval($this->input->post("flg_regolamentato")) >= 0)
        {
            if (intval($this->input->post("flg_regolamentato")) === 0)
            {
                $where_fr = "flg_regolamentato IS NULL";
            }
            else
            {
                $where_fr = "flg_regolamentato IS NOT NULL";
            }
            $this->datatables->where($where_fr);
        }
        
        if (!$this->ion_auth->is_admin())
        {
            $this->datatables->where('rrtq_profilo.id_stato_profilo !=', 4);
        }

        //$action_link = '<a href="qualificazione/gestione/$1" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
        //$action_link .= '<a href="../public/GeneraPDF/$1" target="_blank" data-toggle="tooltip" data-original-title="Scarica PDF"><i class="fa fa-file-pdf-o text-danger m-r-5"></i></a>';
        //$this->datatables->add_column('azione', $action_link, 'id_profilo');
        //CHIAMATA DI CALLBACK 
        $this->datatables->add_column('azione', '$1', 'dt_profilo_action(id_profilo,id_stato_profilo)');

        return $this->datatables->generate();
    }

    public function list_profili($where = NULL)
    {
        $this->db->select('id_profilo,titolo_profilo');
        if ($where !== NULL)
        {
            $this->db->where($where);
        }
        $this->db->from('rrtq_profilo');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function datatables_profilo_competenze($id_profilo)
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_profilo,rrtq_profilo_competenza.id_competenza')
                ->from('rrtq_profilo_competenza')
                ->join('rrtq_competenza', 'rrtq_profilo_competenza.id_competenza = rrtq_competenza.id_competenza')
                ->select('titolo_competenza,descrizione_competenza,risultato_competenza,oggetto_di_osservazione,indicatori,livello_eqf')
                ->where('id_profilo', $id_profilo);

        $action_link = '<a href="' . base_url() . 'admin/unitacompetenza/gestione/$1" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
        $action_link .= '<a href="'. base_url() . 'admin/unitacompetenza/stampa/$1" target="_blank" data-toggle="tooltip" data-original-title="Stampa UC"><i class="fa fa-file-pdf-o text-inverse m-r-5"></i></a>';
        $action_link .= '<a href="javascript:del_competenza($1);" data-toggle="tooltip" data-original-title="Dissocia"><i class="fa fa-chain-broken text-danger m-r-5"></i></a>';

        $this->datatables->add_column('azione', $action_link, 'id_competenza');

        return $this->datatables->generate();
    }

    public function datatables_profilo_st_formativo($id_profilo)
    {
        $this->load->library('datatables');
        $this->load->helper('MY_datatable_helper');

        $this->datatables
                ->select('id_standard_formativo, des_standard_formativo')
                ->from('rrtq_standard_formativo')
                ->where('id_profilo', $id_profilo);

        $this->datatables->add_column('azione', '$1', 'dt_standard_formativo_action(id_standard_formativo)');

        return $this->datatables->generate();
    }

    public function list_stato_profilo()
    {
        $this->db->select('id_stato_profilo,des_stato_profilo');
        $this->db->from('rrtq_stato_profilo');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function save_profilo($data, $id)
    {
        if ($id === "")
        {
            //INSERIMENTO NUOVO PROFILO
            $id_profilo = $this->select_max_id_profilo();

            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            $this->db->set('id_profilo', $id_profilo);
            /*
             * 2018-07-16 In inserimento per default il profilo è impostato a In Revisione
             */
            $this->db->set('id_stato_profilo', 2);
            $this->db->set('data_ultima_modifica', 'NOW()', FALSE);
            $this->db->set($data['profilo']);
            $this->db->insert('rrtq_profilo');

            //INSERIMENTO ASSOCIAZIONE ADA
            foreach ($data['profilo_ada'] as $ada)
            {
                $profilo_ada[] = array(
                    'id_profilo' => $id_profilo,
                    'id_ada' => $ada
                );
            }
            $this->db->insert_batch('rrtq_profilo_ada', $profilo_ada);
            //INSERIMENTO ASSOCIAZIONE ATECO
            foreach ($data['profilo_ateco'] as $ateco)
            {
                $profilo_ateco[] = array(
                    'id_profilo' => $id_profilo,
                    'codice_ateco' => $ateco
                );
            }
            $this->db->insert_batch('rrtq_profilo_ateco2007', $profilo_ateco);
            //INSERIMENTO ASSOCIAZIONE CODICI PROFESSIONI
            foreach ($data['profilo_cp2011'] as $cp2011)
            {
                $profilo_cp2011[] = array(
                    'id_profilo' => $id_profilo,
                    'codice_cp2011' => $cp2011
                );
            }
            $this->db->insert_batch('rrtq_profilo_cp2011', $profilo_cp2011);

            //FINE TRANSAZIONE
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->activity->log("add", array(
                    'id' => $id_profilo,
                    'table' => 'Qualificazione',
                    'extra_info' => 'con titolo ' . $data['profilo']['titolo_profilo']
                ));
                /* END LOG */
                /* MESSAGES NOTIFICATION SYSTEM */
                if ($this->config->item('enable_messages'))
                {
                    $this->messaggistica->invia_messaggio('save_profilo', $data['profilo']['titolo_profilo']);
                }
                /* END MESSAGES */
                return $id_profilo;
            }
        }
        else
        {
            //AGGIORNAMENTO PROFILO
            $id_profilo = $id;
            $stato_profilo = $this->select_stato_profilo($id_profilo);
            $curr_stato_profilo = (int) $stato_profilo['id_stato_profilo'];

            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            /* NEL CASO IN CUI LO STATO PASSA DA PUBBLICATA (0) AD ALTRO SERIALIZZO IL CONTENUTO */
            if ($curr_stato_profilo === 0)
            {
                $this->db->set('id_stato_profilo', 2);
                $this->load->model('qualificazione_model');
                $file_qualificazione = $this->qualificazione_model->select_qualificazione($id_profilo);
                $this->db->set('file_qualificazione', serialize($file_qualificazione));
            }
            /* NEL CASO IN CUI LA REVISIONE FOSSE STATA APPROVATA, RIMETTE LO STATO IN REVISIONE */
            if ($curr_stato_profilo === 1)
            {
                $this->db->set('id_stato_profilo', 2);
            }
            $this->db->set($data['profilo']);
            $this->db->where('id_profilo', $id_profilo);
            $this->db->update('rrtq_profilo');

            //AGGIORNAMENTO ASSOCIAZIONE ADA
            $this->db->where('id_profilo', $id_profilo);
            $this->db->delete('rrtq_profilo_ada');
            foreach ($data['profilo_ada'] as $ada)
            {
                $profilo_ada[] = array(
                    'id_profilo' => $id_profilo,
                    'id_ada' => $ada
                );
            }
            $this->db->insert_batch('rrtq_profilo_ada', $profilo_ada);

            //AGGIORNAMENTO ASSOCIAZIONE ATECO
            $this->db->where('id_profilo', $id_profilo);
            $this->db->delete('rrtq_profilo_ateco2007');
            foreach ($data['profilo_ateco'] as $ateco)
            {
                $profilo_ateco[] = array(
                    'id_profilo' => $id_profilo,
                    'codice_ateco' => $ateco
                );
            }
            $this->db->insert_batch('rrtq_profilo_ateco2007', $profilo_ateco);

            //AGGIORNAMENTO ASSOCIAZIONE CODICI PROFESSIONI
            $this->db->where('id_profilo', $id_profilo);
            $this->db->delete('rrtq_profilo_cp2011');
            foreach ($data['profilo_cp2011'] as $cp2011)
            {
                $profilo_cp2011[] = array(
                    'id_profilo' => $id_profilo,
                    'codice_cp2011' => $cp2011
                );
            }
            $this->db->insert_batch('rrtq_profilo_cp2011', $profilo_cp2011);
            //FINE TRANSAZIONE
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->activity->log("edit", array(
                    'id' => $id_profilo,
                    'table' => 'Qualificazione',
                    'extra_info' => 'con titolo ' . $data['profilo']['titolo_profilo']
                ));
                /* END LOG */
                //SE PASSA IN REVISIONE DA PUBBLICATO O REVISIONE APPROVATA INVIA MESSAGGIO
                if ($curr_stato_profilo < 2)
                {
                    /* MESSAGES NOTIFICATION SYSTEM */
                    if ($this->config->item('enable_messages'))
                    {
                        $this->messaggistica->invia_messaggio('setta_revisione_profili', $data['profilo']['titolo_profilo']);
                    }
                    /* END MESSAGES */
                }

                return $id_profilo;
            }
        }
    }

    public function save_associazione_competenza($data, $action)
    {
        $this->setta_revisione_profili($data['id_profilo']);

        $this->db->where($data);
        $this->db->delete('rrtq_profilo_competenza');
        if ($action === "add")
        {
            $this->db->insert('rrtq_profilo_competenza', $data);
        }


        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* LOG ACTIVITY */
        $activity_op = ($action === "add" ? "add" : "delete");
        $this->activity->log($activity_op, array(
            'id' => 'profilo ' . $data['id_profilo'] . ' id competenza ' . $data['id_competenza'],
            'table' => 'Qualificazione-Competenza'
        ));
        /* END LOG */


        return TRUE;
    }

    public function list_ridondanze_abilita($id_profilo)
    {
        $this->db->select('id_abilita,ridondanze');
        $this->db->from('v_rrtq_profilo_ridondanze_abilita');
        $this->db->where('id_profilo', $id_profilo);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function list_ridondanze_conoscenza($id_profilo)
    {
        $this->db->select('id_conoscenza,ridondanze');
        $this->db->from('v_rrtq_profilo_ridondanze_conoscenza');
        $this->db->where('id_profilo', $id_profilo);
        $query = $this->db->get();
        return $query->result_array();
    }    
    
    /*GESTIONE DEGLI STATI*/
    public function avvia_pubblicazione($id)
    {

        //AVVIO TRANSAZIONE
        $this->db->trans_start();

        $this->db->set('id_stato_profilo', 0);
        $this->db->set('file_qualificazione', NULL);
        $this->db->set('data_ultima_pubblicazione', 'NOW()', FALSE);
        $this->db->where('id_profilo', $id);
        $this->db->update('rrtq_profilo');

        $this->db->set('data_ultima_pubblicazione', 'NOW()', FALSE);
        $this->db->where('id_profilo', $id);
        $this->db->update('rrtq_standard_formativo');

        //06/09/2018 ARCHIVIO STORICO DELLE PUBBLICAZIONI
        $this->load->model('qualificazione_model');
        $file_da_storicizzare = $this->qualificazione_model->select_qualificazione($id);
        
        $this->db->set('id_profilo', $id);
        $this->db->set('data_pubblicazione', 'NOW()', FALSE);
        $this->db->set('file_qualificazione', serialize($file_da_storicizzare));
        $this->db->insert('rrtq_archivio_pubblicazioni');
        
        //FINE TRANSAZIONE
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return FALSE;
        }
        else
        {
            /* LOG ACTIVITY */
            $this->activity->log('publish', array('id' => $id, 'table' => 'Qualificazione'));
            /* END LOG */
            /* MESSAGES NOTIFICATION SYSTEM */
            if ($this->config->item('enable_messages'))
            {
                $this->messaggistica->invia_messaggio('avvia_pubblicazione', $this->get_titoli_profilo($id));
            }
            /* END MESSAGES */
            return TRUE;
        }
    }

    public function sospendi_pubblicazione($id)
    {
        $this->db->set('id_stato_profilo', 3);
        $this->db->where('id_profilo', $id);
        $this->db->update('rrtq_profilo');
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* LOG ACTIVITY */
        $this->activity->log('unpublish', array('id' => $id, 'table' => 'Qualificazione'));
        /* END LOG */
        /* MESSAGES NOTIFICATION SYSTEM */
        if ($this->config->item('enable_messages'))
        {
            $this->messaggistica->invia_messaggio('sospendi_pubblicazione', $this->get_titoli_profilo($id));
        }
        /* END MESSAGES */
        return TRUE;
    }

    public function elimina_pubblicazione($id)
    {
        $this->db->set('id_stato_profilo', 4);
        $this->db->where('id_profilo', $id);
        $this->db->update('rrtq_profilo');
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* LOG ACTIVITY */
        $this->activity->log('delete', array('id' => $id, 'table' => 'Qualificazione'));
        /* END LOG */
        /* MESSAGES NOTIFICATION SYSTEM */
        if ($this->config->item('enable_messages'))
        {
            $this->messaggistica->invia_messaggio('elimina_pubblicazione', $this->get_titoli_profilo($id));
        }
        /* END MESSAGES */
        return TRUE;
    }

    public function approva_revisione($id)
    {
        $this->db->set('id_stato_profilo', 1);
        $this->db->where('id_profilo', $id);
        $this->db->update('rrtq_profilo');
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* LOG ACTIVITY */
        $this->activity->log('revision_ok', array('id' => $id, 'table' => 'Qualificazione'));
        /* END LOG */
        /* MESSAGES NOTIFICATION SYSTEM */
        if ($this->config->item('enable_messages'))
        {
            $this->messaggistica->invia_messaggio('approva_revisione', $this->get_titoli_profilo($id));
        }
        /* END MESSAGES */
        return TRUE;
    }
    
        
    public function revisione_completa($id)
    {
        $ret = FALSE;
        if ($this->config->item('enable_messages'))
        {
           $ret = $this->messaggistica->invia_messaggio('revisione_completa', $this->get_titoli_profilo($id));
        } 
        return $ret;
    }

    public function restore_profilo($id)
    {
        $id_ultimo_stato = 2; //IN REVISIONE
        $this->db->select('file_qualificazione');
        $this->db->where('id_profilo', $id);
        $this->db->from('rrtq_profilo');
        $query = $this->db->get();
        $ret = $query->row_array();

        if ($ret['file_qualificazione'] === NULL)
        {
            $id_ultimo_stato = 0;
        }

        $this->db->set('id_stato_profilo', $id_ultimo_stato);
        $this->db->where('id_profilo', $id);
        $this->db->update('rrtq_profilo');
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* LOG ACTIVITY */
        $this->activity->log('restore_ok', array('id' => $id, 'table' => 'Qualificazione'));
        /* END LOG */
        /* MESSAGES NOTIFICATION SYSTEM */
        if ($this->config->item('enable_messages'))
        {
            $this->messaggistica->invia_messaggio('ripristina_qualificazione', $this->get_titoli_profilo($id));
        }
        /* END MESSAGES */
        return TRUE;
    }

    public function setta_revisione_profili($ids)
    {
        //contiene gli ID che passano per la prima volta in revisione
        $id_da_notificare = array();
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        foreach ($ids as $id_profilo)
        {
            $this->db->select('id_stato_profilo')
                    ->from('rrtq_profilo')
                    ->where('id_profilo', $id_profilo);
            $query = $this->db->get();
            $row = $query->row(0)->id_stato_profilo;

            if ((int) $row < 2)
            {
                $this->db->set('id_stato_profilo', 2);
                // NEL CASO IN CUI LO STATO PASSASSE DA PUBBLICATA AD ALTRO SERIALIZZO IL CONTENUTO 
                $this->load->model('qualificazione_model');
                $file_qualificazione = $this->qualificazione_model->select_qualificazione($id_profilo);
                $this->db->set('file_qualificazione', serialize($file_qualificazione));
                $this->db->where('id_profilo', $id_profilo);
                $this->db->update('rrtq_profilo');
                $id_da_notificare[] = $id_profilo;
            }
            //Quando lo stato corrente è NON PUBBLICATO e si modifica una qualificazione,
            //lo stato non cambia ma non si attiva il controolo delle modifiche ( In Revisione, etc.). 
            //Per evitare che questo avvenga e gestire il processo di validazione delle modifiche
            //la versione corrente dovrebbe passare a "In revisione" e settare a NULL "data_ultima_pubblicazione"
            // Facendo così il pubblico non visualizza la qualificazione in elenco.
        }

        if (count($ids) > 0)
        {
            /* LOG ACTIVITY */
            $this->activity->log('revision', array('id' => implode(",", $ids), 'table' => 'Qualificazione'));
            /* END LOG */
        }
        /* MESSAGES NOTIFICATION SYSTEM */
        if ($this->config->item('enable_messages'))
        {
            if (count($id_da_notificare) > 0)
            {
                $this->messaggistica->invia_messaggio('setta_revisione_profili', $this->get_titoli_profilo($id_da_notificare));
            }
        }
        /* END MESSAGES */
    }

    public function select_stato_profilo($id)
    {
        $this->db->select('id_stato_profilo,data_ultima_modifica');
        $this->db->where('id_profilo', $id);
        $this->db->from('rrtq_profilo');
        $query = $this->db->get();
        return $query->row_array();
    }

    private function select_max_id_profilo()
    {
        $maxid = 1;
        $row = $this->db->query('SELECT MAX(id_profilo)+1 AS maxid FROM rrtq_profilo')->row();
        if ($row)
        {
            $maxid = $row->maxid;
        }
        return $maxid;
    }

    /* OTTIENE LE DENOMINAZIONI DEI PROFILI PER LOG ED EMAIL */
    private function get_titoli_profilo($ids)
    {
        // crea un array se solo un ID è stato passato
        if (!is_array($ids))
        {
            $ids = array($ids);
        }
        $this->db->select('titolo_profilo');
        $this->db->from('rrtq_profilo');
        $this->db->where_in('id_profilo', $ids);

        $query = $this->db->get();
        $titoli = $query->result_array();
        $titoli_str = "";
        foreach ($query->result_array() as $titolo)
        {

            $titoli_str .= $titolo["titolo_profilo"] . "<br/>";
        }


        return $titoli_str;
    }

}
