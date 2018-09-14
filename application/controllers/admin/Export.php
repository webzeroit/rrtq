<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Export
 *
 * @author rlanz
 */
class Export extends MY_Controller_Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->output->set_template('admin');

        //CSS
        $this->load->css('assets/plugins/select2/dist/css/select2.min.css');
        //JS        
        $this->load->js('assets/plugins/select2/dist/js/select2.full.min.js');
        $this->load->js('assets/plugins/select2/dist/js/i18n/it.js');
    }

    public function index()
    {

        if ($this->input->post())
        {
            $this->form_validation->set_rules('id_profilo[]', 'Lista Qualificazioni', 'required');
            if ($this->form_validation->run() == TRUE)
            {
                $lista_id = $this->input->post("id_profilo");
                $this->genera_file_atlante($lista_id);
            }
            else
            {
                redirect('admin/export');
            }
        }
        else
        {
            $this->load->model('sep_model');
            $this->load->model('profilo_model');

            $profili_where = array('id_stato_profilo <' => 2);
            $data = array(
                'list_sep' => $this->sep_model->list_sep(),
                'list_profili' => $this->profilo_model->list_profili($profili_where)
            );
            $this->output->set_title("Interscambio dati ATLANTE");
            $this->load->view('export/atlante', $data);
        }
    }

    public function genera_file_atlante($ids)
    {
        $this->load->model("INAPP_model");
        $file_export_name = "CAMPANIA_import_" . date("d_m_Y") . ".xlsx";

        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet->getProperties()
                ->setCreator("Regione Campania")
                ->setLastModifiedBy("Regione Campania")
                ->setTitle("Esportazione file ATLANTE");

        //SETTAGGI
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);

        //FOGLIO profili        
        $headerProfili = ['id_profilo', 'titolo', 'descrizione', 'liv EQF', 'Settore', 'ADA 1', 'ADA 2', 'ADA 3', 'ADA 4', 'ADA 5', 'ADA 6', 'ADA 7', 'ADA 8'];

        $dataProfili = $this->INAPP_model->select_profili_export($ids);
        $spreadsheet->setActiveSheetIndex(0)->fromArray($headerProfili);
        $spreadsheet->setActiveSheetIndex(0)->fromArray($dataProfili, NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('profili');

        //FOGLIO competenze       
        $headerCompetenze = ['id_profilo', 'id_competenza', 'titolo', 'descrizione', 'risultato'];

        $spreadsheet->createSheet();
        $dataCompetenze = $this->INAPP_model->select_competenze_export($ids);
        $spreadsheet->setActiveSheetIndex(1)->fromArray($headerCompetenze);
        $spreadsheet->setActiveSheetIndex(1)->fromArray($dataCompetenze, NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('competenze');

        //FOGLIO conoscenze       
        $headerConoscenze = ['id_competenza', 'id_conoscenza', 'descrizione'];

        $spreadsheet->createSheet();
        $dataConoscenze = $this->INAPP_model->select_conoscenze_export($ids);
        $spreadsheet->setActiveSheetIndex(2)->fromArray($headerConoscenze);
        $spreadsheet->setActiveSheetIndex(2)->fromArray($dataConoscenze, NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('conoscenze');

        //FOGLIO abilita       
        $headerAbilita = ['id_competenza', 'id_abilita', 'descrizione'];

        $spreadsheet->createSheet();
        $dataAbilita = $this->INAPP_model->select_abilita_export($ids);
        $spreadsheet->setActiveSheetIndex(3)->fromArray($headerAbilita);
        $spreadsheet->setActiveSheetIndex(3)->fromArray($dataAbilita, NULL, 'A2');
        $spreadsheet->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setTitle('abilita');

        $spreadsheet->setActiveSheetIndex(0);

        $this->INAPP_model->set_data_export($ids);


        $this->output->unset_template();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $file_export_name . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    /* AJAX CALL */

    public function get_profili_sep_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = array();
        if ($this->input->post('id_sep'))
        {
            $this->load->model('profilo_model');
            $list_profili = $this->profilo_model->list_profili(array('id_sep' => $this->input->post('id_sep'), 'id_stato_profilo <' => 2));
        }
        foreach ($list_profili as $value)
        {
            $output[] = $value['id_profilo'];
        }

        $this->_render_json($output);
    }

    public function get_profili_validati_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_profilo'))
        {
            $lista_id = $this->input->post("id_profilo");

            $this->db->select('id_profilo,titolo_profilo');
            $this->db->where('id_stato_profilo', 1);
            $this->db->where_in('id_profilo', $lista_id);
            $this->db->from('rrtq_profilo');
            $query = $this->db->get();
            $output = $query->result_array();
        }
        $this->_render_json($output);
    }

}
