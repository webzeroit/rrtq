<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Posta in arrivo</h4>
                <h6 class="card-subtitle">Elenco delle comunicazioni ricevute</h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_messages" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mittente</th>
                                <th>Oggetto</th>
                                <th>Messaggio</th>                                                                
                                <th>Data Ora</th>
                                <th>Azione</th>                                                                
                            </tr>
                        </thead>
                    </table>
                </div> 
                <div class="button-group">                                        
                    <button id="btn_letti" name="btn_letti" type="button" class="btn btn-info">Contrassegna tutti come letti</button>
                </div>                  
            </div>
        </div>  
    </div>
</div>
<script>
    var table_messages;
    $(document).ready(function () {
        table_messages = $('#dt_messages').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[0, "desc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/utenti/get_datatables_in_arrivo_json' ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable":true },
                {"targets": [1], "visible": true, "searchable": true ,"width": "15%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "17%"},
                {"targets": [3], "visible": true, "searchable": true, "width": "50%"},
                {"targets": [4], "visible": true, "searchable": true, "width": "10%", "orderData":[0], "className": "text-center"},
                {
                    "targets": [5],
                    "data": null,
                    "className": "text-center",
                    "orderable": false,
                    "width": "8%",
                    "render": function (data) {
                        var stato = '';
                        if (parseInt(data[5]) === 0)
                            stato = '<a href="javascript:segna_come_letto(' + data[0] + ');" data-toggle="tooltip" data-original-title="Segna come letto"><i class="fa fa-envelope-o"></i></a>';                            
                        else
                            stato = '<span><i class="fa fa-envelope-open-o"></i></span>';
                        return stato;
                    }
                    
                }                
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
        
        
        $('#btn_letti').click( function() {
            swal({
                title: "Sei sicuro?",
                text: "Tutti i messaggi saranno contrassegnati come letti",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {                   
                    $.ajax({
                        type: 'POST',
                        url: baseURL + 'admin/utenti/segna_come_letto',
                        cache: false,                        
                        success: function () {                            
                            table_messages.ajax.reload();
                        },
                        error: function () {
                            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                        }
                    });
                }
            });
        })
        
    });
    
    function segna_come_letto(id_message)
    {
        $('[data-toggle="tooltip"]').tooltip("hide");
        $.ajax({
            type: 'POST',
            url: baseURL + 'admin/utenti/segna_come_letto',
            cache: false,
            data: {id_message: id_message},
            success: function () {                
                table_messages.ajax.reload();
                table_messages.fnDraw();
            },
            error: function () {
                swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
            }
        });
    }
</script>