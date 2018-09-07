<!-- MODAL ABILITA -->
<div class="modal fade" id="UcModal" tabindex="-1" role="dialog" aria-labelledby="UcModalLabel1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card card-outline-warning">
            <div class="modal-header card-header">
                <h4 class="modal-title text-white" id="UcModalLabel1">Unità di Competenza</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form>
                    <div id="withData" class="form-group m-b-0">
                        <h5>Titolo competenza</h5>
                        <p class="text-justify" id="titolo_competenza"></p>
                        <br/>
                        <h5>Risultato Atteso</h5>
                        <p class="text-justify" id="risultato_competenza"></p>
                        <br/>
                        <h5>Livello EQF</h5>
                        <p class="text-justify" id="livello_eqf"></p>    
                        <div id="div_dettaglio_competenza" class="row m-t-30">
                            <div class="col-lg-6">
                                <h5>Abilità</h5>
                                <ol id="list_abilita" class="list-icons">

                                </ol>
                            </div>
                            <div class="col-lg-6">
                                <h5>Conoscenze</h5>
                                <ol id="list_conoscenza" class="list-icons">
                                </ol>
                            </div>                                    
                        </div>
                        <div id="div_ridondanze" class="row m-t-20 m-b-0">
                            <div class="col-lg-12 text-center">
                                <span class="card-subtitle"><small><i>* Le ridondanze di abilità e conoscenze, se presenti, risultano evidenziate in rosso</i></small></span>
                            </div>
                        </div>
                    </div>  
                    <div id="withoutData" class="form-group m-b-0">
                        <h4 class="text-center">Nessun elemento selezionato</h4>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-inverse waves-effect text-left" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">

function loadUc(id, id_profilo){
    if (id === undefined || id === null) {
        return;
    }
    if (id_profilo === undefined || id_profilo === 0) {
        $("#div_ridondanze").hide();
    } else {
        $("#div_ridondanze").show();
    }    
    
    
    var curr_competenza = id;
    //clear
    $("#titolo_competenza").html("");
    $("#risultato_competenza").html("");
    $("#livello_eqf").html("");    
    $("#list_abilita").html("");
    $("#list_conoscenza").html("");
    $("#withData").hide();
    $("#withoutData").show();
    
    /*DATI UC*/
    $.ajax({
         type: 'POST',
         url: baseURL + 'admin/qualificazione/get_competenza_json',
         cache: false,
         async: false,
         data: {id_competenza: curr_competenza},
         success: function (data) {
            if (data !== null){
                $("#withData").show();
                $("#withoutData").hide();                
                $("#titolo_competenza").html(data.titolo_competenza);
                $("#risultato_competenza").html(data.risultato_competenza);
                if (data.livello_eqf === null) 
                    $("#livello_eqf").html("N/D");
                else
                    $("#livello_eqf").html(data.livello_eqf);
            } 
         },
         error: function () {
             swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
         }
     });    
    
    /*LISTA ABILITA*/
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/qualificazione/list_competenza_abilita_json',
        cache: false,
        async: false,
        data: {id_competenza: curr_competenza},
        success: function (data) {
            var lista_1 = '';
            $.each(data, function (idx, obj) {
                lista_1 += '<li id="'+ obj.id_abilita +'"><small>' + obj.descrizione_abilita  + '</small></li>';
            });
            $("#list_abilita").html(lista_1);
            if (parseInt(id_profilo) > 0)
            {
                evidenziaAbilita(id_profilo);
            }
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
        }
    });
    /*LISTA CONOSCENZE*/
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/qualificazione/list_competenza_conoscenza_json',
        cache: false,
        async: false,
        data: {id_competenza: curr_competenza},
        success: function (data) {
            var lista_2 = '';
            $.each(data, function (idx, obj) {
                lista_2 += '<li id="'+ obj.id_conoscenza +'"><small>' + obj.descrizione_conoscenza + '</small></li>';
            });   
            $("#list_conoscenza").html(lista_2);
            if (parseInt(id_profilo) > 0)
            {
                evidenziaConoscenze(id_profilo);
            }            
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
        }
    });
    
    
}

function evidenziaAbilita(id_profilo)
{
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/qualificazione/list_ridondanze_abilita_json',
        cache: false,
        async: false,
        data: {id_profilo: id_profilo},
        success: function (data) {            
            $.each(data, function (idx, obj) {
                $('#list_abilita #'+ obj.id_abilita + ' small').addClass('text-danger');                
            });
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
        }
    });
}

function evidenziaConoscenze(id_profilo)
{
    $.ajax({
        type: 'POST',
        url: baseURL + 'admin/qualificazione/list_ridondanze_conoscenza_json',
        cache: false,
        async: false,
        data: {id_profilo: id_profilo},
        success: function (data) {            
            $.each(data, function (idx, obj) {
                $('#list_conoscenza #'+ obj.id_conoscenza + ' small').addClass('text-danger');        
            });
        },
        error: function () {
            swal('Attenzione', 'Si sono verificati degli errori nel gestire la richiesta', 'error');
        }
    });    
}

</script>