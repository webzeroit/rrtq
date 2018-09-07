<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ricerca extends MY_Controller_Public
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->output->set_template('public');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function index()
    {
        
        $this->output->set_title("Repertorio Regionale Qualificazioni");

        $this->load->model('sep_model');
        $data = array(
            'list_sep' => $this->sep_model->list_sep()
        );

        $this->load->view('public/ricerca', $data);
    }

    public function get_datatables_profili_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->library('datatables');
        
        
        $this->datatables
                ->select('id_profilo,id_sep,titolo_profilo,livello_eqf')
                ->from('rrtq_profilo')
                ->where('id_stato_profilo <', 3)
                ->where('data_ultima_pubblicazione !=', NULL);
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
        if ($this->input->post("titolo_profilo"))
        {
            $this->datatables->like('titolo_profilo', $this->input->post("titolo_profilo"));
        }           

        $action_link = '<a href="' . base_url() . 'public/scheda/$1" data-toggle="tooltip" data-original-title="Apri Scheda"> <i class="fa fa fa-id-card-o text-inverse m-r-5"></i> </a>';
        //$action_link .= '<a href="' . base_url() . 'public/stampa/sp/$1" target="_blank" data-toggle="tooltip" data-original-title="PDF Qualificazione"><i class="fa fa-file-pdf-o text-inverse m-r-5"></i></a>';

        $this->datatables->add_column('azione', $action_link, 'id_profilo');


        $output = $this->datatables->generate();


        $this->_render_text($output);
    }

}
