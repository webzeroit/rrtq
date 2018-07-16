<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">        
                <h4 class="card-title">Informazioni generali</h4>
                <h6 class="card-subtitle">Inserire e/o selezionare tutte le informazioni richieste per la corretta identificazione della qualificazione</h6>
                <form class="m-t-40" id="frm_dati_profilo" autocomplete="off">
                    <div class="form-group">
                        <h5>Settore Economico Professionale <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="id_sep" name="id_sep" class="form-control">
                                <option value="0"></option>
                                <?php
                                foreach ($list_sep as $sep)
                                {
                                    ($sep['id_sep'] == $profilo['id_sep']) ? $selected = TRUE : $selected = FALSE;
                                    ?>
                                    <option <?= set_select('id_sep', $sep, $selected) ?> value="<?= $sep['id_sep'] ?>"><?= $sep['descrizione_sep'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                    <div class="form-group">
                        <h5>Titolo qualificazione <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" id="titolo_profilo" name="titolo_profilo" maxlength="255" class="form-control"
                                   value="<?php echo set_value('titolo_profilo', $profilo['titolo_profilo']); ?>"> 
                        </div>
                    </div>     
                    <div class="form-group">
                        <h5>A.D.A <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="id_ada" name="id_ada[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_ada as $ada)
                                {
                                    ?>
                                    <option value="<?= $ada['id_ada'] ?>"><?= $ada['descrizione_ada'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>   
                        </div>
                    </div>  
                    <?php if ($action === "edit")
                    { ?>
                        <div class="form-group">
                            <h5>Processo</h5>
                            <div class="controls">
                                <textarea id="processo" name="processo" rows="3" class="form-control" readonly></textarea>
                            </div>                           
                        </div>
                        <div class="form-group">
                            <h5>Sequenza di Processo</h5>
                            <div class="controls">
                                <textarea id="seq_processo" name="seq_processo" rows="5" class="form-control" readonly></textarea>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="form-group">
                        <h5>Descrizione qualificazione <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="descrizione_profilo" name="descrizione_profilo" rows="7" maxlength="4000" class="form-control"><?php echo set_value('descrizione_profilo', $profilo['descrizione_profilo']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>   
                    <div class="form-group">
                        <h5>Livello EQF <span class="text-danger">*</span></h5>
                        <input type="text" name="livello_eqf" class="form-control"
                               value="<?php echo set_value('livello_eqf', $profilo['livello_eqf']); ?>">
                        <div class="form-control-feedback"> <small><i>Consulta la pagina dei <a href="https://ec.europa.eu/ploteus/content/descriptors-page" target="_blank">descrittori ufficiali</a></i> </small> </div>
                    </div>  
                    <div class="form-group">
                        <h5>Referenziazione ATECO 2007 <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="codice_ateco" name="codice_ateco[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_ateco as $ateco)
                                {
                                    ?>
                                    <option value="<?= $ateco['codice_ateco'] ?>"><?= $ateco['descrizione_ateco'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>   
                        </div>
                    </div> 
                    <div class="form-group">
                        <h5>Referenziazione CP 2011 <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="codice_cp2011" name="codice_cp2011[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_cp2011 as $cp2011)
                                {
                                    ?>
                                    <option value="<?= $cp2011['codice_cp2011'] ?>"><?= $cp2011['descrizione_cp2011'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>   
                        </div>
                    </div>                      
                    <div class="form-group">
                        <div class="controls">
                            <div class="demo-checkbox">
                                <input type="checkbox" id="flg_regolamentato" value="1" name="flg_regolamentato" class="filled-in chk-col-light-blue" 
                                <?php echo ($profilo['flg_regolamentato'] === "1") ? ' checked="checked"' : ''; ?> />
                                <label for="flg_regolamentato">Qualificazione regolamentata</label>
                            </div> 
                        </div>
                    </div>
                    <?php
                    if ($action === "edit")
                    {
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5>Stato qualificazione</h5>
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
                                               value="<?php echo set_value('data_ultima_modifica', convertsDataOraInItalianFormat($profilo['data_ultima_modifica'])); ?>"> 
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h5>Ultimo scarico INAPP </h5>
                                    <div class="controls">
                                        <input type="text" id="data_ultimo_export" name="data_ultimo_export" class="form-control" readonly
                                               value="<?php echo set_value('data_ultimo_export', convertsDataOraInItalianFormat($profilo['data_ultimo_export'])); ?>"> 
                                    </div>
                                </div>                            
                            </div>                            
                        </div>
                    <?php } ?>
                    
                   
                    
                    <?php echo form_hidden('id_profilo', $id_profilo); ?>
                    <?php echo form_hidden('action', $action); ?>                    
                    <div class="text-xs-right">
                        <button type="submit" class="btn btn-info">Salva</button>                                        
                        <button type="button" id="btn_reset" class="btn btn-inverse">Indietro</button>
                    </div>                    
                </form>
            </div>  
        </div>
    </div>  
</div>

<?php if ($action === "edit")
{ ?>
    <!-- ASSOCIAZIONE COMPETENZE PROFILO-->
    <div id="div_associa_competenza" class="row">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Associazione Unità di Competenza</h4>
                    <h6 class="card-subtitle">Seleziona l'unità di competenza da associare al profilo</h6>  
                    <form class="m-t-30" id="frm_associa_competenza">
                        <div class="form-group">
                            <div class="controls">
                                <label class="control-label">Unità di Competenza <span class="text-danger">*</span></label>
                                <select id="id_competenza" name="id_competenza" class="select2 form-control custom-select" style="width: 100%; height:46px;">
                                    <option value=""></option>                                       
                                </select>
                            </div>
                        </div>
                        <div id="div_dettaglio_competenza" class="row m-t-30 m-b-40">
                            <div class="col-lg-6">
                                <h5>Abilità</h5>
                                <ol id="list_abilita" class="list-icons">

                                </ol>
                            </div>
                            <div class="col-lg-6">
                                <h5>Conoscenze</h5>
                                <ol id="list_conoscenza" class="list-icons">
                                </ol>
                            </div>                                    
                        </div>
                        <?php echo form_hidden('action_competenza', 'add'); ?> 
                        <?php echo form_hidden('id_profilo', $id_profilo); ?>
                        <div class="form-actions">
                            <button id="btn_salva_associazione_comp" name="btn_salva_associazione_comp" type="submit" class="btn btn-info">Salva associazione</button>  
                            <button type="button" id="btn_chiudi_associazione_comp" class="btn btn-inverse">Chiudi</button>   
                        </div>                        
                    </form>                        
                </div>                    
            </div>
        </div>
    </div>

    <!-- TABELLA COMPETENZE PROFILO-->
    <div class="row m-t-5">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Unità di Competenza</h4>
                    <h6 class="card-subtitle">La tabella contiene le unità di competenza associale alla qualificazione. 
                        Qualsiasi modifica alla composizione delle UC di una qualificazione <i>Pubblicata</i> ne comporterà la
                        variazione di stato <i>In Revisione</i>.</h6>            
                    <div div class="table-responsive m-t-5 m-b-40">
                        <table id="dt_competenze_profilo" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>id_profilo</th>
                                    <th>id_competenza</th>
                                    <th>Titolo</th>
                                    <th>Descrizione</th>
                                    <th>Risultato atteso</th>
                                    <th>Oggetto di osservazione</th>
                                    <th>Indicatori</th>
                                    <th>Azione</th> 
                                </tr>                            
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="button-group">                    
                        <button id="btn_add_competenza_profilo" name="btn_add_competenza_profilo" class="btn btn-info">Associa nuova competenza</button>      
                    </div>                
                </div>
            </div>
        </div>
    </div>
       
    <div id="q_tools" class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Controllo delle modifiche</h4>
                    <h6 class="card-subtitle">I file generati dai tools contengono le modifiche successive all'ultima pubblicazione della qualificazione</h6>
                    <div class="button-group">
                        <a href="<?php echo base_url('/public/GeneraPDF/'.$id_profilo.'/1') ?>" target="_blank" class="btn btn-outline-info">Genera PDF</a>
                        <a href="<?php echo base_url('/admin/qualificazione/difftool/'.$id_profilo) ?>" target="_blank" class="btn btn-outline-info">Lancia Diff Checker</a>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    
<?php } ?>
    
    

    
    
    
<script language="javascript" type="text/javascript">
    var tabella_competenze;

    $(document).ready(function () {
        "use strict";
        //$("input,select,textarea").not("[type=submit],[class=select2]").jqBootstrapValidation();
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


        /* Gestione Profilo  */
        var id_profilo = $("input[name='id_profilo']").val();
        var action = $("input[name='action']").val();        
        $("#btn_reset").on("click", function () {
            window.location.href = baseURL + 'admin/qualificazione';
        });

        $('#frm_dati_profilo').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_dati_profilo").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/save_profilo',
                cache: false,
                data: formData,
                success: function (data) {
                    if (parseInt(data.id_profilo) > 0) {
                        swal({
                            title: "Salva dati",
                            text: "Operazione effettuata con successo",
                            type: "success"
                        }, function () {
                            if (action === "add")
                            {
                                window.location.href = baseURL + "admin/qualificazione/gestione/" + data.id_profilo;
                            } 
                            else 
                            {
                                carica_campi_processo(data.id_profilo);
                                refresh_stato_qualificazione(id_profilo);
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

        });

        $("#id_sep").change(function () {
            var curr_sep = $("#id_sep").val();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/get_ada_sep_json',
                cache: false,
                async: false,
                data: {id_sep: curr_sep},
                success: function (data) {
                    var newOptions = '';
                    $.each(data, function (idx, obj) {
                        newOptions += '<option value="' + obj.id_ada + '">' + obj.descrizione_ada + '</option>';
                    });
                    $("#id_ada").html(newOptions);
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
        });


        if (action === 'edit') {
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/get_ada_profilo_json',
                cache: false,
                async: false,
                data: {id_profilo: id_profilo},
                success: function (data) {
                    $("#id_ada").val(data).trigger("change");
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
           
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/get_ateco_profilo_json',
                cache: false,
                async: false,
                data: {id_profilo: id_profilo},
                success: function (data) {
                    $("#codice_ateco").val(data).trigger("change");
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });

            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/get_cp2011_profilo_json',
                cache: false,
                async: false,
                data: {id_profilo: id_profilo},
                success: function (data) {
                    $("#codice_cp2011").val(data).trigger("change");
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
            
            carica_campi_processo(id_profilo);            
            
            tabella_competenze = $('#dt_competenze_profilo').DataTable({
                "language": {
                    "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
                },
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "paging": false,
                "lengthChange": false,
                "order": [[2, "asc"]],
                "dom": 'lfrtip',
                ajax: {
                    "url": "<?php echo base_url() . 'admin/Qualificazione/get_datatables_profilo_competenza_json' ?>",
                    "type": "POST",
                    "data": {
                        "id_profilo": id_profilo
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {"targets": [0], "visible": false, "searchable": false},
                    {"targets": [1], "visible": false, "searchable": false},
                    {"targets": [2], "visible": true, "searchable": true, "width": "40%"},
                    {"targets": [3], "visible": true, "searchable": true, "width": "50%"},
                    {"targets": [4], "visible": false, "searchable": false},
                    {"targets": [5], "visible": false, "searchable": false},
                    {"targets": [6], "visible": false, "searchable": false},
                    {"targets": [7], "visible": true, "searchable": false, "orderable": false, "width": "10%"}
                ],
                "drawCallback": function () {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="popover"]').popover();
                }
            });

        }
        /* Fine Gestione Profilo */




        /* Gestione Competenza  */
        $('#div_associa_competenza').hide();
        $('#div_dettaglio_competenza').hide();
        $('#btn_add_competenza_profilo').click(function () {
            carica_competenze_select();
            $('#div_associa_competenza').slideDown();
            $(window).scrollTop($('#div_associa_competenza').offset().top - 200);
            $('#div_dettaglio_competenza').hide();
        });
        $('#btn_chiudi_associazione_comp').click(function () {
            $('#div_associa_competenza').slideUp();
            $('#div_dettaglio_competenza').hide();
        });
        $('#frm_associa_competenza').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_associa_competenza").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/save_associazione_competenza',
                cache: false,
                data: formData,
                success: function (data) {
                    swal("Salva informazioni", data.message, data.esito);
                    if (data.esito !== "error")
                    {
                        $('#div_dettaglio_competenza').hide();
                        $('#div_associa_competenza').slideUp();
                        tabella_competenze.ajax.reload();
                        refresh_stato_qualificazione(id_profilo);
                        display_qtool();
                    }
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });

        });
        $("#id_competenza").change(function () {
            var curr_competenza = $("#id_competenza").val();
            $('#div_dettaglio_competenza').show();
            /*LISTA ABILITA*/
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/list_competenza_abilita_json',
                cache: false,
                async: false,
                data: {id_competenza: curr_competenza},
                success: function (data) {
                    var lista_1 = '';
                    $.each(data, function (idx, obj) {
                        lista_1 += '<li>' + obj.descrizione_abilita + '</li>';
                    });
                    $("#list_abilita").html(lista_1);
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });
            /*LISTA CONOSCENZE*/
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/qualificazione/list_competenza_conoscenza_json',
                cache: false,
                async: false,
                data: {id_competenza: curr_competenza},
                success: function (data) {
                    var lista_2 = '';
                    $.each(data, function (idx, obj) {
                        lista_2 += '<li>' + obj.descrizione_conoscenza + '</li>';
                    });
                    $("#list_conoscenza").html(lista_2);
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });

        });
        /* Fine Gestione Competenza */

        /* Gestione QTools */
        display_qtool();

    });


    function refresh_stato_qualificazione(id)
    {
       $.ajax({
             type: 'POST',
             url: baseURL + 'admin/qualificazione/get_stato_profilo_json',
             cache: false,
             async: false,
             data: {id_profilo: id},
             success: function (data) {
                 $("#data_ultima_modifica").val(data['data_ultima_modifica']);
                 $("#id_stato_profilo").val(data['id_stato_profilo']);
             },
             error: function () {
                 swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
             }
         }); 
    }
    function carica_campi_processo(id)
    {
        $("#processo").empty();
        $("#seq_processo").empty();
        $.ajax({
             type: 'POST',
             url: baseURL + 'admin/qualificazione/get_processo_profilo_json',
             cache: false,
             async: false,
             data: {id_profilo: id},
             success: function (data) {
                 $.each(data, function(index) {
                     $("#processo").append(data[index] + "\n");   
                 }); 
             },
             error: function () {
                 swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
             }
         });

         $.ajax({
             type: 'POST',
             url: baseURL + 'admin/qualificazione/get_sequenza_processo_profilo_json',
             cache: false,
             async: false,
             data: {id_profilo: id},
             success: function (data) {     
                 $.each(data, function(index) {
                     $("#seq_processo").append(data[index] + "\n");   
                 });                    
             },
             error: function () {
                 swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
             }
         });             
    }
    function carica_competenze_select()
    {
        $.ajax({
            type: 'POST',
            url: baseURL + 'admin/qualificazione/list_competenza_json',
            cache: false,
            async: false,
            success: function (data) {
                var newOptions = '<option value=""></option>';
                $.each(data, function (idx, obj) {
                    newOptions += '<option value="' + obj.id_competenza + '">' + obj.titolo_competenza + '</option>';
                });
                $("#id_competenza").html(newOptions);
            },
            error: function () {
                swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
            }
        });
    }
    function del_competenza(id)
    {
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
                var action = "delete";
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/save_associazione_competenza',
                    cache: false,
                    data: {id_profilo: id_profilo, id_competenza: id, action_competenza: action},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_competenze.ajax.reload();
                        refresh_stato_qualificazione(id_profilo);
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
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
        if (parseInt(curr_stato) > 1)
            $('#q_tools').show();
        
    }


</script>