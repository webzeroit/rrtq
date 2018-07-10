<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo lang('index_heading'); ?></h4>
                <h6 class="card-subtitle"><?php echo lang('index_subheading'); ?></h6>
                <div class="table-responsive m-t-20 m-b-40">
                    <table id="dt_utenti" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo lang('index_fname_th'); ?></th>
                                <th><?php echo lang('index_lname_th'); ?></th>
                                <th><?php echo lang('index_email_th'); ?></th>
                                <th><?php echo lang('index_groups_th'); ?></th>
                                <th><?php echo lang('index_status_th'); ?></th>
                                <th><?php echo lang('index_action_th'); ?></th>                                                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php foreach ($user['groups'] as $group): ?>
                                            <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $group['name'] ?>.png"  width="30" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $group['description'] ?>"  />
                                        <?php endforeach ?>
                                    </td>
                                    <td>                                        
                                        <a href="javascript:conferma(<?php echo $user['id']; ?>,<?php echo ($user['active']) ? 0 : 1; ?>)" ><?php echo ($user['active']) ? lang('index_active_link') : lang('index_inactive_link'); ?></a>
                                    </td>


                                    <td><a href="utenti/gestione/<?php echo $user['id'] ?>" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a></td>
                                </tr>
                            <?php endforeach; ?>                            
                        </tbody>
                    </table>
                </div> 
                <div class="button-group">                    
                    <a href="utenti/gestione" role="button" id="btn_crea_utente" name="btn_crea_utente" class="btn btn-info">Nuovo Utente</a>      
                </div>                  
            </div>
        </div>  
    </div>
</div>
<script>
    var table_utente;
    $(document).ready(function () {
        table_utente = $('#dt_utenti').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.lang"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": false, //Feature control DataTables' server-side processing mode.
            "dom": 'lfrtip',
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": true, "searchable": true, "width": "17%"},
                {"targets": [1], "visible": true, "searchable": true, "width": "17%"},
                {"targets": [2], "visible": true, "searchable": true, "width": "31%"},
                {"targets": [3], "visible": true, "searchable": true, "width": "15%"},
                {"targets": [4], "visible": true, "searchable": true, "width": "10%", "className": "text-center"},
                {"targets": [5], "visible": true, "searchable": false, "orderable": false, "width": "10%"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            }
        });
    });

    function conferma(id, tipo)
    {
        var op = "Attivazione ";
        if (tipo === 0) {
            op = "Disattivazione ";
        }
        swal({
            title: op + " utenza",
            text: "Vuoi procedere?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                var post_url = "";
                if (tipo === 0) {
                    post_url = baseURL + "admin/utenti/deactivate/" + id;
                } else {
                    post_url = baseURL + "admin/utenti/activate/" + id;
                }

                $.ajax({
                    type: 'POST',
                    url: post_url,
                    cache: false,
                    success: function (data) {
                        swal({
                            title: "Salva informazioni",
                            text: data.message,
                            type: data.esito
                        }, function () {
                            if (data.esito === "success") {
                                window.location.href = baseURL + "admin/utenti";
                            }
                        });
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel salvataggio dei dati', 'error');
                    }
                });
            }
        });
    }

</script>