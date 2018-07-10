<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Abilita extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function index()
    {
        $this->output->set_title("Elenco delle Abilità");
        $this->load->view('abilita/lista');
    }

    public function gestione($id_abilita = NULL)
    {
        $this->output->set_title("Gestione Abilità");
        $this->load->model('abilita_model');        

        if ($id_abilita === NULL)
        {
            $data = array(
                'action' => "add",
                'abilita' => NULL,
                'id_abilita' => $id_abilita
            );
        }
        else
        {
            $abilita = $this->abilita_model->get_abilita($id_abilita);
            if ($abilita === NULL)
            {
                redirect('admin/abilita', 'refresh');
            }
            $data = array(
                'action' => "edit",
                'abilita' => $abilita,
                'id_abilita' => $id_abilita
            );
        }
        $this->load->view('abilita/gestione', $data);
    }

    /*
     * AJAX CALLS FOR index
     */

    public function get_datatables_abilita_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('abilita_model');
        $output = $this->abilita_model->datatables_abilita();
        $this->_render_text($output);
    }

    /*
     * AJAX CALLS FOR gestione
     */

    public function save_abilita()
    {
        $FormRules = array(
            array(
                'field' => 'descrizione_abilita',
                'label' => 'Descrizione Abilità',
                'rules' => 'required|max_length[1000]'
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {

            if ($this->input->post())
            {
                $id_abilita = $this->input->post('id_abilita');
                $mode = $this->input->post('action');
                $data['abilita'] = array(
                    'descrizione_abilita' => $this->input->post("descrizione_abilita")
                );

                $this->load->model('abilita_model');
                $ret = $this->abilita_model->save_abilita($data, $id_abilita);
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

    public function get_datatables_competenze_abilita_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_abilita"))
        {
            $this->load->model('abilita_model');
            $output = $this->abilita_model->datatables_competenze_abilita($this->input->post("id_abilita"));
            $this->_render_text($output);
        }
    }

    public function elimina_abilita_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $resp_usr = $this->config->item('role_responsabile');
        if ($this->ion_auth->is_admin() || $this->ion_auth->in_group($resp_usr))
        {
            if ($this->input->post('id_abilita'))
            {
                $this->load->model('abilita_model');
                $ret = $this->abilita_model->elimina_abilita($this->input->post('id_abilita'));

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

}
