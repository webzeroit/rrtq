
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">   
                <h4 class="card-title">Descrittore dell'abilità</h4>
                <h6 class="card-subtitle">Inserire le informazioni richieste per la corretta identificazione dell'abilità</h6>
                <form class="m-t-40" id="frm_dati_abilita" autocomplete="off">
                    <div class="form-group">
                        <h5>Descrizione abilità <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <textarea id="descrizione_abilita" name="descrizione_abilita" rows="7" maxlength="1000" class="form-control"><?php echo set_value('descrizione_abilita', $abilita['descrizione_abilita']); ?></textarea>
                        </div>
                        <div class="form-control-feedback"><small><i>Max 1000 caratteri</i></small></div>
                    </div>                                    
                    <?php echo form_hidden('id_abilita', $id_abilita); ?>
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
{
    ?>

    <!-- TABELLA COMPETENZE CHE UTILIZZANO L'ABILITA' -->
    <div class="row m-t-5">
        <div class="col-12">  
            <div class="card">
                <div class="card-body">   
                    <h4 class="card-title">Unità di competenza associate all'abilità</h4>
                    <h6 class="card-subtitle">La tabella contiene le unità di competenza associate all'abilità. </h6>
                    <div div class="table-responsive m-t-5 m-b-40">
                        <table id="dt_competenze_abilita" class="table table-hover table-bordered" cellspacing="0" width="100%">
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

        var id_abilita = $("input[name='id_abilita']").val();
        var action = $("input[name='action']").val();
        if (action === 'edit') {
            $('#dt_competenze_abilita').DataTable({
                "language": {
                    "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
                },
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [[1, "asc"]],
                "dom": 'lfrtip',
                ajax: {
                    "url": "<?php echo base_url() . 'admin/abilita/get_datatables_competenze_abilita_json' ?>",
                    "type": "POST",
                    "data": {
                        "id_abilita": id_abilita
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
            window.location.href = baseURL + 'admin/abilita';
        });

        $('#frm_dati_abilita').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_dati_abilita").serialize();
            $.ajax({
                type: 'POST',
                url: baseURL + 'admin/abilita/save_abilita',
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