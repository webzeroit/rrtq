
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">    
                <?php if ($action === "add")
                {
                    ?>
                    <h4 class="card-title"><?php echo lang('create_user_heading'); ?></h4>
                <?php
                }
                else
                {
                    ?>
                    <h4 class="card-title"><?php echo lang('edit_user_heading'); ?></h4>
                <?php } ?>
                <h6 class="card-subtitle">Inserire e/o selezionare tutte le informazioni richieste per la corretta identificazione dell'utente</h6>
                <form class="m-t-40" id="frm_dati_utente" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Nome <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" id="first_name" name="first_name" maxlength="50" class="form-control"
                                           value="<?php echo set_value('first_name', $user['first_name']); ?>"> 
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h5>Cognome <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" id="last_name" name="last_name" maxlength="50" class="form-control"
                                           value="<?php echo set_value('last_name', $user['last_name']); ?>"> 
                                </div>
                            </div>                         
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h5>Email <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" id="email" name="email" maxlength="100" class="form-control"
                                           value="<?php echo set_value('email', $user['email']); ?>"> 
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h5>Ente / Azienda </h5>
                                <div class="controls">
                                    <input type="text" id="company" name="company" maxlength="100" class="form-control"
                                           value="<?php echo set_value('company', $user['company']); ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <h5>Telefono </h5>
                                <div class="controls">
                                    <input type="text" id="phone" name="phone" maxlength="20" class="form-control"
                                           value="<?php echo set_value('phone', $user['phone']); ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <h5>Username <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" id="username" name="username" maxlength="100" class="form-control"
                                           <?php echo ($action === "edit" ?  "readonly" : ""); ?>
                                           value="<?php echo set_value('username', $user['username']); ?>"> 

                                    <small><i>Da utilizzare per accedere al sistema</i></small>
                                </div>
                            </div>
                        </div>                        

                        <?php if ($action === "add") { ?>

                            <div class="col-md-4">
                                <h5>Password <span class="text-danger">*</span></h5>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" maxlength="20" class="form-control"
                                           value="<?php echo random_string('alnum', 8); ?>"> 
                                    <div class="input-group-append">
                                        <button id="btn_mostra_pwd" class="btn btn-info" type="button">Mostra</button>
                                    </div>
                                    
                                </div>
                                <small><i>Generata dal sistema</i></small>
                            </div>

                        <?php } else { ?>
                            <div class="col-md-">
                                <div class="form-group">
                                    <h5>Ultimo accesso</h5>
                                    <div class="controls">
                                        <input type="text" id="last_login" name="username" class="form-control" readonly 
                                               value="<?php echo set_value('username', date('d/m/Y H:i:s',$user['last_login'])); ?>"> 
                                    </div>
                                </div>
                            </div>    
                         
                        
                        <?php } ?>
                    </div>
                    <h4 class="card-title m-t-40">Assegnazione Ruoli</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="demo-checkbox">
                                    <?php
                                    foreach ($groups as $group)
                                    {
                                        $gID = $group['id'];
                                        $checked = null;
                                        foreach ($currentGroups as $grp)
                                        {
                                            if ($gID == $grp['id'])
                                            {
                                                $checked = ' checked="checked"';
                                                break;
                                            }
                                        }
                                        ?>

                                        <input type="checkbox" id="group_<?php echo $group['id']; ?>" value="<?php echo $group['id']; ?>" name="groups[]" class="filled-in chk-col-light-blue" <?php echo $checked; ?>>
                                        <label for="group_<?php echo $group['id']; ?>"><?php echo htmlspecialchars($group['description'], ENT_QUOTES, 'UTF-8'); ?></label>
                                    <?php } ?>
                                </div> 
                            </div>
                        </div>   
                    </div>              
                    <?php echo form_hidden('id', $user['id']); ?>
                    <?php echo form_hidden('action', $action); ?>  


                    <div class="text-xs-right m-t-20">
                        <button type="submit" class="btn btn-info">Salva</button>
                        <button type="button" id="btn_reset" class="btn btn-inverse">Indietro</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>  
</div>

<script language="javascript" type="text/javascript">

    $(document).ready(function () {
        "use strict";

        /* Gestione Profilo  */
        var id = $("input[name='id']").val();
        var action = $("input[name='action']").val();

        $("#btn_reset").on("click", function () {
            window.location.href = baseURL + 'admin/utenti';
        });

        $("#btn_mostra_pwd").on("click", function () {
            
            if ($('#password').attr('type') === "password") {
                $('#password').attr('type' , 'text');
                $("#btn_mostra_pwd").html('Nascondi');
            } else {
                $('#password').attr('type' , 'password');
                $("#btn_mostra_pwd").html('Mostra');
            }
        });
        
        $('#frm_dati_utente').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_dati_utente").serialize();
            var post_url = 'admin/utenti/save_utente';

            $.ajax({
                type: 'POST',
                url: baseURL + post_url,
                cache: false,
                data: formData,
                success: function (data) {
                    if (parseInt(data.id) > 0) {
                        swal({
                            title: "Salva dati",
                            text: "Operazione effettuata con successo",
                            type: "success"
                        }, function () {
                            if (action === "add")
                            {
                                window.location.href = baseURL + "admin/utenti/gestione/" + data.id;
                            }
                        });
                    } else {
                        swal("Salva informazioni", data.message, data.esito);
                    }
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }

            });

        });

    });


</script>