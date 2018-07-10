<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tabelle extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function sep()
    {
        $this->output->set_title("Elenco S.E.P.");
        $this->load->view('tabelle/sep');
    }

    public function processo()
    {
        $this->output->set_title("Elenco Processi");
        $this->load->view('tabelle/processo');
    }

    public function ada()
    {
        $this->output->set_title("Elenco A.D.A.");
        $this->load->view('tabelle/ada');
    }

    public function sequenza_processo()
    {
        $this->output->set_title("Elenco Sequenze di Processo");
        $this->load->view('tabelle/sequenza_processo');
    }

    public function ateco_2007()
    {
        $this->output->set_title("Codici Ateco 2007");
        $this->load->view('tabelle/ateco2007');
    }

    public function cp_2011()
    {
        $this->output->set_title("Codici Professioni ISTAT 2011");
        $this->load->view('tabelle/cp2011');
    }

    /*
     * AJAX CALLS FOR TABLE
     */

    public function get_datatables_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("table"))
        {
            $tabella = $this->input->post("table");
            switch ($tabella)
            {
                case "sep":
                    $this->load->model('sep_model');
                    $output = $this->sep_model->datatables_sep();
                    $this->_render_text($output);
                    break;
                case "ada":
                    $this->load->model('ada_model');
                    $output = $this->ada_model->datatables_ada();
                    $this->_render_text($output);
                    break;
                case "processo":
                    $this->load->model('processo_model');
                    $output = $this->processo_model->datatables_processo();
                    $this->_render_text($output);
                    break;
                case "sequenza_processo":
                    $this->load->model('sequenza_processo_model');
                    $output = $this->sequenza_processo_model->datatables_sequenza_processo();
                    $this->_render_text($output);
                    break;
                case "ateco":
                    $this->load->model('ateco_model');
                    $output = $this->ateco_model->datatables_ateco();
                    $this->_render_text($output);
                    break;
                case "cp2011":
                    $this->load->model('cp2011_model');
                    $output = $this->cp2011_model->datatables_cp2011();
                    $this->_render_text($output);
                    break;
            }
        }
    }

    public function export_xls($tabella)
    {

        switch ($tabella)
        {
            case "sep":
                $this->load->model('sep_model');
                $output = $this->sep_model->datatables_sep();
                $headerFile = ['ID', 'Codice', 'Descrizione']; 
                break;
            case "ada":
                $this->load->model('ada_model');
                $output = $this->ada_model->datatables_ada();
                $headerFile = ['ID', 'S.E.P.', 'Codice', 'Descrizione'];                
                break;
            case "processo":
                $this->load->model('processo_model');
                $output = $this->processo_model->datatables_processo();
                $headerFile = ['ID', 'S.E.P.', 'Codice', 'Descrizione'];                
                break;
            case "sequenza_processo":
                $this->load->model('sequenza_processo_model');
                $output = $this->sequenza_processo_model->datatables_sequenza_processo();
                $headerFile = ['ID', 'S.E.P.', 'Codice', 'Descrizione'];  
                break;
            case "ateco":
                $this->load->model('ateco_model');
                $output = $this->ateco_model->datatables_ateco();
                $headerFile = ['Codice', 'Descrizione']; 
                break;
            case "cp2011":
                $this->load->model('cp2011_model');
                $output = $this->cp2011_model->datatables_cp2011();
                $headerFile = ['Codice', 'Descrizione']; 
                break;
            default:
                show_404();
                break;
        }


        $file_export_name = "export_" . $tabella . "_" . date("d_m_Y") . ".xlsx";
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()
                ->setCreator("Regione Campania")
                ->setLastModifiedBy("Regione Campania")
                ->setTitle("Esportazione file ATLANTE");

        //SETTAGGI
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);

        $dataFile = json_decode($output,TRUE);      

        $spreadsheet->setActiveSheetIndex(0)->fromArray($headerFile);
        $spreadsheet->setActiveSheetIndex(0)->fromArray($dataFile['data'], NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('Export ' . $tabella);

        $this->output->unset_template();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_export_name . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}
