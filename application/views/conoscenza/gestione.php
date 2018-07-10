<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">   
                <h4 class="card-title">Descrittore della conoscenza</h4>
                <h6 class="card-subtitle">Inserire le informazioni richieste per la corretta identificazione della conoscenza</h6>
                <form class="m-t-40" id="frm_dati_conoscenza" autocomplete="off">
                    <div class="form-group">
                        <h5>Descrizione conoscenza <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="descrizione_conoscenza" name="descrizione_conoscenza" rows="7" maxlength="1000" class="form-control"><?php echo set_value('descrizione_conoscenza', $conoscenza['descrizione_conoscenza']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 1000 caratteri</i></small></div>
                    </div>                                    
                    <?php echo form_hidden('id_conoscenza', $id_conoscenza); ?>
                    <?php echo form_hidden('action', $action); ?>                    
                    <div class="text-xs-right m-t-40">
                        <button type="submit" class="btn btn-info">Salva</button>
                        <button type="button" id="btn_reset" class="btn btn-inverse">Indietro</button>
                    </div>  
                </form>

            </div>
        </div>
    </div>
</div>
<?php if ($action === "edit")
{ ?>

    <!-- TABELLA COMPETENZE CHE UTILIZZANO LA CONOSCENZA -->
    <div class="row m-t-5">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Unità di competenza associate alla conoscenza</h4>
                    <h6 class="card-subtitle">La tabella contiene le unità di competenza associate alla conoscenza. </h6>
                    <div div class="table-responsive m-t-5 m-b-40">
                        <table id="dt_competenze_conoscenza" class="table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titolo</th>
                                    <th>Descrizione</th>
                                    <th>Qualificazioni associate</th>                                
                                    <th>Azione</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>              
                </div>
            </div>
        </div>
    </div>

<?php } ?>


<script>
    $(document).ready(function () {
        "use strict";

        var id_conoscenza = $("input[name='id_conoscenza']").val();
        var action = $("input[name='action']").val();
        if (action === 'edit') {
            $('#dt_competenze_conoscenza').DataTable({
                "language": {
                    "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
                },
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [[1, "asc"]],
                "dom": 'lfrtip',                
                ajax: {
                    "url": "<?php echo base_url() . 'admin/conoscenza/get_datatables_competenze_conoscenza_json' ?>",
                    "type": "POST",
                    "data": {
                        "id_conoscenza": id_conoscenza
                    }
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {"targets": [0], "visible": false, "searchable": false},
                    {"targets": [1], "visible": true, "searchable": true, "width": "40%"},
                    {"targets": [2], "visible": true, "searchable": true, "width": "40%"},
                    {"targets": [3], "visible": true, "searchable": true, "width": "10%", "className": "text-center"},
                    {"targets": [4], "visible": true, "searchable": false, "orderable": false, "width": "10%"}
                ],
                "drawCallback": function () {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="popover"]').popover();
                }
            });
        }



        /* Gestione Competenza  */
        $("#btn_reset").on("click", function () {
            window.location.href = baseURL + 'admin/conoscenza';
        });

        $('#frm_dati_conoscenza').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_dati_conoscenza").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/conoscenza/save_conoscenza',
                cache: false,
                data: formData,
                success: function (data) {
                    swal("Salva informazioni", data.message, data.esito);
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }
            });

        });



    });


</script>