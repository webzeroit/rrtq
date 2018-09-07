<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p>Le Qualificazioni contenute nel Repertorio Regionale costituiscono il riferimento per il "<b>Quadro Nazionale delle Qualificazioni Regionali</b>", nell'ambito del Repertorio nazionale, di cui al D.Lgs. n. 13/2013 e al D.I. 30/06/2015).</p>
                <p>Ad ogni qualificazione dell'elenco sono associati i corrispondenti <b>Standard Formativi</b> (durate orarie, eventuale possibilità di formazione a distanza, requisiti minimi di ingresso dei partecipanti, attestazione rilasciata al termine del percorso, ecc.)</p>
            </div>
        </div>
    </div>
</div>

<!--RICERCA-->
<div id="form-filter-div" class="row" style="display:none;">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Ricerca avanzata</h4>               
            </div>
            <div class="card-body">
                <form id="form-filter" novalidate autocomplete="off">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label">Settore Economico Professionale</label>
                                    <select id="id_sep" name="id_sep" class="form-control">
                                        <option value="0">Tutti</option>
                                        <?php foreach ($list_sep as $sep){ ?>
                                            <option value="<?= $sep['id_sep'] ?>"><?= $sep['descrizione_sep'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Livello EQF</label>
                                    <select id="livello_eqf" name="livello_eqf" class="form-control">
                                        <option value="0">Tutti</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                            </div>                               
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label class="control-label">Denominazione qualificazione</label>
                                        <input type="text" id="titolo_profilo" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    <div class="form-actions">
                        <button type="button" id="btn-filter" class="btn btn-info"><i class="fa fa-search"></i> Cerca</button>
                        <button type="button" id="btn-reset" class="btn btn-secondary"><i class="fa fa-eraser"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Qualificazioni</h4>
                <h6 class="card-subtitle">Elenco delle qualificazioni presenti nel repertorio regionale e relativi standard formativi</h6>
                <div class="table-responsive m-t-10 m-b-40">
                    <table id="dt_profilo" class="display table color-table info-table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>S.E.P.</th>
                                <th>Denominazione qualificazione</th>
                                <th>Livello EQF</th>
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="button-group">                    
                    <button id="btn_ricerca" name="btn_ricerca" class="btn btn-info">Ricerca avanzata</button>
                </div>             
            </div>
        </div>  
    </div>
</div>
<script>
    var tabella_qualificazioni;
    $(document).ready(function () {
        tabella_qualificazioni = $('#dt_profilo').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian_p.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [[1, "asc"],[2, "asc"]],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'public/ricerca/get_datatables_profili_json' ?>",
                "type": "POST",
                "data":  function (data) {
                    if ($('#titolo_profilo').val() !== "")
                    {
                       data.titolo_profilo = $('#titolo_profilo').val();                   
                    }
                    if ($('#id_sep').val() !== "0")
                    {
                       data.id_sep = $('#id_sep').val();                
                    }
                    if ($('#livello_eqf').val() !== "0")
                    {
                       data.livello_eqf = $('#livello_eqf').val();                
                    }
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false},
                {"targets": [1], "visible": true, "searchable": true, "width": "5%", "className": "text-center"},
                {"targets": [2], "visible": true, "searchable": true, "width": "65%"},
                {"targets": [3], "visible": true, "searchable": false, "width": "12%","className": "text-center"},              
                {"targets": [4], "visible": true, "searchable": false, "orderable": false, "width": "8%", "className": "text-center"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
        
        $('#btn_ricerca').on("click", function () {
            $("#form-filter-div").slideDown();
            $(window).scrollTop($('#form-filter-div').offset().top - 90);  
        });
        
        $('#btn-filter').click(function () { //button filter event click
            tabella_qualificazioni.ajax.reload(); //just reload table
        });

        $('#btn-reset').click(function () { //button reset event click
            $('#form-filter')[0].reset();
            if ($.fn.select2) {
                $('#form-filter select.select2').val('').trigger('change');
            }        
            $("#form-filter-div").slideUp();
            tabella_qualificazioni.ajax.reload(); //just reload table
        });
        
        $('#form-filter-div').submit( function(e){ 
            e.preventDefault();
            tabella_qualificazioni.ajax.reload(); //just reload table
        });
    });    
</script>    