<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['sys_upload_path'] = 'files/'; //Assicurati che termini con "/"
$config['sys_upload_max_size'] = '2048';
$config['sys_allowed_types'] = 'pdf';
$config['role_responsabile'] = 'responsabile';
$config['role_supervisore'] = 'supervisore';
$config['role_utente'] = 'collaboratore';
$config['role_api'] = 'utente_api';
$config['enable_messages'] = TRUE;
$config['polling_messages'] = 60000; // default 1 minuto. Espresso in millisecondi (es. 1000 ms = 1 second)

