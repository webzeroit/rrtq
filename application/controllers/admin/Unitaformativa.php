<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UnitaFormativa extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');
       
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function index()
    {
        $this->output->set_title("Elenco delle Unità Formative");
        $this->load->view('unitaformativa/lista');
    }
 

    public function export_xls()
    {

        $this->load->model('standard_formativo_model', 'sf');
        $dataFile = $this->sf->lista_unita_formativa_export();
        $headerFile = ['ID QP', 'ID SF', 'ID UC','Denominazione Standard Formativo','Titolo Unità Formativa','Durata min. ore','Perc. Variazione +/-','Perc. Max. Fad']; 

        $file_export_name = "export_UF_" . date("d_m_Y") . ".xlsx";
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()
                ->setCreator("Regione Campania")
                ->setLastModifiedBy("Regione Campania")
                ->setTitle("Esportazione file ATLANTE");

        //SETTAGGI
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        
        $spreadsheet->setActiveSheetIndex(0)->fromArray($headerFile);
        $spreadsheet->setActiveSheetIndex(0)->fromArray($dataFile, NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('Export UF');

        $this->output->unset_template();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_export_name . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    /*
     * AJAX CALLS FOR index
     */

    public function get_datatables_lista_uf_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('standard_formativo_model', 'sf');
        $output = $this->sf->datatables_lista_unita_formativa();
        $this->_render_text($output);
    }

}
