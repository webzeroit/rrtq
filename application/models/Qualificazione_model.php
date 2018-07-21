<?php

/**
 * Name:    Repertorio Model
 * Author:  Raffaele Lanzetta
 *           r.lanzetta@gmail.com
 * 
 *
 *
 * Created:  10.01.2009
 *
 * Description:  La classe è responsabile della lettura della qualificazione con relative 
 * Unità di Competenza (Abilità e Conscenze), A.D.A., Referenziazioni CP ed ATECO per la
 * generazione della scheda in pdf/xml/json
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Qualificazione_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function select_profilo($id)
    {
        $this->db->where('id_profilo', $id);
        $this->db->from('rrtq_profilo');
        $this->db->join('rrtq_sep', 'rrtq_profilo.id_sep = rrtq_sep.id_sep');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function list_profilo_cp2011($id)
    {
        $this->db->from('rrtq_profilo_cp2011');
        $this->db->join('rrtq_istat_cp2011', 'rrtq_profilo_cp2011.codice_cp2011 = rrtq_istat_cp2011.codice_cp2011');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_ateco2007($id)
    {
        $this->db->from('rrtq_profilo_ateco2007');
        $this->db->join('rrtq_istat_ateco2007', 'rrtq_profilo_ateco2007.codice_ateco = rrtq_istat_ateco2007.codice_ateco');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_processo($id)
    {
        $this->db->select('codice_processo, descrizione_processo');
        $this->db->distinct();
        $this->db->from('v_rrtq_profilo_ada_seq_proc');
        $this->db->where('id_profilo', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_seq_processo($id)
    {
        $this->db->select('codice_sequenza, descrizione_sequenza');
        $this->db->distinct();
        $this->db->from('v_rrtq_profilo_ada_seq_proc');
        $this->db->where('id_profilo', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_ada($id)
    {
        $this->db->select('id_ada, codice_ada, descrizione_ada');
        $this->db->from('v_rrtq_profilo_ada_seq_proc');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_profilo_competenza($id)
    {
        $this->db->from('rrtq_profilo_competenza');
        $this->db->join('rrtq_competenza', 'rrtq_profilo_competenza.id_competenza = rrtq_competenza.id_competenza');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_competenza_abilita($id)
    {
        $this->db->from('rrtq_competenza_abilita');
        $this->db->join('rrtq_abilita', 'rrtq_competenza_abilita.id_abilita = rrtq_abilita.id_abilita');
        $this->db->where('id_competenza', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_competenza_conoscenza($id)
    {
        $this->db->from('rrtq_competenza_conoscenza');
        $this->db->join('rrtq_conoscenza', 'rrtq_competenza_conoscenza.id_conoscenza = rrtq_conoscenza.id_conoscenza');
        $this->db->where('id_competenza', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_competenza_cp2011($id)
    {
        $this->db->from('rrtq_competenza_cp2011');
        $this->db->join('rrtq_istat_cp2011', 'rrtq_competenza_cp2011.codice_cp2011 = rrtq_istat_cp2011.codice_cp2011');
        $this->db->where('id_competenza', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * Estrae la qualificazione completa
     */

    public function select_qualificazione($id)
    {
        $data = array();
        $data["profilo"] = $this->select_profilo($id);
        $data["profilo"]["processo"] = $this->list_profilo_processo($id);
        $data["profilo"]["seq_processo"] = $this->list_profilo_seq_processo($id);
        $data["profilo"]["ada"] = $this->list_profilo_ada($id);
        $data["profilo"]["ateco2007"] = $this->list_profilo_ateco2007($id);
        $data["profilo"]["cp2011"] = $this->list_profilo_cp2011($id);
        $competenze = $this->list_profilo_competenza($id);
        $i = 0;
        foreach ($competenze as $competenza)
        {
            $id_competenza = $competenza["id_competenza"];
            $data["profilo"]["competenze"][$i] = $competenza;
            $data["profilo"]["competenze"][$i]["abilita"] = $this->list_competenza_abilita($id_competenza);
            $data["profilo"]["competenze"][$i]["conoscenza"] = $this->list_competenza_conoscenza($id_competenza);
            $i++;
        }
        return $data;
    }

    public function select_qualificazione_serialized($id)
    {
        $this->db->select('file_qualificazione');
        $this->db->from('rrtq_profilo');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        $data = $query->row_array();
        return unserialize($data['file_qualificazione']);
    }

    public function elimina_qualificazione($id)
    {
        if ($id !== "")
        {
            //AVVIO TRANSAZIONE
            $this->db->trans_start();

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_cp2011');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_ateco2007');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_competenza');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_ada');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo');

            //FINE TRANSAZIONE
            $this->db->trans_complete();


            if ($this->db->trans_status() === FALSE)
            {
                return FALSE;
            }
            else
            {
                /* LOG ACTIVITY */
                $this->db->cache_delete_all();
                $this->activity->log("delete", array(
                    'id' => $id,
                    'table' => 'Qualificazione',
                    'extra_info' => 'in modo definitivo'
                ));
                return TRUE;
            }
        }
    }

    /*
     * Genera la qualificazione in HTML per lanciare il Diff Checker
     * il flag revisione indica se selezionare la qualificazione che 
     * è attualmente in modifica (1) oppure l'ultima pubblicata presente
     * nella colonna serialized del DB (0)    
     * Fine Tuning DiffTools
     */

    public function diffTool($id)
    {
        /* SELEZIONA LE VERSIONI DA CONFRONTARE */
        $prima = $this->select_qualificazione_serialized($id);
        if (empty($prima))
        {
            return "<h1>Nessuna versione precedente disponibile al confronto</h1>";;
        }
        $dopo = $this->select_qualificazione($id);

        
        $htmlconDifferenze = "
            <style> 
                ins {color: #333333;background-color: #41ff32; text-decoration: none;}
                del {color: #AA3333;background-color: #ffeaea;text-decoration: line-through;}
            </style>
            <center><i>Diff-Check effettuato il " . date('d/m/Y H:i') . "<i></center><br><br>";

        $competenze_prima = $prima['profilo']['competenze'];
        $competenze_dopo = $dopo['profilo']['competenze'];

        unset($prima['profilo']['competenze']);
        unset($dopo['profilo']['competenze']);

        /* CREA I 2 HTML PROFILO */
        $html_profilo_prima = $this->profiloToHTML($prima);
        $html_profilo_dopo = $this->profiloToHTML($dopo);
        
        $htmlconDifferenze .= $this->diffHTML($html_profilo_prima, $html_profilo_dopo);
        
        
        /* CONTIENE I 2 HTML COMPETENZE */
        foreach ($competenze_prima as $key_prima => $competenza_prima)
        {
            $html_competenze_prima = "";
            $html_competenze_dopo = "";
            $trovata = false;
            $id_competenza_prima = $competenza_prima["id_competenza"];

            foreach ($competenze_dopo as $key_dopo => $competenza_dopo)
            {
                $id_competenza_dopo = $competenza_dopo["id_competenza"];

                if ($id_competenza_prima == $id_competenza_dopo)
                {
                    $trovata = true;
                    break;
                }
            }

            if ($trovata)
            {
                /* CREA I 2 HTML COMPETENZE E LI CONTRONTA */
                $html_competenze_prima = $this->competenzaToHTML($competenze_prima[$key_prima]);
                $html_competenze_dopo = $this->competenzaToHTML($competenze_dopo[$key_dopo]);
                $htmlconDifferenze .= $this->diffHTML($html_competenze_prima, $html_competenze_dopo);
                unset($competenze_dopo[$key_dopo]);
            }
            else
            {
                $html_competenze_prima = $this->competenzaToHTML($competenze_prima[$key_prima]);
                $htmlconDifferenze .= $this->diffHTML($html_competenze_prima, NULL);                
            }
        }
        if (count($competenze_dopo) > 0)
        {
            foreach ($competenze_dopo as $new_competenze)
            {
                $html_competenze_dopo = $this->competenzaToHTML($new_competenze);
                $htmlconDifferenze .= $this->diffHTML(NULL, $html_competenze_dopo); 
            }
        }
     
        return $htmlconDifferenze;
    }

    private function diffHTML($prima, $dopo)
    {
        $htmlDiff = new Caxy\HtmlDiff\HtmlDiff($prima, $dopo);
        $htmlDiff->getConfig()
                ->setPurifierCacheLocation('application/cache/purifier/')
                ->setInsertSpaceInReplace(true)
                ->setGroupDiffs(true)
                ->setUseTableDiffing(true);

        return $htmlDiff->build();
    }

    private function profiloToHTML($file_qualificazione)
    {
        $profilo = $file_qualificazione['profilo'];

        $profilo_processo = $file_qualificazione["profilo"]["processo"];
        $str_profilo_processo = "";
        if (!empty($profilo_processo))
        {
            foreach ($profilo_processo as $item)
            {
                $str_profilo_processo .= $item['descrizione_processo'] . "<br/>";
            }
        }
        //SEQUENZA DI PROCESSO
        $profilo_seq_processo = $file_qualificazione["profilo"]["seq_processo"];
        $str_profilo_seq_processo = "";
        if (!empty($profilo_seq_processo))
        {
            foreach ($profilo_seq_processo as $item)
            {
                $str_profilo_seq_processo .= $item['descrizione_sequenza'] . "<br/>";
            }
        }
        // ADA
        $profilo_ada = $file_qualificazione["profilo"]["ada"];
        $str_profilo_ada = "";
        if (!empty($profilo_ada))
        {
            foreach ($profilo_ada as $item)
            {
                $str_profilo_ada .= $item['codice_ada'] . " - " . $item['descrizione_ada'] . "<br/>";
            }
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
        /*
         * Fine estrazione dati del profilo
         * Inizio la composizione dell'HTML
         */
        $html = "";
        $html .= '
            <table border="1" cellpadding="4" style="border-collapse: collapse;" width="100%">
                <tr style="background-color:#D9D9D9;">
                    <td colspan="2" align="center" width="510" height="40"><b>SETTORE ECONOMICO PROFESSIONALE<br/><br/><i>' . $profilo['descrizione_sep'] . '</i></b></td>
                </tr>    
                <tr>
                    <td width="25%"><b>Processo</b></td>
                    <td width="75%">' . $str_profilo_processo . '</td>
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
                <tr>
                    <td><b>Regolamentata</b></td>
                    <td>' . ($profilo['flg_regolamentato'] == 1 ? 'SI' : 'NO') . '</td>
                </tr>                                 
            </table>
            <br/><br/>';
        return $html;
    }

    private function competenzaToHTML($competenza)
    {
        $html = "";
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

        $html .= '
                <table border="1" cellpadding="4" style="border-collapse: collapse;" width="100%">
                    <tr style="background-color:#D9D9D9;">
                        <td colspan="2" align="center" width="100%"><b>COMPETENZA - Titolo</b><br/>' . $competenza['titolo_competenza'] . '</td>
                    </tr>    
                    <tr style="background-color:#D9D9D9;">
                        <td colspan="2" align="center"><b>Risultato atteso</b><br/>' . $competenza['risultato_competenza'] . '</td>
                    </tr>  
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="50%"><b>Abilit&agrave;</b></td>
                        <td align="center" width="50%"><b>Conoscenze</b></td>
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


        $html .= '<br/><p><b>Indicazioni per la valutazione delle competenze</b></p>
                  <table border="1" cellpadding="4" style="border-collapse: collapse;" width="100%">
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="33%"><b>Titolo competenza e Risultato atteso</b></td>
                        <td align="center" width="33%"><b>Oggetto di osservazione</b></td>
                        <td align="center" width="34%"><b>Indicatori</b></td>
                    </tr>
                    <tr>
                        <td>' . $competenza['titolo_competenza'] . "<br/>" . $competenza['risultato_competenza'] . '</td>
                        <td>' . $competenza['oggetto_di_osservazione'] . '</td>
                        <td>' . $competenza['indicatori'] . '</td>
                    </tr>
                </table>
                <br/><br/><br/>';


        return $html;
    }

}
