<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Log Attività</h4>
                <h6 class="card-subtitle">Elenco delle attività effettuate dagli utenti in piattaforma</h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_log" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>user_id</th>
                                <th>Data</th>
                                <th>Evento</th>                                                                
                                <th>Descrizione</th>
                                <th>IP</th>                                                                
                            </tr>
                        </thead>
                    </table>
                </div> 
                <div class="button-group">                    
                    <a href="activitylog/export_xls" role="button" id="btn_export" name="btn_export" class="btn btn-info">Esporta in Excel</a>
                    <button id="btn_delete_log" name="btn_delete_log" type="button" class="btn waves-effect waves-light btn-danger">Cancella Log</button>
                </div>                  
            </div>
        </div>  
    </div>
</div>
<script>
    var table_log;
    $(document).ready(function () {
        table_log = $('#dt_log').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[0, "desc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/activitylog/get_datatables_json' ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": true, "searchable": true, "width": "7%"},
                {"targets": [1], "visible": false, "searchable": true },
                {"targets": [2], "visible": true, "searchable": true, "width": "18%"},
                {"targets": [3], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [4], "visible": true, "searchable": true, "width": "65%"},
                {"targets": [5], "visible": false, "searchable": true }
]
        });
        
        
        $('#btn_delete_log').click( function() {
            swal({
                title: "Sei sicuro?",
                text: "La tabella verrà cancellata e le informazioni non potranno essere più recuerate",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {                   
                    $.ajax({
                        type: 'POST',
                        url: baseURL + 'admin/activitylog/delete_log',
                        cache: false,                        
                        success: function (data) {
                            swal("Salva informazioni", data.message, data.esito);
                            table_log.ajax.reload();
                        },
                        error: function () {
                            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                        }
                    });
                }
            });
        })
        
    });
</script>