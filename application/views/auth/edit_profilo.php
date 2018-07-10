<!-- Modifica Profilo -->
<?php $current_user = $this->ion_auth->user()->row_array(); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-body">
            <h4 class="card-title">Gestione dati personali</h4>  
            <h6 class="card-subtitle">Qui puoi inserire e/o modificare le informazioni associate al tuo profilo</h6>
            <form class="m-t-20" id="frm_dati_profilo" autocomplete="off">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Nome <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" id="first_name" name="first_name" maxlength="50" class="form-control"
                                       value="<?php echo set_value('first_name', $current_user['first_name']); ?>"> 
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Cognome <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input type="text" id="last_name" name="last_name" maxlength="50" class="form-control"
                                       value="<?php echo set_value('last_name', $current_user['last_name']); ?>"> 
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
                                       value="<?php echo set_value('email', $current_user['email']); ?>"> 
                            </div>
                        </div>
                    </div>                        
                </div>                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Ente / Azienda </h5>
                            <div class="controls">
                                <input type="text" id="company" name="company" maxlength="100" class="form-control"
                                       value="<?php echo set_value('company', $current_user['company']); ?>"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Telefono </h5>
                            <div class="controls">
                                <input type="text" id="phone" name="phone" maxlength="20" class="form-control"
                                       value="<?php echo set_value('phone', $current_user['phone']); ?>"> 
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <h5>Ruoli assegnati </h5>
                            <div class="controls">
                                <?php
                                $user_groups = $this->ion_auth->get_users_groups()->result_array();
                                foreach ($user_groups as $group):
                                    ?>
                                    <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $group['name'] ?>.png"  width="30" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $group['description'] ?>"  />
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>                     
                </div>                                       

                <div class="text-xs-right m-t-20">
                    <button type="submit" class="btn btn-info">Salva</button>                    
                </div>

            </form>
        </div>
    </div>




    <!-- Modifica Password -->

    <div class="col-md-4">
        <div class="card card-body">
            <h4 class="card-title"><?php echo lang('change_password_heading'); ?></h4>
            <h6 class="card-subtitle">Qui puoi modificare la tua password di accesso</h6>
            <form class="m-t-20" id="frm_cambia_password">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Username </h5>
                            <div class="controls">
                                <input type="text" id="username" name="username" class="form-control" readonly
                                       value="<?php echo set_value('username', $current_user['username']); ?>"> 
                            </div>
                        </div>  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Vecchia password <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input class="form-control" id="old" name="old" type="password" required> 
                            </div>
                        </div>  
                    </div>
                </div>     
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Nuova password <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input class="form-control" id="new" name="new" type="password" required> 
                            </div>
                        </div>  
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Conferma nuova password <span class="text-danger">*</span></h5>
                            <div class="controls">
                                <input class="form-control" id="new_confirm" name="new_confirm" type="password" required> 
                            </div>
                        </div>  
                    </div>
                </div>                 
                <div class="text-xs-right m-t-20">
                    <button type="submit" class="btn btn-info">Salva</button>                    
                </div>
            </form>
        </div>
    </div>
</div>


<script language="javascript" type="text/javascript">
    $(document).ready(function () {
        "use strict";
        $('#frm_dati_profilo').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_dati_profilo").serialize();
            var post_url = 'admin/utenti/save_profilo';

            $.ajax({
                type: 'POST',
                url: baseURL + post_url,
                cache: false,
                data: formData,
                success: function (data) {
                    if (parseInt(data.id) > 0) {
                        swal("Salva informazioni", data.message, data.esito);
                    } else {
                        swal("Salva informazioni", data.message, data.esito);
                    }
                },
                error: function () {
                    swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                }

            });

        });
        
        
        $('#frm_cambia_password').on('submit', function (form) {
            form.preventDefault();
            var formData = $("#frm_cambia_password").serialize();
            var post_url = 'admin/utenti/change_password';

            $.ajax({
                type: 'POST',
                url: baseURL + post_url,
                cache: false,
                data: formData,
                success: function (data) {
                    if (data.id) {
                        swal({
                            title: "Salva dati",
                            text: "Operazione effettuata con successo",
                            type: "success"
                        }, function () {
                            $('#frm_cambia_password')[0].reset();
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

