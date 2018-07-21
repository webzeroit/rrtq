<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Aree di Attività</h4>
                <h6 class="card-subtitle">Elenco delle aree di attività definite nel repertorio regionale</h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_ada" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S.E.P.</th>
                                <th>Codice</th>                                                                
                                <th>Descrizione</th>                                                                
                            </tr>
                        </thead>
                    </table>
                </div> 
                <div class="button-group">                    
                    <a href="export_xls/ada" role="button" id="btn_export" name="btn_export" class="btn btn-info">Esporta in Excel</a>      
                </div>                  
            </div>
        </div>  
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dt_ada').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[2, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/tabelle/get_datatables_json' ?>",
                "type": "POST",
                "data": { 'table' : 'ada' }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [1], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [3], "visible": true, "searchable": true, "width": "70%"}
            ]
        });
    });
</script>