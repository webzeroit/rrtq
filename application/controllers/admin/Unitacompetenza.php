<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UnitaCompetenza extends MY_Controller_Admin
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
        $this->output->set_title("Elenco delle Unità di Competenza");
        $this->load->view('unitacompetenza/lista');
    }

    public function gestione($id_competenza = NULL)
    {
        $this->output->set_title("Gestione Unità di Competenza");
        $this->load->model('competenza_model');
        $this->load->model('qualificazione_model');
        $this->load->model('cp2011_model');

        if ($id_competenza === NULL)
        {
            $data = array(
                'action' => "add",
                'competenza' => NULL,
                'id_competenza' => $id_competenza,
                'list_abilita' => NULL,
                'list_conoscenza' => NULL
            );
        }
        else
        {
            $competenza = $this->competenza_model->get_competenza($id_competenza);
            if ($competenza === NULL)
            {
                redirect('admin/unitacompetenza', 'refresh');
            }
            $data = array(
                'action' => "edit",
                'list_abilita' => $this->qualificazione_model->list_competenza_abilita($id_competenza),
                'list_conoscenza' => $this->qualificazione_model->list_competenza_conoscenza($id_competenza),
                'competenza' => $competenza,
                'id_competenza' => $id_competenza
            );
        }
        $data['list_cp2011'] = $this->cp2011_model->list_cp2011();
        $this->load->view('unitacompetenza/gestione', $data);
    }

    /*
     * AJAX CALLS FOR index
     */

    public function get_datatables_unitacompetenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('competenza_model');
        $output = $this->competenza_model->datatables_competenza();
        $this->_render_text($output);
    }

    /*
     * AJAX CALLS FOR gestione
     */

    public function save_competenza()
    {
        $FormRules = array(
            array(
                'field' => 'titolo_competenza',
                'label' => 'Titolo Competenza',
                'rules' => 'required|max_length[500]'
            ),           
            array(
                'field' => 'risultato_competenza',
                'label' => 'Risultato Atteso',
                'rules' => 'required|max_length[4000]'
            ),
            array(
                'field' => 'oggetto_di_osservazione',
                'label' => 'Oggetto di Osservazione',
                'rules' => 'required|max_length[4000]'
            ),
            array(
                'field' => 'indicatori',
                'label' => 'Indicatori',
                'rules' => 'required|max_length[4000]'
            ),
            array(
                'field' => 'livello_eqf',
                'label' => 'Livello EQF competenza',
                'rules' => 'required|less_than_equal_to[8]',
            ),
            array(
                'field' => 'id_abilita[]',
                'label' => 'Lista delle abilità',
                'rules' => 'required',
            ),
            array(
                'field' => 'id_conoscenza[]',
                'label' => 'Lista delle conoscenze',
                'rules' => 'required',
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {

            if ($this->input->post())
            {
                $id_competenza = $this->input->post('id_competenza');
                $mode = $this->input->post('action');
                $data['competenza'] = array(
                    'titolo_competenza' => $this->input->post("titolo_competenza"),
                    'descrizione_competenza' => $this->input->post("titolo_competenza"),
                    'risultato_competenza' => $this->input->post("risultato_competenza"),
                    'oggetto_di_osservazione' => $this->input->post("oggetto_di_osservazione"),
                    'indicatori' => $this->input->post("indicatori"),
                    'livello_eqf' => $this->input->post("livello_eqf")
                );
                $data['competenza_abilita'] = $this->input->post("id_abilita");
                $data['competenza_conoscenza'] = $this->input->post("id_conoscenza");
                $data['competenza_cp2011'] = $this->input->post("codice_cp2011");

                $this->load->model('competenza_model');
                $ret = $this->competenza_model->save_competenza($data, $id_competenza);
            }


            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Errori in inserimento'
                );
            }
            else
            {
                $output = array(
                    'id_competenza' => $ret,
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

    public function get_datatables_competenza_profili_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_competenza"))
        {
            $this->load->model('competenza_model');
            $output = $this->competenza_model->datatables_competenza_profili($this->input->post("id_competenza"));
            $this->_render_text($output);
        }
    }

    public function search_abilita_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('search'))
        {
            $this->load->model('abilita_model');
            $output = $this->abilita_model->search_abilita($this->input->post('search'));
        }
        $this->_render_json($output);
    }

    public function search_conoscenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('search'))
        {
            $this->load->model('conoscenza_model');
            $output = $this->conoscenza_model->search_conoscenza($this->input->post('search'));
        }
        $this->_render_json($output);
    }

    public function elimina_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->ion_auth->is_admin() || 
            $this->ion_auth->in_group($this->config->item('role_responsabile')) ||
            $this->ion_auth->in_group($this->config->item('role_supervisore'))
        )
        {
            if ($this->input->post('id_competenza'))
            {
                $this->load->model('competenza_model');
                $ret = $this->competenza_model->elimina_competenza($this->input->post('id_competenza'));

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
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => 'Non hai i privilegi per effettuare questa operazione.'
            );
            $this->_render_json($output); // redirect them to the home page because they must be an administrator to view this
        }
    }

    public function get_cp2011_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_competenza'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_competenza_cp2011($this->input->post("id_competenza"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['codice_cp2011'];
            }
            $this->_render_json($rows);
        }
    }

}
