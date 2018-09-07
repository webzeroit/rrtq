<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Settori dell'istruzione e della formazione (ISCED-F 2013)</h4>
                <h6 class="card-subtitle">La classificazione internazionale standard dell'istruzione (<a href="https://ec.europa.eu/education/resources/international-standard-classification-education-fields_it" target="_blank">ISCED</a>) è stata messa a punto dall'UNESCO per agevolare il confronto delle statistiche e degli indicatori relativi all'istruzione tra paesi diversi, sulla base di definizioni uniformi e concordate a livello internazionale.</h6>
                <div id="treeview1" class="m-t-40 m-b-40">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
       getTree();
    });

    function getTree() {
        data = null;
        $.ajax({
            type: "GET",
            url: baseURL + 'admin/tabelle/build_isced_tree',
            dataType: "json",
            success: function (response)
            {
                var data = response;
                initTree(data);
            }
        });
        return data;
    }


    function initTree(data) {
        $('#treeview1').treeview({
            selectedBackColor: "#03a9f3",
            onhoverColor: "rgba(0, 0, 0, 0.05)",
            expandIcon: 'fa fa-plus',
            collapseIcon: 'fa fa-minus',
            nodeIcon: 'fa fa-book',
            data: data
        });
        
        $('#treeview1').treeview('collapseAll', { silent: true });
    }
</script>