<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();    
        $this->output->set_template('admin');
        $this->load->model("dashboard_model", "dash");

        $this->load->css('assets/plugins/morrisjs/morris.css');

        $this->load->js('assets/plugins/raphael/raphael-min.js');
        $this->load->js('assets/plugins/morrisjs/morris.min.js');
    }
    
    public function index()
    {
        if ($this->ion_auth->is_admin() ||
                $this->ion_auth->in_group($this->config->item('role_responsabile')) ||
                $this->ion_auth->in_group($this->config->item('role_supervisore'))
        )
        {
            $this->output->set_title("Dashboard");

            $this->data = $this->dash->indicatori_totali();
            $this->data['indicatori_stato'] = $this->dash->indicatori_stato();
            $this->data['ultime_modifiche_sp'] = $this->dash->lista_ultimi_profili_mod(10);
            $this->data['ultime_modifiche_sf'] = $this->dash->lista_ultimi_sf_mod(10);
            $this->data['ultimi_export'] = $this->dash->lista_ultimi_export(10);
            $this->load->view('dashboard', $this->data);
        }
        else
        {
            redirect('admin/qualificazione', 'refresh');
        }
    }
    
    public function export_xls($tabella)
    {
        switch ($tabella)
        {
            case "qual":
                $output = $this->dash->lista_ultimi_profili_mod();
                $headerFile = ['ID', 'S.E.P.', 'Qualificazione','Data Ultima Modifica','Codice Stato', 'Stato']; 
                break;
            case "stfor":
                $output = $this->dash->lista_ultimi_sf_mod();
                $headerFile = ['ID', 'S.E.P.', 'Denominazione standard formativo', 'Data Ultima Modifica','Codice Stato', 'Stato'];                
                break;
            case "inapp":
                $this->load->model('processo_model');
                $output = $this->dash->lista_ultimi_export();
                $headerFile = ['ID', 'S.E.P.','Qualificazione','Data Ultimo Export'];                
                break;
            default:
                show_404();
                break;
        }


        $file_export_name = "export_" . $tabella . "_" . date("d_m_Y") . ".xlsx";
        $locale = 'it';
        $validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
        if (!$validLocale) {
            echo 'Unable to set locale to '.$locale." - reverting to en_us<br />\n";
        }        
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()
                ->setCreator("Regione Campania")
                ->setLastModifiedBy("Regione Campania")
                ->setTitle("Esportazione file ATLANTE");

        //SETTAGGI
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
    

        $spreadsheet->setActiveSheetIndex(0)->fromArray($headerFile);
        $spreadsheet->setActiveSheetIndex(0)->fromArray($output, NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('Export_mod_' . $tabella);
        $spreadsheet->getActiveSheet()->getStyle('D1:D1000')
                ->getNumberFormat()
                ->setFormatCode('dd/mm/yyyy hh:mm:ss');
        $this->output->unset_template();
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_export_name . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
    }
    
    
}

