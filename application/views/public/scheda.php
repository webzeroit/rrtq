
<div class="row">
    <div class="col-12">
        <div class="ribbon-wrapper card">
            <div class="card-body">
                <div class="ribbon ribbon-bookmark ribbon-right ribbon-info">Qualificazione professionale</div>
                <h3 class="card-title text-center m-b-20"><?php echo  $profilo['titolo_profilo']; ?></h3>
                <table class="table table-no-bordered">
                    <tbody>
                        <tr>
                            <td width="30%"><b>Livello EQF</td>
                            <td width="70%"><?php echo  $profilo['livello_eqf']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Settore Economico Professionale</b></td>
                            <td><?php echo  $profilo['codice_sep'] . " - " . $profilo['descrizione_sep'] ?></td>
                        </tr>   
                        <tr>
                            <td><b>Area di Attività</b></td>
                            <td>
                            <?php 
                            $profilo_ada = $profilo["ada"];
                            $str_profilo_ada = "";
                            foreach ($profilo_ada as $item)
                            {
                                $str_profilo_ada .= $item['codice_ada'] . " - " . $item['descrizione_ada'] . "<br/>";
                            }
                            echo  rtrim($str_profilo_ada,'<br/>');
                            ?>
                            </td>
                        </tr> 
                        <tr>
                            <td><b>Processo</b></td>
                            <td>
                            <?php 
                            $profilo_processo = $profilo["processo"];
                            $str_profilo_processo = "";
                            foreach ($profilo_processo as $item)
                            {
                                $str_profilo_processo .= $item['descrizione_processo'] . "<br/>";
                            }
                            echo  rtrim($str_profilo_processo,'<br/>');
                            ?>
                            </td>
                        </tr>                    
                        <tr>
                            <td><b>Sequenza di processo</b></td>
                            <td>
                            <?php 
                            $profilo_seq_processo = $profilo["seq_processo"];
                            $str_profilo_seq_processo = "";
                            foreach ($profilo_seq_processo as $item)
                            {
                                $str_profilo_seq_processo .= $item['descrizione_sequenza'] . "<br/>";
                            }
                            echo  rtrim($str_profilo_seq_processo,'<br/>');
                            ?>
                            </td>
                        </tr>   
                        <tr>
                            <td><b>Descrizione sintetica della qualificazione</b></td>
                            <td><?php echo $profilo['descrizione_profilo'] ?></td>
                        </tr>  
                        <tr>
                            <td><b>Referenziazione ATECO 2007</b></td>
                            <td>
                                <?php 
                                $profilo_ateco2007 = $profilo["ateco2007"];
                                $str_profilo_ateco2007 = "";
                                foreach ($profilo_ateco2007 as $item)
                                {
                                    $str_profilo_ateco2007 .= $item['codice_ateco'] . " - " . $item['descrizione_ateco'] . "<br/>";
                                }
                                echo rtrim($str_profilo_ateco2007,'<br/>')
                                ?>
                            </td>
                        </tr>      
                        <tr>
                            <td><b>Referenziazione ISTAT CP2011</b></td>
                            <td>
                                <?php 
                                $profilo_cp2011 = $profilo["cp2011"];
                                $str_profilo_cp2011 = "";
                                foreach ($profilo_cp2011 as $item)
                                {
                                    $str_profilo_cp2011 .= $item['codice_cp2011'] . " - " . $item['descrizione_cp2011'] . "<br/>";
                                }
                                echo rtrim($str_profilo_cp2011,'<br/>') 
                                ?>
                            </td>
                        </tr> 
                        <?php if (intval($profilo['flg_regolamentato']) > 0) { ?>
                        <tr>
                            <td><b>Regolamentata</b></td>
                            <td>SI</td>
                        </tr> 
                        <?php }  ?>                        
                        <tr>
                            <td><b>Scheda qualificazione PDF</b></td>
                            <td><a href="<?php echo base_url() . 'public/stampa/sp/' . $profilo["id_profilo"] ?>" target="_blank">
                                <img src="<?php echo base_url(); ?>assets/images/icon/pdf.png" alt="Scarica" class="light-logo" /></a>
                            </td>
                        </tr>                         
                    </tbody>
                </table>
            
                <hr>
                <h4 class="card-title text-center m-t-40 m-b-20">Elenco Unità di Competenza (UC)</h4>
                
                <?php  
                    $profilo_competenza = $profilo["competenze"];
                    $prog_competenza = 1;
                    $num_competenze = count($profilo_competenza);
                    foreach ($profilo_competenza as $competenza)
                    {
                        
                        $competenza_abilita = $competenza['abilita'];
                        $str_abilita = "";
                        foreach ($competenza_abilita as $item)
                        {
                            $str_abilita .= "<li><i class='fa fa-chevron-right'></i> " . $item['descrizione_abilita'] . "</li>";
                        }
                        $competenza_conoscenza = $competenza['conoscenza'];
                        $str_conoscenze = "";
                        foreach ($competenza_conoscenza as $item)
                        {
                            $str_conoscenze .= "<li><i class='fa fa-chevron-right'></i> " . $item['descrizione_conoscenza'] . "</li>";
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
                        $id_accordion = "accordionUc" . $prog_competenza;
                        $id_heading = "headingUc" . $prog_competenza;
                        $id_collapse = "uc" . $prog_competenza;
                ?>
                
                    <div id="<?php echo $id_accordion ?>" role="tablist" aria-multiselectable="true">

                        <div class="card m-b-0">
                            <div class="card-header" role="tab" id="<?php echo $id_heading ?>">
                                <h5 class="mb-0">
                                <a class="link" data-toggle="collapse" data-parent="#<?php echo $id_accordion ?>" href="#<?php echo $id_collapse ?>" aria-expanded="true" aria-controls="collapseOne">
                                   <?php echo $competenza["titolo_competenza"] ?>
                                </a>
                              </h5>
                            </div>
                            <div id="<?php echo $id_collapse ?>" class="collapse" role="tabpanel" aria-labelledby="<?php echo $id_heading ?>">
                                <div class="card-body">
                                    <table class="table table-no-bordered">
                                        <tbody>
                                            <tr>
                                                <td width="25%"><b>Codice</b></td>
                                                <td width="75%"><?php echo $competenza["id_competenza"] ?></td>
                                            </tr>                                            
                                            <tr>
                                                <td><b>Risultato atteso</b></td>
                                                <td><?php echo $competenza["risultato_competenza"] ?></td>
                                            </tr>      
                                            <tr>
                                                <td><b>Oggetto di osservazione</b></td>
                                                <td><?php echo  $competenza["oggetto_di_osservazione"] ?></td>
                                            </tr>  
                                            <tr>
                                                <td><b>Indicatori</b></td>
                                                <td><?php echo  $competenza["indicatori"] ?></td>
                                            </tr>                                            
                                            <tr>
                                                <td ><b>Livello EQF</td>
                                                <td><?php echo $competenza['livello_eqf']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Abilit&agrave;</b></td>
                                                <td><ul class="list-icons"><?php echo $str_abilita ?></ul></td>
                                            </tr> 
                                            <tr>
                                                <td><b>Conoscenze</b></td>
                                                <td><ul class="list-icons"><?php echo $str_conoscenze ?></ul></td>
                                            </tr> 
                                            <tr>
                                                <td><b>Referenziazione ISTAT CP2011</b></td>
                                                <td><?php echo rtrim($str_competenza_cp2011,'<br/>') ?></td>
                                            </tr>                                              
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php  
                        $prog_competenza++;
                    } 
                ?>  
                <div class="text-right m-t-40">
                    <a href="<?php echo base_url(); ?>" id="btn_back" class="btn btn-inverse btn-xs">Torna alla ricerca</a>
                </div> 
            </div>
        </div>
    </div>
</div>    

<?php
if (array_key_exists('standard_formativo', $profilo))
{
    $standard_formativi_profilo = $profilo['standard_formativo'];
    foreach ($standard_formativi_profilo as $standard_formativo)
    {
        //ISCED-F
        $standard_formativo_isced = $standard_formativo["isced"];
        $str_standard_formativo_isced = "";
        foreach ($standard_formativo_isced as $item)
        {
            $str_standard_formativo_isced .= $item['des_isced'] . "<br/>";
        }
        
        
        ?>
        <div class="row">
            <div class="col-12">
                <div class="ribbon-wrapper card">
                    <div class="card-body">
                        <div class="ribbon ribbon-bookmark ribbon-right ribbon-warning">Standard Formativo</div>
                        <h3 class="card-title text-center m-b-20"><?php echo $standard_formativo['des_standard_formativo']; ?></h3>
                        <table class="table table-no-bordered">
                            <tbody>
                                <tr>
                                    <td width="30%"><b>Livello EQF</td>
                                    <td width="70%"><?php echo $profilo['livello_eqf']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Durata minima complessiva del percorso (ore)</b></td>
                                    <td><?php echo $standard_formativo['ore_min_durata_percorso']; ?></td>
                                </tr>  
                                <tr>
                                    <td><b>Durata minima di aula e laboratorio (ore)</b></td>
                                    <td><?php echo $standard_formativo['ore_min_aula_lab']; ?></td>
                                </tr> 
                                <tr>
                                    <td><b>Percentuale massima di FaD sulla durata minima di aula e laboratorio</b></td>
                                    <td><?php echo $standard_formativo['perc_fad_aula_lab']; ?>%</td>
                                </tr>                 
                                <tr>
                                    <td><b>Durata minima tirocinio in impresa (ore)</b></td>
                                    <td><?php echo $standard_formativo['ore_min_tirocinio']; ?></td>
                                </tr>                   
                                <tr>
                                    <td><b>Durata minima delle attività di aula e laboratorio rivolte alle KC (ore)</b></td>
                                    <td><?php echo $standard_formativo['ore_min_aula_lab_kc']; ?></td>
                                </tr>
                                <?php 
                                if (array_key_exists('perc_fad_aula_lab_kc', $standard_formativo)){
                                    if (intval($standard_formativo['ore_min_aula_lab_kc']) > 0)
                                    { ?>
                                    <tr>
                                        <td><b>Percentuale massima di FaD sulla durata delle attività rivolte alle KC</b></td>
                                        <td><?php echo $standard_formativo['perc_fad_aula_lab_kc']; ?>%</td>
                                    </tr>                                
                                <?php
                                    }
                                } ?>
                                <tr>
                                    <td><b>Requisiti minimi di ingresso dei partecipanti</b></td>
                                    <td><?php echo $standard_formativo['req_min_partecipanti'] ?></td>
                                </tr>   
                                <tr>
                                    <td><b>Requisiti minimi didattici comuni a tutte le UF/segmenti</b></td>
                                    <td><?php echo $standard_formativo['req_min_didattici'] ?></td>
                                </tr>  
                                <tr>
                                    <td><b>Requisiti minimi di risorse professionali e strumentali</b></td>
                                    <td><?php echo $standard_formativo['req_min_risorse'] ?></td>
                                </tr>   
                                <tr>
                                    <td><b>Requisiti minimi di valutazione e di attestazione degli apprendimenti</b></td>
                                    <td><?php echo $standard_formativo['req_min_valutazione'] ?></td>
                                </tr> 
                                <tr>
                                    <td><b>Gestione dei crediti formativi</b></td>
                                    <td><?php echo $standard_formativo['req_crediti_formativi'] ?></td>
                                </tr>    
                                <tr>
                                    <td><b>Eventuali ulteriori indicazioni</b></td>
                                    <td><?php echo $standard_formativo['altre_indicazioni'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>Codice ISCED-F 2013</b></td>
                                    <td><?php echo rtrim($str_standard_formativo_isced,'<br/>') ?></td>
                                </tr>                                    
                                <tr>
                                    <td><b>Scheda standard formativo PDF</b></td>
                                    <td><a href="<?php echo base_url() . 'public/stampa/sf/' . $standard_formativo["id_standard_formativo"] ?>" target="_blank">
                                        <img src="<?php echo base_url(); ?>assets/images/icon/pdf.png" alt="Scarica" class="light-logo" /></a>
                                    </td>
                                </tr>                                    
                            </tbody>
                        </table>  
                        <hr>
                        <!-- STAMPA DETTAGLIO UF -->
                        <?php 
                            if ($standard_formativo['flg_uf_modulo'] === "0") 
                            { 
                                $standard_formativo_uf = $standard_formativo["uf"];   
                                $prog_uf = 1;
                                $num_uf = count($standard_formativo_uf);
                                ?>
                                
                                <h4 class="card-title text-center m-t-40">Elenco Unità Formative (UF)</h4>    
                        
                                <?php  
                                foreach ($standard_formativo_uf as $uf)
                                {                                    
                                    $uc = NULL;
                                    //Individuo la UC collegata alla UF
                                    foreach ($profilo_competenza as $key => $value)
                                    {
                                        if ($value['id_competenza'] === $uf['id_competenza']){
                                           $uc = $profilo_competenza[$key];
                                           //echo "Posizione " . $key . " ha ID " . $value['id_competenza'] . " la UC corrente ha ID " .$uf['id_competenza'] . "<br/>";
                                           break;
                                        }
                                    }
                                    $competenza_abilita = $uc['abilita'];
                                    $str_abilita = "";
                                    foreach ($competenza_abilita as $item)
                                    {
                                        $str_abilita .= "<li><i class='fa fa-chevron-right'></i> " . $item['descrizione_abilita'] . "</li>";
                                    }
                                    $competenza_conoscenza = $uc['conoscenza'];
                                    $str_conoscenze = "";
                                    foreach ($competenza_conoscenza as $item)
                                    {
                                        $str_conoscenze .= "<li><i class='fa fa-chevron-right'></i> " . $item['descrizione_conoscenza'] . "</li>";
                                    }
                                    
                                    $id_accordion = "accordionUf" . $prog_uf;
                                    $id_heading = "headingUf" . $prog_uf;
                                    $id_collapse = "uf" . $prog_uf;
                                ?>
                                    <div id="<?php echo $id_accordion ?>" role="tablist" aria-multiselectable="true">

                                        <div class="card m-b-0">
                                            <div class="card-header" role="tab" id="<?php echo $id_heading ?>">
                                                <h5 class="mb-0">
                                                <a class="link" data-toggle="collapse" data-parent="#<?php echo $id_accordion ?>" href="#<?php echo $id_collapse ?>" aria-expanded="true" aria-controls="collapseOne">
                                                   <?php echo $uf["titolo_unita_formativa"] ?>
                                                </a>
                                              </h5>
                                            </div>
                                            <div id="<?php echo $id_collapse ?>" class="collapse" role="tabpanel" aria-labelledby="<?php echo $id_heading ?>">
                                                <div class="card-body">
                                                    <table class="table table-no-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td width="25%"><b>Codice</b></td>
                                                                <td width="75%"><?php echo $uf['id_unita_formativa'] ?></td>
                                                            </tr>                                            
                                                            <tr>
                                                                <td><b>Livello EQF</b></td>
                                                                <td><?php echo $uc["livello_eqf"] ?></td>
                                                            </tr>      
                                                            <tr>
                                                                <td><b>Denominazione UC correlata</b></td>
                                                                <td><?php echo  $uc["titolo_competenza"] . " (" . $uc["id_competenza"] . ")" ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Risultato atteso</b></td>
                                                                <td><?php echo  $uc["risultato_competenza"] ?></td>
                                                            </tr>                                                            
                                                            <tr>
                                                                <td><b>Abilit&agrave;</b></td>
                                                                <td><ul class="list-icons"><?php echo $str_abilita ?></ul></td>
                                                            </tr> 
                                                            <tr>
                                                                <td><b>Conoscenze</b></td>
                                                                <td><ul class="list-icons"><?php echo $str_conoscenze ?></ul></td>
                                                            </tr>                                                           
                                                            <tr>
                                                                <td><b>Durata minima (ore)</b></td>
                                                                <td><?php echo  $uf["ore_min_durata_uf"] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td ><b>Percentuale di variazione massima consentita in aumento e/o diminuzione della durata minima dell'UF</td>
                                                                <td><?php echo $uf["perc_varianza"] ?>%</td>
                                                            </tr>                                                             
                                                            <tr>
                                                                <td ><b>Percentuale massima di FaD</td>
                                                                <td><?php echo $uf["perc_fad_uf"] ?>%</td>
                                                            </tr>                                                                                                     
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                                                                                        
                                    
                                <?php
                                    $prog_uf++;
                                } 
                            } 
                        ?>
                        
                        
                        
                        <!-- STAMPA DETTAGLIO MODULI -->
                        <?php 
                            if ($standard_formativo['flg_uf_modulo'] === "1") 
                            { 
                                $standard_formativo_mod = $standard_formativo["moduli"];                          
                                $prog_mod = 1;
                                $num_mod = count($standard_formativo_mod);
                                ?> 
                                
                                <h4 class="card-title text-center m-t-40 m-b-20">Elenco Moduli (UF)</h4> 
                                
                                <?php     
                                
                                foreach ($standard_formativo_mod as $modulo)
                                {
                                    $id_accordion = "accordionMod" . $prog_mod;
                                    $id_heading = "headingMod" . $prog_mod;
                                    $id_collapse = "mod" . $prog_mod;
                                ?>
                                    <div id="<?php echo $id_accordion ?>" role="tablist" aria-multiselectable="true">

                                        <div class="card m-b-0">
                                            <div class="card-header" role="tab" id="<?php echo $id_heading ?>">
                                                <h5 class="mb-0">
                                                <a class="link" data-toggle="collapse" data-parent="#<?php echo $id_accordion ?>" href="#<?php echo $id_collapse ?>" aria-expanded="true" aria-controls="collapseOne">
                                                   <?php echo $modulo["titolo_modulo"] ?>
                                                </a>
                                              </h5>
                                            </div>
                                            <div id="<?php echo $id_collapse ?>" class="collapse" role="tabpanel" aria-labelledby="<?php echo $id_heading ?>">
                                                <div class="card-body">
                                                    <table class="table table-no-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td width="25%"><b>Codice</b></td>
                                                                <td width="75%"><?php echo $modulo["id_modulo"] ?></td>
                                                            </tr>                                            
                                                            <tr>
                                                                <td><b>Conoscenze/contenuti</b></td>
                                                                <td><?php echo $modulo["des_contenuti"] ?></td>
                                                            </tr>      
                                                            <tr>
                                                                <td><b>Vincoli (eventuali)</b></td>
                                                                <td><?php echo  $modulo["des_eventuali_vincoli"] ?></td>
                                                            </tr>  
                                                            <tr>
                                                                <td><b>Durata minima (ore)</b></td>
                                                                <td><?php echo  $modulo["ore_min_durata_mod"] ?></td>
                                                            </tr>                                            
                                                            <tr>
                                                                <td ><b>Percentuale massima di FaD</td>
                                                                <td><?php echo $modulo["perc_fad_mod"] ?>%</td>
                                                            </tr>                                                                                                     
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                <?php    
                                    $prog_mod++;
                                }        
                            } 
                        ?>
                        <div class="text-right m-t-40">
                            <a href="<?php echo base_url(); ?>" id="btn_back" class="btn btn-inverse btn-xs">Torna alla ricerca</a>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div class="row" style="display:none;">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <code><pre><?php print_r($profilo, FALSE); ?></pre></code>
            </div>
        </div>
    </div>
</div>