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
$config['lock_fad_kc'] = TRUE; // Blocca il campo % FaD KC nello standard formativo
/*
 * Versioni minime compatibili del browser per la sezione ADMIN
 * controllate in fase di login
 */
$config['Chrome'] = 40; // Versione minima CHROME 40
$config['IE'] = 11; // Versione minima IE 10
$config['Spartan'] = 16; // Versione minima Spartan 16
$config['Firefox'] = 58; // Versione minima Firefox //58

$config['maintenance_mode'] = FALSE;
$config['maintenance_ips'] = array('::1'); //localhost exception