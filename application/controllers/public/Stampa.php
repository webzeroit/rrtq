<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stampa extends CI_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index($tipo = "", $id = NULL, $live = 0)
    {
        if (($id === NULL) || $tipo === NULL)
        {
            show_404();
        }
        else
        {
            //la richiesta del pdf live può avvenire solo se l'utente è loggato in backend
            if ($live == 1)
            {
                $this->load->library('ion_auth');
                if (!$this->ion_auth->logged_in())
		{
                    show_error("Non sei autorizzato a visualizzare questa pagina");
                }
            }
            if ($tipo === "sp")
            {
                $this->genera_sp($id, $live);
            }
            else if ($tipo === "sf")
            {
                $this->genera_sf($id, $live);
            }
        }
    }

    private function genera_sp($id_profilo = NULL, $live = 0)
    {

        $this->load->model('qualificazione_model', 'repertorio');
        $profilo_live = $this->repertorio->select_profilo($id_profilo);
        if ($profilo_live === NULL)
        {
            show_404();
        }        
        /*  Verifico lo stato della qualificazione 
         *  Genera il PDF solo se lo stato è Pubblicato o In Revisione
         * 0 = Pubblicato
         * 1 = Revisioni Validate
         * 2 = In Revisione
         * 3 = Non Pubblicato
         * 4 = Cancellato              
         */
        $stato_profilo = (int) $profilo_live['id_stato_profilo'];
        $des_stato_profilo = "Pubblicato";
        switch ($stato_profilo)
        {
            case 0:
                $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                break;
            case 1:
                if ($live == 1)
                {
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                    $des_stato_profilo = "Revisioni Validate";
                }
                else
                {
                    $file_qualificazione = unserialize($profilo_live['file_qualificazione']);
                }
                break;
            case 2:
                if ($live == 1)
                {
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                    $des_stato_profilo = "In Revisione";
                }
                else
                {
                    $file_qualificazione = unserialize($profilo_live['file_qualificazione']);
                }
                break;
            case 3:
                if ($live == 1)
                {
                    $des_stato_profilo = "Non Pubblicato";
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                }
                else
                {
                    show_404();
                }
                break;
            case 4:
            default:
                show_404();
                break;
        }

        if (!is_array($file_qualificazione))
        {
            show_404();
        }
        /*
         * Preparazione dati del profilo
         */
        $profilo = $file_qualificazione['profilo'];
        //PROCESSO
        $document_id = "SP_" . $profilo['id_profilo'] . "_" . date_format(date_create($profilo['data_ultima_modifica']), 'YmdHi');

        $profilo_processo = $file_qualificazione["profilo"]["processo"];
        $str_profilo_processo = "";
        foreach ($profilo_processo as $item)
        {
            $str_profilo_processo .= $item['descrizione_processo'] . "<br/>";
        }

        //SEQUENZA DI PROCESSO
        $profilo_seq_processo = $file_qualificazione["profilo"]["seq_processo"];
        $str_profilo_seq_processo = "";
        foreach ($profilo_seq_processo as $item)
        {
            $str_profilo_seq_processo .= $item['descrizione_sequenza'] . "<br/>";
        }

        // ADA
        $profilo_ada = $file_qualificazione["profilo"]["ada"];
        $str_profilo_ada = "";
        foreach ($profilo_ada as $item)
        {
            $str_profilo_ada .= $item['codice_ada'] . " - " . $item['descrizione_ada'] . "<br/>";
        }
        // CP 2011
        $profilo_cp2011 = $file_qualificazione["profilo"]["cp2011"];
        $str_profilo_cp2011 = "";
        foreach ($profilo_cp2011 as $item)
        {
            $str_profilo_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
        }
        //ATECO 2007
        $profilo_ateco2007 = $file_qualificazione["profilo"]["ateco2007"];
        $str_profilo_ateco2007 = "";
        foreach ($profilo_ateco2007 as $item)
        {
            $str_profilo_ateco2007 .= $item['codice_ateco'] . " - " . $item['descrizione_ateco'] . "<br/>";
        }

        $profilo_competenza = $file_qualificazione["profilo"]["competenze"];
        
        $str_elenco_uc = "";
        foreach ($profilo_competenza as $item)
        {
            $str_elenco_uc .= "<li>" .$item['titolo_competenza'] . " (" . $item['id_competenza'] . ")</li>";
        } 
        
        $row_regolamentata = "";
        if (intval($profilo['flg_regolamentato']) > 0)
        {
            $row_regolamentata = '
             <tr>
                <td class="titolo"><b>Regolamentata</b></td>
                <td>SI</td>
            </tr>';
        }         
        /*
         * Fine estrazione dati del profilo
         */

        //Tabella qualificazione
        $tbl_profilo = '
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
                    <td colspan="2" align="center" class="head"><b>QUALIFICAZIONE PROFESSIONALE</b></td>                    
                </tr> 
                <tr>
                    <td width="30%" class="titolo"><b>Denominazione qualificazione</b></td>
                    <td width="70%"><b>' . $profilo['titolo_profilo'] . '</b></td>
                </tr>  
                <tr>
                    <td class="titolo"><b>Livello EQF</b></td>
                    <td>' . $profilo['livello_eqf'] . '</td>
                </tr>                  
                <tr>
                    <td class="titolo"><b>Settore Economico Professionale</b></td>
                    <td>' . $profilo['codice_sep'] . " - " . $profilo['descrizione_sep'] . '</td>
                </tr>    
                <tr>
                    <td class="titolo"><b>Area di Attivit&agrave;</b></td>
                    <td>' . rtrim($str_profilo_ada,'<br/>') . '</td>
                </tr>                
                <tr>
                    <td class="titolo"><b>Processo</b></td>
                    <td>' . rtrim($str_profilo_processo,'<br/>') . '</td>
                </tr>
                <tr>
                    <td class="titolo"><b>Sequenza di processo</b></td>
                    <td>' . rtrim($str_profilo_seq_processo,'<br/>') . '</td>
                </tr> 
                <tr>
                    <td class="titolo"><b>Descrizione sintetica della qualificazione</b></td>
                    <td>' . $profilo['descrizione_profilo'] . '</td>
                </tr>                 
                <tr>
                    <td class="titolo"><b>Referenziazione ATECO 2007</b></td>
                    <td>' . rtrim($str_profilo_ateco2007,'<br/>') . '</td>
                </tr>      
                <tr>
                    <td class="titolo"><b>Referenziazione ISTAT CP2011</b></td>
                    <td>' . rtrim($str_profilo_cp2011,'<br/>') . '</td>
                </tr>'. $row_regolamentata .'
            </table>';
       //ELENCO UF
        if (strlen($str_elenco_uc) > 0) 
        {
            $tbl_profilo .= '
            <table border="0.01" cellpadding="4" width="100%">  
                <tr>
                    <td align="center" class="head"><b>ELENCO DELLE UNITA\' DI COMPETENZA</b></td>
                </tr>    
                <tr>                    
                    <td style="font-size: 10pt;"><ol>' . $str_elenco_uc . '</ol></td>
                </tr>
            </table>';
        }

        /* START PDF */
        $this->load->library('Pdf');
        // crea il documento PDF        
        //$pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false, false);
        $pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false, false);
        // imposta metadata documento
        $pdf->document_id = $document_id;
        $pdf->document_status = $des_stato_profilo;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Regione Campania');
        $pdf->SetTitle($profilo['titolo_profilo']);
        $pdf->SetSubject('Standard Professionale');
        $pdf->SetKeywords('RRTQ');
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
        $pdf->setListIndentWidth(5);

        //aggiunge la prima pagina
        $pdf->AddPage();

        //Titolo documento
        $html_titolo = '<h3>REPERTORIO DELLE QUALIFICAZIONI PROFESSIONALI DELLA REGIONE CAMPANIA</h3><br/>';
        $pdf->writeHTMLCell(0, 0, '', '', $html_titolo, 0, 1, 0, true, 'C', true);
        $pdf->writeHTML($tbl_profilo, true, false, false, false, '');

        $pdf->AddPage();

        //Titolo documento       
        $prog_competenza = 1;
        $num_competenze = count($profilo_competenza);

        foreach ($profilo_competenza as $competenza)
        {

            $competenza_abilita = $competenza['abilita'];
            $str_abilita = "";
            foreach ($competenza_abilita as $item)
            {
                $str_abilita .= "<li>" . $item['descrizione_abilita'] . "</li>";
            }
            $competenza_conoscenza = $competenza['conoscenza'];
            $str_conoscenze = "";
            foreach ($competenza_conoscenza as $item)
            {
                $str_conoscenze .= "<li>" . $item['descrizione_conoscenza'] . "</li>";
            }
            // CP 2011
            $str_competenza_cp2011 = "";
            if (array_key_exists('cp2011', $competenza))
            {
                $competenza_cp2011 = $competenza["cp2011"];
                foreach ($competenza_cp2011 as $item)
                {
                    $str_competenza_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
                }
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
                        <td colspan="2" align="center" class="head"><b>DETTAGLIO UNITA\' DI COMPETENZA n.' . $prog_competenza . '</b></td>                    
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
                        <td>' . rtrim($str_competenza_cp2011,'<br/>') . '</td>
                    </tr>                   
                </table>';

            $pdf->writeHTML($tbl_competenze, true, false, false, false, '');
         
            $prog_competenza++;
            if ($prog_competenza <= $num_competenze)
            {
                $pdf->AddPage();
            }
        }

        $pdf->Output('Qualificazione_' . $id_profilo . '.pdf', 'I');
    }

    private function genera_sf($id_standard_formativo = NULL, $live = 0)
    {
        /* RICAVO L'ID PROFILO DALL'ID SF */
        $this->load->model('standard_formativo_model', 'sf');
        $sf_profilo = $this->sf->get_id_profilo($id_standard_formativo);
        
        if ($sf_profilo === NULL) 
        {
            show_404();
        }
        $id_profilo = $sf_profilo["id_profilo"];
        
        $this->load->model('qualificazione_model', 'repertorio');        
        $profilo_live = $this->repertorio->select_profilo($id_profilo);
        /*  Verifico lo stato della qualificazione 
         *  Genera il PDF solo se lo stato è Pubblicato o In Revisione
         * 0 = Pubblicato
         * 1 = Revisioni Validate
         * 2 = In Revisione
         * 3 = Non Pubblicato
         * 4 = Cancellato              
         */
        $stato_profilo = (int) $profilo_live['id_stato_profilo'];
        $des_stato_profilo = "Pubblicato";
        switch ($stato_profilo)
        {
            case 0:
                $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                break;
            case 1:
                if ($live == 1)
                {
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                    $des_stato_profilo = "Revisioni Validate";
                }
                else
                {
                    $file_qualificazione = unserialize($profilo_live['file_qualificazione']);
                }
                break;
            case 2:
                if ($live == 1)
                {
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                    $des_stato_profilo = "In Revisione";
                }
                else
                {
                    $file_qualificazione = unserialize($profilo_live['file_qualificazione']);
                }
                break;
            case 3:
                if ($live == 1)
                {
                    $des_stato_profilo = "Non Pubblicato";
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                }
                else
                {
                    show_404();
                }
                break;
            case 4:
            default:
                show_404();
                break;
        }

        if (!is_array($file_qualificazione))
        {
            show_404();  
        }
        
        //Eccezione valida per nuovi standard formativi e con profilo in revisione
        if (!array_key_exists('standard_formativo',$file_qualificazione['profilo']))
        {
            show_404();  
        }
        
        $profilo = $file_qualificazione['profilo'];
        $standard_formativo = null;
        
        $standard_formativi_profilo = $file_qualificazione['profilo']['standard_formativo'];
        foreach ($standard_formativi_profilo as $sf)
        {
            if ($sf["id_standard_formativo"] === $id_standard_formativo)
            {
                $standard_formativo = $sf;
            }   
        }
        //Eccezione relativa a nuovi standard formativi e con profilo in revisione
        if (!is_array($standard_formativo))
        {
            show_404();  
        }
        
        /* RACCOGLIE E STRUTTURA I DATI DEGLI ARRAY */
        $document_id = "SF_" . $id_standard_formativo . "_" . date_format(date_create($standard_formativo['data_ultima_modifica']), 'YmdHi');

        // ADA
        $profilo_ada = $profilo["ada"];
        $str_profilo_ada = "";
        foreach ($profilo_ada as $item)
        {
            $str_profilo_ada .= $item['codice_ada'] . " - " . $item['descrizione_ada'] . "<br/>";
        }
        
        //PROCESSO
        $profilo_processo = $profilo["processo"];
        $str_profilo_processo = "";
        foreach ($profilo_processo as $item)
        {
            $str_profilo_processo .= $item['descrizione_processo'] . "<br/>";
        }

        //SEQUENZA DI PROCESSO
        $profilo_seq_processo = $profilo["seq_processo"];
        $str_profilo_seq_processo = "";
        foreach ($profilo_seq_processo as $item)
        {
            $str_profilo_seq_processo .= $item['descrizione_sequenza'] . "<br/>";
        }

        // CP 2011
        $profilo_cp2011 = $profilo["cp2011"];
        $str_profilo_cp2011 = "";
        foreach ($profilo_cp2011 as $item)
        {
            $str_profilo_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
        }
        
        //ATECO 2007
        $profilo_ateco2007 = $profilo["ateco2007"];
        $str_profilo_ateco2007 = "";
        foreach ($profilo_ateco2007 as $item)
        {
            $str_profilo_ateco2007 .= $item['codice_ateco'] . " - " . $item['descrizione_ateco'] . "<br/>";
        }
        
        //ISCED-F
        $standard_formativo_isced = $standard_formativo["isced"];
        $str_standard_formativo_isced = "";
        foreach ($standard_formativo_isced as $item)
        {
            $str_standard_formativo_isced .= $item['des_isced'] . "<br/>";
        }
        
        $profilo_competenza = $profilo["competenze"];        
        $standard_formativo_uf = $standard_formativo["uf"];   
        $standard_formativo_mod = $standard_formativo["moduli"];   
        
        $str_elenco_uf = "";
        foreach ($standard_formativo_uf as $item)
        {
            $str_elenco_uf .= $item['sequenza'] . " - " . $item['titolo_unita_formativa'] . "<br/>";
        }
        $str_elenco_mod = "";
        foreach ($standard_formativo_mod as $item)
        {
            $str_elenco_mod .= $item['sequenza'] . " - " . $item['titolo_modulo'] . "<br/>";
        }
        
        /* FINE RACCOLTA DATI ARRAY*/
        $row_perc_fac_kc = "";
        if (array_key_exists('perc_fad_aula_lab_kc', $standard_formativo)){
            if (intval($standard_formativo['ore_min_aula_lab_kc']) > 0)
            {
                $row_perc_fac_kc = '
                 <tr>
                    <td class="titolo"><b>Percentuale massima di FaD sulla durata delle attività rivolte alle KC</b></td>
                    <td>' . $standard_formativo['perc_fad_aula_lab_kc'] . '%</td>
                </tr>';
            } 
        }
        //Tabella qualificazione
        $tbl_standard_formativo = '
            <style>
                td.head {
                    background-color: #ffc266;
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
                    <td colspan="2" align="center" class="head"><b>STANDARD FORMATIVO</b></td>                    
                </tr>            
                <tr>
                    <td width="30%" class="titolo"><b>Denominazione Standard Formativo</b></td>
                    <td width="70%"><b>' . $standard_formativo["des_standard_formativo"] . '</b></td>
                </tr>
                <tr>
                    <td class="titolo"><b>Livello EQF</b></td>
                    <td>' . $profilo['livello_eqf'] . '</td>
                </tr>  
                <tr>
                    <td class="titolo"><b>Settore Economico Professionale</b></td>
                    <td>' . $profilo['codice_sep'] . " - " . $profilo['descrizione_sep'] . '</td>
                </tr>                 
                <tr>
                    <td class="titolo"><b>Area di Attivit&agrave;</b></td>
                    <td>' . rtrim($str_profilo_ada,'<br/>') . '</td>
                </tr>
                <tr>
                    <td class="titolo"><b>Processo </b></td>
                    <td>' . rtrim($str_profilo_processo,'<br/>') . '</td>
                </tr>
                <tr>
                    <td class="titolo"><b>Sequenza di processo</b></td>
                    <td>' . rtrim($str_profilo_seq_processo,'<br/>') . '</td>
                </tr>                
                <tr>
                    <td class="titolo"><b>Qualificazione regionale di riferimento</b></td>
                    <td>' . $profilo['titolo_profilo'] . '</td>
                </tr> 
                <tr>
                    <td class="titolo"><b>Descrizione qualificazione</b></td>
                    <td>' . $profilo['descrizione_profilo'] . '</td>
                </tr>   
                <tr>
                    <td class="titolo"><b>Referenziazione ATECO 2007</b></td>
                    <td>' . rtrim($str_profilo_ateco2007,'<br/>') . '</td>
                </tr>      
                <tr>
                    <td class="titolo"><b>Referenziazione ISTAT CP2011</b></td>
                    <td>' . rtrim($str_profilo_cp2011,'<br/>') . '</td>
                </tr>                                
                <tr>
                    <td class="titolo"><b>Codice ISCED-F 2013</b></td>
                    <td>' . rtrim($str_standard_formativo_isced,'<br/>') . '</td>
                </tr>
                <tr>
                    <td class="titolo"><b>Durata minima complessiva del percorso (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_durata_percorso'] . '</td>
                </tr>  
                <tr>
                    <td class="titolo"><b>Durata minima di aula e laboratorio (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_aula_lab'] . '</td>
                </tr> 
                <tr>
                    <td class="titolo"><b>Percentuale massima di FaD sulla durata minima di aula e laboratorio</b></td>
                    <td>' . $standard_formativo['perc_fad_aula_lab'] . '%</td>
                </tr>                 
                <tr>
                    <td class="titolo"><b>Durata minima tirocinio in impresa (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_tirocinio'] . '</td>
                </tr>                   
                <tr>
                    <td class="titolo"><b>Durata minima delle attività di aula e laboratorio rivolte alle KC (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_aula_lab_kc'] . '</td>
                </tr>' . $row_perc_fac_kc . '
                <tr>
                    <td class="titolo"><b>Requisiti minimi di ingresso dei partecipanti</b></td>
                    <td>' . $standard_formativo['req_min_partecipanti'] . '</td>
                </tr>   
                <tr>
                    <td class="titolo"><b>Requisiti minimi didattici comuni a tutte le UF/segmenti</b></td>
                    <td>' . $standard_formativo['req_min_didattici'] . '</td>
                </tr>  
                <tr>
                    <td class="titolo"><b>Requisiti minimi di risorse professionali e strumentali</b></td>
                    <td>' . $standard_formativo['req_min_risorse'] . '</td>
                </tr>   
                <tr>
                    <td class="titolo"><b>Requisiti minimi di valutazione e di attestazione degli apprendimenti</b></td>
                    <td>' . $standard_formativo['req_min_valutazione'] . '</td>
                </tr> 
                <tr>
                    <td class="titolo"><b>Gestione dei crediti formativi</b></td>
                    <td>' . $standard_formativo['req_crediti_formativi'] . '</td>
                </tr>    
                <tr>
                    <td class="titolo"><b>Eventuali ulteriori indicazioni</b></td>
                    <td>' . $standard_formativo['altre_indicazioni'] . '</td>
                </tr>                 
            </table>';
        //ELENCO UF
        if (strlen($str_elenco_uf) > 0) 
        {
            $tbl_standard_formativo .= '
            <table border="0.01" cellpadding="4" width="100%">  
                <tr>
                    <td align="center" class="head"><b>ELENCO DELLE UNITA\' FORMATIVE</b></td>
                </tr>    
                <tr>                    
                    <td style="font-size: 10pt;">' . rtrim($str_elenco_uf,'<br/>') . '</td>
                </tr>
            </table>';
        }
        //ELENCO MODULI
        if (strlen($str_elenco_mod) > 0) 
        {
            $tbl_standard_formativo .= '                            
            <table border="0.01" cellpadding="4" width="100%">  
                <tr>
                    <td align="center" class="head"><b>ELENCO DEI MODULI</b></td>
                </tr>    
                <tr>                    
                    <td style="font-size: 10pt;">' . rtrim($str_elenco_mod,'<br/>') . '</td>
                </tr>
            </table>';
        }        
        
        
        
        
        
        /* START PDF */
        $this->load->library('Pdf');
        // crea il documento PDF        
        //$pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false, false);
        $pdf = new Pdf('P', 'mm', 'A4', false, 'ISO-8859-1', false, false);
        // imposta metadata documento
        $pdf->document_id = $document_id;
        $pdf->document_status = $des_stato_profilo;
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Regione Campania');
        $pdf->SetTitle($standard_formativo['des_standard_formativo']);
        $pdf->SetSubject('Standard Formativo');
        $pdf->SetKeywords('RRTQ');
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
        $pdf->setListIndentWidth(5);

        //aggiunge la prima pagina
        $pdf->AddPage();
        
        //Titolo documento
        $html_titolo = '<h3>REPERTORIO DELLE QUALIFICAZIONI PROFESSIONALI DELLA REGIONE CAMPANIA</h3><br/>';
        $pdf->writeHTMLCell(0, 0, '', '', $html_titolo, 0, 1, 0, true, 'C', true);
        $pdf->writeHTML($tbl_standard_formativo, true, false, false, false, '');
        
        $pdf->AddPage();
        
        //STAMPA DETTAGLIO UF
        $prog_uf = 1;
        $num_uf = count($standard_formativo_uf);
        foreach ($standard_formativo_uf as $uf)
        {
            $uc = $this->get_uc_from_array($profilo_competenza, $uf["id_competenza"]);

            $competenza_abilita = $uc['abilita'];
            $str_abilita = "";
            foreach ($competenza_abilita as $item)
            {
                $str_abilita .= "<li>" . $item['descrizione_abilita'] . "</li>";
            }
            $competenza_conoscenza = $uc['conoscenza'];
            $str_conoscenze = "";
            foreach ($competenza_conoscenza as $item)
            {
                $str_conoscenze .= "<li>" . $item['descrizione_conoscenza'] . "</li>";
            }

            
            $tbl_standard_formativo = '
            <style>
                td.head {
                    background-color: #ffc266;
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
                    <td colspan="2" align="center" class="head"><b>DETTAGLIO UNITA\' FORMATIVA n.'. $uf["sequenza"] .'</b></td>                    
                </tr>
                <tr>
                    <td width="30%" class="titolo"><b>Denominazione unit&agrave; formativa</b></td>
                    <td width="70%"><b>' . $uf["titolo_unita_formativa"] . '</b></td>
                </tr>     
                <tr>
                    <td  class="titolo"><b>Livello EQF</b></td>
                    <td>' . $uc["livello_eqf"] . '</td>
                </tr>      
                <tr>
                    <td  class="titolo"><b>Denominazione unit&agrave; di competenza</b></td>
                    <td>' . $uc["titolo_competenza"] . " (" . $uc["id_competenza"] . ')</td>
                </tr>
                <tr>
                    <td class="titolo"><b>Risultato atteso</b></td>
                    <td>' . $uc["risultato_competenza"] . '</td>
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
                    <td  class="titolo"><b>Vincoli (eventuali)</b></td>
                    <td>' . $uf["des_eventuali_vincoli"] . '</td>
                </tr>                 
                <tr>
                    <td class="titolo"><b>Durata minima (ore)</b></td>
                    <td>' . $uf["ore_min_durata_uf"] . '</td>
                </tr>       
                <tr>
                    <td  class="titolo"><b>Percentuale di variazione massima consentita in aumento e/o diminuzione della durata minima dell\'UF</b></td>
                    <td>' . $uf["perc_varianza"] . '%</td>
                </tr>   
                <tr>
                    <td  class="titolo"><b>Percentuale massima di FaD</b></td>
                    <td>' . $uf["perc_fad_uf"] . '%</td>
                </tr>                
            </table>';
            
            $pdf->writeHTML($tbl_standard_formativo, true, false, false, false, '');
        
            $prog_uf++;
            if ($prog_uf <= $num_uf)
            {
                $pdf->AddPage();
            }
        
        }        
        
 
        
        //STAMPA DETTAGLIO MODULI
        $prog_mod = 1;
        $num_mod = count($standard_formativo_mod);
        foreach ($standard_formativo_mod as $modulo)
        {            
            
            $tbl_standard_formativo = '
            <style>
                td.head {
                    background-color: #ffc266;
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
                    <td colspan="2" align="center" class="head"><b>DETTAGLIO MODULO n.'. $modulo["sequenza"] . '</b></td>                    
                </tr>
                <tr>
                    <td width="30%" class="titolo"><b>Denominazione modulo</b></td>
                    <td width="70%"><b>' . $modulo["titolo_modulo"] . '</b></td>
                </tr>   
                <tr>
                    <td  class="titolo"><b>Conoscenze/contenuti</b></td>
                    <td>' . $modulo["des_contenuti"] . '</td>
                </tr>   
                <tr>
                    <td  class="titolo"><b>Vincoli (eventuali)</b></td>
                    <td>' . $modulo["des_eventuali_vincoli"] . '</td>
                </tr>                 
                <tr>
                    <td class="titolo"><b>Durata minima (ore)</b></td>
                    <td>' . $modulo["ore_min_durata_mod"] . '</td>
                </tr>         
                <tr>
                    <td  class="titolo"><b>Percentuale massima di FaD</b></td>
                    <td>' . $modulo["perc_fad_mod"] . '%</td>
                </tr> 
            </table>';
            
            $pdf->writeHTML($tbl_standard_formativo, true, false, false, false, '');
        
            $prog_mod++;
            if ($prog_mod <= $num_mod)
            {
                $pdf->AddPage();
            }
        
        }             
        
        $pdf->Output('StandardFormativo_' . $id_standard_formativo . '.pdf', 'I');
    }
            
    private function get_uc_from_array($array_uc, $find_id_competenza)
    {
        foreach ($array_uc as $uc)
        {
            if ($uc["id_competenza"] === $find_id_competenza)
            {
                return $uc;
            }   
        }
        return NULL;
    }

}
