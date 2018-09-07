<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Unità Formative</h4>
                <h6 class="card-subtitle">Elenco delle unità formative definite negli standard formativi del repertorio regionale</h6>
                <div class="table-responsive m-t-5 m-b-40">
                    <table id="dt_uf_standard" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id_unita_formativa</th>
                                <th>id_standard_formativo</th>
                                <th>id_profilo</th>
                                <th>id_competenza</th>                                        
                                <th>Denominazione unità formativa</th>
                                <th>Durata min. ore</th>
                                <th>% Variaz. +/-</th>
                                <th>des_eventuali_vincoli</th>
                                <th>% FAD</th>
                                <th>Seq.</th>
                                <th>Azione</th> 
                            </tr>
                        </thead>
                    </table>
                </div> 
                <div class="button-group">                    
                    <a href="unitaformativa/export_xls" role="button" id="btn_export" name="btn_export" class="btn btn-info">Esporta in Excel</a>      
                </div>                  
            </div>
        </div>  
    </div>
</div>

<script>
    var tabella_uf;
    $(document).ready(function () {
        tabella_uf = $('#dt_uf_standard').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "paging": true,
            "lengthChange": true,
            "order": [[4, "asc"]], //ordina per titolo
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/unitaformativa/get_datatables_lista_uf_json' ?>",
                "type": "POST"                
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false}, //id_unita_formativa
                {"targets": [1], "visible": false, "searchable": false}, //id_standard_formativo
                {"targets": [2], "visible": false, "searchable": false}, //id_profilo
                {"targets": [3], "visible": false, "searchable": false}, //id_competenza
                {"targets": [4], "visible": true,  "searchable": true,  "width": "50%"}, //titolo_unita_formativa
                {"targets": [5], "visible": true,  "searchable": true,  "width": "18%", "className": "text-right" }, //ore_min_durata_uf
                {"targets": [6], "visible": true,  "searchable": true,  "width": "15%", "className": "text-right"}, //perc_varianza
                {"targets": [7], "visible": false, "searchable": false }, //des_eventuali_vincoli
                {"targets": [8], "visible": true,  "searchable": true,  "width": "10%", "className": "text-right"}, //perc_fad_uf
                {"targets": [9], "visible": false,  "searchable": false }, //sequenza
                {"targets": [10], "visible": true, "searchable": false, "width": "7%", "orderable": false, "className": "text-center"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });        
    });
            
</script>