<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StandardFormativo extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');
        //CSS
        $this->load->css('assets/plugins/select2/dist/css/select2.min.css');
        //JS        
        $this->load->js('assets/plugins/select2/dist/js/select2.full.min.js');
        $this->load->js('assets/plugins/select2/dist/js/i18n/it.js');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function index()
    {
        $this->output->set_title("Elenco standard formativi");
        $this->load->view('standardformativo/lista');
    }

    public function nuovo($id_profilo)
    {
        $this->output->set_title("Nuovo Standard Formativo");
        $this->load->model('qualificazione_model');
        $this->load->model('isced_model');

        $profilo = $this->qualificazione_model->select_profilo($id_profilo);

        if ($profilo === NULL)
        {
            redirect('admin/standardformativo', 'refresh');
        }

        $data = array(
            'action' => "add",
            'standard_formativo' => NULL,
            'id_standard_formativo' => NULL,
            'list_isced' => $this->isced_model->list_detailed(),
            'id_profilo' => $id_profilo,
            'profilo' => $profilo
        );


        $this->load->view('standardformativo/gestione', $data);
    }

    public function gestione($id_standard_formativo = NULL)
    {
        $this->output->set_title("Gestione Standard Formativo");
        $this->load->model('standard_formativo_model');
        $this->load->model('qualificazione_model');
        $this->load->model('profilo_model');
        $this->load->model('isced_model');

        $standard_formativo = $this->standard_formativo_model->get_standard_formativo($id_standard_formativo);
        if ($standard_formativo === NULL)
        {
            show_404();
        }
        $profilo = $this->qualificazione_model->select_profilo($standard_formativo['id_profilo']);

        $data = array(
            'action' => "edit",
            'standard_formativo' => $standard_formativo,
            'id_standard_formativo' => $id_standard_formativo,
            'list_isced' => $this->isced_model->list_detailed(),
            'list_stato_profilo' => $this->profilo_model->list_stato_profilo(),
            'id_profilo' => $profilo['id_profilo'],
            'profilo' => $profilo
        );

        $this->load->view('standardformativo/gestione', $data);
    }

    /*
     * AJAX CALLS
     */

    public function save_standard_formativo()
    {

        $FormRules = array(
            array(
                'field' => 'des_standard_formativo',
                'label' => 'Denominazione Standard Formativo',
                'rules' => 'trim|required|max_length[255]',
            ),
            array(
                'field' => 'req_min_partecipanti',
                'label' => 'Requisiti minimi di ingresso dei partecipanti',
                'rules' => 'trim|required|max_length[4000]',
            ),
            array(
                'field' => 'req_min_didattici',
                'label' => 'Requisiti minimi didattici comuni a tutte le UF/segmenti',
                'rules' => 'trim|required|max_length[4000]',
            ),
            array(
                'field' => 'req_min_risorse',
                'label' => 'Requisiti minimi di risorse professionali e strumentali',
                'rules' => 'trim|required|max_length[4000]',
            ),
            array(
                'field' => 'req_min_valutazione',
                'label' => 'Requisiti minimi di valutazione e di attestazione degli apprendimenti',
                'rules' => 'trim|required|max_length[4000]',
            ),
            array(
                'field' => 'ore_min_durata_percorso',
                'label' => 'Durata minima complessiva del percorso (ore)',
                'rules' => 'required|is_natural_no_zero|max_length[4]|callback_valida_durata',
            ),
            array(
                'field' => 'ore_min_aula_lab',
                'label' => 'Durata minima di aula e laboratorio (ore)',
                'rules' => 'required|is_natural|max_length[4]',
            ),
            array(
                'field' => 'ore_min_aula_lab_kc',
                'label' => 'Durata minima delle attività di aula e laboratorio rivolte alle KC (ore)',
                'rules' => 'required|is_natural|max_length[4]|less_than[' . $this->input->post("ore_min_aula_lab") . ']',
            ),
            array(
                'field' => 'ore_min_tirocinio',
                'label' => 'Durata minima tirocinio in impresa (ore)',
                'rules' => 'required|is_natural|max_length[4]',
            ),
            array(
                'field' => 'perc_fad_aula_lab',
                'label' => 'Percentuale massima di FaD sulla durata minima di aula e laboratorio',
                'rules' => 'required|is_natural|less_than_equal_to[100]|max_length[3]',
            ),
            array(
                'field' => 'perc_fad_aula_lab_kc',
                'label' => 'Percentuale massima di FaD sulla durata delle attività rivolte alle KC',
                'rules' => 'is_natural|less_than_equal_to[100]|max_length[3]',
            ),
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {
            if ($this->input->post())
            {
                $id_standard_formativo = $this->input->post('id_standard_formativo');
                //$mode = $this->input->post('action');
                $data['standard_formativo'] = array(
                    'id_profilo' => $this->input->post("id_profilo"),
                    'des_standard_formativo' => $this->input->post("des_standard_formativo"),
                    'req_min_partecipanti' => $this->input->post("req_min_partecipanti"),
                    'req_min_didattici' => $this->input->post("req_min_didattici"),
                    'req_min_risorse' => $this->input->post("req_min_risorse"),
                    'req_min_valutazione' => $this->input->post("req_min_valutazione"),
                    'req_crediti_formativi' => $this->input->post("req_crediti_formativi"),
                    'altre_indicazioni' => $this->input->post("altre_indicazioni"),
                    'ore_min_durata_percorso' => $this->input->post("ore_min_durata_percorso"),
                    'ore_min_aula_lab' => $this->input->post("ore_min_aula_lab"),
                    'ore_min_aula_lab_kc' => $this->input->post("ore_min_aula_lab_kc"),
                    'ore_min_tirocinio' => $this->input->post("ore_min_tirocinio"),
                    'perc_fad_aula_lab' => $this->input->post("perc_fad_aula_lab"),
                    'perc_fad_aula_lab_kc' => $this->input->post("perc_fad_aula_lab_kc"),
                    'flg_uf_modulo' => $this->input->post("flg_uf_modulo")
                );

                if ($this->input->post("id_isced"))
                {
                    $data['standard_formativo_isced'] = $this->input->post("id_isced");
                }

                $this->load->model('standard_formativo_model');
                $ret = $this->standard_formativo_model->save_standard_formativo($data, $id_standard_formativo);
            }
            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di inserimento'
                );
            }
            else
            {
                $output = array(
                    'id_standard_formativo' => $ret,
                    'esito' => 'success',
                    'message' => 'Salvataggio effettuato '
                );
            }
            $this->_render_json($output);
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

    public function elimina_standard_formativo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_standard_formativo'))
        {
            $this->load->model('standard_formativo_model', 'st');
            $ret = $this->st->elimina_standard_formativo($this->input->post('id_standard_formativo'));

            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di cancellazione.'
                );
            }
            else
            {
                $output = array(
                    'esito' => 'success',
                    'message' => 'Operazione effettuata con successo '
                );
            }
            $this->_render_json($output);
        }
    }

    public function get_isced_sf_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_standard_formativo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_standard_formativo_isced($this->input->post("id_standard_formativo"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['id_isced'];
            }
            $this->_render_json($rows);
        }
    }

    public function get_datatables_uf_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_standard_formativo"))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $output = $this->sf->datatables_unita_formativa($this->input->post("id_standard_formativo"));
            $this->_render_text($output);
        }
    }
    
    public function get_datatables_moduli_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_standard_formativo"))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $output = $this->sf->datatables_moduli($this->input->post("id_standard_formativo"));
            $this->_render_text($output);
        }
    }

    public function valida_durata($ore_min_durata_percorso)
    {
        //DURATA TOTALE = DURATA AULA E LAB + DURATA TIROCINIO
        if ($ore_min_durata_percorso - ((int) $this->input->post('ore_min_aula_lab') + (int) $this->input->post('ore_min_tirocinio')) == 0)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('valida_durata', 'La durata minima complessiva deve corrispondere alla somma delle ore di aula/laboratorio e tirocinio');
            return FALSE;
        }
    }

    public function get_indicatori_durata_sf($id_standard_formativo = 0)
    {
        if ($this->input->is_ajax_request())
        {
            $id_standard_formativo = $this->input->post('id_standard_formativo');
        }
        $this->load->model('standard_formativo_model', 'sf');
        $output = $this->sf->list_indicatori_durata_sf($id_standard_formativo);
        $this->_render_json($output);
    }

    public function get_stato_sf_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo') && $this->input->post('id_standard_formativo'))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $output = $this->sf->select_stato_sf($this->input->post('id_profilo'), $this->input->post('id_standard_formativo'));
            $output['data_ultima_modifica'] = convertsDataOraInItalianFormat($output['data_ultima_modifica']);
            $this->_render_json($output);
        }
    }

    /*
     * AJAX TABELLA    
     */

    public function get_datatables_st_formativo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('standard_formativo_model', 'sf');
        $output = $this->sf->datatables_st_formativo();
        $this->_render_text($output);
    }

    /*
     * CRUD AJAX MODULI
     */

    public function save_modulo_json()
    {
        $FormRules = array(
            array(
                'field' => 'id_modulo',
                'label' => 'Codice Modulo',
                'rules' => 'trim'
            ),
            array(
                'field' => 'titolo_modulo',
                'label' => 'Denominazione modulo',
                'rules' => 'trim|required|max_length[255]'
            ),
            array(
                'field' => 'des_contenuti',
                'label' => 'Conoscenze/contenuti',
                'rules' => 'trim|required|max_length[4000]'
            ),
            array(
                'field' => 'ore_min_durata_mod',
                'label' => 'Durata minima (ore)',
                'rules' => 'required|is_natural_no_zero|max_length[4]',
            ),
            array(
                'field' => 'perc_fad_mod',
                'label' => 'Percentuale massima di FaD',
                'rules' => 'required|is_natural|less_than_equal_to[100]|max_length[3]',
            ),
            array(
                'field' => 'sequenza',
                'label' => 'Sequenza ordinamento',
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[100]|max_length[3]',
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {
            /*
             * VERIFICA
             * Il numero di ore in FaD di un singolo MODULO non può superare 
             * il numero di ore in FaD definite a livello di standard formativo
             */
            $ore_fad_sf = floatval($this->input->post('durata_fad_sf'));
            $ore_mod = intval($this->input->post('ore_min_durata_mod'));
            $perc_fad_mod = intval($this->input->post('perc_fad_mod'));
            $ore_fad_mod = $ore_mod * ($perc_fad_mod / 100);

            $errore = ($ore_fad_mod > $ore_fad_sf);

            if (!$errore)
            {
                $id_modulo = $this->input->post("id_modulo");
                $data = $this->input->post();
                //E' passato volutamente dal form per controllo ma non è presente in tabella, lasciandolo va in errore;
                unset($data['durata_fad_sf']);
                $this->load->model('standard_formativo_model', 'sf');
                $ret = $this->sf->save_modulo($data, $id_modulo);
                if ($ret === FALSE)
                {
                    $output = array(
                        'esito' => 'error',
                        'message' => 'Si sono verificati degli errori in fase di inserimento'
                    );
                }
                else
                {
                    $output = array(
                        'esito' => 'success',
                        'message' => 'Salvataggio effettuato '
                    );
                }
                $this->_render_json($output);
            }
            else
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Il numero di ore in FaD di un singolo MODULO (in questo caso ' . $ore_fad_mod . ' ore) è superiore al numero di ore in FaD complessive (al netto delle KC) definite a livello di standard formativo (' . $ore_fad_sf . ' ore)'
                );
                $this->_render_json($output);
            }            
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

    public function elimina_modulo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }

        if ($this->input->post('id_modulo') && $this->input->post('id_profilo'))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $ret = $this->sf->elimina_modulo($this->input->post('id_modulo'), $this->input->post('id_profilo'));

            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di cancellazione.'
                );
            }
            else
            {
                $output = array(
                    'esito' => 'success',
                    'message' => 'Operazione effettuata con successo '
                );
            }
            $this->_render_json($output);
        }
    }

    public function leggi_modulo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_modulo'))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $output = $this->sf->get_modulo($this->input->post('id_modulo'));
            $this->_render_json($output);
        }
    }

    /*
     * CRUD AJAX UNITA' FORMATIVE
     */

    public function save_uf_json()
    {
        $FormRules = array(
            array(
                'field' => 'id_unita_formativa',
                'label' => 'Codice Unità Formativa',
                'rules' => 'trim'
            ),            
            array(
                'field' => 'id_competenza',
                'label' => 'Unità di competenza correlata',
                'rules' => 'required',
            ),
            array(
                'field' => 'ore_min_durata_uf',
                'label' => 'Durata minima (ore)',
                'rules' => 'required|is_natural_no_zero|max_length[4]',
            ),
            array(
                'field' => 'perc_varianza',
                'label' => 'Percentuale variazione in aumento e/o diminuzione',
                'rules' => 'required|is_natural|less_than_equal_to[100]|max_length[3]',
            ),
            array(
                'field' => 'perc_fad_uf',
                'label' => 'Percentuale massima di FaD',
                'rules' => 'required|is_natural|less_than_equal_to[100]|max_length[3]',
            ),
            array(
                'field' => 'sequenza',
                'label' => 'Sequenza ordinamento',
                'rules' => 'required|is_natural_no_zero|less_than_equal_to[100]|max_length[3]',
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {
            /*
             * VERIFICA
             * Il numero di ore in FaD di una singola UF non può superare 
             * il numero di ore in FaD definite a livello di standard formativo
             */
            $ore_fad_sf = floatval($this->input->post('durata_fad_sf'));
            $ore_uf = intval($this->input->post('ore_min_durata_uf'));
            $perc_fad_uf = intval($this->input->post('perc_fad_uf'));
            $ore_fad_uf = $ore_uf * ($perc_fad_uf / 100);

            $errore = ($ore_fad_uf > $ore_fad_sf);

            if (!$errore)
            {
                $id_unita_formativa = $this->input->post("id_unita_formativa");
                $data = $this->input->post();
                /*
                 * E' passato volutamente dal form per controllo 
                 * ma non è presente in tabella, 
                 * lasciandolo va in errore;
                 */
                unset($data['durata_fad_sf']);
                $this->load->model('standard_formativo_model', 'sf');
                $ret = $this->sf->save_unita_formativa($data, $id_unita_formativa);
                if ($ret === FALSE)
                {
                    $output = array(
                        'esito' => 'error',
                        'message' => 'Si sono verificati degli errori in fase di inserimento'
                    );
                }
                else
                {
                    $output = array(
                        'esito' => 'success',
                        'message' => 'Salvataggio effettuato '
                    );
                }
                $this->_render_json($output);
            }
            else
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Il numero di ore in FaD di una singola UF (in questo caso ' . $ore_fad_uf . ' ore) è superiore al numero di ore in FaD complessive (al netto delle KC) definite a livello di standard formativo (' . $ore_fad_sf . ' ore)'
                );
                $this->_render_json($output);
            }
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

    public function elimina_uf_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }

        if ($this->input->post('id_unita_formativa') && $this->input->post('id_profilo'))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $ret = $this->sf->elimina_unita_formativa($this->input->post('id_unita_formativa'), $this->input->post('id_profilo'));

            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di cancellazione.'
                );
            }
            else
            {
                $output = array(
                    'esito' => 'success',
                    'message' => 'Operazione effettuata con successo '
                );
            }
            $this->_render_json($output);
        }
    }

    public function leggi_uf_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_unita_formativa'))
        {
            $this->load->model('standard_formativo_model', 'sf');
            $output = $this->sf->get_unita_formativa($this->input->post('id_unita_formativa'));
            $this->_render_json($output);
        }
    }

    public function list_profilo_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_profilo_competenza($this->input->post('id_profilo'));
        }
        $this->_render_json($output);
    }

}
