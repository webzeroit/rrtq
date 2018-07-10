<?php
$p = 0;
$np = 0;
$r = 0;
foreach ($indicatori_stato as $stato)
{
    switch (intval($stato["label"]))
    {
        case 1:
            $p = $stato["value"];
            break;
        case 2:
            $r = $stato["value"];
            break;
        case 3:
            $np = $stato["value"];
            break;
    }
}
?>  

<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_qualificazioni; ?></h1>
                        <h6>Qualificazioni</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-certificate text-info"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>        
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_competenze; ?></h1>
                        <h6>Unità di Competenza</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-chemical-weapon text-success"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>        
    </div>    
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_abilita; ?></h1>
                        <h6>Descrittori di abilità</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-puzzle text-purple"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>        
    </div>    
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_conoscenze; ?></h1>
                        <h6>Descrittori di conoscenza</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-lightbulb-on text-warning"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>        
    </div>          
</div>


<div class="row">
    <div class="col-lg-5 col-md-5">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>                
                <h4 class="card-title m-b-0">Stato Qualificazioni</h4>
            </div>
            <div class="card-body collapse show">
                <div id="morris-donut-chart" class="ecomm-donute" ></div>
                <ul class="list-inline m-t-20 text-center">
                    <li >
                        <h6 class="text-muted"><i class="fa fa-circle text-info"></i> Pubblicate</h6>
                        <h4 class="m-b-0"><?php echo $p ?></h4>
                    </li>
                    <li>
                        <h6 class="text-muted"><i class="fa fa-circle text-warning"></i> In Revisione</h6>
                        <h4 class="m-b-0"><?php echo $r ?></h4>
                    </li>
                    <li>
                        <h6 class="text-muted"> <i class="fa fa-circle text-danger"></i> Non Pubblicate</h6>
                        <h4 class="m-b-0"><?php echo $np ?></h4>
                    </li>
                </ul>

            </div>
        </div>        
    </div>
    <div class="col-lg-7 col-md-5">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>                
                <h4 class="card-title m-b-0">Ultime qualificazioni esportate per INAPP</h4>                
            </div>
            <div class="card-body collapse show">
                <div class="table-responsive">                    
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Qualificazione</th>
                                <th class="text-center">Data/Ora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultimi_export as $qual): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($qual['titolo_profilo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center"><?php echo convertsDataOraInItalianFormat($qual['data_ultimo_export']); ?></td>                                   
                                </tr>
                            <?php endforeach; ?>      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>             
    </div>        
</div> 

<script>
    $(function () {
        "use strict";

        // ============================================================== 
        // Morris donut chart
        // ==============================================================       
        Morris.Donut({
            element: 'morris-donut-chart',
            data: [{
                    label: "Pubblicate",
                    value: <?php echo $p ?>
                }, {
                    label: "In Revisione",
                    value: <?php echo $r; ?>
                }, {
                    label: "Non Pubblicate",
                    value: <?php echo $np; ?>
                }],
            resize: true,
            colors: ['#1976d2', '#ffb22b', '#ef5350']
        });
        // ============================================================== 
        // sales difference
        // ==============================================================        
    });
</script>