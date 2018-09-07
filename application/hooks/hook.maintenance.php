<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Check whether the site is offline or not.
 *
 */
class MaintenanceEnabler
{
    public function __construct(){
        log_message('debug','Accessing maintenance hook!');
    }
    
    public function offline_check(){
        if(file_exists(APPPATH.'config/app_config.php')){

            include(APPPATH.'config/app_config.php');
            
            if(!in_array($_SERVER['REMOTE_ADDR'], $config['maintenance_ips']) && $config['maintenance_mode'] === TRUE) {
                include(APPPATH.'views/manutenzione.php');
                exit;
            }
        }
    }
}