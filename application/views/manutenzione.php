<!doctype html>
<?php
$base_url = "http://" . $_SERVER['SERVER_NAME'] . "/rrtq/";

// Function to get the client ip address
function get_client_ip_env()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}
?>
<html lang="it">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Area applicativa">
        <meta name="author" content="">
        <link rel="icon" href="assets/img/favicon.png">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">	
        <title>Manutenzione Piattaforma CAPIRE</title>
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="py-3 text-center">
                <img class="d-block mx-auto mb-2" src="<?php echo $base_url; ?>assets/images/logo-regione-campania-big.png" alt="" width="90" height="90">
                <h2>Area applicativa DG11</h2>
                <p class="lead">Direzione Generale per l'istruzione, la formazione, il lavoro e le politiche giovanili</p>
            </div>
            <hr>
            <br/>
            <div class="row">
                <div class="col-lg-3 text-center"></div>
                <div class="col-lg-6 text-center">
                    <img  src="<?php echo $base_url; ?>assets/images/icon/maintenance.png" alt="" width="128" height="128">
                    <h3>Sono in corso urgenti interventi di manutenzione ti invitiamo a riprovare più tardi.</h3>
                </div><!-- /.col-lg-4 -->    
                <div class="col-lg-3 text-center"></div>
            </div>	
        </div>		




        <input type="hidden" value="<?php echo get_client_ip_env(); ?>">
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>