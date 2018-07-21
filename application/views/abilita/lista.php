<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Abilità</h4>
                <h6 class="card-subtitle">Elenco dei descrittori di abilità definiti nel repertorio regionale</h6>
                <div class="table-responsive m-t-10 m-b-40">
                    <table id="dt_abilita" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Abilità</th>
                                <th>Competenze associate</th>                                
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="button-group">                    
                    <a href="abilita/gestione" role="button" id="btn_add_abilita" name="btn_add_abilita" class="btn btn-info">Nuova abilità</a>      
                </div>             
            </div>
        </div>  
    </div>
</div>
<script>
    var tabella_abilita;
    $(document).ready(function () {
        tabella_abilita = $('#dt_abilita').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[1, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/abilita/get_datatables_abilita_json' ?>",
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
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            }
        });
    });
    
    function elimina_abilita(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "L'abilità sarà eliminata definitivamente dal repertorio regionale.",
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
                var id_abilita = id;
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/abilita/elimina_abilita_json',
                    cache: false,
                    data: {id_abilita: id_abilita },
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_abilita.ajax.reload();
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }      
</script>