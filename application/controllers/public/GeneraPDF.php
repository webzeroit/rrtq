<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GeneraPDF extends CI_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function live($id_profilo = NULL)
    {

        if ($id_profilo === NULL)
        {
            show_404();
        }
        else
        {
            $this->load->model('qualificazione_model', 'repertorio');
            /*
             * Estrazione dati del profilo
             */
            $profilo = $this->repertorio->select_profilo($id_profilo);
            //PROCESSO
            $profilo_processo = $this->repertorio->list_profilo_processo($id_profilo);
            $str_profilo_processo = "";
            foreach ($profilo_processo as $item)
            {
                $str_profilo_processo .= $item['descrizione_processo'] . "<br/>";
            }
            //SEQUENZA DI PROCESSO
            $profilo_seq_processo = $this->repertorio->list_profilo_seq_processo($id_profilo);
            $str_profilo_seq_processo = "";
            foreach ($profilo_seq_processo as $item)
            {
                $str_profilo_seq_processo .= $item['descrizione_sequenza'] . "<br/>";
            }
            // ADA
            $profilo_ada = $this->repertorio->list_profilo_ada($id_profilo);
            $str_profilo_ada = "";
            foreach ($profilo_ada as $item)
            {
                $str_profilo_ada .= $item['codice_ada'] . " - " . $item['descrizione_ada'] . "<br/>";
            }
            // CP 2011
            $profilo_cp2011 = $this->repertorio->list_profilo_cp2011($id_profilo);
            $str_profilo_cp2011 = "";
            foreach ($profilo_cp2011 as $item)
            {
                $str_profilo_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
            }
            //ATECO 2007
            $profilo_ateco2007 = $this->repertorio->list_profilo_ateco2007($id_profilo);
            $str_profilo_ateco2007 = "";
            foreach ($profilo_ateco2007 as $item)
            {
                $str_profilo_ateco2007 .= $item['codice_ateco'] . " - " . $item['descrizione_ateco'] . "<br/>";
            }

            $profilo_competenza = $this->repertorio->list_profilo_competenza($id_profilo);
            /*
             * Fine estrazione dati del profilo
             */

            $this->load->library('Pdf');
            // crea il documento PDF
            $pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false);

            // imposta informazioni documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Regione Campania');
            $pdf->SetTitle($profilo['titolo_profilo']);
            $pdf->SetSubject('Standard Professionale');
            $pdf->SetKeywords('RRTQ');

            // imposta l'header con i loghi
            $pdf->SetHeaderData('logo_ue_regione.jpg', 30, '', '', array(0, 0, 0), array(255, 255, 255));

            // imposta margini
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->setFooterData(Array(0, 0, 0), array(255, 255, 255));
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf->SetFont('helvetica', '', 10);


            $pdf->setListIndentWidth(8);

            $pdf->AddPage();

            //Titolo documento
            $html_titolo = '<h4>REPERTORIO<br/>DELLE QUALIFICAZIONI PROFESSIONALI DELLA REGIONE CAMPANIA</h4>';
            $pdf->writeHTMLCell(0, 0, '', '', $html_titolo, 0, 1, 0, true, 'C', true);

            //Spazio
            $pdf->Ln(10);

            //Tabella qualificazione
            $tbl_profilo = '
            <table border="0.01" cellpadding="4">
                <tr style="background-color:#D9D9D9;">
                    <td colspan="2" align="center" width="510" height="40"><b>SETTORE ECONOMICO PROFESSIONALE<br/><br/><i>' . $profilo['descrizione_sep'] . '</i></b></td>
                </tr>    
                <tr>
                    <td width="150"><b>Processo</b></td>
                    <td width="360">' . $str_profilo_processo . '</td>
                </tr>
                <tr>
                    <td><b>Sequenza di processo</b></td>
                    <td>' . $str_profilo_seq_processo . '</td>
                </tr>  
                <tr>
                    <td><b>Area di Attivit&agrave;</b></td>
                    <td>' . $str_profilo_ada . '</td>
                </tr>                
                <tr>
                    <td><b>Qualificazione regionale</b></td>
                    <td>' . $profilo['titolo_profilo'] . '</td>
                </tr> 
                <tr>
                    <td><b>Referenziazioni</b></td>
                    <td><i>Nomenclatura delle unit&agrave; Professionali (NUP/CP ISTAT 2011)</i>:<br/>
                    ' . $str_profilo_cp2011 . '
                    <br/>
                    <i>Classificazione delle attivit&agrave; economiche (ATECO 2007/ISTAT)</i>:<br/>
                    ' . $str_profilo_ateco2007 . '
                    </td>
                </tr>
                <tr>
                    <td><b>Livello EQF</b></td>
                    <td>' . $profilo['livello_eqf'] . '</td>
                </tr>
                 <tr>
                    <td><b>Descrizione sintetica della qualificazione e delle attivit&agrave;</b></td>
                    <td>' . $profilo['descrizione_profilo'] . '</td>
                </tr>                 
            </table>';

            $pdf->writeHTML($tbl_profilo, true, false, false, false, '');

            $pdf->AddPage();

            //Titolo documento
            $html_titolo_competenze = '<h4>STANDARD DELLE COMPETENZE TECNICO-PROFESSIONALI<br/>CARATTERIZZANTI LA QUALIFICAZIONE</h4>';
            $pdf->writeHTMLCell(0, 15, '', '', utf8_encode($html_titolo_competenze), 0, 1, 0, true, 'C', true);

            $prog_competenza = 1;
            $num_competenze = count($profilo_competenza);

            foreach ($profilo_competenza as $competenza)
            {

                $competenza_abilita = $this->repertorio->list_competenza_abilita($competenza['id_competenza']);
                $str_abilita = "";
                foreach ($competenza_abilita as $item)
                {
                    $str_abilita .= "<li>" . $item['descrizione_abilita'] . "</li>";
                }
                $competenza_conoscenza = $this->repertorio->list_competenza_conoscenza($competenza['id_competenza']);
                $str_conoscenze = "";
                foreach ($competenza_conoscenza as $item)
                {
                    $str_conoscenze .= "<li>" . $item['descrizione_conoscenza'] . "</li>";
                }

                $tbl_competenze = '
                <table border="0.01" cellpadding="4">
                    <tr style="background-color:#D9D9D9;">
                        <td colspan="2" align="center" width="510"><b>COMPETENZA N. ' . $prog_competenza . ' - Titolo</b><br/>' . $competenza['titolo_competenza'] . '</td>
                    </tr>    
                    <tr style="background-color:#D9D9D9;">
                        <td colspan="2" align="center"><b>Risultato atteso</b><br/>' . $competenza['risultato_competenza'] . '</td>
                    </tr>  
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="255"><b>Abilit&agrave;</b></td>
                        <td align="center" width="255"><b>Conoscenze</b></td>
                    </tr>     
                    <tr>
                        <td>
                        <ul>
                            ' . $str_abilita . '
                        </ul>
                        </td>
                        <td>
                            <ul>
                             ' . $str_conoscenze . '                         
                            </ul>
                        </td>
                    </tr>
                </table>';
                $pdf->writeHTML($tbl_competenze, true, false, false, false, '');

                //Spazio
                $pdf->Ln(10);
                $html_titolo_ris_competenze = '<p><b>Indicazioni per la valutazione delle competenze</b></p>';
                $pdf->writeHTMLCell(0, 7, '', '', $html_titolo_ris_competenze, 0, 1, 0, true, '', true);



                $tbl_ris_competenze = '
                <table border="0.01" cellpadding="4">
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="170"><b>Titolo competenza e Risultato atteso</b></td>
                        <td align="center" width="170"><b>Oggetto di osservazione</b></td>
                        <td align="center" width="170"><b>Indicatori</b></td>
                    </tr>
                    <tr>
                        <td>' . $competenza['titolo_competenza'] . "<br/>" . $competenza['risultato_competenza'] . '</td>
                        <td>' . $competenza['oggetto_di_osservazione'] . '</td>
                        <td>' . $competenza['indicatori'] . '</td>
                    </tr>
                </table>
                ';


                $pdf->writeHTML($tbl_ris_competenze, true, false, false, false, '');


                $prog_competenza++;
                if ($prog_competenza <= $num_competenze)
                    $pdf->AddPage();
            }


            $pdf->Output('Qualificazione_' . $id_profilo . '.pdf', 'I');
        }
    }

    public function index($id_profilo = NULL)
    {
        if ($id_profilo === NULL)
        {
            show_404();
        }
        else
        {
            $this->load->model('qualificazione_model', 'repertorio');
            $profilo_live = $this->repertorio->select_profilo($id_profilo);
            /*  Verifico lo stato della qualificazione 
             *  Genera il PDF solo se lo stato è Pubblicato o In Revisione
             * 1 = Pubblicato
             * 2 = In Revisione
             * 3 = Non Pubblicato
             * 4 = Cancellato              
             */
            $stato_profilo = (int) $profilo_live['id_stato_profilo'];
            switch ($stato_profilo)
            {
                case 1:
                    $file_qualificazione = $this->repertorio->select_qualificazione($id_profilo);
                    break;
                case 2:
                    $file_qualificazione = unserialize($profilo_live['file_qualificazione']);
                    break;
                case 3:
                case 4:
                default:
                    show_404();
                    break;
            }


            /*
             * Preparazione dati del profilo
             */
            $profilo = $file_qualificazione['profilo'];
            //PROCESSO
            $document_id = $profilo['id_profilo'] . "_" . date_format(date_create($profilo['data_ultima_modifica']),'YmdHi');
            
            
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
            /*
             * Fine estrazione dati del profilo
             */



            /* START PDF */
            $this->load->library('Pdf');
            // crea il documento PDF
            $pdf = new Pdf('P', 'mm', 'A4', false, 'UTF-8', false);
            // imposta metadata documento
            $pdf->document_id = $document_id;
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Regione Campania');
            $pdf->SetTitle($profilo['titolo_profilo']);
            $pdf->SetSubject('Standard Professionale');
            $pdf->SetKeywords('RRTQ');
            // imposta l'header con i loghi
            $pdf->SetHeaderData('logo_ue_regione.jpg', 30, '', '', array(0, 0, 0), array(255, 255, 255));
            // imposta margini
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->setFooterData(Array(0, 0, 0), array(255, 255, 255));
            // imposta auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // imposta il font
            $pdf->SetFont('helvetica', '', 10);
            //imposta l'indentazione
            $pdf->setListIndentWidth(8);

            //aggiunge la prima pagina
            $pdf->AddPage();

            //Titolo documento
            $html_titolo = '<h4>REPERTORIO<br/>DELLE QUALIFICAZIONI PROFESSIONALI DELLA REGIONE CAMPANIA</h4>';
            $pdf->writeHTMLCell(0, 0, '', '', $html_titolo, 0, 1, 0, true, 'C', true);

            //Spazio
            $pdf->Ln(10);

            //Tabella qualificazione
            $tbl_profilo = '
            <table border="0.01" cellpadding="4">
                <tr style="background-color:#D9D9D9;">
                    <td colspan="2" align="center" width="510" height="40"><b>SETTORE ECONOMICO PROFESSIONALE<br/><br/><i>' . $profilo['descrizione_sep'] . '</i></b></td>
                </tr>    
                <tr>
                    <td width="150"><b>Processo</b></td>
                    <td width="360">' . $str_profilo_processo . '</td>
                </tr>
                <tr>
                    <td><b>Sequenza di processo</b></td>
                    <td>' . $str_profilo_seq_processo . '</td>
                </tr>  
                <tr>
                    <td><b>Area di Attivit&agrave;</b></td>
                    <td>' . $str_profilo_ada . '</td>
                </tr>                
                <tr>
                    <td><b>Qualificazione regionale</b></td>
                    <td>' . $profilo['titolo_profilo'] . '</td>
                </tr> 
                <tr>
                    <td><b>Referenziazioni</b></td>
                    <td><i>Nomenclatura delle unit&agrave; Professionali (NUP/CP ISTAT 2011)</i>:<br/>
                    ' . $str_profilo_cp2011 . '
                    <br/>
                    <i>Classificazione delle attivit&agrave; economiche (ATECO 2007/ISTAT)</i>:<br/>
                    ' . $str_profilo_ateco2007 . '
                    </td>
                </tr>
                <tr>
                    <td><b>Livello EQF</b></td>
                    <td>' . $profilo['livello_eqf'] . '</td>
                </tr>
                 <tr>
                    <td><b>Descrizione sintetica della qualificazione e delle attivit&agrave;</b></td>
                    <td>' . $profilo['descrizione_profilo'] . '</td>
                </tr>                 
            </table>';

            $pdf->writeHTML($tbl_profilo, true, false, false, false, '');

            $pdf->AddPage();

            //Titolo documento
            $html_titolo_competenze = '<h4>STANDARD DELLE COMPETENZE TECNICO-PROFESSIONALI<br/>CARATTERIZZANTI LA QUALIFICAZIONE</h4>';
            $pdf->writeHTMLCell(0, 15, '', '', utf8_encode($html_titolo_competenze), 0, 1, 0, true, 'C', true);

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

                $tbl_competenze = '
                <table border="0.01" cellpadding="4">
                    <tr style="background-color:#D9D9D9;">
                        <td colspan="2" align="center" width="510"><b>COMPETENZA N. ' . $prog_competenza . ' - Titolo</b><br/>' . $competenza['titolo_competenza'] . '</td>
                    </tr>    
                    <tr style="background-color:#D9D9D9;">
                        <td colspan="2" align="center"><b>Risultato atteso</b><br/>' . $competenza['risultato_competenza'] . '</td>
                    </tr>  
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="255"><b>Abilit&agrave;</b></td>
                        <td align="center" width="255"><b>Conoscenze</b></td>
                    </tr>     
                    <tr>
                        <td>
                        <ul>
                            ' . $str_abilita . '
                        </ul>
                        </td>
                        <td>
                            <ul>
                             ' . $str_conoscenze . '                         
                            </ul>
                        </td>
                    </tr>
                </table>';
                $pdf->writeHTML($tbl_competenze, true, false, false, false, '');

                //Spazio
                $pdf->Ln(10);
                $html_titolo_ris_competenze = '<p><b>Indicazioni per la valutazione delle competenze</b></p>';
                $pdf->writeHTMLCell(0, 7, '', '', $html_titolo_ris_competenze, 0, 1, 0, true, '', true);



                $tbl_ris_competenze = '
                <table border="0.01" cellpadding="4">
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="170"><b>Titolo competenza e Risultato atteso</b></td>
                        <td align="center" width="170"><b>Oggetto di osservazione</b></td>
                        <td align="center" width="170"><b>Indicatori</b></td>
                    </tr>
                    <tr>
                        <td>' . $competenza['titolo_competenza'] . "<br/>" . $competenza['risultato_competenza'] . '</td>
                        <td>' . $competenza['oggetto_di_osservazione'] . '</td>
                        <td>' . $competenza['indicatori'] . '</td>
                    </tr>
                </table>
                ';


                $pdf->writeHTML($tbl_ris_competenze, true, false, false, false, '');


                $prog_competenza++;
                if ($prog_competenza <= $num_competenze)
                    $pdf->AddPage();
            }

            $pdf->Output('Qualificazione_' . $id_profilo . '.pdf', 'I');
        }
    }

}
