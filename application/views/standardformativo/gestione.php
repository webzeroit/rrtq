<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">        
                <h4 class="card-title">Informazioni generali</h4>
                <h6 class="card-subtitle">Inserire e/o selezionare tutte le informazioni richieste per la corretta identificazione dello Standard Formativo</h6>
                <form class="m-t-40" id="frm_dati_standard_formativo" autocomplete="off">                    
                    <div class="form-group">
                        <h5>Titolo qualificazione</h5>
                        <div class="controls">
                            <input type="text" id="titolo_profilo" name="titolo_profilo" class="form-control" readonly="readonly"
                                   value="<?php echo set_value('titolo_profilo', $profilo['titolo_profilo']); ?>"> 
                        </div>
                        <div class="form-control-feedback"> <small><i><a href="<?php echo base_url() . 'admin/qualificazione/gestione/' . $id_profilo  ?>">Clicca</a> per gestire la qualificazione</i> </small> </div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <h5>Settore Economico Professionale</h5>
                                <div class="controls">
                                    <input type="text" id="descrizione_sep" name="descrizione_sep" class="form-control" readonly="readonly"
                                           value="<?php echo set_value('descrizione_sep', $profilo['descrizione_sep']); ?>"> 
                                </div>
                            </div>     
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <h5>Livello EQF</h5>
                                <input type="text" name="livello_eqf" class="form-control" readonly="readonly"
                                       value="<?php echo set_value('livello_eqf', $profilo['livello_eqf']); ?>">
                            </div>                            
                        </div>
                    </div>
                    <!-- TEXT AREA -->
                    <div class="form-group">
                        <h5>Denominazione Standard Formativo <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" id="des_standard_formativo" name="des_standard_formativo" maxlength="255" class="form-control"
                                   value="<?php echo set_value('des_standard_formativo', $standard_formativo['des_standard_formativo']); ?>"> 
                        </div>
                        <div class="form-control-feedback"> <small><i><a href="#" id="copyQ">Clicca</a> per copiare il titolo della qualificazione</i> </small> </div>
                    </div>    

                    <div class="form-group">
                        <h5>Requisiti minimi di ingresso dei partecipanti <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="req_min_partecipanti" name="req_min_partecipanti" rows="8" maxlength="4000" class="form-control"><?php echo set_value('req_min_partecipanti', $standard_formativo['req_min_partecipanti']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>

                    <div class="form-group">
                        <h5>Requisiti minimi didattici comuni a tutte le UF/segmenti <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="req_min_didattici" name="req_min_didattici" rows="5" maxlength="4000" class="form-control"><?php echo set_value('req_min_didattici', $standard_formativo['req_min_didattici']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>                   

                    <div class="form-group">
                        <h5>Requisiti minimi di risorse professionali e strumentali <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="req_min_risorse" name="req_min_risorse" rows="5" maxlength="4000" class="form-control"><?php echo set_value('req_min_risorse', $standard_formativo['req_min_risorse']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>                     

                    <div class="form-group">
                        <h5>Requisiti minimi di valutazione e di attestazione degli apprendimenti <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="req_min_valutazione" name="req_min_valutazione" rows="5" maxlength="4000" class="form-control"><?php echo set_value('req_min_valutazione', $standard_formativo['req_min_valutazione']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>        
                    
                    <!-- ISCED-F 2013 -->
                    <div class="form-group">
                        <h5>Codice ISCED-F 2013</h5>
                        <div class="controls">
                            <select id="id_isced" name="id_isced[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_isced as $isced)
                                {
                                    ?>
                                    <option value="<?= $isced['id_isced'] ?>"><?= $isced['detailed'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="form-control-feedback"> <small><i>Consulta la tabella dei <a href="<?php echo base_url('admin/tabelle/isced'); ?>" target="_blank">Codici ISCED-F</a></i> </small> </div>
                        </div>
                    </div>  
                    
                    <div class="form-group">
                        <h5>Gestione dei crediti formativi </h5>
                        <div class="controls">
                            <textarea id="req_crediti_formativi" name="req_crediti_formativi" rows="3" maxlength="4000" class="form-control"><?php echo set_value('req_crediti_formativi', $standard_formativo['req_crediti_formativi']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>       

                    <div class="form-group">
                        <h5>Eventuali ulteriori indicazioni </h5>
                        <div class="controls">
                            <textarea id="altre_indicazioni" name="altre_indicazioni" rows="3" maxlength="4000" class="form-control"><?php echo set_value('altre_indicazioni', $standard_formativo['altre_indicazioni']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>         

                    <!-- TIPO COMPOSIZIONE -->
                    <div class="form-group">
                        <h5>Composizione Standard Formativo <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="flg_uf_modulo" name="flg_uf_modulo" class="form-control">
                                <option value="0" <?= ($standard_formativo['flg_uf_modulo'] == 0) ? 'selected' : ''; ?>>Unità Formative</option>
                                <option value="1" <?= ($standard_formativo['flg_uf_modulo'] == 1) ? 'selected' : ''; ?>>Moduli</option>
                            </select>
                        </div>
                    </div>
                    <?php  if ($action === "edit") { ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>Stato</h5>
                                    <div class="controls">
                                        <select id="id_stato_profilo" name="id_stato_profilo" class="form-control" disabled>
                                            <option value=""></option>
                                            <?php
                                            foreach ($list_stato_profilo as $stato_profilo)
                                            {
                                                ($stato_profilo['id_stato_profilo'] == $profilo['id_stato_profilo']) ? $selected = TRUE : $selected = FALSE;
                                                ?>
                                                <option <?= set_select('id_stato_profilo', $stato_profilo, $selected) ?> value="<?= $stato_profilo['id_stato_profilo'] ?>"><?= $stato_profilo['des_stato_profilo'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>                    
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h5>Data ultima modifica</h5>
                                    <div class="controls">
                                        <input type="text" id="data_ultima_modifica" name="data_ultima_modifica" class="form-control" readonly
                                               value="<?php echo set_value('data_ultima_modifica', convertsDataOraInItalianFormat($standard_formativo['data_ultima_modifica'])); ?>"> 
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    <?php } ?>       
                    <!-- INPUT NUMERICI -->
                    <br/>
                    <div class="form-group m-t-10 row">
                        <label class="control-label col-md-4">Durata minima complessiva del percorso (ore)<span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="number" id="ore_min_durata_percorso" name="ore_min_durata_percorso" class="form-control"
                                   tabindex="1" value="<?php echo set_value('ore_min_durata_percorso', $standard_formativo['ore_min_durata_percorso']); ?>"> 
                        </div>
                        <label class="control-label col-md-4">Durata minima delle attività di aula e laboratorio rivolte alle KC (ore) <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="number" id="ore_min_aula_lab_kc" name="ore_min_aula_lab_kc" class="form-control"
                                   tabindex="4" value="<?php echo set_value('ore_min_aula_lab_kc', $standard_formativo['ore_min_aula_lab_kc']); ?>">  
                        </div>                                                
                    </div>


                    <div class="form-group row">
                        <label class="control-label col-md-4">Durata minima di aula e laboratorio (ore) <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="number" id="ore_min_aula_lab" name="ore_min_aula_lab" class="form-control"
                                   tabindex="2" value="<?php echo set_value('ore_min_aula_lab', $standard_formativo['ore_min_aula_lab']); ?>"> 
                        </div>                        
                        <?php 
                            $readonly = "";
                            if ($this->config->item('lock_fad_kc')) {
                                $readonly = "readonly";
                            } 
                        ?>                                
                        <label class="control-label col-md-4">Percentuale massima di FaD sulla durata delle attività rivolte alle KC</label>
                        <div class="col-md-2">
                            <input type="number" id="perc_fad_aula_lab_kc" name="perc_fad_aula_lab_kc" class="form-control"  <?php echo $readonly; ?>
                                   tabindex="5" value="<?php echo set_value('perc_fad_aula_lab_kc', $standard_formativo['perc_fad_aula_lab_kc']); ?>"> 
                        </div>                         
                        
                    </div>      

                    <div class="form-group row">
                        <label class="control-label col-md-4">Durata minima tirocinio in impresa (ore) <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="number" id="ore_min_tirocinio" name="ore_min_tirocinio" class="form-control"
                                   tabindex="3" value="<?php echo set_value('ore_min_tirocinio', $standard_formativo['ore_min_tirocinio']); ?>">  
                        </div>    
                        <label class="control-label col-md-4">Percentuale massima di FaD sulla durata minima di aula e laboratorio <span class="text-danger">*</span></label>
                        <div class="col-md-2">
                            <input type="number" id="perc_fad_aula_lab" name="perc_fad_aula_lab" class="form-control"
                                   tabindex="6" value="<?php echo set_value('perc_fad_aula_lab', $standard_formativo['perc_fad_aula_lab']); ?>"> 
                        </div>  
                    </div>                                             
                    <?php echo form_hidden('id_profilo', $id_profilo); ?>
                    <?php echo form_hidden('id_standard_formativo', $id_standard_formativo); ?>                    
                    <?php echo form_hidden('action', $action); ?>                    
                    <div class="text-xs-right m-t-40">
                        <button type="submit" class="btn btn-info">Salva</button>                                        
                        <button type="button" id="btn_reset" class="btn btn-inverse">Indietro</button>
                    </div>                                                                             
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($action === "edit") { ?>
    <!-- FORM ADD/EDIT UF -->
    <div id="div_form_uf" class="row m-t-40">
        <div class="col-12">  
            <div class="card card-outline-warning">
                <div class="card-header">   
                    <h4 id="titolo_frm_uf" class="m-b-0 text-white">Unità Formativa</h4>
                </div>
                <div class="card-body">
                    <form class="m-t-5" id="frm_unita_formativa" name="frm_unita_formativa">
                        <div class="form-group">
                            <h5>Unità di competenza correlata <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <select id="id_competenza" name="id_competenza" class="select2 form-control custom-select" style="width: 100%; height:46px;">
                                    <option value=""></option>                                       
                                </select>
                            </div>
                            <div class="form-control-feedback"><small><i><a id="btn_dettaglio_uc" href="#" data-toggle="modal" data-target="#UcModal">Clicca</a> per visualizzare il dettaglio della UC selezionata</i></small></div>                            
                        </div>                        
                        <!-- TEXT AREA -->                                            
                        <div class="form-group">
                            <h5>Vincoli (eventuali)</h5>
                            <div class="controls">
                                <textarea id="des_eventuali_vincoli" name="des_eventuali_vincoli" rows="3" maxlength="4000" class="form-control"></textarea>
                            </div>
                            <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                        </div>                          
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="control-label col-md-12">Durata minima (ore) <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" id="ore_min_durata_uf" name="ore_min_durata_uf" class="form-control"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="control-label col-md-12">Percentuale variazione <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" id="perc_varianza" name="perc_varianza" class="form-control">  
                                    </div>  
                                    <div class="form-control-feedback col-md-12"><small><i>% di variazione consentita in aumento e/o diminuzione della durata minima dell'UF</i></small></div>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="control-label col-md-12">Percentuale massima di FaD <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" id="perc_fad_uf" name="perc_fad_uf" class="form-control">  
                                    </div>  
                                </div>
                            </div>                            
                            <div class="col-md-2">
                                <div class="form-group row">
                                    <label class="control-label col-md-12">Sequenza <span class="text-danger">*</span></label>                                   
                                    <div class="col-md-12">
                                        <input type="number" id="sequenza" name="sequenza" class="form-control">  
                                    </div>
                                    <div class="form-control-feedback col-md-12"><small><i>Sequenza di ordinamento rispetto alle altre UF</i></small></div>
                                </div>
                            </div>
                        </div>                              
                        <?php echo form_hidden('id_unita_formativa', ''); ?>
                        <?php echo form_hidden('id_profilo', $id_profilo); ?>
                        <?php echo form_hidden('id_standard_formativo', $id_standard_formativo); ?>   
                        <?php echo form_hidden('durata_fad_sf', 0); ?> 
                        <div class="form-actions m-t-20">
                            <button id="btn_salva_uf" name="btn_salva_uf" type="submit" class="btn btn-info">Salva</button>  
                            <button type="reset" id="btn_chiudi_uf" class="btn btn-inverse">Chiudi</button>   
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- TABELLA UNITA' FORMATIVE -->
    <div id="div_tabella_uf" class="row m-t-40">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Unità Formative</h4>
                    <h6 class="card-subtitle">La tabella contiene le unità formative che compongono lo standard professionale. 
                        Qualsiasi modifica alla composizione delle UF di una qualificazione <i>Pubblicata</i> o con <i>Revisioni Validate</i> ne comporterà la
                        variazione di stato <i>In Revisione</i>.</h6>            
                    <div div class="table-responsive m-t-5 m-b-40">
                        <table id="dt_uf_standard" class="table color-table info-table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>id_unita_formativa</th>
                                    <th>id_standard_formativo</th>
                                    <th>id_profilo</th>
                                    <th>id_competenza</th>                                        
                                    <th>Denominazione unità formativa</th>
                                    <th>Durata min. ore</th>
                                    <th>% Variaz. +/-</th>
                                    <th>des_eventuali_vincoli</th>
                                    <th>% FAD</th>
                                    <th>Seq.</th>
                                    <th>Azione</th> 
                                </tr>                            
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> 
                    <div class="button-group">                    
                        <button id="btn_add_uf" name="btn_add_uf" class="btn btn-info">Nuova unità formativa</button>      
                    </div>                         
                </div>
            </div>
        </div>
    </div>

    
    <!-- FORM ADD/EDIT MODULO -->
    <div id="div_form_moduli" class="row m-t-40">
        <div class="col-12">  
            <div class="card card-outline-warning">
                <div class="card-header">   
                    <h4 id="titolo_frm_modulo" class="m-b-0 text-white">Modulo</h4>
                </div>
                <div class="card-body">
                    <form class="m-t-5" id="frm_modulo" name="frm_modulo">
                        <!-- TEXT AREA -->
                        <div class="form-group">
                            <h5>Denominazione modulo <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" id="titolo_modulo" name="titolo_modulo" maxlength="255" class="form-control"> 
                            </div>
                        </div>    
                        
                        <div class="form-group">
                            <h5>Conoscenze/contenuti <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <textarea id="des_contenuti" name="des_contenuti" rows="5" maxlength="4000" class="form-control"></textarea>
                            </div>
                            <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                        </div>     
                        
                        <div class="form-group">
                            <h5>Vincoli (eventuali)</h5>
                            <div class="controls">
                                <textarea id="des_eventuali_vincoli" name="des_eventuali_vincoli" rows="3" maxlength="4000" class="form-control"></textarea>
                            </div>
                            <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                        </div>                          
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="control-label col-md-12">Durata minima (ore) <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" id="ore_min_durata_mod" name="ore_min_durata_mod" class="form-control"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="control-label col-md-12">Percentuale massima di FaD <span class="text-danger">*</span></label>
                                    <div class="col-md-12">
                                        <input type="number" id="perc_fad_mod" name="perc_fad_mod" class="form-control">  
                                    </div>  
                                </div>
                            </div> 
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label col-md-12">Sequenza <span class="text-danger">*</span></label>                                   
                                    <div class="col-md-12">
                                        <input type="number" id="sequenza" name="sequenza" class="form-control">  
                                    </div>
                                    <div class="form-control-feedback col-md-12"><small><i>Sequenza di ordinamento rispetto agli altri moduli</i></small></div>
                                </div>
                            </div>
                        </div>                        
                        <?php echo form_hidden('id_modulo', ''); ?>
                        <?php echo form_hidden('id_profilo', $id_profilo); ?>
                        <?php echo form_hidden('id_standard_formativo', $id_standard_formativo); ?> 
                        <?php echo form_hidden('durata_fad_sf', 0); ?> 
                        <div class="form-actions">
                            <button id="btn_salva_modulo" name="btn_salva_modulo" type="submit" class="btn btn-info">Salva</button>  
                            <button type="reset" id="btn_chiudi_modulo" class="btn btn-inverse">Chiudi</button>   
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- TABELLA MODULI -->
    <div id="div_tabella_moduli" class="row m-t-40">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Moduli</h4>
                    <h6 class="card-subtitle">La tabella contiene i moduli che compongono lo standard professionale. 
                        Qualsiasi modifica alla composizione dei moduli di una qualificazione <i>Pubblicata</i> o con <i>Revisioni Validate</i> ne comporterà la
                        variazione di stato <i>In Revisione</i>.</h6>            
                    <div div class="table-responsive m-t-5 m-b-40">
                        <table id="dt_modulo_standard" class="table color-table info-table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>id_modulo</th>
                                    <th>id_standard_formativo</th>
                                    <th>id_profilo</th>
                                    <th>Denominazione Modulo</th>
                                    <th>des_contenuti</th>
                                    <th>Durata min. ore</th>
                                    <th>des_eventuali_vincoli</th>
                                    <th>% FAD</th>
                                    <th>Seq.</th>
                                    <th>Azione</th> 
                                </tr>                            
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> 
                    <div class="button-group">                    
                        <button id="btn_add_modulo" name="btn_add_modulo" class="btn btn-info">Nuovo modulo</button>      
                    </div>                         
                </div>
            </div>
        </div>
    </div>     
         
    
    <!-- VERIFICA -->
    <div id="q_cheklist" class="row m-t-40">        
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Verifica</h4>
                    <h6 class="card-subtitle">Di seguito sono riportati gli indicatori utili alla verifica del corretto inserimento dello standard formativo</h6>                      
                    <table class="table color-table success-table table-hover table-bordered m-t-40">
                        <thead>
                            <tr>
                                <th>Elemento</th>
                                <th class="text-center">Valore</th>
                                <th class="text-center">Esito verifica</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Totale durata minima di aula e laboratorio <i>da attribuire</i> alle Unità Formative/Moduli al netto delle KC (ore)</td>
                                <td class="text-nowrap text-center"><span id="ore_min_durata_uf_mod_ins"></span> </td>
                                <td class="text-nowrap text-center"><span class="badge badge-default">Calcolato</span> </td>
                            </tr>                             
                            <tr>
                                <td>Totale durata minima di aula e laboratorio <i>attribuita</i> alle Unità Formative/Moduli al netto delle KC (ore)</td>
                                <td class="text-nowrap text-center"><span id="ore_min_durata_uf_mod"></span> </td>
                                <td class="text-nowrap text-center"><span id="label_durata_uf_mod" class="badge"></span> </td>
                            </tr>  
                            <tr>
                                <td>Durata massima FaD di aula e laboratorio prevista per lo standard formativo al netto delle KC (ore)</td>
                                <td class="text-nowrap text-center"><span id="ore_durata_fad_sf"></span> </td>
                                <td class="text-nowrap text-center"><span id="label_ore_durata_fad_sf" class="badge badge-default">Calcolato</span> </td>
                            </tr> 
                            <tr>
                                <td>Totale durata FaD di aula e laboratorio <i>attribuita</i> alle Unità Formative/Moduli al netto delle KC (ore)</td>
                                <td class="text-nowrap text-center"><span id="ore_durata_fad_uf_mod"></span> </td>
                                <td class="text-nowrap text-center"><span id="label_ore_durata_fad_uf_mod" class="badge"></span> </td>
                            </tr>                                   
                        </tbody>
                    </table>                         
                </div>
            </div>
        </div>
    </div>     
   
    
    <!-- QUALITY TOOLS -->
    <div id="q_tools" class="row m-t-40">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Controllo delle modifiche</h4>
                    <h6 class="card-subtitle">I file generati dai tools contengono le modifiche successive all'ultima pubblicazione dello standard formativo</h6>
                    <div class="button-group">
                        <a href="<?php echo base_url('/public/stampa/sf/' . $id_standard_formativo . '/1') ?>" target="_blank" class="btn btn-outline-info">Genera PDF</a>
                        <a href="<?php echo base_url('/admin/qualificazione/difftool/' . $id_profilo) ?>" target="_blank" class="btn btn-outline-info">Lancia Diff Checker</a>
                    </div>
                </div>
            </div>
        </div>
    </div>  
 
 
    <?php 
        $this->load->section('dettaglio_uc', 'section/dettaglio_uc');
        if($this->load->get_section('dettaglio_uc') != '') {
            echo $this->load->get_section('dettaglio_uc');
        } 
    ?>      
<?php } ?>





<script language="javascript" type="text/javascript">
var tabella_uf;
var tabella_moduli;
var id_profilo;
var id_standard_formativo;
var action;
var curr_flg_uf_modulo; 


$(document).ready(function () {
    "use strict";
    var std_options = {
        language: "it",
        placeholder: "",
        allowClear: false
    };    
    var std_options_multi = {
            language: "it",
            placeholder: "",
            allowClear: true
    };
    if ($.fn.select2) {
        $(".select2").select2(std_options);
        $(".select2-multiple").select2(std_options_multi);
    }

    /* Visualizza dettaglio UC contestualmente */
    $("#btn_dettaglio_uc").click( function (e) {
        e.preventDefault();                  
        if (typeof(loadUc) === "function"){
            loadUc($("#id_competenza").val(), id_profilo);
        }
    });

    $('#copyQ').click(function(e){
        e.preventDefault(); 
        $("#des_standard_formativo").val($("#titolo_profilo").val());
        return false; 
    });

    $('#copyUC').click(function(e){
        e.preventDefault(); 
        $("#titolo_unita_formativa").val($("#id_competenza option:selected").text());
        return false; 
    });

    id_profilo = $("input[name='id_profilo']").val();
    id_standard_formativo = $("input[name='id_standard_formativo']").val();    
    action = $("input[name='action']").val();  

    //Bottone INDIETRO
    $("#btn_reset").on("click", function () {
        /* Gestione Competenza  */
        var ref = document.referrer;
        if ((ref.indexOf("qualificazione") !== -1) || (ref.indexOf("standardformativo/nuovo") !== -1))
            window.location.href = baseURL + 'admin/qualificazione/gestione/' + id_profilo;
        else
            window.location.href = baseURL + 'admin/standardformativo';
    });
    
    //Bottone SALVA (Submit)
    $('#frm_dati_standard_formativo').on('submit', function (form) {
        form.preventDefault();
        var formData = $("#frm_dati_standard_formativo").serialize();
        save_standard_formativo(formData);
    });
    
    $('#div_tabella_uf').hide();
    $('#div_form_uf').hide();
    $('#div_form_moduli').hide();
    $('#div_tabella_moduli').hide();
    
    if (action === 'add')
    {
        $('#perc_fad_aula_lab_kc').val("15");
    }
    if (action === 'edit')
    {
        curr_flg_uf_modulo = $("#flg_uf_modulo").val();
        //Setta Totale durata minima attribuita alle Unità Formative/Moduli (ore)
        set_tot_durata();
        set_tabelle_sf();


        //CARICAMENTO CODICI ISCED-F
        $.ajax({
            type: 'POST',
            url: baseURL + 'admin/standardformativo/get_isced_sf_json',
            cache: false,
            async: false,
            data: {id_standard_formativo: id_standard_formativo},
            success: function (data) {
                $("#id_isced").val(data).trigger("change");
            },
            error: function () {
                swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
            }
        });

        //EVENTO CHANGE DEL TIPO DI COMPOSIZIONE SF
        $("#flg_uf_modulo").on("change", function() {               
           if ($("#flg_uf_modulo").val() !== curr_flg_uf_modulo)
           {
               var msg;
               if (curr_flg_uf_modulo === "0")
                   msg = "Cambiando il tipo di composizione con Moduli verranno eliminate, in modo irreversibile, le Unità Formative presenti in tabella.\n\r";
               else
                   msg = "Cambiando il tipo di composizione con Unità Formative verranno eliminati, in modo irreversibile, i Moduli presenti in tabella.\n\r";

               swal({
                    title: "Attenzione!",
                    text: msg + " Vuoi continuare?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (!isConfirm) {                           
                        $("#flg_uf_modulo").val(curr_flg_uf_modulo);
                    } else {
                        var formData = $("#frm_dati_standard_formativo").serialize();
                        save_standard_formativo(formData);
                        curr_flg_uf_modulo = $("#flg_uf_modulo").val();                        
                        set_tabelle_sf();
                        set_tot_durata();
                    }
                });
           }

        });
    
        /*
        * COMPOSIZIONE CON UNITA' FORMATIVE
        */
        $('#btn_add_uf').on("click", function (){
            $('#titolo_frm_uf').html('Nuova unità formativa');
            carica_competenze_select(0);
            $("input[name='id_unita_formativa']").val('');
            $('#frm_unita_formativa')[0].reset();
            $('#div_form_uf').slideDown();
            //Inserisce automaticamente il numero di sequenza 
            //basato sul numero totale di righe presenti in tabella
            if (! tabella_uf.rows().count() ) 
            {
                $('#frm_unita_formativa #sequenza').val("1");
            } else {
                $('#frm_unita_formativa #sequenza').val(parseInt(tabella_uf.rows().count())+1);
            }
            $(window).scrollTop($('#div_form_uf').offset().top - 100);
        });

        $('#btn_chiudi_uf').on("click", function (){
            $('#div_form_uf').slideUp();
        });

        $('#frm_unita_formativa').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_unita_formativa").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/standardformativo/save_uf_json',
                cache: false,
                data: formData,
                success: function (data) {
                    swal("Salva informazioni", data.message, data.esito);
                    if (data.esito !== "error")
                    {
                        $('#div_form_uf').slideUp();
                        tabella_uf.ajax.reload();
                        set_tot_durata();
                        refresh_stato_qualificazione();
                        display_qtool();
                    }
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
        });    
    
       /***********************************
        * COMPOSIZIONE CON MODULI                
        ************************************/
        $('#btn_add_modulo').on("click", function ()
        {                    
            $('#titolo_frm_modulo').html('Nuovo Modulo');
            $("input[name='id_modulo']").val('');
            $('#frm_modulo')[0].reset();
            $('#div_form_moduli').slideDown();
            //Inserisce automaticamente il numero di sequenza 
            //basato sul numero totale di righe presenti in tabella
            if ( ! tabella_moduli.rows().count() ) 
            {
                $('#frm_modulo #sequenza').val("1");
            } else {
                $('#frm_modulo #sequenza').val(parseInt(tabella_moduli.rows().count())+1);
            }            
            $(window).scrollTop($('#div_form_moduli').offset().top - 100);
        });

        $('#btn_chiudi_modulo').on("click", function ()
        {
            $('#div_form_moduli').slideUp();
        });

        $('#frm_modulo').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_modulo").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/standardformativo/save_modulo_json',
                cache: false,
                data: formData,
                success: function (data) {
                    swal("Salva informazioni", data.message, data.esito);
                    if (data.esito !== "error")
                    {
                        $('#div_form_moduli').slideUp();
                        tabella_moduli.ajax.reload();
                        set_tot_durata();
                        refresh_stato_qualificazione();
                        display_qtool();                   
                    }
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
        });
    
    
    }
    
    /* Gestione QTools */
    display_qtool();
    /* Fine Gestione QTools */
});

function refresh_stato_qualificazione()
{
   var id_profilo = $("input[name='id_profilo']").val();
   var id_standard_formativo = $("input[name='id_standard_formativo']").val();
   $.ajax({
         type: 'POST',
         url: baseURL + 'admin/standardformativo/get_stato_sf_json',
         cache: false,
         async: false,
         data: {id_profilo: id_profilo , id_standard_formativo : id_standard_formativo},
         success: function (data) {
            $("#data_ultima_modifica").val(data['data_ultima_modifica']);
            $("#id_stato_profilo").val(data['id_stato_profilo']);
         },
         error: function () {
             swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
         }
     }); 
}

function save_standard_formativo(formData)
{
    
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/standardformativo/save_standard_formativo',
        cache: false,
        data: formData,
        success: function (data) {
            if (parseInt(data.id_standard_formativo) > 0) {
                swal({
                    title: "Salva dati",
                    text: "Operazione effettuata con successo",
                    type: "success"
                }, function () {
                    if (action === "add")
                    {
                        window.location.href = baseURL + "admin/standardformativo/gestione/" + data.id_standard_formativo;
                    } 
                    else 
                    {
                        set_tot_durata();
                        refresh_stato_qualificazione();
                        display_qtool();                        
                    }                     
                });
            } else {             
                swal("Salva informazioni", data.message, data.esito);
            }
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
        }
    });        
}

function set_tot_durata()
{
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/standardformativo/get_indicatori_durata_sf',
        cache: false,
        data: {id_standard_formativo: id_standard_formativo},
        success: function (data) {            

            var durata_sf = parseInt(data.tot_durata_sf) || 0;
            var durata_uf_mod = parseInt(data.tot_durata_uf_mod) || 0;
            var durata_fad_sf = parseFloat(data.tot_ore_fad_sf) || 0;
            var durata_fad_uf_mod = parseFloat(data.tot_ore_uf_mod_fad) || 0;

            $("input[name='durata_fad_sf']").val(durata_fad_sf);
            
            if (durata_sf !== durata_uf_mod)
            {
                $('#label_durata_uf_mod').html("Errore");
                $('#label_durata_uf_mod').removeClass("badge-success");
                $('#label_durata_uf_mod').addClass("badge-danger");
            }
            else
            {
                $('#label_durata_uf_mod').html("Positivo");
                $('#label_durata_uf_mod').removeClass("badge-danger");
                $('#label_durata_uf_mod').addClass("badge-success");
            }
            $('#ore_min_durata_uf_mod_ins').html(durata_sf);
            $('#ore_min_durata_uf_mod').html(durata_uf_mod);
            
            if (durata_fad_sf > durata_fad_uf_mod)
            {
                $('#label_ore_durata_fad_uf_mod').html("Errore");
                $('#label_ore_durata_fad_uf_mod').removeClass("badge-success");
                $('#label_ore_durata_fad_uf_mod').addClass("badge-danger");
            }
            else
            {
                $('#label_ore_durata_fad_uf_mod').html("Positivo");
                $('#label_ore_durata_fad_uf_mod').removeClass("badge-danger");
                $('#label_ore_durata_fad_uf_mod').addClass("badge-success");
            }            
            $('#ore_durata_fad_sf').html(durata_fad_sf);
            $('#ore_durata_fad_uf_mod').html(durata_fad_uf_mod);



        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel recupero dei dati', 'error');
        }
    });
    
}

function set_tabelle_sf()
{
    $('#div_tabella_uf').hide();
    $('#div_form_uf').hide();
    $('#div_form_moduli').hide();
    $('#div_tabella_moduli').hide();
    //SETTAGGIO CONDIZIONALE PER TIPO COMPOSIZIONE
    if (parseInt(curr_flg_uf_modulo) === 0)
    {
        
        if (typeof(tabella_uf) !== 'undefined' && tabella_uf !== null){
            tabella_uf.destroy();                        
        }
        tabella_uf = $('#dt_uf_standard').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "paging": false,
            "lengthChange": false,
            "order": [[9, "asc"]], //ordina per sequenza
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/standardformativo/get_datatables_uf_json' ?>",
                "type": "POST",
                "data": {
                    "id_standard_formativo": id_standard_formativo
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false}, //id_unita_formativa
                {"targets": [1], "visible": false, "searchable": false}, //id_standard_formativo
                {"targets": [2], "visible": false, "searchable": false}, //id_profilo
                {"targets": [3], "visible": false, "searchable": false}, //id_competenza
                {"targets": [4], "visible": true,  "searchable": true,  "width": "50%"}, //titolo_unita_formativa
                {"targets": [5], "visible": true,  "searchable": true,  "width": "14%", "className": "text-right" }, //ore_min_durata_uf
                {"targets": [6], "visible": true,  "searchable": true,  "width": "10%", "className": "text-right"}, //perc_varianza
                {"targets": [7], "visible": false, "searchable": false }, //des_eventuali_vincoli
                {"targets": [8], "visible": true,  "searchable": true,  "width": "10%", "className": "text-right"}, //perc_fad_uf
                {"targets": [9], "visible": true,  "searchable": true,  "width": "8%", "className": "text-right"}, //sequenza
                {"targets": [10], "visible": true, "searchable": false, "width": "8%", "orderable": false, "className": "text-center"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
        $('#div_tabella_uf').show();
    } 
    else if (parseInt(curr_flg_uf_modulo) === 1) 
    {
        $('#div_tabella_moduli').show();

        if (typeof(tabella_moduli) !== 'undefined' && tabella_moduli !== null){
            tabella_moduli.destroy();                            
        }
        tabella_moduli = $('#dt_modulo_standard').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "paging": false,
            "lengthChange": false,
            "order": [[8, "asc"]], //ordina per sequenza
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/standardformativo/get_datatables_moduli_json' ?>",
                "type": "POST",
                "data": {
                    "id_standard_formativo": id_standard_formativo
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false}, //id_modulo
                {"targets": [1], "visible": false, "searchable": false}, //id_standard_formativo
                {"targets": [2], "visible": false, "searchable": false}, //id_profilo
                {"targets": [3], "visible": true,  "searchable": true,  "width": "40%"}, //titolo_modulo
                {"targets": [4], "visible": false, "searchable": false }, //des_contenuti
                {"targets": [5], "visible": true,  "searchable": true,  "width": "10%", "className": "text-right" }, //ore_min_durata_mod
                {"targets": [6], "visible": false, "searchable": false }, //des_eventuali_vincoli
                {"targets": [7], "visible": true,  "searchable": true,  "width": "10%", "className": "text-right"}, //perc_fad_mod
                {"targets": [8], "visible": true,  "searchable": true,  "width": "8%", "className": "text-right"}, //sequenza
                {"targets": [9], "visible": true, "searchable": false, "width": "8%", "orderable": false, "className": "text-center"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });                
    }
}    
    
/* AZIONI TABELLA MODULO*/
function del_mod(id_modulo)
{
    $('#div_form_moduli').slideUp();
    swal({
        title: "Sei sicuro?",
        text: "Verrà cancellata la riga selezionata",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            //PROSEGUI		
            var id_profilo = $("input[name='id_profilo']").val();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/standardformativo/elimina_modulo_json',
                cache: false,
                data: {id_modulo: id_modulo, id_profilo : id_profilo},
                success: function (data) {
                    swal("Elimina modulo", data.message, data.esito);
                    tabella_moduli.ajax.reload();
                    set_tot_durata();
                    refresh_stato_qualificazione();
                    display_qtool();                     
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
        }
    });
}

function edit_mod(id_modulo)
{
    
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/standardformativo/leggi_modulo_json',
        cache: false,
        data: {id_modulo: id_modulo},
        success: function (data) {
            var frm = $("#frm_modulo");
            frm[0].reset();
            for (field in data) 
            {
                frm.find('[name="' + field + '"]').val(data[field]);
            }          
            $('#div_form_moduli').slideDown();
            $(window).scrollTop($('#div_form_moduli').offset().top - 100);
            $('#titolo_frm_modulo').html('Modifica Modulo');
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel recupero dei dati', 'error');
        }
    });
}
    
/* AZIONI TABELLA UNITA' FORMATIVA*/
function del_uf(id_unita_formativa)
{
    $('#div_form_uf').slideUp();
    swal({
        title: "Sei sicuro?",
        text: "Verrà cancellata la riga selezionata",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            //PROSEGUI		
            var id_profilo = $("input[name='id_profilo']").val();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/standardformativo/elimina_uf_json',
                cache: false,
                data: {id_unita_formativa: id_unita_formativa, id_profilo : id_profilo },
                success: function (data) {
                    swal("Elimina Unità Formativa", data.message, data.esito);
                    tabella_uf.ajax.reload();
                    set_tot_durata();
                    refresh_stato_qualificazione();
                    display_qtool();                       
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
        }
    });
}

function edit_uf(id_unita_formativa)
{
    
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/standardformativo/leggi_uf_json',
        cache: false,
        data: {id_unita_formativa: id_unita_formativa},
        success: function (data) {
            var frm = $("#frm_unita_formativa");
            frm[0].reset();
            for (field in data) 
            {
                frm.find('[name="' + field + '"]').val(data[field]);
            }          
            carica_competenze_select(data.id_competenza);
            $('#div_form_uf').slideDown();
            $(window).scrollTop($('#div_form_uf').offset().top - 100);
            $('#titolo_frm_modulo').html('Modifica unità formativa');
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel recupero dei dati', 'error');
        }
    });
}

