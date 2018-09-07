<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Scheda extends MY_Controller_Public
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->output->set_template('public');
    }

    public function index($id)
    {
        if ($id != NULL)
        {
            $this->output->set_title("Scheda di dettaglio");
            $this->load->model('qualificazione_model', 'repertorio');
            $profilo_live = $this->repertorio->select_profilo($id);
            if ($profilo_live === NULL)
            {
                show_404();
            }
            $stato_profilo = (int) $profilo_live['id_stato_profilo'];
            if ($stato_profilo === 0)
            {
                $data = $this->repertorio->select_qualificazione($id);
            }
            else if ($stato_profilo < 3)
            {
                $data = unserialize($profilo_live['file_qualificazione']);
            } 
            else 
            {
                //NON PUBBLICATO o CANCELLATO
                show_404();
            }
        }
        else
        {
            show_404();
        }

        $this->load->view('public/scheda', $data);
    }

}
