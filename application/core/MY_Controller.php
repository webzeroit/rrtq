<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller_Admin extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();       
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $this->load->library('messaggistica');
        $this->load->section('menu', 'section/menu');
    }
    
    public function _render_json($json)
    {
        if (is_resource($json))
        {
            throw new \RuntimeException('Impossibile convertire l\'oggetto in JSON.');
        }
        $this->output->unset_template();
        $this->output->enable_profiler(FALSE)
                ->set_content_type('application/json')
                ->set_output(json_encode($json));
    }

    public function _render_text($text, $typography = FALSE)
    {
        // Note that, for now anyway, we don't do any cleaning of the text
        // and leave that up to the client to take care of.
        // However, we can auto_typogrify the text if we're asked nicely.
        if ($typography === TRUE)
        {
            $this->load->helper('typography');
            $text = auto_typography($text);
        }
        $this->output->unset_template();
        $this->output->enable_profiler(FALSE)
                ->set_content_type('text/plain')
                ->set_output($text);
    }
    
    public function verifica_posta()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = $this->messaggistica->non_letti();
        $this->_render_json($output);
    }
    
    

}
