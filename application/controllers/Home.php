<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        /* CodeIgniter non supporta il Routing in sotto-directory ed utilizzo il Redirect */
        redirect('public/ricerca', 'refresh');
    }
    
}
