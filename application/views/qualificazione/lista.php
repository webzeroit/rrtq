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
                "type": "POST"
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
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            }
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
            text: "La qualificazioni sarà ripristinata all'ultima versione prima della cancellazione e lo stato di Non Pubblicata",
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



</script>