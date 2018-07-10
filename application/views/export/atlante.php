<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">        
                <h4 class="card-title">Genera file di importazione per la piattaforma ATLANTE</h4>
                <h6 class="card-subtitle">                    
                    L'obiettivo è quello di mantenere aggiornato e sincronizzato il Repertorio Regionale con la Banca dati nazionale (Atlante del Lavoro e delle Qualificazioni).
                    La procedura consente di generare i file di importazione/aggiornamento nella piattaforma nazionale, le specifiche tecniche sul formato e sulle regole di trasferimento sono contenute nel documento <b><i>Procedura di importazione/aggiornamento delle qualificazioni regionali</i></b> disponibile sul sito <a href="http://atlantelavoro.inapp.org/" target="_blank">Atlante Lavoro INAPP</a>.
                </h6>
                <form class="m-t-40" id="frm_export_atlante" autocomplete="off" action="" method="post">
                    <div class="form-group row">
                        <label class="control-label text-right col-md-6">Elementi selezionati:</label>
                        <div class="col-md-6">
                            <p id="count_export" class="form-control-static text-left font-weight-bold">0</p>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <h5>Settore Economico Professionale</h5>
                        <div class="controls">
                            <select id="id_sep" name="id_sep" class="form-control">
                                <option value="0"></option>
                                <?php
                                foreach ($list_sep as $sep)
                                {
                                    ($sep['id_sep'] == $profilo['id_sep']) ? $selected = TRUE : $selected = FALSE;
                                    ?>
                                    <option <?= set_select('id_sep', $sep, $selected) ?> value="<?= $sep['id_sep'] ?>"><?= $sep['descrizione_sep'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <small class="form-control-feedback">Aggiunge alla lista le qualificazioni afferenti al S.E.P. selezionato</small>
                        </div>
                    </div> 
                    <div class="form-group">
                        <h5>Seleziona le qualificazioni da esportare <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select id="id_profilo" name="id_profilo[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple">
                                <?php
                                foreach ($list_profili as $profilo)
                                {
                                    ?>
                                    <option value="<?= $profilo['id_profilo'] ?>"><?= $profilo['titolo_profilo'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>  
                            <small class="form-control-feedback">Sono escluse dalla lista le qualificazioni che si trovano nello stato <span class="text-warning">In Revisione</span> e <span class="text-danger">Non Pubblicato</span></small>
                        </div>
                    </div>  
                    <div class="text-xs-right">
                        <button type="submit" class="btn btn-info">Genera file</button>
                    </div>                       
                </form>                
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        "use strict";
        var std_options_multi = {
            language: "it",
            placeholder: "",
            allowClear: true
        };
        if ($.fn.select2) {
            $(".select2-multiple").select2(std_options_multi);
        }
        $("#id_profilo").on("change", function () {
            $("#count_export").html(($("#id_profilo").find(':selected').length));
        });

        $("#id_sep").change(function () {
            var curr_sep = $("#id_sep").val();
            if (parseInt(curr_sep) > 0) {
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/export/get_profili_sep_json',
                    cache: false,
                    async: false,
                    data: {id_sep: curr_sep},
                    success: function (data) {
                        $("#id_profilo").val(data).trigger("change");
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    });

</script>