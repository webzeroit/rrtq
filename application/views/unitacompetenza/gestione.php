<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">   
                <h4 class="card-title">Informazioni generali</h4>
                <h6 class="card-subtitle">Inserire e/o selezionare tutte le informazioni richieste per la corretta identificazione della unità di competenza</h6>
                <form class="m-t-40" id="frm_dati_competenza" autocomplete="off">
                    <div class="form-group">
                        <h5>Titolo competenza <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <input type="text" id="titolo_competenza" name="titolo_competenza" maxlength="500" class="form-control"
                                   value="<?php echo set_value('titolo_competenza', $competenza['titolo_competenza']); ?>"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <h5>Descrizione competenza <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="descrizione_competenza" name="descrizione_competenza" rows="7" maxlength="4000" class="form-control"><?php echo set_value('descrizione_competenza', $competenza['descrizione_competenza']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>   
                    <div class="form-group">
                        <h5>Risultato atteso <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="risultato_competenza" name="risultato_competenza" rows="5" maxlength="4000" class="form-control"><?php echo set_value('risultato_competenza', $competenza['risultato_competenza']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div>  
                    <div class="form-group">
                        <h5>Oggetto di osservazione <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="oggetto_di_osservazione" name="oggetto_di_osservazione" rows="5" maxlength="4000" class="form-control"><?php echo set_value('oggetto_di_osservazione', $competenza['oggetto_di_osservazione']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div> 
                    <div class="form-group">
                        <h5>Indicatori <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="indicatori" name="indicatori" rows="5" maxlength="4000" class="form-control"><?php echo set_value('indicatori', $competenza['indicatori']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 4000 caratteri</i></small></div>
                    </div> 
                    <div class="form-group">
                        <h5>Livello EQF <span class="text-danger">*</span></h5>
                        <input type="text" name="livello_eqf" class="form-control"
                        value="<?php echo set_value('livello_eqf', $competenza['livello_eqf']); ?>">
                        <div class="form-control-feedback"> <small><i>Consulta la pagina dei <a href="https://ec.europa.eu/ploteus/content/descriptors-page" target="_blank">descrittori ufficiali</a></i> </small> </div>
                    </div>  
                    <div class="form-group">
                        <h5>Referenziazione CP 2011</h5>
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
                    <div class="form-group m-t-40 m-b-40">
                        <h5>Abilità <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="id_abilita" name="id_abilita[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_abilita as $abilita)
                                {
                                    ?>
                                    <option value="<?= $abilita['id_abilita'] ?>" selected="selected"><?= $abilita['descrizione_abilita'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>   
                        </div>
                    </div> 
                    <div class="form-group m-t-40 m-b-40">
                        <h5>Conoscenze <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="id_conoscenza" name="id_conoscenza[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_conoscenza as $conoscenza)
                                {
                                    ?>
                                    <option value="<?= $conoscenza['id_conoscenza'] ?>" selected="selected"><?= $conoscenza['descrizione_conoscenza'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>   
                        </div>
                    </div>                       
                    <?php echo form_hidden('id_competenza', $id_competenza); ?>
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

    <!-- TABELLA PROFILI CHE UTILIZZANO LA COMPETENZA -->
    <div class="row m-t-5">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Qualificazioni associate all'Unità di Competenza</h4>
                    <h6 class="card-subtitle">La tabella contiene le qualificazioni associate all'unità di competenza. </h6>
                    <div div class="table-responsive m-t-5 m-b-40">
                        <table id="dt_profili_competenza" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>id_profilo</th>
                                    <th>S.E.P.</th>
                                    <th>Denominazione</th>
                                    <th>Regolamentata</th>
                                    <th>id_stato</th>
                                    <th>Stato</th>
                                    <th>Azione</th> 
                                </tr>                            
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>              
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<script language="javascript" type="text/javascript">
    var tabella_profili_competenza;

    $(document).ready(function () {
        "use strict";
        if ($.fn.select2) {
            $("#id_abilita").select2({
                language: "it",
                placeholder: "",
                allowClear: true,
                minimumInputLength: 5,
                ajax: {
                    url: baseURL + 'admin/unitacompetenza/search_abilita_json',
                    dataType: 'json',
                    type: 'POST',
                    delay: 500,
                    data: function (params) {
                        var query = {
                            search: params.term
                        }

                        // Query parameters will be ?search=[term]&page=[page]
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

            $("#id_conoscenza").select2({
                language: "it",
                placeholder: "",
                allowClear: true,
                minimumInputLength: 5,
                ajax: {
                    url: baseURL + 'admin/unitacompetenza/search_conoscenza_json',
                    dataType: 'json',
                    type: 'POST',
                    delay: 500,
                    data: function (params) {
                        var query = {
                            search: params.term
                        }

                        // Query parameters will be ?search=[term]&page=[page]
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
                        
            $("#codice_cp2011").select2({
                language: "it",
                placeholder: "",
                allowClear: true
            });
        }


        var id_competenza = $("input[name='id_competenza']").val();
        var action = $("input[name='action']").val();
        if (action === 'edit') {
            //CARICA CODICI PROFESSIONI ASSOCIATE
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/unitacompetenza/get_cp2011_competenza_json',
                cache: false,
                async: false,
                data: {id_competenza: id_competenza},
                success: function (data) {
                    $("#codice_cp2011").val(data).trigger("change");
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });            
            
            
            tabella_profili_competenza = $('#dt_profili_competenza').DataTable({
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
                    "url": "<?php echo base_url() . 'admin/unitacompetenza/get_datatables_competenza_profili_json' ?>",
                    "type": "POST",
                    "data": {
                        "id_competenza": id_competenza
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {"targets": [0], "visible": false, "searchable": false},
                    {"targets": [1], "visible": true, "searchable": true, "width": "5%"},
                    {"targets": [2], "visible": true, "searchable": true, "width": "60%"},
                    {
                        "targets": [3],
                        "data": null,
                        "visible": true,
                        "searchable": true,
                        "width": "10%",
                        "className": "text-center",
                        "render": function (data, type) {
                            if (type === "sort" || type === 'type') {
                                return data[3];
                            } else {
                                console.log("reg=" + data[3]);
                                var reg = '';
                                if (parseInt(data[3]) == 1)
                                    reg = 'SI';
                                else
                                    reg = 'NO';
                                return reg;
                            }
                        }
                    },
                    {"targets": [4], "visible": false, "searchable": false},
                    {
                        "targets": [5],
                        "data": null,
                        "className": "text-center",
                        "width": "15%",
                        "render": function (data, type) {
                            if (type === "sort" || type === 'type') {
                                return data[4];
                            } else {
                                var stato = '';
                                if (parseInt(data[4]) === 1)
                                    stato = '<span class="label label-info">' + data[5] + '</span>';
                                else if (parseInt(data[4]) === 2)
                                    stato = '<span class="label label-warning">' + data[5] + '</span>';
                                else if (parseInt(data[4]) === 3)
                                    stato = '<span class="label label-danger">' + data[5] + '</span>';
                                else if (parseInt(data[4]) === 4)
                                    stato = '<span class="label label-inverse">' + data[5] + '</span>';
                                else
                                    stato = '';
                                return stato;
                            }
                        }
                    },
                    {
                        "targets": [6],
                        "data": null,
                        "visible": true,
                        "searchable": false,
                        "orderable": false,
                        "width": "10%",
                        "render": function (data, type) {
                            if (parseInt(data[4]) === 4) {
                                return '';
                            } else {
                                return data[6];
                            }
                        }
                    }
                ],
                "drawCallback": function () {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="popover"]').popover();
                }
            });
        }



        /* Gestione Competenza  */
        $("#btn_reset").on("click", function () {
            window.location.href = baseURL + 'admin/unitacompetenza';
        });

        $('#frm_dati_competenza').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_dati_competenza").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/unitacompetenza/save_competenza',
                cache: false,
                data: formData,
                success: function (data) {
                    swal("Salva informazioni", data.message, data.esito);
                    if ($.fn.DataTable.isDataTable(tabella_profili_competenza)) {
                        tabella_profili_competenza.ajax.reload();
                    }
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });

        });



    });


</script>