<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityLog extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('auth');
        $this->output->set_template('admin');
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    /**
     *  List Activity     
     */
    public function index()
    {
        if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('Non hai i privilegi per visualizzare questa pagina.');
        }
        $this->output->set_title("Log Attività Utenti");
        $this->load->view('auth/activity_log');
    }

    public function export_xls()
    {
        $this->load->model('Activity_log_model', 'activity');
        
        $output = $this->activity->datatables_log();
        $headerFile = ['ID', 'UserID', 'Data Evento', 'Evento', 'Descrizione', 'Indirizzo IP'];

        $file_export_name = "export_activity_" . date("d_m_Y") . ".xlsx";
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()
                ->setCreator("Regione Campania")
                ->setLastModifiedBy("Regione Campania")
                ->setTitle("Esportazione Log Attivita");

        //SETTAGGI
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);

        $dataFile = json_decode($output, TRUE);

        $spreadsheet->setActiveSheetIndex(0)->fromArray($headerFile);
        $spreadsheet->setActiveSheetIndex(0)->fromArray($dataFile['data'], NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('Export_Log ');

        $this->output->unset_template();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_export_name . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function delete_log()
    {

        
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }  
        $this->load->model('Activity_log_model', 'activity');
        $ret = $this->activity->delete_logs();
        
        if ($ret === FALSE)
        {
            $output = array(
                'esito' => 'error',
                'message' => 'Errore nella cancellazione del Log'
            );
        }
        else
        {
            $output = array(
                'esito' => 'success',
                'message' => 'Operazione effettuata '
            );
        }  
        $this->_render_json($output);
    }


    public function get_datatables_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('Activity_log_model', 'activity');
        $output = $this->activity->datatables_log();
        $this->_render_text($output);
    }
}
