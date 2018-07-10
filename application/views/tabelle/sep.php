<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Settori Economico Professionali</h4>
                <h6 class="card-subtitle">Elenco dei Settori Economico Professionali (S.E.P.) definiti nel repertorio regionale</h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_sep" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Codice</th>
                                <th>Descrizione</th>                                                                
                            </tr>
                        </thead>
                    </table>
                </div>  
                <div class="button-group">                    
                    <a href="export_xls/sep" role="button" id="btn_export" name="btn_export" class="btn btn-info">Esporta in Excel</a>      
                </div>                 
            </div>
        </div>  
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#dt_sep').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[1, "asc"]],
            "dom": 'lfrtip',            
            ajax: {
                "url": "<?php echo base_url() . 'admin/tabelle/get_datatables_json' ?>",
                "type": "POST",
                "data": {'table': 'sep'}
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [1], "visible": true, "searchable": true, "width": "10%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "80%"}
            ]
        });
    });
</script>