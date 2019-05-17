<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Archivio_pubblicazioni_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function select_storico_serialized($id_pubblicazione)
    {
        $this->db->select('file_qualificazione');
        $this->db->from('rrtq_archivio_pubblicazioni');
        $this->db->where('id_pubblicazione', $id_pubblicazione);
        $query = $this->db->get();
        $data = $query->row_array();
        return unserialize($data['file_qualificazione']);
    }

    public function datatables_archivio_pubblicazioni()
    {
        $this->load->library('datatables');

        $this->datatables
                ->select('id_pubblicazione, rrtq_profilo.id_profilo, id_sep, titolo_profilo, DATE_FORMAT(data_pubblicazione,"%d/%m/%Y %H:%i") as data_pubblicazione')
                ->from('rrtq_archivio_pubblicazioni')
                ->join('rrtq_profilo', 'rrtq_archivio_pubblicazioni.id_profilo = rrtq_profilo.id_profilo');

        $action_link = '<a href="' . base_url() . 'admin/archiviopubblicazioni/genera_sp/$1" target="_blank" data-toggle="tooltip" data-original-title="PDF Qualificazione"><i class="fa fa-file-pdf-o text-blue m-r-10"></i></a>';        
        $action_link .= '<a href="' . base_url() . 'admin/archiviopubblicazioni/genera_sf/$1" target="_blank" data-toggle="tooltip" data-original-title="PDF Standard Formativo"><i class="fa fa-file-pdf-o text-warning m-r-5"></i></a>';        

        $this->datatables->add_column('azione', $action_link, 'id_pubblicazione');

        return $this->datatables->generate();
    }

}
