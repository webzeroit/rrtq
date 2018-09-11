<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  edit_column callback function in Codeigniter (Ignited Datatables)
 *
 * Grabs a value from the edit_column field for the specified field so you can
 * return the desired value.  
 *
 * @access   public
 * @return   mixed
 */
if (!function_exists('dt_profilo_action'))
{

    function dt_profilo_action($id, $stato)
    {
        $ci = & get_instance();
        $action_link = '';
        if ($stato != 4)
        {
            $action_link = '<a href="qualificazione/gestione/' . $id . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
            $action_link .= '<a href="'. base_url() . 'public/stampa/sp/' . $id . '" target="_blank" data-toggle="tooltip" data-original-title="PDF Pubblico"><i class="fa fa-file-pdf-o text-inverse m-r-5"></i></a>';
        }
        //SE PUBBLICATO 
        /* GESTIONE RUOLI */
        if ($ci->ion_auth->is_admin() || $ci->ion_auth->in_group($ci->config->item('role_responsabile'))
        )
        {
            if ($stato == 0)
            {
                $action_link .= '<a href="javascript:sospendi_pubblicazione(' . $id . ');" data-toggle="tooltip" data-original-title="Sospendi Pubblicazione"><i class="fa fa-chain-broken text-inverse m-r-5"></i></a>';
            }
            // SE REVISIONE APPROVATA
            if ($stato == 1)
            {
                $action_link .= '<a href="javascript:avvia_pubblicazione(' . $id . ');" data-toggle="tooltip" data-original-title="Pubblica"><i class="fa fa-globe text-inverse m-r-5"></i></a>';
            }
            //NON PUBBLICATO
            if ($stato == 3)
            {
                $action_link .= '<a href="javascript:avvia_pubblicazione(' . $id . ');" data-toggle="tooltip" data-original-title="Pubblica"><i class="fa fa-globe text-inverse m-r-5"></i></a>';
            }
            //SE NON CANCELLATO
            if ($stato < 3)
            {
                $action_link .= '<a href="javascript:elimina_pubblicazione(' . $id . ');" data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';
            }
        }
        if ($ci->ion_auth->is_admin() || $ci->ion_auth->in_group($ci->config->item('role_supervisore')))
        {
            //SE REVISIONE LA PUO' APPROVARE
            if ($stato == 2)
            {
                $action_link .= '<a href="javascript:approva_revisione(' . $id . ');" data-toggle="tooltip" data-original-title="Approva Revisione"><i class="fa fa-check-square-o text-inverse m-r-5"></i></a>';
            }
        }
        if ($ci->ion_auth->is_admin())
        {
            if ($stato == 4)
            {
                $action_link .= '<a href="javascript:elimina_qualificazione(' . $id . ');" data-toggle="tooltip" data-original-title="Elimina Definitivamente"><i class="fa fa-trash-o text-danger m-r-5"></i></a>';
                $action_link .= '<a href="javascript:ripristina_qualificazione(' . $id . ');" data-toggle="tooltip" data-original-title="Ripristina"><i class="fa fa-undo text-inverse m-r-5"></i></a>';
            }
        }
        return $action_link;
    }

}

if (!function_exists('dt_uc_action'))
{

    function dt_uc_action($id, $profili_associati)
    {
        $ci = & get_instance();
        $action_link = '<a href="unitacompetenza/gestione/' . $id . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
        $action_link .= '<a href="'. base_url() . 'admin/unitacompetenza/stampa/' . $id . '" target="_blank" data-toggle="tooltip" data-original-title="Stampa UC"><i class="fa fa-file-pdf-o text-inverse m-r-5"></i></a>';
        
        if ($ci->ion_auth->is_admin() ||
                $ci->ion_auth->in_group($ci->config->item('role_responsabile')) ||
                $ci->ion_auth->in_group($ci->config->item('role_supervisore'))
        )
        {
            if ($profili_associati == 0)
            {
                $action_link .= '<a href="javascript:elimina_competenza(' . $id . ');"  data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';
            }
        }
        return $action_link;
    }

}

if (!function_exists('dt_abilita_action'))
{

    function dt_abilita_action($id, $competenze_associate)
    {
        $ci = & get_instance();
        $action_link = '<a href="abilita/gestione/' . $id . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';

        if ($ci->ion_auth->is_admin() ||
                $ci->ion_auth->in_group($ci->config->item('role_responsabile')) ||
                $ci->ion_auth->in_group($ci->config->item('role_supervisore'))
        )
        {
            if ($competenze_associate == 0)
            {
                $action_link .= '<a href="javascript:elimina_abilita(' . $id . ');" data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';
            }
        }
        return $action_link;
    }

}

if (!function_exists('dt_conoscenza_action'))
{

    function dt_conoscenza_action($id, $competenze_associate)
    {
        $ci = & get_instance();
        $action_link = '<a href="conoscenza/gestione/' . $id . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';

        if ($ci->ion_auth->is_admin() ||
                $ci->ion_auth->in_group($ci->config->item('role_responsabile')) ||
                $ci->ion_auth->in_group($ci->config->item('role_supervisore'))
        )
        {
            if ($competenze_associate == 0)
            {
                $action_link .= '<a href="javascript:elimina_conoscenza(' . $id . ');" data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';
            }
        }
        return $action_link;
    }

}

if (!function_exists('dt_standard_formativo_action'))
{

    function dt_standard_formativo_action($id)
    {
        $ci = & get_instance();
        $action_link = '';

        $action_link = '<a href="' . base_url() . 'admin/standardformativo/gestione/' . $id . '" data-toggle="tooltip" data-original-title="Gestione"> <i class="fa fa-edit text-inverse m-r-5"></i> </a>';
        $action_link .= '<a href="'. base_url() . 'public/stampa/sf/' . $id . '" target="_blank" data-toggle="tooltip" data-original-title="PDF Pubblico"><i class="fa fa-file-pdf-o text-inverse m-r-5"></i></a>';

        //SE PUBBLICATO 
        /* GESTIONE RUOLI */
        if ($ci->ion_auth->is_admin() ||
                $ci->ion_auth->in_group($ci->config->item('role_responsabile')) ||
                $ci->ion_auth->in_group($ci->config->item('role_supervisore')))
        {
            $action_link .= '<a href="javascript:del_standard(' . $id . ');" data-toggle="tooltip" data-original-title="Elimina"><i class="fa fa-close text-danger m-r-5"></i></a>';
        }
        return $action_link;
    }

}

/* End of file MY_datatable_helper.php */
/* Location: ./application/helpers/MY_datatable_helper.php */  