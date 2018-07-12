<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qualificazione extends MY_Controller_Admin
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
        // Inserisci il menu' in una sezione a parte e gestiscilo con section
        //$data["ultima_briciola"] = "Puoi inserire la sezione menu";
        //$this->load->section('briciole', 'section/briciole', $data);
    }

    public function index()
    {
        $this->output->set_title("Elenco delle qualificazioni");
        $this->load->view('qualificazione/lista');
    }

    public function gestione($id_profilo = NULL)
    {
        $this->output->set_title("Gestione qualificazione");
        $this->load->model('sep_model');
        $this->load->model('ada_model');
        $this->load->model('ateco_model');
        $this->load->model('cp2011_model');
        $this->load->model('profilo_model');
        $this->load->model('qualificazione_model');

        $data = array(
            'list_sep' => $this->sep_model->list_sep(),
            'list_ateco' => $this->ateco_model->list_ateco(),
            'list_cp2011' => $this->cp2011_model->list_cp2011(),
            'list_stato_profilo' => $this->profilo_model->list_stato_profilo(),
            'id_profilo' => $id_profilo
        );

        if ($id_profilo === NULL)
        {
            $data['action'] = "add";
            $data['profilo'] = NULL;
        }
        else
        {
            $profilo = $this->qualificazione_model->select_profilo($id_profilo);
            if ($profilo === NULL)
            {
                redirect('admin/qualificazione', 'refresh');
            }
            $data['action'] = "edit";
            $data['profilo'] = $profilo;
            $data['list_ada'] = $this->ada_model->list_ada('id_sep in (25,' . $profilo['id_sep'] . ')');
            //$data['list_ada'] = $this->ada_model->list_ada(array('id_sep' => $profilo['id_sep']));
        }
        $this->load->view('qualificazione/gestione', $data);
    }

    public function difftool($id_profilo = NULL)
    {
        if ($id_profilo !== NULL)
        {
            $this->output->unset_template();
            $this->load->model('qualificazione_model');
            $prima = $this->qualificazione_model->select_qualificazione_html($id_profilo, 0);
            if (!isset($prima))
            {
                echo "<h1>Nessuna versione precedente disponibile al confronto</h1>";
            }
            else
            {
                $dopo = $this->qualificazione_model->select_qualificazione_html($id_profilo, 1);
                $htmlDiff = new Caxy\HtmlDiff\HtmlDiff($prima, $dopo);
                $htmlDiff->getConfig()
                        ->setPurifierCacheLocation('application/cache/purifier/')
                        ->setInsertSpaceInReplace(true)
                        ->setGroupDiffs(true)
                        ->setUseTableDiffing(true);

                $content_extra = "
            <style> 
                ins {color: #333333;background-color: #41ff32; text-decoration: none;}
                del {color: #AA3333;background-color: #ffeaea;text-decoration: line-through;}
            </style>
            <center><i>Diff-Check effettuato il " . date('d/m/Y H:i') . "<i></center><br><br>";
                $content = $htmlDiff->build();
                echo $content_extra . $content;
            }
        }
    }

    /*
     * AJAX CALLS
     */

    public function save_profilo()
    {
        $FormRules = array(
            array(
                'field' => 'id_sep',
                'label' => 'Settore Economico Professionale',
                'rules' => 'required',
            ),
            array(
                'field' => 'titolo_profilo',
                'label' => 'Titolo qualificazione',
                'rules' => 'required|max_length[255]',
            ),
            array(
                'field' => 'id_ada[]',
                'label' => 'A.D.A.',
                'rules' => 'required',
            ),
            array(
                'field' => 'descrizione_profilo',
                'label' => 'Descrizione qualificazione',
                'rules' => 'required|max_length[4000]',
            ),
            array(
                'field' => 'livello_eqf',
                'label' => 'Livello EQF qualificazione',
                'rules' => 'required|less_than_equal_to[8]',
            ),
            array(
                'field' => 'codice_ateco[]',
                'label' => 'Referenziazioni Ateco 2007',
                'rules' => 'required',
            ),
            array(
                'field' => 'codice_cp2011[]',
                'label' => 'Referenziazioni CP 2011',
                'rules' => 'required',
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {

            if ($this->input->post())
            {
                $id_profilo = $this->input->post('id_profilo');
                $mode = $this->input->post('action');
                $data['profilo'] = array(
                    'id_sep' => $this->input->post("id_sep"),
                    'titolo_profilo' => $this->input->post("titolo_profilo"),
                    'descrizione_profilo' => $this->input->post("descrizione_profilo"),
                    'livello_eqf' => $this->input->post("livello_eqf"),
                    'flg_regolamentato' => $this->input->post("flg_regolamentato")
                );
                $data['profilo_ada'] = $this->input->post("id_ada");
                $data['profilo_ateco'] = $this->input->post("codice_ateco");
                $data['profilo_cp2011'] = $this->input->post("codice_cp2011");

                $this->load->model('profilo_model');
                $ret = $this->profilo_model->save_profilo($data, $id_profilo);
            }


            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'errori in inserimento'
                );
            }
            else
            {
                $output = array(
                    'id_profilo' => $ret,
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

    public function get_datatables_profili_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('profilo_model');
        $output = $this->profilo_model->datatables_profili();
        $this->_render_text($output);
    }

    public function get_datatables_profilo_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_profilo"))
        {
            $this->load->model('profilo_model');
            $output = $this->profilo_model->datatables_profilo_competenze($this->input->post("id_profilo"));
            $this->_render_text($output);
        }
    }

    public function get_ada_profilo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_profilo_ada($this->input->post("id_profilo"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['id_ada'];
            }
            $this->_render_json($rows);
        }
    }

    public function get_processo_profilo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_profilo_processo($this->input->post("id_profilo"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['codice_processo'] . ' - ' . $row['descrizione_processo'] . ' ';
            }
            $this->_render_json($rows);
        }
    }

    public function get_sequenza_processo_profilo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_profilo_seq_processo($this->input->post("id_profilo"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['codice_sequenza'] . ' - ' . $row['descrizione_sequenza'];
            }
            $this->_render_json($rows);
        }
    }

    public function get_ateco_profilo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_profilo_ateco2007($this->input->post("id_profilo"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['codice_ateco'];
            }
            $this->_render_json($rows);
        }
    }

    public function get_cp2011_profilo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_profilo_cp2011($this->input->post("id_profilo"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['codice_cp2011'];
            }
            $this->_render_json($rows);
        }
    }

    public function get_ada_sep_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('id_sep'))
        {
            $this->load->model('ada_model');
            //$output = $this->ada_model->list_ada(array('id_sep' => $this->input->post('id_sep')));
            $output = $this->ada_model->list_ada('id_sep in (25,' . $this->input->post('id_sep') . ')');
        }
        $this->_render_json($output);
    }

    public function get_stato_profilo_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('profilo_model');
            $output = $this->profilo_model->select_stato_profilo($this->input->post('id_profilo'));
            $output['data_ultima_modifica'] = convertsDataOraInItalianFormat($output['data_ultima_modifica']);
            $this->_render_json($output);
        }
    }

    /* GESTIONE UC AJAX */

    public function list_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('competenza_model');
        $output = $this->competenza_model->list_competenza();
        $this->_render_json($output);
    }

    public function list_competenza_abilita_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('id_competenza'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_competenza_abilita($this->input->post('id_competenza'));
        }
        $this->_render_json($output);
    }

    public function list_competenza_conoscenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('id_competenza'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_competenza_conoscenza($this->input->post('id_competenza'));
        }
        $this->_render_json($output);
    }

    public function save_associazione_competenza()
    {
        $FormRules = array(
            array(
                'field' => 'id_competenza',
                'label' => 'Unità di Competenza',
                'rules' => 'required',
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {
            if ($this->input->post())
            {
                $id_profilo = $this->input->post('id_profilo');
                $id_competenza = $this->input->post('id_competenza');
                $mode = $this->input->post('action_competenza');
                $data = array(
                    'id_profilo' => $id_profilo,
                    'id_competenza' => $id_competenza
                );
                $this->load->model('profilo_model');
                $ret = $this->profilo_model->save_associazione_competenza($data, $mode);
                if ($ret === FALSE)
                {
                    $output = array(
                        'esito' => 'error',
                        'message' => 'errori in inserimento'
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

    public function edita_pubblicazione_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $this->load->model('profilo_model');
            $mode = $this->input->post('action');
            $ret = FALSE;
            if ($mode === "start")
            {
                $ret = $this->profilo_model->avvia_pubblicazione($this->input->post('id_profilo'));
            }
            if ($mode === "stop")
            {
                $ret = $this->profilo_model->sospendi_pubblicazione($this->input->post('id_profilo'));
            }
            if ($mode === "delete")
            {
                $ret = $this->profilo_model->elimina_pubblicazione($this->input->post('id_profilo'));
            }
            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Si sono verificati degli errori in fase di aggiornamento.'
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

    public function elimina_qualificazione_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            $output = array(
                'esito' => 'error',
                'message' => 'Non hai i privilegi per effettuare questa operazione.'
            );
            $this->_render_json($output); // redirect them to the home page because they must be an administrator to view this
        }
        else
        {
            if ($this->input->post('id_profilo'))
            {
                $this->load->model('qualificazione_model');
                $ret = $this->qualificazione_model->elimina_qualificazione($this->input->post('id_profilo'));

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
    }

}
