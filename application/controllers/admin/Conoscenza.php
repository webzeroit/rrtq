<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Conoscenza extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function index()
    {
        $this->output->set_title("Elenco delle Conoscenze");
        $this->load->view('conoscenza/lista');
    }

    public function gestione($id_conoscenza = NULL)
    {
        $this->output->set_title("Gestione Conoscenza");
        $this->load->model('conoscenza_model');        

        if ($id_conoscenza === NULL)
        {
            $data = array(
                'action' => "add",
                'conoscenza' => NULL,
                'id_conoscenza' => $id_conoscenza
            );
        }
        else
        {
            $conoscenza = $this->conoscenza_model->get_conoscenza($id_conoscenza);
            if ($conoscenza === NULL)
            {
                redirect('admin/conoscenza', 'refresh');
            }
            $data = array(
                'action' => "edit",
                'conoscenza' => $conoscenza,
                'id_conoscenza' => $id_conoscenza
            );
        }
        $this->load->view('conoscenza/gestione', $data);
    }

    /*
     * AJAX CALLS FOR index
     */

    public function get_datatables_conoscenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('conoscenza_model');
        $output = $this->conoscenza_model->datatables_conoscenza();
        $this->_render_text($output);
    }

    /*
     * AJAX CALLS FOR gestione
     */

    public function save_conoscenza()
    {
        $FormRules = array(
            array(
                'field' => 'descrizione_conoscenza',
                'label' => 'Descrizione Conoscenza',
                'rules' => 'required|max_length[1000]'
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {

            if ($this->input->post())
            {
                $id_conoscenza = $this->input->post('id_conoscenza');
                $mode = $this->input->post('action');
                $data['conoscenza'] = array(
                    'descrizione_conoscenza' => $this->input->post("descrizione_conoscenza")
                );

                $this->load->model('conoscenza_model');
                $ret = $this->conoscenza_model->save_conoscenza($data, $id_conoscenza);
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

    public function get_datatables_competenze_conoscenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_conoscenza"))
        {
            $this->load->model('conoscenza_model');
            $output = $this->conoscenza_model->datatables_competenze_conoscenza($this->input->post("id_conoscenza"));
            $this->_render_text($output);
        }
    }

    public function elimina_conoscenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $resp_usr = $this->config->item('role_responsabile');
        if ($this->ion_auth->is_admin() || $this->ion_auth->in_group($resp_usr))
        {
            if ($this->input->post('id_conoscenza'))
            {
                $this->load->model('conoscenza_model');
                $ret = $this->conoscenza_model->elimina_conoscenza($this->input->post('id_conoscenza'));

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
