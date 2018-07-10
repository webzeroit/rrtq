<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo config_item('base_url'); ?>assets/images/favicon.png">
    <title>404 - Pagina non trovata</title>
    <!-- Bootstrap Core CSS -->
        <link href="<?php echo config_item('base_url'); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="<?php echo config_item('base_url'); ?>assets/css/style.css" rel="stylesheet">
	<!-- You can change the theme colors from here -->
	<link href="<?php echo config_item('base_url'); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>404</h1>
                <h3 class="text-uppercase">Pagina non trovata</h3>
                <p class="text-muted m-t-30 m-b-30">La pagina richiesta non è presente sul server</p>
                <a href="<?php echo config_item('base_url') ?>" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Torna alla Home</a> </div>
                <footer class="footer">© <?php echo date("Y"); ?> Piattaforma CAPIRE</footer>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
	<script src="<?php echo config_item('base_url') ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap tether Core JavaScript -->
	<script src="<?php echo config_item('base_url'); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
	<script src="<?php echo config_item('base_url'); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--Wave Effects -->
	<script src="<?php echo config_item('base_url'); ?>assets/js/waves.js"></script>	
</body>

</html>
