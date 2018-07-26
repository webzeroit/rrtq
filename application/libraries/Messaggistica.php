<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Message
 *
 * @author rlanz
 */
class Messaggistica
{

    public function __construct()
    {
        $this->load->library(array('email', 'ion_auth'));
        $this->load->model('messaggistica_model');
        $this->lang->load('messaggistica');
    }

    public function invia_messaggio($event, $arguments)
    {
        /* ID | NAME            | DESCRIPTION
         * ----------------------------------------
         *  1 |	admin           | Administrator
         *  2 |	responsabile	| Responsabile
         *  3 |	collaboratore	| Collaboratore
         *  4 |	supervisore	| Supervisore
         *  5 |	api             | Utente API
         * ----------------------------------------
         */
        $user_from = $this->ion_auth->user()->row();
        $nome_from = $user_from->first_name . ' ' . $user_from->last_name;
        $groupId_to = 0;

        switch ($event)
        {
            case "save_profilo":
                $groupId_to = 4;
                $oggetto = $this->lang->line('o_save_profilo');
                $messaggio = $this->lang->line('m_save_profilo');
                break;
            case "setta_revisione_profili":
                $groupId_to = 4;
                $oggetto = $this->lang->line('o_setta_revisione_profili');
                $messaggio = $this->lang->line('m_setta_revisione_profili');
                break;
            case "revisione_completa":
                $groupId_to = 4;
                $oggetto = $this->lang->line('o_revisione_completa');
                $messaggio = $this->lang->line('m_revisione_completa');
                break;
            case "approva_revisione":
                $groupId_to = array(2, 3);
                $oggetto = $this->lang->line('o_approva_revisione');
                $messaggio = $this->lang->line('m_approva_revisione');
                break;
            case "avvia_pubblicazione":
                $groupId_to = 4;
                $oggetto = $this->lang->line('o_avvia_pubblicazione');
                $messaggio = $this->lang->line('m_avvia_pubblicazione');
                break;
            case "sospendi_pubblicazione":
                $groupId_to = 4;
                $oggetto = $this->lang->line('o_sospendi_pubblicazione');
                $messaggio = $this->lang->line('m_sospendi_pubblicazione');
                break;
            case "elimina_pubblicazione":
                $groupId_to = 4;
                $oggetto = $this->lang->line('o_elimina_pubblicazione');
                $messaggio = $this->lang->line('m_elimina_pubblicazione');
                break;
        }

        $users_to = $this->ion_auth->where('active', 1)->users($groupId_to)->result();
        $ids_user_to = array();

        foreach ($users_to as $user_to)
        {
            $ids_user_to[] = $user_to->id;
        }
        //NESSUN DESTINATARIO PRESENTE
        if (count($ids_user_to) == 0)
        {
            return TRUE;
        }
        $messaggio = sprintf($messaggio, $nome_from, $arguments);
        $esito = $this->messaggistica_model->nuovo($ids_user_to, $user_from->id, $oggetto, $messaggio);

        return ($esito > 0);
    }

    public function non_letti()
    {
        $user_id = $this->ion_auth->get_user_id();
        if ($user_id !== NULL)
        {
            return $this->messaggistica_model->non_letti($user_id);
        }
        return NULL;
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @param    string $var
     *
     * @return    mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

}
