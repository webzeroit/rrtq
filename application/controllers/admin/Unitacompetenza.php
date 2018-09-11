<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UnitaCompetenza extends MY_Controller_Admin
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
        $this->load->js('assets/plugins/datatables/jquery.dataTables.min.js');
    }

    public function index()
    {
        $this->output->set_title("Elenco delle Unità di Competenza");
        $this->load->view('unitacompetenza/lista');
    }

    public function gestione($id_competenza = NULL)
    {
        $this->output->set_title("Gestione Unità di Competenza");
        $this->load->model('competenza_model');
        $this->load->model('qualificazione_model');
        $this->load->model('cp2011_model');

        if ($id_competenza === NULL)
        {
            $data = array(
                'action' => "add",
                'competenza' => NULL,
                'id_competenza' => $id_competenza,
                'list_abilita' => NULL,
                'list_conoscenza' => NULL
            );
        }
        else
        {
            $competenza = $this->competenza_model->get_competenza($id_competenza);
            if ($competenza === NULL)
            {
                redirect('admin/unitacompetenza', 'refresh');
            }
            $data = array(
                'action' => "edit",
                'list_abilita' => $this->qualificazione_model->list_competenza_abilita($id_competenza),
                'list_conoscenza' => $this->qualificazione_model->list_competenza_conoscenza($id_competenza),
                'competenza' => $competenza,
                'id_competenza' => $id_competenza
            );
        }
        $data['list_cp2011'] = $this->cp2011_model->list_cp2011();
        $this->load->view('unitacompetenza/gestione', $data);
    }

    public function stampa($id_competenza)
    {
        if ($id_competenza === NULL)
        {
            show_404();
        }

        $this->load->model('competenza_model');
        $this->load->model('qualificazione_model');


        /* DATI COMPETENZA */
        $competenza = $this->competenza_model->get_competenza($id_competenza);
        /* ABILITA' */
        $competenza_abilita = $this->qualificazione_model->list_competenza_abilita($id_competenza);
        $str_abilita = "";
        foreach ($competenza_abilita as $item)
        {
            $str_abilita .= "<li>" . $item['descrizione_abilita'] . " (" . $item['id_abilita'] . ")</li>";
        }
        /* CONOSCENZA */
        $competenza_conoscenza = $this->qualificazione_model->list_competenza_conoscenza($id_competenza);
        $str_conoscenze = "";
        foreach ($competenza_conoscenza as $item)
        {
            $str_conoscenze .= "<li>" . $item['descrizione_conoscenza'] . " (" . $item['id_conoscenza'] . ")</li>";
        }
        /* CP 2011 */
        $competenza_cp2011 = $this->qualificazione_model->list_competenza_cp2011($id_competenza);
        $str_competenza_cp2011 = "";
        foreach ($competenza_cp2011 as $item)
        {
            $str_competenza_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
        }

        $tbl_competenze = '
                <style>
                    td.head {
                        background-color: #99d6ff;
                        font-family: helvetica;
                        font-weight: bold;
                    }   
                    td.titolo {
                        background-color: #F1F1F1;
                        font-family: helvetica;
                        font-weight: bold;
                    }                 
                </style>                 
                <table border="0.01" cellpadding="4" width="100%">  
                    <tr>
                        <td colspan="2" align="center" class="head"><b>DETTAGLIO UNITA\' DI COMPETENZA ('.$id_competenza.')</b></td>                    
                    </tr> 
                    <tr>
                        <td width="30%" class="titolo"><b>Denominazione unit&agrave; di competenza</b></td>
                        <td width="70%"><b>' . $competenza["titolo_competenza"] . '</b></td>
                    </tr>    
                    <tr>
                        <td class="titolo"><b>Livello EQF</b></td>
                        <td>' . $competenza["livello_eqf"] . '</td>
                    </tr>                     
                    <tr>
                        <td class="titolo"><b>Risultato atteso</b></td>
                        <td>' . $competenza["risultato_competenza"] . '</td>
                    </tr>                     
                    <tr>
                        <td class="titolo"><b>Oggetto di osservazione</b></td>
                        <td>' . $competenza["oggetto_di_osservazione"] . '</td>
                    </tr>
                    <tr>
                        <td class="titolo"><b>Indicatori</b></td>
                        <td>' . $competenza["indicatori"] . '</td>
                    </tr>
                    <tr>
                        <td class="titolo"><b>Abilit&agrave;</b></td>
                        <td><ol>' . $str_abilita . '</ol></td>
                    </tr> 
                    <tr>
                        <td class="titolo"><b>Conoscenze</b></td>
                        <td><ol>' . $str_conoscenze . '</ol></td>
                    </tr> 
                    <tr>
                        <td class="titolo"><b>Referenziazione ISTAT CP2011</b></td>
                        <td>' . rtrim($str_competenza_cp2011, '<br/>') . '</td>
                    </tr>                   
                </table>';

        $competenza_profili = $this->competenza_model->list_competenza_profili($id_competenza);

        $tbl_competenza_profili = '
        <style>
            td.head {
                background-color: #99d6ff;
                font-family: helvetica;
                font-weight: bold;
            }   
            td.titolo {
                background-color: #F1F1F1;
                font-family: helvetica;
                font-weight: bold;
            }                 
        </style>                 
        <table border="0.01" cellpadding="4" width="100%">  
            <tr>
                <td colspan="4" align="center" class="head"><b>QUALIFICAZIONI ASSOCIATE</b></td>                    
            </tr>
            <tr>
                <td align="center" class="titolo" width="10%"><b>S.E.P</b></td>                    
                <td class="titolo" width="60%"><b>Denominazione</b></td>                    
                <td align="center" class="titolo" width="10%"><b>Reg.</b></td>                    
                <td class="titolo" width="20%"><b>Stato</b></td>                    
            </tr>';
        if (count($competenza_profili) === 0)
        {
            $tbl_competenza_profili .= '<tr>
                <td colspan="4" align="center"><i>Nessuna qualificazione associata</i></td>                    
            </tr>';
        }
        else
        {
            foreach ($competenza_profili as $profilo)
            {
                $tbl_competenza_profili .= '<tr>
                <td align="center">' . $profilo["id_sep"] . '</td>      
                <td>' . $profilo["titolo_profilo"] . '</td>   
                <td align="center">' . ($profilo["flg_regolamentato"] === "1" ? "SI" : "NO") . '</td>  
                <td>' . $profilo["des_stato_profilo"] . '</td> 
            </tr>';
            }
        }
        $tbl_competenza_profili .= '</table>';



        /* START PDF */
        $this->load->library('Pdf');
        // crea il documento PDF        
        //$pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false, false);
        $pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false, false);
        // imposta metadata documento
        $pdf->document_id = 'UC_' . $id_competenza;
        $pdf->footer_text = '  data_creazione: ' . date('d/m/Y H:i');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Regione Campania');
        $pdf->SetTitle('Unità di Competenza');
        $pdf->SetKeywords('RRTQ, UC');
        // imposta l'header con i loghi
        $pdf->SetHeaderData('logo_ue_regione.jpg', 25, '', '', array(0, 0, 0), array(255, 255, 255));
        // imposta margini
        $pdf->SetMargins(8, 23, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->setFooterData(Array(0, 0, 0), array(255, 255, 255));
        // imposta auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // imposta il font
        $pdf->SetFont('helvetica', '', 9);
        //imposta l'indentazione
        $pdf->setListIndentWidth(4);

        //aggiunge la prima pagina
        $pdf->AddPage();

        //Titolo documento
        $html_titolo = '<h3>REPERTORIO DELLE QUALIFICAZIONI PROFESSIONALI DELLA REGIONE CAMPANIA</h3><br/>';
        $pdf->writeHTMLCell(0, 0, '', '', $html_titolo, 0, 1, 0, true, 'C', true);

        $pdf->writeHTML($tbl_competenze, true, false, false, false, '');

        $pdf->writeHTML($tbl_competenza_profili, true, false, false, false, '');

        $pdf->Output('UC_' . $id_competenza . '.pdf', 'I');
    }

    /*
     * AJAX CALLS FOR index
     */

    public function get_datatables_unitacompetenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $this->load->model('competenza_model');
        $output = $this->competenza_model->datatables_competenza();
        $this->_render_text($output);
    }

    /*
     * AJAX CALLS FOR gestione
     */

    public function save_competenza()
    {
        $FormRules = array(
            array(
                'field' => 'titolo_competenza',
                'label' => 'Titolo Competenza',
                'rules' => 'required|max_length[500]'
            ),
            array(
                'field' => 'risultato_competenza',
                'label' => 'Risultato Atteso',
                'rules' => 'required|max_length[4000]'
            ),
            array(
                'field' => 'oggetto_di_osservazione',
                'label' => 'Oggetto di Osservazione',
                'rules' => 'required|max_length[4000]'
            ),
            array(
                'field' => 'indicatori',
                'label' => 'Indicatori',
                'rules' => 'required|max_length[4000]'
            ),
            array(
                'field' => 'livello_eqf',
                'label' => 'Livello EQF competenza',
                'rules' => 'required|less_than_equal_to[8]',
            ),
            array(
                'field' => 'id_abilita[]',
                'label' => 'Lista delle abilità',
                'rules' => 'required',
            ),
            array(
                'field' => 'id_conoscenza[]',
                'label' => 'Lista delle conoscenze',
                'rules' => 'required',
            )
        );

        $this->form_validation->set_rules($FormRules);

        if ($this->form_validation->run() == TRUE)
        {

            if ($this->input->post())
            {
                $id_competenza = $this->input->post('id_competenza');
                $mode = $this->input->post('action');
                $data['competenza'] = array(
                    'titolo_competenza' => $this->input->post("titolo_competenza"),
                    'descrizione_competenza' => $this->input->post("titolo_competenza"),
                    'risultato_competenza' => $this->input->post("risultato_competenza"),
                    'oggetto_di_osservazione' => $this->input->post("oggetto_di_osservazione"),
                    'indicatori' => $this->input->post("indicatori"),
                    'livello_eqf' => $this->input->post("livello_eqf")
                );
                $data['competenza_abilita'] = $this->input->post("id_abilita");
                $data['competenza_conoscenza'] = $this->input->post("id_conoscenza");
                $data['competenza_cp2011'] = $this->input->post("codice_cp2011");

                $this->load->model('competenza_model');
                $ret = $this->competenza_model->save_competenza($data, $id_competenza);
            }


            if ($ret === FALSE)
            {
                $output = array(
                    'esito' => 'error',
                    'message' => 'Errori in inserimento'
                );
            }
            else
            {
                $output = array(
                    'id_competenza' => $ret,
                    'esito' => 'success',
                    'message' => 'Salvataggio effettuato '
                );
            }
            $this->_render_json($output);
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => validation_errors()
            );
            $this->_render_json($output);
        }
    }

    public function get_datatables_competenza_profili_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post("id_competenza"))
        {
            $this->load->model('competenza_model');
            $output = $this->competenza_model->datatables_competenza_profili($this->input->post("id_competenza"));
            $this->_render_text($output);
        }
    }

    public function search_abilita_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('search'))
        {
            $this->load->model('abilita_model');
            $output = $this->abilita_model->search_abilita($this->input->post('search'));
        }
        $this->_render_json($output);
    }

    public function search_conoscenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        $output = null;
        if ($this->input->post('search'))
        {
            $this->load->model('conoscenza_model');
            $output = $this->conoscenza_model->search_conoscenza($this->input->post('search'));
        }
        $this->_render_json($output);
    }

    public function elimina_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->ion_auth->is_admin() ||
                $this->ion_auth->in_group($this->config->item('role_responsabile')) ||
                $this->ion_auth->in_group($this->config->item('role_supervisore'))
        )
        {
            if ($this->input->post('id_competenza'))
            {
                $this->load->model('competenza_model');
                $ret = $this->competenza_model->elimina_competenza($this->input->post('id_competenza'));

                if ($ret === FALSE)
                {
                    $output = array(
                        'esito' => 'error',
                        'message' => 'Si sono verificati degli errori in fase di cancellazione.'
                    );
                }
                else
                {
                    $output = array(
                        'esito' => 'success',
                        'message' => 'Operazione effettuata con successo '
                    );
                }
                $this->_render_json($output);
            }
        }
        else
        {
            $output = array(
                'esito' => 'error',
                'message' => 'Non hai i privilegi per effettuare questa operazione.'
            );
            $this->_render_json($output); // redirect them to the home page because they must be an administrator to view this
        }
    }

    public function get_cp2011_competenza_json()
    {
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        if ($this->input->post('id_competenza'))
        {
            $this->load->model('qualificazione_model');
            $output = $this->qualificazione_model->list_competenza_cp2011($this->input->post("id_competenza"));
            $rows = array();
            foreach ($output as $row)
            {
                $rows[] = $row['codice_cp2011'];
            }
            $this->_render_json($rows);
        }
    }

}
