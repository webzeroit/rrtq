<?php
$p = 0;
$np = 0;
$r = 0;
$ra = 0;

foreach ($indicatori_stato as $stato)
{
    switch (intval($stato["label"]))
    {
        case 0:
            $p = $stato["value"];
            break;
        case 1:
            $ra = $stato["value"];
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
    <div class="col-lg-9 col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>                
                <h4 class="card-title m-b-0"><i class="mdi mdi-chart-line"> </i> Stato Qualificazioni</h4>
            </div>
            <div class="card-body collapse show">
                <div id="morris-donut-chart" class="ecomm-donute" ></div>
                <ul class="list-inline m-t-20 text-center">
                    <li >
                        <h6 class="text-muted"><i class="fa fa-circle text-info"></i> Pubblicate</h6>
                        <h4 class="m-b-0"><?php echo $p ?></h4>
                    </li>
                    <li>
                        <h6 class="text-muted"><i class="fa fa-circle text-success"></i> Revisioni Validate</h6>
                        <h4 class="m-b-0"><?php echo $ra ?></h4>
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
    <div class="col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_standard_formativi; ?></h1>
                        <h6>Standard Formativi</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-presentation text-info"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>    
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_unita_formative; ?></h1>
                        <h6>Unità Formative</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-book-open-page-variant text-muted"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>    
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <h1 class=""><?php echo $n_moduli; ?></h1>
                        <h6>Moduli</h6>
                    </div>
                    <div class="col-2 align-self-center text-right  p-l-0">
                        <h2 class="m-b-0"><i class="mdi mdi-book text-danger"></i></h2>
                    </div>                    
                </div>
            </div>
        </div>        
    </div>        
</div> 

<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-plus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>                
                <h4 class="card-title m-b-0"><i class="mdi mdi-certificate"> </i> Ultime 10 qualificazioni modificate</h4>                
            </div>
            <div class="card-body collapse">
                <div class="table-responsive">                    
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">S.E.P.</th>
                                <th>Qualificazione</th>
                                <th>Data/Ora</th>
                                <th class="text-center">Stato</th>
                                <th class="text-center">Azione</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultime_modifiche_sp as $qual_mod): ?>
                                <tr>
                                    <td class="text-center" width="5%"><?php echo $qual_mod['id_sep']; ?></td>
                                    <td width="60%"><?php echo htmlspecialchars($qual_mod['titolo_profilo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td width="15%"><?php echo $qual_mod['data_ultima_modifica']; ?></td>
                                    <td class="text-center" width="15%">
                                    <?php 
                                    $stato = '';
                                    if (intval($qual_mod['id_stato_profilo']) === 0)
                                        $stato = '<span class="label label-info">' . $qual_mod['des_stato_profilo'] . '</span>';                                    
                                    if (intval($qual_mod['id_stato_profilo']) === 1)
                                        $stato = '<span class="label label-success">' . $qual_mod['des_stato_profilo'] . '</span>';
                                    else if (intval($qual_mod['id_stato_profilo']) === 2)
                                        $stato  = '<span class="label label-warning">' . $qual_mod['des_stato_profilo'] . '</span>';
                                    else if (intval($qual_mod['id_stato_profilo']) === 3)
                                        $stato = '<span class="label label-danger">' . $qual_mod['des_stato_profilo'] .  '</span>';
                                    else if (intval($qual_mod['id_stato_profilo']) === 4)
                                        $stato = '<span class="label label-inverse">' . $qual_mod['des_stato_profilo'] . '</span>';
                                    
                                    echo $stato; 
                                    ?>
                                    </td>
                                    <td class="text-center" width="5%">
                                    <?php 
                                        $action_link = '<a href="' . base_url() .'admin/qualificazione/gestione/' . $qual_mod['id_profilo'] . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
                                        //$action_link .= '<a href="' . base_url() . '/public/GeneraPDF/' . $qual_mod['id_profilo'] . '" target="_blank" data-toggle="tooltip" data-original-title="Scarica PDF Pubblicato"><i class="fa fa-file-pdf-o text-danger m-r-5"></i></a>';
                                        echo $action_link; 
                                    ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="button-group text-right m-t-10">                    
                    <a href="dashboard/export_xls/qual" role="button" id="btn_export_q" name="btn_export_q" class="btn btn-sm btn-info">Esporta in Excel</a>      
                </div>
            </div>
        </div>             
    </div>              
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-plus"> </i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>                
                <h4 class="card-title m-b-0"><i class="mdi mdi-presentation"></i> Ultimi 10 standard formativi modificati</h4>                
            </div>
            <div class="card-body collapse">
                <div class="table-responsive">                    
                    <table class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">S.E.P.</th>
                                <th>Standard Formativo</th>
                                <th>Data/Ora</th>
                                <th class="text-center">Stato</th>
                                <th class="text-center">Azione</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultime_modifiche_sf as $sf_mod): ?>
                                <tr>
                                    <td class="text-center" width="5%"><?php echo $sf_mod['id_sep']; ?></td>
                                    <td width="60%"><?php echo htmlspecialchars($sf_mod['des_standard_formativo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td width="15%"><?php echo $sf_mod['data_ultima_modifica']; ?></td>
                                    <td class="text-center" width="15%">
                                    <?php 
                                    $stato = '';
                                    if (intval($sf_mod['id_stato_profilo']) === 0)
                                        $stato = '<span class="label label-info">' . $sf_mod['des_stato_profilo'] . '</span>';                                    
                                    if (intval($sf_mod['id_stato_profilo']) === 1)
                                        $stato = '<span class="label label-success">' . $sf_mod['des_stato_profilo'] . '</span>';
                                    else if (intval($sf_mod['id_stato_profilo']) === 2)
                                        $stato  = '<span class="label label-warning">' . $sf_mod['des_stato_profilo'] . '</span>';
                                    else if (intval($sf_mod['id_stato_profilo']) === 3)
                                        $stato = '<span class="label label-danger">' . $sf_mod['des_stato_profilo'] .  '</span>';
                                    else if (intval($sf_mod['id_stato_profilo']) === 4)
                                        $stato = '<span class="label label-inverse">' . $sf_mod['des_stato_profilo'] . '</span>';
                                    
                                    echo $stato; 
                                    ?>
                                    </td>
                                    <td class="text-center" width="5%">
                                    <?php 
                                        $action_link = '<a href="' . base_url() .'admin/standardformativo/gestione/' . $sf_mod['id_standard_formativo'] . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
                                        echo $action_link; 
                                    ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="button-group text-right m-t-10">                    
                    <a href="dashboard/export_xls/stfor" role="button" id="btn_export_sf" name="btn_export_sf" class="btn btn-sm btn-info">Esporta in Excel</a>      
                </div>                
            </div>
        </div>             
    </div>              
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-actions">
                    <a class="" data-action="collapse"><i class="ti-plus"></i></a>
                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
                </div>                
                <h4 class="card-title m-b-0"><i class="mdi mdi-file-export"> </i> Ultime 10 qualificazioni esportate per INAPP</h4>                
            </div>
            <div class="card-body collapse">
                <div class="table-responsive">                    
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th class="text-center">S.E.P.</th>
                                <th>Qualificazione</th>
                                <th class="text-center">Data/Ora Export</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultimi_export as $qual): ?>
                                <tr>
                                    <td class="text-center" width="5%"><?php echo $qual['id_sep']; ?></td>
                                    <td width="75%"><?php echo htmlspecialchars($qual['titolo_profilo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center" width="20%"><?php echo $qual['data_ultimo_export']; ?></td>                                   
                                </tr>
                            <?php endforeach; ?>      
                        </tbody>
                    </table>
                </div>
                <div class="button-group text-right m-t-10">                    
                    <a href="dashboard/export_xls/inapp" role="button" id="btn_export_in" name="btn_export_in" class="btn btn-sm btn-info">Esporta in Excel</a>      
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
            data: [
                {
                    label: "Pubblicate",
                    value: <?php echo $p ?>
                }, 
                {
                    label: "Revisioni Validate",
                    value: <?php echo $ra; ?>
                }, 
                {
                    label: "In Revisione",
                    value: <?php echo $r; ?>
                }, 
                {
                    label: "Non Pubblicate",
                    value: <?php echo $np; ?>
                }],
            resize: true,
            colors: ['#1976d2', '#26dad2', '#ffb22b', '#ef5350']
        });
        // ============================================================== 
        // sales difference
        // ==============================================================        
    });
</script>