<?php

class MY_Model extends CI_Model {

    
    public function __construct()
    {
        $this->load->model("Activity_log_model", "activity");
        parent::__construct();
    }

}
