<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Standard_formativo_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /* CRUD su STANDARD FORMATIVO  */

    public function save_standard_formativo($data, $id)
    {
        if ($id === "")
        {
            //INSERIMENTO STANDARD FORMATIVO
            $id_standard_formativo = $this->select_max_id_standard();

            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            /* METTE IN REVISIONE IL PROFILO */
            $id_profilo = $data['standard_formativo']['id_profilo'];
            $this->load->model("profilo_model");
            $this->profilo_model->setta_revisione_profili($id_profilo);
            /* FINE */

            $this->db->set('id_standard_formativo', $id_standard_formativo);
            $this->db->set('data_ultima_modifica', 'NOW()', FALSE);
            $this->db->set($data['standard_formativo']);
            $this->db->insert('rrtq_standard_formativo');

            //INSERIMENTO CODICI ISCED
            if (isset($data['standard_formativo_isced']))
            {
                foreach ($data['standard_formativo_isced'] as $isced)
                {
                    $standard_formativo_isced[] = array(
                        'id_standard_formativo' => $id_standard_formativo,
                        'id_isced' => $isced
                    );
                }
                $this->db->insert_batch('rrtq_standard_formativo_isced', $standard_formativo_isced);
            }

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
                    'id' => $id_standard_formativo,
                    'table' => 'Standard Formativo',
                    'extra_info' => 'con titolo ' . $data['standard_formativo']['des_standard_formativo']
                ));
                /* END LOG */
                /* MESSAGES NOTIFICATION SYSTEM */
                if ($this->config->item('enable_messages'))
                {
                    $this->messaggistica->invia_messaggio('save_standard_formativo', $data['standard_formativo']['des_standard_formativo']);
                }
                /* END MESSAGES */
                return $id_standard_formativo;
            }
        }
        else
        {
            //AGGIORNAMENTO PROFILO
            $id_standard_formativo = $id;

            //AVVIO TRANSAZIONE
            $this->db->trans_start();
            /* METTE IN REVISIONE IL PROFILO */
            $id_profilo = $data['standard_formativo']['id_profilo'];
            $this->load->model("profilo_model");
            $this->profilo_model->setta_revisione_profili($id_profilo);
            /* FINE */

            /*
             * SVOTA LA TABELLA OPPOSTA AL TIPO DI COMPOSIZIONE
             * SE flg_uf_modulo=0 (UF) allora svota rrtq_standard_formativo_mod
             * SE flg_uf_modulo=1 (MODULI) allora svota rrtq_standard_formativo_uf
             */
            if ((int) $data['standard_formativo']['flg_uf_modulo'] == 0)
            {
                $this->db->where('id_standard_formativo', $id);
                $this->db->delete('rrtq_standard_formativo_mod');
            }
            if ((int) $data['standard_formativo']['flg_uf_modulo'] == 1)
            {
                $this->db->where('id_standard_formativo', $id);
                $this->db->delete('rrtq_standard_formativo_uf');
            }
            /* FINE */


            $this->db->where('id_standard_formativo', $id_standard_formativo);
            $this->db->update('rrtq_standard_formativo', $data['standard_formativo']);

            //AGGIORNAMENTO ASSOCIAZIONE ISCED-F 
            $this->db->where('id_standard_formativo', $id_standard_formativo);
            $this->db->delete('rrtq_standard_formativo_isced');

            if (isset($data['standard_formativo_isced']))
            {
                foreach ($data['standard_formativo_isced'] as $isced)
                {
                    $standard_formativo_isced[] = array(
                        'id_standard_formativo' => $id_standard_formativo,
                        'id_isced' => $isced
                    );
                }
                $this->db->insert_batch('rrtq_standard_formativo_isced', $standard_formativo_isced);
            }

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
                    'id' => $id_standard_formativo,
                    'table' => 'Standard Formativo',
                    'extra_info' => 'con titolo ' . $data['standard_formativo']['des_standard_formativo']
                ));
                /* END LOG */
                return $id_standard_formativo;
            }
        }
    }

    public function get_standard_formativo($id)
    {
        $this->db->where('id_standard_formativo', $id);
        $this->db->from('rrtq_standard_formativo');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_id_profilo($id)
    {
        $this->db->select('id_profilo');
        $this->db->where('id_standard_formativo', $id);
        $this->db->from('rrtq_standard_formativo');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function elimina_standard_formativo($id)
    {
        if ($id !== "")
        {
            /* METTE IN REVISIONE IL PROFILO */
            $sf = $this->get_standard_formativo($id);
            $id_profilo = $sf["id_profilo"];

            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            /* PRIFILO IN REVISIONE */
            $this->load->model("profilo_model");
            $this->profilo_model->setta_revisione_profili($id_profilo);
            /* FINE */

            $this->db->where('id_standard_formativo', $id);
            $this->db->delete('rrtq_standard_formativo_uf');

            $this->db->where('id_standard_formativo', $id);
            $this->db->delete('rrtq_standard_formativo_mod');

            $this->db->where('id_standard_formativo', $id);
            $this->db->delete('rrtq_standard_formativo_isced');

            $this->db->where('id_standard_formativo', $id);
            $this->db->delete('rrtq_standard_formativo');
            //FINE TRANSAZIONE
            $this->db->trans_complete();


            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->activity->log("delete", array(
                    'id' => 'profilo ' . $id_profilo . ' id standard formativo ' . $id,
                    'table' => 'Standard Formativo',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }

    public function datatables_st_formativo()
    {
        $this->load->library('datatables');
        $this->load->helper('MY_datatable_helper');

        $this->datatables
                ->select('id_standard_formativo, des_standard_formativo,rrtq_profilo.id_stato_profilo')
                ->from('rrtq_standard_formativo')
                ->join('rrtq_profilo', 'rrtq_profilo.id_profilo = rrtq_standard_formativo.id_profilo')
                ->join('rrtq_stato_profilo', 'rrtq_profilo.id_stato_profilo = rrtq_stato_profilo.id_stato_profilo')
                ->select('des_stato_profilo');

        if (!$this->ion_auth->is_admin())
        {
            $this->datatables->where('rrtq_profilo.id_stato_profilo !=', 4);
        }

        $this->datatables->add_column('azione', '$1', 'dt_standard_formativo_action(id_standard_formativo)');

        return $this->datatables->generate();
    }

    public function select_tipo_composizione($id)
    {
        $this->db->select('flg_uf_modulo');
        $this->db->where('id_standard_formativo', $id);
        $this->db->from('rrtq_standard_formativo');
        $query = $this->db->get();
        if (empty($query->result()))
        {
            return FALSE;
        }
        return (int) $query->row()->flg_uf_modulo;
    }

    private function select_max_id_standard()
    {
        $maxid = 1;
        $row = $this->db->query('SELECT MAX(id_standard_formativo)+1 AS maxid FROM rrtq_standard_formativo')->row();
        if ($row->maxid !== null)
        {
            $maxid = $row->maxid;
        }
        return $maxid;
    }

    /* CRUD UNITA' FORMATIVA su Standard Formativo */

    public function save_unita_formativa($data, $id_unita_formativa)
    {
        $activity_op = ($id_unita_formativa === "" ? "add" : "edit");
        if ($id_unita_formativa === "")
        {
            //INSERIMENTO NUOVA             
            $this->db->set($data);
            $this->db->insert('rrtq_standard_formativo_uf');
            $id_unita_formativa = $this->db->insert_id();
        }
        else
        {
            //MODIFICA ESITENTE
            $this->db->where('id_unita_formativa', $id_unita_formativa);
            $this->db->update('rrtq_standard_formativo_uf', $data);
        }
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* PRIFILO IN REVISIONE */
        $this->load->model("profilo_model");
        $this->profilo_model->setta_revisione_profili($data["id_profilo"]);
        /* FINE */

        /* LOG ACTIVITY */
        $this->activity->log($activity_op, array('id' => $id_unita_formativa, 'table' => 'Unità Formativa'));
        /* END LOG */

        return $id_unita_formativa;
    }

    public function get_unita_formativa($id_unita_formativa)
    {
        $this->db->where('id_unita_formativa', $id_unita_formativa);
        $this->db->from('rrtq_standard_formativo_uf');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function elimina_unita_formativa($id_unita_formativa, $id_profilo)
    {
        if ($id_unita_formativa !== "")
        {
            $this->db->where('id_unita_formativa', $id_unita_formativa);
            $ret = $this->db->delete('rrtq_standard_formativo_uf');

            if ($ret === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* PRIFILO IN REVISIONE */
                $this->load->model("profilo_model");
                $this->profilo_model->setta_revisione_profili($id_profilo);
                /* FINE */

                /* LOG ACTIVITY */
                $this->activity->log("delete", array(
                    'id' => $id_unita_formativa,
                    'table' => 'Unità Formativa',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }

    public function datatables_unita_formativa($id_standard_formativo)
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_unita_formativa,id_standard_formativo,id_profilo,id_competenza,titolo_unita_formativa,ore_min_durata_uf,perc_varianza,des_eventuali_vincoli,perc_fad_uf,sequenza')
                ->from('v_rrtq_standard_formativo_uf')
                ->where('id_standard_formativo', $id_standard_formativo);

        $action_link = '<a href="javascript:edit_uf($1);" data-toggle="tooltip" data-original-title="Modifica"><i class="fa fa-edit text-inverse m-r-5"></i></a>';
        $action_link .= '<a href="javascript:del_uf($1);" data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';

        $this->datatables->add_column('azione', $action_link, 'id_unita_formativa');

        return $this->datatables->generate();
    }
    
    public function count_ore_unita_formative($id_standard_formativo)
    {
        $this->db->select_sum('ore_min_durata_uf', 'durata_min_uf')
                ->from('rrtq_standard_formativo_uf')
                ->where('id_standard_formativo', $id_standard_formativo);

        $query = $this->db->get();

        $ret = ($query->row()->durata_min_uf == null) ? 0 : $query->row()->durata_min_uf;

        return $ret;
    }

    /* CRUD MODULI su Standard Formativo */

    public function save_modulo($data, $id_modulo)
    {
        $activity_op = ($id_modulo === "" ? "add" : "edit");
        if ($id_modulo === "")
        {
            //INSERIMENTO NUOVA             
            $this->db->set($data);
            $this->db->insert('rrtq_standard_formativo_mod');
            $id_modulo = $this->db->insert_id();
        }
        else
        {
            //MODIFICA ESITENTE
            $this->db->where('id_modulo', $id_modulo);
            $this->db->update('rrtq_standard_formativo_mod', $data);
        }
        $db_error = $this->db->error();
        if ($db_error["code"] !== 0)
        {
            return FALSE;
        }
        /* PRIFILO IN REVISIONE */
        $this->load->model("profilo_model");
        $this->profilo_model->setta_revisione_profili($data["id_profilo"]);
        /* FINE */

        /* LOG ACTIVITY */
        $this->activity->log($activity_op, array('id' => $id_modulo, 'table' => 'Modulo Formativo'));
        /* END LOG */
        return $id_modulo;
    }

    public function get_modulo($id_modulo)
    {
        $this->db->where('id_modulo', $id_modulo);
        $this->db->from('rrtq_standard_formativo_mod');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function elimina_modulo($id_modulo, $id_profilo)
    {
        if ($id_modulo !== "")
        {
            $this->db->where('id_modulo', $id_modulo);
            $ret = $this->db->delete('rrtq_standard_formativo_mod');

            if ($ret === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* PRIFILO IN REVISIONE */
                $this->load->model("profilo_model");
                $this->profilo_model->setta_revisione_profili($id_profilo);
                /* FINE */

                /* LOG ACTIVITY */
                $this->activity->log("delete", array(
                    'id' => $id_modulo,
                    'table' => 'Modulo Formativo',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }

    public function datatables_moduli($id_standard_formativo)
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_modulo,id_standard_formativo,id_profilo,titolo_modulo,des_contenuti,ore_min_durata_mod,des_eventuali_vincoli,perc_fad_mod,sequenza')
                ->from('rrtq_standard_formativo_mod')
                ->where('id_standard_formativo', $id_standard_formativo);

        $action_link = '<a href="javascript:edit_mod($1);" data-toggle="tooltip" data-original-title="Modifica"><i class="fa fa-edit text-inverse m-r-5"></i></a>';
        $action_link .= '<a href="javascript:del_mod($1);" data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';

        $this->datatables->add_column('azione', $action_link, 'id_modulo');

        return $this->datatables->generate();
    }

    public function count_ore_moduli($id_standard_formativo)
    {
        $this->db->select_sum('ore_min_durata_mod', 'durata_min_mod')
                ->from('rrtq_standard_formativo_mod')
                ->where('id_standard_formativo', $id_standard_formativo);

        $query = $this->db->get();

        $ret = ($query->row()->durata_min_mod == null) ? 0 : $query->row()->durata_min_mod;

        return $ret;
    }

    public function select_stato_sf($id_profilo, $id_standard_formativo)
    {
        $this->db->select('rrtq_profilo.id_stato_profilo, rrtq_standard_formativo.data_ultima_modifica')
                ->from('rrtq_standard_formativo')
                ->join('rrtq_profilo', 'rrtq_profilo.id_profilo = rrtq_standard_formativo.id_profilo')
                ->where('rrtq_standard_formativo.id_profilo', $id_profilo)
                ->where('rrtq_standard_formativo.id_standard_formativo', $id_standard_formativo);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function list_indicatori_durata_sf($id_standard_formativo)
    {
        //CALCOLO IL VALORE DELLE ORE IN FAD A LIVELLO DI STANDARD FORMATIVO
        $this->db->select('flg_uf_modulo, (ore_min_aula_lab - ore_min_aula_lab_kc) as tot_durata_sf, SUM( ( ore_min_aula_lab - ore_min_aula_lab_kc ) * ( perc_fad_aula_lab / 100 ) ) AS tot_ore_fad_sf ', FALSE)
                ->from('rrtq_standard_formativo')
                ->where('id_standard_formativo', $id_standard_formativo);
        $query = $this->db->get();
        $data = $query->row_array();

        if ($data['flg_uf_modulo'] !== NULL)
        {
            if ($data['flg_uf_modulo'] === "0")
            {
                #somma la durata minima di tutte le uf e somma le ore destinate alla FAD applicando la percentuale
                $this->db->select('SUM(ore_min_durata_uf) as tot_durata_uf_mod, SUM(ore_min_durata_uf*(perc_fad_uf/100)) as tot_ore_uf_mod_fad', FALSE)
                        ->from('rrtq_standard_formativo_uf')
                        ->where('id_standard_formativo', $id_standard_formativo);
                $query = $this->db->get();
                $data += $query->row_array();
            }
            else
            {
                #somma la durata minima di tutti i moduli e somma le ore destinate alla FAD applicando la percentuale
                $this->db->select('SUM(ore_min_durata_mod) as tot_durata_uf_mod, SUM(ore_min_durata_mod*(perc_fad_mod/100)) as tot_ore_uf_mod_fad', FALSE)
                        ->from('rrtq_standard_formativo_mod')
                        ->where('id_standard_formativo', $id_standard_formativo);
                $query = $this->db->get();
                $data += $query->row_array();
            }
        } else {
            $data['tot_durata_uf_mod'] = NULL;
            $data['tot_ore_uf_mod_fad'] = NULL;
        }

        return $data;
    }
    
    
    /* GESTIONE UNITA FORMATIVE*/
    public function datatables_lista_unita_formativa()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_unita_formativa,id_standard_formativo,id_profilo,id_competenza,titolo_unita_formativa,ore_min_durata_uf,perc_varianza,des_eventuali_vincoli,perc_fad_uf,sequenza')
                ->from('v_rrtq_standard_formativo_uf');
                
        $action_link = '<a href="' . base_url() . 'admin/standardformativo/gestione/$1" data-toggle="tooltip" data-original-title="Apri Standard Formativo"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
       
        $this->datatables->add_column('azione', $action_link, 'id_standard_formativo');

        return $this->datatables->generate();
    }
    
    public function lista_unita_formativa_export()
    {
        $this->db->select('v_rrtq_standard_formativo_uf.id_profilo,v_rrtq_standard_formativo_uf.id_standard_formativo,id_competenza,des_standard_formativo,titolo_unita_formativa,ore_min_durata_uf,perc_varianza,perc_fad_uf');
        $this->db->from('v_rrtq_standard_formativo_uf');
        $this->db->join('rrtq_standard_formativo', 'v_rrtq_standard_formativo_uf.id_standard_formativo = rrtq_standard_formativo.id_standard_formativo');
                
        $query = $this->db->get();
        return $query->result_array();
    }
}
