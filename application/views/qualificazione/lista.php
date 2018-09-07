<!--RICERCA-->
<div id="form-filter-div" class="row" style="display:none;">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Ricerca avanzata</h4>               
            </div>
            <div class="card-body">
                <form id="form-filter" novalidate autocomplete="off">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Settore Economico Professionale</label>
                                    <select id="id_sep" name="id_sep" class="form-control">
                                        <option value="0">Tutti</option>
                                        <?php foreach ($list_sep as $sep){ ?>
                                            <option value="<?= $sep['id_sep'] ?>"><?= $sep['descrizione_sep'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Livello EQF</label>
                                    <select id="livello_eqf" name="livello_eqf" class="form-control">
                                        <option value="0">Tutti</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>                               
                        </div>  
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="controls">
                                        <label class="control-label">Denominazione qualificazione</label>
                                        <input type="text" id="titolo_profilo" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Regolamentata</label>
                                    <select id="flg_regolamentato" name="flg_regolamentato" class="form-control">
                                        <option value="-1">Tutte</option>
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>
                                    </select>
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Stato</label>
                                    <select id="id_stato_profilo" name="id_stato_profilo" class="form-control">
                                        <option value="-1">Tutti</option>
                                        <option value="0">Pubblicato</option>
                                        <option value="1">Revisioni Validate</option>
                                        <option value="2">In Revisione</option>
                                        <option value="3">Non Pubblicato</option>
                                    </select>
                                </div>
                            </div>                             
                        </div>                    
                    </div>
                    <div class="form-actions">
                        <button type="button" id="btn-filter" class="btn btn-info"><i class="fa fa-search"></i> Cerca</button>
                        <button type="button" id="btn-reset" class="btn btn-secondary"><i class="fa fa-eraser"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Qualificazioni</h4>
                <h6 class="card-subtitle">Elenco delle qualificazioni presenti nel repertorio regionale</h6>
                <div class="table-responsive m-t-10 m-b-40">
                    <table id="dt_profilo" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S.E.P.</th>
                                <th>Denominazione</th>
                                <th>id_stato</th>
                                <th>Stato</th>
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="button-group">                    
                    <a href="qualificazione/gestione" role="button" id="btn_add_profilo" name="btn_add_profilo" class="btn btn-info">Nuova qualificazione</a>      
                    <button id="btn_ricerca" name="btn_ricerca" class="btn btn-outline-info">Ricerca avanzata</button>
                </div>             
            </div>
        </div>  
    </div>
</div>
<script>
    var tabella_qualificazioni;
    $(document).ready(function () {
        tabella_qualificazioni = $('#dt_profilo').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[1, "asc"],[2, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/Qualificazione/get_datatables_profili_json' ?>",
                "type": "POST",
                "data":  function (data) {
                    if ($('#titolo_profilo').val() !== "")
                    {
                       data.titolo_profilo = $('#titolo_profilo').val();                   
                    }
                    if ($('#id_sep').val() !== "0")
                    {
                       data.id_sep = $('#id_sep').val();                
                    }
                    if ($('#livello_eqf').val() !== "0")
                    {
                       data.livello_eqf = $('#livello_eqf').val();                
                    }
                    data.id_stato_profilo = $('#id_stato_profilo').val();                
                    data.flg_regolamentato = $('#flg_regolamentato').val();                
                    
                }                
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false},
                {"targets": [1], "visible": true, "searchable": true, "width": "5%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "65%"},
                {"targets": [3], "visible": false, "searchable": false},
                {
                    "targets": [4],
                    "data": null,
                    "className": "text-center",
                    "width": "15%",
                    "render": function (data, type) {
                        if (type === "sort" || type === 'type') {
                            return data[3];
                        } else {
                            var stato = '';
                            if (parseInt(data[3]) === 0)
                                stato = '<span class="label label-info">' + data[4] + '</span>';                            
                            else if (parseInt(data[3]) === 1)
                                stato = '<span class="label label-success">' + data[4] + '</span>';
                            else if (parseInt(data[3]) === 2)
                                stato = '<span class="label label-warning">' + data[4] + '</span>';
                            else if (parseInt(data[3]) === 3)
                                stato = '<span class="label label-danger">' + data[4] + '</span>';
                            else if (parseInt(data[3]) === 4)
                                stato = '<span class="label label-inverse">' + data[4] + '</span>';
                            else
                                stato = '';
                            return stato;
                        }
                    }
                },
                {"targets": [5], "visible": true, "searchable": false, "orderable": false, "width": "15%"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
        
        
        
        $('#btn_ricerca').on("click", function () {
            $("#form-filter-div").slideDown();
            $(window).scrollTop($('#form-filter-div').offset().top - 130);  
        });
        
        $('#btn-filter').click(function () { //button filter event click
            tabella_qualificazioni.ajax.reload(); //just reload table
        });

        $('#btn-reset').click(function () { //button reset event click
            $('#form-filter')[0].reset();
            if ($.fn.select2) {
                $('#form-filter select.select2').val('').trigger('change');
            }        
            $("#form-filter-div").slideUp();
            tabella_qualificazioni.ajax.reload(); //just reload table
        });  
        
        $('#form-filter-div').submit( function(e){ 
            e.preventDefault();
            tabella_qualificazioni.ajax.reload(); //just reload table
        });        
    });
    
    function sospendi_pubblicazione(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La qualificazioni non sarà più visibile all'utenza esterna",
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
                var id_profilo = id;
                var action = "stop";
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/edita_pubblicazione_json',
                    cache: false,
                    data: {id_profilo: id_profilo, action: action},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_qualificazioni.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }    
    
    function avvia_pubblicazione(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La qualificazioni sarà resa disponibile all'utenza esterna",
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
                var id_profilo = id;
                var action = "start";
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/edita_pubblicazione_json',
                    cache: false,
                    data: {id_profilo: id_profilo, action: action},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_qualificazioni.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }      
    
    function approva_revisione(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La revisioni saranno approvate e la qualificazione potrà essere pubblicata",
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
                var id_profilo = id;
                var action = "approve";
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/edita_pubblicazione_json',
                    cache: false,
                    data: {id_profilo: id_profilo, action: action},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_qualificazioni.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }       
    

    function elimina_pubblicazione(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La qualificazioni sarà eliminata dal repertorio regionale",
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
                var id_profilo = id;
                var action = "delete";
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/edita_pubblicazione_json',
                    cache: false,
                    data: {id_profilo: id_profilo, action: action},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_qualificazioni.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }        

    /*ONLY WITH ADMIN ROLE*/
    function elimina_qualificazione(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La qualificazioni sarà eliminata definitivamente dal repertorio regionale. Se non sai cosa stai facendo, desisti!",
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
                var id_profilo = id;
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/elimina_qualificazione_json',
                    cache: false,
                    data: {id_profilo: id_profilo },
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_qualificazioni.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }        

    function ripristina_qualificazione(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La qualificazioni sarà ripristinata all'ultima versione prima della cancellazione",
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
                var id_profilo = id;
                var action = "restore";
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/qualificazione/edita_pubblicazione_json',
                    cache: false,
                    data: {id_profilo: id_profilo, action: action},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_qualificazioni.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }    



</script>