/* SOLO PER UF */
function carica_competenze_select(id_selected)
{
    var curr_comp = [];
    tabella_uf.column(3).data().each(function (value, index) {
        /* Non disabilito l'id che sto modificando*/
        if (value !== id_selected){
            curr_comp[index] = value;
        }
    });
    
    var id_profilo = $("input[name='id_profilo']").val();
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/standardformativo/list_profilo_competenza_json',
        cache: false,
        data: {id_profilo: id_profilo},
        success: function (data) {
            var newOptions = '<option value=""></option>';
            $.each(data, function (idx, obj) {                
                /* SE IN MODIFICA PRESELEZIONA ELEMENTO */
                var set_select = "";
                if (id_selected === obj.id_competenza)
                    set_select = "selected='selected'";
                
                /* DISABILITA QUELLI PRESENTI IN TABELLA PER EVITARE DUPLICATI */
                var set_disable = "";
                if (curr_comp.indexOf(obj.id_competenza) > -1)
                {
                   set_disable = "disabled";
                }
                newOptions += '<option value="' + obj.id_competenza + '" ' + set_select + ' ' + set_disable + '>' + obj.titolo_competenza + '</option>';
            });
            $("#id_competenza").html(newOptions);
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
        }
    });
}

function display_qtool()
{
    /* default invisibile */
    $('#q_tools').hide();
    /* In action=add non lo visualizza */
    var action = $("input[name='action']").val();
    if (action !== 'edit')
        return;
    var curr_stato = $("#id_stato_profilo").val();
    if (parseInt(curr_stato) > 0)
        $('#q_tools').show();

}

</script>