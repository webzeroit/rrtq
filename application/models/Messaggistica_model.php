<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe responsabile della gestione della tabella sys_message
 *
 * @author rlanz
 */
class Messaggistica_model extends CI_Model
{

    public function non_letti($user_to)
    {
        $this->db->select('id_message,subject,message,DATE_FORMAT(date, "%d/%m/%Y %H:%i:%s") AS date', FALSE);
        //$this->db->select("DATE_FORMAT(date, `%d/%m/%Y %H:%i:%s`) AS date", FALSE);
        $this->db->where('user_to', $user_to);
        $this->db->where('receiver_open', 0);
        $this->db->from('sys_messages');
        $this->db->order_by('id_message', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function datatables_in_arrivo()
    {
        $user_to = $this->ion_auth->get_user_id();

        $this->load->library('datatables');

        $this->datatables
                ->select('id_message, CONCAT(first_name, " ", last_name) as mittente, subject, message, DATE_FORMAT(date, "%d/%m/%Y %H:%i:%s") as date, receiver_open', FALSE)
                ->from('sys_messages')
                ->join('sys_users', 'sys_messages.user_from = sys_users.id')
                ->where('user_to', $user_to);

        return $this->datatables->generate();
    }

    public function in_arrivo($user_to)
    {
        $this->db->where('user_to', $user_to);
        $this->db->from('sys_messages');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function inviati($user_from)
    {
        $this->db->where('user_from', $user_from);
        $this->db->from('sys_messages');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function nuovo($user_to, $user_from, $subject, $message)
    {

        if (!is_array($user_to))
        {
            $user_to = array($user_to);
        }
        $data = array();
        foreach ($user_to as $to)
        {
            $row = array(
                'user_to' => $to,
                'user_from' => $user_from,
                'subject' => $subject,
                'message' => $message
            );

            $data[] = $row;
        }
        //return number of rows inserted or FALSE on failure
        return $this->db->insert_batch('sys_messages', $data);
    }

    public function segna_come_letto($id_message = NULL)
    {
        if ($id_message == NULL)
        {
            $user_to = $this->ion_auth->get_user_id();
            $this->db->set('receiver_open', 1);
            $this->db->where('receiver_open', 0);
            $this->db->where('user_to', $user_to);
        }
        else
        {
            $this->db->set('receiver_open', 1);
            $this->db->where('id_message', $id_message);
        }
        //TRUE on success, FALSE on failure
        return $this->db->update('sys_messages');
    }

}
