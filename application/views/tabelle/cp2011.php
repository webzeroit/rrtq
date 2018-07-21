<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Codici Professioni ISTAT 2011</h4>
                <h6 class="card-subtitle">Classificazione delle Professioni (CP2011) definite nel repertorio regionale</h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_cp2011" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Codice</th>
                                <th>Descrizione</th>                                                                
                            </tr>
                        </thead>
                    </table>
                </div>  
                <div class="button-group">                    
                    <a href="export_xls/cp2011" role="button" id="btn_export" name="btn_export" class="btn btn-info">Esporta in Excel</a>      
                </div>                  
            </div>
        </div>  
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dt_cp2011').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[0, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/tabelle/get_datatables_json' ?>",
                "type": "POST",
                "data": { 'table' : 'cp2011' }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [1], "visible": true, "searchable": true, "width": "90%"}
            ]
        });
    });
</script>