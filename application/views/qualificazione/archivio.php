<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Archivio pubblicazioni</h4>
                <h6 class="card-subtitle">Archivio storico delle qualificazioni e degli standard formativi pubblicati sul portale pubblico.</h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_archivio_pubblicazioni" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id_pubblicazione</th>
                                <th>id_profilo</th>
                                <th>S.E.P.</th>
                                <th>Denominazione</th>                                                                
                                <th>Data pubblicazione</th>
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>                 
            </div>
        </div>  
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dt_archivio_pubblicazioni').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [1, "desc"],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/archiviopubblicazioni/get_datatables_json' ?>",
                "type": "POST"
            },
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false},
                {"targets": [1], "visible": false, "searchable": false},
                {"targets": [2], "visible": true, "searchable": true, "width": "5%"},
                {"targets": [3], "visible": true, "searchable": true, "width": "70%"}, 
                {"targets": [4], "visible": true, "searchable": true, "width": "20%"},
                {"targets": [5], "visible": true, "searchable": false, "width": "5%"}                   
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
    });
</script>