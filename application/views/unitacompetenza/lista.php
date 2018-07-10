<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Unità di Competenza</h4>
                <h6 class="card-subtitle">Elenco delle unità di competenza definite nel repertorio regionale</h6>
                <div class="table-responsive m-t-10 m-b-40">
                    <table id="dt_competenza" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titolo</th>
                                <th>Descrizione</th>
                                <th>Qualificazioni associate</th>                                
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="button-group">                    
                    <a href="unitacompetenza/gestione" role="button" id="btn_add_competenza" name="btn_add_competenza" class="btn btn-info">Nuova unità di competenza</a>      
                </div>             
            </div>
        </div>  
    </div>
</div>
<script>
    var tabella_competenze;
    $(document).ready(function () {
        tabella_competenze = $('#dt_competenza').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[1, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/unitacompetenza/get_datatables_unitacompetenza_json' ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false},
                {"targets": [1], "visible": true, "searchable": true, "width": "40%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "40%"},
                {"targets": [3], "visible": true, "searchable": true, "width": "10%", "className": "text-center"},
                {"targets": [4], "visible": true, "searchable": false, "orderable": false, "width": "10%"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            }
        });
    });
    
    
    
    /*ONLY WITH ADMIN ROLE*/
    function elimina_competenza(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La competenza sarà eliminata definitivamente dal repertorio regionale.",
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
                var id_competenza = id;
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/unitacompetenza/elimina_competenza_json',
                    cache: false,
                    data: {id_competenza: id_competenza },
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_competenze.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }            
</script>