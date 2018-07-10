<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');
        $this->load->css('assets/plugins/morrisjs/morris.css');


        $this->load->js('assets/plugins/raphael/raphael-min.js');
        $this->load->js('assets/plugins/morrisjs/morris.min.js');
        // Inserisci il menu' in una sezione a parte e gestiscilo con section
        //$data["ultima_briciola"] = "Puoi inserire la sezione menu";
        //$this->load->section('briciole', 'section/briciole', $data);
    }

    public function index()
    {
        $resp_usr = $this->config->item('role_responsabile');
        if ($this->ion_auth->is_admin() || $this->ion_auth->in_group($resp_usr))
        {


            $this->output->set_title("Dashboard");

            $this->load->model("dashboard_model", "dash");

            $this->data = $this->dash->indicatori_totali();
            $this->data['ultimi_export'] = $this->dash->lista_ultimi_export();
            $this->data['indicatori_stato'] = $this->dash->indicatori_stato();
            //$this->load->view('welcome_message');
            $this->load->view('dashboard', $this->data);
        } else {
            redirect('admin/qualificazione', 'refresh');
        }
    }

}
