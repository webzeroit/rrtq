<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Standard Formativi</h4>
                <h6 class="card-subtitle">Elenco degli standard formativi presenti nel repertorio regionale. E' possibile aggiungere un nuovo standard formativo direttamente nella scheda di gestione della Qualificazione</h6>
                <div class="table-responsive m-t-10 m-b-40">
                    <table id="dt_standard_formativo" class="display table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Denominazione Standard Formativo</th>
                                <th>id_stato</th>
                                <th>Stato Qualificazione</th>
                                <th>Azione</th>
                            </tr>
                        </thead>
                    </table>
                </div>                            
            </div>
        </div>  
    </div>
</div>
<script>
    var tabella_standard_formativi;
    $(document).ready(function () {
        tabella_standard_formativi = $('#dt_standard_formativo').DataTable({
            "language": {
                "url": baseURL + "/assets/plugins/datatables-plugins/i18n/Italian.json"
            },
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [1, "asc"],
            "dom": 'lfrtip',
            ajax: {
                "url": "<?php echo base_url() . 'admin/standardformativo/get_datatables_st_formativo_json' ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {"targets": [0], "visible": false, "searchable": false},
                {"targets": [1], "visible": true, "searchable": true, "width": "70%"},
                {"targets": [2], "visible": false, "searchable": false},
                {
                    "targets": [3],
                    "data": null,
                    "className": "text-center",
                    "width": "20%",
                    "render": function (data, type) {
                        if (type === "sort" || type === "type") {
                            return data[2];
                        } else {
                            var stato = '';
                            if (parseInt(data[2]) === 0)
                                stato = '<span class="label label-info">' + data[3] + '</span>';                            
                            else if (parseInt(data[2]) === 1)
                                stato = '<span class="label label-success">' + data[3] + '</span>';
                            else if (parseInt(data[2]) === 2)
                                stato = '<span class="label label-warning">' + data[3] + '</span>';
                            else if (parseInt(data[2]) === 3)
                                stato = '<span class="label label-danger">' + data[3] + '</span>';
                            else if (parseInt(data[2]) === 4)
                                stato = '<span class="label label-inverse">' + data[3] + '</span>';
                            else
                                stato = '';
                            return stato;
                        }
                    }
                },
                {"targets": [4], "visible": true, "searchable": false, "orderable": false, "width": "10%"}
            ],
            "drawCallback": function () {
                $('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
                $('[data-toggle="popover"]').popover({trigger : 'hover'});
            }
        });
    });
    
    /*ONLY WITH ADMIN ROLE*/
    function del_standard(id)
    {
        swal({
            title: "Sei sicuro?",
            text: "Verrà cancellata la riga selezionata",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                //PROSEGUI		                
                $.ajax({
                    type: 'POST',
                    url: baseURL + 'admin/standardformativo/elimina_standard_formativo_json',
                    cache: false,
                    data: {id_standard_formativo: id},
                    success: function (data) {
                        swal("Salva informazioni", data.message, data.esito);
                        tabella_standard_formativi.ajax.reload();                       
                    },
                    error: function () {
                        swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
                    }
                });
            }
        });
    }
</script>