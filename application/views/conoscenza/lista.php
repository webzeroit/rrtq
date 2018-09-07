<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Conoscenze</h4>
                <h6 class="card-subtitle">Elenco dei descrittori di conoscenza definiti nel repertorio regionale</h6>
                <div class="table-responsive m-t-10 m-b-40">
                    <table id="dt_conoscenza" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Conoscenza</th>
                                <th>Competenze associate</th>                                
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="button-group">                    
                    <a href="conoscenza/gestione" role="button" id="btn_add_conoscenza" name="btn_add_conoscenza" class="btn btn-info">Nuova conoscenza</a>      
                </div>             
            </div>
        </div>  
    </div>
</div>
<script>
    var tabella_conoscenza;
    $(document).ready(function () {
        tabella_conoscenza = $('#dt_conoscenza').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[1, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/conoscenza/get_datatables_conoscenza_json' ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false},
                {"targets": [1], "visible": true, "searchable": true, "width": "80%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "10%", "className": "text-center"},
                {"targets": [3], "visible": true, "searchable": false, "orderable": false, "width": "10%"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
    });
    
   /*ONLY WITH ADMIN ROLE*/
    function elimina_conoscenza(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "La conoscenza sarà eliminata definitivamente dal repertorio regionale.",
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
                var id_conoscenza = id;
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/conoscenza/elimina_conoscenza_json',
                    cache: false,
                    data: {id_conoscenza: id_conoscenza },
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_conoscenza.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }                
</script>