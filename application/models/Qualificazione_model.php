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
 * Unità di Competenza (Abilità e Conscenze), A.D.A., Referenziazioni CP, ATECO e Standard Formativi 
 * per la generazione della scheda in pdf/xml/json
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

    public function list_profilo_standard_formativo($id)
    {
        $this->db->from('rrtq_standard_formativo');
        $this->db->where('id_profilo', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_standard_formativo_uf($id)
    {
        $this->db->from('v_rrtq_standard_formativo_uf');
        $this->db->where('id_standard_formativo', $id);
        $this->db->order_by('sequenza', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_standard_formativo_moduli($id)
    {
        $this->db->from('rrtq_standard_formativo_mod');
        $this->db->where('id_standard_formativo', $id);
        $this->db->order_by('sequenza', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_standard_formativo_isced($id)
    {
        $this->db->from('rrtq_standard_formativo_isced');
        $this->db->join('rrtq_isced', 'rrtq_standard_formativo_isced.id_isced = rrtq_isced.id_isced');
        $this->db->where('id_standard_formativo', $id);
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
            $data["profilo"]["competenze"][$i]["cp2011"] = $this->list_competenza_cp2011($id_competenza);
            $i++;
        }
        /* STANDARD FORMATIVI */
        $standard_formativi = $this->list_profilo_standard_formativo($id);
        $j = 0;
        foreach ($standard_formativi as $standard_formativo)
        {
            $id_standard_formativo = $standard_formativo["id_standard_formativo"];
            $data["profilo"]["standard_formativo"][$j] = $standard_formativo;
            $data["profilo"]["standard_formativo"][$j]["uf"] = $this->list_standard_formativo_uf($id_standard_formativo);
            $data["profilo"]["standard_formativo"][$j]["moduli"] = $this->list_standard_formativo_moduli($id_standard_formativo);
            $data["profilo"]["standard_formativo"][$j]["isced"] = $this->list_standard_formativo_isced($id_standard_formativo);
            $j++;
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
            $this->db->delete('rrtq_profilo_ada');

            /* ISCED - SELEZIONO GLI ID SF DA ELIMINARE */
            $this->db->select("id_standard_formativo");
            $this->db->from('rrtq_standard_formativo');
            $this->db->where('id_profilo', $id);
            $query = $this->db->get();
            $del_id = $query->result_array();
            
            foreach ($del_id as $value)
            {
                $this->db->where('id_standard_formativo', $value['id_standard_formativo']);
                $this->db->delete('rrtq_standard_formativo_isced');
            }            
            /*FINE ISCED */
            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_standard_formativo_mod');
            
            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_standard_formativo_uf');
            
            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_standard_formativo');

            $this->db->where('id_profilo', $id);
            $this->db->delete('rrtq_profilo_competenza');            
            
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
            return "<h1>Nessuna versione precedente disponibile al confronto</h1>";
        }
        $dopo = $this->select_qualificazione($id);

        // HEADER OUTPUT
        $htmlconDifferenze = "
            <style> 
                ins {color: #333333;background-color: #41ff32; text-decoration: none;}
                del {color: #AA3333;background-color: #ffeaea;text-decoration: line-through;}
                h2, h3  {display:inline; padding: 0px;margin: 0px;}
            </style>
            <center><i>Diff-Check effettuato il " . date('d/m/Y H:i') . "<i><br/><a href='javascript:window.print();'>Stampa</a></center><br><br>";

        //SALVO LE COMPETENZE IN VARIABILI PER LAVORARLE A PARTE
        $competenze_prima = $prima['profilo']['competenze'];
        $competenze_dopo = $dopo['profilo']['competenze'];
        //LE RIMUOVO DALL'ARRAY PRINCIPALE
        unset($prima['profilo']['competenze']);
        unset($dopo['profilo']['competenze']);

        //SALVO GLI STANDARD FORMATIVI IN VARIABILI PER LAVORARLE A PARTE
        if (isset($prima['profilo']['standard_formativo']))
        {
            $standard_formativi_prima = $prima['profilo']['standard_formativo'];
            unset($prima['profilo']['standard_formativo']);
        }
        else
        {
            $standard_formativi_prima = array();
        }
        if (isset($dopo['profilo']['standard_formativo']))
        {
            $standard_formativi_dopo = $dopo['profilo']['standard_formativo'];
            //LI RIMUOVO DALL'ARRAY PRINCIPALE
            unset($dopo['profilo']['standard_formativo']);
        }
        else
        {
            $standard_formativi_dopo = array();
        }

        /* CREA I 2 HTML PROFILO */
        $html_profilo_prima = $this->profiloToHTML($prima);
        $html_profilo_dopo = $this->profiloToHTML($dopo);
        $htmlconDifferenze .= $this->diffHTML($html_profilo_prima, $html_profilo_dopo);
        /* COMPARA UC */
        $htmlconDifferenze .= $this->compare($competenze_prima, $competenze_dopo, 'id_competenza', 'competenzaToHTML');
        /* COMPARA STANDARD FORMATIVI */
        $htmlconDifferenze .= $this->compare($standard_formativi_prima, $standard_formativi_dopo, 'id_standard_formativo', 'standardFormativoToHTML');

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

    private function compare($array_prima, $array_dopo, $id_compare, $methodToHTML)
    {
        /* INIZIO GENERAZIONE HTML COMPETENZE */
        $htmlconDifferenze = "";
        
        if (count($array_prima) > 0)
        {
            foreach ($array_prima as $key_prima => $object_prima)
            {
                $html_object_prima = "";
                $html_object_dopo = "";
                $trovato = false;
                $id_prima = $object_prima[$id_compare];

                foreach ($array_dopo as $key_dopo => $object_dopo)
                {
                    $id_dopo = $object_dopo[$id_compare];

                    if ($id_prima == $id_dopo)
                    {
                        $trovato = true;
                        break;
                    }
                }

                if ($trovato)
                {
                    /* CREA I 2 HTML COMPETENZE E LI CONFRONTA */

                    $html_object_prima = call_user_func_array(array($this, $methodToHTML), array($array_prima[$key_prima]));
                    $html_object_dopo = call_user_func_array(array($this, $methodToHTML), array($array_dopo[$key_dopo]));
                    $htmlconDifferenze .= $this->diffHTML($html_object_prima, $html_object_dopo);
                    if ($methodToHTML == "standardFormativoToHTML")
                    {
                        $htmlconDifferenze .= $this->compare($array_prima[$key_prima]['uf'], $array_dopo[$key_dopo]['uf'], 'id_unita_formativa', 'unitaFormativaToHTML');
                        $htmlconDifferenze .= $this->compare($array_prima[$key_prima]['moduli'], $array_dopo[$key_dopo]['moduli'], 'id_modulo', 'moduloToHTML');
                    }
                    unset($array_dopo[$key_dopo]);
                }
                else
                {
                    $html_object_prima = call_user_func_array(array($this, $methodToHTML), array($array_prima[$key_prima]));
                    $htmlconDifferenze .= $this->diffHTML($html_object_prima, NULL);
                    if ($methodToHTML == "standardFormativoToHTML")
                    {
                        $htmlconDifferenze .= $this->compare($array_prima[$key_prima]['uf'], NULL, 'id_unita_formativa', 'unitaFormativaToHTML');
                        $htmlconDifferenze .= $this->compare($array_prima[$key_prima]['moduli'], NULL, 'id_modulo', 'moduloToHTML');
                    }
                }
            }
        }
        if (count($array_dopo) > 0)
        {
            foreach ($array_dopo as $new_object)
            {
                $html_object_dopo = call_user_func_array(array($this, $methodToHTML), array($new_object));
                $htmlconDifferenze .= $this->diffHTML(NULL, $html_object_dopo);
                if ($methodToHTML == "standardFormativoToHTML")
                {
                    $htmlconDifferenze .= $this->compare(NULL, $new_object['uf'], 'id_unita_formativa', 'unitaFormativaToHTML');
                    $htmlconDifferenze .= $this->compare(NULL, $new_object['moduli'], 'id_modulo', 'moduloToHTML');
                }
            }
        }

        return $htmlconDifferenze;
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
                <tr style="background-color:#A8E1F0;">
                    <td colspan="2" align="center"><small><b>Titolo qualificazione</b></small><br/><h2>' . $profilo['titolo_profilo'] . '</h2></td>
                </tr>    
                <tr>
                    <td width="15%"><b>Settore Economico Professionale</b></td>
                    <td width="85%">' . $profilo['descrizione_sep'] . '</td>
                </tr>   
                <tr>
                    <td><b>Area di Attivit&agrave;</b></td>
                    <td>' . $str_profilo_ada . '</td>
                </tr>                  
                <tr>
                    <td><b>Processo</b></td>
                    <td>' . $str_profilo_processo . '</td>
                </tr>
                <tr>
                    <td><b>Sequenza di processo</b></td>
                    <td>' . $str_profilo_seq_processo . '</td>
                </tr>  
                <tr>
                    <td><b>Descrizione qualificazione</b></td>
                    <td>' . $profilo['descrizione_profilo'] . '</td>
                </tr> 
                <tr>
                    <td><b>Livello EQF</b></td>
                    <td>' . $profilo['livello_eqf'] . '</td>
                </tr>    
                <tr>
                    <td><b>Referenziazione ATECO 2007</b></td>
                    <td>' . $str_profilo_ateco2007 . '</td>
                </tr>                 
                <tr>
                    <td><b>Referenziazione CP 2011</b></td>
                    <td>' . $str_profilo_cp2011 . '</td>                  
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

        //cp_2011
        $str_competenza_cp2011 = "";

        if (array_key_exists('cp2011',$competenza))
        {
            $competenza_cp2011 = $competenza['cp2011'];        
            foreach ($competenza_cp2011 as $item)
            {
                $str_competenza_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
            }
        }

        $html .= '
                <table border="1"  cellpadding="4" style="border-collapse: collapse;" width="100%">
                    <tr style="background-color:#A8E1F0;">
                        <td colspan="4" align="center"><small><b>Competenza</b></small><br/><h3>' . $competenza['titolo_competenza'] . '</h3></td>
                    </tr>    
                    <tr>
                        <td width="15%"><b>Risultato atteso</b></td>
                        <td width="85%" colspan="3">' . $competenza['risultato_competenza'] . '</td>
                    </tr>                     
                    <tr>
                        <td><b>Oggetto di osservazione</b></td>
                        <td colspan="3">' . $competenza['oggetto_di_osservazione'] . '</td>
                    </tr>  
                    <tr>
                        <td ><b>Indicatori</b></td>
                        <td colspan="3">' . $competenza['indicatori'] . '</td>
                    </tr>     
                    <tr>
                        <td><b>Livello EQF</b></td>
                        <td colspan="3">' . $competenza['livello_eqf'] . '</td>
                    </tr>      
                    <tr>
                        <td><b>Referenziazione CP 2011</b></td>
                        <td colspan="3">' . $str_competenza_cp2011 . '</td>
                    </tr>
                    <tr style="background-color:#D9D9D9;">
                        <td align="center" width="50%" colspan="2"><b>Abilit&agrave;</b></td>
                        <td align="center" width="50%" colspan="2"><b>Conoscenze</b></td>
                    </tr>     
                    <tr>
                        <td colspan="2">
                        <ul>
                            ' . $str_abilita . '
                        </ul>
                        </td>
                        <td colspan="2">
                            <ul>
                             ' . $str_conoscenze . '                         
                            </ul>
                        </td>
                    </tr>
                </table>
                <br/><br/><br/>';

        return $html;
    }

    private function standardFormativoToHTML($standard_formativo)
    {
        $codici_isced = $standard_formativo["isced"];
        $str_codici_isced = "";
        if (!empty($codici_isced))
        {
            foreach ($codici_isced as $item)
            {
                $str_codici_isced .= $item['des_isced'] . "<br/>";
            }
        }

        $html = "<br/><br/><br/><br/>";
        $html .= '
            <table border="1" cellpadding="4" style="border-collapse: collapse;" width="100%">
                <tr style="background-color:#F5D672;">
                    <td colspan="2" align="center"><small><b>Denominazione Standard Formativo</b></small><br/><h2>' . $standard_formativo['des_standard_formativo'] . '</h2></td>
                </tr>    
                <tr>
                    <td width="15%"><b>Requisiti minimi di ingresso dei partecipanti</b></td>
                    <td width="85%">' . $standard_formativo['req_min_didattici'] . '</td>
                </tr>   
                <tr>
                    <td><b>Requisiti minimi didattici comuni a tutte le UF/segmenti</b></td>
                    <td>' . $standard_formativo['req_min_partecipanti'] . '</td>
                </tr>                  
                <tr>
                    <td><b>Requisiti minimi di risorse professionali e strumentali</b></td>
                    <td>' . $standard_formativo['req_min_risorse'] . '</td>
                </tr>
                <tr>
                    <td><b>Requisiti minimi di valutazione e di attestazione degli apprendimenti</b></td>
                    <td>' . $standard_formativo['req_min_valutazione'] . '</td>
                </tr>  
                <tr>
                    <td><b>Codice ISCED-F 2013</b></td>
                    <td>' . $str_codici_isced . '</td>
                </tr>                
                <tr>
                    <td><b>Gestione dei crediti formativi</b></td>
                    <td>' . $standard_formativo['req_crediti_formativi'] . '</td>
                </tr> 
                <tr>
                    <td><b>Eventuali ulteriori indicazioni</b></td>
                    <td>' . $standard_formativo['altre_indicazioni'] . '</td>
                </tr>    
                <tr>
                    <td><b>Composizione Standard Formativo</b></td>
                    <td>' . ($standard_formativo['flg_uf_modulo'] == 1 ? 'Moduli' : 'Unità Formative') . '</td>
                </tr>  
                <tr>
                    <td><b>Durata minima complessiva del percorso (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_durata_percorso'] . '</td>
                </tr>
                <tr>
                    <td><b>Durata minima di aula e laboratorio (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_aula_lab'] . '</td>
                </tr>  
                <tr>
                    <td><b>Durata minima tirocinio in impresa (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_tirocinio'] . '</td>
                </tr>                
                <tr>
                    <td><b>Durata minima delle attività di aula e laboratorio rivolte alle KC (ore)</b></td>
                    <td>' . $standard_formativo['ore_min_aula_lab_kc'] . '</td>
                </tr> 
                <tr>
                    <td><b>Percentuale massima di FaD sulla durata minima di aula e laboratorio</b></td>
                    <td>' . $standard_formativo['perc_fad_aula_lab'] . '</td>
                </tr> 
            </table>
            <br/><br/>';
        return $html;
    }

    private function unitaFormativaToHTML($unita_formativa)
    {
        $html = '
                <table border="1"  cellpadding="4" style="border-collapse: collapse;" width="100%">
                    <tr style="background-color:#F5D672;">
                        <td colspan="4" align="center"><small><b>Unità Formativa</b></small><br/><h3>' . $unita_formativa['titolo_unita_formativa'] . '</h3></td>
                    </tr>    
                    <tr>
                        <td width="15%"><b>Vincoli (eventuali)</b></td>
                        <td width="85%" colspan="3">' . $unita_formativa['des_eventuali_vincoli'] . '</td>
                    </tr>                     
                    <tr>
                        <td><b>Durata minima (ore)</b></td>
                        <td><b>Percentuale variazione</b></td>
                        <td><b>Percentuale massima di FaD</b></td>
                        <td><b>Sequenza</b></td>
                    </tr>  
                    <tr>
                        <td>' . $unita_formativa['ore_min_durata_uf'] . '</td>
                        <td>' . $unita_formativa['perc_varianza'] . '</td>
                        <td>' . $unita_formativa['perc_fad_uf'] . '</td>
                        <td>' . $unita_formativa['sequenza'] . '</td>
                    </tr>                        
                </table>
                <br/><br/>';

        return $html;
    }

    private function moduloToHtml($modulo)
    {
        $html = '
              <table border="1"  cellpadding="4" style="border-collapse: collapse;" width="100%">
                  <tr style="background-color:#F5D672;">
                      <td colspan="4" align="center"><small><b>Moduli</b></small><br/><h3>' . $modulo['titolo_modulo'] . '</h3></td>
                  </tr>  
                  <tr>
                      <td width="15%"><b>Conoscenze/contenuti</b></td>
                      <td width="85%" colspan="3">' . $modulo['des_contenuti'] . '</td>
                  </tr>                     
                  <tr>
                      <td width="15%"><b>Vincoli (eventuali)</b></td>
                      <td width="85%" colspan="3">' . $modulo['des_eventuali_vincoli'] . '</td>
                  </tr>                     
                  <tr>
                      <td><b>Durata minima (ore)</b></td>
                      <td><b>Percentuale massima di FaD</b></td>
                      <td colspan="2"><b>Sequenza</b></td>
                  </tr>  
                  <tr>
                      <td>' . $modulo['ore_min_durata_mod'] . '</td>
                      <td>' . $modulo['perc_fad_mod'] . '</td>
                      <td colspan="2">' . $modulo['sequenza'] . '</td>                      
                  </tr>                        
              </table>
              <br/><br/>';

        return $html;
    }

}
